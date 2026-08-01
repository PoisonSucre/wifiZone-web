<?php $__env->startSection('sidebar'); ?> <?php echo $__env->make('components.sidebar-vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('title', 'Retraits'); ?>
<?php $__env->startSection('header'); ?>
<div class="flex items-center gap-2.5 pb-1">
    <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-amber-500 via-amber-500/90 to-orange-400 flex items-center justify-center text-white text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(245,158,11,0.5)]">
        <i class="fas fa-wallet"></i>
        <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
    </div>
    <div class="min-w-0">
        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Finance</p>
        <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Mes Retraits</h2>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vendor.retrait-manager');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-306549630-0', $__key);

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/vendor/retraits.blade.php ENDPATH**/ ?>