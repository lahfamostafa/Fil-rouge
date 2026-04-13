@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Choisir un terrain</h2>

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
                📍 {{ $terrain->adress }}
            </p>

            <p class="text-green-600 font-bold mt-2">
                {{ $terrain->price }} DH / heure
            </p>

            <div class="mt-4 flex justify-between items-center">

                <span class="text-sm text-gray-400">
                    {{ $terrain->opening_time }} - {{ $terrain->closing_time }}
                </span>

                <a href="/reservations/create/{{ $terrain->id }}"
                   class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                    Réserver
                </a>

            </div>

        </div>

    </div>

@endforeach

</div>

@endsection