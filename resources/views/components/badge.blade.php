@props(['type' => 'gray', 'label' => ''])
@php
$colors = [
    'success' => 'badge-success',
    'warning' => 'badge-warning',
    'info' => 'badge-info',
];
$class = $colors[$type] ?? '';
@endphp
<span {{ $attributes->merge(['class' => "badge {$class}"]) }}>
    {{ $label ?: $slot }}
</span>
