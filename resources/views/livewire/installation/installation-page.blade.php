@extends('layouts.public')
@section('title', config('platform.name') . ' - Installation WifiZone')
@section('navbar')
    @include('partials.navbar')
@endsection
@section('content')

{{-- ============================================================ --}}
{{-- Local, page-scoped visual layer (prefixed iz- to avoid clashing --}}
{{-- with any global utility of a similar name) --}}
{{-- ============================================================ --}}
<style>
    @keyframes iz-radar-pulse{
        0%{ width:70px; height:70px; opacity:.9; border-width:2.5px; }
        100%{ width:460px; height:460px; opacity:0; border-width:1px; }
    }
    .iz-radar-ring{ position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); border-radius:9999px; border:2px solid rgba(16,185,129,0.4); animation:iz-radar-pulse 3.2s cubic-bezier(.2,.6,.4,1) infinite; }

    @keyframes iz-badge-float{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-9px); } }
    .iz-float{ animation:iz-badge-float 5s ease-in-out infinite; }

    @keyframes iz-signal-travel{
        0%{ left:-6%; opacity:0; }
        12%{ opacity:1; }
        88%{ opacity:1; }
        100%{ left:104%; opacity:0; }
    }
    .iz-signal-dot{ position:absolute; top:50%; width:9px; height:9px; margin-top:-4.5px; border-radius:9999px; background:#10B981; box-shadow:0 0 14px 3px rgba(16,185,129,.65); animation:iz-signal-travel 3.4s linear infinite; }

    .iz-kit-chip{ transition:background-color .2s ease, transform .2s ease; }
    .iz-kit-chip:hover{ transform:translateX(2px); }

    .iz-compare-table th, .iz-compare-table td{ white-space:nowrap; }

    @media (prefers-reduced-motion: reduce){
        .iz-radar-ring, .iz-float, .iz-signal-dot{ animation:none !important; }
    }
</style>

<div class="min-h-screen bg-slate-50 dark:bg-[#0A0A0C] pt-32" x-data="{ selectedPack: null }">
    {{-- Packs & helpers --}}
    @php
    $pack = [
        'id' => 'wifizone',
        'nom' => 'Pack WiFi Zone',
        'sousTitre' => 'La solution clé en main pour votre hotspot',
        'prix' => '120 000',
        'prixNote' => 'FCFA',
        'equipements' => [
            'Antenne (Tenda)',
            'Mikrotik',
            'Cablages',
        ],
        'services' => [
            'Installation & configuration complète',
            'Configuration portail captif',
            'Test de couverture & optimisation',
            'Formation vendeur 1h',
            'Support technique 30 jours',
            'Tickets personnalisé',
        ],
        'couleur' => '#10B981',
        'garantie' => '1 an',
        'support' => '30 jours',
        'formation' => '1h',
        'monitoring' => false,
        'onduleur' => false,
    ];

    function installIcon($text) {
        $map = [
            'Routeur' => 'fa-server',
            'Antenne' => 'fa-broadcast-tower',
            'Câble' => 'fa-plug',
            'Câblage' => 'fa-plug',
            'Cablages' => 'fa-plug',
            'Mikrotik' => 'fa-server',
            'Boîtier' => 'fa-box',
            'Alimentation' => 'fa-bolt',
            'Fixation' => 'fa-thumbtack',
            'Onduleur' => 'fa-car-battery',
            'Matériel' => 'fa-microchip',
            'Installation' => 'fa-tools',
            'Formation' => 'fa-graduation-cap',
            'Support' => 'fa-headset',
            'Monitoring' => 'fa-chart-line',
            'Garantie' => 'fa-shield-alt',
            'Étude' => 'fa-map-marked-alt',
            'Test' => 'fa-signal',
            'Maintenance' => 'fa-wrench',
            'Tickets' => 'fa-ticket-alt',
        ];
        foreach ($map as $key => $icon) {
            if (str_contains($text, $key)) return $icon;
        }
        return 'fa-check';
    }
    @endphp

    {{-- ============================================================ --}}
    {{-- HERO — coverage radar as the signature visual --}}
    {{-- ============================================================ --}}
    <section class="relative bg-gradient-to-b from-slate-50 to-white dark:from-[#0A0A0C] dark:to-[#111316] min-h-[calc(100vh-8rem)] grid place-items-center">
        <div class="absolute inset-0 overflow-hidden bg-[url('data:image/svg+xml,%3Csvg width=%2246%22 height=%2246%22 viewBox=%220 0 46 46%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22none%22/%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22%2310B981%22 fill-opacity=%220.03%22/%3E%3C/svg%3E')] opacity-50"></div>
        <div class="absolute inset-0 overflow-hidden -webkit-mask-image:[radial-gradient(ellipse_65%25_55%25_at_50%25_10%25,_black_35%25,_transparent_100%25)] mask-image:[radial-gradient(ellipse_65%25_55%25_at_50%25_10%25,_black_35%25,_transparent_100%25)]">
            <div class="orb w-72 h-72 sm:w-96 sm:h-96 bg-neonGreen/20 dark:bg-neonGreen/25 -top-16 -left-16"></div>
            <div class="orb w-64 h-64 sm:w-80 sm:h-80 bg-neonGreen/10 dark:bg-neonGreen/15 top-1/3 -right-10" style="animation-delay:-6s"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
            {{-- Radar + badges --}}
            <div class="flex flex-col items-center">

                {{-- Radar --}}
                <div class="relative w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] lg:w-[480px] lg:h-[480px] shrink-0 iz-float">
                    <div class="iz-radar-ring"></div>
                    <div class="iz-radar-ring" style="animation-delay:-1.05s"></div>
                    <div class="iz-radar-ring" style="animation-delay:-2.1s"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 sm:w-72 sm:h-72 flex items-center justify-center z-10">
                        <img src="{{ asset('wifii.gif') }}" alt="WiFi" class="w-64 h-64 sm:w-72 sm:h-72 object-contain">
                    </div>
                </div>

                {{-- Badges en bas --}}
                <div class="flex items-center justify-center">
                    <div class="hidden sm:flex items-center gap-2.5 bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-lg px-4 py-3 shadow-xl shrink-0 iz-float">
                        <i class="fas fa-signal text-neonGreen text-base"></i>
                        <p class="text-xs font-bold text-slate-700 dark:text-gray-300 whitespace-nowrap">Couverture jusqu'à 150m</p>
                    </div>
                </div>
            </div>

            {{-- Copy column --}}
            <div class="text-center lg:text-right">
                <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.08] mb-6">
                    Nous installons votre <span class="text-neonGreen text-glow">WiFi Zone</span> clé en main
                </h1>
                <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-xl mx-auto lg:mx-0 lg:ml-auto mb-8">
                    Matériel professionnel, configuration experte, formation incluse. Vous lancez votre activité, on s'occupe de la technique.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-end gap-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-6 py-4 text-base rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-headset"></i> Demander un devis
                    </a>
                    <a href="#packs" class="inline-flex items-center justify-center gap-2 bg-white dark:bg-darkCard/80 hover:bg-slate-100 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white font-bold px-6 py-4 text-base rounded-full transition-all shadow-sm">
                        <i class="fas fa-box-open"></i> Voir nos packs
                    </a>
                </div>
            </div>
        </div>

        {{-- Badges compacts sur mobile --}}
        <div class="flex sm:hidden items-center justify-center gap-3 -mt-6">
            <div class="flex items-center gap-2 bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-full px-3 py-2 shadow-md">
                <i class="fas fa-signal text-neonGreen text-xs"></i>
                <p class="text-[11px] font-bold text-slate-700 dark:text-gray-300">150m</p>
            </div>
            <div class="flex items-center gap-2 bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-full px-3 py-2 shadow-md">
                <i class="fas fa-users text-neonGreen text-xs"></i>
                <p class="text-[11px] font-bold text-slate-700 dark:text-gray-300">40+ appareils</p>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- PACKS --}}
    {{-- ============================================================ --}}
    <section id="packs" class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Nos offres d'installation</h2>
                <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Choisissez le pack adapté à votre projet
                </p>
                <p class="mt-4 text-sm sm:text-lg text-slate-600 dark:text-gray-400">
                    Matériel garanti, installation comprise, formation incluse. Pas de surprise.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-14 sm:mb-20 items-center relative">

                <div class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 items-center z-10 text-neonGreen">
                    <i class="fas fa-long-arrow-alt-right text-3xl drop-shadow-lg"></i>
                </div>

                <div class="relative rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow hover:-translate-y-1 group shadow-sm">
                    <div class="p-6 sm:p-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-6 shadow-lg" style="background: {{ $pack['couleur'] }}; box-shadow: 0 12px 24px -8px {{ $pack['couleur'] }}66;">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $pack['nom'] }}</h3>
                        <p class="text-slate-600 dark:text-gray-400 text-sm mb-6">{{ $pack['sousTitre'] }}</p>
                        <div class="mb-6">
                            <span class="font-display text-3xl font-extrabold" style="color: {{ $pack['couleur'] }}">{{ $pack['prix'] }}</span>
                            @if($pack['prixNote'])
                            <span class="text-slate-500 dark:text-gray-500 font-semibold ml-1">{{ $pack['prixNote'] }}</span>
                            @endif
                        </div>
                        <div class="space-y-2.5 mb-6 border-t border-slate-100 dark:border-darkBorder/40 pt-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500">Équipements fournis</p>
                            <ul class="space-y-1">
                                @foreach($pack['equipements'] as $equip)
                                <li class="iz-kit-chip flex items-start gap-2.5 text-sm text-slate-600 dark:text-gray-400 rounded-lg px-1.5 py-1 hover:bg-slate-50 dark:hover:bg-darkBg/40">
                                    <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0 mt-0.5" style="background: {{ $pack['couleur'] }}1A; color: {{ $pack['couleur'] }}">
                                        <i class="fas {{ installIcon($equip) }} text-[10px]"></i>
                                    </span>
                                    {{ $equip }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="space-y-2.5 border-t border-slate-100 dark:border-darkBorder/40 pt-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500">Services inclus</p>
                            <ul class="space-y-1">
                                @foreach($pack['services'] as $service)
                                <li class="iz-kit-chip flex items-start gap-2.5 text-sm text-slate-600 dark:text-gray-400 rounded-lg px-1.5 py-1 hover:bg-slate-50 dark:hover:bg-darkBg/40">
                                    <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0 mt-0.5" style="background: {{ $pack['couleur'] }}1A; color: {{ $pack['couleur'] }}">
                                        <i class="fas {{ installIcon($service) }} text-[10px]"></i>
                                    </span>
                                    {{ $service }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <button @click="selectedPack = '{{ $pack['id'] }}'" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-sm transition-all" :class="selectedPack === '{{ $pack['id'] }}' ? 'text-white' : 'text-slate-700 dark:text-gray-300 bg-slate-100 dark:bg-darkBorder/40 hover:bg-slate-200 dark:hover:bg-darkBorder/60'" :style="selectedPack === '{{ $pack['id'] }}' ? 'background: {{ $pack['couleur'] }}' : ''">
                            <template x-if="selectedPack === '{{ $pack['id'] }}'">
                                <span class="inline-flex items-center gap-2"><i class="fas fa-check"></i> Pack sélectionné</span>
                            </template>
                            <template x-if="selectedPack !== '{{ $pack['id'] }}'">
                                <span class="inline-flex items-center gap-2"><i class="fas fa-arrow-right"></i> Choisir ce pack</span>
                            </template>
                        </button>
                    </div>
                </div>

                <div class="relative flex items-center justify-center">
                    <img src="{{ asset('Wifizone.png') }}" alt="WiFi Zone" class="w-full max-w-md h-auto object-contain rounded-3xl shadow-2xl ring-1 ring-black/5">
                    <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-neonGreen/60 to-transparent pointer-events-none rounded-b-3xl"></div>
                </div>
            </div>


        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- PROCESSUS --}}
    {{-- ============================================================ --}}
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-darkBg/30 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Comment ça se passe</h2>
                <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Un processus simple en 4 étapes
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 relative">
                <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-slate-200 dark:bg-darkBorder/40 overflow-visible">
                    <span class="iz-signal-dot"></span>
                    <span class="iz-signal-dot" style="animation-delay:-1.7s"></span>
                </div>
                @php
                $etapes = [
                    ['icon' => 'fas fa-phone-alt', 'titre' => '1. Contact', 'desc' => 'Vous nous appelez ou remplissez le formulaire. On discute de votre zone et vos besoins.'],
                    ['icon' => 'fas fa-map-marked-alt', 'titre' => '2. Étude gratuite', 'desc' => 'On se déplace (ou étude à distance) pour analyser la couverture et valider le matériel.'],
                    ['icon' => 'fas fa-tools', 'titre' => '3. Installation', 'desc' => 'Notre équipe installe, configure le portail captif et teste la couverture.'],
                    ['icon' => 'fas fa-graduation-cap', 'titre' => '4. Formation & Go', 'desc' => 'On vous forme 1-2h, vous repartez avec votre WiFi Zone opérationnelle.'],
                ];
                @endphp
                @foreach($etapes as $index => $etape)
                <div class="relative p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 hover:-translate-y-1 transition-all">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-neonGreen text-xl font-bold mb-6 relative z-10" style="background: linear-gradient(135deg, #10B981, #059669); color: white;">
                        <i class="{{ $etape['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $etape['titre'] }}</h3>
                    <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed">{{ $etape['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA --}}
    {{-- ============================================================ --}}
    <section class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl p-8 sm:p-12 lg:p-16 text-center relative overflow-hidden" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%)">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2246%22 height=%2246%22 viewBox=%220 0 46 46%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22none%22/%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22white%22 fill-opacity=%220.05%22/%3E%3C/svg%3E')]"></div>
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-14 -left-10 w-48 h-48 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative z-10">
                    <i class="fas fa-broadcast-tower text-white/70 text-2xl mb-4"></i>
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-white mb-4">
                        Prêt à lancer votre WiFi Zone ?
                    </h2>
                    <p class="text-white/80 text-base sm:text-lg max-w-2xl mx-auto mb-8">
                        Étude gratuite, sans engagement. On s'occupe de tout, vous encaissez.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-white text-neonGreen font-bold px-8 py-4 text-base rounded-full hover:bg-slate-100 transition-all transform hover:-translate-y-0.5 shadow-xl">
                        <i class="fas fa-rocket"></i> Demander mon étude gratuite
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FAQ --}}
    {{-- ============================================================ --}}
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-darkBg/30 transition-colors duration-300">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Questions fréquentes</h2>
                <p class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Tout savoir sur l'installation
                </p>
            </div>
            <div class="space-y-3">
                @php
                $faqs = [
                    ['q' => 'L\'étude de couverture est-elle vraiment gratuite ?', 'a' => 'Oui, totalement gratuite et sans engagement. On se déplace chez vous ou on fait l\'étude à distance selon votre localisation.'],
                    ['q' => 'Combien de temps dure l\'installation ?', 'a' => 'Entre 2h et 4h selon la complexité (fixation, câblage, configuration). On s\'occupe de tout.'],
                    ['q' => 'Le matériel est-il garanti ?', 'a' => 'Oui : 1 an pour Starter, 2 ans pour Pro, 3 ans pour Entreprise. Échange standard en cas de panne.'],
                    ['q' => 'Puis-je payer en plusieurs fois ?', 'a' => 'Oui, paiement en 2 ou 3 fois sans frais possible sur les packs Starter et Pro.'],
                    ['q' => 'Que se passe-t-il si j\'ai un problème technique après ?', 'a' => 'Support inclus : 30 jours (Starter), 1 an (Pro), illimité 24/7 (Entreprise). On intervient à distance ou sur site.'],
                    ['q' => 'Je suis déjà client, puis-je upgrader mon pack ?', 'a' => 'Bien sûr. On récupère l\'ancien matériel, on installe le nouveau, vous ne payez que la différence.'],
                ];
                @endphp
                @foreach($faqs as $faq)
                <div class="rounded-2xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder overflow-hidden">
                    <button type="button" onclick="toggleFaq(this)" aria-expanded="false" class="faq-toggle w-full flex items-center justify-between gap-4 px-5 sm:px-6 py-4 sm:py-5 text-left">
                        <span class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">{{ $faq['q'] }}</span>
                        <i class="faq-icon fas fa-plus text-neonGreen text-sm shrink-0"></i>
                    </button>
                    <div class="faq-panel">
                        <p class="px-5 sm:px-6 pb-4 sm:pb-5 text-sm text-slate-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<script>
    // --- Scroll progress bar ---
    function izUpdateScrollProgress() {
        const doc = document.documentElement;
        const scrollTop = doc.scrollTop || document.body.scrollTop;
        const scrollHeight = doc.scrollHeight - doc.clientHeight;
        const progress = scrollHeight > 0 ? Math.min(scrollTop / scrollHeight, 1) : 0;
        const fill = document.getElementById('scroll-progress-bar-fill');
        if (fill) fill.style.transform = 'scaleX(' + progress + ')';
    }
    window.addEventListener('scroll', izUpdateScrollProgress);
    izUpdateScrollProgress();

    // --- FAQ accordion ---
    function toggleFaq(btn) {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.faq-toggle').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
    }

    // --- Hero trust stats count-up ---
    function izInitStatCounters() {
        const counters = document.querySelectorAll('.iz-stat-counter');
        if (!counters.length || !('IntersectionObserver' in window)) return;
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                if (el.dataset.done) return;
                el.dataset.done = '1';
                const target = parseFloat(el.dataset.target || '0');
                const decimals = parseInt(el.dataset.decimals || '0', 10);
                const duration = 1400;
                const start = performance.now();
                function step(now) {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = (target * eased).toFixed(decimals);
                    if (p < 1) requestAnimationFrame(step);
                    else el.textContent = target.toFixed(decimals);
                }
                requestAnimationFrame(step);
                observer.unobserve(el);
            });
        }, { threshold: 0.4 });
        counters.forEach(function(c) { observer.observe(c); });
    }
    document.addEventListener('DOMContentLoaded', izInitStatCounters);
</script>
@endsection