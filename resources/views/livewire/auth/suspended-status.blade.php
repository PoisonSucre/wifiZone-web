<div wire:poll.3s="pollStatus"
     x-data
     @redirect-to-login.window="window.location = '{{ route('vendor.login') }}'"
     @redirect-to-pending.window="window.location = '{{ route('vendor.pending') }}'">

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl p-4 mb-5 flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-500 mt-0.5 shrink-0"></i>
            <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Check button --}}
    <button wire:click="checkStatus" wire:loading.attr="disabled"
            class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-bold py-3 px-6 rounded-xl transition-all text-sm flex items-center justify-center gap-2 mb-4 disabled:opacity-50">
        <span wire:loading.remove wire:target="checkStatus" class="flex items-center gap-2">
            <i class="fas fa-sync-alt"></i> Vérifier mon statut
        </span>
        <span wire:loading wire:target="checkStatus" class="flex items-center gap-2">
            <i class="fas fa-spinner fa-spin"></i> Vérification...
        </span>
    </button>

    {{-- Status results --}}
    @if($status === 'suspendu')
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-2xl p-4 flex items-start gap-3 animate-pulse">
            <i class="fas fa-ban text-red-500 mt-0.5 shrink-0"></i>
            <div class="text-left">
                <p class="text-sm font-bold text-red-600 dark:text-red-400">Toujours suspendu</p>
                <p class="text-xs text-red-500/70 dark:text-red-400/70 mt-1">Votre compte est toujours suspendu. Vérification automatique toutes les 3 secondes.</p>
            </div>
        </div>
    @endif

    @if($status === 'not_found')
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-times-circle text-red-500 mt-0.5 shrink-0"></i>
            <p class="text-sm text-red-600 dark:text-red-400 text-left">Aucun compte trouvé. Veuillez contacter le support.</p>
        </div>
    @endif
</div>
