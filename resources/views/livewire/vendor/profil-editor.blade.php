@php
    $vendeur = auth()->user();
@endphp

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="space-y-4 sm:space-y-5 pb-2">

    {{-- SKELETON --}}
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4 animate-pulse">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="h-4 w-40 bg-slate-200 dark:bg-slate-700/40 rounded mb-4"></div>
            <div class="space-y-3">
                @for ($j = 0; $j < 4; $j++)
                    <div class="h-10 bg-slate-100 dark:bg-slate-700/20 rounded-xl"></div>
                @endfor
            </div>
        </div>
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="h-4 w-40 bg-slate-200 dark:bg-slate-700/40 rounded mb-4"></div>
            <div class="space-y-3">
                @for ($j = 0; $j < 3; $j++)
                    <div class="h-10 bg-slate-100 dark:bg-slate-700/20 rounded-xl"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- FLASH --}}
        @if($saved)
            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-neonGreen/10 border border-emerald-200 dark:border-neonGreen/20 text-emerald-700 dark:text-neonGreen text-xs font-bold flex items-center gap-2"
                 x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <i class="fas fa-check-circle text-sm"></i> Profil mis à jour avec succès.
            </div>
        @endif

        {{-- FORMULAIRES --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="space-y-4">

            {{-- INFOS PERSONNELLES --}}
            <div class="flex-1 min-w-[280px] bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                    <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                        <i class="fas fa-user-edit text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Informations personnelles</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-2 p-2.5 rounded-lg bg-blue-50 dark:bg-blue-500/5 border border-blue-200/60 dark:border-blue-500/20 mb-4">
                        <i class="fas fa-info-circle text-blue-500 text-[10px]"></i>
                        <span class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold">L'email ne peut pas être modifié.</span>
                    </div>
                    <form wire:submit.prevent="save" class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Prénom</label>
                                <input type="text" wire:model.live="prenom" placeholder="Prénom"
                                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                                @error('prenom') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Nom</label>
                                <input type="text" wire:model.live="nom" placeholder="Nom"
                                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                                @error('nom') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Téléphone</label>
                                <input type="text" wire:model.live="telephone" placeholder="Ex: 666 359 580"
                                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                                @error('telephone') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Ville</label>
                                <input type="text" wire:model.live="ville" placeholder="Ex: Douala"
                                       class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Adresse</label>
                            <input type="text" wire:model.live="adresse" placeholder="Ex: Rue 1.234"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Email</label>
                            <input type="email" value="{{ $email }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-200/50 dark:bg-darkBg/50 border border-slate-200/80 dark:border-darkBorder text-sm text-slate-400 dark:text-gray-500 cursor-not-allowed">
                        </div>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md mt-2">
                            <i class="fas fa-save text-[10px]"></i> Sauvegarder
                        </button>
                    </form>
                </div>
            </div>

            {{-- MOT DE PASSE --}}
            <div class="flex-1 min-w-[280px] bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                    <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500">
                        <i class="fas fa-lock text-xs"></i>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Changer le mot de passe</h3>
                </div>
                <div class="p-4">
                    <form wire:submit.prevent="save" class="space-y-3">
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Mot de passe actuel</label>
                            <input type="password" wire:model.live="currentPassword" placeholder="Votre mot de passe actuel"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            @error('currentPassword') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Nouveau mot de passe</label>
                            <input type="password" wire:model.live="newPassword" placeholder="Votre mot de passe"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            @error('newPassword') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 block">Confirmer</label>
                            <input type="password" wire:model.live="confirmPassword" placeholder="Retapez le mot de passe"
                                   class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                            @error('confirmPassword') <p class="text-red-500 text-[11px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md mt-2">
                            <i class="fas fa-save text-[10px]"></i> Mettre à jour le mot de passe
                        </button>
                    </form>
</div>
        </div>
        </div>
    </div>
</div>
