<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TerrainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reservations/create/{terrain}', [ReservationController::class, 'create']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

    Route::get('/terrains', [TerrainController::class, 'index']);
    Route::get('/mes-reservations', [ReservationController::class, 'myReservations']);

    Route::patch('/manager/reservations/{id}/confirm', [ManagerController::class, 'confirm']);
    Route::patch('/manager/reservations/{id}/cancel', [ManagerController::class, 'cancel']);

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth')
        ->name('dashboard');
});

require __DIR__.'/auth.php';
