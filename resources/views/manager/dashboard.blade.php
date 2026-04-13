@extends('layouts.app')

@section('content')
@if(isset($terrains))

<h2 class="text-2xl font-bold mb-6">Mes Terrains</h2>

@forelse($terrains as $terrain)

<div class="mb-8 bg-white p-5 rounded-xl shadow">

    <h3 class="text-xl font-semibold mb-4">
        {{ $terrain->name }} ({{ $terrain->location }})
    </h3>

    <table class="w-full text-left">

        <thead>
            <tr class="border-b">
                <th>Client</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($terrain->reservations as $res)

        <tr class="border-b">

            <td>{{ $res->user->name }}</td>

            <td>{{ $res->date }}</td>

            <td>
                {{ substr($res->start_time,0,5) }}
                →
                {{ substr($res->end_time,0,5) }}
            </td>

            <td>{{ $res->total_price }} DH</td>

            <td>
                <span class="
                    px-2 py-1 rounded text-white text-sm
                    {{ $res->status == 'pending' ? 'bg-yellow-500' : '' }}
                    {{ $res->status == 'confirmed' ? 'bg-green-500' : '' }}
                    {{ $res->status == 'cancelled' ? 'bg-red-500' : '' }}
                ">
                    {{ $res->status }}
                </span>
            </td>

            <td class="space-x-2">

                <!-- Confirm -->
                <form action="/manager/reservations/{{ $res->id }}/confirm" method="POST" class="inline">
                    @csrf
                    @method('PATCH')

                    <button class="bg-green-500 text-white px-2 py-1 rounded">
                        ✔
                    </button>
                </form>

                <!-- Cancel -->
                <form action="/manager/reservations/{{ $res->id }}/cancel" method="POST" class="inline">
                    @csrf
                    @method('PATCH')

                    <button class="bg-red-500 text-white px-2 py-1 rounded">
                        ✖
                    </button>
                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="6">Aucune réservation</td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>
@empty

    <div class="text-center py-10">
        <h2 class="text-lg font-semibold">Aucun terrain</h2>
        <p class="text-gray-500 mb-4">Ajoutez votre premier terrain</p>

        <a href="/terrains/create"
           class="bg-blue-500 text-white px-4 py-2 rounded">
           + Ajouter un terrain
        </a>
    </div>

@endforelse

@endif

@endsection