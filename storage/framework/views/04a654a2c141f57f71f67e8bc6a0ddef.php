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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-check-circle"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $vendeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($v->id); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white"><?php echo e($v->prenom); ?> <?php echo e($v->nom); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($v->email); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($v->telephone); ?></td>
                        <td class="py-2.5 px-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->statut === 'actif'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">Actif</span>
                            <?php elseif($v->statut === 'en_attente'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400">En attente</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400">Suspendu</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300">
                            <span class="font-bold text-emerald-600 dark:text-emerald-400"><?php echo e($v->nb_dispo); ?></span> / <span class="text-slate-500"><?php echo e($v->nb_vendus); ?></span>
                        </td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white"><?php echo e(number_format($v->revenus ?? 0, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></td>
                        <td class="py-2.5 px-3">
                            <button wire:click="openCommissionModal(<?php echo e($v->id); ?>, <?php echo e($v->commission_pct); ?>)"
                                class="inline-flex items-center gap-1 text-xs font-bold text-neonGreen hover:text-emerald-600 transition-colors">
                                <i class="fas fa-percentage text-[10px]"></i> <?php echo e($v->commission_pct); ?>%
                            </button>
                        </td>
                        <td class="py-2.5 px-3">
                            <div class="flex items-center gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->statut !== 'actif'): ?>
                                <button wire:click="openConfirm('activate', <?php echo e($v->id); ?>, 'Activer ce vendeur ?', 'Activer', 'bg-emerald-600 hover:bg-emerald-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:border-emerald-300 dark:hover:border-emerald-500/30 transition-all"
                                    title="Activer">
                                    <i class="fas fa-check text-[10px]"></i>
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->statut !== 'suspendu'): ?>
                                <button wire:click="openConfirm('suspend', <?php echo e($v->id); ?>, 'Suspendre ce vendeur ?', 'Suspendre', 'bg-amber-600 hover:bg-amber-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-500/10 hover:border-amber-300 dark:hover:border-amber-500/30 transition-all"
                                    title="Suspendre">
                                    <i class="fas fa-pause text-[10px]"></i>
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <button wire:click="openConfirm('delete', <?php echo e($v->id); ?>, 'Supprimer ce vendeur ? Cette action est irréversible.', 'Supprimer', 'bg-red-600 hover:bg-red-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:border-red-300 dark:hover:border-red-500/30 transition-all"
                                    title="Supprimer">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="9" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-inbox text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucun vendeur trouvé.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeurs->hasPages()): ?>
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            <?php echo e($vendeurs->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAddModal): ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newPrenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Nom</label>
                        <input type="text" wire:model="newNom" required
                            class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newNom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Email</label>
                    <input type="email" wire:model="newEmail" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Téléphone</label>
                    <input type="text" wire:model="newTelephone" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newTelephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Mot de passe</label>
                    <input type="password" wire:model="newPassword" required
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingCommissionId): ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editingCommissionValue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showConfirm): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
            <div class="p-5 text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 mx-auto mb-3">
                    <i class="fas fa-question-circle text-lg"></i>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white mb-2">Confirmation</h3>
                <p class="text-xs text-slate-500 dark:text-gray-400 mb-5"><?php echo e($confirmMessage); ?></p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeConfirm"
                        class="px-4 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button wire:click="executeConfirm"
                        class="px-4 py-2 rounded-xl text-white text-xs font-bold transition-all shadow-sm <?php echo e($confirmButtonClass); ?>">
                        <i class="fas fa-check-circle mr-1"></i><?php echo e($confirmButtonText); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/vendeur-manager.blade.php ENDPATH**/ ?>