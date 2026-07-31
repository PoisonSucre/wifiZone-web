<div class="space-y-4">
    <?php
    $actionLabels = [
        'create_admin' => ['label' => 'Ajout admin', 'icon' => 'fa-user-plus', 'color' => 'emerald'],
        'delete_admin' => ['label' => 'Suppression admin', 'icon' => 'fa-user-minus', 'color' => 'red'],
        'reject_withdrawal' => ['label' => 'Retrait rejeté', 'icon' => 'fa-ban', 'color' => 'red'],
        'pay_withdrawal' => ['label' => 'Retrait payé', 'icon' => 'fa-check-double', 'color' => 'emerald'],
        'update_commission' => ['label' => 'Commission modifiée', 'icon' => 'fa-percent', 'color' => 'amber'],
    ];
    $badge = function (string $action) use ($actionLabels) {
        $a = $actionLabels[$action] ?? ['label' => $action, 'icon' => 'fa-circle', 'color' => 'slate'];
        $map = [
            'emerald' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400',
            'red' => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400',
            'amber' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400',
            'slate' => 'bg-slate-100 dark:bg-slate-500/10 text-slate-600 dark:text-slate-400',
        ];
        return '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold ' . ($map[$a['color']] ?? $map['slate']) . '"><i class="fas ' . $a['icon'] . '"></i>' . $a['label'] . '</span>';
    };
    ?>

    <div class="flex flex-wrap items-center gap-2">
        <button wire:click="$set('filterAction', '')"
            class="px-3 py-1.5 rounded-full text-[11px] font-bold transition-all border <?php echo e($filterAction === '' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30'); ?>">
            <i class="fas fa-list mr-1"></i>Tous
        </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <button wire:click="$set('filterAction', '<?php echo e($action); ?>')"
                class="px-3 py-1.5 rounded-full text-[11px] font-bold transition-all border <?php echo e($filterAction === $action ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30'); ?>">
                <i class="fas <?php echo e($actionLabels[$action]['icon'] ?? 'fa-circle'); ?> mr-1"></i><?php echo e($actionLabels[$action]['label'] ?? $action); ?>

                <span class="opacity-60">(<?php echo e($data->nb); ?>)</span>
            </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/30 dark:bg-transparent">
                        <th class="py-2.5 px-3 font-bold">Date</th>
                        <th class="py-2.5 px-3 font-bold">Admin</th>
                        <th class="py-2.5 px-3 font-bold">Action</th>
                        <th class="py-2.5 px-3 font-bold">Cible</th>
                        <th class="py-2.5 px-3 font-bold">Détails</th>
                        <th class="py-2.5 px-3 font-bold">IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400 whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i')); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">
                            <?php echo e($log->admin?->fullName() ?? 'Admin #' . $log->admin_id); ?>

                        </td>
                        <td class="py-2.5 px-3"><?php echo $badge($log->action); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->target_type && $log->target_id): ?>
                                <?php echo e($log->target_type); ?> #<?php echo e($log->target_id); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300 max-w-[260px] truncate" title="<?php echo e($log->details); ?>"><?php echo e($log->details ?? '—'); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400"><?php echo e($log->ip ?? '—'); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-clipboard-list text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucune entrée du journal.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logs->hasPages()): ?>
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            <?php echo e($logs->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/journal-manager.blade.php ENDPATH**/ ?>