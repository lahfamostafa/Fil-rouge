@extends('layouts.app')
@section('title', 'Terrains')


@section('content')

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700 text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Manager: create form --}}
@if(auth()->user()->role == 'manager')
<div x-data="{ open: false }" class="mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- Add terrain card trigger --}}
        <button @click="open = !open"
            class="border-2 border-dashed border-slate-200 hover:border-green-400 rounded-2xl p-6 flex flex-col items-center justify-center gap-2 text-slate-400 hover:text-green-600 transition-all group">
            <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-green-50 flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            </div>
            <span class="text-sm font-semibold">Nouveau terrain</span>
        </button>

    </div>

    {{-- Form panel --}}
    <div x-show="open" x-transition class="mt-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-base font-semibold text-slate-800 mb-4">Ajouter un terrain</h3>
        <form action="/terrains" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nom</label>
                <input type="text" name="name" placeholder="Ex: Terrain Central" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Localisation</label>
                <input type="text" name="location" placeholder="Ex: Casablanca, Maarif" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Latitude</label>
                <input type="number" step="any" name="latitude" placeholder="33.5731" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Longitude</label>
                <input type="number" step="any" name="longitude" placeholder="-7.5898" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Prix / heure (DH)</label>
                <input type="number" name="price" placeholder="100" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Image</label>
                <input type="file" name="image" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:font-medium file:text-xs hover:file:bg-green-100 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Ouverture</label>
                <input type="time" name="opening_time" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Fermeture</label>
                <input type="time" name="closing_time" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div class="sm:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-green-200">
                    Enregistrer
                </button>
                <button type="button" @click="open = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Terrain grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($terrains as $terrain)
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:shadow-slate-100 transition-all duration-200 group">

        {{-- Image --}}
        <div class="relative overflow-hidden h-44 bg-slate-100">
            <img src="{{ asset('storage/'.$terrain->image) }}"
                 alt="{{ $terrain->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute top-3 right-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-xs font-bold text-green-700 shadow-sm">
                    {{ $terrain->price }} DH/h
                </span>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-4">
            <h3 class="font-bold text-slate-800 mb-1">{{ $terrain->name }}</h3>
            <div class="flex items-center gap-1.5 text-slate-400 text-sm mb-3">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                {{ $terrain->location }}
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                <div class="flex items-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                    {{ substr($terrain->opening_time, 11, 5) }} – {{ substr($terrain->closing_time, 11, 5) }}
                </div>

                @if(auth()->user()->role != 'manager')
                <a href="/reservations/create/{{ $terrain->id }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm shadow-green-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Réserver
                </a>
                @endif
            </div>
        </div>

    </div>
    @endforeach
</div>

@if(count($terrains) == 0)
<div class="flex flex-col items-center justify-center py-20 text-center">
    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
    </div>
    <h3 class="font-semibold text-slate-700 mb-1">Aucun terrain disponible</h3>
    <p class="text-slate-400 text-sm">Les terrains ajoutés apparaîtront ici</p>
</div>
@endif

@endsection