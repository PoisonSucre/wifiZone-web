

<?php
    // ====================================================================
    //  A) HELPER SPARKLINE (SVG pur, aucune dépendance JS)
    // ====================================================================
    $sparkline = function (array $data, string $color, int $h = 28, string $key = 'sp'): string {
        $data = array_values(array_filter($data, fn ($v) => is_numeric($v)));
        if (count($data) < 2) {
            $midY = $h / 2;
            $id   = 'sp_' . preg_replace('/[^a-z0-9]/i', '', $key);
            return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
                . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
                . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
                . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
                . '</linearGradient></defs>'
                . '<polygon points="0,' . $midY . ' 100,' . $midY . ' 100,' . $h . ' 0,' . $h . '" fill="url(#' . $id . ')"/>'
                . '<polyline points="0,' . $midY . ' 100,' . $midY . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>'
                . '</svg>';
        }
        $max   = max($data);
        $min   = min($data);
        $range = max($max - $min, 0.0001);
        $n     = count($data);
        $pts   = [];
        foreach ($data as $i => $v) {
            $x = ($i / ($n - 1)) * 100;
            $y = $h - (($v - $min) / $range) * ($h - 6) - 3;
            $pts[] = round($x, 2) . ',' . round($y, 2);
        }
        $line = implode(' ', $pts);
        $area = $line . " 100,{$h} 0,{$h}";
        $id   = 'sp_' . preg_replace('/[^a-z0-9]/i', '', $key);

        return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
            . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
            . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
            . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
            . '</linearGradient></defs>'
            . '<polygon points="' . $area . '" fill="url(#' . $id . ')"/>'
            . '<polyline points="' . $line . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>'
            . '</svg>';
    };

    // ====================================================================
    //  B) PALETTE DE COULEURS
    // ====================================================================
    $C = [
        'neon'   => '#00ff88',
        'blue'   => '#3b82f6',
        'amber'  => '#f59e0b',
        'purple' => '#a855f7',
        'pink'   => '#ec4899',
        'red'    => '#ef4444',
    ];

    // ====================================================================
    //  C) DONNÉES — Directement depuis les propriétés Livewire
    // ====================================================================

    // --- KPI principaux ---
    $totalVendeurs          = $totalVendeurs          ?? 0;
    $vendeursActifs         = $vendeursActifs         ?? 0;
    $vendeursEnAttente      = $vendeursEnAttente      ?? 0;
    $totalTickets           = $totalTickets           ?? 0;
    $ticketsVendus          = $ticketsVendus          ?? 0;
    $totalRevenus           = $totalRevenus           ?? 0;
    $totalCommission        = $totalCommission        ?? 0;
    $nbRetraitsEnCours      = $nbRetraitsEnCours      ?? 0;
    $montantRetraitsEnCours = $montantRetraitsEnCours ?? 0;

    // --- Évolution (8 derniers jours) pour les sparklines ---
    $evo = [
        'vendeurs'    => $vendeursEvolution    ?? [],
        'actifs'      => $actifsEvolution      ?? [],
        'suspendus'   => $suspendusEvolution   ?? [],
        'attente'     => $attenteEvolution     ?? [],
        'tickets'     => $ticketsEvolution     ?? [],
        'vendus'      => $vendusEvolution      ?? [],
        'revenus'     => $revenusEvolution     ?? [],
        'commission'  => $commissionEvolution  ?? [],
        'retraits'    => $retraitsEvolution    ?? [],
    ];

    // --- Graphique principal (7 derniers jours) ---
    $chartLabels      = $chartLabels      ?? [];
    $chartRevenus     = $chartRevenus     ?? [];
    $chartCommissions = $chartCommissions ?? [];

    // --- Derniers vendeurs pour la table ---
    $derniersVendeurs = $derniersVendeurs ?? [];

    // --- Dernières transactions pour la table ---
    $dernieresTransactions = $dernieresTransactions ?? [];

    // Devise (tu peux aussi surcharger via config)
    $currency = config('platform.currency') ?? 'FCFA';
?>

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="space-y-4 sm:space-y-5 pb-2">

    
    
    
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4 animate-pulse">

        

        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[100px] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2.5"></div>
                            <div class="h-5 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                    <div class="h-6 w-full bg-slate-100 dark:bg-slate-700/20 rounded-md"></div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 2; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden">
                    <div class="h-12 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30 flex items-center px-4 gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="h-3 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    </div>
                    <div class="p-4 space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($j = 0; $j < 4; $j++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700/40 shrink-0"></div>
                                <div class="flex-1 space-y-1.5">
                                    <div class="h-2.5 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                                    <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    
    
    
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(0,255,136,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total Vendeurs</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalVendeurs); ?></p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['vendeurs'], $C['neon'], 28, 'vendeurs'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(59,130,246,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-user-check text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Actifs</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($vendeursActifs); ?></p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['actifs'], $C['blue'], 28, 'actifs'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-purple-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(168,85,247,0.45)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-purple-500/5 group-hover:bg-purple-500/15 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-percentage text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total Commission</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e(number_format($totalCommission, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e($currency); ?></span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['commission'], $C['purple'], 28, 'commission'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(245,158,11,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-wallet text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total Retraits</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e(number_format($totalRetraits, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e($currency); ?></span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['retraits'], $C['amber'], 28, 'retraits'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-red-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(239,68,68,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-red-500/5 group-hover:bg-red-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-credit-card text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Retraits en cours</p>
                        <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e($nbRetraitsEnCours); ?> <span class="text-[10px] text-slate-400 font-bold">(<?php echo e(number_format($montantRetraitsEnCours, 0, ',', ' ')); ?>)</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['retraits'], $C['red'], 28, 'retraits'); ?></div>
            </div>
        </div>

        
        

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeursEnAttente > 0): ?>
            <div class="flex items-center gap-3 p-3 sm:p-4 text-sm bg-gradient-to-r from-amber-50 to-orange-50/50 dark:from-amber-900/10 dark:to-orange-900/5 border border-amber-200/70 dark:border-amber-800/30 rounded-2xl shadow-sm">
                <div class="relative w-9 h-9 shrink-0 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <i class="fas fa-exclamation-triangle text-sm"></i>
                    <span class="absolute inset-0 rounded-xl bg-amber-400/30 animate-ping"></span>
                </div>
                <p class="flex-1 text-slate-700 dark:text-gray-300 text-[13px]">
                    <strong class="font-extrabold text-slate-900 dark:text-white"><?php echo e($vendeursEnAttente); ?> vendeur(s)</strong> en attente d'approbation.
                </p>
                <a href="/raider/vendeurs" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md whitespace-nowrap">
                    Approuver <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm flex flex-col h-full overflow-hidden">
                <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                            <i class="fas fa-user-plus text-xs"></i>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Derniers Vendeurs</h3>
                    </div>
                    <a href="/raider/vendeurs" class="text-[11px] font-bold text-slate-400 hover:text-neonGreen transition-colors flex items-center gap-1">
                        Tout voir <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                                <th class="py-2 px-4 font-bold">Nom</th>
                                <th class="py-2 px-4 font-bold">Email</th>
                                <th class="py-2 px-4 font-bold text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-slate-700 dark:text-gray-300">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $derniersVendeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                    <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white group-hover:text-neonGreen transition-colors">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-neonGreen/20 to-neonGreen/5 flex items-center justify-center text-neonGreen text-[10px] font-black">
                                                <?php echo e(strtoupper(substr($v['prenom'], 0, 1))); ?><?php echo e(strtoupper(substr($v['nom'], 0, 1))); ?>

                                            </div>
                                            <span class="truncate"><?php echo e($v['prenom']); ?> <?php echo e($v['nom']); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-4 text-slate-500 dark:text-gray-400 truncate max-w-[180px]"><?php echo e($v['email']); ?></td>
                                    <td class="py-2.5 px-4 text-slate-500 text-right whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($v['date_inscription'])->format('d/m/Y')); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="3" class="py-10 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                            <i class="fas fa-inbox text-lg"></i>
                                        </div>
                                        <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucun vendeur récent.</p>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm flex flex-col h-full overflow-hidden">
                <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                            <i class="fas fa-exchange-alt text-xs"></i>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Dernières Transactions</h3>
                    </div>
                    <a href="/raider/transactions" class="text-[11px] font-bold text-slate-400 hover:text-neonGreen transition-colors flex items-center gap-1">
                        Tout voir <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                                <th class="py-2 px-4 font-bold">Date</th>
                                <th class="py-2 px-4 font-bold">Vendeur</th>
                                <th class="py-2 px-4 font-bold text-right">Montant</th>
                                <th class="py-2 px-4 font-bold text-right">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-slate-700 dark:text-gray-300">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $dernieresTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                    <td class="py-2.5 px-4 text-slate-500 whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($t['date_creation'])->format('d/m/Y H:i')); ?></td>
                                    <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center text-blue-500 text-[10px] font-black">
                                                <?php echo e(strtoupper(substr($t['vendeur']['prenom'] ?? '', 0, 1))); ?><?php echo e(strtoupper(substr($t['vendeur']['nom'] ?? '', 0, 1))); ?>

                                            </div>
                                            <span class="truncate max-w-[120px]"><?php echo e($t['vendeur']['prenom'] ?? ''); ?> <?php echo e($t['vendeur']['nom'] ?? ''); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-4 font-black text-slate-900 dark:text-white text-right whitespace-nowrap">
                                        <?php echo e(number_format($t['montant'], 0, ',', ' ')); ?> <span class="text-[9px] text-slate-400"><?php echo e($currency); ?></span>
                                    </td>
                                    <td class="py-2.5 px-4 text-right">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($t['statut'] === 'completed'): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Complétée
                                            </span>
                                        <?php elseif($t['statut'] === 'pending'): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> En attente
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Annulée
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="4" class="py-10 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                            <i class="fas fa-receipt text-lg"></i>
                                        </div>
                                        <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucune transaction.</p>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/dashboard.blade.php ENDPATH**/ ?>