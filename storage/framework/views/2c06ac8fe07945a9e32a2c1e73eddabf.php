<?php
$vendeur = auth()->user();
$ticketsDispo = $vendeur ? $vendeur->tickets()->available()->count() : 0;
$retraitsPending = $vendeur ? $vendeur->withdrawals()->where('statut', 'pending')->count() : 0;

$hotspotService = app(\App\Services\HotspotService::class);
if ($vendeur) {
    $hotspotService->freezeExpiredSubscriptions($vendeur);
}
$hotspotUsed = $vendeur ? $hotspotService->usedSlots($vendeur) : 0;
$hotspotLimit = $vendeur ? $hotspotService->limit($vendeur) : 0;
$hotspotRemaining = $vendeur ? $hotspotService->remaining($vendeur) : 0;
$hotspotCanCreate = $vendeur ? $hotspotService->canCreate($vendeur) : true;
$hotspotBadge = $vendeur ? ($hotspotCanCreate ? "+{$hotspotRemaining} hotspot" . ($hotspotRemaining > 1 ? 's' : '') : "Quota atteint") : null;

$links = [
    ['route' => 'vendor.dashboard',     'label' => 'Dashboard',      'icon' => 'fa-chart-line',              'url' => '/vendeur'],
    ['route' => 'vendor.hotspot',       'label' => 'Mes Hotspots',   'icon' => 'fa-wifi',                    'url' => '/vendeur/hotspot', 'badge' => $hotspotBadge],
    ['route' => 'vendor.transactions',  'label' => 'Transactions',  'icon' => 'fa-receipt',                 'url' => '/vendeur/transactions'],
    ['route' => 'vendor.alertes',        'label' => 'Alertes',        'icon' => 'fa-exclamation-triangle',    'url' => '/vendeur/alertes'],
    ['route' => 'vendor.retraits',      'label' => 'Retraits',       'icon' => 'fa-wallet',                  'url' => '/vendeur/retraits'],
    ['route' => 'vendor.profil',        'label' => 'Profil',         'icon' => 'fa-user',                    'url' => '/vendeur/profil'],
];
$activeRoute = Route::currentRouteName();

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
<?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/sidebar-vendor.blade.php ENDPATH**/ ?>