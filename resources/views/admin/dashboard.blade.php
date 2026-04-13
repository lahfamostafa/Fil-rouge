@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

<div class="grid grid-cols-4 gap-6">

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Utilisateurs</p>
        <h3 class="text-2xl font-bold">120</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Terrains</p>
        <h3 class="text-2xl font-bold">15</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Réservations</p>
        <h3 class="text-2xl font-bold">340</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Revenus</p>
        <h3 class="text-2xl font-bold">45 000 DH</h3>
    </div>

</div>

@endsection