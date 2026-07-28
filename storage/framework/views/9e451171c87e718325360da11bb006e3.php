<?php
    $currency = config('platform.currency') ?? 'FCFA';
    $hasSolde = $soldeDisponible > 0;

    // Habillage de la carte vendeur
    $vendeur = auth()->user();
    $cardHolder   = strtoupper(($vendeur->prenom ?? '') . ' ' . ($vendeur->nom ?? 'VENDEUR PARTENAIRE'));
    $cardNumber   = $vendeur->card_number ?? '•••• •••• •••• 0000';

    // Montants rapides pour la demande de retrait
    $pct25  = (int) floor($soldeDisponible * 0.25);
    $pct50  = (int) floor($soldeDisponible * 0.5);
    $pctMax = (int) floor($soldeDisponible);
?>

<div x-data="{ loaded: false, cardFlipped: false, retraitOpen: false, commentCaMarcheOpen: false }" x-cloak
     x-init="setTimeout(() => { loaded = true; }, 500)"
     @keydown.escape.window="retraitOpen = false"
     class="space-y-4 sm:space-y-5 pb-2">

    
    <div x-show="!loaded"
         x-transition:leave="transition ease-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4 sm:space-y-5 animate-pulse">
        
        
        <div class="h-12"></div>
        
        
        <div class="bg-slate-200/70 dark:bg-darkCard rounded-2xl h-[80px]"></div>
        
        
        <div class="relative mx-auto w-full max-w-[380px] h-[235px]">
            <div class="absolute inset-0 rounded-3xl bg-slate-200/70 dark:bg-darkCard"></div>
        </div>
        
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
                <div class="h-4 w-40 bg-slate-200 dark:bg-slate-700/40 rounded mb-4"></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($j = 0; $j < 4; $j++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="h-10 bg-slate-100 dark:bg-slate-700/20 rounded-xl mb-2"></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div x-show="loaded" x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-neonGreen/10 border border-emerald-200 dark:border-neonGreen/20 text-emerald-700 dark:text-neonGreen text-xs font-bold flex items-center gap-2"
                 x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <i class="fas fa-check-circle text-sm"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('error')): ?>
            <div class="p-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-sm"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-blue-50 dark:bg-blue-900/10 rounded-2xl p-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">Comment fonctionnent les retraits ?</h4>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-400">Suivez nos étapes simples pour gérer vos revenus.</p>
                </div>
            </div>
            <button type="button" @click="commentCaMarcheOpen = true"
                    class="px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-[11px] font-bold transition-all shadow-sm">
                Savoir plus
            </button>
        </div>

        
        
        
        <div class="relative mx-auto w-full max-w-[380px] h-[235px] [perspective:1600px]">
            <div class="absolute inset-0 transition-transform duration-700 ease-out [transform-style:preserve-3d]"
                 x-bind:style="cardFlipped ? 'transform:rotateY(180deg)' : 'transform:rotateY(0deg)'">

                
                <div class="group absolute inset-0 rounded-3xl overflow-hidden [backface-visibility:hidden]
                            bg-gradient-to-br from-[#0b1f16] via-[#0f2a1c] to-black shadow-xl shadow-black/20 border border-white/5">
                    
                    <div class="absolute inset-0 pointer-events-none opacity-40
                                bg-[repeating-linear-gradient(45deg,rgba(255,255,255,0.025)_0px,rgba(255,255,255,0.025)_1px,transparent_1px,transparent_7px)]"></div>
                    
                    <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-neonGreen/20 blur-3xl"></div>
                    <div class="absolute -bottom-16 -left-10 w-56 h-56 rounded-full bg-blue-500/10 blur-3xl"></div>
                    
                    <div class="absolute top-0 -left-1/2 w-1/3 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent
                                skew-x-12 -translate-x-full group-hover:translate-x-[420%] transition-transform duration-1000 ease-out pointer-events-none"></div>

                    <div class="relative h-full flex flex-col justify-between p-5">
                        
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[9px] sm:text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-2.5">Carte Vendeur</p>
                                <div class="flex items-center gap-2.5">
                                    
                                    <div class="relative w-9 h-7 rounded-md bg-gradient-to-br from-amber-200 via-yellow-300 to-amber-500 shadow-inner overflow-hidden">
                                        <div class="absolute inset-0 grid grid-cols-3 gap-px p-0.5">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($c = 0; $c < 6; $c++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <div class="bg-amber-600/30 rounded-[1px]"></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                    <i class="fas fa-wifi fa-rotate-90 text-white/40 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                                             <?php echo e($hasSolde ? 'bg-neonGreen/15 text-neonGreen' : 'bg-white/10 text-white/40'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($hasSolde ? 'bg-neonGreen animate-pulse' : 'bg-white/30'); ?>"></span>
                                    <?php echo e($hasSolde ? 'Actif' : 'Inactif'); ?>

                                </span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" @click="cardFlipped = true"
                                            aria-label="Voir le détail des gains"
                                            class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white/70 hover:text-white flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-neonGreen/60">
                                        <i class="fas fa-arrows-rotate text-[11px]"></i>
                                    </button>
                                    <button type="button"
                                            @click="<?php echo e($hasSolde ? 'retraitOpen = true' : ''); ?>"
                                            <?php echo e($hasSolde ? '' : 'disabled'); ?>

                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold shadow-md transition-all
                                                   <?php echo e($hasSolde
                                                        ? 'bg-neonGreen hover:bg-neonGreen-600 text-black hover:-translate-y-0.5 shadow-neonGreen/20'
                                                        : 'bg-white/10 text-white/30 cursor-not-allowed'); ?>">
                                        <i class="fas fa-paper-plane text-[9px]"></i> Retirer
                                    </button>
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            <p class="text-[9px] sm:text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-1.5">Solde disponible</p>
                            <div class="flex items-baseline gap-2">
                                <span class="font-mono font-black text-2xl sm:text-3xl text-white tracking-tight tabular-nums leading-none"><?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?></span>
                                <span class="text-xs sm:text-sm font-bold text-white/40"><?php echo e($currency); ?></span>
                            </div>
                            <p class="mt-2 font-mono text-xs sm:text-sm text-white/35 tracking-[0.25em]"><?php echo e($cardNumber); ?></p>
                        </div>

                        
                        <div class="flex items-end justify-between">
                            <div class="min-w-0">
                                <p class="text-[8px] font-bold text-white/30 uppercase tracking-[0.2em] mb-1">Titulaire</p>
                                <p class="text-xs sm:text-sm font-bold text-white/85 truncate max-w-[130px] sm:max-w-[160px]"><?php echo e($cardHolder); ?></p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-neonGreen/90 mix-blend-screen"></div>
                                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white/80 -ml-3 mix-blend-screen"></div>
                                </div>
                                <p class="text-[8px] font-bold text-white/30 uppercase tracking-[0.15em]">Wifi Pour Tous</p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="absolute inset-0 rounded-3xl overflow-hidden [backface-visibility:hidden] [transform:rotateY(180deg)]
                            bg-gradient-to-br from-[#0b1f16] via-[#0f2a1c] to-black shadow-xl shadow-black/20 border border-white/5">
                    <div class="absolute inset-0 pointer-events-none opacity-40
                                bg-[repeating-linear-gradient(45deg,rgba(255,255,255,0.025)_0px,rgba(255,255,255,0.025)_1px,transparent_1px,transparent_7px)]"></div>
                    
                    <div class="h-9 sm:h-10 bg-black/70 mt-4"></div>

                    <div class="relative p-5 flex flex-col h-[calc(100%-2.25rem)]">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-bold text-white/50 uppercase tracking-[0.2em]">Détail des gains</p>
                            <button type="button" @click="cardFlipped = false" aria-label="Retour"
                                    class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white/70 hover:text-white flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-neonGreen/60">
                                <i class="fas fa-xmark text-xs"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-3 gap-2 flex-1">
                            <div class="flex flex-col justify-center">
                                <p class="text-[8px] font-bold text-white/35 uppercase tracking-wider mb-1">Revenus</p>
                                <p class="font-mono font-black text-white text-xs sm:text-sm tabular-nums"><?php echo e(number_format($totalRevenus, 0, ',', ' ')); ?></p>
                            </div>
                            <div class="flex flex-col justify-center">
                                <p class="text-[8px] font-bold text-white/35 uppercase tracking-wider mb-1">Retiré</p>
                                <p class="font-mono font-black text-orange-400 text-xs sm:text-sm tabular-nums"><?php echo e(number_format($dejaRetire, 0, ',', ' ')); ?></p>
                            </div>
                            <div class="flex flex-col justify-center">
                                <p class="text-[8px] font-bold text-white/35 uppercase tracking-wider mb-1">Net (<?php echo e($commissionPct); ?>%)</p>
                                <p class="font-mono font-black text-neonGreen text-xs sm:text-sm tabular-nums"><?php echo e(number_format($soldeNet, 0, ',', ' ')); ?></p>
                            </div>
                        </div>

                        <button type="button"
                                @click="<?php echo e($hasSolde ? 'cardFlipped = false; retraitOpen = true' : ''); ?>"
                                <?php echo e($hasSolde ? '' : 'disabled'); ?>

                                class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-[11px] font-bold transition-all
                                       <?php echo e($hasSolde ? 'bg-neonGreen hover:bg-neonGreen-600 text-black' : 'bg-white/10 text-white/30 cursor-not-allowed'); ?>">
                            <i class="fas fa-paper-plane text-[10px]"></i> Demander un retrait
                        </button>
                    </div>
                </div>
            </div>
        </div>

        
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Historique des retraits</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                            <th class="py-2 px-4 font-bold">Date</th>
                            <th class="py-2 px-4 font-bold">Brut</th>
                            <th class="py-2 px-4 font-bold">Commission</th>
                            <th class="py-2 px-4 font-bold">Net</th>
                            <th class="py-2 px-4 font-bold text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $retraits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retrait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                <td class="py-2.5 px-4 text-slate-500 dark:text-gray-400 whitespace-nowrap">
                                    <?php echo e($retrait->date_creation ? $retrait->date_creation->format('d/m/Y H:i') : '-'); ?>

                                </td>
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white whitespace-nowrap">
                                    <?php echo e(number_format($retrait->montant_brut, 0, ',', ' ')); ?> <span class="text-[9px] text-slate-400"><?php echo e($currency); ?></span>
                                </td>
                                <td class="py-2.5 px-4 text-red-500 dark:text-red-400 whitespace-nowrap">
                                    -<?php echo e(number_format($retrait->montant_commission, 0, ',', ' ')); ?> <span class="text-[9px] text-slate-400"><?php echo e($currency); ?></span>
                                </td>
                                <td class="py-2.5 px-4 font-black text-neonGreen dark:text-neonGreen whitespace-nowrap">
                                    <?php echo e(number_format($retrait->montant_net, 0, ',', ' ')); ?> <span class="text-[9px] text-slate-400"><?php echo e($currency); ?></span>
                                </td>
                                <td class="py-2.5 px-4 text-right">
                                    <?php
                                        $statusStyle = match($retrait->statut) {
                                            'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                            'approved' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                            'paid' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                            default => 'bg-slate-100 text-slate-700 dark:bg-slate-500/10 dark:text-slate-400',
                                        };
                                    ?>
                                    <div class="flex flex-col items-end gap-0.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold <?php echo e($statusStyle); ?>">
                                            <span class="w-1.5 h-1.5 rounded-full <?php echo e(match($retrait->statut) { 'pending' => 'bg-amber-500', 'approved' => 'bg-blue-500', 'rejected' => 'bg-red-500', 'paid' => 'bg-emerald-500', default => 'bg-slate-500' }); ?>"></span>
                                            <?php echo e($retrait->statusLabel()); ?>

                                        </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($retrait->statut === 'rejected' && $retrait->note): ?>
                                            <span class="text-[9px] text-red-500 dark:text-red-400 max-w-[180px] text-right truncate" title="<?php echo e($retrait->note); ?>"><?php echo e($retrait->note); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                        <i class="fas fa-inbox text-lg"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucun retrait pour l'instant.</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                    </table>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($retraits->hasPages()): ?>
                    <div class="px-4 py-3 border-t border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-darkBg/30">
                        <?php echo e($retraits->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

    
    
    
    <div x-show="retraitOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="retraitOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div x-show="retraitOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="w-full max-w-md bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl overflow-hidden">

            <div class="flex items-center justify-between gap-2.5 px-4 py-3.5 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Demander un retrait</h3>
                </div>
                <button type="button" @click="retraitOpen = false" aria-label="Fermer"
                        class="w-7 h-7 rounded-full hover:bg-slate-100 dark:hover:bg-darkBg text-slate-400 hover:text-slate-700 dark:hover:text-white flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-neonGreen/50">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="p-4 sm:p-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasSolde): ?>
                    <p class="text-[11px] text-slate-400 dark:text-gray-500 font-medium mb-4">
                        Solde disponible : <span class="font-black text-blue-600 dark:text-blue-400"><?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <?php echo e($currency); ?></span>
                    </p>
                    <form wire:submit.prevent="demanderRetrait" class="space-y-4">
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Montant (<?php echo e($currency); ?>)</label>
                            <input type="number" x-ref="montantInput" wire:model="montant" min="1" required placeholder="Ex: 5000"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            <div class="flex items-center gap-1.5 mt-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['25%' => $pct25, '50%' => $pct50, 'Max' => $pctMax]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <button type="button"
                                            @click="$refs.montantInput.value = <?php echo e($value); ?>; $refs.montantInput.dispatchEvent(new Event('input'))"
                                            class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 dark:bg-darkBg text-slate-500 dark:text-gray-400 hover:bg-neonGreen/10 hover:text-neonGreen transition-colors">
                                        <?php echo e($label); ?>

                                    </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['montant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[11px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Numéro Mobile Money</label>
                            <input type="text" wire:model="phoneNumber" required placeholder="Ex: 66 63 59 58"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phoneNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[11px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-black text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
                                <i class="fas fa-paper-plane text-[10px]"></i> Envoyer la demande
                            </button>
                            <button type="button" @click="retraitOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-darkBorder text-[11px] font-bold text-slate-500 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-colors">
                                Annuler
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                            <i class="fas fa-wallet text-lg"></i>
                        </div>
                        <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucun solde disponible pour le moment.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div x-show="commentCaMarcheOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="commentCaMarcheOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6"
             onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Comment ça marche ?</h3>
                <button type="button" @click="commentCaMarcheOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['icon' => 'fa-cart-shopping', 'text' => 'Vos revenus s\'accumulent à chaque vente'],
                    ['icon' => 'fa-paper-plane', 'text' => 'Vous demandez un retrait quand vous voulez'],
                    ['icon' => 'fa-percent', 'text' => 'La commission ('.$commissionPct.'%) est déduite automatiquement'],
                    ['icon' => 'fa-mobile-screen', 'text' => 'Vous recevez le montant net sur Mobile Money'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full bg-neonGreen/10 text-neonGreen flex items-center justify-center text-xs font-black">
                            <?php echo e($i + 1); ?>

                        </div>
                        <p class="text-xs text-slate-600 dark:text-gray-400"><?php echo e($step['text']); ?></p>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/vendor/retrait-manager.blade.php ENDPATH**/ ?>