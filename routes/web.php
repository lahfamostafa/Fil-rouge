<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\MatchParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TerrainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
    Route::patch('/reservations/{reservation}', [ReservationController::class, 'update']);
    Route::get('/mes-reservations', [ReservationController::class, 'myReservations']);

    Route::get('/terrains', [TerrainController::class, 'index']);

    Route::patch('/matches/participants/{id}/accept', [MatchParticipantController::class, 'accept'])->name('matches.participants.accept');
    Route::patch('/matches/participants/{id}/reject', [MatchParticipantController::class, 'reject'])->name('matches.participants.reject');


    Route::middleware('role:client')->group(function () {

        Route::get('/matches/{id}', [MatcheController::class, 'show'])->name('matches.show');

        Route::post('/matches/{match}/join', [MatchParticipantController::class, 'join'])
            ->name('matches.join');

        Route::get('/matches', [MatcheController::class, 'index'])->name('matches.index');
        Route::get('/matches/create/{reservation}', [MatcheController::class, 'create'])->name('matche.create');
        Route::post('/matches', [MatcheController::class, 'store'])->name('matches.store');

        Route::get('/reservations/create/{terrain}', [ReservationController::class, 'create']);
        Route::post('/reservations', [ReservationController::class, 'store']);

        Route::get('/matches/{match}/requests', [MatchParticipantController::class, 'requests'])->name('matches.requests');

        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('announcements.index');

        Route::get('/announcements/create/{match}', [AnnouncementController::class, 'create'])
            ->name('announcements.create');

        Route::post('/announcements', [AnnouncementController::class, 'store'])
            ->name('announcements.store');
    });

    Route::middleware('role:manager')->group(function () {

        Route::delete('/terrains/{id}', [TerrainController::class, 'destroy']);
        Route::get('/terrains/create', [TerrainController::class, 'create']);

        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard']);

        Route::patch('/manager/reservations/{id}/confirm', [ManagerController::class, 'confirm']);
        Route::patch('/manager/reservations/{id}/cancel', [ManagerController::class, 'cancel']);

        Route::post('/terrains', [TerrainController::class, 'store']);
        Route::get('/terrains/{id}/edit', [TerrainController::class, 'edit']);
        Route::put('/terrains/{id}', [TerrainController::class, 'update']);
    });
});

require __DIR__ . '/auth.php';
