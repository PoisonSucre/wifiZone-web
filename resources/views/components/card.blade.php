@props(['padding' => 'p-5', 'class' => '', 'header' => false])
@php
    $base = 'bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl';
    $paddingClass = $header ? '' : $padding;
@endphp
<div {{ $attributes->merge(['class' => "{$base} {$paddingClass} {$class}"]) }}>
    @if($header)
        {{ $header }}
    @endif
    @if(!$header)
        {{ $slot }}
    @else
        <div class="{{ $padding }}">
            {{ $slot }}
        </div>
    @endif
</div>
