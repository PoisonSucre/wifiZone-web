<div>
    {{-- Step Indicator --}}
    <div class="flex items-center justify-center mb-8">
        @foreach([1 => 'Identité', 2 => 'Contact', 3 => 'Sécurité'] as $num => $label)
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $step >= $num ? 'bg-neonGreen text-white' : 'bg-slate-200 dark:bg-darkBorder text-slate-400 dark:text-gray-500' }}">
                    {{ $num }}
                </div>
                <span class="ml-1 text-xs text-slate-500 dark:text-gray-400 hidden sm:inline">{{ $label }}</span>
                @if($num < 3)
                    <div class="w-8 h-0.5 mx-2 {{ $step > $num ? 'bg-neonGreen' : 'bg-slate-200 dark:bg-darkBorder' }}"></div>
                @endif
            </div>
        @endforeach
    </div>

    <form class="space-y-5">
        <div x-show="$wire.step === 1" class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Prénom</label>
                <input type="text" wire:model="prenom" required
                       placeholder="Votre prénom"
                       class="block w-full px-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Nom</label>
                <input type="text" wire:model="nom" required
                       placeholder="Votre nom"
                       class="block w-full px-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div x-show="$wire.step === 2" class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" wire:model="email" required autocomplete="email"
                           placeholder="votre@email.com"
                           class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                </div>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Téléphone</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="tel" wire:model="telephone" required autocomplete="tel"
                           placeholder="66 63 59 58"
                           class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                </div>
                @error('telephone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div x-show="$wire.step === 3" class="space-y-4" x-data="{ showPassword: false }">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Mot de Passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input :type="showPassword ? 'text' : 'password'" wire:model.live="password" required
                           placeholder="Min. 6 caractères"
                           class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-neonGreen transition-colors">
                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Confirmer le Mot de Passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input :type="showPassword ? 'text' : 'password'" wire:model.live="passwordConfirmation" required
                           placeholder="Confirmez votre mot de passe"
                           class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                </div>
                <div x-show="$wire.passwordConfirmation.length > 0" class="mt-2 text-xs font-bold">
                    <span x-show="$wire.password === $wire.passwordConfirmation" class="text-green-500">
                        <i class="fas fa-check-circle"></i> Les mots de passe correspondent
                    </span>
                    <span x-show="$wire.password !== $wire.passwordConfirmation" class="text-red-500">
                        <i class="fas fa-times-circle"></i> Les mots de passe ne correspondent pas
                    </span>
                </div>
                @error('passwordConfirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            @if($step > 1)
                <button type="button" wire:click="prevStep"
                        class="flex-1 bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-4 px-6 rounded-2xl transition-all text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Retour
                </button>
            @endif
            <button type="button" wire:click="submit" wire:loading.attr="disabled"
                    class="flex-1 bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-4 px-6 rounded-2xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                
                <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                    @if($step < 3)
                        Suivant <i class="fas fa-arrow-right"></i>
                    @else
                        <i class="fas fa-user-plus"></i> S'inscrire
                    @endif
                </span>
                
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i> Traitement...
                </span>
            </button>
        </div>
    </form>
</div>
