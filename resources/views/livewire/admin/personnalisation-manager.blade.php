<div class="space-y-4">
    @if(session()->has('success'))
    <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4 sm:p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <i class="fab fa-whatsapp text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Message WhatsApp</h3>
                <p class="text-[10px] text-slate-500 dark:text-gray-400">Personnalisez le message envoyé depuis la page d'installation</p>
            </div>
        </div>
        <form wire:submit.prevent="save" class="space-y-4 max-w-lg">
            <div>
                <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Numéro WhatsApp</label>
                <input type="text" wire:model="whatsappNumber" required
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors">
                <p class="text-[10px] text-slate-400 mt-1">Format international sans le + (ex: 22662261391)</p>
                @error('whatsappNumber') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5">Template du message</label>
                <textarea wire:model="whatsappMessage" required rows="4"
                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold border-2 border-slate-200 dark:border-darkBorder bg-white dark:bg-darkBg text-slate-700 dark:text-gray-300 focus:border-neonGreen outline-none transition-colors resize-none"></textarea>
                <p class="text-[10px] text-slate-400 mt-1">
                    Placeholders disponibles :
                    <code class="text-neonGreen bg-neonGreen/5 px-1 rounded">{pack_nom}</code>
                    <code class="text-neonGreen bg-neonGreen/5 px-1 rounded">{pack_prix}</code>
                    <code class="text-neonGreen bg-neonGreen/5 px-1 rounded">{pack_prix_note}</code>
                    <code class="text-neonGreen bg-neonGreen/5 px-1 rounded">{platform_name}</code>
                </p>
                @error('whatsappMessage') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
            <button type="submit"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-sm">
                <i class="fas fa-save text-[10px]"></i>Enregistrer
            </button>
        </form>
    </div>
</div>
