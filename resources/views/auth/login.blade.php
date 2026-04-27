<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – EasyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .panel-grid {
            background-image:
                linear-gradient(rgba(16,185,129,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16,185,129,0.08) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.18s; }
        .delay-3 { animation-delay: 0.26s; }
    </style>
</head>
<body class="min-h-screen bg-[#fafaf9] antialiased">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- ── Left panel (decorative) ───────────────────────────────────── --}}
    <div class="hidden lg:flex flex-col bg-gradient-to-br from-emerald-600 to-teal-700 panel-grid relative overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-transparent pointer-events-none"></div>

        {{-- Logo --}}
        <div class="relative z-10 p-10">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <span class="text-white font-display font-bold">E</span>
                </div>
                <span class="font-display font-bold text-xl text-white">EasyMatch</span>
            </a>
        </div>

        {{-- Center content --}}
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-12 text-center">
            <div class="w-20 h-20 rounded-3xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl mb-6 shadow-xl">⚽</div>
            <h2 class="font-display text-3xl font-extrabold text-white mb-3 tracking-tight">
                Bon retour sur<br>EasyMatch !
            </h2>
            <p class="text-emerald-100 text-base leading-relaxed max-w-xs">
                Retrouvez vos terrains favoris, vos matchs en cours et vos coéquipiers.
            </p>

            {{-- Mini stats --}}
            <div class="mt-10 grid grid-cols-3 gap-4 w-full max-w-xs">
                @foreach([['180+', 'Terrains'], ['5 800+', 'Joueurs'], ['98%', 'Satisfaction']] as $s)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl py-3 border border-white/20">
                        <p class="font-display text-xl font-extrabold text-white">{{ $s[0] }}</p>
                        <p class="text-xs text-emerald-200 mt-0.5">{{ $s[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10 p-10 text-center">
            <p class="text-xs text-emerald-200">© {{ date('Y') }} EasyMatch</p>
        </div>
    </div>

    {{-- ── Right panel (form) ─────────────────────────────────────────── --}}
    <div class="flex flex-col items-center justify-center px-6 py-12 sm:px-12">

        {{-- Mobile logo --}}
        <div class="lg:hidden mb-8">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                    <span class="text-white font-display font-bold text-sm">E</span>
                </div>
                <span class="font-display font-bold text-lg text-slate-900">Easy<span class="text-emerald-600">Match</span></span>
            </a>
        </div>

        <div class="w-full max-w-sm">

            {{-- Header --}}
            <div class="mb-8 animate-in">
                <h1 class="font-display text-3xl font-extrabold text-slate-900 mb-1.5 tracking-tight">
                    Connexion
                </h1>
                <p class="text-slate-400 text-sm">Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline">S'inscrire</a>
                </p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-4 animate-in">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 012 0v4a1 1 0 01-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li class="text-sm text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Session status --}}
            @if(session('status'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-2 text-sm text-emerald-700 font-medium animate-in">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-4 animate-in delay-1">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                        Adresse email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input
                            type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            required autofocus autocomplete="email"
                            placeholder="vous@example.com"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border @error('email') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Mot de passe
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            type="password" name="password" id="password"
                            required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-11 py-3 rounded-xl border @error('password') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all"
                        >
                        <button type="button" onclick="togglePwd('password')"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer">
                    <label for="remember" class="text-sm text-slate-500 cursor-pointer select-none">
                        Se souvenir de moi
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3.5 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold text-sm rounded-xl transition-all duration-150 shadow-sm shadow-emerald-200 mt-2">
                    Se connecter
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative flex items-center gap-3 my-6 animate-in delay-2">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-400 font-medium">ou</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            {{-- Register link --}}
            <div class="animate-in delay-3">
                <a href="{{ route('register') }}"
                   class="w-full flex items-center justify-center gap-2 py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl border border-slate-200 hover:border-slate-300 transition-all">
                    Créer un compte gratuitement
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePwd(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>