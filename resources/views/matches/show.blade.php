{{-- resources/views/matches/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('matches.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 leading-tight tracking-tight">
                Match Details
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 012 0v4a1 1 0 01-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left Column: Main Info --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Match Header Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-5 flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-xs font-medium uppercase tracking-wider">Terrain</p>
                                <h3 class="text-white text-xl font-bold mt-0.5">
                                    {{ $match->reservation->terrain->name ?? 'N/A' }}
                                </h3>
                            </div>
                            {{-- Status Badge --}}
                            @php
                                $statusConfig = [
                                    'open'   => ['bg-white/20 text-white', 'bg-green-200', 'Open'],
                                    'full'   => ['bg-white/20 text-white', 'bg-yellow-300', 'Full'],
                                    'closed' => ['bg-white/20 text-white', 'bg-gray-300',   'Closed'],
                                ];
                                [$badgeClass, $dotClass, $label] = $statusConfig[$match->status] ?? $statusConfig['open'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 {{ $badgeClass }} text-sm font-bold px-3 py-1.5 rounded-full border border-white/30">
                                <span class="w-2 h-2 rounded-full {{ $dotClass }}"></span>
                                {{ $label }}
                            </span>
                        </div>

                        <div class="p-6 space-y-4">
                            {{-- Date / Time --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-1">Date</p>
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($match->reservation->date)->format('D, M j Y') }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-1">Time</p>
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ substr($match->reservation->start_time, 11, 5) ?? '--' }} – {{ substr($match->reservation->end_time, 11, 5) ?? '--' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Players --}}
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-500">Accepted Players</span>
                                    <span class="font-bold {{ $acceptedCount >= $match->max_players ? 'text-red-500' : 'text-green-600' }}">
                                        {{ $acceptedCount }} / {{ $match->max_players }}
                                    </span>
                                </div>
                                @php
                                    $pct = $match->max_players > 0 ? min(100, round(($acceptedCount / $match->max_players) * 100)) : 0;
                                    $barColor = $pct >= 100 ? 'bg-red-400' : ($pct >= 75 ? 'bg-yellow-400' : 'bg-green-500');
                                @endphp
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>

                            {{-- Description --}}
                            @if($match->description)
                                <div class="border-t border-gray-100 pt-4">
                                    <p class="text-xs text-gray-400 mb-1.5">Description</p>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $match->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Participants List --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h4 class="font-semibold text-gray-800">Participants</h4>
                            <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full">
                                {{ $match->participants->count() }} total
                            </span>
                        </div>

                        @if($match->participants->isEmpty())
                            <div class="px-6 py-8 text-center text-gray-400 text-sm">
                                No participants yet. Be the first to join!
                            </div>
                        @else
                            <ul class="divide-y divide-gray-50">
                                @foreach($match->participants as $participant)
                                    <li class="px-6 py-3.5 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($participant->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $participant->user->name ?? 'Unknown' }}</span>
                                        </div>
                                        @php
                                            $sc = [
                                                'accepted' => 'bg-green-100 text-green-700',
                                                'pending'  => 'bg-yellow-100 text-yellow-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                            ][$participant->status] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="text-xs font-semibold {{ $sc }} px-2.5 py-1 rounded-full capitalize">
                                            {{ $participant->status }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>

                {{-- Right Column: Actions & Creator --}}
                <div class="space-y-6">

                    @if(auth()->id() === $match->creator_id)
    <a href="{{ route('announcements.create', $match) }}"
       class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
        + creer annonce
    </a>
@endif

                    {{-- Creator Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-3">Created by</p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($match->creator->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $match->creator->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-400">{{ $match->creator->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Actions</p>

                        @if($isCreator)
                            {{-- Creator: View Requests --}}
                            <a href="{{ route('matches.requests', $match) }}"
                               class="flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-3 px-4 rounded-xl transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                View Join Requests
                            </a>
                            <div class="text-center text-xs text-gray-400 bg-blue-50 rounded-lg py-2 px-3">
                                You are the creator of this match
                            </div>

                        @elseif($participation)
                            {{-- Already applied --}}
                            @php
                                $statusConfig = [
                                    'pending'  => ['bg-yellow-50 border-yellow-200 text-yellow-800', '⏳ Your request is pending'],
                                    'accepted' => ['bg-green-50 border-green-200 text-green-800',  '✅ You are accepted!'],
                                    'rejected' => ['bg-red-50 border-red-200 text-red-800',         '❌ Your request was rejected'],
                                ][$participation->status] ?? ['bg-gray-50 border-gray-200 text-gray-700', 'Status unknown'];
                            @endphp
                            <div class="border {{ $statusConfig[0] }} text-sm font-semibold text-center py-3 px-4 rounded-xl">
                                {{ $statusConfig[1] }}
                            </div>

                        @elseif($match->status === 'open')
                            {{-- Can join --}}
                            <form action="{{ route('matches.join', $match) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 active:scale-95 text-white text-sm font-semibold py-3 px-4 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Request to Join
                                </button>
                            </form>

                        @elseif($match->status === 'full')
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm font-semibold text-center py-3 px-4 rounded-xl">
                                🏟️ Match is Full
                            </div>

                        @else
                            <div class="bg-gray-50 border border-gray-200 text-gray-500 text-sm font-semibold text-center py-3 px-4 rounded-xl">
                                Match Closed
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection