{{-- resources/views/matches/announcements/create.blade.php --}}
@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('announcements.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all duration-150 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">New Announcement</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Match #{{ $match->id }}
                    &middot;
                    {{ $match->reservation->terrain->name ?? 'Match' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 space-y-5">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
                    <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Please fix the following</p>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-2 text-sm text-red-600">
                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 012 0v4a1 1 0 01-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Posting a public announcement</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Public
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-5 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-[10px] font-bold uppercase tracking-widest mb-1">Linked Match</p>
                        <p class="text-white font-extrabold text-base leading-tight">
                            {{ $match->reservation->terrain->name ?? 'Match #' . $match->id }}
                        </p>
                        @if(!empty($match->reservation->terrain->location))
                            <p class="text-emerald-100 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $match->reservation->terrain->location }}
                            </p>
                        @endif
                    </div>
                    {{-- Status badge --}}
                    @php
                        $statusStyle = [
                            'open'   => 'bg-white/20 text-white border-white/30',
                            'full'   => 'bg-white/20 text-white border-white/30',
                            'closed' => 'bg-white/20 text-white border-white/30',
                        ][$match->status] ?? 'bg-white/20 text-white border-white/30';
                        $dotStyle = [
                            'open'   => 'bg-green-300 animate-pulse',
                            'full'   => 'bg-yellow-300',
                            'closed' => 'bg-slate-300',
                        ][$match->status] ?? 'bg-slate-300';
                    @endphp
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold border px-3 py-1.5 rounded-full {{ $statusStyle }} shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotStyle }}"></span>
                        {{ ucfirst($match->status) }}
                    </span>
                </div>

                <div class="px-5 py-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    {{-- Match ID --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Match ID</p>
                        <p class="text-sm font-bold text-slate-700">#{{ $match->id }}</p>
                    </div>
                    {{-- Date --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Date</p>
                        <p class="text-sm font-bold text-slate-700">
                            {{ \Carbon\Carbon::parse($match->reservation->date ?? now())->format('M j, Y') }}
                        </p>
                    </div>
                    {{-- Time --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Time</p>
                        <p class="text-sm font-bold text-slate-700">
                            {{ substr($match->reservation->start_time ?? '', 11, 5) }}
                            –
                            {{ substr($match->reservation->end_time ?? '', 11, 5) }}
                        </p>
                    </div>
                    {{-- Players --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Players</p>
                        <p class="text-sm font-bold text-slate-700">
                            {{ $match->participants->where('status', 'accepted')->count() }}
                            /
                            {{ $match->max_players }}
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('announcements.store') }}" method="POST" id="announcementForm">
                @csrf

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                    <div class="p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm shrink-0 mt-0.5">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="hidden" name="match_id" value="{{ $match->id }}">
                                <textarea
                                    name="content"
                                    id="content"
                                    rows="6"
                                    maxlength="1000"
                                    required
                                    placeholder="Write your announcement... What should players know about this match?"
                                    class="w-full bg-transparent border-none resize-none outline-none text-sm text-slate-700 placeholder-slate-300 leading-relaxed focus:ring-0 p-0"
                                    oninput="updateCount(this)"
                                >{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('announcements.index') }}"
                           class="flex-1 text-center text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 py-3 px-5 rounded-xl transition-all duration-150">
                            Cancel
                        </a>
                        <button type="submit"
                                class="flex-[2] flex items-center justify-center gap-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] py-3 px-5 rounded-xl transition-all duration-150 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Publish Announcement
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <script>
        function updateCount(el) {
            const counter = document.getElementById('charCount');
            const len = el.value.length;
            counter.textContent = `${len} / 1000`;
            counter.classList.toggle('text-red-500', len > 900);
            counter.classList.toggle('text-slate-400', len <= 900);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('content');
            if (el && el.value) updateCount(el);
        });
    </script>

@endsection