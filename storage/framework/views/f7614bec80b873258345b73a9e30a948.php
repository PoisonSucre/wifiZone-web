<?php
    $links = [
        ['route' => 'vendor.dashboard',     'label' => 'Accueil',      'icon' => 'fa-chart-line',              'url' => '/vendeur'],
        ['route' => 'vendor.hotspot',       'label' => 'Hotspots',     'icon' => 'fa-wifi',                    'url' => '/vendeur/hotspot'],
        ['route' => 'vendor.alertes',       'label' => 'Alertes',      'icon' => 'fa-exclamation-triangle',    'url' => '/vendeur/alertes'],
        ['route' => 'vendor.retraits',      'label' => 'Retraits',     'icon' => 'fa-wallet',                  'url' => '/vendeur/retraits'],
        ['route' => 'vendor.profil',        'label' => 'Profil',       'icon' => 'fa-user',                    'url' => '/vendeur/profil'],
    ];
    $vendeur = auth()->user();
    $retraitsPending = $vendeur ? $vendeur->withdrawals()->where('statut', 'pending')->count() : 0;
    
    $hotspotService = app(\App\Services\HotspotService::class);
    if ($vendeur) {
        $hotspotService->freezeExpiredSubscriptions($vendeur);
    }
    $hotspotRemaining = $vendeur ? $hotspotService->remaining($vendeur) : 0;
    $hotspotCanCreate = $vendeur ? $hotspotService->canCreate($vendeur) : true;
    
    foreach ($links as &$link) {
        if ($link['route'] === 'vendor.retraits' && $retraitsPending > 0) {
            $link['badge'] = $retraitsPending;
            $link['badge_type'] = 'numeric';
        }
        if ($link['route'] === 'vendor.hotspot' && $hotspotCanCreate && $hotspotRemaining > 0) {
            $link['badge'] = '+' . $hotspotRemaining;
            $link['badge_type'] = 'numeric';
        }
    }
    unset($link);
    $activeRoute = Route::currentRouteName();
?>
<nav class="mobile-bottom-nav" aria-label="Navigation mobile">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <?php $isActive = $activeRoute === $link['route']; ?>
        <a href="<?php echo e($link['url']); ?>" wire:navigate class="mbn-item <?php echo e($isActive ? 'active' : ''); ?>">
            <span class="mbn-icon">
                <i class="fas <?php echo e($link['icon']); ?>"></i>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($link['badge'])): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($link['badge_type'] ?? '') === 'hotspot'): ?>
                        <span class="mbn-badge mbn-badge-hotspot"><?php echo e($link['badge']); ?></span>
                    <?php else: ?>
                        <span class="mbn-badge"><?php echo e($link['badge']); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </span>
            <span class="mbn-label"><?php echo e($link['label']); ?></span>
        </a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</nav>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/bottom-nav.blade.php ENDPATH**/ ?>