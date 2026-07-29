@props([
    'show' => false,
    'onClose' => '',
    'icon' => 'plus',
    'iconBg' => 'green',
    'title' => '',
    'subtitle' => '',
    'maxWidth' => 'sm',
])
@php
    $iconMap = [
        'green' => 'bg-neonGreen/10 text-neonGreen',
        'amber' => 'bg-amber-500/10 text-amber-500',
        'red' => 'bg-red-100 dark:bg-red-500/10 text-red-500',
        'blue' => 'bg-blue-500/10 text-blue-500',
        'purple' => 'bg-purple-500/10 text-purple-500',
        'cyan' => 'bg-cyan-500/10 text-cyan-500',
        'slate' => 'bg-slate-100 dark:bg-darkBg text-slate-400',
    ];
    $iconClass = $iconMap[$iconBg] ?? $iconMap['green'];
    $widthClass = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-sm',
    };
@endphp
@if($show)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     @if($onClose) wire:click="{{ $onClose }}" @endif>
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 {{ $widthClass }} w-full"
         onclick="event.stopPropagation()">
        @if($icon)
        <div class="flex items-center justify-center w-12 h-12 rounded-full {{ $iconClass }} mx-auto mb-4">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
        @endif
        @if($title)
        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">{{ $title }}</h3>
        @endif
        @if($subtitle)
        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</div>
@endif
