@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Bienvenue </h2>

<div class="grid grid-cols-3 gap-6">

    <a href="/terrains" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">Réserver un terrain</h3>
        <p class="text-gray-500 mt-2">Choisir et réserver</p>
    </a>

    <a href="/mes-reservations" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">Mes réservations</h3>
        <p class="text-gray-500 mt-2">Voir vos réservations</p>
    </a>

    <a href="#" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">Annonces</h3>
        <p class="text-gray-500 mt-2">Trouver des joueurs</p>
    </a>

</div>

@endsection