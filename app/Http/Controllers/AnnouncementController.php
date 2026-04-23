<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Matche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::with(
            'match.reservation.terrain',
            'match.creator',
            'match.participants',
            'comments.user')
                ->latest()
                ->paginate(15);
        return view('announcements.index',compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($matchId)
    {
        $match = Matche::findOrFail($matchId);

        if($match->creator_id != Auth::id()){
            abort(403);
        }

        return view('announcements.create',compact('match'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string'
        ]);

        Announcement::create([
            'match_id' => $request->match_id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return redirect('/announcements')->with('success','Annonce crée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
