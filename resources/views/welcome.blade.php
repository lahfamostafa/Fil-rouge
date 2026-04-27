<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyMatch – Réservez. Jouez. Gagnez.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .hero-grid {
            background-image:
                linear-gradient(rgba(16,185,129,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16,185,129,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .glow { box-shadow: 0 0 60px rgba(16,185,129,0.25); }
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 50%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover { transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .card-hover:hover { transform: translateY(-6px); }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-fadeup { animation: fadeUp 0.7s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.35s; }
        .delay-4 { animation-delay: 0.5s; }
        .noise {
            position: relative;
        }
        .noise::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            border-radius: inherit;
        }
    </style>
</head>
<body class="bg-[#fafaf9] text-slate-900 antialiased overflow-x-hidden">

{{-- ══ NAVBAR ══════════════════════════════════════════════════════════ --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                <span class="text-white font-display font-bold text-sm">E</span>
            </div>
            <span class="font-display font-bold text-lg tracking-tight text-slate-900">Easy<span class="text-emerald-600">Match</span></span>
        </a>

        {{-- Nav links (desktop) --}}
        <div class="hidden md:flex items-center gap-1">
            <a href="#features" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">Fonctionnalités</a>
            <a href="#stats" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">Stats</a>
            <a href="{{ route('terrains.index') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all">Terrains</a>
        </div>

        {{-- Auth buttons --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('login') }}"
               class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition-all">
                Connexion
            </a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-emerald-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                S'inscrire
            </a>
        </div>
    </div>
</nav>

{{-- ══ HERO ═════════════════════════════════════════════════════════════ --}}
<section class="hero-grid relative min-h-screen flex flex-col items-center justify-center pt-16 overflow-hidden noise">

    {{-- Glow blobs --}}
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-5 sm:px-8 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-8 animate-fadeup">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Plateforme sportive #1 au Maroc
        </div>

        {{-- Headline --}}
        <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.05] mb-6 animate-fadeup delay-1">
            Réservez.<br>
            <span class="text-gradient">Jouez.</span> Gagnez.
        </h1>

        {{-- Sub --}}
        <p class="text-slate-500 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed mb-10 animate-fadeup delay-2">
            Trouvez le terrain parfait, créez votre match et rejoignez des joueurs près de chez vous — en quelques secondes.
        </p>

        {{-- CTAs --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 animate-fadeup delay-3">
            <a href="{{ route('register') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold rounded-2xl transition-all shadow-lg shadow-emerald-200/60 glow text-base">
                Commencer gratuitement
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('terrains.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-2xl border border-slate-200 hover:border-slate-300 transition-all text-base shadow-sm">
                Voir les terrains
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
            </a>
        </div>

        {{-- Floating hero card --}}
        <div class="mt-16 animate-fadeup delay-4">
            <div class="relative inline-block animate-float">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl shadow-slate-200/60 p-6 max-w-sm mx-auto text-left">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold">⚽</div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Terrain Central — Casablanca</p>
                            <p class="text-xs text-slate-400">Vendredi 27 Juin · 18h00 – 19h00</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-slate-500">Joueurs</span>
                        <span class="text-xs font-bold text-emerald-600">7 / 10</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-4">
                        <div class="h-2 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500" style="width:70%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            @foreach(['A','K','M','Y','R'] as $l)
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 border-2 border-white flex items-center justify-center text-white text-[10px] font-bold">{{ $l }}</div>
                            @endforeach
                            <div class="w-7 h-7 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-slate-500 text-[10px] font-bold">+2</div>
                        </div>
                        <span class="text-xs font-bold text-white bg-emerald-600 px-3 py-1.5 rounded-full">Rejoindre</span>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="absolute -top-4 -right-4 bg-white border border-slate-100 rounded-2xl shadow-lg px-3 py-2 flex items-center gap-1.5">
                    <span class="text-lg">🏆</span>
                    <div>
                        <p class="text-[10px] font-bold text-slate-800">Match créé</p>
                        <p class="text-[10px] text-slate-400">il y a 2 min</p>
                    </div>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-emerald-600 rounded-2xl shadow-lg px-3 py-2 flex items-center gap-1.5">
                    <span class="text-lg">⚡</span>
                    <p class="text-[10px] font-bold text-white">Réservation confirmée !</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce opacity-40">
        <span class="text-xs font-medium text-slate-400">Défiler</span>
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ══ FEATURES ═════════════════════════════════════════════════════════ --}}
<section id="features" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">

        {{-- Section header --}}
        <div class="text-center mb-16">
            <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-3">Fonctionnalités</p>
            <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                Tout ce dont vous<br>avez besoin
            </h2>
            <p class="text-slate-400 text-lg max-w-lg mx-auto">Une expérience fluide du terrain à la victoire.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $features = [
                    [
                        'icon' => '🏟️',
                        'color' => 'from-emerald-500 to-teal-600',
                        'light' => 'bg-emerald-50 border-emerald-100',
                        'title' => 'Réservation instantanée',
                        'desc'  => 'Réservez votre terrain en 30 secondes. Choisissez la date, l\'heure et confirmez — sans attente, sans appel.',
                        'tags'  => ['Paiement sécurisé', 'Confirmation email'],
                    ],
                    [
                        'icon' => '⚽',
                        'color' => 'from-blue-500 to-indigo-600',
                        'light' => 'bg-blue-50 border-blue-100',
                        'title' => 'Créez votre match',
                        'desc'  => 'Organisez un match ouvert, fixez le nombre de joueurs et regardez les demandes affluer depuis la communauté.',
                        'tags'  => ['Gestion des joueurs', 'Annonces publiques'],
                    ],
                    [
                        'icon' => '🤝',
                        'color' => 'from-violet-500 to-purple-600',
                        'light' => 'bg-violet-50 border-violet-100',
                        'title' => 'Rejoignez un match',
                        'desc'  => 'Parcourez les matchs ouverts près de vous, rejoignez une équipe et jouez — même seul au départ.',
                        'tags'  => ['Filtres avancés', 'Notifications temps réel'],
                    ],
                ];
            @endphp

            @foreach($features as $i => $f)
                <div class="card-hover {{ $f['light'] }} border rounded-3xl p-7 flex flex-col gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $f['color'] }} flex items-center justify-center text-2xl shadow-sm">
                        {{ $f['icon'] }}
                    </div>
                    <div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-2">{{ $f['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-auto">
                        @foreach($f['tags'] as $tag)
                            <span class="text-[10px] font-bold text-slate-500 bg-white border border-slate-200 px-2.5 py-1 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ STATS ════════════════════════════════════════════════════════════ --}}
<section id="stats" class="py-24 bg-slate-900 noise relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/30 to-teal-900/20 pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-5 sm:px-8">
        <div class="text-center mb-16">
            <p class="text-xs font-bold uppercase tracking-widest text-emerald-400 mb-3">En chiffres</p>
            <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                La communauté parle
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['value' => '2 400+', 'label' => 'Réservations', 'icon' => '📅'],
                    ['value' => '180+',   'label' => 'Terrains',      'icon' => '🏟️'],
                    ['value' => '5 800+', 'label' => 'Joueurs',       'icon' => '👟'],
                    ['value' => '98%',    'label' => 'Satisfaction',  'icon' => '⭐'],
                ];
            @endphp

            @foreach($stats as $s)
                <div class="bg-white/5 border border-white/10 backdrop-blur-sm rounded-3xl p-6 text-center hover:bg-white/10 transition-all">
                    <div class="text-3xl mb-3">{{ $s['icon'] }}</div>
                    <p class="font-display text-4xl font-extrabold text-white mb-1">{{ $s['value'] }}</p>
                    <p class="text-sm text-slate-400 font-medium">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Testimonials --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-12">
            @php
                $testimonials = [
                    ['name' => 'Karim B.',   'role' => 'Joueur régulier',  'text' => '"EasyMatch a transformé mes week-ends. Je trouve un match en 5 minutes chrono."'],
                    ['name' => 'Yasmine A.', 'role' => 'Organisatrice',    'text' => '"Je gère mes réservations depuis mon téléphone. Impossible de s\'en passer."'],
                    ['name' => 'Mehdi O.',   'role' => 'Manager de terrain','text' => '"Mes terrains affichent complet tous les weekends grâce à la plateforme."'],
                ];
            @endphp

            @foreach($testimonials as $t)
                <div class="bg-white/5 border border-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/10 transition-all">
                    <p class="text-sm text-slate-300 leading-relaxed mb-4">{{ $t['text'] }}</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ substr($t['name'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $t['name'] }}</p>
                            <p class="text-xs text-slate-400">{{ $t['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ CTA BANNER ═══════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-5 sm:px-8 text-center">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-12 relative overflow-hidden noise shadow-2xl shadow-emerald-200/50">
            <div class="absolute inset-0 bg-gradient-to-r from-black/5 to-transparent pointer-events-none"></div>
            <div class="relative z-10">
                <p class="text-emerald-100 text-sm font-bold uppercase tracking-widest mb-4">Prêt à jouer ?</p>
                <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Rejoignez EasyMatch<br>dès aujourd'hui
                </h2>
                <p class="text-emerald-100 text-lg mb-8 max-w-lg mx-auto">Inscription gratuite · Aucune carte requise · Prêt en 1 minute</p>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-700 font-extrabold text-base px-8 py-4 rounded-2xl transition-all shadow-xl active:scale-95">
                    Créer mon compte
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══ FOOTER ═══════════════════════════════════════════════════════════ --}}
<footer class="bg-slate-900 py-12">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                    <span class="text-white font-display font-bold text-sm">E</span>
                </div>
                <span class="font-display font-bold text-lg text-white">Easy<span class="text-emerald-400">Match</span></span>
            </div>
            <div class="flex items-center gap-6 text-sm text-slate-400">
                <a href="#" class="hover:text-white transition-colors">Terrains</a>
                <a href="#" class="hover:text-white transition-colors">Matchs</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Connexion</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors">Inscription</a>
            </div>
        </div>
        <div class="border-t border-white/10 mt-8 pt-8 text-center">
            <p class="text-xs text-slate-500">© {{ date('Y') }} EasyMatch. Tous droits réservés.</p>
        </div>
    </div>
</footer>

</body>
</html>