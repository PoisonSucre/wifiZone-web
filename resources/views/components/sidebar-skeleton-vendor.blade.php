@php
$skeletonLinks = [
    'vendor.dashboard',
    'vendor.tickets',
    'vendor.boutique',
    'vendor.hotspot',
    'vendor.import',
    'vendor.retraits',
    'vendor.profil',
];
@endphp

<div class="sidebar-skeleton" id="sidebar-skeleton">
    <div class="skeleton-header">
        <div class="skeleton-logo"></div>
        <div class="skeleton-brand"></div>
    </div>
    <div class="skeleton-nav">
        @foreach($skeletonLinks as $link)
        <div class="skeleton-link">
            <div class="skeleton-icon"></div>
            <div class="skeleton-text"></div>
        </div>
        @endforeach
    </div>
    <div class="skeleton-footer">
        <div class="skeleton-btn"></div>
        <div class="skeleton-btn"></div>
    </div>
</div>
