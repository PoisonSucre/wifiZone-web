@php
    $currency = config('platform.currency') ?? 'FCFA';
    $totalDispo = $nbDispo ?? 0;
    $totalVendus = $nbVendus ?? 0;
    $dispoParForfait = $dispoParForfait ?? collect();
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
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[72px]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700/40"></div>
                        <div class="flex-1">
                            <div class="h-2 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2.5"></div>
                            <div class="h-5 w-12 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @for ($k = 0; $k < 5; $k++)
                <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 h-[76px]">
                    <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700/40 rounded mb-2"></div>
                    <div class="h-2.5 w-16 bg-slate-200 dark:bg-slate-700/40 rounded mb-2"></div>
                    <div class="h-5 w-8 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                </div>
            @endfor
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <div class="h-7 w-14 bg-slate-200 dark:bg-slate-700/40 rounded-full"></div>
            <div class="h-7 w-20 bg-slate-200 dark:bg-slate-700/40 rounded-full"></div>
            <div class="h-7 w-16 bg-slate-200 dark:bg-slate-700/40 rounded-full"></div>
            <div class="flex-1 min-w-[200px] h-10 bg-slate-200 dark:bg-slate-700/40 rounded-xl"></div>
        </div>
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden">
            <div class="p-4 space-y-3">
                @for ($j = 0; $j < 6; $j++)
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700/40 shrink-0"></div>
                        <div class="flex-1 space-y-1.5">
                            <div class="h-2.5 w-32 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                            <div class="h-2 w-20 bg-slate-200 dark:bg-slate-700/40 rounded"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- STATS GRID --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            {{-- Total --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-layer-group text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $totalDispo + $totalVendus }}</p>
                    </div>
                </div>
            </div>

            {{-- Disponibles --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-check-circle text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Disponibles</p>
                        <p class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight leading-none">{{ $totalDispo }}</p>
                    </div>
                </div>
            </div>

            {{-- Vendus --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-purple-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-purple-500/5 group-hover:bg-purple-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-shopping-cart text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Vendus</p>
                        <p class="text-xl sm:text-2xl font-black text-purple-600 dark:text-purple-400 tracking-tight leading-none">{{ $totalVendus }}</p>
                    </div>
                </div>
            </div>

            {{-- Forfaits --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-tags text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Forfaits</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $dispoParForfait->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- DISPONIBLES PAR FORFAIT --}}
        @if($dispoParForfait->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach($dispoParForfait as $row)
                    @php
                        $f = $row->forfait ?: 'N/A';
                    @endphp
                    <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                        <div class="relative p-4 flex flex-col gap-1">
                            <p class="text-[9px] sm:text-[10px] font-bold text-neonGreen uppercase tracking-widest">Tickets restants</p>
                            <p class="text-[11px] font-semibold text-slate-500 dark:text-gray-400">{{ $f }}</p>
                            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $row->nb }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- FILTRES --}}
        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="$set('filter', 'all')"
                    style="{{ $filter === 'all' ? 'background-color:#00ff88;color:#000;border-color:#00ff88;box-shadow:0 1px 3px rgba(0,255,136,0.3)' : 'background-color:#fff;border-color:#e2e8f0;color:#64748b' }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold border transition-all dark:border-darkBorder">
                <i class="fas fa-layer-group text-[9px]"></i> Tous
            </button>

            <button wire:click="$set('filter', 'disponible')"
                    style="{{ $filter === 'disponible' ? 'background-color:#3b82f6;color:#fff;border-color:#3b82f6;box-shadow:0 1px 3px rgba(59,130,246,0.3)' : 'background-color:#fff;border-color:#e2e8f0;color:#64748b' }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold border transition-all dark:border-darkBorder">
                <i class="fas fa-check-circle text-[9px]"></i> Disponibles
            </button>

            <button wire:click="$set('filter', 'vendu')"
                    style="{{ $filter === 'vendu' ? 'background-color:#a855f7;color:#fff;border-color:#a855f7;box-shadow:0 1px 3px rgba(168,85,247,0.3)' : 'background-color:#fff;border-color:#e2e8f0;color:#64748b' }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold border transition-all dark:border-darkBorder">
                <i class="fas fa-shopping-cart text-[9px]"></i> Vendus
            </button>
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Rechercher un ticket..."
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 focus:bg-white dark:focus:bg-darkCard transition-all duration-200">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                            <th class="py-3 px-4 font-bold">#</th>
                            <th class="py-3 px-4 font-bold">Utilisateur</th>
                            <th class="py-3 px-4 font-bold">Mot de passe</th>
                            <th class="py-3 px-4 font-bold">Forfait</th>
                            <th class="py-3 px-4 font-bold text-right">Montant</th>
                            <th class="py-3 px-4 font-bold text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-700 dark:text-gray-300">
                        @forelse($tickets as $ticket)
                            <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0 group">
                                <td class="py-2.5 px-4 font-bold text-slate-900 dark:text-white">{{ $ticket->id }}</td>
                                <td class="py-2.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center text-blue-500 text-[10px] font-black">
                                            {{ strtoupper(substr($ticket->user, 0, 2)) }}
                                        </div>
                                        <code class="text-[11px] font-mono text-slate-600 dark:text-gray-400">{{ $ticket->user }}</code>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <div x-data="{ show: false }" class="flex items-center gap-1.5">
                                        <span class="font-mono text-[11px] text-slate-600 dark:text-gray-400"
                                              x-text="show ? '{{ addslashes($ticket->password ?: '—') }}' : '••••••••'"></span>
                                        <button type="button" @click="show = !show"
                                                class="text-neonGreen hover:text-neonGreen-600 transition-colors p-0.5">
                                            <i class="fas text-[10px]" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        {{ $ticket->forfait }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 font-black text-slate-900 dark:text-white text-right whitespace-nowrap">
                                    {{ number_format($ticket->montant, 0, ',', ' ') }} <span class="text-[9px] text-slate-400">{{ $currency }}</span>
                                </td>
                                <td class="py-2.5 px-4 text-right">
                                    @if($ticket->status === 'disponible')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Vendu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                                        <i class="fas fa-inbox text-lg"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucun ticket trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($tickets->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-darkBg/30">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
