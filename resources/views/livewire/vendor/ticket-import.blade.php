@php
    $currency = config('platform.currency') ?? 'FCFA';
@endphp

<div x-data="{ loaded: false }" x-cloak
     x-init="$nextTick(() => loaded = true)"
     class="space-y-4 sm:space-y-5 pb-2 max-w-3xl mx-auto">

    {{-- SKELETON --}}
    <div x-show="!loaded"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4 animate-pulse">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-5">
            <div class="h-4 w-32 bg-slate-200 dark:bg-slate-700/40 rounded mb-4"></div>
            <div class="h-10 w-full bg-slate-100 dark:bg-slate-700/20 rounded-xl mb-4"></div>
        </div>
    </div>

    {{-- CONTENU RÉEL --}}
    <div x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="space-y-4 sm:space-y-5">

        {{-- STEPPER --}}
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl p-4">
            <div class="flex items-center justify-between">
                @php
                    $steps = [
                        1 => ['icon' => 'fa-wifi', 'label' => 'Hotspot'],
                        2 => ['icon' => 'fa-tag', 'label' => 'Forfait'],
                        3 => ['icon' => 'fa-upload', 'label' => 'Import'],
                    ];
                @endphp
                @foreach($steps as $num => $step)
                    <div class="flex items-center {{ $num < 3 ? 'flex-1' : '' }}">
                        <div class="flex items-center gap-2 cursor-pointer"
                             wire:click="goToStep({{ $num }})">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all {{
                                $currentStep === $num
                                    ? 'bg-neonGreen text-white shadow-md scale-110'
                                    : ($currentStep > $num
                                        ? 'bg-neonGreen/20 text-neonGreen'
                                        : 'bg-slate-100 dark:bg-darkBg text-slate-400 dark:text-gray-600')
                            }}">
                                @if($currentStep > $num)
                                    <i class="fas fa-check text-[10px]"></i>
                                @else
                                    <i class="fas {{ $step['icon'] }} text-[10px]"></i>
                                @endif
                            </div>
                            <span class="text-[11px] font-bold hidden sm:inline {{
                                $currentStep === $num ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-gray-500'
                            }}">{{ $step['label'] }}</span>
                        </div>
                        @if($num < 3)
                            <div class="flex-1 h-0.5 mx-2 rounded-full transition-all {{
                                $currentStep > $num ? 'bg-neonGreen' : 'bg-slate-200 dark:bg-darkBorder'
                            }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- STEP 1 : HOTSPOT (uniquement si non pré-sélectionné) --}}
        @if($currentStep === 1)
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-wifi text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Étape 1 — Sélectionnez le hotspot</h3>
            </div>
            <div class="p-4 space-y-4">
                <p class="text-xs text-slate-500 dark:text-gray-400">
                    Choisissez le hotspot sur lequel les tickets importés seront rattachés.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($hotspots as $hs)
                    <button type="button" wire:click="$set('hotspotId', {{ $hs->id }})"
                            class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all text-left {{
                                $hotspotId === $hs->id
                                    ? 'border-neonGreen bg-neonGreen/5'
                                    : 'border-slate-200 dark:border-darkBorder hover:border-slate-300 dark:hover:border-darkBorder/80'
                            }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{
                            $hotspotId === $hs->id ? 'bg-neonGreen text-white' : 'bg-slate-100 dark:bg-darkBg text-slate-400'
                        }}">
                            <i class="fas fa-wifi text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $hs->name }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500">{{ $hs->statut === 'actif' ? 'Actif' : 'Inactif' }}</p>
                        </div>
                        @if($hotspotId === $hs->id)
                            <i class="fas fa-check-circle text-neonGreen text-sm"></i>
                        @endif
                    </button>
                    @endforeach
                </div>

                @if($hotspots->isEmpty())
                <div class="rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/40 p-4 text-center">
                    <p class="text-sm text-amber-700 dark:text-amber-400 font-bold mb-2">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Aucun hotspot configuré
                    </p>
                    <a href="{{ route('vendor.hotspot') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition-all">
                        <i class="fas fa-plus text-[10px]"></i> Créer un hotspot
                    </a>
                </div>
                @endif

                @error('hotspotId') <p class="text-[10px] text-red-500 font-bold">{{ $message }}</p> @enderror

                @if($hotspots->isNotEmpty())
                <div class="flex justify-end">
                    <button type="button" wire:click="nextStep"
                            {{ $hotspotId <= 0 ? 'disabled' : '' }}
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-xs font-bold transition-all shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                        Suivant <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Bandeau hotspot si pré-sélectionné --}}
        @if($hotspotPreselected && $currentStep > 1)
        <div class="bg-neonGreen/5 border border-neonGreen/20 rounded-xl p-3 flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                <i class="fas fa-wifi text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest">Hotspot sélectionné</p>
                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $hotspots->firstWhere('id', $hotspotId)?->name ?? '—' }}</p>
            </div>
            <button type="button" wire:click="$set('currentStep', 1)"
                    class="text-[10px] font-bold text-neonGreen hover:underline">
                Changer
            </button>
        </div>
        @endif

        {{-- STEP 2 : FORFAIT --}}
        @if($currentStep === 2)
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                    <i class="fas fa-tag text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Étape 2 — Sélectionnez le forfait</h3>
            </div>
            <div class="p-4 space-y-4">
                <p class="text-xs text-slate-500 dark:text-gray-400">
                    Le montant de chaque ticket importé sera celui du forfait sélectionné. Mikhmon ne contient pas de prix dans son export.
                </p>

                @if($forfaits->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($forfaits as $fr)
                    <button type="button" wire:click="$set('forfaitId', {{ $fr->id }})"
                            class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all text-left {{
                                $forfaitId === $fr->id
                                    ? 'border-neonGreen bg-neonGreen/5'
                                    : 'border-slate-200 dark:border-darkBorder hover:border-slate-300 dark:hover:border-darkBorder/80'
                            }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{
                            $forfaitId === $fr->id ? 'bg-neonGreen text-white' : 'bg-slate-100 dark:bg-darkBg text-slate-400'
                        }}">
                            <i class="fas fa-tag text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $fr->label }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-gray-500">
                                {{ number_format($fr->montant, 0, ',', ' ') }} {{ $currency }} — {{ $fr->formattedDuration() }}
                            </p>
                        </div>
                        @if($forfaitId === $fr->id)
                            <i class="fas fa-check-circle text-neonGreen text-sm"></i>
                        @endif
                    </button>
                    @endforeach
                </div>
                @else
                <div class="rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/40 p-4 text-center space-y-3">
                    <p class="text-sm text-amber-700 dark:text-amber-400 font-bold">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Aucun forfait configuré
                    </p>
                    <p class="text-[11px] text-amber-600 dark:text-amber-400/80">
                        Vous devez créer au moins un forfait avant d'importer des tickets. Le prix des tickets provient du forfait, pas du fichier Mikhmon.
                    </p>
                    <a href="{{ route('vendor.boutique', ['hotspot' => $hotspotId, 'from' => 'import']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition-all">
                        <i class="fas fa-plus text-[10px]"></i> Configurer un forfait
                    </a>
                </div>
                @endif

                @error('forfaitId') <p class="text-[10px] text-red-500 font-bold">{{ $message }}</p> @enderror

                <div class="flex justify-between">
                    <button type="button" wire:click="previousStep"
                            @if($hotspotPreselected) wire:click="$set('currentStep', 1)" @endif
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-600 dark:text-gray-400 text-xs font-bold transition-all hover:bg-slate-200 dark:hover:bg-darkBorder">
                        <i class="fas fa-arrow-left text-[10px]"></i> Retour
                    </button>
                    @if($forfaits->isNotEmpty())
                    <button type="button" wire:click="nextStep"
                            {{ $forfaitId <= 0 ? 'disabled' : '' }}
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-xs font-bold transition-all shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                        Suivant <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- STEP 3 : UPLOAD --}}
        @if($currentStep === 3)
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-upload text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Étape 3 — Importez le fichier Mikhmon</h3>
            </div>
            <div class="p-4 space-y-4">

                {{-- Résumé sélection --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="rounded-xl bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 p-3">
                        <p class="text-[9px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Hotspot</p>
                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate">
                            {{ $hotspots->firstWhere('id', $hotspotId)?->name ?? '—' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder/40 p-3">
                        <p class="text-[9px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">Forfait</p>
                        @php $selFr = $forfaits->firstWhere('id', $forfaitId); @endphp
                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate">
                            {{ $selFr?->label ?? '—' }}
                            <span class="text-slate-400 font-normal">· {{ $selFr ? number_format($selFr->montant, 0, ',', ' ') . ' ' . $currency : '' }}</span>
                        </p>
                    </div>
                </div>

                {{-- Format Mikhmon --}}
                <div class="p-4 rounded-xl bg-slate-50/80 dark:bg-darkBg/40 border border-slate-100 dark:border-darkBorder/30">
                    <p class="text-xs font-bold text-slate-700 dark:text-white mb-2 flex items-center gap-2">
                        <i class="fas fa-file-code text-neonGreen text-[10px]"></i>
                        Format Mikhmon (export CSV)
                    </p>
                    <code class="block font-mono text-[11px] px-3 py-2 rounded-lg bg-slate-100 dark:bg-darkBorder/50 text-neonGreen font-bold border border-neonGreen/10">
                        Username,Password,Profile,Time Limit,Data Limit,Comment
                    </code>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-2 leading-relaxed">
                        <i class="fas fa-info-circle mr-1"></i>
                        Exportez vos utilisateurs depuis Mikhmon (Hotspot → Export Users → CSV).<br>
                        <strong>Seules les 2 premières colonnes sont obligatoires</strong> (Username, Password). Les colonnes Profile, Time Limit, Data Limit et Comment sont ignorées — le prix et le forfait sont attribués automatiquement selon votre sélection à l'étape 2.
                    </p>
                </div>

                {{-- Avertissement correspondance forfait --}}
                @php $selFr = $forfaits->firstWhere('id', $forfaitId); @endphp
                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/40">
                    <div class="flex items-start gap-2.5">
                        <div class="shrink-0 w-8 h-8 rounded-lg bg-amber-500/15 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-amber-500 text-xs"></i>
                        </div>
                        <div class="flex-1 space-y-1.5">
                            <p class="text-[11px] font-bold text-amber-700 dark:text-amber-400">
                                Vérifiez la correspondance avant d'importer
                            </p>
                            <p class="text-[11px] text-amber-600 dark:text-amber-400/90 leading-relaxed">
                                Tous les tickets de ce fichier seront importés avec le forfait <strong>{{ $selFr?->label ?? '—' }}</strong> au prix de <strong>{{ $selFr ? number_format($selFr->montant, 0, ',', ' ') . ' ' . $currency : '—' }}</strong>.
                            </p>
                            <p class="text-[11px] text-amber-600 dark:text-amber-400/90 leading-relaxed">
                                Assurez-vous que les tickets Mikhmon que vous importez correspondent bien à ce forfait (même durée, même profil). Si vous avez plusieurs profils dans votre fichier, importez-les séparément en sélectionnant à chaque fois le forfait correspondant.
                            </p>
                            <div class="flex items-center gap-2 pt-1">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-amber-100 dark:bg-amber-800/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold">
                                    <i class="fas fa-ticket text-[9px]"></i> Profil Mikhmon : <strong>{{ $selFr?->label ?? '—' }}</strong>
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-amber-100 dark:bg-amber-800/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold">
                                    <i class="fas fa-clock text-[9px]"></i> Durée : <strong>{{ $selFr?->formattedDuration() ?? '—' }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2 block">Fichier Mikhmon</label>
                    <div class="relative">
                        <input type="file" wire:model="importFile"
                               accept=".csv,.xlsx,.xls"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-sm text-slate-900 dark:text-white file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-neonGreen/10 file:text-neonGreen focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all duration-200">
                    </div>
                    @error('importFile') <p class="text-[10px] text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 mt-1.5">
                        <i class="fas fa-info-circle mr-1"></i>
                        Formats : .CSV, .XLSX, .XLS — max 5 Mo
                    </p>
                </div>

                {{-- Bouton import --}}
                <div class="flex items-center justify-between gap-3">
                    <button type="button" wire:click="previousStep"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-slate-600 dark:text-gray-400 text-xs font-bold transition-all hover:bg-slate-200 dark:hover:bg-darkBorder">
                        <i class="fas fa-arrow-left text-[10px]"></i> Retour
                    </button>
                    <button wire:click="importFile" wire:loading.attr="disabled"
                            {{ !$importFile ? 'disabled' : '' }}
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-neonGreen hover:bg-neonGreen-600 text-white text-xs font-bold transition-all shadow-sm hover:shadow-md disabled:opacity-40 disabled:cursor-not-allowed">
                        <span wire:loading.remove><i class="fas fa-upload text-[10px]"></i> Importer</span>
                        <span wire:loading class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-[10px]"></i> Import en cours...
                        </span>
                    </button>
                </div>

                {{-- Résultat --}}
                @if($importResult)
                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-4 rounded-xl text-xs font-bold border {{ $importSuccess ? 'bg-emerald-50 dark:bg-neonGreen/10 border-emerald-200 dark:border-neonGreen/20 text-emerald-700 dark:text-neonGreen' : 'bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400' }}">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas {{ $importSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' }} text-sm"></i>
                        <span>{{ $importResult }}</span>
                    </div>
                    <button type="button" wire:click="resetImport"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-600 dark:text-gray-400 text-[10px] font-bold transition-all hover:border-neonGreen/50">
                        <i class="fas fa-redo text-[9px]"></i> Nouvel import
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- GUIDE MIKHMON --}}
        @if($currentStep === 1)
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100 dark:border-darkBorder/40 bg-slate-50/50 dark:bg-darkBg/30">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-question-circle text-xs"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white">Comment exporter depuis Mikhmon ?</h3>
            </div>
            <div class="p-4 space-y-2.5">
                @php
                    $guideSteps = [
                        'Ouvrez Mikhmon et connectez-vous à votre routeur MikroTik.',
                        'Allez dans Hotspot → Users.',
                        'Cliquez sur "Export" → choisissez "CSV".',
                        'Le fichier téléchargé contient : Username, Password, Profile, etc.',
                        'Importez ce fichier ici — le prix est automatiquement attribué selon votre forfait.',
                    ];
                @endphp
                @foreach($guideSteps as $i => $step)
                    <div class="flex items-start gap-2.5">
                        <span class="shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold flex items-center justify-center mt-0.5">{{ $i + 1 }}</span>
                        <span class="text-xs text-slate-600 dark:text-gray-400 leading-relaxed">{!! $step !!}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
