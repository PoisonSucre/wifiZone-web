@php
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
@endphp

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="space-y-4 sm:space-y-5 pb-2">

    {{-- SKELETON --}}
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4 animate-pulse">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @for ($i = 0; $i < 5; $i++)
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
            @endfor
        </div>
        <div class="grid grid-cols-3 gap-3">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[72px]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2.5"></div>
                            <div class="h-4 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                </div>
            @endfor
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
                @for ($j = 0; $j < 5; $j++)
                    <div class="flex items-center gap-3">
                        <div class="h-2.5 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700/40 shrink-0"></div>
                            <div class="h-2.5 w-24 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                        <div class="h-5 w-14 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        <div class="ml-auto h-2.5 w-16 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ALERTE TRANSACTIONS BLOQUÉES --}}
    @if($checkMessage)
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="flex flex-wrap items-center gap-3 p-3 rounded-2xl {{ $checkSuccess ? 'bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20' : 'bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20' }}">
        <div class="w-8 h-8 shrink-0 rounded-lg {{ $checkSuccess ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-500' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} flex items-center justify-center text-xs">
            <i class="fas {{ $checkSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
        </div>
        <p class="flex-1 min-w-0 text-xs sm:text-sm font-bold {{ $checkSuccess ? 'text-emerald-700 dark:text-emerald-400' : 'text-red-700 dark:text-red-400' }}">{{ $checkMessage }}</p>
        <button @click="show = false" class="ml-auto w-6 h-6 shrink-0 rounded-lg {{ $checkSuccess ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-500' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} hover:opacity-70 transition-all flex items-center justify-center">
            <i class="fas fa-times text-[9px]"></i>
        </button>
    </div>
    @endif

    {{-- ALERTE TICKETS MANQUANTS --}}
    @if($stuckCount > 0)
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         class="flex flex-wrap items-start gap-3 p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
        <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-500 text-sm">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-extrabold text-amber-700 dark:text-amber-400">{{ $stuckCount }} transaction(s) confirmée(s) sans ticket attribué</p>
            <p class="text-xs text-amber-600/70 dark:text-amber-400/70 mt-0.5">Ces clients ont payé mais n'ont pas reçu leur ticket.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <a href="{{ route('vendor.alertes') }}"
               class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all flex items-center gap-1.5">
                <i class="fas fa-external-link-alt text-[10px]"></i>
                Voir
            </a>
            <button @click="show = false" class="w-7 h-7 shrink-0 rounded-lg flex items-center justify-center bg-amber-100 dark:bg-amber-500/20 text-amber-500 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- STATS GRID --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

            {{-- Revenus --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(0,255,136,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-money-bill-wave text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Revenus</p>
                        <p class="text-[15px] sm:text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1 min-w-0 truncate">
                            {{ number_format($totalRevenus, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">{{ $currency }}</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $sparkline($evo['revenus'], $C['neon'], 28, 'revenus') !!}</div>
            </div>

            {{-- Solde Dispo --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(59,130,246,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-wallet text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Solde Dispo</p>
                        <p class="text-[15px] sm:text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1 min-w-0 truncate">
                            {{ number_format($soldeDisponible, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">{{ $currency }}</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $sparkline($evo['solde'], $C['blue'], 28, 'solde') !!}</div>
            </div>

            {{-- Aujourd'hui --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(245,158,11,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-calendar-day text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Aujourd'hui</p>
                        <p class="text-[15px] sm:text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1 min-w-0 truncate">
                            {{ number_format($revenusAujourdhui, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">{{ $currency }}</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $sparkline($evo['revenus'], $C['amber'], 28, 'aujourdhui') !!}</div>
            </div>

            {{-- Vendus --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-purple-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(168,85,247,0.45)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-purple-500/5 group-hover:bg-purple-500/15 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Vendus</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $totalVendus }}</p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $sparkline($evo['vendus'], $C['purple'], 28, 'vendus') !!}</div>
            </div>

            {{-- Restants --}}
            <div class="relative col-span-2 sm:col-span-1 bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-pink-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(236,72,153,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-pink-500/5 group-hover:bg-pink-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Restants</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $totalDispo }}</p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $sparkline($evo['dispo'], $C['pink'], 28, 'dispo') !!}</div>
            </div>
        </div>

        {{-- GRAPHIQUE --}}
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

        {{-- VENTES RÉCENTES --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm flex flex-col h-full overflow-hidden">
            <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-history text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Ventes Récentes</h3>
                </div>
                <a href="{{ route('vendor.tickets') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-neonGreen hover:text-neonGreen-600 transition-colors">
                    Voir tous <i class="fas fa-arrow-right text-[9px]"></i>
                </a>
            </div>
            <div class="md:hidden divide-y divide-slate-50 dark:divide-darkBorder/20">
                @forelse(array_slice($recentSales, 0, 5) as $sale)
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-7 h-7 shrink-0 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center text-blue-500 text-[10px] font-black">
                                    {{ strtoupper(substr($sale['user'] ?? 'U', 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $sale['user'] ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($sale['date_creation'])->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                {{ $sale['forfait'] ?? '-' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Montant</span>
                            <span class="text-sm font-black text-slate-900 dark:text-white">
                                {{ number_format($sale['montant'], 0, ',', ' ') }} <span class="text-[9px] text-slate-400">{{ $currency }}</span>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                            <i class="fas fa-inbox text-lg"></i>
                        </div>
                        <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucune vente récente.</p>
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                            <th class="py-2 px-4 font-bold">Date</th>
                            <th class="py-2 px-4 font-bold">Utilisateur</th>
                            <th class="py-2 px-4 font-bold">Forfait</th>
                            <th class="py-2 px-4 font-bold text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        @forelse(array_slice($recentSales, 0, 5) as $sale)
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                <td class="py-2.5 px-4 text-slate-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($sale['date_creation'])->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center text-blue-500 text-[10px] font-black">
                                            {{ strtoupper(substr($sale['user'] ?? 'U', 0, 2)) }}
                                        </div>
                                        <span class="truncate max-w-[140px]">{{ $sale['user'] ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        {{ $sale['forfait'] ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 font-black text-slate-900 dark:text-white text-right whitespace-nowrap">
                                    {{ number_format($sale['montant'], 0, ',', ' ') }} <span class="text-[9px] text-slate-400">{{ $currency }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                        <i class="fas fa-inbox text-lg"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucune vente récente.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function initRevenueChart() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    if (ctx._chartInitialized) return;
    ctx._chartInitialized = true;

    const labels = @js($chartLabels);
    const datasets = @js($chartDatasets);

    if (!labels.length || !datasets.length) return;

    const isDark = document.documentElement.classList.contains('dark');
    const legendColor = isDark ? '#ffffff' : '#1e293b';
    const isMobile = window.innerWidth < 640;

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
                    position: isMobile ? 'bottom' : 'top',
                    labels: {
                        color: legendColor,
                        font: { size: isMobile ? 10 : 12, weight: '500' },
                        usePointStyle: true,
                        pointStyleWidth: isMobile ? 6 : 10,
                        boxHeight: isMobile ? 6 : 10,
                        padding: isMobile ? 8 : 16,
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
                            return ' ' + ctx.dataset.label + '  :  ' + val + ' {{ $currency }}';
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
                    ticks: { color: '#9ca3af', font: { size: isMobile ? 9 : 11 }, maxRotation: 0, maxTicksLimit: isMobile ? 5 : 30 },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.08)', drawBorder: false },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: isMobile ? 9 : 11 },
                        maxTicksLimit: isMobile ? 4 : 8,
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
@endpush
