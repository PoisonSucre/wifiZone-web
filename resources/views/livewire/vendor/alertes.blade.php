<div class="space-y-4 pb-2">
    {{-- NOTIFICATION --}}
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

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center gap-x-3 gap-y-2 pb-1">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 via-amber-500/90 to-orange-400 flex items-center justify-center text-white text-lg shadow-[0_10px_30px_-10px_rgba(245,158,11,0.55)]">
            <i class="fas fa-exclamation-triangle"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-amber-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Alertes</p>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Paiements sans ticket</h2>
        </div>
        <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 dark:bg-amber-500/10 border border-amber-200/60 dark:border-amber-500/20 text-xs font-extrabold text-amber-700 dark:text-amber-400">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            {{ count($transactions) }} en attente
        </span>
    </div>

    {{-- TABLEAU --}}
    @if(count($transactions) === 0)
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 flex items-center justify-center text-emerald-500 mb-4">
            <i class="fas fa-check-circle text-2xl"></i>
        </div>
        <p class="text-sm font-extrabold text-slate-700 dark:text-gray-200">Aucune alerte</p>
        <p class="text-xs text-slate-400 dark:text-gray-500 mt-1">Tous les paiements ont bien reçu leur ticket.</p>
    </div>
    @else
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden">
        <div class="md:hidden divide-y divide-slate-100 dark:divide-darkBorder/40">
            @foreach($transactions as $tx)
            <div class="p-4 space-y-2.5">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-medium text-slate-700 dark:text-gray-200">
                        {{ \Carbon\Carbon::parse($tx['date_creation'])->format('d/m/Y H:i') }}
                    </span>
                    <button wire:click="checkTransaction({{ $tx['id'] }})" wire:loading.attr="disabled"
                            class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all disabled:opacity-40">
                        <span wire:loading.remove wire:target="checkTransaction({{ $tx['id'] }})"><i class="fas fa-sync-alt text-[8px]"></i></span>
                        <span wire:loading wire:target="checkTransaction({{ $tx['id'] }})"><i class="fas fa-spinner fa-spin text-[8px]"></i></span>
                        Vérifier
                    </button>
                </div>
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">Montant</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ number_format($tx['montant'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="text-right min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">Téléphone</p>
                        @if($tx['phone_number'])
                            <span class="font-mono text-xs text-slate-600 dark:text-gray-300 break-all">{{ $tx['phone_number'] }}</span>
                        @else
                            <span class="font-mono text-xs text-slate-400 dark:text-gray-500 italic">Numéro inconnu</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                        <th class="text-left font-extrabold text-slate-500 dark:text-gray-400 uppercase tracking-wider px-4 py-3">Date</th>
                        <th class="text-left font-extrabold text-slate-500 dark:text-gray-400 uppercase tracking-wider px-4 py-3">Montant</th>
                        <th class="text-left font-extrabold text-slate-500 dark:text-gray-400 uppercase tracking-wider px-4 py-3">Téléphone</th>
                        <th class="text-right font-extrabold text-slate-500 dark:text-gray-400 uppercase tracking-wider px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @foreach($transactions as $tx)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-darkBg/30 transition-colors">
                        <td class="px-4 py-3 font-medium text-slate-700 dark:text-gray-200 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($tx['date_creation'])->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-900 dark:text-white whitespace-nowrap">
                            {{ number_format($tx['montant'], 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($tx['phone_number'])
                            <span class="font-mono text-slate-600 dark:text-gray-300">{{ $tx['phone_number'] }}</span>
                            @else
                            <span class="font-mono text-slate-400 dark:text-gray-500 italic">Numéro inconnu</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button wire:click="checkTransaction({{ $tx['id'] }})" wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-500/30 transition-all disabled:opacity-40">
                                <span wire:loading.remove wire:target="checkTransaction({{ $tx['id'] }})"><i class="fas fa-sync-alt text-[8px]"></i></span>
                                <span wire:loading wire:target="checkTransaction({{ $tx['id'] }})"><i class="fas fa-spinner fa-spin text-[8px]"></i></span>
                                Vérifier
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(count($transactions) >= 50)
        <div class="px-4 py-3 border-t border-slate-100 dark:border-darkBorder/40 text-center">
            <p class="text-[10px] text-slate-400 dark:text-gray-500">Affichage des 50 dernières transactions. <a href="#" class="text-amber-600 hover:underline font-bold">Voir tout</a></p>
        </div>
        @endif
    </div>
    @endif
</div>
