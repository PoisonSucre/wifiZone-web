<aside class="vendor-sidebar" id="sidebar" x-data="{ showLogoutModal: false }">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <div class="sidebar-logo-wrapper">
                <div class="sidebar-logo-glow"></div>
                <i class="fas <?php echo e($logoIcon); ?> sidebar-logo"></i>
            </div>
            <span class="sidebar-brand"><?php echo e($brandText); ?></span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label"><?php echo e($navLabel); ?></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $isActive = $activeRoute === $link['route']; ?>
                <a href="<?php echo e($link['url']); ?>" wire:navigate @click="closeVendorSidebar()" class="sidebar-link <?php echo e($isActive ? 'active' : ''); ?>">
                    <div class="link-indicator"></div>
                    <div class="link-icon-wrapper">
                        <i class="fas <?php echo e($link['icon']); ?>"></i>
                    </div>
                    <span class="link-label"><?php echo e($link['label']); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($link['badge'])): ?>
                        <span class="link-badge"><?php echo e($link['badge']); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <svg class="link-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <button type="button" class="sidebar-action-btn" onclick="toggleTheme()" title="Basculer le thème">
                <div class="action-icon-wrapper">
                    <i class="fas fa-sun hidden dark:inline" id="theme-sun"></i>
                    <i class="fas fa-moon inline dark:hidden" id="theme-moon"></i>
                </div>
                <span class="action-label">Thème</span>
                <div class="action-toggle">
                    <div class="toggle-knob"></div>
                </div>
            </button>
            <form method="POST" action="<?php echo e(route($logoutRoute)); ?>" class="sidebar-logout-form" id="logout-form" x-ref="logoutForm">
                <?php echo csrf_field(); ?>
                <button type="button" class="sidebar-action-btn sidebar-logout-btn" @click="showLogoutModal = true">
                    <div class="action-icon-wrapper logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="action-label">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Logout Confirmation Modal (Alpine.js inline) -->
    <div x-show="showLogoutModal" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="showLogoutModal = false" @keydown.escape.window="showLogoutModal = false">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/10 text-amber-500 mx-auto mb-4">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Confirmer la déconnexion</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">Voulez-vous vraiment vous déconnecter ?</p>
            <div class="flex gap-3">
                <button type="button" @click="showLogoutModal = false" class="flex-1 bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-3 px-4 rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                    Annuler
                </button>
                <button type="button" @click="showLogoutModal = false; $refs.logoutForm.submit()" class="flex-1 bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3 px-4 rounded-xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </button>
            </div>
        </div>
    </div>
</aside>

<?php if (! $__env->hasRenderedOnce('cfb85860-6484-4c2b-a5f4-aa866ffe42d8')): $__env->markAsRenderedOnce('cfb85860-6484-4c2b-a5f4-aa866ffe42d8'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function toggleVendorSidebar() {
    var sb = document.querySelector('.vendor-sidebar');
    var ov = document.querySelector('.sidebar-overlay');
    if (!sb) return;
    sb.classList.toggle('open');
    if (ov) ov.classList.toggle('active', sb.classList.contains('open'));
}
window.toggleVendorSidebar = toggleVendorSidebar;

function closeVendorSidebar() {
    var sb = document.querySelector('.vendor-sidebar');
    var ov = document.querySelector('.sidebar-overlay');
    if (sb) sb.classList.remove('open');
    if (ov) ov.classList.remove('active');
}
window.closeVendorSidebar = closeVendorSidebar;

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeVendorSidebar();
});

window.addEventListener('resize', function () {
    if (window.innerWidth > 1024) closeVendorSidebar();
});

document.addEventListener('livewire:navigated', function () {
    closeVendorSidebar();
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/sidebar.blade.php ENDPATH**/ ?>