<?php
$links = [
    ['route' => 'vendor.dashboard',     'label' => 'Dashboard',      'icon' => 'fa-chart-line',              'url' => '/vendeur'],
    ['route' => 'vendor.hotspot',       'label' => 'Mes Hotspots',   'icon' => 'fa-wifi',                    'url' => '/vendeur/hotspot'],
    ['route' => 'vendor.alertes',        'label' => 'Alertes',        'icon' => 'fa-exclamation-triangle',    'url' => '/vendeur/alertes'],
    ['route' => 'vendor.retraits',      'label' => 'Retraits',       'icon' => 'fa-wallet',                  'url' => '/vendeur/retraits'],
    ['route' => 'vendor.profil',        'label' => 'Profil',         'icon' => 'fa-user',                    'url' => '/vendeur/profil'],
];
$activeRoute = Route::currentRouteName();

$vendeur = auth()->user();
$ticketsDispo = $vendeur ? $vendeur->tickets()->available()->count() : 0;
$retraitsPending = $vendeur ? $vendeur->withdrawals()->where('statut', 'pending')->count() : 0;

foreach ($links as &$link) {
    if ($link['route'] === 'vendor.retraits' && $retraitsPending > 0) {
        $link['badge'] = $retraitsPending;
    }
}
unset($link);

$logoIcon = 'fa-wifi';
$brandText = 'Salut ' . ($vendeur->prenom ?? '') . ' 👋';
$navLabel = 'Menu principal';
$logoutRoute = 'vendor.logout';
?>
@include('components.sidebar')
