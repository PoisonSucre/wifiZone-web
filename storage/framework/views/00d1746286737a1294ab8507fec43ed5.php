<?php $__env->startSection('title', config('platform.name') . ' - Monétisez votre WiFi Zone'); ?>

<?php $__env->startSection('navbar'); ?>
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6 px-4 sm:px-6 lg:px-8">
    <div id="header-container" class="max-w-7xl mx-auto rounded-full bg-transparent border border-transparent px-6 py-2.5 flex items-center justify-between transition-all duration-500">
        <a href="/" class="flex items-center gap-1 sm:gap-3 text-[10px] sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow transition-all duration-300 hover:scale-105 whitespace-nowrap shrink-0">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            <?php echo e(config('platform.name')); ?>

        </a>

        <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-semibold">
            <a href="#vendeurs" class="relative py-2 text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors group flex items-center gap-1.5">
                <i class="fas fa-store text-xs opacity-70"></i> Espace Propriétaires
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[2px] bg-neonGreen rounded-full transition-all duration-300 group-hover:w-8"></span>
            </a>
            <a href="#comment-ca-marche" class="relative py-2 text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors group flex items-center gap-1.5">
                <i class="fas fa-circle-question text-xs opacity-70"></i> Comment ça marche
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[2px] bg-neonGreen rounded-full transition-all duration-300 group-hover:w-8"></span>
            </a>
            <a href="<?php echo e(route('contact')); ?>" class="relative py-2 text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors group flex items-center gap-1.5">
                <i class="fas fa-headset text-xs opacity-70"></i> Nous Contacter
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[2px] bg-neonGreen rounded-full transition-all duration-300 group-hover:w-8"></span>
            </a>
        </nav>

        <div class="flex items-center gap-2 sm:gap-4">
            <button id="theme-toggle" onclick="toggleTheme()" class="p-2 sm:p-2.5 rounded-full text-slate-600 dark:text-gray-400 hover:bg-slate-100/55 dark:hover:bg-darkBorder/55 transition-all duration-300" aria-label="Changer de thème">
                <i id="theme-toggle-light-icon" class="fas fa-sun text-amber-500 text-base sm:text-lg hidden dark:inline"></i>
                <i id="theme-toggle-dark-icon" class="fas fa-moon text-base sm:text-lg inline dark:hidden"></i>
            </button>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(auth()->user()->is_admin ? '/raider/' : '/vendeur/'); ?>" class="hidden sm:inline-block px-5 py-2 text-sm font-bold text-white dark:text-white bg-neonGreen hover:bg-neonGreen-400 rounded-full transition-all duration-300 shadow-neon-button">
                    <i class="fas fa-tachometer-alt"></i> Mon Espace
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('vendor.login')); ?>" class="hidden sm:inline-block px-4 py-2 text-sm font-semibold text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white transition-colors duration-300">
                    Connexion
                </a>
                <a href="<?php echo e(route('vendor.register')); ?>" class="relative overflow-hidden bg-neonGreen hover:bg-neonGreen-400 text-white dark:text-white font-bold text-xs sm:text-sm px-4 sm:px-6 py-2.5 rounded-full hover:shadow-[0_0_25px_rgba(16,185,129,0.4)] shadow-neon-button transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 group">
                    <span>S'inscrire</span>
                    <i class="fas fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <button id="mobile-menu-btn" class="p-2 rounded-full md:hidden text-slate-600 dark:text-gray-400 hover:bg-slate-100/55 dark:hover:bg-darkBorder/55 transition-all duration-300" aria-label="Menu Mobile">
                <i class="fas fa-bars text-lg sm:text-xl"></i>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden absolute left-4 right-4 mt-3 rounded-3xl border border-slate-200/60 dark:border-darkBorder/60 bg-white dark:bg-darkBg p-6 space-y-4 shadow-xl transition-all duration-300">
        <a href="#vendeurs" onclick="toggleMobileMenu()" class="block text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors text-xs font-semibold flex items-center gap-2"><i class="fas fa-store text-[10px] opacity-70"></i> Espace Propriétaires</a>
        <a href="#comment-ca-marche" onclick="toggleMobileMenu()" class="block text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors text-xs font-semibold flex items-center gap-2"><i class="fas fa-circle-question text-[10px] opacity-70"></i> Comment ça marche</a>
        <a href="<?php echo e(route('contact')); ?>" onclick="toggleMobileMenu()" class="block text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors text-xs font-semibold flex items-center gap-2"><i class="fas fa-headset text-[10px] opacity-70"></i> Nous Contacter</a>
        <div class="pt-4 border-t border-slate-200/50 dark:border-darkBorder/50 flex flex-col gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(auth()->user()->is_admin ? '/raider/' : '/vendeur/'); ?>" class="w-full text-center py-2.5 text-xs font-bold text-white bg-neonGreen rounded-full hover:bg-neonGreen-400 transition-colors">
                    <i class="fas fa-tachometer-alt"></i> Mon Espace
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('vendor.login')); ?>" class="w-full text-center py-2.5 text-xs font-semibold text-slate-700 dark:text-gray-300 border border-slate-200/55 dark:border-darkBorder/55 rounded-full hover:text-slate-950 dark:hover:text-white transition-colors">
                    Connexion
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="relative overflow-hidden bg-slate-50 dark:bg-[#0A0A0C] pt-32 sm:pt-40 lg:pt-48 pb-12 sm:pb-20 transition-colors duration-300">
    <div class="absolute inset-y-0 right-0 w-full lg:w-1/2 z-0">
        <div class="absolute inset-0 gradient-overlay z-10"></div>
        <div class="absolute inset-x-0 top-0 h-24 sm:h-32 bg-gradient-to-b from-slate-50 dark:from-darkBg to-transparent z-10"></div>
        <div class="absolute inset-x-0 bottom-0 h-24 sm:h-32 bg-gradient-to-t from-slate-50 dark:from-darkBg to-transparent z-10"></div>
        <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&q=80&w=1200"
             alt="WiFi Network Equipment"
             class="w-full h-full object-cover object-center filter grayscale-[30%] opacity-20 sm:opacity-30 lg:opacity-65 brightness-95 dark:brightness-110 contrast-105 transition-all duration-300"
             onerror="this.src='https://placehold.co/800x600/121216/10B981?text=WiFi+Network'">
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-12 sm:pb-20 w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6 sm:space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neonGreen/10 border border-neonGreen/20 text-neonGreen text-xs font-semibold tracking-wider uppercase mx-auto lg:mx-0">
                <span class="w-2 h-2 rounded-full bg-neonGreen animate-ping"></span>
                Solution Automatisée Pour Wi-Fi Zone
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight sm:leading-none">
                Monétisez votre <span class="text-neonGreen text-glow">WiFi Zone</span> en ligne et en toute simplicité
            </h1>

            <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-xl mx-auto lg:mx-0">
                Encaissez instantanément vos clients par Mobile Money (Orange Money, Wave, Moov) sans aucune interruption de service, et pilotez les performances de vos forfaits depuis un tableau de bord puissant.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(auth()->user()->is_admin ? '/raider/' : '/vendeur/'); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-tachometer-alt"></i> Mon Tableau de bord
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('vendor.register')); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-store"></i> Démarrer Maintenant
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="#vendeurs" class="inline-flex items-center justify-center gap-2 bg-white dark:bg-darkCard/80 hover:bg-slate-100 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full transition-all shadow-sm">
                    <i class="fas fa-play"></i> En savoir plus
                </a>
            </div>
        </div>
    </div>
</section>

<section id="vendeurs" class="py-16 sm:py-24 bg-slate-100/50 dark:bg-darkCard/30 relative transition-colors duration-300">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-transparent to-slate-50 dark:from-darkBg dark:to-darkBg pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">La Solution Vendeurs</h2>
            <p class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Transformez votre bande passante en revenus automatisés
            </p>
            <p class="mt-4 text-sm sm:text-lg text-slate-600 dark:text-gray-400">
                Vous possédez un point d'accès WiFi et offrez du réseau à vos clients ? Laissez notre technologie sécurisée gérer la facturation et le suivi à votre place.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow group shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-xl font-bold mb-6 group-hover:bg-neonGreen group-hover:text-black transition-all">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">Encaissement 100% Mobile Money</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-xs sm:text-sm">
                    Plus besoin de manipuler de la monnaie physique ou de gérer des cartes à gratter. Vos clients paient directement via Orange Money, Wave ou Moov.
                </p>
            </div>
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow group shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-xl font-bold mb-6 group-hover:bg-neonGreen group-hover:text-black transition-all">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">Suivi des tickets & données</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-xs sm:text-sm">
                    Analysez vos revenus en temps réel. Suivez l'état de validité de chaque ticket, la consommation data de vos clients et optimisez vos forfaits.
                </p>
            </div>
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow group shadow-sm sm:col-span-2 lg:col-span-1">
                <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-xl font-bold mb-6 group-hover:bg-neonGreen group-hover:text-black transition-all">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">Zéro configuration de port complexe</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-xs sm:text-sm">
                    Importez vos tickets en quelques clics depuis un fichier CSV. Pas de configuration technique complexe, pas de serveur distant à gérer.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="comment-ca-marche" class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Parcours Simple</h2>
            <p class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Comment vos clients accèdent au réseau ?
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl font-black relative shadow-md dark:shadow-neon-glow">
                    1
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">1. Connexion au WiFi Zone</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Le client active son WiFi, sélectionne le hotspot du vendeur le plus proche et le portail captif s'ouvre automatiquement.
                </p>
            </div>
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl font-black relative shadow-md dark:shadow-neon-glow">
                    2
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">2. Paiement Instantané</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Il choisit le forfait de son choix et initie le paiement sécurisé par Mobile Money sans avoir besoin d'accès à d'autres sites.
                </p>
            </div>
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl font-black relative shadow-md dark:shadow-neon-glow">
                    3
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">3. Code Reçu & Connexion</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Une fois validé, sa plateforme lui délivre son code de connexion unique pour surfer instantanément à très haute vitesse !
                </p>
            </div>
        </div>
    </div>
</section>

<section id="modeles" class="py-16 sm:py-24 bg-slate-100/50 dark:bg-darkCard/20 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-neonGreen/10 border border-neonGreen/20 text-neonGreen text-xs font-bold tracking-wider uppercase">
                <i class="fas fa-gift"></i> Inscription 100% Gratuite
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Des modèles de tickets personnalisables
            </h2>
            <p class="text-slate-600 dark:text-gray-400 max-w-2xl mx-auto text-xs leading-relaxed">
                L'inscription et l'accès à notre plateforme sont totalement <strong class="text-slate-900 dark:text-white">gratuits</strong>.
                De plus, chaque vendeur est libre de <strong class="text-neonGreen">personnaliser ses propres tickets</strong>, d'ajuster ses prix et de créer ses propres forfaits.
            </p>
            <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-500 font-semibold uppercase tracking-widest pt-2">
                Exemples de forfaits populaires configurés par nos vendeurs :
            </p>
        </div>

        <div class="flex justify-center mb-10 sm:mb-16">
            <div class="inline-flex p-1.5 bg-slate-200 dark:bg-darkBg rounded-2xl border border-slate-300 dark:border-darkBorder transition-colors">
                <button onclick="switchTemplate('template-digital', this)" class="template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white dark:bg-neonGreen text-slate-900 dark:text-white shadow-sm w-full sm:w-auto">
                    <i class="fas fa-mobile-alt mr-2"></i> Template 1 : Badge Digital
                </button>
                <button onclick="switchTemplate('template-coupon', this)" class="template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white w-full sm:w-auto">
                    <i class="fas fa-ticket-alt mr-2"></i> Template 2 : Ticket Coupon
                </button>
            </div>
        </div>

        <div id="template-digital" class="template-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
            <?php
            $exemples = [
                ['label' => '1 Heure', 'montant' => '150', 'features' => ['Usage ponctuel', 'Débit standard', 'Accès illimité']],
                ['label' => '5 Heures', 'montant' => '250', 'features' => ['Débit amélioré', 'Connexion stable 100%', 'Usage continu']],
                ['label' => '24 Heures', 'montant' => '350', 'features' => ['Débit prioritaire', 'Accès 24h/24', 'Reconnexion libre']],
                ['label' => '3 Jours', 'montant' => '600', 'features' => ['Débit premium', 'Connexion stable', 'Multi-appareils']],
                ['label' => '1 Semaine', 'montant' => '1000', 'features' => ['Débit illimité', 'Support prioritaire', 'Accès VIP']],
            ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $exemples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/40 rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all transform hover:-translate-y-1 hover:shadow-neon-glow relative overflow-hidden group shadow-sm">
                <div class="absolute -top-12 -right-12 w-24 h-24 bg-neonGreen/5 rounded-full filter blur-xl group-hover:bg-neonGreen/10 transition-all"></div>
                <div>
                    <div class="flex items-center justify-between">
                        <i class="fas fa-wifi text-slate-300 dark:text-slate-600 text-xs"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white mt-4"><?php echo e($f['label']); ?></h3>
                </div>
                <div class="my-4 sm:my-6 flex items-baseline gap-1">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight"><?php echo e($f['montant']); ?></span>
                    <span class="text-[10px] sm:text-xs font-semibold text-slate-400 dark:text-gray-500 uppercase"><?php echo e(config('platform.currency', 'XOF')); ?></span>
                </div>
                <ul class="space-y-2 text-[11px] sm:text-xs text-slate-500 dark:text-gray-400 border-t border-slate-100 dark:border-darkBorder/40 pt-3 sm:pt-4 mb-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $f['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-neonGreen text-[10px]"></i> <?php echo e($feat); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
                <div class="bg-slate-50 dark:bg-darkBg/50 border border-slate-100 dark:border-darkBorder/30 rounded-xl p-2.5 sm:p-3 text-center transition-colors">
                    <p class="text-[8px] sm:text-[9px] text-slate-400 dark:text-gray-500 uppercase tracking-widest font-semibold mb-1">Code de connexion</p>
                    <p class="font-mono text-[11px] sm:text-xs font-bold text-slate-800 dark:text-neonGreen tracking-widest">WIFI-<?php echo e(1000 + $index); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div id="template-coupon" class="template-container hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $exemples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white dark:bg-darkCard border-2 border-dashed border-slate-300 dark:border-darkBorder rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all transform hover:-translate-y-1 hover:shadow-neon-glow relative overflow-hidden group shadow-md">
                <div class="absolute top-1/2 -left-3 w-6 h-6 bg-slate-100 dark:bg-[#060608] rounded-full border-r-2 border-dashed border-slate-300 dark:border-darkBorder -translate-y-1/2"></div>
                <div class="absolute top-1/2 -right-3 w-6 h-6 bg-slate-100 dark:bg-[#060608] rounded-full border-l-2 border-dashed border-slate-300 dark:border-darkBorder -translate-y-1/2"></div>
                <div>
                    <div class="text-center border-b border-slate-100 dark:border-darkBorder/40 pb-2 sm:pb-3 mb-3 sm:mb-4">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Pass Wi-Fi Access</p>
                        <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white mt-1"><?php echo e($f['label']); ?></h3>
                    </div>
                </div>
                <div class="my-2 sm:my-3 text-center">
                    <p class="text-xl sm:text-2xl font-black text-neonGreen tracking-tight"><?php echo e($f['montant']); ?> <?php echo e(config('platform.currency', 'XOF')); ?></p>
                </div>
                <div class="space-y-1.5 sm:space-y-2 my-3 sm:my-4 text-center text-[10px] sm:text-[11px] text-slate-500 dark:text-gray-400">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $f['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <p><i class="fas fa-check-circle text-neonGreen mr-1"></i> <?php echo e($feat); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <div class="border-t border-slate-100 dark:border-darkBorder/40 pt-3 sm:pt-4 mt-2 text-center">
                    <p class="text-[8px] sm:text-[9px] text-slate-400 dark:text-gray-500 uppercase tracking-widest font-semibold mb-1">Entrez ce code :</p>
                    <p class="font-mono text-xs sm:text-sm font-bold text-slate-800 dark:text-white bg-slate-100 dark:bg-darkBg/60 py-1.5 rounded-lg tracking-widest border border-slate-200 dark:border-darkBorder/30">
                        ZON-<?php echo e(900 + $index); ?>

                    </p>
                    <div class="flex justify-center mt-2 sm:mt-3 opacity-35 dark:opacity-60">
                        <div class="h-5 sm:h-6 w-3/4 flex justify-center gap-0.5">
                            <div class="bg-slate-900 dark:bg-white w-1 h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[2px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[3px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[1px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[4px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[1px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[3px] h-full"></div>
                            <div class="bg-slate-900 dark:bg-white w-[2px] h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>

<section class="py-16 sm:py-24 relative overflow-hidden bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-neonGreen/5 filter blur-3xl rounded-full scale-75 -translate-y-12"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6 sm:space-y-8">
        <h2 class="text-2xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
            Prêt à rentabiliser votre <span class="text-neonGreen text-glow">WiFi Zone</span> ?
        </h2>
        <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto">
            Rejoignez les dizaines de propriétaires de réseaux Wi-Fi qui automatisent déjà leurs ventes en ligne et suivent facilement leurs gains mensuels.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(auth()->user()->is_admin ? '/raider/' : '/vendeur/'); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-tachometer-alt"></i> Mon Tableau de bord
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('vendor.register')); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                    Devenir Vendeur Maintenant
                </a>
                <a href="<?php echo e(route('vendor.login')); ?>" class="inline-flex items-center justify-center gap-2 bg-slate-100 dark:bg-transparent hover:bg-slate-200 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full transition-all shadow-sm">
                    Se Connecter
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    function toggleMobileMenu() { mobileMenu.classList.toggle('hidden'); }
    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleMobileMenu);

    const mainHeader = document.getElementById('main-header');
    const headerContainer = document.getElementById('header-container');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            mainHeader.classList.remove('py-6');
            mainHeader.classList.add('py-3');
            headerContainer.classList.add('header-scrolled');
        } else {
            mainHeader.classList.remove('py-3');
            mainHeader.classList.add('py-6');
            headerContainer.classList.remove('header-scrolled');
        }
    });
    if (window.scrollY > 20) {
        mainHeader.classList.remove('py-6');
        mainHeader.classList.add('py-3');
        headerContainer.classList.add('header-scrolled');
    }

    function switchTemplate(templateId, clickedBtn) {
        document.querySelectorAll('.template-container').forEach(function(c) { c.classList.add('hidden'); });
        document.getElementById(templateId).classList.remove('hidden');
        document.querySelectorAll('.template-tab-btn').forEach(function(btn) {
            btn.className = 'template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white w-full sm:w-auto';
        });
        clickedBtn.className = 'template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white dark:bg-neonGreen text-slate-900 dark:text-white shadow-sm w-full sm:w-auto';
    }

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/pages/landing.blade.php ENDPATH**/ ?>