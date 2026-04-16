<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link.active { background: linear-gradient(135deg, #16a34a, #15803d); color: white; }
        .sidebar-link.active svg { color: white; }
        .slot-btn { transition: all 0.15s ease; }
        .slot-btn:not(:disabled):hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="bg-slate-50 antialiased">

@include('layouts.navigation')

<div class="flex h-[calc(100vh-56px)] overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="hidden sm:flex w-64 bg-white border-r border-slate-100 flex-col shrink-0">

        {{-- Brand in sidebar --}}
        <div class="px-5 pt-6 pb-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Navigation</p>
        </div>

        <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="/dashboard"
               class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0 transition-colors {{ request()->is('dashboard') ? '!bg-white/20' : '' }}">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600 {{ request()->is('dashboard') ? '!text-white' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                    </svg>
                </span>
                Dashboard
            </a>

            {{-- Terrains --}}
            <a href="/terrains"
               class="sidebar-link {{ request()->is('terrains*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0 transition-colors {{ request()->is('terrains*') ? '!bg-white/20' : '' }}">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600 {{ request()->is('terrains*') ? '!text-white' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <circle cx="12" cy="11" r="3" stroke-linecap="round"/>
                    </svg>
                </span>
                @if(auth()->user()->role == 'client') Terrains @else Mes terrains @endif
            </a>

            {{-- Mes réservations (client only) --}}
            @if(auth()->user()->role == 'client')
            <a href="/mes-reservations"
               class="sidebar-link {{ request()->is('mes-reservations*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0 transition-colors {{ request()->is('mes-reservations*') ? '!bg-white/20' : '' }}">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600 {{ request()->is('mes-reservations*') ? '!text-white' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Mes réservations
            </a>
            @endif

            {{-- Annonces --}}
            <a href="/annonces"
               class="sidebar-link {{ request()->is('annonces*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0 transition-colors {{ request()->is('annonces*') ? '!bg-white/20' : '' }}">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600 {{ request()->is('annonces*') ? '!text-white' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </span>
                Annonces
            </a>

            {{-- Messages --}}
            <a href="#"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0 transition-colors">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
                Messages
            </a>

        </nav>

        {{-- User card --}}
        <div class="m-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>

    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="bg-white border-b border-slate-100 px-6 py-3.5 flex items-center justify-between shrink-0">
            <h1 class="text-sm font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
            @hasSection('header_actions')
                <div>@yield('header_actions')</div>
            @endif
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>
</body>
</html>