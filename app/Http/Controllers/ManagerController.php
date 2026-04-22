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
        $terrains = $manager->terrains()->with('reservations')->get();
        $reservations = Reservation::whereHas('terrain', function ($q) use ($manager) {
            $q->where('manager_id', $manager->id);
        })->get();
        return view('manager.dashboard', compact('terrains', 'reservations'));
    }

    public function confirm($id)
    {
        $reservation = Reservation::where('id', $id)
            ->whereHas('terrain', function ($q) {
                $q->where('manager_id', auth()->id());
            })
            ->firstOrFail();

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Action non autorisée');
        }

        $reservation->status = 'confirmed';
        $reservation->save();

        return back();
    }

    public function cancel($id)
    {
        $res = Reservation::where('id', $id)
            ->whereHas('terrain', function ($q) {
                $q->where('manager_id', Auth::id());
            })
            ->with('match.participants')
            ->firstOrFail();

        if ($res->status !== 'pending') {
            return back()->with('error', 'Action non autorisée');
        }
        $res->status = 'cancelled';
        $res->save();

        return back();
    }
}
