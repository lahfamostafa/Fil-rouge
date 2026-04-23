@extends('layouts.app')
@section('title', 'Manager Dashboard')

@section('content')

{{-- ============================================================
     1. STATS CARDS
============================================================ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- Total Terrains --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:shadow-slate-100 transition-all">
        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <circle cx="12" cy="11" r="3"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Terrains</p>
            <p class="text-2xl font-black text-slate-800 leading-tight">{{ $terrains->count() }}</p>
        </div>
    </div>

    {{-- Total Reservations --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:shadow-slate-100 transition-all">
        <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Réservations</p>
            <p class="text-2xl font-black text-slate-800 leading-tight">
                {{ $terrains->sum(fn($t) => $t->reservations->count()) }}
            </p>
        </div>
    </div>

    {{-- Pending --}}
    <div class="bg-white rounded-2xl border border-amber-100 p-5 flex items-center gap-4 hover:shadow-md hover:shadow-amber-50 transition-all">
        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide">En attente</p>
            <p class="text-2xl font-black text-slate-800 leading-tight">
                {{ $terrains->sum(fn($t) => $t->reservations->where('status', 'pending')->count()) }}
            </p>
        </div>
    </div>

    {{-- Revenue --}}
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md hover:shadow-green-200 transition-all">
        <div class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-green-100 uppercase tracking-wide">Revenus</p>
            <p class="text-2xl font-black text-white leading-tight">
                {{ number_format($terrains->sum(fn($t) => $t->reservations->where('status', 'confirmed')->sum('total_price')), 0) }}
                <span class="text-sm font-semibold text-green-100">DH</span>
            </p>
        </div>
    </div>

</div>

{{-- ============================================================
     2. TERRAINS SECTION
============================================================ --}}
<div class="mb-8">

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-base font-bold text-slate-800">Mes Terrains</h2>
            <p class="text-xs text-slate-400 mt-0.5">Gérez vos terrains sportifs</p>
        </div>
        <a href="/terrains"
           class="text-sm text-green-600 hover:text-green-800 font-semibold flex items-center gap-1 transition-colors">
            Voir tout
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @forelse($terrains as $terrain)
    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-3 flex items-center gap-4 hover:shadow-md hover:shadow-slate-100 transition-all group">

        {{-- Terrain image / icon --}}
        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0">
            @if($terrain->image)
                <img src="{{ asset('storage/'.$terrain->image) }}" alt="{{ $terrain->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Terrain info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
                <h3 class="font-bold text-slate-800 truncate">{{ $terrain->name }}</h3>
                @if($terrain->is_active ?? true)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold border border-green-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Actif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-50 text-slate-400 text-xs font-semibold border border-slate-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Inactif
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-4 mt-1 flex-wrap">
                <span class="flex items-center gap-1 text-xs text-slate-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                    {{ $terrain->location }}
                </span>
                <span class="flex items-center gap-1 text-xs font-bold text-green-600">
                    {{ $terrain->price }} DH/h
                </span>
                <span class="flex items-center gap-1 text-xs text-slate-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $terrain->reservations->count() }} réservation(s)
                </span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-2 shrink-0">
            <a href="/terrains/{{ $terrain->id }}/edit"
               class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors"
               title="Modifier">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            <form action="/terrains/{{ $terrain->id }}" method="POST" class="inline"
                  onsubmit="return confirm('Supprimer ce terrain ?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 transition-colors"
                    title="Supprimer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>

    @empty
    <div class="bg-white rounded-2xl border-2 border-dashed border-slate-200 p-10 text-center">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <circle cx="12" cy="11" r="3"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-600 mb-1">Aucun terrain</h3>
        <p class="text-slate-400 text-sm mb-4">Ajoutez votre premier terrain pour commencer</p>
        <a href="/terrains"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un terrain
        </a>
    </div>
    @endforelse

</div>

{{-- ============================================================
     3. RESERVATIONS SECTION
============================================================ --}}
<div>

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-base font-bold text-slate-800">Réservations récentes</h2>
            <p class="text-xs text-slate-400 mt-0.5">Gérez et suivez les demandes</p>
        </div>
        <a href="/mes-reservations"
           class="text-sm text-green-600 hover:text-green-800 font-semibold flex items-center gap-1 transition-colors">
            Voir tout
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Pending highlight banner --}}
    @php
        $pendingCount = $terrains->sum(fn($t) => $t->reservations->where('status', 'pending')->count());
    @endphp
    @if($pendingCount > 0)
    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-4">
        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-amber-700">
            {{ $pendingCount }} réservation{{ $pendingCount > 1 ? 's' : '' }} en attente de confirmation
        </p>
    </div>
    @endif

    {{-- Table (desktop) / Cards (mobile) --}}
    @php
        $allReservations = $terrains->flatMap(fn($t) => $t->reservations)->sortByDesc('created_at');
    @endphp

    @if($allReservations->count() > 0)

    {{-- Desktop table --}}
    <div class="hidden md:block bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Client</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Terrain</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Date</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Créneau</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Prix</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Statut</th>
                    <th class="text-left px-4 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($allReservations as $res)
                <tr class="hover:bg-slate-50/50 transition-colors {{ $res->status === 'pending' ? 'bg-amber-50/30' : '' }}">

                    {{-- Client --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-xs font-bold text-slate-600 shrink-0">
                                {{ strtoupper(substr($res->user->name, 0, 2)) }}
                            </div>
                            <span class="font-medium text-slate-700">{{ $res->user->name }}</span>
                        </div>
                    </td>

                    {{-- Terrain --}}
                    <td class="px-4 py-3.5">
                        <span class="text-slate-600 font-medium">{{ $res->terrain->name }}</span>
                    </td>

                    {{-- Date --}}
                    <td class="px-4 py-3.5 text-slate-500">
                        {{ \Carbon\Carbon::parse($res->date)->format('d/m/Y') }}
                    </td>

                    {{-- Time --}}
                    <td class="px-4 py-3.5">
                        <span class="inline-flex items-center gap-1 text-slate-600 font-medium text-xs bg-slate-100 px-2 py-1 rounded-lg">
                            {{ substr($res->start_time, 11, 5) }}
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            {{ substr($res->end_time, 11, 5) }}
                        </span>
                    </td>

                    {{-- Price --}}
                    <td class="px-4 py-3.5 font-bold text-green-600">
                        {{ $res->total_price }} DH
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3.5">
                        <span class="w-24 inline-flex justify-center items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold
                            {{ $res->status === 'pending'   ? 'bg-amber-50  text-amber-700  border border-amber-200'  : '' }}
                            {{ $res->status === 'confirmed' ? 'bg-green-50  text-green-700  border border-green-200'  : '' }}
                            {{ $res->status === 'cancelled' ? 'bg-red-50    text-red-600    border border-red-200'    : '' }}
                        ">
                            @if($res->status === 'pending')
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> En attente
                            @elseif($res->status === 'confirmed')
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Confirmé
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Annulé
                            @endif
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-2">
                            @if($res->status === 'pending')
                                <form action="/manager/reservations/{{ $res->id }}/confirm" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 hover:border-green-600 text-xs font-semibold rounded-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Confirmer
                                    </button>
                                </form>
                                <form action="/manager/reservations/{{ $res->id }}/cancel" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 text-xs font-semibold rounded-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Annuler
                                    </button>
                                </form>
                            @else
                                <button disabled class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 text-slate-300 border border-slate-100 text-xs font-semibold rounded-lg cursor-not-allowed">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Confirmer
                                </button>
                                <button disabled class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 text-slate-300 border border-slate-100 text-xs font-semibold rounded-lg cursor-not-allowed">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Annuler
                                </button>
                            @endif
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="md:hidden space-y-3">
        @foreach($allReservations as $res)
        <div class="bg-white rounded-2xl border p-4 transition-all
            {{ $res->status === 'pending' ? 'border-amber-200 bg-amber-50/30' : 'border-slate-100 hover:shadow-md hover:shadow-slate-100' }}">

            {{-- Header --}}
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-xs font-bold text-slate-600 shrink-0">
                        {{ strtoupper(substr($res->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $res->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $res->terrain->name }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold
                    {{ $res->status === 'pending'   ? 'bg-amber-50  text-amber-700  border border-amber-200'  : '' }}
                    {{ $res->status === 'confirmed' ? 'bg-green-50  text-green-700  border border-green-200'  : '' }}
                    {{ $res->status === 'cancelled' ? 'bg-red-50    text-red-600    border border-red-200'    : '' }}
                ">
                    @if($res->status === 'pending')
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> En attente
                    @elseif($res->status === 'confirmed')
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Confirmé
                    @else
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Annulé
                    @endif
                </span>
            </div>

            {{-- Details --}}
            <div class="flex items-center gap-4 mb-3 text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($res->date)->format('d/m/Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                    </svg>
                    {{ substr($res->start_time, 11, 5) }} → {{ substr($res->end_time, 11, 5) }}
                </span>
                <span class="font-bold text-green-600 ml-auto">{{ $res->total_price }} DH</span>
            </div>

            {{-- Actions --}}
            @if($res->status === 'pending')
            <div class="flex gap-2 pt-3 border-t border-slate-100">
                <form action="/manager/reservations/{{ $res->id }}/confirm" method="POST" class="flex-1">
                    @csrf @method('PATCH')
                    <button class="w-full py-2 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 hover:border-green-600 text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Confirmer
                    </button>
                </form>
                <form action="/manager/reservations/{{ $res->id }}/cancel" method="POST" class="flex-1">
                    @csrf @method('PATCH')
                    <button class="w-full py-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </button>
                </form>
            </div>
            @endif

        </div>
        @endforeach
    </div>

    @else
    {{-- Empty state --}}
    <div class="bg-white rounded-2xl border-2 border-dashed border-slate-200 p-10 text-center">
        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-600 mb-1">Aucune réservation</h3>
        <p class="text-slate-400 text-sm">Les réservations de vos terrains apparaîtront ici</p>
    </div>
    @endif

</div>

@endsection