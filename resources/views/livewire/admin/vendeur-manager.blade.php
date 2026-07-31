<div class="space-y-4">
    <div class="flex items-center justify-between gap-2">
        <div class="relative flex-1 max-w-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Rechercher par nom, email, téléphone..."
                   class="w-full pl-9 pr-3 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 placeholder-slate-400 focus:border-neonGreen outline-none transition-colors">
        </div>
        <button wire:click="$set('showAddModal', true)"
            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm shrink-0">
            <i class="fas fa-plus text-[10px]"></i>Ajouter un vendeur
        </button>
    </div>

    @if(session()->has('success'))
    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-white dark:bg-darkCard">
                        <th class="py-2.5 px-3 font-bold">ID</th>
                        <th class="py-2.5 px-3 font-bold">Nom</th>
                        <th class="py-2.5 px-3 font-bold">Email</th>
                        <th class="py-2.5 px-3 font-bold">Tél.</th>
                        <th class="py-2.5 px-3 font-bold">Statut</th>
                        <th class="py-2.5 px-3 font-bold">Tickets</th>
                        <th class="py-2.5 px-3 font-bold">Revenus</th>
                        <th class="py-2.5 px-3 font-bold">Commission</th>
                        <th class="py-2.5 px-3 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendeurs as $v)
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $v->id }}</td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">{{ $v->prenom }} {{ $v->nom }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $v->email }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">{{ $v->telephone }}</td>
                        <td class="py-2.5 px-3">
                            @if($v->statut === 'actif')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">Actif</span>
                            @elseif($v->statut === 'en_attente')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400">En attente</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400">Suspendu</span>
                            @endif
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $v->nb_dispo }}</span> / <span class="text-slate-500">{{ $v->nb_vendus }}</span>
                        </td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">{{ number_format($v->revenus ?? 0, 0, ',', ' ') }} {{ config('platform.currency') }}</td>
                        <td class="py-2.5 px-3">
                            <button wire:click="openCommissionModal({{ $v->id }}, {{ $v->commission_pct }})"
                                class="inline-flex items-center gap-1 text-xs font-bold text-neonGreen hover:text-emerald-600 transition-colors">
                                <i class="fas fa-percentage text-[10px]"></i> {{ $v->commission_pct }}%
                            </button>
                        </td>
                        <td class="py-2.5 px-3">
                            <div class="flex items-center gap-1">
                                @if($v->statut !== 'actif')
                                <button wire:click="openConfirm('activate', {{ $v->id }}, 'Activer ce vendeur ?', 'Activer', 'bg-emerald-600 hover:bg-emerald-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:border-emerald-300 dark:hover:border-emerald-500/30 transition-all"
                                    title="Activer">
                                    <i class="fas fa-check text-[10px]"></i>
                                </button>
                                @endif
                                @if($v->statut !== 'suspendu')
                                <button wire:click="openConfirm('suspend', {{ $v->id }}, 'Suspendre ce vendeur ?', 'Suspendre', 'bg-amber-600 hover:bg-amber-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-500/10 hover:border-amber-300 dark:hover:border-amber-500/30 transition-all"
                                    title="Suspendre">
                                    <i class="fas fa-pause text-[10px]"></i>
                                </button>
                                @endif
                                <button wire:click="openConfirm('delete', {{ $v->id }}, 'Supprimer ce vendeur ? Cette action est irréversible.', 'Supprimer', 'bg-red-600 hover:bg-red-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:border-red-300 dark:hover:border-red-500/30 transition-all"
                                    title="Supprimer">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-inbox text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucun vendeur trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($vendeurs->hasPages())
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            {{ $vendeurs->links() }}
        </div>
        @endif
    </div>

    {{-- Modal Ajouter --}}
    @if($showAddModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-darkBorder/40">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                    <i class="fas fa-user-plus text-neonGreen mr-2"></i>Nouveau Vendeur
                </h3>
                <button wire:click="$set('showAddModal', false)"
                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            <form wire:submit.prevent="addVendeur" class="p-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Prénom</label>
                        <input type="text" wire:model="newPrenom" required
                            class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                        @error('newPrenom') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Nom</label>
                        <input type="text" wire:model="newNom" required
                            class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                        @error('newNom') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Email</label>
                    <input type="email" wire:model="newEmail" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    @error('newEmail') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Téléphone</label>
                    <input type="text" wire:model="newTelephone" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    @error('newTelephone') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Mot de passe</label>
                    <input type="password" wire:model="newPassword" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    @error('newPassword') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Commission (%)</label>
                    <input type="number" step="0.01" wire:model="newCommission"
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="$set('showAddModal', false)"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button type="submit"
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                        <i class="fas fa-save mr-1"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Modal Commission --}}
    @if($editingCommissionId)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-darkBorder/40">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                    <i class="fas fa-percentage text-neonGreen mr-2"></i>Modifier Commission
                </h3>
                <button wire:click="$set('editingCommissionId', null)"
                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Commission (%)</label>
                    <input type="number" step="0.01" wire:model="editingCommissionValue"
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    @error('editingCommissionValue') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('editingCommissionId', null)"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button wire:click="initiateSaveCommission"
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                        <i class="fas fa-save mr-1"></i>Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Confirmation --}}
    @if($showConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
            <div class="p-5 text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 mx-auto mb-3">
                    <i class="fas fa-question-circle text-lg"></i>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white mb-2">Confirmation</h3>
                <p class="text-xs text-slate-500 dark:text-gray-400 mb-5">{{ $confirmMessage }}</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeConfirm"
                        class="px-4 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button wire:click="executeConfirm"
                        class="px-4 py-2 rounded-xl text-white text-xs font-bold transition-all shadow-sm {{ $confirmButtonClass }}">
                        <i class="fas fa-check-circle mr-1"></i>{{ $confirmButtonText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
