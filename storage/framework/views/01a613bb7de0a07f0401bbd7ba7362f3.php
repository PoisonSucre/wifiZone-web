<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['icon' => 'chart-line', 'color' => 'green', 'label' => '', 'value' => '']));

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

foreach (array_filter((['icon' => 'chart-line', 'color' => 'green', 'label' => '', 'value' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
$colorClass = match($color) {
    'green' => 'stat-green',
    'blue' => 'stat-blue',
    'orange' => 'stat-orange',
    'purple' => 'stat-purple',
    default => 'stat-green',
};
?>
<div <?php echo e($attributes->merge(['class' => "stat-card {$colorClass}"])); ?>>
    <div class="stat-icon"><i class="fas fa-<?php echo e($icon); ?>"></i></div>
    <div class="stat-info">
        <span class="stat-value"><?php echo e($value); ?></span>
        <span class="stat-label"><?php echo e($label); ?></span>
    </div>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/stat-card.blade.php ENDPATH**/ ?>