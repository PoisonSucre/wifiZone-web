<?php $__env->startSection('sidebar'); ?> <?php echo $__env->make('components.sidebar-vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('title', 'Mes Tickets'); ?>
<?php
    $hsId = (int) request()->query('hotspot', 0);
    $activeHotspot = $hsId > 0 ? \App\Models\Hotspot::where('id', $hsId)->where('vendeur_id', auth()->id())->first() : null;
?>
<?php $__env->startSection('header'); ?>
<div class="flex items-center justify-between gap-2 pb-1">
    <div class="flex items-center gap-2.5 min-w-0">
        <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-blue-500 via-blue-500/90 to-blue-400 flex items-center justify-center text-white text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(59,130,246,0.5)]">
            <i class="fas fa-ticket"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div class="min-w-0">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Gestion</p>
            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Mes Tickets</h2>
        </div>
    </div>
    <div class="flex items-center gap-1.5 shrink-0">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeHotspot): ?>
            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-[10px] font-bold border border-neonGreen/20">
                <i class="fas fa-wifi text-[9px]"></i> <?php echo e($activeHotspot->name); ?>

            </span>
        <?php else: ?>
            <a href="<?php echo e(route('vendor.hotspot')); ?>" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 dark:bg-darkBg text-slate-600 dark:text-gray-300 text-[10px] font-bold hover:bg-slate-200 dark:hover:bg-darkBorder transition">
                <i class="fas fa-wifi text-[9px]"></i> <span class="hidden sm:inline">Choisir un hotspot</span><span class="inline sm:hidden">Hotspot</span>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <a href="<?php echo e(route('vendor.import', $hsId > 0 ? ['hotspot' => $hsId] : [])); ?>" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-neonGreen hover:bg-neonGreen-600 text-white text-[10px] font-bold transition-all shadow-sm hover:shadow-md">
            <i class="fas fa-plus text-[9px]"></i> <span class="hidden sm:inline">Ajouter</span>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('vendor.ticket-list');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1195905058-0', $__key);

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

<?php echo $__env->make('layouts.vendor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/vendor/tickets.blade.php ENDPATH**/ ?>