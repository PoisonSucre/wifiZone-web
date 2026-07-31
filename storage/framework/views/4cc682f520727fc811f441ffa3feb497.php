<div class="space-y-4">
    <?php
    $sparkline = function (array $data, string $color, int $h = 28, string $key = 'sp'): string {
        $data = array_values(array_filter($data, fn ($v) => is_numeric($v)));
        if (count($data) < 2) {
            $midY = $h / 2;
            $id   = 'sp_' . preg_replace('/[^a-z0-9]/i', '', $key);
            return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
                . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
                . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
                . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
                . '</linearGradient></defs>'
                . '<polygon points="0,' . $midY . ' 100,' . $midY . ' 100,' . $h . ' 0,' . $h . '" fill="url(#' . $id . ')"/>'
                . '<polyline points="0,' . $midY . ' 100,' . $midY . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" vector-effect="non-scaling-stroke"/>'
                . '</svg>';
        }
        $max   = max($data);
        $min   = min($data);
        $range = max($max - $min, 0.0001);
        $n     = count($data);
        $pts   = [];
        foreach ($data as $i => $v) {
            $x = ($i / ($n - 1)) * 100;
            $y = $h - (($v - $min) / $range) * ($h - 6) - 3;
            $pts[] = round($x, 2) . ',' . round($y, 2);
        }
        $line = implode(' ', $pts);
        $area = $line . " 100,{$h} 0,{$h}";
        $id   = 'sp_' . preg_replace('/[^a-z0-9]/i', '', $key);
        return '<svg class="w-full block" viewBox="0 0 100 ' . $h . '" preserveAspectRatio="none" style="height:' . $h . 'px">'
            . '<defs><linearGradient id="' . $id . '" x1="0" x2="0" y1="0" y2="1">'
            . '<stop offset="0%" stop-color="' . $color . '" stop-opacity="0.3"/>'
            . '<stop offset="100%" stop-color="' . $color . '" stop-opacity="0"/>'
            . '</linearGradient></defs>'
            . '<polygon points="' . $area . '" fill="url(#' . $id . ')"/>'
            . '<polyline points="' . $line . '" fill="none" stroke="' . $color . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>'
            . '</svg>';
    };
    $C = ['amber' => '#f59e0b', 'emerald' => '#10b981', 'red' => '#ef4444'];
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-check-circle"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex flex-wrap items-center gap-2">
        <?php
            $filters = [
                '' => ['label' => 'Tous', 'icon' => 'fa-list'],
                'pending' => ['label' => 'En attente', 'icon' => 'fa-hourglass-half'],
                'paid' => ['label' => 'Payés', 'icon' => 'fa-check-double'],
                'rejected' => ['label' => 'Rejetés', 'icon' => 'fa-times-circle'],
            ];
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <button wire:click="$set('filterStatut', '<?php echo e($val); ?>')"
                class="px-3 py-1.5 rounded-full text-[11px] font-bold transition-all border <?php echo e($filterStatut === $val ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30'); ?>">
                <i class="fas <?php echo e($f['icon']); ?> mr-1"></i><?php echo e($f['label']); ?>

            </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="grid grid-cols-2 gap-3">

    <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-amber-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors duration-500"></div>
        <div class="relative p-4 flex items-center gap-3">
            <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                <i class="fas fa-hourglass-half text-sm"></i>
            </div>
            <div class="flex flex-col min-w-0 flex-1">
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">En attente</p>
                <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none">
                    <?php echo e($stats['pending']->nb ?? 0); ?> retraits
                    <span class="text-[10px] text-slate-400 font-bold">(<?php echo e(number_format($stats['pending']->total ?? 0, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?>)</span>
                </p>
            </div>
        </div>
        <div class="relative pointer-events-none"><?php echo $sparkline($retraitsEvolution, $C['amber'], 28, 'rt-pending'); ?></div>
    </div>

    <div class="relative bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder hover:border-emerald-500/50 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 group overflow-hidden">
        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
        <div class="relative p-4 flex items-center gap-3">
            <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white group-hover:rotate-3 transition-all duration-300">
                <i class="fas fa-check-double text-sm"></i>
            </div>
            <div class="flex flex-col min-w-0 flex-1">
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Total retiré</p>
                <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none">
                    <?php echo e(number_format($stats['paid']->total ?? 0, 0, ',', ' ')); ?> <span class="text-[10px] text-slate-400 font-bold"><?php echo e(config('platform.currency')); ?></span>
                </p>
            </div>
        </div>
        <div class="relative pointer-events-none"><?php echo $sparkline($montantEvolution, $C['emerald'], 28, 'rt-paid'); ?></div>
    </div>

    </div>

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest border-b border-slate-100 dark:border-darkBorder/40 bg-white dark:bg-darkCard">
                        <th class="py-2.5 px-3 font-bold">ID</th>
                        <th class="py-2.5 px-3 font-bold">Date</th>
                        <th class="py-2.5 px-3 font-bold">Vendeur</th>
                        <th class="py-2.5 px-3 font-bold">Téléphone</th>
                        <th class="py-2.5 px-3 font-bold">Brut</th>
                        <th class="py-2.5 px-3 font-bold">Commission</th>
                        <th class="py-2.5 px-3 font-bold">Net</th>
                        <th class="py-2.5 px-3 font-bold">Statut</th>
                        <th class="py-2.5 px-3 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $retraits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($r->id); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400"><?php echo e(\Carbon\Carbon::parse($r->date_creation)->format('d/m/Y H:i')); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($r->vendeur?->prenom); ?> <?php echo e($r->vendeur?->nom); ?></td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300"><?php echo e($r->phone_number ?? '-'); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white"><?php echo e(number_format($r->montant_brut, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-amber-600 dark:text-amber-400"><?php echo e(number_format($r->montant_commission, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white"><?php echo e(number_format($r->montant_net, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></td>
                        <td class="py-2.5 px-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->statut === 'pending'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400">En attente</span>
                            <?php elseif($r->statut === 'paid'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400">Payé</span>
                            <?php elseif($r->statut === 'rejected'): ?>
                                <div class="flex flex-col gap-0.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 w-fit">Rejeté</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->note): ?>
                                        <span class="text-[9px] text-red-500 dark:text-red-400 max-w-[120px] truncate" title="<?php echo e($r->note); ?>"><?php echo e($r->note); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-2.5 px-3">
                            <div class="flex items-center gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->statut === 'pending'): ?>
                                <button wire:click="openConfirm('pay', <?php echo e($r->id); ?>, 'Marquer ce retrait comme payé ?', 'Payer', 'bg-emerald-600 hover:bg-emerald-700')"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:border-emerald-300 dark:hover:border-emerald-500/30 transition-all"
                                    title="Payer">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                </button>
                                <button wire:click="openRejectModal(<?php echo e($r->id); ?>)"
                                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:border-red-300 dark:hover:border-red-500/30 transition-all"
                                    title="Rejeter">
                                    <i class="fas fa-ban text-[10px]"></i>
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="9" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-inbox text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucun retrait trouvé.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($retraits->hasPages()): ?>
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            <?php echo e($retraits->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showRejectModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-darkBorder/40">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                    <i class="fas fa-times-circle text-red-500 mr-2"></i>Rejeter le retrait
                </h3>
                <button wire:click="closeRejectModal"
                    class="w-7 h-7 rounded-lg border border-slate-200 dark:border-darkBorder flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Motif du rejet</label>
                    <textarea wire:model="rejectReason" rows="3"
                        class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-red-500 outline-none transition-colors"
                        placeholder="Expliquez la raison du rejet..."></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rejectReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="closeRejectModal"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-darkBg transition-all">Annuler</button>
                    <button wire:click="confirmReject"
                        class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-sm">
                        <i class="fas fa-times-circle mr-1"></i>Rejeter
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/admin/retrait-manager.blade.php ENDPATH**/ ?>