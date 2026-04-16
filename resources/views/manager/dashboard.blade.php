@extends('layouts.app')
@section('title', 'Mes Réservations')

@section('content')

{{-- Filter tabs --}}
<div class="flex items-center gap-2 mb-6 overflow-x-auto pb-1">
    @php
        $filters = ['all' => 'Toutes', 'today' => 'Aujourd\'hui', 'upcoming' => 'À venir', 'past' => 'Passées'];
        $current = request('filter', 'all');
        $colors = ['all' => 'slate', 'today' => 'blue', 'upcoming' => 'green', 'past' => 'slate'];
    @endphp
    @foreach($filters as $key => $label)
    <a href="/mes-reservations?filter={{ $key }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition-all
           {{ $current == $key
               ? 'bg-green-600 text-white shadow-sm shadow-green-200'
               : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300 hover:text-slate-800'
           }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Reservations list --}}
<div class="space-y-3">
    @forelse($reservations as $res)
    <div class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md hover:shadow-slate-100 transition-all">
        <div class="flex items-center gap-4">

            {{-- Date block --}}
            <div class="w-14 shrink-0 text-center bg-slate-50 rounded-xl py-2.5 border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::parse($res->date)->format('M') }}</p>
                <p class="text-2xl font-black text-slate-800 leading-tight">{{ \Carbon\Carbon::parse($res->date)->format('d') }}</p>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-slate-800 truncate">{{ $res->terrain->name }}</h3>
                <div class="flex items-center gap-3 mt-1">
                    <span class="flex items-center gap-1 text-xs text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        {{ substr($res->start_time, 0, 5) }} → {{ substr($res->end_time, 0, 5) }}
                    </span>
                    <span class="text-xs font-bold text-green-600">{{ $res->total_price }} DH</span>
                </div>
            </div>

            {{-- Status + cancel --}}
            <div class="flex items-end gap-2 shrink-0">
                <div class="flex flex-col items-end gap-2 shrink-0">
                    @if($res->status === 'pending')
                    <form action="/manager/reservations/{{ $res->id }}/confirm" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="text-xs text-green-500 hover:text-green-700 font-medium transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" /></svg>
                            ✓ Confirmer
                        </button>
                    </form>
                    <form action="/manager/reservations/{{ $res->id }}/cancel" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Annuler
                        </button>
                    </form>
                    @endif
                </div>
                <span class="px-3 py-1 rounded-lg text-xs font-bold text-center
                    {{ $res->status == 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                    {{ $res->status == 'confirmed' ? ' w-24 bg-green-50 text-green-700 border border-green-200' : '' }}
                    {{ $res->status == 'cancelled' ? ' w-24 bg-red-50 text-red-600 border border-red-200' : '' }}
                ">
                    {{ $res->status == 'pending' ? '⏳ En attente' : '' }}
                    {{ $res->status == 'confirmed' ? '✓ Confirmé' : '' }}
                    {{ $res->status == 'cancelled' ? '✕ Annulé' : '' }}
                </span>

            </div>

        </div>
    </div>
    @empty
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-700 mb-1">Aucune réservation</h3>
        <p class="text-slate-400 text-sm mb-4">Vous n'avez pas encore de réservations</p>
        <a href="/terrains" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors">
            Réserver maintenant
        </a>
    </div>
    @endforelse
</div>

@endsection