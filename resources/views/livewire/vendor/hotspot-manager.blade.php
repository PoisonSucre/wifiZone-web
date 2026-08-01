@php
    $nbTotal = $totalHotspots;
    $nbActifs = $actifs;
    $nbInactifs = $inactifs;
    $totalTickets = $hotspots->sum('tickets_count');
@endphp

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="relative space-y-4 sm:space-y-5 pb-2">

    {{-- SKELETON --}}
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 z-10 space-y-4 animate-pulse">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @for ($i = 0; $i < 3; $i++)
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
            @endfor
        </div>
    </div>

    {{-- BANNIÈRE ABONNEMENT GELÉ --}}
    @if($hasFrozen)
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-500/30 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="fas fa-snowflake"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-extrabold text-amber-800 dark:text-amber-300">Abonnement gelé</p>
                <p class="text-xs text-amber-600 dark:text-amber-400">Vos {{ $frozenSubscriptions->sum('slots') }} hotspots sont gelés. Renouvelez votre abonnement pour les réactiver et ne pas perdre vos données.</p>
            </div>
        </div>
        <div class="flex gap-2 shrink-0">
            @foreach($frozenSubscriptions as $frozen)
            <button type="button" wire:click="openRenewModal('{{ $frozen->pack_key }}')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition-all shadow-sm">
                <i class="fas fa-rotate-right text-[10px]"></i> Renouveler Pack {{ $frozen->pack_key }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

     {{-- CONTENU RÉEL --}}
     <div x-show="loaded" x-cloak
          x-transition:enter="transition ease-out duration-500"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          class="space-y-4 sm:space-y-5 relative z-[1]">

         {{-- STATISTIQUES --}}
         <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            {{-- Total --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-cyan-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-cyan-500/5 group-hover:bg-cyan-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 group-hover:bg-cyan-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-wifi text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $nbTotal }}</p>
                    </div>
                </div>
            </div>

            {{-- Actifs --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-blue-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-check-circle text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Actifs</p>
                        <p class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight leading-none">{{ $nbActifs }}</p>
                    </div>
                </div>
            </div>

            {{-- Inactifs --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-eye-slash text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Inactifs</p>
                        <p class="text-xl sm:text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight leading-none">{{ $nbInactifs }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Tickets --}}
            <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-neonGreen/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
                <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-neonGreen/5 group-hover:bg-neonGreen/10 transition-colors duration-500"></div>
                <div class="relative p-4 flex items-center gap-3">
                    <div class="w-10 h-10 shrink-0 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen group-hover:bg-neonGreen group-hover:text-black group-hover:rotate-3 transition-all duration-300">
                        <i class="fas fa-ticket-alt text-sm"></i>
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Tickets</p>
                        <p class="text-lg sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $totalTickets }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BANNIÈRE QUOTA --}}
         <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 p-4 sm:p-5 text-white shadow-[0_10px_30px_-12px_rgba(6,182,212,0.45)]">
             <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10"></div>
             <div class="absolute -right-2 -top-2 w-24 h-24 rounded-full bg-white/5"></div>
             <div class="relative flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                 <div class="flex items-center gap-3 flex-1 min-w-0">
                     <span class="shrink-0 w-10 h-10 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center">
                         <i class="fas fa-layer-group text-sm"></i>
                     </span>
                     <div class="min-w-0 flex-1">
                         <p class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-white/70">Quota de hotspots</p>
                         <div class="flex items-center gap-2">
                             <p class="text-sm font-black tracking-tight">{{ $used }} / {{ $limit }} utilisé(s) @if($hasFrozen) · <span class="text-amber-300">{{ $frozenSubscriptions->sum('slots') }} gelé(s)</span>@endif</p>
                             @if(!$canCreate)
                                 <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/20 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider">
                                     <i class="fas fa-exclamation-triangle text-[8px]"></i> Quota atteint
                                 </span>
                             @else
                                 <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/20 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider">
                                     <i class="fas fa-check text-[8px]"></i> {{ $remaining }} place(s)
                                 </span>
                             @endif
                         </div>
                     </div>
                 </div>
                 <button type="button" wire:click="openPackModal"
                         class="shrink-0 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-[11px] font-extrabold transition-all shadow-sm hover:shadow-md">
                     <i class="fas fa-cart-plus text-[10px]"></i> Acheter des quotas
                 </button>
             </div>
             <div class="relative h-2 rounded-full bg-white/20 mt-3.5 overflow-hidden">
                 <div class="h-full rounded-full bg-white transition-all duration-700"
                      style="width: {{ $limit > 0 ? min(($used / $limit) * 100, 100) : 0 }}%"></div>
             </div>
             <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5 mt-3">
                 @if(!$canCreate)
                     <p class="text-[11px] font-bold text-white/90">
                         @if($hasFrozen)
                             Vos abonnements sont gelés. Renouvelez-les pour réactiver vos hotspots et en créer de nouveaux.
                         @else
                             Tous vos emplacements sont utilisés. Achetez un pack pour ajouter plus de hotspots.
                         @endif
                     </p>
                 @else
                    <p class="text-[11px] text-white/80">
                        {{ $limit - $used }} emplacement(s) restant(s). Un abonnement mensuel vous permet d'ajouter plus de hotspots.
                    </p>
                @endif
                @if($subscriptions->isNotEmpty())
                    <p class="shrink-0 text-[10px] font-bold text-white/85 flex items-center gap-1.5">
                        <i class="fas fa-crown text-[9px]"></i>
                        @foreach($subscriptions as $sub)
                            <span>Pack {{ $packs[$sub->pack_key]['label'] ?? $sub->pack_key }} +{{ $sub->slots }} · expire le {{ $sub->expires_at?->format('d/m/Y') }}</span>
                            @if(!$loop->last)<span class="text-white/40">•</span>@endif
                        @endforeach
                    </p>
                @endif
            </div>
        </div>

        {{-- TITRE SECTION --}}
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Mes Hotspots</h3>
            <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-0.5">{{ $nbTotal }} hotspot(s) configuré(s)</p>
        </div>

        {{-- GRILLE HOTSPOTS --}}
        @if($hotspots->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4 max-w-3xl">
            @foreach($hotspots as $hotspot)
            <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden hover:border-cyan-500/30 transition-all duration-300 hover:-translate-y-0.5 group">
                {{-- Header --}}
                <div class="px-4 pt-4 pb-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-11 h-11 shrink-0 rounded-xl bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-[0_4px_12px_-4px_rgba(6,182,212,0.4)] group-hover:rotate-3 transition-transform duration-300">
                                <i class="fas fa-wifi text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-extrabold text-slate-900 dark:text-white truncate">{{ $hotspot->name }}</h4>
                                @if($hotspot->description)
                                    <p class="text-[10px] text-slate-400 dark:text-gray-500 truncate mt-0.5">{{ $hotspot->description }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Badge statut --}}
                        <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $hasFrozen ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400' : ($hotspot->statut === 'actif' ? 'bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 dark:text-gray-500') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $hasFrozen ? 'bg-amber-400 animate-pulse' : ($hotspot->statut === 'actif' ? 'bg-red-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600') }}"></span>
                            {{ $hasFrozen ? 'Gelé' : ($hotspot->statut === 'actif' ? 'En ligne' : 'Hors ligne') }}
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="px-4 pb-3 flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-tags text-[10px] text-neonGreen"></i>
                        <span class="text-[11px] font-bold text-slate-600 dark:text-gray-400">{{ $hotspot->forfaits_count }} forfait(s)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-ticket-alt text-[10px] text-cyan-500"></i>
                        <span class="text-[11px] font-bold text-slate-600 dark:text-gray-400">{{ $hotspot->tickets_count }} ticket(s)</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-4 pb-4 flex items-center gap-1.5">
                    <a href="{{ route('vendor.hotspot.details', $hotspot->id) }}"
                       wire:navigate
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-white dark:text-black text-[11px] font-bold transition-all">
                        <i class="fas fa-arrow-right text-[10px]"></i> Gérer
                    </a>
                    <button type="button" wire:click="confirmToggle({{ $hotspot->id }})"
                            {{ $hasFrozen ? 'disabled' : '' }}
                            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all {{ $hasFrozen ? 'bg-slate-100 dark:bg-slate-700/40 text-slate-300 dark:text-slate-600 cursor-not-allowed' : ($hotspot->statut === 'actif' ? 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white' : 'bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black') }}"
                            title="{{ $hasFrozen ? 'Indisponible pendant le gel' : ($hotspot->statut === 'actif' ? 'Désactiver' : 'Activer') }}">
                        <i class="fas {{ $hotspot->statut === 'actif' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                    </button>
                    <button type="button" wire:click="editHotspot({{ $hotspot->id }})"
                            class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-neonGreen hover:text-black transition-all"
                            title="Modifier">
                        <i class="fas fa-edit text-[10px]"></i>
                    </button>
                    <button type="button" wire:click="confirmDelete({{ $hotspot->id }})"
                            class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-red-500 hover:text-white transition-all"
                            title="Supprimer">
                        <i class="fas fa-trash text-[10px]"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- EMPTY STATE --}}
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
        @endif
    </div>

    {{-- MODAL PACKS --}}
    @if($showPackModal)
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
                {{-- ABONNEMENTS ACTIFS --}}
                @if($subscriptions->isNotEmpty())
                <div class="mb-5">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2.5">
                        <i class="fas fa-crown text-amber-500 mr-1"></i> Vos abonnements actifs
                    </p>
                    <div class="space-y-2">
                        @foreach($subscriptions as $sub)
                        <div class="flex items-center justify-between gap-3 bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 rounded-xl px-3 py-2.5">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="shrink-0 w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                                    <i class="fas fa-wifi text-[11px]"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-extrabold text-slate-900 dark:text-white">Pack {{ $packs[$sub->pack_key]['label'] ?? $sub->pack_key }} <span class="text-neonGreen">+{{ $sub->slots }}</span></p>
                                    <p class="text-[10px] text-slate-400 dark:text-gray-500">
                                        Paiement {{ $sub->payment_method === 'solde' ? 'via solde' : 'via LigdiCash' }} · expire le {{ $sub->expires_at?->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-clock text-[9px]"></i> {{ (int) now()->diffInDays($sub->expires_at, false) }} j restants
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- PACKS --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($packs as $pack)
                    <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 flex flex-col hover:border-cyan-500/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 text-white text-[11px] font-extrabold uppercase tracking-wider">
                                <i class="fas fa-wifi text-[9px]"></i> {{ $pack['label'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-[10px] font-bold">
                                <i class="fas fa-plus text-[9px]"></i> +{{ $pack['slots'] }} hotspots
                            </span>
                        </div>
                        <div class="mb-4">
                            <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ number_format($pack['price'], 0, ',', ' ') }} <span class="text-[11px] text-slate-400 font-bold">{{ config('platform.currency') }}</span></p>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-1 font-medium">par mois, sans engagement</p>
                            @if(!empty($pack['desc']))
                            <p class="text-[10px] text-slate-500 dark:text-gray-400 mt-1.5 font-medium">{{ $pack['desc'] }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-1.5 mt-auto">
                            <form method="POST" action="{{ route('vendor.pack.payment', $pack['key']) }}" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-400 text-white text-[11px] font-bold transition-all">
                                    <i class="fas fa-mobile-alt text-[10px]"></i> Payer via LigdiCash
                                </button>
                            </form>
                            <button type="button" wire:click="chooseSoldePack('{{ $pack['key'] }}')"
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-700 dark:text-gray-300 text-[11px] font-bold transition-all hover:border-neonGreen/50 {{ $soldeDisponible < $pack['price'] ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    @if($soldeDisponible < $pack['price']) disabled @endif>
                                <i class="fas fa-wallet text-[10px]"></i> Payer avec mon solde
                            </button>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500 text-center mt-0.5">
                                Solde : {{ number_format($soldeDisponible, 0, ',', ' ') }} {{ config('platform.currency') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL SUPPRESSION --}}
    @if($showDeleteModal)
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
    @endif

    {{-- MODAL TOGGLE STATUT --}}
    @if($showToggleModal)
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
                Voulez-vous vraiment changer le statut du hotspot <span class="font-bold text-slate-900 dark:text-white">{{ $toggleHotspotName }}</span> ?
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
    @endif

    {{-- MODAL PAIEMENT SOLDE --}}
    @if($soldePackKey && isset($packs[$soldePackKey]))
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
                Confirmer l'achat du <span class="font-bold text-slate-900 dark:text-white">Pack {{ $packs[$soldePackKey]['label'] }}</span>
                (+{{ $packs[$soldePackKey]['slots'] }} hotspots) pour
                <span class="font-bold text-slate-900 dark:text-white">{{ number_format($packs[$soldePackKey]['price'], 0, ',', ' ') }} {{ config('platform.currency') }}</span>
                ? Le montant sera déduit de votre solde.
            </p>
            <div class="bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 rounded-xl px-3 py-2.5 mb-5 flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">Solde disponible</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($soldeDisponible, 0, ',', ' ') }} {{ config('platform.currency') }}</span>
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
    @endif

    {{-- MODAL CRÉATION / MODIFICATION --}}
    @if($showForm)
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
                <div class="w-9 h-9 rounded-lg {{ $editingHotspot ? 'bg-amber-500/10 text-amber-500' : 'bg-cyan-500/10 text-cyan-500' }} flex items-center justify-center">
                    <i class="fas fa-{{ $editingHotspot ? 'edit' : 'plus' }} text-sm"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex-1">{{ $editingHotspot ? 'Modifier le hotspot' : 'Nouveau hotspot' }}</h3>
                <button type="button" wire:click="cancelEdit"
                        class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-600 transition-all">
                    <i class="fas fa-times text-[11px]"></i>
                </button>
            </div>
            <div class="p-5">
                <form wire:submit.prevent="{{ $editingHotspot ? 'updateHotspot' : 'addHotspot' }}" class="space-y-4">
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Nom du hotspot *</label>
                        <input type="text" wire:model="hotspotName" required placeholder="Ex: WiFi Centre Ville"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200">
                        @error('hotspotName') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Description</label>
                        <textarea wire:model="hotspotDescription" rows="3" placeholder="Description optionnelle..."
                                  class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200 resize-none"></textarea>
                        @error('hotspotDescription') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">URL du MikroTik</label>
                        <input type="url" wire:model="mikrotikUrl" placeholder="Ex: https://votre-routeur.ngrok-free.app"
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500/50 transition-all duration-200">
                        @error('mikrotikUrl') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">URL publique de votre routeur MikroTik (ngrok, DDNS, IP publique). Le client sera redirigé ici après achat.</p>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 disabled:opacity-50 disabled:cursor-not-allowed text-white text-[12px] font-bold transition-all shadow-sm">
                            <i wire:loading.remove wire:target="addHotspot, updateHotspot" class="fas fa-{{ $editingHotspot ? 'save' : 'plus' }} text-[11px]"></i>
                            <i wire:loading wire:target="addHotspot, updateHotspot" class="fas fa-spinner fa-spin text-[11px]"></i>
                            {{ $editingHotspot ? 'Enregistrer' : 'Créer' }}
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
    @endif
</div>
