<?php $__env->startSection('title', 'Connexion'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300 hover:border-neonGreen/30 hover:shadow-neon-glow">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            <?php echo e(config('platform.name')); ?>

        </a>
        <p class="text-sm text-slate-500 dark:text-gray-400">Ravi de vous revoir ! Connectez-vous à votre espace.</p>
    </div>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('auth.login-form');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2343983283-0', $__key);

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

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center space-y-2">
        <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400">
            Pas encore de compte ?
            <a href="<?php echo e(route('vendor.register')); ?>" class="font-bold text-neonGreen hover:text-neonGreen-400 transition-colors">S'inscrire gratuitement</a>
        </p>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400">
            <a href="<?php echo e(route('vendor.forgot-password')); ?>" class="font-bold text-slate-400 hover:text-neonGreen transition-colors">Mot de passe oublié ?</a>
        </p>
        <p>
            <a href="/" class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/auth/login.blade.php ENDPATH**/ ?>