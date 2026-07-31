<div class="space-y-4">
    <div class="flex flex-wrap items-center gap-2">
        <select wire:model.live="filterVendeur"
            class="px-3 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
            <option value="">Tous les vendeurs</option>
            @foreach($vendeurs as $v)
            <option value="{{ $v->id }}">{{ $v->prenom }} {{ $v->nom }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatut"
            class="px-3 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
            <option value="">Tous les statuts</option>
            <option value="completed">Complétée</option>
            <option value="pending">En attente</option>
            <option value="cancelled">Annulée</option>
        </select>
    </div>

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-white dark:bg-darkCard">
                        <th class="py-2.5 px-3 font-bold">ID</th>
                        <th class="py-2.5 px-3 font-bold">Date</th>
                        <th class="py-2.5 px-3 font-bold">Vendeur</th>
                        <th class="py-2.5 px-3 font-bold">Utilisateur</th>
                        <th class="py-2.5 px-3 font-bold">Forfait</th>
                        <th class="py-2.5 px-3 font-bold">Montant</th>
                        <th class="py-2.5 px-3 font-bold">Commission</th>
                        <th class="py-2.5 px-3 font-bold">Statut</th>
                        <th class="py-2.5 px-3 font-bold">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $t->id }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($t->date_creation)->format('d/m/Y H:i') }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $t->vendeur?->prenom }} {{ $t->vendeur?->nom }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $t->ticket?->user ?? '-' }}</td>
                        <td class="py-2.5 px-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">
                                {{ $t->ticket?->forfait ?? '-' }}
                            </span>
                        </td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">{{ number_format($t->montant, 0, ',', ' ') }} {{ config('platform.currency') }}</td>
                        <td class="py-2.5 px-3 text-xs font-bold text-amber-600 dark:text-amber-400">{{ number_format($t->commission, 0, ',', ' ') }} {{ config('platform.currency') }}</td>
                        <td class="py-2.5 px-3">
                            @if($t->statut === 'completed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">Complétée</span>
                            @elseif($t->statut === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400">En attente</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400">Annulée</span>
                            @endif
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $t->phone_number ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-inbox text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucune transaction trouvée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
