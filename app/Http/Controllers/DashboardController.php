<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

public function index()
{
    $user = Auth::user();

    if ($user->role == 'admin') {
        return view('admin.dashboard');
    }

    if ($user->role == 'manager') {
        return app(\App\Http\Controllers\ManagerController::class)->dashboard();
    }

    return view('client.dashboard');
}
}
