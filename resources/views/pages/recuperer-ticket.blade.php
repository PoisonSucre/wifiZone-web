@extends('layouts.public')

@section('title', 'Récupérer un Ticket - ' . config('platform.name'))

@section('navbar')
    <x-navbar-public />
@endsection

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-[#0A0A0C] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="text-center mb-8">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white mb-2">
                    <i class="fas fa-ticket-alt text-neonGreen mr-2"></i> Récupérer un Ticket
                </h2>
                <p class="text-sm text-slate-600 dark:text-gray-400">
                    Entrez le numéro qui a servi au paiement pour retrouver vos identifiants WiFi
                </p>
            </div>

            <form method="POST" action="{{ route('recuperer-ticket') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                        Numéro de téléphone
                    </label>
                    <div class="relative">
                        <input type="tel" name="phone" id="phone" required
                               placeholder="Ex: 66 63 59 58 ou +22666635958"
                               value="{{ $phone ?? '' }}"
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-darkBg border border-slate-200 dark:border-darkBorder text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all">
                        <i class="fas fa-phone absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-gray-500"></i>
                    </div>
                </div>
                <button type="submit" id="recupererBtn"
                        class="w-full inline-flex items-center justify-center gap-2 bg-neonGreen text-white dark:text-white font-bold px-4 py-3 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-search"></i>
                    <span id="btnText">Récupérer mon ticket</span>
                    <i id="btnSpinner" class="fas fa-spinner fa-spin" style="display:none"></i>
                </button>
            </form>
            <p class="text-center mt-4 text-xs text-slate-500 dark:text-gray-500">
                Numéro utilisé lors du paiement (Orange Money, Wave, Moov)
            </p>

            @if(($message ?? '') === 'success' && ($ticket ?? null))
            <div class="mt-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-6 animate-fade-in">
                <p class="text-center text-emerald-700 dark:text-emerald-400 font-bold mb-4 flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> Ticket trouvé !
                </p>
                <div class="bg-white dark:bg-darkCard/50 rounded-xl p-5 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-darkBorder/50">
                        <span class="text-slate-500 dark:text-gray-400 text-sm">Utilisateur</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">{{ $ticket->user }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-darkBorder/50">
                        <span class="text-slate-500 dark:text-gray-400 text-sm">Mot de passe</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm pw-text" data-ticket-id="{{ $ticket->id }}" id="tkPass">••••••</span>
                            <button type="button" class="pw-toggle text-neonGreen hover:text-neonGreen-600" onclick="togglePw(this)" aria-label="Afficher le mot de passe">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-darkBorder/50">
                        <span class="text-slate-500 dark:text-gray-400 text-sm">Forfait</span>
                        <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $ticket->forfait }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-slate-500 dark:text-gray-400 text-sm">Vendeur</span>
                        <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $ticket->prenom ?? '' }} {{ $ticket->nom ?? '' }}</span>
                    </div>
                </div>
            </div>
            @elseif(($message ?? '') === 'not_found')
            <div class="mt-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-5 text-center animate-fade-in">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mb-2"></i>
                <p class="text-red-700 dark:text-red-400 font-semibold">Aucun ticket trouvé pour ce numéro.</p>
            </div>
            @elseif(($message ?? '') === 'missing_input')
            <div class="mt-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5 text-center animate-fade-in">
                <i class="fas fa-exclamation-triangle text-amber-500 text-xl mb-2"></i>
                <p class="text-amber-700 dark:text-amber-400 font-semibold">Veuillez entrer un numéro de téléphone.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePw(btn) {
    const span = btn.closest('.flex').querySelector('.pw-text');
    const icon = btn.querySelector('i');
    if (span.textContent === '••••••') {
        const ticketId = span.dataset.ticketId;
        span.textContent = '...';
        fetch('/recuperer-ticket/password/' + ticketId)
            .then(function(r) { if (!r.ok) throw new Error(); return r.json(); })
            .then(function(d) {
                span.textContent = d.password;
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            })
            .catch(function() {
                span.textContent = '••••••';
            });
    } else {
        span.textContent = '••••••';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route("recuperer-ticket") }}"]');
    if (form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('recupererBtn');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');
            if (btn && text && spinner) {
                btn.disabled = true;
                text.textContent = 'Recherche...';
                spinner.style.display = 'inline-block';
            }
        });
    }
});
</script>
@endpush