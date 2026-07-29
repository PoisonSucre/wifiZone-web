<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id' => 'confirm-modal', 'title' => 'Confirmation', 'message' => 'Êtes-vous sûr ?', 'confirmAction' => '', 'confirmText' => 'Confirmer']));

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

foreach (array_filter((['id' => 'confirm-modal', 'title' => 'Confirmation', 'message' => 'Êtes-vous sûr ?', 'confirmAction' => '', 'confirmText' => 'Confirmer']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="<?php echo e($id); ?>" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('<?php echo e($id); ?>', false)"></div>
        <div class="relative bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-xl shadow-xl max-w-md w-full mx-auto p-6 z-10">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2"><?php echo e($title); ?></h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6"><?php echo e($message); ?></p>
            <?php echo e($slot); ?>

        </div>
    </div>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/confirm-modal.blade.php ENDPATH**/ ?>