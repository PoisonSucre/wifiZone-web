@props(['icon' => 'cog', 'color' => 'green'])
@php
    $colorMap = [
        'green' => 'bg-neonGreen/10 text-neonGreen',
        'amber' => 'bg-amber-500/10 text-amber-500',
        'red' => 'bg-red-500/10 text-red-500',
        'blue' => 'bg-blue-500/10 text-blue-500',
        'purple' => 'bg-purple-500/10 text-purple-500',
        'cyan' => 'bg-cyan-500/10 text-cyan-500',
        'slate' => 'bg-slate-400/10 text-slate-400',
        'orange' => 'bg-orange-500/10 text-orange-500',
    ];
    $iconClass = $colorMap[$color] ?? $colorMap['green'];
@endphp
<div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
    <div class="w-8 h-8 rounded-lg {{ $iconClass }} flex items-center justify-center">
        <i class="fas fa-{{ $icon }} text-xs"></i>
    </div>
    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">{{ $slot }}</h3>
</div>
