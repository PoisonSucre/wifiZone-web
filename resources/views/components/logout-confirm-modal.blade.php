@props(['id' => 'logout-confirm-modal', 'title' => 'Confirmer la déconnexion', 'message' => 'Voulez-vous vraiment vous déconnecter ?', 'confirmText' => 'Se déconnecter', 'cancelText' => 'Annuler', 'formRef' => 'logoutForm', 'color' => 'amber', 'open' => false])

<div x-data="{ open: @js($attributes->get('open', false)) }" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="$dispatch('close')" @keydown.escape.window="$dispatch('close')" @close.window="open = false">
    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-500/10 text-{{ $color }}-500 mx-auto mb-4">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">{{ $title }}</h3>
        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">{{ $message }}</p>
        <div class="flex gap-3">
            <button type="button" @click="$dispatch('close')" class="flex-1 bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-3 px-4 rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                {{ $cancelText }}
            </button>
            <button type="button" @click="$dispatch('confirm')" class="flex-1 bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3 px-4 rounded-xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                <i class="fas fa-sign-out-alt"></i> {{ $confirmText }}
            </button>
        </div>
    </div>
</div>