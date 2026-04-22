{{-- resources/views/matches/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 leading-tight tracking-tight">
                ⚽ Open Matches
            </h2>
            <span class="text-sm text-gray-500">{{ $matches->total() }} match{{ $matches->total() !== 1 ? 'es' : '' }}
                available</span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 012 0v4a1 1 0 01-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Match Grid --}}
            @if ($matches->isEmpty())
                <div class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                        <span class="text-4xl">⚽</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No open matches right now</h3>
                    <p class="text-gray-400 text-sm">Check back later or create one from your reservations.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($matches as $match)
                        @php
                            $acceptedCount = $match->participants->where('status', 'accepted')->count();
                            $isFull = $match->status === 'full';
                            $isMine = $match->creator_id === auth()->id();
                            $hasJoined = $match->participants->where('user_id', auth()->id())->isNotEmpty();
                            $status = $match->user_status ?? null;
                        @endphp

                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col overflow-hidden">

                            {{-- Card Header --}}
                            <div
                                class="bg-gradient-to-r from-green-500 to-emerald-600 px-5 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-white font-semibold text-sm truncate max-w-[160px]">
                                        {{ $match->reservation->terrain->name ?? 'Unknown Terrain' }}
                                    </span>
                                </div>

                                {{-- Status Badge --}}
                                @if ($match->status === 'open')
                                    <span
                                        class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-200 animate-pulse"></span> Open
                                    </span>
                                @elseif($match->status === 'full')
                                    <span
                                        class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-300"></span> Full
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Closed
                                    </span>
                                @endif
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 flex flex-col flex-1 gap-4">

                                {{-- Creator --}}
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($match->creator->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Created by</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ $match->creator->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>

                                {{-- Match Date & Time --}}
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($match->reservation->date ?? now())->format('D, M j') }}
                                    &middot;
                                    {{ substr($match->reservation->start_time, 11, 5) ?? '--:--' }}
                                </div>

                                {{-- Players Progress --}}
                                <div>
                                    <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                                        <span>Players</span>
                                        <span
                                            class="font-semibold {{ $acceptedCount >= $match->max_players ? 'text-red-500' : 'text-green-600' }}">
                                            {{ $acceptedCount }} / {{ $match->max_players }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        @php
                                            $pct =
                                                $match->max_players > 0
                                                    ? min(100, round(($acceptedCount / $match->max_players) * 100))
                                                    : 0;
                                            $barColor =
                                                $pct >= 100
                                                    ? 'bg-red-400'
                                                    : ($pct >= 75
                                                        ? 'bg-yellow-400'
                                                        : 'bg-green-500');
                                        @endphp
                                        <div class="h-2 rounded-full {{ $barColor }} transition-all duration-500"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-2 mt-auto pt-2">

                                    <a href="{{ route('matches.show', $match) }}"
                                        class="flex-1 text-center text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-2 rounded-lg transition">
                                        View
                                    </a>

                                    {{-- Creator --}}
                                    @if ($isMine)
                                        <span
                                            class="flex-1 text-center text-sm font-semibold text-blue-500 bg-blue-50 border border-blue-200 px-3 py-2 rounded-lg">
                                            Your Match
                                        </span>

                                        {{-- Accepted --}}
                                    @elseif($status === 'accepted')
                                        <span
                                            class="flex-1 text-center text-sm font-semibold text-green-400 bg-gray-50 border border-green-200 px-3 py-2 rounded-lg">
                                            Joined
                                        </span>

                                        {{-- Pending --}}
                                    @elseif($status === 'pending')
                                        <span
                                            class="flex-1 text-center text-sm font-semibold text-yellow-500 bg-yellow-50 border border-yellow-200 px-3 py-2 rounded-lg">
                                            Pending
                                        </span>

                                        {{-- Rejected --}}
                                    @elseif($status === 'rejected')
                                        <span
                                            class="flex-1 text-center text-sm font-semibold text-red-400 bg-red-50 border border-red-200 px-3 py-2 rounded-lg">
                                            Rejected
                                        </span>

                                        {{-- Full --}}
                                    @elseif($isFull)
                                        <span
                                            class="flex-1 text-center text-sm font-semibold text-red-400 bg-red-50 border border-red-200 px-3 py-2 rounded-lg">
                                            Full
                                        </span>

                                        {{-- Default: Join --}}
                                    @else
                                        <form action="{{ route('matches.join', $match) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-sm font-semibold text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg transition">
                                                Join
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $matches->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
