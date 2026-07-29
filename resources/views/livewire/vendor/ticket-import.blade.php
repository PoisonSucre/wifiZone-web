@php
    $currency = config('platform.currency') ?? 'FCFA';
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
            <div class="h-4 w-32 bg-slate-200 dark:bg-slate-700/40 rounded mb-4"></div>
            <div class="h-10 w-full bg-slate-100 dark:bg-slate-700/20 rounded-xl mb-4"></div>
            <div class="h-16 w-full bg-slate-100 dark:bg-slate-700/20 rounded-xl mb-4"></div>
            <div class="h-12 w-full bg-slate-200 dark:bg-slate-700/40 rounded-xl mb-4"></div>
            <div class="h-12 w-40 bg-slate-200 dark:bg-slate-700/40 rounded-full"></div>
        </div>
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="h-4 w-48 bg-slate-200 dark:bg-slate-700/40 rounded mb-3"></div>
            <div class="space-y-2">
                @for ($j = 0; $j < 5; $j++)
                    <div class="h-3 bg-slate-100 dark:bg-slate-700/20 rounded w-full"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- CONTENU RÉEL --}}
    <div x-data="{ loaded: false, fileName: '' }"
         x-init="$nextTick(() => loaded = true)"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- FORMULAIRE D'IMPORT --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                    <i class="fas fa-upload text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Configuration de l'import</h3>
            </div>
            <div class="p-4 space-y-5">

                {{-- MODE D'IMPORT --}}
                <div>
                    <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2 block">Mode d'importation</label>
                    <div class="grid grid-cols-2 p-1.5 gap-1 bg-slate-100/80 dark:bg-darkBg/80 rounded-xl border border-slate-200/60 dark:border-darkBorder/50 relative">
                        <div class="absolute top-1.5 bottom-1.5 rounded-lg bg-white dark:bg-darkCard shadow-sm transition-all duration-300 ease-out border border-slate-100 dark:border-darkBorder/50"
                             :class="$wire.importMode === 'without_password' ? 'left-1.5 w-[calc(50%-6px)]' : 'left-[calc(50%+3px)] w-[calc(50%-6px)]'"></div>
                        <label wire:click="$set('importMode', 'without_password')"
                               class="relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold cursor-pointer transition-all duration-200 select-none z-10"
                               :class="$wire.importMode === 'without_password' ? 'text-neonGreen' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">
                            <input type="radio" value="without_password" class="sr-only" {{ $importMode === 'without_password' ? 'checked' : '' }}>
                            <i class="fas fa-ticket text-sm"></i>
                            Tickets
                        </label>
                        <label wire:click="$set('importMode', 'with_password')"
                               class="relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold cursor-pointer transition-all duration-200 select-none z-10"
                               :class="$wire.importMode === 'with_password' ? 'text-neonGreen' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">
                            <input type="radio" value="with_password" class="sr-only" {{ $importMode === 'with_password' ? 'checked' : '' }}>
                            <i class="fas fa-users text-sm"></i>
                            Membres
                        </label>
                    </div>
                </div>

                {{-- FORMAT CSV --}}
                <div class="p-4 rounded-xl bg-slate-50/80 dark:bg-darkBg/40 border border-slate-100 dark:border-darkBorder/30">
                    <p class="text-xs font-bold text-slate-700 dark:text-white mb-2 flex items-center gap-2">
                        <i class="fas fa-file-code text-neonGreen text-[10px]"></i>
                        Format CSV attendu
                    </p>
                    @if($importMode === 'with_password')
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <code class="font-mono text-xs px-3 py-2 rounded-lg bg-slate-100 dark:bg-darkBorder/50 text-neonGreen font-bold border border-neonGreen/10">user;password;forfait;montant</code>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">4 colonnes</span>
                        </div>
                        <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold leading-relaxed">
                            <i class="fas fa-exclamation-triangle text-[10px] mr-1"></i>
                            Importez les codes et mots de passe générés dans Mikhmon.
                        </p>
                    </div>
                    @else
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <code class="font-mono text-xs px-3 py-2 rounded-lg bg-slate-100 dark:bg-darkBorder/50 text-neonGreen font-bold border border-neonGreen/10">user;forfait;montant</code>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">3 colonnes</span>
                        </div>
                        <p class="text-emerald-600 dark:text-emerald-400 text-xs font-semibold leading-relaxed">
                            <i class="fas fa-check-circle text-[10px] mr-1"></i>
                            Le mot de passe sera attribué automatiquement par la plateforme.
                        </p>
                    </div>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('vendor.template') }}?format=csv&mode={{ $importMode }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-neonGreen/20 bg-neonGreen/5 text-neonGreen text-[11px] font-bold hover:bg-neonGreen/10 transition-all">
                            <i class="fas fa-download text-[10px]"></i> Template CSV
                        </a>
                        <a href="{{ route('vendor.template') }}?format=excel&mode={{ $importMode }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-blue-500/20 bg-blue-500/5 text-blue-500 text-[11px] font-bold hover:bg-blue-500/10 transition-all">
                            <i class="fas fa-download text-[10px]"></i> Template Excel
                        </a>
                    </div>
                </div>

                {{-- UPLOAD --}}
                <div>
                    <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2 block">Fichier</label>
                    <div class="relative">
                        <input type="file" wire:model="importFile"
                               accept=".csv,.xlsx,.xls"
                               @change="fileName = $event.target.files[0]?.name || ''"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-neonGreen/10 file:text-neonGreen focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                        @if($importFile)
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5 text-[10px] font-bold text-neonGreen bg-neonGreen/10 px-2 py-1 rounded-lg">
                            <i class="fas fa-check text-[8px]"></i>
                            <span class="max-w-[100px] truncate">{{ $importFile->getClientOriginalName() }}</span>
                        </div>
                        @endif
                    </div>
                    @error('importFile') <p class="text-[10px] text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-1.5">
                        <i class="fas fa-info-circle mr-1"></i>
                        Formats acceptés : .CSV, .XLSX, .XLS — max 5 Mo
                    </p>
                </div>

                {{-- BOUTON IMPORT --}}
                <div class="flex items-center gap-3">
                    <button wire:click="importFile" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-[11px] font-bold transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove><i class="fas fa-upload text-[10px]"></i> Importer</span>
                        <span wire:loading class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-[10px]"></i> Import en cours...
                        </span>
                    </button>
                </div>

                {{-- RÉSULTAT --}}
                @if($importResult)
                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-3 rounded-xl text-xs font-bold border {{ $importSuccess ? 'bg-emerald-50 dark:bg-neonGreen/10 border-emerald-200 dark:border-neonGreen/20 text-emerald-700 dark:text-neonGreen' : 'bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400' }}">
                    <div class="flex items-center gap-2">
                        <i class="fas {{ $importSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' }} text-sm"></i>
                        <span>{{ $importResult }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- GUIDE MIKHMON --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-question-circle text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Guide Mikhmon</h3>
            </div>
            <div class="p-4 space-y-4">

                {{-- Note mode --}}
                <div class="flex gap-3">
                    <div class="shrink-0 w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center">
                        <i class="fas fa-info text-neonGreen text-[10px]"></i>
                    </div>
                    <div class="text-xs text-slate-600 dark:text-gray-400 leading-relaxed">
                        <template x-if="importMode === 'without_password'">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white">Mode Tickets :</span> Importez les codes générés dans Mikhmon au format <code class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-slate-100 dark:bg-darkBorder/50 text-neonGreen border border-neonGreen/10">user;forfait;montant</code>. Le mot de passe est attribué automatiquement.
                            </div>
                        </template>
                        <template x-if="importMode === 'with_password'">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white">Mode Membres :</span> Importez les codes et mots de passe au format <code class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-slate-100 dark:bg-darkBorder/50 text-neonGreen border border-neonGreen/10">user;password;forfait;montant</code>. Utile si vous souhaitez conserver les mots de passe d'origine.
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Étapes --}}
                <div class="space-y-2.5">
                    @php
                        $steps = [
                            'Ouvrez Mikhmon sur votre PC et connectez-vous à votre routeur MikroTik.',
                            'Allez dans Hotspot → User Profile → Add Profile pour créer un profil.',
                            'Allez dans Hotspot → Users → Generate.',
                            'Renseignez la QTY, choisissez le Server, et sélectionnez User Mode → Username = Password.',
                            'Définissez la longueur du code (6 à 8 caractères) et sélectionnez le Profile créé.',
                            'Cliquez sur Generate → les tickets apparaissent dans User List.',
                            'Pour exporter, sélectionnez les tickets puis cliquez sur Print → Save as PDF.',
                        ];
                    @endphp
                    @foreach($steps as $i => $step)
                        <div class="flex items-start gap-2.5">
                            <span class="shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold flex items-center justify-center mt-0.5">{{ $i + 1 }}</span>
                            <span class="text-xs text-slate-600 dark:text-gray-400 leading-relaxed">{!! $step !!}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Note --}}
                <div class="p-3 rounded-xl bg-blue-50/80 dark:bg-blue-500/5 border border-blue-200/60 dark:border-blue-500/20">
                    <p class="text-blue-700 dark:text-blue-400 text-[11px] font-semibold leading-relaxed">
                        <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
                        Chaque ticket Mikhmon utilise le <strong>même code</strong> comme nom d'utilisateur et mot de passe. Dans le mode Tickets, il suffit d'importer le code, le forfait et le montant.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
