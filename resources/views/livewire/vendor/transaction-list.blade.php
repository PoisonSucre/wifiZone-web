@php
    $currency = config('platform.currency') ?? 'FCFA';
@endphp

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="space-y-4 sm:space-y-5 pb-2 max-w-4xl mx-auto px-4 sm:px-6">

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total dépensé</p>
                <p class="text-xl font-black text-slate-900 dark:text-white">{{ number_format($totalAmount, 0, ',', ' ') }} <span class="text-xs text-slate-400 font-bold">{{ $currency }}</span></p>
            </div>
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">Nombre d'achats</p>
                <p class="text-xl font-black text-slate-900 dark:text-white">{{ $totalCount }}</p>
            </div>
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total quotas ajoutés</p>
                <p class="text-xl font-black text-neonGreen">{{ $totalSlots }} <span class="text-xs font-bold text-slate-400">Hotspots</span></p>
            </div>
        </div>

        {{-- FILTRES --}}
        <div class="flex flex-wrap items-center gap-2">
            <select wire:model.live="filterDate" class="px-3 py-1.5 rounded-full text-[11px] font-bold border border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-600 dark:text-gray-300">
                <option value="7j">7 derniers jours</option>
                <option value="30j">30 derniers jours</option>
                <option value="90j">90 derniers jours</option>
                <option value="all">Tout l'historique</option>
            </select>
            
            <select wire:model.live="filterMethod" class="px-3 py-1.5 rounded-full text-[11px] font-bold border border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-600 dark:text-gray-300">
                <option value="all">Toutes méthodes</option>
                <option value="ligdicash">LigdiCash</option>
                <option value="solde">Solde</option>
            </select>

            <select wire:model.live="filterPack" class="px-3 py-1.5 rounded-full text-[11px] font-bold border border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-600 dark:text-gray-300">
                <option value="all">Tous packs</option>
                <option value="A">Pack A</option>
                <option value="B">Pack B</option>
                <option value="C">Pack C</option>
            </select>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher..." class="px-4 py-1.5 rounded-full border border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-sm text-slate-900 dark:text-white placeholder-slate-400">
        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Pack</th>
                            <th class="py-3 px-4">Quotas ajoutés</th>
                            <th class="py-3 px-4">Montant</th>
                            <th class="py-3 px-4">Méthode</th>
                            <th class="py-3 px-4">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        @forelse($transactions as $t)
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/50 dark:hover:bg-darkBg/30 transition-colors">
                                <td class="py-3 px-4">{{ $t->date_creation->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-4 font-bold">{{ $packs[$t->pack_key]['label'] ?? $t->pack_key }}</td>
                                <td class="py-3 px-4">{{ $t->slots ?? 0 }} Hotspots</td>
                                <td class="py-3 px-4">{{ number_format($t->montant, 0, ',', ' ') }} {{ $currency }}</td>
                                <td class="py-3 px-4">{{ ucfirst($t->payment_method) }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusLabel = match($t->statut) {
                                            'completed' => 'Terminé',
                                            'pending'   => 'En attente',
                                            'rejected'  => 'Rejeté',
                                            default     => ucfirst($t->statut),
                                        };
                                        $statusStyle = match($t->statut) {
                                            'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                            'pending'   => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                            'rejected'  => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                            default     => 'bg-slate-100 text-slate-700 dark:bg-slate-500/10 dark:text-slate-400',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusStyle }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-slate-500 dark:text-gray-400">Aucune transaction trouvée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 dark:border-darkBorder/40">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>