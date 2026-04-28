<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\MatchParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchParticipantController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchParticipant $matchParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchParticipant $matchParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatchParticipant $matchParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchParticipant $matchParticipant)
    {
        //
    }

    public function join($matchId)
    {
        $match = Matche::findOrFail($matchId);

        $current = MatchParticipant::where('match_id', $matchId)
            ->where('status', 'accepted')
            ->count();

        if ($match->status == 'full') {
            return back()->with('error', 'Match complet');
        }

        if ($match->creator_id == Auth::id()) {
            return back()->with('error', 'Impossible');
        }

        $exists = MatchParticipant::where('match_id', $matchId)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Déjà demandé');
        }

        MatchParticipant::create([
            'match_id' => $matchId,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Demande envoyée');
    }

    public function requests(Matche $match)
    {
        if ($match->creator_id !== Auth::id()) {
            abort(403, 'Only the match creator can view requests.');
        }

        $match->load(['reservation.terrain', 'creator']);

        $pending = $match->participants()
            ->with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $accepted = $match->participants()
            ->with('user')
            ->where('status', 'accepted')
            ->get();

        return view('matches.requests', compact('match', 'pending', 'accepted'));
    }

    public function accept($id)
    {
        $p = MatchParticipant::findOrFail($id);

        if ($p->match->creator_id != Auth::id()) {
            abort(403);
        }

        $acceptedCount = $p->match->participants()
            ->where('status', 'accepted')
            ->count();

        if ($acceptedCount >= $p->match->max_players) {
            return back()->with('error', 'Match déjà complet');
        }

        $p->update(['status' => 'accepted']);

        $acceptedCount = $p->match->participants()
            ->where('status', 'accepted')
            ->count();

        if ($acceptedCount >= $p->match->max_players)
            $p->match->update(['status' => 'full']);

        return back();
    }

    public function reject($id)
    {
        $p = MatchParticipant::findOrFail($id);

        $acceptedCount = $p->match->participants()
            ->where('status', 'accepted')
            ->count();

        if ($acceptedCount < $p->match->max_players) {
            $p->match->update(['status' => 'open']);
        }

        if ($p->match->creator_id != Auth::id()) {
            abort(403);
        }

        $p->update(['status' => 'rejected']);

        return back();
    }
}
