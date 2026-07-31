<?php $__env->startSection('title', config('platform.name') . ' - Monétisez votre WiFi Zone'); ?>

<?php $__env->startSection('showAnchor', true); ?>

<?php $__env->startSection('navbar'); ?>
    <?php if (isset($component)) { $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-public','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $attributes = $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $component = $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>




<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap');

    .font-display{ font-family:'Sora',ui-sans-serif,system-ui,sans-serif; letter-spacing:-0.025em; }
    .font-body{ font-family:'Manrope',ui-sans-serif,system-ui,sans-serif; }

    /* Ambient network grid backdrop */
    .grid-pattern{
        background-image:
            linear-gradient(to right, rgba(16,185,129,0.07) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(16,185,129,0.07) 1px, transparent 1px);
        background-size: 46px 46px;
        -webkit-mask-image: radial-gradient(ellipse 65% 55% at 50% 10%, black 35%, transparent 100%);
        mask-image: radial-gradient(ellipse 65% 55% at 50% 10%, black 35%, transparent 100%);
    }
    .dark .grid-pattern{
        background-image:
            linear-gradient(to right, rgba(16,185,129,0.10) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(16,185,129,0.10) 1px, transparent 1px);
    }

    @keyframes orb-float{ 0%,100%{ transform:translate(0,0) scale(1); } 50%{ transform:translate(24px,-28px) scale(1.06); } }
    .orb{ position:absolute; border-radius:9999px; filter:blur(64px); animation:orb-float 15s ease-in-out infinite; pointer-events:none; }

    @keyframes signal-travel{
        0%{ left:-6%; opacity:0; }
        12%{ opacity:1; }
        88%{ opacity:1; }
        100%{ left:104%; opacity:0; }
    }
    .signal-dot{ position:absolute; top:50%; width:9px; height:9px; margin-top:-4.5px; border-radius:9999px; background:#10B981; box-shadow:0 0 14px 3px rgba(16,185,129,.65); animation:signal-travel 3.4s linear infinite; }

    @keyframes marquee-scroll{ from{ transform:translateX(0); } to{ transform:translateX(-50%); } }
    .marquee-track{ display:flex; width:max-content; animation:marquee-scroll 28s linear infinite; }
    .marquee-wrap:hover .marquee-track{ animation-play-state:paused; }

    @keyframes float-y{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-12px); } }
    .float-y{ position:relative; animation:float-y 5.5s ease-in-out infinite; }

    @keyframes ticker-pop{
        0%, 100%{ opacity:0; transform:translateY(6px) scale(.97); }
        10%, 85%{ opacity:1; transform:translateY(0) scale(1); }
    }
    .ticker-pop{ animation:ticker-pop 5s ease-in-out infinite; }

    /* Phone mockup — the product itself, front and center */
    .phone-frame{
        position:relative; width:272px; max-width:78vw; margin:0 auto;
        border-radius:2.4rem; padding:12px;
        background:linear-gradient(160deg,#22262a,#0a0b0c);
        box-shadow:0 35px 70px -25px rgba(0,0,0,.55), 0 0 0 1px rgba(16,185,129,.18);
    }
    .phone-notch{ position:absolute; top:12px; left:50%; transform:translateX(-50%); width:86px; height:18px; background:#0a0b0c; border-radius:0 0 12px 12px; z-index:5; }
    .phone-screen{ position:relative; border-radius:1.7rem; overflow:hidden; background:#f8fafc; min-height:440px; }
    .phone-state{ position:absolute; inset:0; padding:30px 18px 18px; opacity:0; transform:translateY(12px); transition:opacity .5s ease, transform .5s ease; pointer-events:none; }
    .phone-state.active{ opacity:1; transform:translateY(0); pointer-events:auto; }

    /* FAQ accordion */
    .faq-panel{ max-height:0; overflow:hidden; transition:max-height .4s ease; }
    .faq-toggle[aria-expanded="true"] + .faq-panel{ max-height:240px; }
    .faq-icon{ transition:transform .3s ease; }
    .faq-toggle[aria-expanded="true"] .faq-icon{ transform:rotate(45deg); }

    /* Browser chrome mock for the dashboard preview */
    .browser-chrome{ border-radius:1.25rem; overflow:hidden; background:#fff; box-shadow:0 40px 80px -30px rgba(0,0,0,.35); }
    .dark .browser-chrome{ background:#101114; }

    @media (prefers-reduced-motion: reduce){
        .orb, .signal-dot, .marquee-track, .float-y, .ticker-pop{ animation:none !important; }
    }
</style>




<section class="relative overflow-hidden bg-slate-50 dark:bg-[#0A0A0C] pt-32 sm:pt-40 lg:pt-48 pb-16 sm:pb-24 transition-colors duration-300">
    <div class="absolute inset-0 grid-pattern"></div>
    <div class="orb w-72 h-72 sm:w-96 sm:h-96 bg-neonGreen/20 dark:bg-neonGreen/25 -top-16 -left-16"></div>
    <div class="orb w-64 h-64 sm:w-80 sm:h-80 bg-neonGreen/10 dark:bg-neonGreen/15 top-1/3 -right-10" style="animation-delay:-6s"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        
        <div class="space-y-6 sm:space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neonGreen/10 border border-neonGreen/20 text-neonGreen text-xs font-semibold tracking-wider uppercase mx-auto lg:mx-0">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neonGreen opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-neonGreen"></span>
                </span>
                Solution Automatisée Pour Wi-Fi Zone
            </div>
            <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.08]">
                Monétisez votre <span class="text-neonGreen text-glow">WiFi Zone</span> en ligne
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-xl mx-auto lg:mx-0">
                Encaissez instantanément vos clients par Mobile Money (Orange Money, Wave, Moov) sans aucune interruption de service, et pilotez les performances de vos forfaits depuis un tableau de bord puissant.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e('/vendeur/'); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-tachometer-alt"></i> Mon Tableau de bord
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('vendor.register')); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-store"></i> Démarrer Maintenant
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('installation')); ?>" class="inline-flex items-center justify-center gap-2 bg-white dark:bg-darkCard/80 hover:bg-slate-100 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full transition-all shadow-sm flex items-center gap-2 group">
                    <i class="fas fa-wifi text-xs"></i> Besoin d'un WifiZone (installation)
                    <i class="fas fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>

            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 max-w-xl mx-auto lg:mx-0 border-t border-slate-200/70 dark:border-darkBorder/40">
                <div class="pt-6 text-center lg:text-left">
                    <p class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white"><span class="stat-counter" data-target="20" data-decimals="0">0</span>+</p>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-500 font-semibold uppercase tracking-wide mt-1">Vendeurs actifs</p>
                </div>
                <div class="pt-6 text-center lg:text-left">
                    <p class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white"><span class="stat-counter" data-target="2" data-decimals="1">0</span>K+</p>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-500 font-semibold uppercase tracking-wide mt-1">Tickets vendus</p>
                </div>
                <div class="pt-6 text-center lg:text-left">
                    <p class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white"><span class="stat-counter" data-target="98" data-decimals="0">0</span>%</p>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-500 font-semibold uppercase tracking-wide mt-1">Disponibilité</p>
                </div>
            </div>
        </div>

        
        <div class="relative hidden lg:block text-right">
            <div class="relative float-y inline-block text-left">
                <div class="phone-frame">
                    <div class="phone-notch"></div>
                    <div class="phone-screen">
                        
                        <div class="phone-state active" data-phone-state>
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Portail Captif</p>
                                    <p class="text-xs font-bold text-slate-800">Ouaga_WiFi_Zone</p>
                                </div>
                                <i class="fas fa-wifi text-neonGreen"></i>
                            </div>
                            <p class="text-[10px] font-semibold text-slate-500 mb-2 uppercase tracking-wide">Choisissez un forfait</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border border-slate-200 text-[11px] text-slate-600">
                                    <span>1 Heure</span><span class="font-bold text-slate-700">150 FCFA</span>
                                </div>
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border-2 border-neonGreen bg-neonGreen/5 text-[11px] text-slate-800">
                                    <span class="font-bold flex items-center gap-1.5"><i class="fas fa-check-circle text-neonGreen"></i> 24 Heures</span><span class="font-bold text-neonGreen">350 FCFA</span>
                                </div>
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border border-slate-200 text-[11px] text-slate-600">
                                    <span>1 Semaine</span><span class="font-bold text-slate-700">1000 FCFA</span>
                                </div>
                            </div>
                            <div class="mt-5 w-full py-2.5 rounded-xl bg-slate-900 text-white text-center text-[11px] font-bold">Continuer</div>
                        </div>
                        
                        <div class="phone-state" data-phone-state>
                            <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-1">Étape 2/3</p>
                            <p class="text-xs font-bold text-slate-800 mb-4">Choisissez votre moyen de paiement</p>
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl border-2 border-neonGreen bg-neonGreen/5">
                                    <img src="/template/orange.png" alt="Orange Money" class="h-6 max-w-[50px] object-contain">
                                    <span class="text-[11px] font-bold text-slate-800">Orange Money</span>
                                    <i class="fas fa-check-circle text-neonGreen text-xs ml-auto"></i>
                                </div>
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl border border-slate-200">
                                    <img src="/template/wave.png" alt="Wave" class="h-6 max-w-[60px] object-contain">
                                </div>
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl border border-slate-200">
                                    <img src="/template/moov.png" alt="Moov Money" class="h-6 max-w-[50px] object-contain">
                                    <span class="text-[11px] font-semibold text-slate-500">Moov Money</span>
                                </div>
                            </div>
                            <div class="mt-5 flex items-center justify-between px-1">
                                <span class="text-[10px] text-slate-500 uppercase font-semibold">Total</span>
                                <span class="text-sm font-black text-slate-900">350 FCFA</span>
                            </div>
                            <div class="mt-3 w-full py-2.5 rounded-xl bg-slate-900 text-white text-center text-[11px] font-bold">Payer maintenant</div>
                        </div>
                        
                        <div class="phone-state" data-phone-state>
                            <div class="flex flex-col items-center text-center pt-6">
                                <div class="w-14 h-14 rounded-full bg-neonGreen/10 flex items-center justify-center text-neonGreen text-2xl mb-4">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Vos identifiants</p>
                                <div class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-3">
                                    <div class="flex items-center gap-3 text-left">
                                        <div class="w-8 h-8 rounded-full bg-neonGreen/10 flex items-center justify-center text-neonGreen text-[11px] shrink-0">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-semibold">Utilisateur</p>
                                            <p class="font-mono text-sm font-bold text-slate-900">wifi2025</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-left">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-[11px] shrink-0">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-semibold">Mot de passe</p>
                                            <p class="font-mono text-sm font-bold text-slate-900">24533</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="mt-4 w-full py-2.5 rounded-xl bg-slate-900 text-white text-[11px] font-bold flex items-center justify-center gap-2">
                                    <i class="fas fa-download"></i> Télécharger la facture
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="hidden sm:block absolute -left-16 top-10 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl px-4 py-3 shadow-xl " style="animation-delay:-2.5s">
                    <p class="text-[9px] font-semibold text-white uppercase tracking-wide flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Service Actif</p>
                    <p class="font-display text-lg font-extrabold text-white mt-0.5">24h/7J</p>
                </div>

                
                <div class="hidden sm:flex absolute -right-6 -bottom-4 items-center gap-2 bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-2xl px-4 py-2.5 shadow-xl ticker-pop">
                    <i class="fas fa-bolt text-neonGreen text-xs"></i>
                    <p class="text-[10px] font-bold text-slate-700 dark:text-gray-300">Nouveau ticket vendu</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-6 sm:py-8 bg-white dark:bg-darkBg border-y border-slate-100 dark:border-darkBorder/30 transition-colors duration-300 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center gap-4 sm:gap-8">
        <p class="text-[10px] sm:text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500 shrink-0">Compatible avec</p>
        <div class="marquee-wrap relative overflow-hidden flex-1 [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
            <div class="marquee-track gap-10 sm:gap-14 items-center">
                <?php
                $items = [
                    ['type' => 'img', 'src' => '/template/orange.png', 'alt' => 'Orange Money', 'label' => 'Orange Money'],
                    ['type' => 'img', 'src' => '/template/wave.png', 'alt' => 'Wave', 'label' => 'Wave'],
                    ['type' => 'img', 'src' => '/template/moov.png', 'alt' => 'Moov Money', 'label' => 'Moov Money'],
                    ['type' => 'img', 'src' => '/template/mikrotik.svg', 'alt' => 'MikroTik', 'label' => 'Routeurs Mikrotik'],
                ];
                $items = array_merge($items, $items);
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="flex items-center gap-2.5 text-slate-500 dark:text-gray-500 shrink-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['type'] === 'img'): ?>
                        <img src="<?php echo e($item['src']); ?>" alt="<?php echo e($item['alt']); ?>" class="h-5 sm:h-6 max-w-[80px] sm:max-w-[100px] object-contain">
                    <?php else: ?>
                        <i class="fas <?php echo e($item['icon']); ?> text-neonGreen/80"></i>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($item['label'], ['Routeurs Mikrotik', 'Wave'])): ?>
                    <span class="text-xs sm:text-sm font-bold whitespace-nowrap"><?php echo e($item['label']); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>
</section>




<section id="vendeurs" class="py-16 sm:py-24 bg-slate-100/50 dark:bg-darkCard/30 relative transition-colors duration-300">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-transparent to-slate-50 dark:from-darkBg dark:to-darkBg pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">La Solution Vendeurs</h2>
            <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Transformez votre bande passante en revenus automatisés
            </p>
            <p class="mt-4 text-sm sm:text-lg text-slate-600 dark:text-gray-400">
                Vous possédez un point d'accès WiFi et offrez du réseau à vos clients ? Laissez notre technologie sécurisée gérer la facturation et le suivi à votre place.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-14 sm:mb-20">
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow hover:-translate-y-1 group shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-xl font-bold mb-6 group-hover:bg-neonGreen group-hover:text-black transition-all">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">Encaissement 100% Mobile Money</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-xs sm:text-sm">
                    Plus besoin de manipuler de la monnaie physique ou de gérer des cartes à gratter. Vos clients paient directement via Orange Money, Wave ou Moov.
                </p>
            </div>
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow hover:-translate-y-1 group shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-xl font-bold mb-6 group-hover:bg-neonGreen group-hover:text-black transition-all">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3">Suivi des tickets & données</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed text-xs sm:text-sm">
                    Analysez vos revenus en temps réel. Suivez l'état de validité de chaque ticket, la consommation data de vos clients et optimisez vos forfaits.
                </p>
            </div>
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 transition-all hover:shadow-neon-glow hover:-translate-y-1 group shadow-sm sm:col-span-2 lg:col-span-1">
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
            <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Comment vos clients accèdent au réseau ?
            </p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">
            <div class="hidden lg:block absolute top-7 left-[16.5%] right-[16.5%] h-px bg-slate-200 dark:bg-darkBorder/60 overflow-visible">
                <span class="signal-dot"></span>
                <span class="signal-dot" style="animation-delay:-1.7s"></span>
            </div>
            <div class="flex flex-col items-center text-center space-y-4 relative">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl relative shadow-md dark:shadow-neon-glow z-10">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">1. Connexion au WiFi Zone</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Le client active son WiFi, sélectionne le hotspot du vendeur le plus proche et le portail captif s'ouvre automatiquement.
                </p>
            </div>
            <div class="flex flex-col items-center text-center space-y-4 relative">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl relative shadow-md dark:shadow-neon-glow z-10">
                    <i class="fas fa-mobile-screen-button"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">2. Paiement Instantané</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Il choisit le forfait de son choix et initie le paiement sécurisé par Mobile Money sans avoir besoin d'accès à d'autres sites.
                </p>
            </div>
            <div class="flex flex-col items-center text-center space-y-4 relative">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder flex items-center justify-center text-neonGreen text-xl sm:text-2xl relative shadow-md dark:shadow-neon-glow z-10">
                    <i class="fas fa-unlock"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">3. Code Reçu & Connexion</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Une fois validé, sa plateforme lui délivre son code de connexion unique pour surfer instantanément à très haute vitesse !
                </p>
            </div>
        </div>
    </div>
</section>




<section class="py-16 sm:py-24 bg-slate-100/50 dark:bg-darkCard/20 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-5 text-center lg:text-left order-2 lg:order-1">
                <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase">Pilotage Vendeur</h2>
                <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Un tableau de bord pensé pour décider vite
                </p>
                <p class="text-sm sm:text-base text-slate-600 dark:text-gray-400 max-w-lg mx-auto lg:mx-0">
                    Revenus du jour, tickets vendus, taux de reconnexion : toutes vos données commerciales sont centralisées et actualisées en direct, sans rapport à demander à personne.
                </p>
                <ul class="space-y-3 text-sm text-slate-700 dark:text-gray-300 font-medium max-w-lg mx-auto lg:mx-0 pt-2">
                    <li class="flex items-center gap-3 justify-center lg:justify-start"><i class="fas fa-check-circle text-neonGreen"></i> Historique complet de chaque transaction Mobile Money</li>
                    <li class="flex items-center gap-3 justify-center lg:justify-start"><i class="fas fa-check-circle text-neonGreen"></i> Export comptable en un clic</li>
                    <li class="flex items-center gap-3 justify-center lg:justify-start"><i class="fas fa-check-circle text-neonGreen"></i> Alertes automatiques en cas d'anomalie</li>
                </ul>
            </div>
            <div class="order-1 lg:order-2">
                <div class="browser-chrome border border-slate-200 dark:border-darkBorder">
                    <div class="flex items-center gap-1.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/50 bg-slate-50 dark:bg-darkBg/60">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-400/70"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400/70"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-neonGreen/70"></span>
                        <span class="ml-3 text-[10px] text-slate-400 dark:text-gray-500 font-mono">vendeur.<?php echo e(config('platform.name') ? \Illuminate\Support\Str::slug(config('platform.name')) : 'plateforme'); ?>.com/dashboard</span>
                    </div>
                    <div class="p-4 sm:p-6 space-y-5">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-xl border border-slate-100 dark:border-darkBorder/40 p-3">
                                <p class="text-[9px] uppercase font-bold text-slate-400 dark:text-gray-500 tracking-wide">Revenus / jour</p>
                                <p class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">45 200 <span class="text-[9px] font-semibold text-neonGreen">+12%</span></p>
                            </div>
                            <div class="rounded-xl border border-slate-100 dark:border-darkBorder/40 p-3">
                                <p class="text-[9px] uppercase font-bold text-slate-400 dark:text-gray-500 tracking-wide">Tickets vendus</p>
                                <p class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">128</p>
                            </div>
                            <div class="rounded-xl border border-slate-100 dark:border-darkBorder/40 p-3">
                                <p class="text-[9px] uppercase font-bold text-slate-400 dark:text-gray-500 tracking-wide">Reconnexion</p>
                                <p class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">94%</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-100 dark:border-darkBorder/40 p-3">
                            <svg viewBox="0 0 300 90" class="w-full h-20" preserveAspectRatio="none">
                                <polyline points="0,70 40,60 80,65 120,40 160,48 200,20 240,30 300,10" fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <polygon points="0,70 40,60 80,65 120,40 160,48 200,20 240,30 300,10 300,90 0,90" fill="#10B981" opacity="0.08"/>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-[11px] px-1">
                                <span class="text-slate-500 dark:text-gray-500 font-mono">•••• 07 82</span>
                                <span class="text-slate-700 dark:text-gray-300 font-semibold">350 FCFA</span>
                                <span class="px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen text-[9px] font-bold">Payé</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] px-1">
                                <span class="text-slate-500 dark:text-gray-500 font-mono">•••• 45 19</span>
                                <span class="text-slate-700 dark:text-gray-300 font-semibold">1000 FCFA</span>
                                <span class="px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen text-[9px] font-bold">Payé</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] px-1">
                                <span class="text-slate-500 dark:text-gray-500 font-mono">•••• 91 03</span>
                                <span class="text-slate-700 dark:text-gray-300 font-semibold">150 FCFA</span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-400/10 text-amber-500 text-[9px] font-bold">En attente</span>
                            </div>
                        </div>
                    </div>
                </div>
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
            <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
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
            <div class="relative bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/40 rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all transform hover:-translate-y-1 hover:shadow-neon-glow overflow-hidden group shadow-sm">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index === 2): ?>
                <span class="absolute top-0 right-0 bg-neonGreen text-white text-[9px] font-bold uppercase tracking-wide px-3 py-1 rounded-bl-xl">Populaire</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
            <div class="relative bg-white dark:bg-darkCard border-2 border-dashed border-slate-300 dark:border-darkBorder rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all transform hover:-translate-y-1 hover:shadow-neon-glow overflow-hidden group shadow-md">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index === 2): ?>
                <span class="absolute top-0 right-0 bg-neonGreen text-white text-[9px] font-bold uppercase tracking-wide px-3 py-1 rounded-bl-xl">Populaire</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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




<section class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Ils l'utilisent déjà</h2>
            <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Des vendeurs qui ont repris le contrôle de leurs revenus
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-50 dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 hover:shadow-neon-glow transition-all">
                <div class="flex items-center gap-1 text-neonGreen text-xs mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed mb-6">« Avant, je perdais du temps à rendre la monnaie et à réimprimer des cartes. Maintenant tout se fait tout seul, même quand je ne suis pas sur place. »</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-neonGreen/10 text-neonGreen font-bold flex items-center justify-center text-sm">IK</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Ibrahim K.</p>
                        <p class="text-[11px] text-slate-500 dark:text-gray-500">Cybercafé, Ouagadougou</p>
                    </div>
                </div>
            </div>
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-50 dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 hover:shadow-neon-glow transition-all">
                <div class="flex items-center gap-1 text-neonGreen text-xs mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed mb-6">« Mes clients paient avec le mobile money qu'ils ont déjà l'habitude d'utiliser. Le tableau de bord me montre exactement combien j'ai gagné chaque soir. »</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-neonGreen/10 text-neonGreen font-bold flex items-center justify-center text-sm">AS</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Aminata S.</p>
                        <p class="text-[11px] text-slate-500 dark:text-gray-500">Maquis WiFi, Bobo-Dioulasso</p>
                    </div>
                </div>
            </div>
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-50 dark:bg-darkCard border border-slate-200 dark:border-darkBorder hover:border-neonGreen/30 hover:shadow-neon-glow transition-all sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-1 text-neonGreen text-xs mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed mb-6">« L'import CSV m'a évité de tout ressaisir manuellement. En dix minutes, mes deux points d'accès étaient déjà en vente. »</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-neonGreen/10 text-neonGreen font-bold flex items-center justify-center text-sm">RT</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Rasmané T.</p>
                        <p class="text-[11px] text-slate-500 dark:text-gray-500">Hôtel, Koudougou</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="py-16 sm:py-24 bg-slate-100/50 dark:bg-darkCard/20 transition-colors duration-300">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14">
            <h2 class="text-xs sm:text-sm font-semibold text-neonGreen tracking-widest uppercase mb-3">Questions Fréquentes</h2>
            <p class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Tout ce qu'il faut savoir avant de commencer
            </p>
        </div>
        <div class="space-y-3">
            <?php
            $faqs = [
                ['q' => 'Quels moyens de paiement mes clients peuvent-ils utiliser ?', 'a' => 'Orange Money, Wave et Moov Money sont pris en charge nativement. Vos clients paient depuis leur propre téléphone, sans créer de compte supplémentaire.'],
                ['q' => 'Dois-je changer mon routeur ou mon installation actuelle ?', 'a' => 'Non. La plateforme s\'intègre à votre équipement existant (Mikrotik) sans configuration technique complexe.'],
                ['q' => 'Puis-je personnaliser mes forfaits, mes prix et mes tickets ?', 'a' => 'Oui, entièrement. Chaque vendeur définit librement la durée, le prix et le visuel de ses tickets, et peut en créer autant qu\'il le souhaite.'],
                ['q' => 'Que se passe-t-il si un client perd son ticket ?', 'a' => 'Il peut récupérer son code de connexion à tout moment depuis la page "Récupérer mon ticket" en indiquant le numéro utilisé pour le paiement.'],
                ['q' => 'L\'inscription et l\'accès à la plateforme sont-ils vraiment gratuits ?', 'a' => 'Oui, la création de compte vendeur et l\'accès au tableau de bord sont gratuits, sans engagement ni abonnement mensuel caché.'],
            ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="rounded-2xl bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder overflow-hidden">
                <button type="button" onclick="toggleFaq(this)" aria-expanded="false" class="faq-toggle w-full flex items-center justify-between gap-4 px-5 sm:px-6 py-4 sm:py-5 text-left">
                    <span class="text-sm sm:text-base font-bold text-slate-900 dark:text-white"><?php echo e($faq['q']); ?></span>
                    <i class="faq-icon fas fa-plus text-neonGreen text-sm shrink-0"></i>
                </button>
                <div class="faq-panel">
                    <p class="px-5 sm:px-6 pb-4 sm:pb-5 text-sm text-slate-600 dark:text-gray-400 leading-relaxed"><?php echo e($faq['a']); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>




<section class="py-16 sm:py-24 relative overflow-hidden bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="absolute inset-0 grid-pattern"></div>
    <div class="orb w-80 h-80 bg-neonGreen/10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 scale-125"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6 sm:space-y-8">
        <h2 class="font-display text-2xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
            Prêt à rentabiliser votre <span class="text-neonGreen text-glow">WiFi Zone</span> ?
        </h2>
        <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto">
            Rejoignez les dizaines de propriétaires de réseaux Wi-Fi qui automatisent déjà leurs ventes en ligne et suivent facilement leurs gains mensuels.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e('/vendeur/'); ?>" class="inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 sm:px-5 sm:py-4 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
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
    // --- Mobile menu (existing behaviour) ---
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    function toggleMobileMenu() { mobileMenu.classList.toggle('hidden'); }
    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleMobileMenu);

    // --- Header shrink-on-scroll (existing behaviour) ---
    const mainHeader = document.getElementById('main-header');
    const headerContainer = document.getElementById('header-container');
    function applyHeaderScrollState() {
        if (window.scrollY > 20) {
            mainHeader.classList.remove('py-6');
            mainHeader.classList.add('py-3');
            headerContainer.classList.add('header-scrolled');
        } else {
            mainHeader.classList.remove('py-3');
            mainHeader.classList.add('py-6');
            headerContainer.classList.remove('header-scrolled');
        }
    }
    window.addEventListener('scroll', applyHeaderScrollState);
    applyHeaderScrollState();

    // --- Scroll progress bar ---
    function updateScrollProgress() {
        const doc = document.documentElement;
        const scrollTop = doc.scrollTop || document.body.scrollTop;
        const scrollHeight = doc.scrollHeight - doc.clientHeight;
        const progress = scrollHeight > 0 ? Math.min(scrollTop / scrollHeight, 1) : 0;
        const fill = document.getElementById('scroll-progress-bar-fill');
        if (fill) fill.style.transform = 'scaleX(' + progress + ')';
    }
    window.addEventListener('scroll', updateScrollProgress);
    updateScrollProgress();

    // --- Pricing template switcher (existing behaviour) ---
    function switchTemplate(templateId, clickedBtn) {
        document.querySelectorAll('.template-container').forEach(function(c) { c.classList.add('hidden'); });
        document.getElementById(templateId).classList.remove('hidden');
        document.querySelectorAll('.template-tab-btn').forEach(function(btn) {
            btn.className = 'template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white w-full sm:w-auto';
        });
        clickedBtn.className = 'template-tab-btn px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white dark:bg-neonGreen text-slate-900 dark:text-white shadow-sm w-full sm:w-auto';
    }

    // --- Stat counters (count up on scroll into view) ---
    function initStatCounters() {
        const counters = document.querySelectorAll('.stat-counter');
        if (!counters.length || !('IntersectionObserver' in window)) return;
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                if (el.dataset.done) return;
                el.dataset.done = '1';
                const target = parseFloat(el.dataset.target || '0');
                const decimals = parseInt(el.dataset.decimals || '0', 10);
                const duration = 1600;
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

    // --- Phone mockup: cycle through captive-portal states ---
    function initPhoneCycler() {
        const states = document.querySelectorAll('[data-phone-state]');
        if (!states.length) return;
        let idx = 0;
        setInterval(function() {
            states[idx].classList.remove('active');
            idx = (idx + 1) % states.length;
            states[idx].classList.add('active');
        }, 3800);
    }

    // --- FAQ accordion ---
    function toggleFaq(btn) {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.faq-toggle').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
    }

    document.addEventListener('DOMContentLoaded', function() {
        initStatCounters();
        initPhoneCycler();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/pages/landing.blade.php ENDPATH**/ ?>