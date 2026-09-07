<div wire:poll.5s="pollStatus"
     x-data
     @redirect-to-login.window="window.location = '{{ route('vendor.login') }}'"
     @redirect-to-suspended.window="window.location = '{{ route('vendor.suspended') }}'">

    @if($status === 'actif')
        <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-3 flex items-center gap-2 text-sm text-emerald-700 dark:text-emerald-400">
            <i class="fas fa-check-circle"></i> Compte activé ! Redirection...
        </div>
    @endif

    @if($status === 'suspendu')
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-xl p-3 flex items-center gap-2 text-sm text-red-700 dark:text-red-400">
            <i class="fas fa-ban"></i> Compte suspendu. Redirection...
        </div>
    @endif

    @if($status === 'not_found')
        <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800/50 rounded-xl p-3 flex items-center gap-2 text-sm text-red-700 dark:text-red-400">
            <i class="fas fa-times-circle"></i> Aucun compte trouvé.
        </div>
    @endif
</div>
