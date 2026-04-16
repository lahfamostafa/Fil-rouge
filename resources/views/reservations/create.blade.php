@extends('layouts.app')
@section('title', 'Réserver — ' . $terrain->name)

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Terrain info card --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-5">
        <div class="relative h-36 bg-slate-100">
            <img src="{{ $terrain->image ?? 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&h=200&fit=crop' }}"
                 class="w-full h-full object-cover" alt="{{ $terrain->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-4 left-4">
                <h2 class="text-lg font-bold text-white">{{ $terrain->name }}</h2>
                <p class="text-white/80 text-sm flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                    {{ $terrain->location }}
                </p>
            </div>
            <div class="absolute top-3 right-3">
                <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm rounded-lg text-xs font-bold text-green-700">
                    {{ $terrain->price }} DH/h
                </span>
            </div>
        </div>
    </div>

    {{-- Date picker --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-5">
        <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
            <span class="w-6 h-6 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
            Choisir une date
        </h3>
        <form method="GET" class="flex gap-3 items-end">
            <div class="flex-1">
                <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-slate-700">
            </div>
            <button type="submit"
                class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-green-200 whitespace-nowrap">
                Voir les créneaux
            </button>
        </form>
    </div>

    {{-- Slots --}}
    @if($date)
    <form action="/reservations" method="POST" id="reservationForm">
        @csrf
        <input type="hidden" name="terrain_id" value="{{ $terrain->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="start_time" id="start_time">
        <input type="hidden" name="end_time" id="end_time">

        <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-1 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                </span>
                Créneaux disponibles
                <span class="ml-auto text-xs text-slate-400 font-normal">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
            </h3>

            {{-- Legend --}}
            <div class="flex items-center gap-4 mb-4 mt-3 pb-3 border-b border-slate-50">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="w-3 h-3 rounded bg-green-500"></span> Disponible
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="w-3 h-3 rounded bg-red-400"></span> Réservé
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="w-3 h-3 rounded bg-slate-300"></span> Passé
                </div>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                @foreach($slots as $slot)
                @php
                    $isBooked = !in_array($slot, $availableSlots, true);
                    $isPast = ($date == date('Y-m-d') && $slot <= $currentTime);
                    $endTime = date('H:i', strtotime($slot . ' +1 hour'));
                @endphp

                <button type="button"
                    onclick="selectSlot('{{ $slot }}')"
                    id="slot-{{ str_replace(':', '', $slot) }}"
                    class="slot-btn relative px-3 py-3 rounded-xl text-xs font-semibold text-center border-2 transition-all
                        @if($isBooked || $isPast)
                            bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed
                        @else
                            bg-green-50 border-green-200 text-green-700 hover:bg-green-500 hover:border-green-500 hover:text-white cursor-pointer
                        @endif
                    "
                    {{ ($isBooked || $isPast) ? 'disabled' : '' }}>
                    <span class="block">{{ $slot }}</span>
                    <span class="block text-[10px] opacity-70 font-normal mt-0.5">→ {{ $endTime }}</span>
                    @if($isBooked)
                        <span class="absolute top-1 right-1 w-1.5 h-1.5 rounded-full bg-red-400"></span>
                    @endif
                </button>
                @endforeach
            </div>
        </div>

        {{-- Summary + submit --}}
        <div id="summaryPanel" class="hidden bg-white rounded-2xl border border-green-200 p-5 mb-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Créneau sélectionné</p>
                    <p class="text-lg font-bold text-slate-800" id="summaryText">—</p>
                    <p class="text-sm text-green-600 font-semibold mt-1">{{ $terrain->price }} DH</p>
                </div>
                <button type="submit"
                    class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-xl transition-colors shadow-md shadow-green-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Confirmer
                </button>
            </div>
        </div>

    </form>
    @endif

</div>

<script>
let selectedSlot = null;

function selectSlot(slot) {
    // Reset previous
    if (selectedSlot) {
        const prev = document.getElementById('slot-' + selectedSlot.replace(':', ''));
        if (prev) {
            prev.classList.remove('!bg-green-600', '!border-green-600', '!text-white', 'ring-2', 'ring-green-400', 'ring-offset-2');
            prev.classList.add('bg-green-50', 'border-green-200', 'text-green-700');
        }
    }

    selectedSlot = slot;
    const btn = document.getElementById('slot-' + slot.replace(':', ''));
    if (btn) {
        btn.classList.add('!bg-green-600', '!border-green-600', '!text-white', 'ring-2', 'ring-green-400', 'ring-offset-2');
        btn.classList.remove('bg-green-50', 'border-green-200', 'text-green-700');
    }

    let [h, m] = slot.split(':');
    let endHour = parseInt(h) + 1;
    let endTime = (endHour < 10 ? '0' + endHour : endHour) + ':00';

    document.getElementById('start_time').value = slot;
    document.getElementById('end_time').value = endTime;

    const panel = document.getElementById('summaryPanel');
    const text = document.getElementById('summaryText');
    panel.classList.remove('hidden');
    text.textContent = slot + ' → ' + endTime;
}
</script>

@endsection