<div id="scroll-progress-bar" class="fixed top-0 left-0 right-0 h-[3px] z-[60] bg-transparent">
    <div id="scroll-progress-bar-fill" class="h-full bg-neonGreen origin-left scale-x-0 transition-transform duration-150 ease-out shadow-[0_0_10px_rgba(16,185,129,0.6)]"></div>
</div>
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6 px-4 sm:px-6 lg:px-8">
    <div id="header-container" class="max-w-7xl mx-auto rounded-full bg-transparent border border-transparent px-6 py-2.5 flex items-center justify-between transition-all duration-500">
        <a href="/" class="flex items-center gap-1 sm:gap-3 text-[10px] sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow transition-all duration-300 hover:scale-105 whitespace-nowrap shrink-0">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            <?php echo e(config('platform.name')); ?>

        </a>
        <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-semibold">
            <a href="<?php echo e(route('recuperer-ticket')); ?>" class="relative py-2 text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors group flex items-center gap-1.5">
                <i class="fas fa-ticket-alt text-xs opacity-70"></i> Récupérer mon ticket
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
        <a href="<?php echo e(route('recuperer-ticket')); ?>" onclick="toggleMobileMenu()" class="block text-slate-700 dark:text-gray-300 hover:text-neonGreen transition-colors text-xs font-semibold flex items-center gap-2"><i class="fas fa-ticket-alt text-[10px] opacity-70"></i> Récupérer mon ticket</a>
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
</header><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/partials/navbar.blade.php ENDPATH**/ ?>