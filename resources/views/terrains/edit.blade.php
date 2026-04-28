@extends('layouts.app')
@section('title', 'Modifier le terrain')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">

        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Modifier le terrain</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Modifiez les informations de votre terrain</p>
                </div>
            </div>
            @if($terrain->is_active)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold border border-green-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Actif
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-50 text-slate-400 text-xs font-semibold border border-slate-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Inactif
                </span>
            @endif
        </div>

        @if ($errors->any())
        <div class="mx-5 mt-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ $error }}
                </p>
            @endforeach
        </div>
        @endif

        <form action="/terrains/{{ $terrain->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-5 space-y-5">

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 pb-2 border-b border-slate-100">
                        Informations générales
                    </p>
                    <div class="space-y-3">

                        {{-- Name --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nom du terrain</label>
                            <input type="text" name="name" value="{{ old('name', $terrain->name) }}"
                                placeholder="Ex : Terrain Casablanca Centre"
                                class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Localisation</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <circle cx="12" cy="11" r="3"/>
                                </svg>
                                <input type="text" name="location" value="{{ old('location', $terrain->location) }}"
                                    placeholder="Ex : Casablanca, Maarif"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl pl-9 pr-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                            </div>
                        </div>

                        {{-- Lat / Lng --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Latitude</label>
                                <input type="text" name="latitude" value="{{ old('latitude', $terrain->latitude) }}"
                                    placeholder="33.5731"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Longitude</label>
                                <input type="text" name="longitude" value="{{ old('longitude', $terrain->longitude) }}"
                                    placeholder="-7.5898"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 pb-2 border-b border-slate-100">
                        Tarif &amp; horaires
                    </p>
                    <div class="space-y-3">

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Prix par heure</label>
                            <div class="relative">
                                <input type="number" name="price" value="{{ old('price', $terrain->price) }}"
                                    placeholder="120"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 pr-14 text-sm text-slate-800 outline-none transition-all">
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-green-600 pointer-events-none">DH/h</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Ouverture</label>
                                <input type="time" name="opening_time" value="{{ old('opening_time', $terrain->opening_time) }}"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Fermeture</label>
                                <input type="time" name="closing_time" value="{{ old('closing_time', $terrain->closing_time) }}"
                                    class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all">
                            </div>
                        </div>

                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 pb-2 border-b border-slate-100">
                        Statut &amp; image
                    </p>
                    <div class="space-y-3">

                        {{-- Status --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Statut</label>
                            <select name="is_active"
                                class="w-full border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all bg-white">
                                <option value="1" {{ $terrain->is_active ? 'selected' : '' }}>Actif</option>
                                <option value="0" {{ !$terrain->is_active ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>

                        {{-- Image upload --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Image du terrain</label>
                            <label class="flex flex-col items-center gap-2 border-2 border-dashed border-slate-200 hover:border-green-400 rounded-xl p-5 cursor-pointer transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-slate-500 text-center">
                                    Cliquez pour changer l'image<br>
                                    <span class="text-slate-400">PNG, JPG jusqu'à 2MB</span>
                                </p>
                                <input type="file" name="image" accept="image/*" class="hidden">
                            </label>

                            @if($terrain->image)
                            <div class="flex items-center gap-3 mt-2.5 p-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <img src="{{ asset('storage/' . $terrain->image) }}"
                                    alt="{{ $terrain->name }}"
                                    class="w-10 h-10 rounded-lg object-cover shrink-0">
                                <div>
                                    <p class="text-xs font-semibold text-slate-700">Image actuelle</p>
                                    <p class="text-xs text-slate-400">Téléversez une nouvelle pour la remplacer</p>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <div class="flex items-center gap-3 px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                <a href="/terrains"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-500 hover:bg-white hover:border-slate-300 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-green-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>

</div>

@endsection