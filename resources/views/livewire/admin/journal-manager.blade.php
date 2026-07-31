<div class="space-y-4">
    @php
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
    @endphp

    <div class="flex flex-wrap items-center gap-2">
        <button wire:click="$set('filterAction', '')"
            class="px-3 py-1.5 rounded-full text-[11px] font-bold transition-all border {{ $filterAction === '' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30' }}">
            <i class="fas fa-list mr-1"></i>Tous
        </button>
        @foreach($actions as $action => $data)
            <button wire:click="$set('filterAction', '{{ $action }}')"
                class="px-3 py-1.5 rounded-full text-[11px] font-bold transition-all border {{ $filterAction === $action ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-darkCard text-slate-600 dark:text-gray-400 border-slate-200 dark:border-darkBorder hover:border-emerald-300 dark:hover:border-emerald-500/30' }}">
                <i class="fas {{ $actionLabels[$action]['icon'] ?? 'fa-circle' }} mr-1"></i>{{ $actionLabels[$action]['label'] ?? $action }}
                <span class="opacity-60">({{ $data->nb }})</span>
            </button>
        @endforeach
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
                    @forelse($logs as $log)
                    <tr class="border-b border-slate-50 dark:border-darkBorder/20 hover:bg-slate-50/70 dark:hover:bg-darkBg/40 transition-colors last:border-0">
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="py-2.5 px-3 text-xs font-bold text-slate-900 dark:text-white">
                            {{ $log->admin?->fullName() ?? 'Admin #' . $log->admin_id }}
                        </td>
                        <td class="py-2.5 px-3">{!! $badge($log->action) !!}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400">
                            @if($log->target_type && $log->target_id)
                                {{ $log->target_type }} #{{ $log->target_id }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-2.5 px-3 text-xs text-slate-700 dark:text-gray-300 max-w-[260px] truncate" title="{{ $log->details }}">{{ $log->details ?? '—' }}</td>
                        <td class="py-2.5 px-3 text-xs text-slate-500 dark:text-gray-400">{{ $log->ip ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-xs text-slate-400 dark:text-gray-500">
                            <i class="fas fa-clipboard-list text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                            Aucune entrée du journal.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-3 py-3 border-t border-slate-100 dark:border-darkBorder/40 flex justify-center">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
