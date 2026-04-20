{{-- resources/views/matches/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url('/mes-reservations') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 leading-tight tracking-tight">
                Create a Match
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Reservation Summary Card --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 mb-8 text-white shadow-md">
                <p class="text-sm text-green-100 font-medium uppercase tracking-wider mb-3">Reservation Details</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-green-200">Terrain</p>
                        <p class="font-bold text-lg">{{ $reservation->terrain->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-green-200">Date</p>
                        <p class="font-bold text-lg">
                            {{ \Carbon\Carbon::parse($reservation->date)->format('D, M j Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-green-200">Start Time</p>
                        <p class="font-bold text-lg">{{ substr($reservation->start_time, 11, 5) ?? '--:--' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-green-200">End Time</p>
                        <p class="font-bold text-lg">{{ substr($reservation->end_time, 11, 5) ?? '--:--' }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">Match Settings</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Fill in the details for your match</p>
                </div>

                <form action="{{ route('matches.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                    {{-- Max Players --}}
                    <div>
                        <label for="max_players" class="block text-sm font-semibold text-gray-700 mb-2">
                            Joueurs necessaire <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input
                                type="number"
                                name="max_players"
                                id="max_players"
                                min="1"
                                max="50"
                                value="{{ old('max_players', 1) }}"
                                class="w-full pl-10 pr-4 py-3 border @error('max_players') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                                placeholder="e.g. 10"
                            >
                        </div>
                        @error('max_players')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            maxlength="500"
                            class="w-full px-4 py-3 border @error('description') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none"
                            placeholder="Any rules, level requirements, or notes for players..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-400 text-right" id="char-count">0 / 500</p>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-green-600 hover:bg-green-700 active:scale-95 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-150 shadow-sm hover:shadow-md text-sm">
                            ⚽ Create Match
                        </button>
                        <a href="{{ url('/mes-reservations') }}"
                           class="flex-1 text-center text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 py-3 px-6 rounded-xl transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const textarea = document.getElementById('description');
        const counter  = document.getElementById('char-count');
        if (textarea && counter) {
            const update = () => counter.textContent = `${textarea.value.length} / 500`;
            update();
            textarea.addEventListener('input', update);
        }
    </script>
@endsection