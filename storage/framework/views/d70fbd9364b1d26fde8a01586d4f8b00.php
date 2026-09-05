<div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show): ?>
<div class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     wire:click="close"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl overflow-hidden max-w-lg w-full max-h-[92vh] flex flex-col"
         onclick="event.stopPropagation()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30 shrink-0">
            <div class="w-9 h-9 rounded-lg bg-cyan-500/10 text-cyan-500 flex items-center justify-center">
                <i class="fas fa-shield-alt text-sm"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Walled Garden MikroTik</h3>
                <p class="text-[10px] text-slate-400 dark:text-gray-500">Hotspot : <?php echo e($hotspotName); ?></p>
            </div>
            <button type="button" wire:click="close"
                    class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-600 transition-all">
                <i class="fas fa-times text-[11px]"></i>
            </button>
        </div>

        
        <div class="p-5 overflow-y-auto flex-1 min-h-0 space-y-3">

            
            <div class="rounded-xl bg-cyan-50 dark:bg-cyan-900/10 border border-cyan-200 dark:border-cyan-800/40 p-3">
                <p class="text-[11px] text-cyan-700 dark:text-cyan-400 leading-relaxed">
                    <i class="fas fa-info-circle mr-1"></i>
                    Copiez ces commandes et collez-les dans le <strong>Terminal MikroTik</strong> (Winbox → New Terminal). Cela permet aux clients non connectés d'accéder à la plateforme de paiement LigdiCash.
                </p>
            </div>

            
            <div class="relative">
                <div class="flex items-center justify-between mb-1.5">
                    <p class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest">
                        <i class="fas fa-code mr-1"></i> Commandes
                    </p>
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('walledGardenConfig').innerText);this.innerHTML='<i class=\'fas fa-check\'></i> Copié !';setTimeout(()=>this.innerHTML='<i class=\'fas fa-copy\'></i> Copier',2000)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-cyan-500 hover:bg-cyan-600 text-white text-[10px] font-bold transition-all shadow-sm">
                        <i class="fas fa-copy text-[9px]"></i> Copier
                    </button>
                </div>
                <pre id="walledGardenConfig" class="bg-slate-900 dark:bg-black/60 border border-slate-700 dark:border-darkBorder rounded-xl p-4 overflow-x-auto text-[10px] leading-relaxed text-slate-300 dark:text-gray-300 font-mono max-h-[350px] overflow-y-auto whitespace-pre"><?php echo e($config); ?></pre>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($mikrotikUrl)): ?>
            <div class="rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/40 p-3">
                <p class="text-[11px] text-amber-700 dark:text-amber-400 leading-relaxed">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Aucune URL MikroTik configurée. Modifiez le hotspot pour ajouter l'URL de votre routeur.
                </p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="px-5 py-4 border-t border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30 shrink-0 flex justify-end">
            <button type="button" wire:click="close"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-600 dark:text-gray-400 text-xs font-bold transition-all hover:border-cyan-500/50">
                <i class="fas fa-times text-[10px]"></i> Fermer
            </button>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/livewire/vendor/walled-garden-modal.blade.php ENDPATH**/ ?>