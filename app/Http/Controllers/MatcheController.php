<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\MatchParticipant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = Matche::with('participants')
            // ->where('status', 'open')
            ->paginate(12);
        // $matches = Matche::

        return view('matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($reservationId)
    {
        $reservation = Reservation::with('terrain')->findOrFail($reservationId);

        // sécurité
        if ($reservation->user_id != Auth::id()) {
            abort(403);
        }

        if ($reservation->status != 'confirmed') {
            abort(403);
        }

        return view('matches.create', compact('reservation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'max_players' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        // sécurité
        if ($reservation->user_id != Auth::id()) {
            abort(403);
        }

        Matche::create([
            'reservation_id' => $reservation->id,
            'creator_id' => Auth::id(),
            'max_players' => $request->max_players,
            'description' => $request->description,
            'status' => 'open'
        ]);

        return redirect('/matches')->with('success', 'Match créé');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $match = Matche::with([
            'reservation.terrain',
            'creator',
            'participants.user'
        ])->findOrFail($id);

        $user = Auth::user();

        // واش هاد المستخدم هو creator
        $isCreator = $user->id == $match->creator_id;

        // المشاركة ديال user فهاد match
        $participation = null;

        if (!$isCreator) {
            $participation = MatchParticipant::where('match_id', $match->id)
                ->where('user_id', $user->id)
                ->first();
        }

        // عدد اللاعبين المقبولين
        $acceptedCount = MatchParticipant::where('match_id', $match->id)
            ->where('status', 'accepted')
            ->count();

        return view('matches.show', compact(
            'match',
            'isCreator',
            'participation',
            'acceptedCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matche $matche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matche $matche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matche $matche)
    {
        //
    }
}
