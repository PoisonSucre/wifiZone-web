<div class="space-y-4">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-check-circle"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('error')): ?>
    <div class="p-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-exclamation-circle"></i><?php echo e(session('error')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <i class="fas fa-user-shield text-sm"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total admins</p>
                    <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none"><?php echo e($totalAdmins); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 sm:p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                <i class="fas fa-user-plus text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Ajouter un admin</h3>
                <p class="text-[10px] text-slate-500 dark:text-gray-400">Créez un compte avec email et mot de passe</p>
            </div>
        </div>
        <form wire:submit.prevent="addAdmin" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Prénom</label>
                <input type="text" wire:model="prenom"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors"
                    placeholder="Ex : Awa">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['prenom'];
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
                <input type="text" wire:model="nom"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors"
                    placeholder="Ex : Diallo">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Email</label>
                <input type="email" wire:model="email"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors"
                    placeholder="admin@exemple.com">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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
                <input type="password" wire:model="password"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors"
                    placeholder="8 caractères minimum">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Confirmer mot de passe</label>
                <input type="password" wire:model="password_confirmation"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors"
                    placeholder="Répétez le mot de passe">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="sm:col-span-2">
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                    <i class="fas fa-user-plus text-[10px]"></i>Ajouter l'admin
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden shadow-sm">
        <div class="px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40">
            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                <i class="fas fa-list text-neonGreen mr-2"></i>Liste des admins
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                        <th class="py-2.5 px-3 font-bold">ID</th>
                        <th class="py-2.5 px-3 font-bold">Nom</th>
                        <th class="py-2.5 px-3 font-bold">Email</th>
                        <th class="py-2.5 px-3 font-bold">Créé le</th>
                        <th class="py-2.5 px-3 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($a->id); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">
                            <?php echo e($a->fullName()); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($a->id === auth('admin')->id()): ?>
                                <span class="ml-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400">Vous</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($a->email); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400"><?php echo e($a->created_at?->format('d/m/Y H:i')); ?></td>
                        <td class="py-2.5 px-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($a->id !== auth('admin')->id()): ?>
                            <button wire:click="openDeleteModal(<?php echo e($a->id); ?>)"
                                class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:border-red-300 dark:hover:border-red-500/30 transition-all"
                                title="Supprimer">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </button>
                            <?php else: ?>
                            <span class="text-[10px] text-slate-300 dark:text-slate-600">—</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-user-shield text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucun admin trouvé.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($admins->hasPages()): ?>
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            <?php echo e($admins->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
            <div class="p-5 text-center">
                <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-400 mx-auto mb-3">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white mb-2">Supprimer cet admin ?</h3>
                <p class="text-xs text-slate-500 dark:text-gray-400 mb-5">Cette action est irréversible et sera journalisée.</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeDeleteModal"
                        class="px-4 py-2 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button wire:click="deleteAdmin"
                        class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-sm">
                        <i class="fas fa-trash-alt mr-1"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/admin-manager.blade.php ENDPATH**/ ?>