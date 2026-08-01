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
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($nbTotal); ?></p>
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
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Actifs</p>
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
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Inactifs</p>
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
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Tickets</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalTickets); ?></p>
                    </div>
                </div>
            </div>
        </div>


         <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 p-4 sm:p-5 text-white shadow-[0_10px_30px_-12px_rgba(6,182,212,0.45)]">
             <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10"></div>
             <div class="absolute -right-2 -top-2 w-24 h-24 rounded-full bg-white/5"></div>
             

              <button type="button" wire:click="openPackModal"
                      class="absolute top-3 right-3 sm:hidden inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-white text-blue-700 hover:bg-blue-50 text-[10px] font-extrabold transition-all shadow-sm hover:shadow-md z-10">
                  <i class="fas fa-cart-plus text-[9px]"></i> Acheter des quotas
              </button>
             
             <div class="relative flex flex-col sm:flex-row sm:items-start gap-4 sm:pr-10">
                 <div class="flex-1 min-w-0">
                     <p class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-white/70">Quota de hotspots</p>
                     <div class="flex items-baseline gap-2 mt-1">
                         <p class="text-2xl font-black tracking-tight"><?php echo e($used); ?> / <?php echo e($limit); ?></p>
                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCreate): ?>
                               <span class="inline-flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-full bg-white/20 text-white text-[10px] font-black uppercase tracking-wider">
                                   <span class="font-medium text-white/80"><?php echo e($remaining); ?> Restant<?php echo e($remaining > 1 ? 's' : ''); ?></span>
                               </span>
                           <?php else: ?>
                               <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-500/20 text-red-300 text-[11px] font-black uppercase tracking-wider">
                                   <i class="fas fa-ban text-[9px]"></i> Quota atteint
                               </span>
                           <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                     </div>
                     <div class="relative h-2 rounded-full bg-white/20 mt-3 overflow-hidden">
                         <div class="h-full rounded-full transition-all duration-700"
                              style="width: <?php echo e($limit > 0 ? min(($used / $limit) * 100, 100) : ($used > 0 ? 100 : 0)); ?>%; background: <?php echo e($limit > 0 && $used >= $limit ? '#ef4444' : ($limit === 0 && $used > 0 ? '#f59e0b' : '#00ff88')); ?>"></div>
                     </div>
                     <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasFrozen): ?>
                         <div class="flex flex-wrap gap-2 mt-2">
                             <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-500/30 text-[10px] font-bold uppercase tracking-wider text-amber-200">
                                 <i class="fas fa-snowflake text-[8px]"></i> <?php echo e($frozenSubscriptions->sum('slots')); ?> gelé(s)
                             </span>
                             <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-500/30 text-[10px] font-bold uppercase tracking-wider text-green-200">
                                 <i class="fas fa-unlock text-[8px]"></i> <?php echo e($availableFreeSlots); ?> gratuit(s)
                             </span>
                         </div>
                     <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                 </div>
                 
                 
                 <div class="shrink-0 hidden sm:flex sm:flex-col sm:items-end sm:gap-2">
                     <button type="button" wire:click="openPackModal"
                             class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-[11px] font-extrabold transition-all shadow-sm hover:shadow-md">
                         <i class="fas fa-cart-plus text-[10px]"></i> Acheter des quotas
                     </button>
                     <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($soldeDisponible > 0): ?>
                         <p class="text-[10px] font-bold text-white/85 flex items-center gap-1.5">
                             <i class="fas fa-wallet text-[9px]"></i>
                             Solde : <?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?>

                         </p>
                     <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                 </div>
                 
                 
                 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($soldeDisponible > 0): ?>
                     <div class="sm:hidden w-full mt-2 pt-2 border-t border-white/20">
                         <p class="text-[10px] font-bold text-white/85 flex items-center justify-center gap-1.5">
                             <i class="fas fa-wallet text-[9px]"></i>
                             Solde : <?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?>

                         </p>
                     </div>
                 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             </div>
             
             <div class="relative flex flex-col gap-1.5 mt-3 sm:mt-4">
                 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$canCreate && $hasFrozen): ?>
                      <p class="text-[11px] font-bold text-white/90">
                          <?php echo e($frozenSubscriptions->sum('slots')); ?> slot(s) payant(s) gelé(s).
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableFreeSlots > 0): ?>
                              <?php echo e($availableFreeSlots); ?> slot(s) gratuit(s) libre(s).
                          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                          <button type="button" wire:click="openRenewModal('<?php echo e($frozenSubscriptions->first()->pack_key); ?>')"
                                  class="underline hover:no-underline font-extrabold">Renouveler →</button>
                      </p>
                  <?php elseif(!$canCreate): ?>
                      <p class="text-[11px] font-bold text-white/90">
                          Tous vos emplacements sont utilisés. Achetez un pack pour ajouter plus de hotspots.
                      </p>
                  <?php else: ?>
                      <p class="text-[11px] text-white/80">
                          <?php echo e($limit - $used); ?> emplacement(s) restant(s). Un abonnement mensuel vous permet d'ajouter plus de hotspots.
                      </p>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subscriptions->isNotEmpty()): ?>
                      <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-2 flex-wrap">
                          <i class="fas fa-crown text-[9px] sm:text-[10px] text-white/70 shrink-0"></i>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                              <span class="text-[10px] sm:text-[11px] font-bold text-white/85 whitespace-nowrap">Pack <?php echo e($packs[$sub->pack_key]['label'] ?? $sub->pack_key); ?> +<?php echo e($sub->slots); ?> · expire le <?php echo e($sub->expires_at?->format('d/m/Y')); ?></span>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                      </div>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        
                        <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo e($hasFrozen ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400' : ($hotspot->statut === 'actif' ? 'bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 dark:text-gray-500')); ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?php echo e($hasFrozen ? 'bg-amber-400 animate-pulse' : ($hotspot->statut === 'actif' ? 'bg-red-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600')); ?>"></span>
                            <?php echo e($hasFrozen ? 'Gelé' : ($hotspot->statut === 'actif' ? 'En ligne' : 'Hors ligne')); ?>

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
                            <?php echo e($hasFrozen ? 'disabled' : ''); ?>

                            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all <?php echo e($hasFrozen ? 'bg-slate-100 dark:bg-slate-700/40 text-slate-300 dark:text-slate-600 cursor-not-allowed' : ($hotspot->statut === 'actif' ? 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black')); ?>"
                            title="<?php echo e($hasFrozen ? 'Indisponible pendant le gel' : ($hotspot->statut === 'actif' ? 'Désactiver' : 'Activer')); ?>">
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
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-plus text-[10px]"></i>
                Créer un hotspot
            </button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPackModal): ?>
    <div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         wire:click="closePackModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl overflow-hidden max-w-2xl w-full max-h-[92vh] flex flex-col"
             onclick="event.stopPropagation()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30 shrink-0">
                <div class="w-9 h-9 rounded-lg bg-cyan-500/10 text-cyan-500 flex items-center justify-center">
                    <i class="fas fa-cart-plus text-sm"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Acheter des quotas</h3>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500">Ajoutez des emplacements de hotspots, renouvelables chaque mois.</p>
                </div>
                <button type="button" wire:click="closePackModal"
                        class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-600 transition-all">
                    <i class="fas fa-times text-[11px]"></i>
                </button>
            </div>

            <div class="p-5 overflow-y-auto flex-1 min-h-0">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subscriptions->isNotEmpty()): ?>
                <div class="mb-5">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2.5">
                        <i class="fas fa-crown text-amber-500 mr-1"></i> Vos abonnements actifs
                    </p>
                    <div class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center justify-between gap-3 bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 rounded-xl px-3 py-2.5">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="shrink-0 w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                                    <i class="fas fa-wifi text-[11px]"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate">Pack <?php echo e($packs[$sub->pack_key]['label'] ?? $sub->pack_key); ?> <span class="text-neonGreen">+<?php echo e($sub->slots); ?></span></p>
                                    <p class="text-[10px] text-slate-400 dark:text-gray-500">
                                        Paiement <?php echo e($sub->payment_method === 'solde' ? 'via solde' : 'via LigdiCash'); ?> · expire le <?php echo e($sub->expires_at?->format('d/m/Y')); ?>

                                    </p>
                                </div>
                            </div>
                            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-clock text-[9px]"></i> <?php echo e((int) now()->diffInDays($sub->expires_at, false)); ?> j restants
                            </span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 flex flex-col hover:border-cyan-500/40 transition-all duration-300 hover:-translate-y-0.5">
<div class="flex items-center justify-between mb-3 gap-2">
                             <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 text-white text-[11px] font-extrabold uppercase tracking-wider shrink-0">
                                 <i class="fas fa-wifi text-[9px]"></i> <?php echo e($pack['label']); ?>

                             </span>
                         </div>
                        <div class="mb-4">
                            <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e(number_format($pack['price'], 0, ',', ' ')); ?> <span class="text-[11px] text-slate-400 font-bold"><?php echo e(config('platform.currency')); ?></span></p>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-1 font-medium">par mois, sans engagement</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($pack['desc'])): ?>
                            <p class="text-[10px] text-slate-500 dark:text-gray-400 mt-1.5 font-medium"><?php echo e($pack['desc']); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex flex-col gap-1.5 mt-auto">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-neonGreen dark:text-neonGreen-400 text-[10px] font-extrabold uppercase tracking-wider whitespace-nowrap mb-1 self-center">
                                 <i class="fas fa-plus text-[8px]"></i> +<?php echo e($pack['slots']); ?> Hotspots
                             </span>
                            <form method="POST" action="<?php echo e(route('vendor.pack.payment', $pack['key'])); ?>" class="w-full">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-400 text-white text-[11px] font-bold transition-all">
                                    <i class="fas fa-mobile-alt text-[10px]"></i> Payer via LigdiCash
                                </button>
                            </form>
                            <button type="button" wire:click="chooseSoldePack('<?php echo e($pack['key']); ?>')"
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-700 dark:text-gray-300 text-[11px] font-bold transition-all hover:border-neonGreen/50 <?php echo e($soldeDisponible < $pack['price'] ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                                    <?php if($soldeDisponible < $pack['price']): ?> disabled <?php endif; ?>>
                                <i class="fas fa-wallet text-[10px]"></i> Payer avec mon solde
                            </button>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500 text-center mt-0.5">
                                Solde : <?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?>

                            </p>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteModal): ?>
    <div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
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
    <div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
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
                        class="flex-1 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($soldePackKey && isset($packs[$soldePackKey])): ?>
    <div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         wire:click="cancelSoldePack"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full"
             onclick="event.stopPropagation()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-neonGreen/10 text-neonGreen mx-auto mb-4">
                <i class="fas fa-wallet"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Payer avec mon solde</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">
                Confirmer l'achat du <span class="font-bold text-slate-900 dark:text-white">Pack <?php echo e($packs[$soldePackKey]['label']); ?></span>
                (+<?php echo e($packs[$soldePackKey]['slots']); ?> hotspots) pour
                <span class="font-bold text-slate-900 dark:text-white"><?php echo e(number_format($packs[$soldePackKey]['price'], 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></span>
                ? Le montant sera déduit de votre solde.
            </p>
            <div class="bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 rounded-xl px-3 py-2.5 mb-5 flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Solde disponible</span>
                <span class="text-sm font-black text-slate-900 dark:text-white"><?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="cancelSoldePack"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-xs font-bold text-slate-600 dark:text-gray-400 transition-all">
                    Annuler
                </button>
                <button wire:click="subscribePackWithSolde" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm">
                    <i wire:loading wire:target="subscribePackWithSolde" class="fas fa-spinner fa-spin text-[10px]"></i>
                    Confirmer
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
    <div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
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
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">URL du MikroTik</label>
                        <input type="url" wire:model="mikrotikUrl" placeholder="Ex: https://votre-routeur.ngrok-free.app"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['mikrotikUrl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[11px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="text-[10px] text-slate-400 mt-1">URL publique de votre routeur MikroTik (ngrok, DDNS, IP publique). Le client sera redirigé ici après achat.</p>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-[12px] font-bold transition-all shadow-sm">
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