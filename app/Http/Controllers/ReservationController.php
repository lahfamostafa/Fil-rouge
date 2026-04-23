<?php

namespace App\Http\Controllers;

use App\Mail\ReservationStatusMail;
use App\Models\Reservation;
use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if (!$terrain->is_active) {
            abort(403);
        }

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

                $slotTime = strtotime($slot);

                $isBooked = $booked->contains(function ($res) use ($slotTime) {

                    $resStart = strtotime($res->start_time);
                    $resEnd = strtotime($res->end_time);

                    return $slotTime >= $resStart && $slotTime < $resEnd;
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

        if (!$terrain->is_active) {
            return back()->with('error', 'Terrain non disponble');
        }

        $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

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

        $reservation = new Reservation();

        $reservation->user_id = Auth::id();
        $reservation->terrain_id = $terrain->id;
        $reservation->date = $request->date;
        $reservation->start_time = $start_time;
        $reservation->end_time = $end_time;
        $reservation->total_price = $total;
        $reservation->status = 'pending';

        $reservation->save();

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

        $now = now();

        if ($request->filter == 'past') {
            $query->where(function ($q) use ($now) {
                $q->where('date', '<', $now->toDateString())
                    ->orWhere(function ($q2) use ($now) {
                        $q2->where('date', $now->toDateString())
                            ->where('end_time', '<', $now->format('H:i:s'));
                    });
            });
        }

        if ($request->filter == 'today') {
            $query->where('date', $now->toDateString());
        }

        if ($request->filter == 'upcoming') {
            $query->where(function ($q) use ($now) {
                $q->where('date', '>', $now->toDateString())
                    ->orWhere(function ($q2) use ($now) {
                        $q2->where('date', $now->toDateString())
                            ->where('start_time', '>', $now->format('H:i:s'));
                    });
            });
        }

        $reservations = $query->orderBy('date', 'desc')->get();

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
        // dd($reservation->match->exists());
        if ($reservation->match) {
            $CountAccepted = $reservation->match->participants->where('status', 'accepted')->count();
            if ($CountAccepted > 0) {
                return back()->with('error', 'Impossible d’annuler, des joueurs sont déjà acceptés');
            }
        }
        $reservation->status = 'cancelled'; 
        $reservation->save();

        Mail::to($reservation->user->email)->send(new ReservationStatusMail($reservation,'cancelled'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Réservation annulée');
    }
}
