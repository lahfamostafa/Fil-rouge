@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Choisir un terrain</h2>
@if ($errors->any())
    <div class="bg-red-100 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(auth()->user()->role == 'manager')

    <form action="/terrains" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
        @csrf
        <input type="text" name="name" placeholder="Nom" class="border p-2 w-full mb-2">
        <input type="text" name="location" placeholder="Localisation" class="border p-2 w-full mb-2">
        <input type="number" step="any" name="latitude" placeholder="Latitude" class="border p-2 w-full mb-2">
        <input type="number" step="any" name="longitude" placeholder="Longitude" class="border p-2 w-full mb-2">
        <input type="number" name="price" placeholder="Prix" class="border p-2 w-full mb-2">
        <input type="time" name="opening_time" class="border p-2 w-full mb-2">
        <input type="time" name="closing_time" class="border p-2 w-full mb-2">
        <input type="file" name="image" class="border p-2 w-full mb-2">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Ajouter
        </button>
    </form>

@endif

<div class="grid grid-cols-3 gap-6">

@foreach($terrains as $terrain)

    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

        <!-- Image -->
        <img src="{{ $terrain->image ?? 'https://via.placeholder.com/400x200' }}"
             class="w-full h-40 object-cover">

        <!-- Content -->
        <div class="p-4">

            <h3 class="text-lg font-semibold">{{ $terrain->name }}</h3>

            <p class="text-gray-500 text-sm">
                📍 {{ $terrain->location }}
            </p>

            <p class="text-green-600 font-bold mt-2">
                {{ $terrain->price }} DH / heure
            </p>

            <div class="mt-4 flex justify-between items-center">

                <span class="text-sm text-gray-400">
                    {{ $terrain->opening_time }} - {{ $terrain->closing_time }}
                </span>

                @if(auth()->user()->role != 'manager')

                    <a href="/reservations/create/{{ $terrain->id }}"
                    class="inline-block mt-3 bg-green-500 text-white px-3 py-1 rounded">
                        Réserver
                    </a>

                @endif

            </div>

        </div>

    </div>

@endforeach

</div>

@endsection