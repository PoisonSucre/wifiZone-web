<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id' => 'logout-confirm-modal', 'title' => 'Confirmer la déconnexion', 'message' => 'Voulez-vous vraiment vous déconnecter ?', 'confirmText' => 'Se déconnecter', 'cancelText' => 'Annuler', 'formRef' => 'logoutForm', 'color' => 'amber', 'open' => false]));

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

foreach (array_filter((['id' => 'logout-confirm-modal', 'title' => 'Confirmer la déconnexion', 'message' => 'Voulez-vous vraiment vous déconnecter ?', 'confirmText' => 'Se déconnecter', 'cancelText' => 'Annuler', 'formRef' => 'logoutForm', 'color' => 'amber', 'open' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="{ open: <?php echo \Illuminate\Support\Js::from($attributes->get('open', false))->toHtml() ?> }" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="$dispatch('close')" @keydown.escape.window="$dispatch('close')" @close.window="open = false">
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-<?php echo e($color); ?>-100 dark:bg-<?php echo e($color); ?>-500/10 text-<?php echo e($color); ?>-500 mx-auto mb-4">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1"><?php echo e($title); ?></h3>
        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5"><?php echo e($message); ?></p>
        <div class="flex gap-3">
            <button type="button" @click="$dispatch('close')" class="flex-1 bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-3 px-4 rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                <?php echo e($cancelText); ?>

            </button>
            <button type="button" @click="$dispatch('confirm')" class="flex-1 bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3 px-4 rounded-xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                <i class="fas fa-sign-out-alt"></i> <?php echo e($confirmText); ?>

            </button>
        </div>
    </div>
</div><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/logout-confirm-modal.blade.php ENDPATH**/ ?>