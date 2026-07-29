<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$vendeur): ?>
    <div class="text-center py-12">
        <i class="fas fa-store text-4xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Boutique introuvable.</p>
    </div>
<?php else: ?>
    <div class="max-w-lg mx-auto">
        
        <div class="text-center p-8 rounded-2xl mb-6" style="background-color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeur->logo): ?>
                <img src="<?php echo e(asset($vendeur->logo)); ?>" alt="Logo" class="w-20 h-20 rounded-full mx-auto mb-4 object-cover border-2 border-white/30">
            <?php else: ?>
                <div class="w-20 h-20 rounded-full mx-auto mb-4 bg-white/20 flex items-center justify-center">
                    <i class="fas fa-wifi text-white text-3xl"></i>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <h1 class="text-white font-bold text-xl"><?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></h1>
            <p class="text-white/80 text-sm mt-1"><?php echo e($vendeur->message_bienvenue ?? 'Bienvenue sur notre hotspot WiFi !'); ?></p>
        </div>

        
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $forfaits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forfait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center justify-between <?php echo e($selectedForfait === $forfait['id'] ? 'ring-2 ring-[#1ca04e]' : ''); ?>">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white"><?php echo e($forfait['label']); ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($forfait['duree_minutes']); ?> minutes</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-lg" style="color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>"><?php echo e(number_format($forfait['montant'], 0)); ?> <?php echo e(config('platform.currency')); ?></span>
                        <button wire:click="selectForfait(<?php echo e($forfait['id']); ?>" class="px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors" style="background-color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>">
                            Choisir
                        </button>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="text-center py-8 bg-white dark:bg-gray-800 rounded-xl shadow">
                    <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Aucun forfait disponible.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedForfait): ?>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Forfait sélectionné : <strong><?php echo e(collect($forfaits)->firstWhere('id', $selectedForfait)['label'] ?? ''); ?></strong></p>
                <a href="#" class="inline-block px-8 py-3 text-white font-semibold rounded-xl shadow transition-colors" style="background-color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>">
                    <i class="fas fa-credit-card mr-2"></i>Payer maintenant
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/shop/shop-page.blade.php ENDPATH**/ ?>