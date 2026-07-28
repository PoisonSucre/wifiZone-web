<aside class="vendor-sidebar" id="sidebar">
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
                <a href="<?php echo e($link['url']); ?>" wire:navigate class="sidebar-link <?php echo e($isActive ? 'active' : ''); ?>">
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
            <form method="POST" action="<?php echo e(route($logoutRoute)); ?>" class="sidebar-logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="sidebar-action-btn sidebar-logout-btn">
                    <div class="action-icon-wrapper logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="action-label">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/sidebar.blade.php ENDPATH**/ ?>