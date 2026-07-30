<?php
    // === SPARKLINE HELPER ===
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

    $C = [
        'neon'   => '#00ff88',
        'blue'   => '#3b82f6',
        'amber'  => '#f59e0b',
        'purple' => '#a855f7',
        'pink'   => '#ec4899',
        'red'    => '#ef4444',
        'orange' => '#f97316',
        'teal'   => '#14b8a6',
    ];

    $totalRevenus       = $totalRevenus       ?? 0;
    $soldeDisponible    = $soldeDisponible    ?? 0;
    $revenusAujourdhui  = $revenusAujourdhui  ?? 0;
    $totalVendus        = $totalVendus        ?? 0;
    $totalDispo         = $totalDispo         ?? 0;
    $dejaRetire         = $dejaRetire         ?? 0;
    $commissionPct      = $commissionPct      ?? 0;
    $soldeNet           = $soldeNet           ?? 0;

    $evo = [
        'revenus'  => $revenusEvolution  ?? [],
        'solde'    => $soldeEvolution    ?? [],
        'vendus'   => $vendusEvolution   ?? [],
        'dispo'    => $dispoEvolution    ?? [],
        'retraits' => $retraitsEvolution ?? [],
    ];

    $chartLabels      = $chartLabels      ?? [];
    $chartDatasets    = $chartDatasets    ?? [];
    $stuckTransactions = $stuckTransactions ?? [];
    $stuckCount = count($stuckTransactions);
    $recentSales      = $recentSales      ?? [];
    $dispoParForfait  = $dispoParForfait  ?? [];

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
        <div class="grid grid-cols-3 gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 3; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[72px]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2.5"></div>
                            <div class="h-4 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                <div>
                    <div class="h-3.5 w-36 bg-slate-200 dark:bg-slate-700/40 rounded mb-1.5"></div>
                    <div class="h-2.5 w-24 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                </div>
            </div>
            <div class="h-[220px] bg-slate-100 dark:bg-slate-700/20 rounded-xl"></div>
        </div>
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700/40"></div>
                    <div class="h-4 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                </div>
                <div class="h-3 w-14 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
            </div>
            <div class="p-4 space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($j = 0; $j < 5; $j++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex items-center gap-3">
                        <div class="h-2.5 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700/40 shrink-0"></div>
                            <div class="h-2.5 w-24 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                        <div class="h-5 w-14 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="ml-auto h-2.5 w-16 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checkMessage): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="flex items-center gap-3 p-3 rounded-2xl <?php echo e($checkSuccess ? 'bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20' : 'bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20'); ?>">
        <div class="w-8 h-8 shrink-0 rounded-lg <?php echo e($checkSuccess ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-500' : 'bg-red-100 dark:bg-red-500/20 text-red-500'); ?> flex items-center justify-center text-xs">
            <i class="fas <?php echo e($checkSuccess ? 'fa-check-circle' : 'fa-exclamation-circle'); ?>"></i>
        </div>
        <p class="text-sm font-bold <?php echo e($checkSuccess ? 'text-emerald-700 dark:text-emerald-400' : 'text-red-700 dark:text-red-400'); ?>"><?php echo e($checkMessage); ?></p>
        <button @click="show = false" class="ml-auto w-6 h-6 shrink-0 rounded-lg <?php echo e($checkSuccess ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-500' : 'bg-red-100 dark:bg-red-500/20 text-red-500'); ?> hover:opacity-70 transition-all flex items-center justify-center">
            <i class="fas fa-times text-[9px]"></i>
        </button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stuckCount > 0): ?>
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         class="flex items-start gap-3 p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
        <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-500 text-sm">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-extrabold text-amber-700 dark:text-amber-400"><?php echo e($stuckCount); ?> transaction(s) confirmée(s) sans ticket attribué</p>
            <p class="text-xs text-amber-600/70 dark:text-amber-400/70 mt-0.5">Ces clients ont payé mais n'ont pas reçu leur ticket.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="<?php echo e(route('vendor.alertes')); ?>"
               class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all flex items-center gap-1.5">
                <i class="fas fa-external-link-alt text-[10px]"></i>
                Voir
            </a>
            <button @click="show = false" class="w-7 h-7 shrink-0 rounded-lg flex items-center justify-center bg-amber-100 dark:bg-amber-500/20 text-amber-500 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
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
                        <i class="fas fa-money-bill-wave text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Revenus</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e(number_format($totalRevenus, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e($currency); ?></span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['revenus'], $C['neon'], 28, 'revenus'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(59,130,246,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-wallet text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Solde Dispo</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e(number_format($soldeDisponible, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e($currency); ?></span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['solde'], $C['blue'], 28, 'solde'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(245,158,11,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-calendar-day text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Aujourd'hui</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            <?php echo e(number_format($revenusAujourdhui, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e($currency); ?></span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['revenus'], $C['amber'], 28, 'aujourdhui'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-purple-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(168,85,247,0.45)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-purple-500/5 group-hover:bg-purple-500/15 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Vendus</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalVendus); ?></p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['vendus'], $C['purple'], 28, 'vendus'); ?></div>
            </div>

            
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-pink-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(236,72,153,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-pink-500/5 group-hover:bg-pink-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Restants</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalDispo); ?></p>
                    </div>
                </div>
                <div class="relative pointer-events-none"><?php echo $sparkline($evo['dispo'], $C['pink'], 28, 'dispo'); ?></div>
            </div>
        </div>

        
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-neonGreen/20 to-neonGreen/5 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white leading-tight">Revenus par forfait</h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-400 mt-0.5">30 derniers jours</p>
                    </div>
                </div>
            </div>
            <div class="relative h-[220px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm flex flex-col h-full overflow-hidden">
            <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Ventes Récentes</h3>
                </div>
                <a href="<?php echo e(route('vendor.tickets')); ?>" class="inline-flex items-center gap-1 text-[11px] font-bold text-neonGreen hover:text-neonGreen-600 transition-colors">
                    Voir tous <i class="fas fa-arrow-right text-[9px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                            <th class="py-2 px-4 font-bold">Date</th>
                            <th class="py-2 px-4 font-bold">Utilisateur</th>
                            <th class="py-2 px-4 font-bold">Forfait</th>
                            <th class="py-2 px-4 font-bold text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = array_slice($recentSales, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                <td class="py-2.5 px-4 text-slate-500 dark:text-gray-400 whitespace-nowrap">
                                    <?php echo e(\Carbon\Carbon::parse($sale['date_creation'])->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center text-blue-500 text-[10px] font-black">
                                            <?php echo e(strtoupper(substr($sale['user'] ?? 'U', 0, 2))); ?>

                                        </div>
                                        <span class="truncate max-w-[140px]"><?php echo e($sale['user'] ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <?php echo e($sale['forfait'] ?? '-'); ?>

                                    </span>
                                </td>
                                <td class="py-2.5 px-4 font-black text-slate-900 dark:text-white text-right whitespace-nowrap">
                                    <?php echo e(number_format($sale['montant'], 0, ',', ' ')); ?> <span class="text-[9px] text-slate-400"><?php echo e($currency); ?></span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="4" class="py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                        <i class="fas fa-inbox text-lg"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucune vente récente.</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function initRevenueChart() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    if (ctx._chartInitialized) return;
    ctx._chartInitialized = true;

    const labels = <?php echo \Illuminate\Support\Js::from($chartLabels)->toHtml() ?>;
    const datasets = <?php echo \Illuminate\Support\Js::from($chartDatasets)->toHtml() ?>;

    if (!labels.length || !datasets.length) return;

    const isDark = document.documentElement.classList.contains('dark');
    const legendColor = isDark ? '#ffffff' : '#1e293b';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: legendColor,
                        font: { size: 12, weight: '500' },
                        usePointStyle: true,
                        pointStyleWidth: 10,
                        padding: 16,
                        generateLabels: function(chart) {
                            return chart.data.datasets.map(function(ds, i) {
                                var meta = chart.getDatasetMeta(i);
                                var total = ds.data.reduce(function(a, b) { return a + b; }, 0);
                                if (total === 0) return null;
                                return {
                                    text: ds.label,
                                    fillStyle: ds.borderColor,
                                    strokeStyle: ds.borderColor,
                                    fontColor: legendColor,
                                    lineWidth: 0,
                                    hidden: !meta.visible,
                                    datasetIndex: i,
                                    pointStyle: ds.pointStyle || 'circle',
                                };
                            }).filter(Boolean);
                        }
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(15,23,42,0.92)',
                    titleColor: '#f1f5f9',
                    titleFont: { size: 13, weight: '700' },
                    bodyColor: '#cbd5e1',
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    boxPadding: 4,
                    filter: function(tooltipItem) {
                        return tooltipItem.parsed.y > 0;
                    },
                    callbacks: {
                        title: function(items) {
                            return '📅 ' + items[0].label;
                        },
                        label: function(ctx) {
                            var val = ctx.parsed.y.toLocaleString('fr-FR');
                            return ' ' + ctx.dataset.label + '  :  ' + val + ' <?php echo e($currency); ?>';
                        }
                    },
                    itemSort: function(a, b) {
                        return b.parsed.y - a.parsed.y;
                    },
                },
            },
            scales: {
                x: {
                    grid: { color: 'rgba(156,163,175,0.08)', drawBorder: false },
                    ticks: { color: '#9ca3af', font: { size: 11 }, maxRotation: 0 },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.08)', drawBorder: false },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 11 },
                        callback: function(v) { return v.toLocaleString('fr-FR'); },
                    },
                }
            },
            animation: {
                duration: 800,
                easing: 'easeOutQuart',
            },
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initRevenueChart, 300);
});

document.addEventListener('livewire:navigated', function() {
    var old = Chart.getChart('revenueChart');
    if (old) old.destroy();
    var ctx = document.getElementById('revenueChart');
    if (ctx) ctx._chartInitialized = false;
    setTimeout(initRevenueChart, 50);
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/vendor/dashboard.blade.php ENDPATH**/ ?>