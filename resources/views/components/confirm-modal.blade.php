@props(['id' => 'confirm-modal', 'title' => 'Confirmation', 'message' => 'Êtes-vous sûr ?', 'confirmAction' => '', 'confirmText' => 'Confirmer'])
<div id="{{ $id }}" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('{{ $id }}', false)"></div>
        <div class="relative bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-xl shadow-xl max-w-md w-full mx-auto p-6 z-10">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $message }}</p>
            {{ $slot }}
        </div>
    </div>
</div>
