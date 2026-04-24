@extends('layouts.app')
@section('title', 'Terrains')

@section('content')

{{-- ══ VALIDATION ERRORS ══════════════════════════════════ --}}
@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
            </svg>
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- ══ PAGE HEADER ════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Terrains</h2>
        <p class="text-sm text-slate-400 mt-0.5">{{ count($terrains) }} terrain{{ count($terrains) > 1 ? 's' : '' }} disponible{{ count($terrains) > 1 ? 's' : '' }}</p>
    </div>
</div>

{{-- ══ MANAGER: ADD TERRAIN ═══════════════════════════════ --}}
@if(auth()->user()->role === 'manager')
    <div x-data="{ open: false }" class="mb-8">

        {{-- Trigger button --}}
        <button @click="open = !open"
                class="inline-flex items-center gap-2 border-2 border-dashed border-slate-200 hover:border-emerald-400 bg-white hover:bg-emerald-50/50 text-slate-400 hover:text-emerald-600 rounded-2xl px-5 py-3.5 text-sm font-semibold transition-all duration-150 group">
            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-emerald-100 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            Nouveau terrain
        </button>

        {{-- Slide-down form panel --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mt-4 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Ajouter un terrain</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Remplissez les informations ci-dessous</p>
                </div>
                <button @click="open = false" class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="/terrains" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Nom --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nom</label>
                        <input type="text" name="name" placeholder="Ex: Terrain Central"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Localisation --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Localisation</label>
                        <input type="text" name="location" placeholder="Ex: Casablanca, Maarif"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Latitude --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Latitude</label>
                        <input type="number" step="any" name="latitude" placeholder="33.5731"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Longitude --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Longitude</label>
                        <input type="number" step="any" name="longitude" placeholder="-7.5898"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Prix --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Prix / heure (DH)</label>
                        <div class="relative">
                            <input type="number" name="price" placeholder="100"
                                   class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">DH</span>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Image</label>
                        <input type="file" name="image"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500
                                      file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
                                      file:bg-emerald-50 file:text-emerald-700 file:font-semibold file:text-xs
                                      hover:file:bg-emerald-100 transition-all cursor-pointer">
                    </div>

                    {{-- Ouverture --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Ouverture</label>
                        <input type="time" name="opening_time"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Fermeture --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Fermeture</label>
                        <input type="time" name="closing_time"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all">
                    </div>

                    {{-- Actions --}}
                    <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-semibold rounded-xl transition-all duration-150 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer
                        </button>
                        <button type="button" @click="open = false"
                                class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition-all duration-150">
                            Annuler
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endif

{{-- ══ TERRAIN GRID ════════════════════════════════════════ --}}
@if(count($terrains) > 0)

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @foreach($terrains as $terrain)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group flex flex-col">

                {{-- Image --}}
                <div class="relative h-44 bg-slate-100 overflow-hidden shrink-0">
                    @if($terrain->image)
                        <img src="{{ asset('storage/' . $terrain->image) }}"
                             alt="{{ $terrain->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Price badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-white/95 backdrop-blur-sm text-xs font-extrabold text-emerald-700 shadow-sm border border-emerald-100">
                            {{ $terrain->price }} <span class="font-bold text-emerald-500">DH/h</span>
                        </span>
                    </div>

                    {{-- Manager actions overlay --}}
                    @if(auth()->user()->role === 'manager')
                        <div class="absolute top-3 left-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <a href="/terrains/{{ $terrain->id }}/edit"
                               class="w-7 h-7 bg-white/95 backdrop-blur-sm rounded-lg flex items-center justify-center text-slate-600 hover:text-blue-600 hover:bg-blue-50 shadow-sm transition-all border border-slate-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                </svg>
                            </a>
                            <form action="/terrains/{{ $terrain->id }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce terrain ?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-7 h-7 bg-white/95 backdrop-blur-sm rounded-lg flex items-center justify-center text-slate-600 hover:text-red-600 hover:bg-red-50 shadow-sm transition-all border border-slate-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-slate-800 text-sm mb-1 truncate">{{ $terrain->name }}</h3>

                    <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-3">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <circle cx="12" cy="11" r="3"/>
                        </svg>
                        <span class="truncate">{{ $terrain->location }}</span>
                    </div>

                    <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">

                        {{-- Hours --}}
                        <div class="flex items-center gap-1.5 text-xs text-slate-400">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                            </svg>
                            {{ substr($terrain->opening_time, 0, 5) }} – {{ substr($terrain->closing_time, 0, 5) }}
                        </div>

                        {{-- Reserve button (client only) --}}
                        @if(auth()->user()->role !== 'manager')
                            <a href="/reservations/create/{{ $terrain->id }}"
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl transition-all duration-150 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Réserver
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach
    </div>

{{-- ══ EMPTY STATE ════════════════════════════════════════ --}}
@else
    <div class="flex flex-col items-center justify-center py-24 text-center bg-white rounded-2xl border border-slate-100 shadow-sm mb-8">
        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <circle cx="12" cy="11" r="3"/>
            </svg>
        </div>
        <h3 class="font-bold text-slate-700 mb-1">Aucun terrain disponible</h3>
        <p class="text-sm text-slate-400">Les terrains ajoutés apparaîtront ici.</p>
    </div>
@endif

{{-- ══ MAP ═════════════════════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-slate-800">Carte des terrains</p>
            <p class="text-xs text-slate-400">{{ count($terrains) }} terrain{{ count($terrains) > 1 ? 's' : '' }} sur la carte</p>
        </div>
    </div>
    <div id="map" class="w-full h-80"></div>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([33.5731, -7.5898], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const terrains = @json($terrains);

    terrains.forEach(t => {
        if (t.latitude && t.longitude) {
            L.marker([t.latitude, t.longitude])
                .addTo(map)
                .bindPopup(`
                    <div style="font-family:sans-serif;font-size:13px;min-width:160px">
                        <p style="font-weight:800;color:#059669;margin-bottom:4px">${t.name}</p>
                        <p style="color:#64748b;margin-bottom:2px">📍 ${t.location}</p>
                        <p style="color:#64748b;margin-bottom:2px">💰 ${t.price} DH / heure</p>
                        <p style="color:#64748b;margin-bottom:8px">🕒 ${t.opening_time?.slice(0,5)} – ${t.closing_time?.slice(0,5)}</p>
                        <a href="/reservations/create/${t.id}"
                           style="display:inline-block;background:#059669;color:white;padding:5px 12px;border-radius:8px;text-decoration:none;font-weight:700;font-size:12px">
                            Réserver
                        </a>
                    </div>
                `);
        }
    });
</script>

@endsection