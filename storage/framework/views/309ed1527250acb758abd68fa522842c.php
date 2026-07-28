<?php $__env->startSection('title', 'Nouveau mot de passe'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            <?php echo e(config('platform.name')); ?>

        </a>
        <p class="text-sm text-slate-500 dark:text-gray-400">Choisissez un nouveau mot de passe.</p>
    </div>

    <form method="POST" action="<?php echo e(route('vendor.reset-password.post')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <input type="hidden" name="email" value="<?php echo e($email); ?>">

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" value="<?php echo e($email); ?>" disabled
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-100 dark:bg-darkBg/40 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-500 dark:text-gray-500 text-sm cursor-not-allowed">
            </div>
        </div>

        <div x-data="{ showPassword: false }">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Nouveau mot de passe</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-lock"></i>
                </span>
                <input :type="showPassword ? 'text' : 'password'" name="password" required
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-neonGreen transition-colors">
                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Confirmer le mot de passe</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" required
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <button type="submit" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-4 px-6 rounded-2xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm">
            <i class="fas fa-key"></i> Réinitialiser le mot de passe
        </button>
    </form>

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center">
        <a href="<?php echo e(route('vendor.login')); ?>" class="text-sm font-bold text-neonGreen hover:text-neonGreen-400 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/auth/reset-password.blade.php ENDPATH**/ ?>