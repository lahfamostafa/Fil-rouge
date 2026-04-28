{{-- resources/views/matches/announcements/index.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 space-y-5">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">Match Announcements</h2>
                <p class="text-sm text-slate-400 mt-0.5">Find and join matches near you</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-full shadow-sm">
                    {{ $announcements->total() ?? count($announcements) }} posts
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm font-medium shadow-sm">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-sm font-medium shadow-sm">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 012 0v4a1 1 0 01-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if($announcements->isEmpty())
            <div class="text-center py-24 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-5">
                    <svg class="w-9 h-9 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-700 mb-1.5">No matches announced yet</h3>
                <p class="text-sm text-slate-400 max-w-xs mx-auto mb-5">Be the first to create a match and invite players to join.</p>
                <a href="{{ url('/matches') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create First Post
                </a>
            </div>

        @else

        @foreach($announcements as $annonce)
            @php
                $match         = $annonce->match;
                $reservation   = $match->reservation;
                $terrain       = $reservation->terrain ?? null;
                $creator       = $match->creator;
                $acceptedCount = $match->participants->where('status', 'accepted')->count();
                $pct           = $match->max_players > 0
                                    ? min(100, round(($acceptedCount / $match->max_players) * 100))
                                    : 0;
                $isCreator     = auth()->id() === $match->creator_id;
                $participation = $match->participants->firstWhere('user_id', auth()->id());
                $pendingCount  = $match->participants->where('status', 'pending')->count();

                $statusMap = [
                    'open'   => ['dot' => 'bg-emerald-400 animate-pulse', 'pill' => 'bg-emerald-100 text-emerald-700', 'label' => 'Open'],
                    'full'   => ['dot' => 'bg-red-400',                   'pill' => 'bg-red-100 text-red-700',         'label' => 'Full'],
                    'closed' => ['dot' => 'bg-slate-400',                 'pill' => 'bg-slate-100 text-slate-500',     'label' => 'Closed'],
                ];
                $st = $statusMap[$match->status] ?? $statusMap['open'];

                $barColor = $pct >= 100 ? 'bg-red-400' : ($pct >= 75 ? 'bg-amber-400' : 'bg-emerald-500');
            @endphp

            <article class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">

                <div class="flex items-center justify-between px-5 pt-5 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                            {{ strtoupper(substr($creator->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 leading-tight">{{ $creator->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 1.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($annonce->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $st['pill'] }} px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}"></span>
                        {{ $st['label'] }}
                    </span>
                </div>

                @if($annonce->content)
                    <div class="px-5 pb-3">
                        <p class="text-sm text-slate-700 leading-relaxed" id="content-short-{{ $annonce->id }}">
                            {{ Str::limit($annonce->content, 120) }}
                        </p>
                        <p class="text-sm text-slate-700 leading-relaxed hidden" id="content-full-{{ $annonce->id }}">
                            {{ $annonce->content }}
                        </p>
                        @if(strlen($annonce->content) > 120)
                            <button onclick="toggleContent({{ $annonce->id }})"
                                    id="toggle-btn-{{ $annonce->id }}"
                                    class="text-emerald-600 hover:text-emerald-700 text-xs font-bold mt-1.5 hover:underline">
                                Read more
                            </button>
                        @endif
                    </div>
                @endif

                <div class="mx-5 mb-4 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-4 text-white shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider mb-1">Terrain</p>
                            <h3 class="font-extrabold text-lg leading-tight truncate">{{ $terrain->name ?? 'N/A' }}</h3>
                            @if(!empty($terrain->location))
                                <p class="text-emerald-100 text-xs mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $terrain->location }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-emerald-100 text-xs font-semibold">Price</p>
                            <p class="font-extrabold text-xl">{{ $reservation->total_price ?? '—' }} <span class="text-sm font-bold text-emerald-200">DH</span></p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/20 grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-2 text-sm font-semibold">
                            <svg class="w-4 h-4 text-emerald-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($reservation->date)->format('D, M j Y') }}
                        </div>
                        <div class="flex items-center gap-2 text-sm font-semibold">
                            <svg class="w-4 h-4 text-emerald-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 1.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ substr($reservation->start_time, 11, 5) }} – {{ substr($reservation->end_time, 11, 5) }}
                        </div>
                    </div>
                </div>

                <div class="px-5 space-y-3">
                    @if(!empty($match->description))
                        <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 rounded-xl px-4 py-3 border border-slate-100 italic">
                            "{{ $match->description }}"
                        </p>
                    @endif

                    <div>
                        <div class="flex justify-between items-center text-xs mb-2">
                            <span class="font-semibold text-slate-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Players
                            </span>
                            <span class="font-bold {{ $acceptedCount >= $match->max_players ? 'text-red-500' : 'text-emerald-600' }}">
                                {{ $acceptedCount }} / {{ $match->max_players }}
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mx-5 my-4 border-t border-slate-100"></div>

                <div class="px-5 pb-4 flex items-center justify-between gap-3 flex-wrap">

                    <div class="shrink-0">
                        @if($isCreator)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                                Organizer
                            </span>
                        @elseif($participation)
                            @if($participation->status === 'accepted')
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Joined
                                </span>
                            @elseif($participation->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 1.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pending approval
                                </span>
                            @elseif($participation->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Rejected
                                </span>
                            @endif
                        @elseif($match->status === 'full')
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Match Full
                            </span>
                        @else
                            <span class="text-xs font-medium text-slate-400">Not joined yet</span>
                        @endif
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('matches.show', $match) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all duration-150">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>

                        @if(!$isCreator && !$participation && $match->status === 'open')
                            <form action="{{ route('matches.join', $match) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 px-3.5 py-2 rounded-xl transition-all duration-150 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Join Match
                                </button>
                            </form>
                        @endif

                        @if($isCreator)
                            <a href="{{ route('matches.requests', $match) }}"
                               class="relative inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3.5 py-2 rounded-xl transition-all duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Requests
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center leading-none">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-100 mx-0">

                    <button onclick="toggleComments({{ $annonce->id }})"
                            class="w-full flex items-center justify-center gap-2 px-5 py-3 text-xs font-semibold text-slate-500 hover:text-emerald-600 hover:bg-slate-50 transition-all duration-150 group">
                        <svg class="w-4 h-4 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Comments
                        <span class="bg-slate-100 group-hover:bg-emerald-100 group-hover:text-emerald-700 text-slate-500 text-[10px] font-bold px-1.5 py-0.5 rounded-full transition-colors">
                            {{ $annonce->comments->count() }}
                        </span>
                    </button>

                    <div id="comments-{{ $annonce->id }}" class="hidden px-5 pb-5 space-y-3">

                        @if($annonce->comments->isNotEmpty())
                            <div class="space-y-3 pt-1">
                                @foreach($annonce->comments as $comment)
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-slate-300 to-slate-400 flex items-center justify-center text-white font-bold text-xs shrink-0 mt-0.5">
                                            {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="bg-slate-50 border border-slate-100 px-3 py-2 rounded-2xl rounded-tl-sm flex-1 min-w-0">
                                            <span class="text-xs font-bold text-slate-700">{{ $comment->user->name ?? 'Unknown' }}</span>
                                            <p class="text-sm text-slate-600 mt-0.5 leading-relaxed">{{ $comment->content }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 text-center py-2">No comments yet. Be the first!</p>
                        @endif

                        <form action="{{ route('comments.store') }}" method="POST" class="flex items-center gap-2 pt-1">
                            @csrf
                            <input type="hidden" name="announcement_id" value="{{ $annonce->id }}">

                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <div class="flex-1 flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2 focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-100 transition-all">
                                <input
                                    type="text"
                                    name="content"
                                    placeholder="Write a comment..."
                                    required
                                    maxlength="300"
                                    class="flex-1 bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none border-none focus:ring-0 p-0"
                                >
                                <button type="submit"
                                        class="shrink-0 w-7 h-7 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white rounded-xl flex items-center justify-center transition-all duration-150">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </article>
        @endforeach

        {{-- ── Pagination ──────────────────────────────────────── --}}
        @if(method_exists($announcements, 'links'))
            <div class="pt-2 pb-6">
                {{ $announcements->links() }}
            </div>
        @endif

        @endif 

    </div>
</div>

<script>
    function toggleComments(id) {
        const el  = document.getElementById('comments-' + id);
        el.classList.toggle('hidden');
    }

    function toggleContent(id) {
        const short  = document.getElementById('content-short-' + id);
        const full   = document.getElementById('content-full-'  + id);
        const btn    = document.getElementById('toggle-btn-'    + id);
        const isHidden = full.classList.contains('hidden');

        full.classList.toggle('hidden',  !isHidden);
        short.classList.toggle('hidden',  isHidden);
        btn.textContent = isHidden ? 'Show less' : 'Read more';
    }
</script>

@endsection