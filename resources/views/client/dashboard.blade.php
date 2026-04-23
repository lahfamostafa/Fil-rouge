@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Welcome banner --}}
<div class="relative bg-gradient-to-br from-green-500 to-emerald-700 rounded-2xl p-6 mb-6 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg viewBox="0 0 200 200" class="absolute -right-10 -top-10 w-56 h-56 text-white" fill="currentColor">
            <circle cx="100" cy="100" r="80" fill="none" stroke="white" stroke-width="2"/>
            <line x1="20" y1="100" x2="180" y2="100" stroke="white" stroke-width="2"/>
            <line x1="100" y1="20" x2="100" y2="180" stroke="white" stroke-width="2"/>
            <ellipse cx="100" cy="100" rx="40" ry="80" fill="none" stroke="white" stroke-width="2"/>
        </svg>
    </div>
    <div class="relative">
        <p class="text-green-100 text-sm font-medium mb-1">Bonjour 👋</p>
        <h2 class="text-2xl font-bold text-white mb-1">{{ auth()->user()->name }}</h2>
        <p class="text-green-100 text-sm">Prêt à réserver un terrain aujourd'hui ?</p>
    </div>
</div>

{{-- Quick action cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <a href="/terrains"
       class="group bg-white rounded-2xl p-5 border border-slate-100 hover:border-green-200 hover:shadow-lg hover:shadow-green-50 transition-all duration-200">
        <div class="w-11 h-11 rounded-xl bg-green-50 group-hover:bg-green-100 flex items-center justify-center mb-4 transition-colors">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <circle cx="12" cy="11" r="3"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-1">Réserver un terrain</h3>
        <p class="text-slate-400 text-sm">Parcourir et choisir</p>
        <div class="mt-4 flex items-center text-green-600 text-sm font-medium">
            Explorer <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </div>
    </a>

    <a href="/mes-reservations"
       class="group bg-white rounded-2xl p-5 border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-50 transition-all duration-200">
        <div class="w-11 h-11 rounded-xl bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mb-4 transition-colors">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-1">Mes réservations</h3>
        <p class="text-slate-400 text-sm">Historique et à venir</p>
        <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
            Voir tout <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </div>
    </a>

    <a href="/announcements"
       class="group bg-white rounded-2xl p-5 border border-slate-100 hover:border-amber-200 hover:shadow-lg hover:shadow-amber-50 transition-all duration-200">
        <div class="w-11 h-11 rounded-xl bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center mb-4 transition-colors">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-1">Annonces</h3>
        <p class="text-slate-400 text-sm">Trouver des joueurs</p>
        <div class="mt-4 flex items-center text-amber-600 text-sm font-medium">
            Découvrir <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </div>
    </a>

</div>

@endsection