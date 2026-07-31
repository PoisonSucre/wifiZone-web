<?php $__env->startSection('title', 'Administration'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300 hover:border-neonGreen/30 hover:shadow-neon-glow">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-shield-alt"></i></span>
            Admin
        </div>
        <p class="text-sm text-slate-500 dark:text-gray-400">Accès à l'administration</p>
    </div>

    <form method="POST" action="<?php echo e(route('admin.login.post')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Adresse Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" required autofocus value="<?php echo e(old('email')); ?>"
                       placeholder="admin@exemple.com"
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Mot de passe</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" required
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                <button type="button" onclick="togglePw('password', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-neonGreen transition-colors">
                    <i class="fas fa-eye text-base"></i>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <button type="submit" id="btn-submit" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-4 px-6 rounded-2xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm">
            <span id="btn-label" class="flex items-center gap-3"><i class="fas fa-sign-in-alt"></i> Connexion Admin</span>
            <span id="btn-loading" class="flex items-center gap-3 hidden"><i class="fas fa-spinner fa-spin"></i> Connexion...</span>
        </button>
    </form>

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center">
        <a href="/" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function() {
        var btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.classList.remove('hover:bg-neonGreen-400', 'hover:-translate-y-0.5');
        document.getElementById('btn-label').classList.add('hidden');
        document.getElementById('btn-loading').classList.remove('hidden');
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/auth/admin-login.blade.php ENDPATH**/ ?>