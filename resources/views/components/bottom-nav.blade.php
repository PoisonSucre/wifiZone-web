@php
    $links = [
        ['route' => 'vendor.dashboard',     'label' => 'Accueil',      'icon' => 'fa-chart-line',              'url' => '/vendeur'],
        ['route' => 'vendor.hotspot',       'label' => 'Hotspots',     'icon' => 'fa-wifi',                    'url' => '/vendeur/hotspot'],
        ['route' => 'vendor.alertes',       'label' => 'Alertes',      'icon' => 'fa-exclamation-triangle',    'url' => '/vendeur/alertes'],
        ['route' => 'vendor.retraits',      'label' => 'Retraits',     'icon' => 'fa-wallet',                  'url' => '/vendeur/retraits'],
        ['route' => 'vendor.profil',        'label' => 'Profil',       'icon' => 'fa-user',                    'url' => '/vendeur/profil'],
    ];
    $vendeur = auth()->user();
    $retraitsPending = $vendeur ? $vendeur->withdrawals()->where('statut', 'pending')->count() : 0;
    
    $hotspotService = app(\App\Services\HotspotService::class);
    if ($vendeur) {
        $hotspotService->freezeExpiredSubscriptions($vendeur);
    }
    $hotspotRemaining = $vendeur ? $hotspotService->remaining($vendeur) : 0;
    $hotspotCanCreate = $vendeur ? $hotspotService->canCreate($vendeur) : true;
    
    foreach ($links as &$link) {
        if ($link['route'] === 'vendor.retraits' && $retraitsPending > 0) {
            $link['badge'] = $retraitsPending;
            $link['badge_type'] = 'numeric';
        }
        if ($link['route'] === 'vendor.hotspot' && $hotspotCanCreate && $hotspotRemaining > 0) {
            $link['badge'] = '+' . $hotspotRemaining;
            $link['badge_type'] = 'numeric';
        }
    }
    unset($link);
    $activeRoute = Route::currentRouteName();
@endphp
<nav class="mobile-bottom-nav" aria-label="Navigation mobile">
    @foreach($links as $link)
        @php $isActive = $activeRoute === $link['route']; @endphp
        <a href="{{ $link['url'] }}" wire:navigate class="mbn-item {{ $isActive ? 'active' : '' }}">
            <span class="mbn-icon">
                <i class="fas {{ $link['icon'] }}"></i>
                @if(!empty($link['badge']))
                    @if(($link['badge_type'] ?? '') === 'hotspot')
                        <span class="mbn-badge mbn-badge-hotspot">{{ $link['badge'] }}</span>
                    @else
                        <span class="mbn-badge">{{ $link['badge'] }}</span>
                    @endif
                @endif
            </span>
            <span class="mbn-label">{{ $link['label'] }}</span>
        </a>
    @endforeach
</nav>
