<!DOCTYPE html>
<html lang="fr" class="scroll-smooth <?php echo e($themeClass); ?>">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title><?php echo $__env->yieldContent('title', config('platform.name')); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="vendor-nav">
    <?php $vendeurTopbar = auth()->user(); ?>
    <div class="vendor-layout">
        <?php echo $__env->yieldContent('sidebar'); ?>
        <main class="vendor-main">
            <div class="vendor-topbar" x-data="{ showTopbarLogout: false }">
                <?php
    $vendeurTopbar = auth()->user();
    $hotspotService = app(\App\Services\HotspotService::class);
    if ($vendeurTopbar) {
        $hotspotService->freezeExpiredSubscriptions($vendeurTopbar);
    }
    $headerHotspotUsed = $vendeurTopbar ? $hotspotService->usedSlots($vendeurTopbar) : 0;
    $headerHotspotLimit = $vendeurTopbar ? $hotspotService->limit($vendeurTopbar) : 0;
    $headerHotspotRemaining = $vendeurTopbar ? $hotspotService->remaining($vendeurTopbar) : 0;
    $headerHotspotCanCreate = $vendeurTopbar ? $hotspotService->canCreate($vendeurTopbar) : true;
?>
<div class="vendor-topbar-greeting">
    <i class="fas fa-wifi"></i> Salut <?php echo e($vendeurTopbar->prenom ?? ''); ?> 👋
</div>
                <div class="vendor-topbar-actions">
                    <button type="button" class="vendor-topbar-icon" onclick="toggleTheme()" aria-label="Basculer le thème">
                        <i class="fas fa-sun"></i>
                        <i class="fas fa-moon"></i>
                    </button>
                    <button type="button" class="vendor-topbar-icon" @click="showTopbarLogout = true" aria-label="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
                <div x-show="showTopbarLogout" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="showTopbarLogout = false" @keydown.escape.window="showTopbarLogout = false">
                    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/10 text-amber-500 mx-auto mb-4">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Confirmer la déconnexion</h3>
                        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">Voulez-vous vraiment vous déconnecter ?</p>
                        <div class="flex gap-2">
                            <button type="button" @click="showTopbarLogout = false" class="flex-1 whitespace-nowrap bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-2 px-3 rounded-xl transition-all text-xs">Annuler</button>
                            <form method="POST" action="<?php echo e(route('vendor.logout')); ?>" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full whitespace-nowrap bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-2 px-3 rounded-xl shadow-neon-button transition-all text-xs flex items-center justify-center gap-1.5">
                                    <i class="fas fa-sign-out-alt text-[10px] shrink-0"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-overlay" onclick="document.querySelector('.vendor-sidebar').classList.remove('open'); this.classList.remove('active')"></div>
            <?php if (! empty(trim($__env->yieldContent('header')))): ?>
                <div class="vendor-header-static">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="vendor-content" id="vendor-content">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>
    <?php if (isset($component)) { $__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bottom-nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('bottom-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1)): ?>
<?php $attributes = $__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1; ?>
<?php unset($__attributesOriginal91530f48093dbfe9d7d6cfefc4ce84c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1)): ?>
<?php $component = $__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1; ?>
<?php unset($__componentOriginal91530f48093dbfe9d7d6cfefc4ce84c1); ?>
<?php endif; ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('toast');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1405669580-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    <?php if (isset($component)) { $__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f)): ?>
<?php $attributes = $__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f; ?>
<?php unset($__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f)): ?>
<?php $component = $__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f; ?>
<?php unset($__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f); ?>
<?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/layouts/vendor.blade.php ENDPATH**/ ?>