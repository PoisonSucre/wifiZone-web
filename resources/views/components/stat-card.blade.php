@props(['icon' => 'chart-line', 'color' => 'green', 'label' => '', 'value' => ''])
@php
$colorClass = match($color) {
    'green' => 'stat-green',
    'blue' => 'stat-blue',
    'orange' => 'stat-orange',
    'purple' => 'stat-purple',
    default => 'stat-green',
};
@endphp
<div {{ $attributes->merge(['class' => "stat-card {$colorClass}"]) }}>
    <div class="stat-icon"><i class="fas fa-{{ $icon }}"></i></div>
    <div class="stat-info">
        <span class="stat-value">{{ $value }}</span>
        <span class="stat-label">{{ $label }}</span>
    </div>
</div>
