@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Mes Réservations</h2>

<div class="grid gap-4">
    <div class="mb-4 space-x-2">

        <a href="/mes-reservations?filter=all" class="px-3 py-1 bg-gray-200 rounded">All</a>
        <a href="/mes-reservations?filter=today" class="px-3 py-1 bg-blue-200 rounded">Today</a>
        <a href="/mes-reservations?filter=upcoming" class="px-3 py-1 bg-green-200 rounded">Upcoming</a>
        <a href="/mes-reservations?filter=past" class="px-3 py-1 bg-red-200 rounded">Past</a>

    </div>

    @foreach($reservations as $res)

    <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">

        <div>
            <h3 class="font-semibold">
                {{ $res->terrain->name }}
            </h3>

            <p class="text-gray-500">
                📅 {{ $res->date }}
            </p>

            <p class="text-gray-500">
                🕒 {{ substr($res->start_time,0,5) }} → {{ substr($res->end_time,0,5) }}
            </p>
        </div>

        <div class="text-right">

            <p class="font-bold text-green-600">
                {{ $res->total_price }} DH
            </p>

            <span class="
                px-3 py-1 rounded text-white text-sm
                {{ $res->status == 'pending' ? 'bg-yellow-500' : '' }}
                {{ $res->status == 'confirmed' ? 'bg-green-500' : '' }}
                {{ $res->status == 'cancelled' ? 'bg-red-500' : '' }}
            ">
                {{ $res->status }}
            </span>
            
        </div>
        <form action="/reservations/{{ $res->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="bg-red-500 text-white px-3 py-1 rounded">
                Annuler
            </button>
        </form>

    </div>

@endforeach

</div>

@endsection