<?php $__env->startSection('title', 'Compte suspendu'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center">
        
        <div class="mx-auto w-16 h-16 rounded-full bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/50 flex items-center justify-center mb-5">
            <i class="fas fa-ban text-2xl text-red-500"></i>
        </div>

        
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">
            Compte suspendu
        </h2>
        <p class="text-sm text-slate-500 dark:text-gray-400 mb-5">
            Votre compte a été suspendu par l'administrateur. Vous ne pouvez plus vous connecter.
        </p>

        
        <div class="text-left bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder rounded-2xl p-4 mb-5 space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-ban text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-600 dark:text-red-400">Accès bloqué</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Votre accès au tableau de bord a été désactivé</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-darkBorder text-slate-400 dark:text-gray-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-ticket-alt text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 dark:text-gray-500">Vente de tickets</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Vous ne pouvez plus créer ni vendre de tickets</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 animate-pulse">
                    <i class="fas fa-headset text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-amber-600 dark:text-amber-400">Contactez le support</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Pour contester cette décision ou obtenir de l'aide</p>
                </div>
            </div>
        </div>

        
        <div class="text-left mb-5">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('auth.suspended-status');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-359063643-0', $__key);

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
        </div>

        
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-2xl p-4 mb-5 flex items-start gap-3">
            <i class="fas fa-info-circle text-red-500 mt-0.5 shrink-0"></i>
            <p class="text-xs text-slate-600 dark:text-gray-300 text-left">
                Si vous pensez qu'il s'agit d'une <strong>erreur</strong>, veuillez contacter notre support avec votre adresse email pour rétablir l'accès.
            </p>
        </div>

        
        <p class="text-xs text-slate-400 dark:text-gray-500 mb-4">
            Contactez-nous au <strong class="text-slate-600 dark:text-gray-300">66 63 59 58 / 64 65 86 44</strong>
        </p>

        
        <a href="<?php echo e(route('vendor.login')); ?>" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-neonGreen dark:hover:text-neonGreen transition-colors">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/auth/suspended.blade.php ENDPATH**/ ?>