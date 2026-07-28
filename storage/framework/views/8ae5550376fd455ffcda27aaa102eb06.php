<?php
    $nbTotal = $totalHotspots;
    $nbActifs = $actifs;
    $nbInactifs = $inactifs;
    $totalTickets = $hotspots->sum('tickets_count');
?>

<div x-data="{ loaded: false }" x-cloak
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 3; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5 h-[140px]">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-3 w-24 bg-slate-200 dark:bg-slate-700/40 rounded mb-2"></div>
                            <div class="h-2 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <div class="h-4 w-16 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="h-4 w-16 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    
    <div x-show="loaded" x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5 relative z-[1]">

        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-cyan-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-cyan-500/5 group-hover:bg-cyan-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 group-hover:bg-cyan-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-wifi text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($nbTotal); ?></p>
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
                        <p class="text-xl sm:text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight leading-none"><?php echo e($nbInactifs); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket-alt text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Tickets</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalTickets); ?></p>
                    </div>
                </div>
            </div>
        </div>

        
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Mes Hotspots</h3>
            <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-0.5"><?php echo e($nbTotal); ?> hotspot(s) configuré(s)</p>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hotspots->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4 max-w-3xl">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $hotspots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotspot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden hover:border-cyan-500/30 transition-all duration-300 hover:-translate-y-0.5 group">
                
                <div class="px-4 pt-4 pb-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-11 h-11 shrink-0 rounded-xl bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-[0_4px_12px_-4px_rgba(6,182,212,0.4)] group-hover:rotate-3 transition-transform duration-300">
                                <i class="fas fa-wifi text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-extrabold text-slate-900 dark:text-white truncate"><?php echo e($hotspot->name); ?></h4>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hotspot->description): ?>
                                    <p class="text-[10px] text-slate-400 dark:text-gray-500 truncate mt-0.5"><?php echo e($hotspot->description); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        
                        <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider <?php echo e($hotspot->statut === 'actif' ? 'bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 dark:text-gray-500'); ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?php echo e($hotspot->statut === 'actif' ? 'bg-red-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600'); ?>"></span>
                            <?php echo e($hotspot->statut === 'actif' ? 'En ligne' : 'Hors ligne'); ?>

                        </span>
                    </div>
                </div>

                
                <div class="px-4 pb-3 flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-tags text-[10px] text-neonGreen"></i>
                        <span class="text-[11px] font-bold text-slate-600 dark:text-gray-400"><?php echo e($hotspot->forfaits_count); ?> forfait(s)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-ticket-alt text-[10px] text-cyan-500"></i>
                        <span class="text-[11px] font-bold text-slate-600 dark:text-gray-400"><?php echo e($hotspot->tickets_count); ?> ticket(s)</span>
                    </div>
                </div>

                
                <div class="px-4 pb-4 flex items-center gap-1.5">
                    <a href="<?php echo e(route('vendor.hotspot.details', $hotspot->id)); ?>"
                       wire:navigate
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-white dark:text-black text-[11px] font-bold transition-all">
                        <i class="fas fa-arrow-right text-[10px]"></i> Gérer
                    </a>
                    <button type="button" wire:click="confirmToggle(<?php echo e($hotspot->id); ?>)"
                            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all <?php echo e($hotspot->statut === 'actif' ? 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black'); ?>"
                            title="<?php echo e($hotspot->statut === 'actif' ? 'Désactiver' : 'Activer'); ?>">
                        <i class="fas <?php echo e($hotspot->statut === 'actif' ? 'fa-toggle-on' : 'fa-toggle-off'); ?> text-sm"></i>
                    </button>
                    <button type="button" wire:click="editHotspot(<?php echo e($hotspot->id); ?>)"
                            class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black transition-all"
                            title="Modifier">
                        <i class="fas fa-edit text-[10px]"></i>
                    </button>
                    <button type="button" wire:click="confirmDelete(<?php echo e($hotspot->id); ?>)"
                            class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-red-500 hover:text-white transition-all"
                            title="Supprimer">
                        <i class="fas fa-trash text-[10px]"></i>
                    </button>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php else: ?>
        
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-500/10 mb-4">
                <i class="fas fa-wifi text-2xl text-cyan-400"></i>
            </div>
            <h4 class="text-base font-bold text-slate-900 dark:text-white mb-1">Aucun hotspot</h4>
            <p class="text-xs text-slate-500 dark:text-gray-400 mb-4 max-w-sm mx-auto">
                Créez votre premier hotspot pour commencer à gérer vos points d'accès WiFi.
            </p>
            <button wire:click="openForm"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-black text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-plus text-[10px]"></i>
                Créer un hotspot
            </button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         wire:click="$set('showDeleteModal', false)"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full"
             onclick="event.stopPropagation()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/10 text-red-500 mx-auto mb-4">
                <i class="fas fa-trash"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Supprimer le hotspot</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">
                Voulez-vous vraiment supprimer ce hotspot ? Les tickets, forfaits et transactions associés seront également supprimés. Cette action est irréversible.
            </p>
            <div class="flex items-center gap-2">
                <button wire:click="$set('showDeleteModal', false)"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-xs font-bold text-slate-600 dark:text-gray-400 transition-all">
                    Annuler
                </button>
                <button wire:click="deleteHotspot" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm">
                    <i wire:loading.remove wire:target="deleteHotspot" class="fas fa-trash text-[10px]"></i>
                    <i wire:loading wire:target="deleteHotspot" class="fas fa-spinner fa-spin text-[10px]"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showToggleModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         wire:click="$set('showToggleModal', false)"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full"
             onclick="event.stopPropagation()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-neonGreen/10 dark:bg-neonGreen/10 text-neonGreen mx-auto mb-4">
                <i class="fas fa-power-off"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Confirmer le changement</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">
                Voulez-vous vraiment changer le statut du hotspot <span class="font-bold text-slate-900 dark:text-white"><?php echo e($toggleHotspotName); ?></span> ?
            </p>
            <div class="flex items-center gap-2">
                <button wire:click="$set('showToggleModal', false)"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-xs font-bold text-slate-600 dark:text-gray-400 transition-all">
                    Annuler
                </button>
                <button wire:click="toggleHotspot" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-black text-xs font-bold transition-all shadow-sm">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         wire:click="cancelEdit"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl overflow-hidden max-w-md w-full"
             onclick="event.stopPropagation()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-9 h-9 rounded-lg <?php echo e($editingHotspot ? 'bg-amber-500/10 text-amber-500' : 'bg-cyan-500/10 text-cyan-500'); ?> flex items-center justify-center">
                    <i class="fas fa-<?php echo e($editingHotspot ? 'edit' : 'plus'); ?> text-sm"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex-1"><?php echo e($editingHotspot ? 'Modifier le hotspot' : 'Nouveau hotspot'); ?></h3>
                <button type="button" wire:click="cancelEdit"
                        class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-600 transition-all">
                    <i class="fas fa-times text-[11px]"></i>
                </button>
            </div>
            <div class="p-5">
                <form wire:submit.prevent="<?php echo e($editingHotspot ? 'updateHotspot' : 'addHotspot'); ?>" class="space-y-4">
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Nom du hotspot *</label>
                        <input type="text" wire:model="hotspotName" required placeholder="Ex: WiFi Centre Ville"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['hotspotName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[11px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Description</label>
                        <textarea wire:model="hotspotDescription" rows="3" placeholder="Description optionnelle..."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200 resize-none"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['hotspotDescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[11px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-black text-[12px] font-bold transition-all shadow-sm">
                            <i wire:loading.remove wire:target="addHotspot, updateHotspot" class="fas fa-<?php echo e($editingHotspot ? 'save' : 'plus'); ?> text-[11px]"></i>
                            <i wire:loading wire:target="addHotspot, updateHotspot" class="fas fa-spinner fa-spin text-[11px]"></i>
                            <?php echo e($editingHotspot ? 'Enregistrer' : 'Créer'); ?>

                        </button>
                        <button type="button" wire:click="cancelEdit"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-600 dark:text-gray-400 text-[12px] font-bold transition-all">
                            <i class="fas fa-times text-[11px]"></i> Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/vendor/hotspot-manager.blade.php ENDPATH**/ ?>