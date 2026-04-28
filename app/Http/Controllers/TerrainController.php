<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'manager') {
            $terrains = Terrain::where('manager_id', $user->id)->get();
        } else {
            $terrains = Terrain::where('is_active', true)->get();
        }

        return view('terrains.index', compact('terrains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('terrains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'manager') {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'price' => 'required|numeric',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('terrains', 'public');
        }

        $terrain = new Terrain();

        $terrain->name = $request->name;
        $terrain->location = $request->location;
        $terrain->latitude = $request->latitude;
        $terrain->longitude = $request->longitude;
        $terrain->price = $request->price;
        $terrain->opening_time = $request->opening_time;
        $terrain->closing_time = $request->closing_time;
        $terrain->image = $imagePath;
        $terrain->manager_id = Auth::id(); 

        $terrain->save();

        return back()->with('success', 'Terrain ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Terrain $terrain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $terrain = Terrain::findOrFail($id);

        if ($terrain->manager_id != auth()->id()) {
            abort(403);
        }

        return view('terrains.edit', compact('terrain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $terrain = Terrain::findOrFail($id);

        // security
        if ($terrain->manager_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'opening_time' => 'required',
            'closing_time' => 'required|after:opening_time',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $imagePath = $terrain->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('terrains', 'public');
        }

        $terrain->update([
            'name' => $request->name,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price' => $request->price,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'image' => $imagePath,
            'is_active' => $request->is_active,
        ]);

        return redirect('/manager/dashboard')->with('success', 'Terrain modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $terrain = Terrain::where('id', $id)
            ->where('manager_id', Auth::id())
            ->firstOrFail();

        $terrain->delete();

        return back()->with('success', 'Terrain supprimé');
    }
}
