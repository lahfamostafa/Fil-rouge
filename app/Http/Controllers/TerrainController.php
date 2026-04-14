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
        //
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
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
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
        $terrain->manager_id = Auth::id(); // هنا آمنة

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
    public function edit(Terrain $terrain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terrain $terrain)
    {
        //
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
