<?php
$skeletonLinks = [
    'vendor.dashboard',
    'vendor.tickets',
    'vendor.boutique',
    'vendor.hotspot',
    'vendor.import',
    'vendor.retraits',
    'vendor.profil',
];
?>

<div class="sidebar-skeleton" id="sidebar-skeleton">
    <div class="skeleton-header">
        <div class="skeleton-logo"></div>
        <div class="skeleton-brand"></div>
    </div>
    <div class="skeleton-nav">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $skeletonLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="skeleton-link">
            <div class="skeleton-icon"></div>
            <div class="skeleton-text"></div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    <div class="skeleton-footer">
        <div class="skeleton-btn"></div>
        <div class="skeleton-btn"></div>
    </div>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/sidebar-skeleton-vendor.blade.php ENDPATH**/ ?>