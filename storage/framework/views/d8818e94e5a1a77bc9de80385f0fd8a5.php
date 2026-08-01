<?php
    $vendeur = auth()->user();
    $service = app(\App\Services\HotspotService::class);
    $service->freezeExpiredSubscriptions($vendeur);
    $canCreate = $service->canCreate($vendeur);
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCreate): ?>
<button type="button"
        onclick="Livewire.dispatch('open-hotspot-form')"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md shrink-0 self-end">
    <i class="fas fa-plus text-[10px]"></i>
    Nouveau Hotspot
</button>
<?php else: ?>
<button type="button" disabled
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-200 dark:bg-darkBorder text-slate-400 dark:text-gray-500 text-[11px] font-bold transition-all cursor-not-allowed shrink-0 self-end">
    <i class="fas fa-ban text-[10px]"></i>
    Quota atteint
</button>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/hotspot-create-button.blade.php ENDPATH**/ ?>