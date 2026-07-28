@extends('layouts.admin')
@section('sidebar') @include('components.sidebar-admin') @endsection
@section('title', 'Détails des Revenus')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
    <div class="flex items-center gap-3">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 via-emerald-500/90 to-teal-400 flex items-center justify-center text-white text-lg shadow-[0_10px_30px_-10px_rgba(16,185,129,0.55)]">
            <i class="fas fa-chart-pie"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Vue détaillée</p>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Revenus & Commissions</h2>
        </div>
    </div>
    <div class="flex items-center gap-2 mt-1 sm:mt-0">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 dark:bg-slate-700 text-white hover:bg-slate-900 text-xs font-bold transition-all">
            <i class="fas fa-arrow-left text-[10px]"></i> Retour
        </a>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-[11px] font-bold text-slate-600 dark:text-gray-400">
            <i class="fas fa-calendar-alt text-[10px]"></i>
            {{ now()->format('d M Y') }}
        </div>
    </div>
</div>
@endsection
@section('content')
@php
    use App\Services\StatsService;

    $currency = config('platform.currency') ?? 'FCFA';
    $stats = app(StatsService::class);

    $periodData = [
        '7j'  => $stats->periodData(7),
        '30j' => $stats->periodData(30),
        '90j' => $stats->periodData(90),
    ];

    $totalRevenus = $stats->totalRevenus();
    $totalCommissions = $stats->totalCommissions();
    $evo = $stats->evolution(7, 7);
    $evoRevenus = $evo['revenus_pct'];
    $evoCommissions = $evo['commissions_pct'];
    $d7 = $periodData['7j'];
    $C = ['neon' => '#00ff88', 'teal' => '#14b8a6', 'amber' => '#f59e0b', 'orange' => '#f97316'];
@endphp
    <div class="space-y-4 sm:space-y-5">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

            {{-- Total Revenus --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(0,255,136,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-money-bill-wave text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total Revenus</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            {{ number_format($totalRevenus, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">{{ $currency }}</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $stats->sparkline($periodData['7j']['revenus'], $C['neon'], 28, 'rd-rev') !!}</div>
            </div>

            {{-- Total Commissions --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-teal-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(20,184,166,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-teal-500/5 group-hover:bg-teal-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-teal-500/10 flex items-center justify-center text-teal-500 group-hover:bg-teal-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-percentage text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total Commissions</p>
                        <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-none flex items-baseline gap-1">
                            {{ number_format($totalCommissions, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">{{ $currency }}</span>
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $stats->sparkline($periodData['7j']['commissions'], $C['teal'], 28, 'rd-com') !!}</div>
            </div>

            {{-- Év. Revenus --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(245,158,11,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Év. Revenus (7j)</p>
                        <p class="text-lg sm:text-xl font-black tracking-tight leading-none {{ $evoRevenus >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                            {{ $evoRevenus >= 0 ? '+' : '' }}{{ $evoRevenus }}%
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $stats->sparkline($periodData['7j']['revenus'], $C['amber'], 28, 'rd-evor') !!}</div>
            </div>

            {{-- Év. Commissions --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-orange-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_30px_-12px_rgba(249,115,22,0.35)] group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-orange-500/5 group-hover:bg-orange-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-arrow-trend-up text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Év. Commissions (7j)</p>
                        <p class="text-lg sm:text-xl font-black tracking-tight leading-none {{ $evoCommissions >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                            {{ $evoCommissions >= 0 ? '+' : '' }}{{ $evoCommissions }}%
                        </p>
                    </div>
                </div>
                <div class="relative pointer-events-none">{!! $stats->sparkline($periodData['7j']['commissions'], $C['orange'], 28, 'rd-evoc') !!}</div>
            </div>
        </div>

        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 sm:p-5 shadow-sm" x-data="{ period: '7j' }">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-neonGreen/20 to-neonGreen/5 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white leading-tight">Évolution</h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 dark:text-gray-400 mt-0.5">Revenus & commissions</p>
                    </div>
                </div>
                <div class="inline-flex p-0.5 rounded-full bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder">
                    @foreach(['7j', '30j', '90j'] as $p)
                        <button @click="period = '{{ $p }}'; window.updateRevenueChart('{{ $p }}')"
                                :class="period === '{{ $p }}' ? 'bg-white dark:bg-darkCard text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 dark:text-gray-400 hover:text-slate-700 dark:hover:text-gray-300'"
                                class="px-2.5 py-1 rounded-full text-[11px] font-bold transition-all">
                            {{ $p }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="relative h-[220px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                    <i class="fas fa-table text-neonGreen mr-2"></i>Détails par jour
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                            <th class="py-2.5 px-4 font-bold">Jour</th>
                            <th class="py-2.5 px-4 font-bold text-right">Revenus</th>
                            <th class="py-2.5 px-4 font-bold text-right">Commission</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        @foreach($d7['labels'] as $i => $label)
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">{{ $label }}</td>
                                <td class="py-2.5 px-4 text-right font-black text-neonGreen">
                                    {{ number_format($d7['revenus'][$i], 0, ',', ' ') }} <span class="text-[9px] text-slate-400">{{ $currency }}</span>
                                </td>
                                <td class="py-2.5 px-4 text-right font-black text-amber-500">
                                    {{ number_format($d7['commissions'][$i], 0, ',', ' ') }} <span class="text-[9px] text-slate-400">{{ $currency }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('revenueChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#9ca3af' : '#94a3b8';
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.08)' : 'rgba(148, 163, 184, 0.12)';

    const allData = @json($periodData);
    const init = allData['7j'];

    function makeGradient(color, a1, a2) {
        const g = ctx.createLinearGradient(0, 0, 0, 220);
        g.addColorStop(0, color.replace(')', ', ' + a1 + ')').replace('rgb', 'rgba'));
        g.addColorStop(1, color.replace(')', ', ' + a2 + ')').replace('rgb', 'rgba'));
        return g;
    }

    const g1 = ctx.createLinearGradient(0, 0, 0, 220);
    g1.addColorStop(0, 'rgba(0, 255, 136, 0.25)');
    g1.addColorStop(1, 'rgba(0, 255, 136, 0)');

    const g2 = ctx.createLinearGradient(0, 0, 0, 220);
    g2.addColorStop(0, 'rgba(245, 158, 11, 0.22)');
    g2.addColorStop(1, 'rgba(245, 158, 11, 0)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: init.labels,
            datasets: [
                {
                    label: 'Revenus',
                    data: init.revenus,
                    borderColor: '#00ff88',
                    backgroundColor: g1,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#00ff88',
                    pointBorderColor: isDark ? '#1a1a2e' : '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#00ff88',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    yAxisID: 'y',
                },
                {
                    label: 'Commission',
                    data: init.commissions,
                    borderColor: '#f59e0b',
                    backgroundColor: g2,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: isDark ? '#1a1a2e' : '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#f59e0b',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    yAxisID: 'y1',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    align: 'center',
                    labels: {
                        color: isDark ? '#ffffff' : '#1e293b',
                        font: { size: 11, weight: '600' },
                        usePointStyle: true,
                        pointStyleWidth: 10,
                        padding: 16,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 13, weight: 'bold' },
                    displayColors: true,
                    boxWidth: 8,
                    boxHeight: 8,
                    usePointStyle: true,
                    callbacks: {
                        label: function (c) {
                            return '  ' + c.dataset.label + ' : ' + new Intl.NumberFormat('fr-FR').format(c.parsed.y) + ' {{ $currency }}';
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 10, weight: '600' } },
                    border: { display: false },
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    grid: { color: gridColor },
                    ticks: {
                        color: textColor,
                        font: { size: 10, weight: '600' },
                        callback: function (v) { return v >= 1000 ? (v / 1000) + 'k' : v; },
                        maxTicksLimit: 5,
                    },
                    border: { display: false },
                    title: { display: true, text: 'Revenus', color: '#00ff88', font: { size: 10, weight: 'bold' } },
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: {
                        color: textColor,
                        font: { size: 10, weight: '600' },
                        callback: function (v) { return v >= 1000 ? (v / 1000) + 'k' : v; },
                        maxTicksLimit: 5,
                    },
                    border: { display: false },
                    title: { display: true, text: 'Commission', color: '#f59e0b', font: { size: 10, weight: 'bold' } },
                },
            },
        },
    });

    window.updateRevenueChart = function(period) {
        const d = allData[period];
        if (!d) return;
        chart.data.labels = d.labels;
        chart.data.datasets[0].data = d.revenus;
        chart.data.datasets[1].data = d.commissions;
        chart.update();
    };
});
</script>
@endpush
@endsection
