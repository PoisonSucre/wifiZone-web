<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['icon' => 'cog', 'color' => 'green']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['icon' => 'cog', 'color' => 'green']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $colorMap = [
        'green' => 'bg-neonGreen/10 text-neonGreen',
        'amber' => 'bg-amber-500/10 text-amber-500',
        'red' => 'bg-red-500/10 text-red-500',
        'blue' => 'bg-blue-500/10 text-blue-500',
        'purple' => 'bg-purple-500/10 text-purple-500',
        'cyan' => 'bg-cyan-500/10 text-cyan-500',
        'slate' => 'bg-slate-400/10 text-slate-400',
        'orange' => 'bg-orange-500/10 text-orange-500',
    ];
    $iconClass = $colorMap[$color] ?? $colorMap['green'];
?>
<div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
    <div class="w-8 h-8 rounded-lg <?php echo e($iconClass); ?> flex items-center justify-center">
        <i class="fas fa-<?php echo e($icon); ?> text-xs"></i>
    </div>
    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white"><?php echo e($slot); ?></h3>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/section-header.blade.php ENDPATH**/ ?>