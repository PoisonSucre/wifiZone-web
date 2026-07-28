@if(!$vendeur)
    <div class="text-center py-12">
        <i class="fas fa-store text-4xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Boutique introuvable.</p>
    </div>
@else
    <div class="max-w-lg mx-auto">
        {{-- Header --}}
        <div class="text-center p-8 rounded-2xl mb-6" style="background-color: {{ $vendeur->couleur ?? '#1ca04e' }}">
            @if($vendeur->logo)
                <img src="{{ asset($vendeur->logo) }}" alt="Logo" class="w-20 h-20 rounded-full mx-auto mb-4 object-cover border-2 border-white/30">
            @else
                <div class="w-20 h-20 rounded-full mx-auto mb-4 bg-white/20 flex items-center justify-center">
                    <i class="fas fa-wifi text-white text-3xl"></i>
                </div>
            @endif
            <h1 class="text-white font-bold text-xl">{{ $vendeur->prenom }} {{ $vendeur->nom }}</h1>
            <p class="text-white/80 text-sm mt-1">{{ $vendeur->message_bienvenue ?? 'Bienvenue sur notre hotspot WiFi !' }}</p>
        </div>

        {{-- Forfaits --}}
        <div class="space-y-3">
            @forelse($forfaits as $forfait)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center justify-between {{ $selectedForfait === $forfait['id'] ? 'ring-2 ring-[#1ca04e]' : '' }}">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $forfait['label'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $forfait['duree_minutes'] }} minutes</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-lg" style="color: {{ $vendeur->couleur ?? '#1ca04e' }}">{{ number_format($forfait['montant'], 0) }} {{ config('platform.currency') }}</span>
                        <button wire:click="selectForfait({{ $forfait['id'] }}" class="px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors" style="background-color: {{ $vendeur->couleur ?? '#1ca04e' }}">
                            Choisir
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 bg-white dark:bg-gray-800 rounded-xl shadow">
                    <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Aucun forfait disponible.</p>
                </div>
            @endforelse
        </div>

        @if($selectedForfait)
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Forfait sélectionné : <strong>{{ collect($forfaits)->firstWhere('id', $selectedForfait)['label'] ?? '' }}</strong></p>
                <a href="#" class="inline-block px-8 py-3 text-white font-semibold rounded-xl shadow transition-colors" style="background-color: {{ $vendeur->couleur ?? '#1ca04e' }}">
                    <i class="fas fa-credit-card mr-2"></i>Payer maintenant
                </a>
            </div>
        @endif
    </div>
@endif
