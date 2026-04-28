@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('matches.show', $match) }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight tracking-tight">
                    Join Requests
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $match->reservation->terrain->name ?? 'Match' }} &middot;
                    {{ \Carbon\Carbon::parse($match->reservation->date)->format('M j, Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-500">{{ $pending->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pending</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $accepted->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Accepted</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ $match->max_players }}</p>
                    <p class="text-xs text-gray-400 mt-1">Max Players</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Pending Requests</h3>
                    @if($pending->isNotEmpty())
                        <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">
                            {{ $pending->count() }} waiting
                        </span>
                    @endif
                </div>

                @if($pending->isEmpty())
                    <div class="px-6 py-10 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gray-100 mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 font-medium">No pending requests</p>
                        <p class="text-xs text-gray-400 mt-1">All requests have been reviewed.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-50">
                        @foreach($pending as $participant)
                            <li class="px-6 py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-700 font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($participant->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $participant->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $participant->user->email ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-shrink-0">
                                    {{-- Accept --}}
                                    <form action="{{ route('matches.participants.accept', $participant->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 active:scale-95 text-white text-xs font-semibold px-3.5 py-2 rounded-lg transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Accept
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <form action="{{ route('matches.participants.reject', $participant->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 active:scale-95 text-red-600 border border-red-200 text-xs font-semibold px-3.5 py-2 rounded-lg transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Accepted Players --}}
            @if($accepted->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-800">Accepted Players</h3>
                        <span class="text-xs font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                            {{ $accepted->count() }} / {{ $match->max_players }}
                        </span>
                    </div>
                    <ul class="divide-y divide-gray-50">
                        @foreach($accepted as $participant)
                            <li class="px-6 py-3.5 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($participant->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-700 truncate">{{ $participant->user->name ?? 'Unknown' }}</p>
                                </div>
                                <span class="text-xs font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">✓ Accepted</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
@endsection