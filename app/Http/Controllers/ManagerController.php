<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function dashboard()
    {
        $manager = Auth::user();

        $terrains = $manager->terrains()->with('reservations')->get() ;

        return view('manager.dashboard', compact('terrains'));
    }

    public function confirm($id)
    {
        $res = Reservation::where('id', $id)
            ->whereHas('terrain', function ($q) {
                $q->where('manager_id', Auth::id());
            })
            ->firstOrFail();

        $res->status = 'confirmed';
        $res->save();

        return back();
    }

    public function cancel($id)
    {
        $res = Reservation::where('id', $id)
            ->whereHas('terrain', function ($q) {
                $q->where('manager_id', Auth::id());
            })
            ->firstOrFail();

        $res->status = 'cancelled';
        $res->save();

        return back();
    }
}
