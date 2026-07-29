<div class="min-h-screen bg-slate-50 dark:bg-[#0A0A0C]" x-data="{ selectedPack: null }">
    {{-- Packs data --}}
    @php
    $packs = [
        [
            'id' => 'starter',
            'nom' => 'Pack Starter',
            'sousTitre' => 'Pour démarrer votre activité',
            'prix' => '299 000',
            'prixNote' => 'FCFA',
            'equipements' => [
                'Routeur MikroTik hAP ax2 (WiFi 6)',
                'Antenne secteur 120° 16dBi',
                'Câble Ethernet extérieur 30m',
                'Boîtier étanche IP66',
                'Alimentation PoE + injecteur',
                'Fixations murales/poteau',
            ],
            'services' => [
                'Installation & configuration complète',
                'Configuration portail captif',
                'Test de couverture & optimisation',
                'Formation vendeur 1h',
                'Support technique 30 jours',
            ],
            'couleur' => '#10B981',
            'populaire' => false,
        ],
        [
            'id' => 'pro',
            'nom' => 'Pack Pro',
            'sousTitre' => 'Notre offre la plus complète',
            'prix' => '499 000',
            'prixNote' => 'FCFA',
            'equipements' => [
                'Routeur MikroTik hAP ax3 (WiFi 6E)',
                '2x Antennes secteur 120° 16dBi',
                'Câble Ethernet extérieur 50m',
                'Boîtier étanche IP66 renforcé',
                'Alimentation PoE + injecteur gigabit',
                'Fixations murales/poteau pro',
                'Onduleur 650VA (autonomie 2h)',
            ],
            'services' => [
                'Installation & configuration complète',
                'Configuration portail captif avancée',
                'Test de couverture & optimisation',
                'Formation vendeur 2h + doc',
                'Support technique 1 an',
                'Monitoring distant inclus 1 an',
                'Garantie matériel 2 ans',
            ],
            'couleur' => '#3B82F6',
            'populaire' => true,
        ],
        [
            'id' => 'enterprise',
            'nom' => 'Pack Entreprise',
            'sousTitre' => 'Pour zones larges & multi-sites',
            'prix' => 'Sur devis',
            'prixNote' => '',
            'equipements' => [
                'Routeur MikroTik CCR2004 ou supérieur',
                'Antennes secteurs 90°/120° selon étude',
                'Câblage complet (fibre/ethernet)',
                'Boîtiers étanches IP67 industriels',
                'Alimentations PoE++ redondées',
                'Matériel sur-mesure selon étude',
            ],
            'services' => [
                'Étude de couverture sur site (gratuit)',
                'Installation multi-points synchronisés',
                'Configuration portail captif centrale',
                'Formation équipe complète',
                'Support prioritaire 24/7 illimité',
                'Monitoring & alertes temps réel',
                'Maintenance préventive annuelle',
                'Garantie matériel 3 ans',
            ],
            'couleur' => '#8B5CF6',
            'populaire' => false,
        ],
    ];
    @endphp
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white dark:from-[#0A0A0C] dark:to-[#111316] py-16 sm:py-24 lg:py-32">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2246%22 height=%2246%22 viewBox=%220 0 46 46%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22none%22/%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22%2310B981%22 fill-opacity=%220.03%22/%3E%3C/svg%3E')] opacity-50"></div>
        <div class="absolute inset-0 -webkit-mask-image:[radial-gradient(ellipse_65%25_55%25_at_50%25_10%25,_black_35%25,_transparent_100%25)] mask-image:[radial-gradient(ellipse_65%25_55%25_at_50%25_10%25,_black_35%25,_transparent_100%25)]">
            <div class="orb w-72 h-72 sm:w-96 sm:h-96 bg-neonGreen/20 dark:bg-neonGreen/25 -top-16 -left-16"></div>
            <div class="orb w-64 h-64 sm:w-80 sm:h-80 bg-neonGreen/10 dark:bg-neonGreen/15 top-1/3 -right-10" style="animation-delay:-6s"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-neonGreen/10 border border-neonGreen/20 text-neonGreen text-xs font-semibold tracking-wider uppercase mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neonGreen opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-neonGreen"></span>
                </span>
                Vous n'avez pas encore de WiFi Zone ?
            </div>
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.08] mb-6">
                Nous installons votre <span class="text-neonGreen text-glow">WiFi Zone</span> clé en main
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto mb-10">
                Matériel professionnel, configuration experte, formation incluse. Vous lancez votre activité, on s'occupe de la technique.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-6 py-4 text-base rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-headset"></i> Demander un devis gratuit
                </a>
                <a href="#packs" class="inline-flex items-center justify-center gap-2 bg-white dark:bg-darkCard/80 hover:bg-slate-100 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white font-bold px-6 py-4 text-base rounded-full transition-all shadow-sm">
                    <i class="fas fa-box-open"></i> Voir nos packs
                </a>
            </div>
        </div>
    </section>

    {{-- Packs --}}
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                @foreach($packs as $pack)
                <div class="relative rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow hover:-translate-y-1 group shadow-sm {{ $pack['populaire'] ? 'ring-2 ring-neonGreen/20' : '' }}">
                    @if($pack['populaire'])
                    <span class="absolute top-0 right-0 bg-neonGreen text-white text-[9px] font-bold uppercase tracking-wide px-3 py-1 rounded-tr-3xl rounded-bl-xl">Le plus choisi</span>
                    @endif

                    <div class="p-6 sm:p-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-6" style="background: {{ $pack['couleur'] }}">
                            @if($pack['id'] === 'starter')
                                <i class="fas fa-seedling"></i>
                            @elseif($pack['id'] === 'pro')
                                <i class="fas fa-rocket"></i>
                            @else
                                <i class="fas fa-building"></i>
                            @endif
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $pack['nom'] }}</h3>
                        <p class="text-slate-600 dark:text-gray-400 text-sm mb-6">{{ $pack['sousTitre'] }}</p>

                        <div class="mb-6">
                            <span class="font-display text-3xl font-extrabold text-slate-900 dark:text-white" style="color: {{ $pack['couleur'] }}">{{ $pack['prix'] }}</span>
                            @if($pack['prixNote'])
                            <span class="text-slate-500 dark:text-gray-500 font-semibold ml-1">{{ $pack['prixNote'] }}</span>
                            @endif
                        </div>

                        <div class="space-y-3 mb-6 border-t border-slate-100 dark:border-darkBorder/40 pt-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500">Équipements fournis</p>
                            <ul class="space-y-2">
                                @foreach($pack['equipements'] as $equip)
                                <li class="flex items-start gap-2 text-sm text-slate-600 dark:text-gray-400">
                                    <i class="fas fa-check text-neonGreen text-[10px] mt-1 shrink-0"></i>
                                    {{ $equip }}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="space-y-3 border-t border-slate-100 dark:border-darkBorder/40 pt-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500">Services inclus</p>
                            <ul class="space-y-2">
                                @foreach($pack['services'] as $service)
                                <li class="flex items-start gap-2 text-sm text-slate-600 dark:text-gray-400">
                                    <i class="fas fa-check text-neonGreen text-[10px] mt-1 shrink-0"></i>
                                    {{ $service }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        @if($pack['id'] === 'enterprise')
                        <a href="{{ route('contact') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-sm transition-all" style="background: {{ $pack['couleur'] }}; color: white">
                            <i class="fas fa-comments"></i> Demander un devis
                        </a>
                        @else
                        <button @click="selectedPack = '{{ $pack['id'] }}'" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-bold text-sm transition-all {{ 'selectedPack === \'' . $pack['id'] . '\' ? \'text-white\' : \'text-slate-700 dark:text-gray-300 bg-slate-100 dark:bg-darkBorder/40 hover:bg-slate-200 dark:hover:bg-darkBorder/60\' }}" :style="selectedPack === '{{ $pack['id'] }}' ? 'background: {{ $pack['couleur'] }}' : ''">
                            <template x-if="selectedPack === '{{ $pack['id'] }}'">
                                <i class="fas fa-check"></i> Pack sélectionné
                            </template>
                            <template x-if="selectedPack !== '{{ $pack['id'] }}'">
                                <i class="fas fa-arrow-right"></i> Choisir ce pack
                            </template>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Processus --}}
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-darkBg/30 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Comment ça se passe</h2>
                <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Un processus simple en 4 étapes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                @php
                $etapes = [
                    ['icon' => 'fas fa-phone-alt', 'titre' => '1. Contact', 'desc' => 'Vous nous appelez ou remplissez le formulaire. On discute de votre zone et vos besoins.'],
                    ['icon' => 'fas fa-map-marked-alt', 'titre' => '2. Étude gratuite', 'desc' => 'On se déplace (ou étude à distance) pour analyser la couverture et valider le matériel.'],
                    ['icon' => 'fas fa-tools', 'titre' => '3. Installation', 'desc' => 'Notre équipe installe, configure le portail captif et teste la couverture.'],
                    ['icon' => 'fas fa-graduation-cap', 'titre' => '4. Formation & Go', 'desc' => 'On vous forme 1-2h, vous repartez avec votre WiFi Zone opérationnelle.'],
                ];
                @endphp
                @foreach($etapes as $index => $etape)
                <div class="relative p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all">
                    @if($index < 3)
                    <div class="hidden lg:block absolute top-10 right-0 w-full h-0.5 bg-slate-200 dark:bg-darkBorder/40"></div>
                    @endif
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-neonGreen text-xl font-bold mb-6" style="background: linear-gradient(135deg, #10B981, #059669)">
                        <i class="{{ $etape['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $etape['titre'] }}</h3>
                    <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed">{{ $etape['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl p-8 sm:p-12 lg:p-16 text-center relative overflow-hidden" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%)">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=%2246%22 height=%2246%22 viewBox=%220 0 46 46%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22none%22/%3E%3Cpath d=%22M46 0H0v46h46V0z%22 fill=%22white%22 fill-opacity=%220.05%22/%3E%3C/svg%3E')]"></div>
                <div class="relative z-10">
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

    {{-- FAQ --}}
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
    function toggleFaq(btn) {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.faq-toggle').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
    }
</script>