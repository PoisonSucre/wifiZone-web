<?php
    $currency = config('platform.currency') ?? 'FCFA';
    $nbForfaits = $forfaits->count();
    $nbActifs = $forfaits->where('actif', true)->count();
    $shopUrl = $vendeur->shopUrl();
    $shopLink = $hotspotId ? $shopUrl . '?hotspot=' . $hotspotId : $shopUrl;
?>

<div x-data="{ loaded: false, apparenceOpen: true, forfaitsOpen: true }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="relative space-y-4 sm:space-y-5 pb-2">

    
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
          class="absolute inset-0 z-10 space-y-4 animate-pulse">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 4; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[72px]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2.5"></div>
                            <div class="h-5 w-12 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5 space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700/40"></div>
                    <div class="h-4 w-24 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1 space-y-1.5">
                        <div class="h-3 w-14 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                    </div>
                    <div class="flex-1 space-y-1.5">
                        <div class="h-3 w-14 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-3 w-12 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-3 w-28 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-3 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    <div class="h-14 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                </div>
                <div class="w-24 h-8 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>

                <div class="border-t border-slate-100 dark:border-darkBorder/40 pt-4">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="h-3 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($k = 0; $k < 3; $k++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="h-12 rounded-xl bg-slate-100 dark:bg-slate-700/20 mb-2"></div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="grid grid-cols-3 gap-2 mt-3">
                        <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                        <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                        <div class="h-9 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                    </div>
                    <div class="w-20 h-8 rounded-xl bg-slate-200 dark:bg-slate-700/40 mt-3"></div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5 space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700/40"></div>
                    <div class="h-4 w-28 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                </div>
                <div class="h-[400px] rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
            </div>
        </div>

        
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5 space-y-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700/40"></div>
                <div class="h-4 w-24 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
            </div>
            <div class="h-3 w-44 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
            <div class="flex gap-2">
                <div class="flex-1 h-10 rounded-xl bg-slate-100 dark:bg-slate-700/20"></div>
                <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
            </div>
        </div>
    </div>

    
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5 relative z-[1]">

        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-tags text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Forfaits</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($nbForfaits); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-check-circle text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Actifs</p>
                        <p class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight leading-none"><?php echo e($nbActifs); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-eye-slash text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Inactifs</p>
                        <p class="text-xl sm:text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight leading-none"><?php echo e($nbForfaits - $nbActifs); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-purple-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-purple-500/5 group-hover:bg-purple-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-palette text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Couleur</p>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full border-2 border-white dark:border-darkCard shadow-sm" style="background:<?php echo e($couleur); ?>"></span>
                            <span class="text-sm font-black text-slate-900 dark:text-white tracking-tight"><?php echo e(strtoupper($couleur)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['padding' => 'p-0','class' => 'shadow-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['padding' => 'p-0','class' => 'shadow-sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <div class="flex items-center justify-between gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30 cursor-pointer select-none"
                     @click="apparenceOpen = !apparenceOpen">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                            <i class="fas fa-palette text-xs"></i>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Apparence</h3>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"
                       :class="{ 'rotate-180': apparenceOpen }"></i>
                </div>
                <div class="p-4 space-y-4" x-show="apparenceOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">
                    <form wire:submit.prevent="updateShop">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Dégradé (haut)</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" wire:model.live="couleurTop" class="w-9 h-9 rounded-xl border-0 cursor-pointer bg-transparent">
                                        <span class="text-xs font-mono font-bold text-slate-900 dark:text-white"><?php echo e($couleurTop); ?></span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Principal (bas)</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" wire:model.live="couleur" class="w-9 h-9 rounded-xl border-0 cursor-pointer bg-transparent">
                                        <span class="text-xs font-mono font-bold text-slate-900 dark:text-white"><?php echo e($couleur); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Logo</label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$logo && $vendeur->logo): ?>
                                    <img src="<?php echo e(asset($vendeur->logo)); ?>" class="w-20 h-14 object-cover rounded-xl border border-slate-200/80 dark:border-darkBorder mb-2" alt="Logo">
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <input type="file" wire:model="logo" accept="image/*" class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-neonGreen/10 file:text-neonGreen">
                                <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-1">JPEG, PNG, GIF ou WebP. Max 2 Mo.</p>
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Nom du portail</label>
                                <input type="text" wire:model.live.debounce.500ms="nomPortail" placeholder="<?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?>"
                                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Message d'accueil</label>
                                <textarea wire:model.live.debounce.500ms="messageBienvenue" rows="2" placeholder="Les tickets peuvent être achetés en contactant votre fournisseur d'accès."
                                          class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200 resize-none"></textarea>
                            </div>
                        </div>
                        <button type="submit" wire:loading.attr="disabled"
                                class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
                            <i wire:loading.remove wire:target="updateShop" class="fas fa-save text-[10px]"></i>
                            <i wire:loading wire:target="updateShop" class="fas fa-spinner fa-spin text-[10px]"></i>
                            Enregistrer
                        </button>
                    </form>
                </div>

                <hr class="border-slate-100 dark:border-darkBorder/40">

                <div class="flex items-center justify-between gap-2 cursor-pointer select-none px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30"
                     @click="forfaitsOpen = !forfaitsOpen">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md flex items-center justify-center text-[10px] font-black bg-neonGreen/10 text-neonGreen">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">Mes Forfaits</h4>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 transition-transform duration-300"
                       :class="{ 'rotate-180': forfaitsOpen }"></i>
                </div>

                <div class="p-4 space-y-4" x-show="forfaitsOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">

                        <div class="space-y-2 mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $forfaits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forfait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50/70 dark:bg-darkBg/50 border border-slate-100 dark:border-darkBorder/40 hover:border-neonGreen/30 transition-all group">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black text-white shrink-0 <?php echo e($forfait->actif ? 'bg-neonGreen' : 'bg-slate-300 dark:bg-slate-600'); ?>">
                                        <?php echo e(strtoupper(substr($forfait->label, 0, 2))); ?>

                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($forfait->label); ?></p>
                                        <p class="text-[10px] text-slate-400 dark:text-gray-500"><?php echo e($forfait->formattedDuration()); ?></p>
                                    </div>
                                    <span class="text-xs font-black text-slate-900 dark:text-white whitespace-nowrap"><?php echo e(number_format($forfait->montant, 0, ',', ' ')); ?></span>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <button type="button" wire:click="toggleForfait(<?php echo e($forfait->id); ?>)"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center transition-all <?php echo e($forfait->actif ? 'bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-amber-500 hover:text-white'); ?>">
                                            <i class="fas fa-<?php echo e($forfait->actif ? 'eye' : 'eye-slash'); ?> text-[10px]"></i>
                                        </button>
                                        <button type="button" wire:click="editForfait(<?php echo e($forfait->id); ?>)"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black transition-all">
                                            <i class="fas fa-edit text-[10px]"></i>
                                        </button>
                                        <button type="button" wire:click="confirmDelete(<?php echo e($forfait->id); ?>)"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div class="text-center py-6">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                        <i class="fas fa-tags text-lg"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucun forfait. Ajoutez-en un ci-dessous.</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="border-t border-slate-100 dark:border-darkBorder/40 pt-4">
                            <button type="button" wire:click="openAddForfaitModal"
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
                                <i class="fas fa-plus text-[10px]"></i> Ajouter un forfait
                            </button>
                        </div>
                    </div>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['padding' => 'p-0','class' => 'shadow-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['padding' => 'p-0','class' => 'shadow-sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                 <?php $__env->slot('header', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['icon' => 'eye','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'eye','color' => 'purple']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Aperçu du portail <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $attributes = $__attributesOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__attributesOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $component = $__componentOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__componentOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
                <div class="p-2 sm:p-3 max-h-[650px] overflow-y-auto rounded-xl border border-slate-200/80 dark:border-darkBorder">
                    <?php
                        $pv = clone $vendeur;
                        $pv->couleur = $couleur;
                        $pv->couleur_top = $couleurTop;
                        $pKey = fn ($k) => $hotspotId ? "preview_{$k}_{$hotspotId}" : "preview_{$k}";
                        $previewLogoPath = session($pKey('logo'));
                        $pv->logo = $previewLogoPath ?? $vendeur->logo;
                        $pv->nom_portail = $nomPortail ?: $vendeur->nom_portail;
                        $pv->message_bienvenue = $messageBienvenue ?: $vendeur->message_bienvenue;
                    ?>
                    <?php echo $__env->make('shop.template.preview', ['vendeur' => $pv, 'forfaits' => $forfaits, 'embed' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['padding' => 'p-0','class' => 'shadow-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['padding' => 'p-0','class' => 'shadow-sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

             <?php $__env->slot('header', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['icon' => 'link','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'link','color' => 'amber']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Lien du portail <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $attributes = $__attributesOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__attributesOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $component = $__componentOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__componentOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
             <?php $__env->endSlot(); ?>
            <div class="p-4">
                <p class="text-[11px] text-slate-400 dark:text-gray-500 mb-3">Partagez ce lien aux clients connectés à votre WiFi :</p>
                <div class="flex items-center gap-2 mb-4">
                    <input type="text" value="<?php echo e($shopLink); ?>" readonly id="shopLink"
                           class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-xs font-mono text-slate-600 dark:text-gray-400 truncate focus:outline-none">
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('shopLink').value);this.innerHTML='<i class=\'fas fa-check\'></i>';setTimeout(()=>this.innerHTML='<i class=\'fas fa-copy\'></i>',1500)"
                            class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white flex items-center justify-center transition-all shadow-sm hover:shadow-md">
                        <i class="fas fa-copy text-xs"></i>
                    </button>
                </div>
                <a href="<?php echo e(route('vendor.boutique.download')); ?><?php echo e($hotspotId ? '?hotspot=' . $hotspotId : ''); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition-all shadow-sm hover:shadow-md">
                    <i class="fas fa-download text-[10px]"></i> Télécharger le pack MikroTik
                </a>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['show' => $showForfaitModal,'onClose' => 'cancelEdit','icon' => $editingForfait ? 'edit' : 'plus','iconBg' => $editingForfait ? 'amber' : 'green','title' => $editingForfait ? 'Modifier le forfait' : 'Nouveau forfait','subtitle' => $editingForfait ? 'Modifiez les informations ci-dessous.' : 'Remplissez les informations ci-dessous.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showForfaitModal),'onClose' => 'cancelEdit','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingForfait ? 'edit' : 'plus'),'iconBg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingForfait ? 'amber' : 'green'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingForfait ? 'Modifier le forfait' : 'Nouveau forfait'),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingForfait ? 'Modifiez les informations ci-dessous.' : 'Remplissez les informations ci-dessous.')]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <form wire:submit.prevent="<?php echo e($editingForfait ? 'updateForfait' : 'addForfait'); ?>" class="space-y-4">
            <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['label' => 'Libellé','model' => 'forfaitLabel','required' => true,'placeholder' => 'Ex: 1 Heure']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Libellé','model' => 'forfaitLabel','required' => true,'placeholder' => 'Ex: 1 Heure']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
            <div class="grid grid-cols-2 gap-3">
                <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['label' => 'Montant ('.e($currency).')','type' => 'number','model' => 'forfaitMontant','required' => true,'placeholder' => '150','min' => 1]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Montant ('.e($currency).')','type' => 'number','model' => 'forfaitMontant','required' => true,'placeholder' => '150','min' => 1]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['label' => 'Durée (minutes)','type' => 'number','model' => 'forfaitDuree','required' => true,'placeholder' => '60','min' => 1]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Durée (minutes)','type' => 'number','model' => 'forfaitDuree','required' => true,'placeholder' => '60','min' => 1]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm">
                    <i wire:loading.remove wire:target="addForfait, updateForfait" class="fas fa-<?php echo e($editingForfait ? 'save' : 'plus'); ?> text-[10px]"></i>
                    <i wire:loading wire:target="addForfait, updateForfait" class="fas fa-spinner fa-spin text-[10px]"></i>
                    <?php echo e($editingForfait ? 'Enregistrer' : 'Ajouter'); ?>

                </button>
                <?php if (isset($component)) { $__componentOriginal1edae8760811c7b935175a7435923573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1edae8760811c7b935175a7435923573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn-secondary','data' => ['wire:click' => 'cancelEdit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('btn-secondary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'cancelEdit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Annuler <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1edae8760811c7b935175a7435923573)): ?>
<?php $attributes = $__attributesOriginal1edae8760811c7b935175a7435923573; ?>
<?php unset($__attributesOriginal1edae8760811c7b935175a7435923573); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1edae8760811c7b935175a7435923573)): ?>
<?php $component = $__componentOriginal1edae8760811c7b935175a7435923573; ?>
<?php unset($__componentOriginal1edae8760811c7b935175a7435923573); ?>
<?php endif; ?>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['show' => $showDeleteModal,'onClose' => '$set(\'showDeleteModal\', false)','icon' => 'trash','iconBg' => 'red','title' => 'Supprimer le forfait','subtitle' => 'Voulez-vous vraiment supprimer ce forfait ? Cette action est irréversible.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showDeleteModal),'onClose' => '$set(\'showDeleteModal\', false)','icon' => 'trash','iconBg' => 'red','title' => 'Supprimer le forfait','subtitle' => 'Voulez-vous vraiment supprimer ce forfait ? Cette action est irréversible.']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal1edae8760811c7b935175a7435923573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1edae8760811c7b935175a7435923573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn-secondary','data' => ['wire:click' => '$set(\'showDeleteModal\', false)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('btn-secondary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showDeleteModal\', false)']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Annuler <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1edae8760811c7b935175a7435923573)): ?>
<?php $attributes = $__attributesOriginal1edae8760811c7b935175a7435923573; ?>
<?php unset($__attributesOriginal1edae8760811c7b935175a7435923573); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1edae8760811c7b935175a7435923573)): ?>
<?php $component = $__componentOriginal1edae8760811c7b935175a7435923573; ?>
<?php unset($__componentOriginal1edae8760811c7b935175a7435923573); ?>
<?php endif; ?>
            <button wire:click="deleteForfait" wire:loading.attr="disabled"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm">
                <i wire:loading.remove wire:target="deleteForfait" class="fas fa-trash text-[10px]"></i>
                <i wire:loading wire:target="deleteForfait" class="fas fa-spinner fa-spin text-[10px]"></i>
                Supprimer
            </button>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/vendor/boutique-manager.blade.php ENDPATH**/ ?>