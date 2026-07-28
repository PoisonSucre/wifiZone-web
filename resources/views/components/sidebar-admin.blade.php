<?php
$links = [
    ['route' => 'admin.dashboard',      'label' => 'Dashboard',      'icon' => 'fa-chart-line',     'url' => '/raider'],
    ['route' => 'admin.vendeurs',       'label' => 'Vendeurs',       'icon' => 'fa-store',          'url' => '/raider/vendeurs'],
    ['route' => 'admin.transactions',   'label' => 'Transactions',   'icon' => 'fa-exchange-alt',   'url' => '/raider/transactions'],
    ['route' => 'admin.tickets',        'label' => 'Tickets',        'icon' => 'fa-ticket-alt',     'url' => '/raider/tickets'],
    ['route' => 'admin.retraits',       'label' => 'Retraits',       'icon' => 'fa-wallet',         'url' => '/raider/retraits'],
    ['route' => 'admin.parametres',     'label' => 'Paramètres',     'icon' => 'fa-cog',            'url' => '/raider/parametres'],
];
$activeRoute = Route::currentRouteName();

$retraitsPending = \App\Models\Withdrawal::where('statut', 'pending')->count();

foreach ($links as &$link) {
    if ($link['route'] === 'admin.retraits' && $retraitsPending > 0) {
        $link['badge'] = $retraitsPending;
    }
}
unset($link);

$logoIcon = 'fa-shield-alt';
$brandText = 'Salut ' . (auth('admin')->user()->prenom ?? 'Raider') . ' 👋';
$navLabel = 'Administration';
$logoutRoute = 'admin.logout';
?>
@include('components.sidebar')
