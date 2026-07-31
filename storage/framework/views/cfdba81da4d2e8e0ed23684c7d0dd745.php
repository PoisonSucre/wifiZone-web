<div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-4 sm:space-y-5">
    <?php
    $meta = [
        'admin_login' => ['label' => 'Connexion admin', 'icon' => 'fa-sign-in-alt', 'c' => 'blue', 'verb' => "s'est connecté"],
        'admin_logout' => ['label' => 'Déconnexion admin', 'icon' => 'fa-sign-out-alt', 'c' => 'blue', 'verb' => "s'est déconnecté"],
        'admin_login_failed' => ['label' => 'Connexion échouée', 'icon' => 'fa-user-lock', 'c' => 'red', 'verb' => 'a échoué à se connecter'],
        'create_admin' => ['label' => 'Ajout admin', 'icon' => 'fa-user-plus', 'c' => 'purple', 'verb' => "a créé l'administrateur"],
        'delete_admin' => ['label' => 'Suppression admin', 'icon' => 'fa-user-minus', 'c' => 'red', 'verb' => "a supprimé l'administrateur"],
        'create_vendor' => ['label' => 'Vendeur créé', 'icon' => 'fa-store', 'c' => 'green', 'verb' => 'a créé le vendeur'],
        'activate_vendor' => ['label' => 'Vendeur activé', 'icon' => 'fa-check-circle', 'c' => 'green', 'verb' => 'a activé le vendeur'],
        'suspend_vendor' => ['label' => 'Vendeur suspendu', 'icon' => 'fa-pause-circle', 'c' => 'red', 'verb' => 'a suspendu le vendeur'],
        'delete_vendor' => ['label' => 'Vendeur supprimé', 'icon' => 'fa-trash', 'c' => 'red', 'verb' => 'a supprimé le vendeur'],
        'update_commission' => ['label' => 'Commission modifiée', 'icon' => 'fa-percent', 'c' => 'amber', 'verb' => 'a modifié la commission'],
        'pay_withdrawal' => ['label' => 'Retrait payé', 'icon' => 'fa-check-double', 'c' => 'green', 'verb' => 'a payé le retrait'],
        'reject_withdrawal' => ['label' => 'Retrait rejeté', 'icon' => 'fa-ban', 'c' => 'red', 'verb' => 'a rejeté le retrait'],
        'update_platform' => ['label' => 'Paramètres plateforme', 'icon' => 'fa-cog', 'c' => 'slate', 'verb' => 'a modifié les paramètres de la plateforme'],
        'update_security' => ['label' => 'Mot de passe modifié', 'icon' => 'fa-shield-alt', 'c' => 'slate', 'verb' => 'a modifié son mot de passe'],
        'update_personalisation' => ['label' => 'Personnalisation modifiée', 'icon' => 'fa-paint-brush', 'c' => 'slate', 'verb' => 'a modifié la personnalisation'],
        'toggle_whatsapp' => ['label' => 'WhatsApp basculé', 'icon' => 'fa-brands fa-whatsapp', 'c' => 'green', 'verb' => 'a basculé le WhatsApp'],
        'toggle_pack' => ['label' => 'Pack basculé', 'icon' => 'fa-box-open', 'c' => 'amber', 'verb' => 'a basculé le pack'],
    ];
    $targetFr = [
        'withdrawal' => 'retrait',
        'vendor' => 'vendeur',
        'admin' => 'administrateur',
        'hotspot' => 'hotspot',
        'ticket' => 'ticket',
        'transaction' => 'transaction',
        'forfait' => 'forfait',
        'setting' => 'paramètre',
        'user' => 'utilisateur',
        'import_batch' => "lot d'import",
    ];
    $ordered = [];
    foreach ($meta as $action => $m) {
        if (($actions[$action]->nb ?? 0) > 0) {
            $ordered[] = $action;
        }
    }
    foreach ($meta as $action => $m) {
        if (($actions[$action]->nb ?? 0) == 0) {
            $ordered[] = $action;
        }
    }
    ?>

    <div class="space-y-1.5">
        <div class="flex items-center gap-1.5 overflow-x-auto whitespace-nowrap pb-0.5 [scrollbar-width:thin] [scrollbar-color:#cbd5e1_transparent] dark:[scrollbar-color:#2f2f33_transparent]">
            <button wire:click="$set('filterAction', '')" class="shrink-0 px-2 py-1 rounded-full text-[10px] font-bold transition-all border <?php echo e($filterAction === '' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30'); ?>">
                <i class="fas fa-list mr-0.5"></i>Tous
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ordered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $m = $meta[$action]; ?>
                <button wire:click="$set('filterAction', '<?php echo e($action); ?>')" class="shrink-0 px-2 py-1 rounded-full text-[10px] font-bold transition-all border <?php echo e($filterAction === $action ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30'); ?>">
                    <i class="fas <?php echo e($m['icon'] ?? 'fa-circle'); ?> mr-0.5"></i><?php echo e($m['label'] ?? $action); ?>

                    <span class="opacity-60">(<?php echo e($actions[$action]->nb ?? 0); ?>)</span>
                </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div class="flex flex-wrap items-center gap-1.5">
            <?php
                $periods = [
                    '' => 'Tout',
                    'today' => 'Aujourd\'hui',
                    '7' => '7 jours',
                    '30' => '30 jours',
                    'month' => 'Ce mois',
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <button wire:click="$set('period', '<?php echo e($value); ?>')"
                    class="px-2 py-1 rounded-full text-[10px] font-bold transition-all border <?php echo e($period === $value ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-indigo-300 dark:hover:border-indigo-500/30'); ?>">
                    <?php echo e($label); ?>

                </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="hidden sm:block w-px h-4 bg-slate-200 dark:bg-darkBorder"></div>
            <div class="flex items-center gap-1">
                <input type="date" wire:model="dateFrom"
                    class="px-1.5 py-1 rounded-md text-[10px] font-bold border bg-white dark:bg-darkCard text-slate-600 dark:text-gray-300 border-slate-200 dark:border-darkBorder outline-none focus:border-indigo-400 dark:focus:border-indigo-500">
                <span class="text-[9px] font-bold text-slate-400">→</span>
                <input type="date" wire:model="dateTo"
                    class="px-1.5 py-1 rounded-md text-[10px] font-bold border bg-white dark:bg-darkCard text-slate-600 dark:text-gray-300 border-slate-200 dark:border-darkBorder outline-none focus:border-indigo-400 dark:focus:border-indigo-500">
                <button wire:click="clearDates" title="Réinitialiser les dates"
                    class="px-1.5 py-1 rounded-md text-[10px] font-bold border bg-white dark:bg-darkCard text-slate-500 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-red-300 hover:text-red-500 dark:hover:border-red-500/40 transition-all">
                    <i class="fas fa-rotate-left"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="absolute left-[22px] sm:left-1/2 sm:-translate-x-1/2 top-0 bottom-0 w-0.5 bg-slate-200 dark:bg-darkBorder"></div>

        <?php $currentDay = null; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $d = \Carbon\Carbon::parse($log->created_at);
                $key = $d->toDateString();
                $dayLabel = $key === now()->toDateString()
                    ? "Aujourd'hui"
                    : ($key === now()->subDay()->toDateString() ? 'Hier' : $d->translatedFormat('l d F Y'));
                $m = $meta[$log->action] ?? ['label' => $log->action, 'icon' => 'fa-circle'];
                $side = $loop->odd ? 'left' : 'right';
                $hue = ($log->id * 47) % 360;
                $dotStyle = "background-color: hsl({$hue} 80% 50%); border-color: hsl({$hue} 80% 50%)";
                $iconStyle = "background-color: hsla({$hue} 80% 50% / 0.12); color: hsl({$hue} 75% 45%)";
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($key !== $currentDay): ?>
                <?php $currentDay = $key; ?>
                <div class="relative z-10 flex items-center justify-center my-6">
                    <span class="px-3 py-1 rounded-full bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500"><?php echo e($dayLabel); ?></span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="relative z-10 flex pb-5 pl-10 sm:pl-0">
                <span class="absolute top-4 left-[22px] -translate-x-1/2 sm:left-1/2 w-2.5 h-2.5 rounded-full border bg-white dark:bg-darkCard" style="<?php echo e($dotStyle); ?>"></span>
                <div class="w-full <?php echo e($side === 'left' ? 'sm:mr-auto' : 'sm:ml-auto'); ?> sm:w-[calc(50%-28px)]">
                    <?php
                        $who = $log->admin?->fullName() ?? ($log->admin_id ? 'Admin #' . $log->admin_id : 'Un administrateur');
                        $target = $log->target_type ? ($targetFr[$log->target_type] ?? $log->target_type) : null;
                        $sentence = trim($who . ' ' . ($m['verb'] ?? 'a effectué une action')
                            . ($log->target_type && $log->target_id ? ' #' . $log->target_id : '')
                            . ' à ' . $d->format('d/m/Y H:i:s'));
                    ?>
                    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm hover:shadow-md transition-shadow" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="w-full text-left flex items-center justify-between gap-2 flex-wrap p-3.5 cursor-pointer">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="<?php echo e($iconStyle); ?>">
                                    <i class="fas <?php echo e($m['icon']); ?> text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold" style="<?php echo e($iconStyle); ?>"><?php echo e($m['label']); ?></span>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white truncate mt-1"><?php echo e($who); ?></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-[10px] font-bold text-slate-400 dark:text-gray-500 whitespace-nowrap"><?php echo e($d->format('d/m/Y H:i:s')); ?></span>
                                <i class="fas fa-chevron-down text-[10px] text-slate-400 dark:text-gray-500 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                            </div>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" x-cloak class="px-3.5 pb-3.5 pt-0 border-t border-slate-100 dark:border-darkBorder/40">
                            <p class="text-xs font-bold text-slate-800 dark:text-gray-200 mt-2.5 leading-relaxed"><?php echo e($sentence); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->ip): ?>
                                <p class="text-[11px] text-slate-500 dark:text-gray-400 font-semibold mt-1.5"><i class="fas fa-network-wired mr-1.5"></i>IP : <?php echo e($log->ip); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->details): ?>
                                <p class="text-[11px] text-slate-500 dark:text-gray-400 mt-1.5"><i class="fas fa-info-circle mr-1.5"></i>Détail : <?php echo e($log->details); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->target_type && $log->target_id): ?>
                                <p class="text-[11px] text-slate-500 dark:text-gray-400 mt-1.5"><i class="fas fa-bullseye mr-1.5"></i>Cible : <?php echo e($target); ?> #<?php echo e($log->target_id); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="relative z-10 py-10 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 dark:bg-darkBg mb-2 text-slate-400">
                    <i class="fas fa-clipboard-list text-lg"></i>
                </div>
                <p class="text-slate-500 dark:text-gray-400 text-xs font-medium">Aucune entrée du journal.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logs->hasPages()): ?>
        <?php echo e($logs->links()); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/journal-manager.blade.php ENDPATH**/ ?>