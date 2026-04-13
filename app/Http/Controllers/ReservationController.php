<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($terrain, Request $request)
    {
        $terrain = Terrain::findOrFail($terrain);

        $date = $request->date;

        $currentTime = now()->format('H:i');

        $slots = [];
        $booked = [];
        $availableSlots = [];

        if ($date) {

            $start = strtotime($terrain->opening_time);
            $end = strtotime($terrain->closing_time);

            for ($time = $start; $time < $end; $time += 3600) {
                $slots[] = date('H:i', $time);
            }

            $booked = Reservation::where('terrain_id', $terrain->id)
                ->where('date', $date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->get();

            foreach ($slots as $slot) {

                $isBooked = $booked->contains(function ($res) use ($slot) {
                    return substr($res->start_time, 0, 5) == $slot;
                });

                if (!$isBooked) {
                    $availableSlots[] = $slot;
                }
            }
        }

        return view('reservations.create', compact(
            'terrain',
            'date',
            'currentTime',
            'slots',
            'booked',
            'availableSlots'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $terrain = Terrain::findOrFail($request->terrain_id);

        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $start_time = date('H:i:s', strtotime($start_time));
        $end_time = date('H:i:s', strtotime($end_time));

        $hours = (strtotime($end_time) - strtotime($start_time)) / 3600;
        $total = $hours * $terrain->price;

        $exists = Reservation::where('terrain_id', $terrain->id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'confirmed']) 
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                    ->where('end_time', '>', $start_time);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ce créneau est déjà réservé');
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        Reservation::create([
            'user_id' => Auth::id(),
            'terrain_id' => $terrain->id,
            'date' => $request->date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_price' => $total,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Réservation réussie');
    }

    public function myReservations(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'manager') {

            $query = Reservation::with('terrain')
                ->whereHas('terrain', function ($q) use ($user) {
                    $q->where('manager_id', $user->id);
                });

        } else {

            $query = Reservation::with('terrain')
                ->where('user_id', $user->id);
        }

        // 🔍 filters
        if ($request->filter == 'past') {
            $query->where('date', '<', now()->toDateString());
        }

        if ($request->filter == 'today') {
            $query->where('date', now()->toDateString());
        }

        if ($request->filter == 'upcoming') {
            $query->where('date', '>', now()->toDateString());
        }

        $reservations = $query->orderBy('date', 'desc')->get();

        if($user->role == 'manager') return view('reservations.my', compact('reservations'));
        return view('reservations.my', compact('reservations'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->delete();

        return back()->with('success', 'Réservation annulée');
    }
}
