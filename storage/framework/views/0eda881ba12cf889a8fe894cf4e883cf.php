<?php $__env->startSection('sidebar'); ?> <?php echo $__env->make('components.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('title', 'Admins'); ?>
<?php $__env->startSection('header'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
    <div class="flex items-center gap-3">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 via-teal-500/90 to-emerald-500 flex items-center justify-center text-white text-lg shadow-[0_10px_30px_-10px_rgba(13,148,136,0.55)]">
            <i class="fas fa-user-shield"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Administration</p>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Gestion des admins</h2>
        </div>
    </div>
    <div class="flex items-center gap-2 mt-1 sm:mt-0">
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-[11px] font-bold text-slate-600 dark:text-gray-400">
            <i class="fas fa-calendar-alt text-[10px]"></i>
            <?php echo e(now()->format('d M Y')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.admin-manager');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1626003936-0', $__key);

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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/admin/admins.blade.php ENDPATH**/ ?>