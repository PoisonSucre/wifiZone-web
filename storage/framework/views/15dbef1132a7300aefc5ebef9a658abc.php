<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'show' => false,
    'onClose' => '',
    'icon' => 'plus',
    'iconBg' => 'green',
    'title' => '',
    'subtitle' => '',
    'maxWidth' => 'sm',
]));

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

foreach (array_filter(([
    'show' => false,
    'onClose' => '',
    'icon' => 'plus',
    'iconBg' => 'green',
    'title' => '',
    'subtitle' => '',
    'maxWidth' => 'sm',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $iconMap = [
        'green' => 'bg-neonGreen/10 text-neonGreen',
        'amber' => 'bg-amber-500/10 text-amber-500',
        'red' => 'bg-red-100 dark:bg-red-500/10 text-red-500',
        'blue' => 'bg-blue-500/10 text-blue-500',
        'purple' => 'bg-purple-500/10 text-purple-500',
        'cyan' => 'bg-cyan-500/10 text-cyan-500',
        'slate' => 'bg-slate-100 dark:bg-darkBg text-slate-400',
    ];
    $iconClass = $iconMap[$iconBg] ?? $iconMap['green'];
    $widthClass = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-sm',
    };
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show): ?>
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     <?php if($onClose): ?> wire:click="<?php echo e($onClose); ?>" <?php endif; ?>>
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 <?php echo e($widthClass); ?> w-full"
         onclick="event.stopPropagation()">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($icon): ?>
        <div class="flex items-center justify-center w-12 h-12 rounded-full <?php echo e($iconClass); ?> mx-auto mb-4">
            <i class="fas fa-<?php echo e($icon); ?>"></i>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($title): ?>
        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1"><?php echo e($title); ?></h3>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subtitle): ?>
        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5"><?php echo e($subtitle); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php echo e($slot); ?>

    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/modal.blade.php ENDPATH**/ ?>