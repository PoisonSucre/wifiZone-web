@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Gestion: ' . $hotspot->name)

@php
    $nbDispo = $hotspot->tickets()->available()->count();
    $nbVendus = $hotspot->tickets()->sold()->count();
    $nbForfaits = $hotspot->forfaits()->count();
    $total = $nbDispo + $nbVendus;
    $txVente = $total > 0 ? round($nbVendus / $total * 100) : 0;
    $isActif = $hotspot->statut === 'actif';

    // Historique 7 jours : ventes et ajouts de stock (vrais agrégats)
    $days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());
    $ventesParJour = $days->map(function ($d) use ($hotspot) {
        return $hotspot->tickets()->where('status', 'vendu')
            ->whereDate('created_at', $d)->count();
    })->toArray();
    $ajoutsParJour = $days->map(function ($d) use ($hotspot) {
        return $hotspot->tickets()->whereDate('created_at', $d)->count();
    })->toArray();

    // Répartition des tickets vendus par forfait (donnée réelle pour la carte Forfaits)
    $repForfaits = \App\Models\Ticket::where('hotspot_id', $hotspot->id)
        ->where('status', 'vendu')
        ->selectRaw('forfait, COUNT(*) as nb')
        ->groupBy('forfait')
        ->orderByDesc('nb')
        ->pluck('nb')
        ->toArray();
    if (empty($repForfaits)) {
        $repForfaits = [0];
    }

    // === SPARKLINE HELPER (identique au dashboard vendeur) ===
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
@endphp

@section('header')
<div class="flex items-center justify-between gap-2 pb-1">
    <div class="flex items-center gap-2.5 min-w-0">
        {{-- SIGNATURE : icône hotspot (identique à la page hotspots) --}}
        <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-[0_8px_20px_-8px_rgba(6,182,212,0.4)]">
            <i class="fas fa-wifi text-sm"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-darkCard
                         {{ $isActif ? 'bg-red-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
        </div>
        <div class="min-w-0">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Point d'accès</p>
            <div class="flex items-center gap-2 mt-0.5">
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">{{ $hotspot->name }}</h2>
                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                             {{ $isActif ? 'bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-gray-500' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isActif ? 'bg-red-500 animate-pulse' : 'bg-slate-400' }}"></span>
                    {{ $isActif ? 'En ligne' : 'Hors ligne' }}
                </span>
            </div>
        </div>
    </div>
    <a href="{{ route('vendor.hotspot') }}" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-white dark:text-black text-[10px] font-bold transition shrink-0">
        <i class="fas fa-arrow-left text-[9px]"></i> <span class="hidden sm:inline">Tous les hotspots</span><span class="inline sm:hidden">Hotspots</span>
    </a>
</div>
@endsection

@section('content')
<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="relative space-y-5 sm:space-y-6 pb-2">

    {{-- SKELETON --}}
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 z-10 space-y-5 animate-pulse">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5 h-[104px]"></div>
            @endfor
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-6 h-[220px]"></div>
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-6 h-[220px]"></div>
        </div>
    </div>

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded" x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-5 sm:space-y-6 relative z-[1]">

        {{-- BANDEAU MÉTRIQUES --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            {{-- Disponibles --}}
            <div class="group relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl p-4 sm:p-5 transition-all duration-300 overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.18em]">En stock</span>
                    <span class="w-9 h-9 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black transition-colors">
                        <i class="fas fa-ticket-alt text-xs"></i>
                    </span>
                </div>
                <p class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-none tabular-nums">{{ $nbDispo }}</p>
                <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-1 font-medium">tickets disponibles</p>
                <div class="mt-3 -mx-1">{!! $sparkline($ajoutsParJour, '#10B981', 28, 'hd_dispo') !!}</div>
            </div>

            {{-- Vendus --}}
            <div class="group relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl p-4 sm:p-5 transition-all duration-300 overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.18em]">Vendus</span>
                    <span class="w-9 h-9 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <i class="fas fa-check-circle text-xs"></i>
                    </span>
                </div>
                <p class="text-3xl sm:text-4xl font-black text-blue-600 dark:text-blue-400 tracking-tight leading-none tabular-nums">{{ $nbVendus }}</p>
                <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-1 font-medium">tickets écoulés</p>
                <div class="mt-3 -mx-1">{!! $sparkline($ventesParJour, '#3B82F6', 28, 'hd_vendus') !!}</div>
            </div>

            {{-- Forfaits --}}
            <div class="group relative col-span-2 sm:col-span-1 bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl p-4 sm:p-5 transition-all duration-300 overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.18em]">Forfaits</span>
                    <span class="w-9 h-9 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <i class="fas fa-tags text-xs"></i>
                    </span>
                </div>
                <p class="text-3xl sm:text-4xl font-black text-amber-600 dark:text-amber-400 tracking-tight leading-none tabular-nums">{{ $nbForfaits }}</p>
                <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-1 font-medium">offres configurées</p>
                <div class="mt-3 -mx-1">{!! $sparkline($repForfaits, '#F59E0B', 28, 'hd_forfaits') !!}</div>
            </div>
        </div>

        {{-- JAUGE DE VENTE (info réelle, pas décorative) --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 sm:px-5">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[11px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Taux de vente</span>
                <span class="text-[11px] font-bold text-slate-700 dark:text-gray-200 tabular-nums">{{ $txVente }}% · {{ $nbVendus }}/{{ $total }}</span>
            </div>
            <div class="h-2 rounded-full bg-slate-100 dark:bg-darkBg overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-neonGreen to-blue-500 transition-all duration-700"
                     style="width: {{ $txVente }}%"></div>
            </div>
        </div>

        {{-- IDENTITÉ & ACTIONS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Fiche identité --}}
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-6">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">Fiche du point d'accès</h3>
                <dl class="space-y-0">
                    <div class="flex items-start justify-between gap-4 py-3 border-b border-slate-100 dark:border-darkBorder/40">
                        <dt class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Description</dt>
                        <dd class="text-sm text-slate-700 dark:text-gray-200 font-medium text-right max-w-[60%]">{{ $hotspot->description ?: '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 py-3 border-b border-slate-100 dark:border-darkBorder/40">
                        <dt class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Statut</dt>
                        <dd>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                         {{ $isActif ? 'bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $isActif ? 'bg-red-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                {{ $isActif ? 'En ligne' : 'Hors ligne' }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-4 py-3">
                        <dt class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Créé le</dt>
                        <dd class="text-sm text-slate-700 dark:text-gray-200 font-medium tabular-nums">{{ $hotspot->created_at ? $hotspot->created_at->format('d/m/Y') : '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Actions --}}
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-6">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">Gérer ce hotspot</h3>
                <div class="grid grid-cols-1 gap-2.5">
                    <a href="{{ route('vendor.tickets', ['hotspot' => $hotspot->id]) }}"
                       wire:navigate
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl bg-neonGreen/10 hover:bg-neonGreen hover:text-white dark:bg-neonGreen/10 dark:hover:bg-neonGreen text-neonGreen dark:text-neonGreen-400 font-bold transition-all border border-neonGreen/20 dark:border-neonGreen/20 shadow-sm hover:shadow-neon-glow">
                        <span class="w-9 h-9 shrink-0 rounded-lg bg-neonGreen/15 flex items-center justify-center text-neonGreen group-hover:bg-white/20 group-hover:text-white transition-colors">
                            <i class="fas fa-ticket-alt text-sm"></i>
                        </span>
                        <span class="flex-1">
                            <span class="block text-[13px] font-extrabold tracking-tight leading-tight">Tickets</span>
                            <span class="block text-[10px] font-medium text-slate-500 dark:text-gray-400 group-hover:text-white">Voir les tickets de ce hotspot</span>
                        </span>
                        <i class="fas fa-chevron-right text-[10px] opacity-50 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>

                    <a href="{{ route('vendor.boutique', ['hotspot' => $hotspot->id]) }}"
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-slate-900 hover:text-white dark:bg-slate-800/40 dark:hover:bg-slate-700 text-slate-700 dark:text-gray-300 font-bold transition-all border border-slate-200 dark:border-darkBorder">
                        <span class="w-9 h-9 shrink-0 rounded-lg bg-slate-200/70 dark:bg-slate-700/60 flex items-center justify-center text-slate-500 dark:text-gray-400 group-hover:bg-white/20 group-hover:text-white transition-colors">
                            <i class="fas fa-store text-sm"></i>
                        </span>
                        <span class="flex-1">
                            <span class="block text-[13px] font-extrabold tracking-tight leading-tight">Portail</span>
                            <span class="block text-[10px] font-medium text-slate-500 dark:text-gray-400 group-hover:text-white">Personnaliser le portail</span>
                        </span>
                        <i class="fas fa-chevron-right text-[10px] opacity-50 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>

                    <a href="{{ route('vendor.import', ['hotspot' => $hotspot->id]) }}"
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-slate-900 hover:text-white dark:bg-slate-800/40 dark:hover:bg-slate-700 text-slate-700 dark:text-gray-300 font-bold transition-all border border-slate-200 dark:border-darkBorder">
                        <span class="w-9 h-9 shrink-0 rounded-lg bg-slate-200/70 dark:bg-slate-700/60 flex items-center justify-center text-slate-500 dark:text-gray-400 group-hover:bg-white/20 group-hover:text-white transition-colors">
                            <i class="fas fa-file-import text-sm"></i>
                        </span>
                        <span class="flex-1">
                            <span class="block text-[13px] font-extrabold tracking-tight leading-tight">Importer</span>
                            <span class="block text-[10px] font-medium text-slate-500 dark:text-gray-400 group-hover:text-white">Ajouter des tickets en masse</span>
                        </span>
                        <i class="fas fa-chevron-right text-[10px] opacity-50 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
