<nav x-data="{ sidebarOpen: false }" class="bg-white border-b border-slate-100 h-14 relative z-30">
    <div class="px-4 sm:px-6 h-full flex items-center justify-between">

        {{-- Left: hamburger + logo --}}
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen"
                class="sm:hidden w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path :class="{'hidden': sidebarOpen, 'block': !sidebarOpen}" class="block" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !sidebarOpen, 'block': sidebarOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c0 0-3 4-3 9s3 9 3 9M12 3c0 0 3 4 3 9s-3 9-3 9M3 12h18"/>
                    </svg>
                </div>
                <span class="font-bold text-slate-900 text-sm hidden sm:block tracking-tight">Smart<span class="text-green-600">Booking</span></span>
            </a>
        </div>

        {{-- Right: role badge + user dropdown --}}
        <div class="flex items-center gap-3">

            {{-- Role badge --}}
            <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                {{ auth()->user()->role == 'manager' ? 'bg-blue-50 text-blue-700' : '' }}
                {{ auth()->user()->role == 'client' ? 'bg-green-50 text-green-700' : '' }}
                {{ auth()->user()->role == 'admin' ? 'bg-purple-50 text-purple-700' : '' }}
            ">
                {{ ucfirst(auth()->user()->role) }}
            </span>

            {{-- User dropdown --}}
            <x-dropdown align="right" width="52">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 hover:border-slate-300 hover:bg-slate-100 transition-all text-sm font-medium text-slate-700">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="hidden sm:block max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                    </div>
                    <div class="border-t border-slate-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Se déconnecter
                            </x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>

        </div>
    </div>

    {{-- Mobile sidebar --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-x-4"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 -translate-x-4"
         class="sm:hidden fixed top-14 left-0 bottom-0 w-64 bg-white border-r border-slate-100 z-50 flex flex-col shadow-xl">

        <div class="px-5 pt-5 pb-3">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Navigation</p>
        </div>

        <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">
            <a href="/dashboard" @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
                </span>
                Dashboard
            </a>
            <a href="/terrains" @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                </span>
                @if(auth()->user()->role == 'client') Terrains @else Mes terrains @endif
            </a>
            <a href="/mes-reservations" @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                Mes réservations
            </a>

            @if (auth()->user()->role === 'client')
                
            <a href="/matches" @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                Matches
            </a>
            <a href="/announcements" @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all group">
                <span class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </span>
                Annonces
            </a>
            @endif
        </nav>

        <div class="m-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Backdrop --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="sidebarOpen=false"
         class="sm:hidden fixed inset-0 top-14 bg-slate-900/30 backdrop-blur-sm z-40">
    </div>
</nav>