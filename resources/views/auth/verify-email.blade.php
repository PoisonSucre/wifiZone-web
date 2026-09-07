@extends('layouts.auth')

@section('title', 'Vérifiez votre email')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            {{ config('platform.name') }}
        </a>
    </div>

    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-envelope-open-text text-2xl text-purple-500 dark:text-purple-400"></i>
        </div>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Vérifiez votre adresse email</h2>
        <p id="verifyMsg" class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">
            Un email de vérification a été envoyé à
            <strong class="text-slate-700 dark:text-gray-200">{{ session('pending_vendor_email', old('email')) }}</strong>.
            Cliquez sur le lien dans l'email pour activer votre compte.
        </p>
    </div>

    @if(session('status'))
        <div class="mb-4 text-sm text-center rounded-2xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 font-semibold text-emerald-700 dark:text-emerald-400">
            {{ session('status') }}
        </div>
    @endif

    <div id="resendAlert" class="hidden mb-4 text-sm text-center rounded-2xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 font-semibold text-emerald-700 dark:text-emerald-400"></div>

    <div class="space-y-3">
        <form id="resendForm" method="POST" action="{{ route('vendor.verify-email.resend') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('pending_vendor_email', old('email')) }}">
            <button type="submit" id="resendBtn" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3.5 px-6 rounded-2xl shadow-neon-button transition-all flex items-center justify-center gap-3 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="resendLabel" class="flex items-center gap-3">
                    <i class="fas fa-redo"></i> Renvoyer l'email de vérification
                </span>
                <span id="resendSpinner" class="hidden items-center gap-3">
                    <i class="fas fa-spinner fa-spin"></i> Envoi en cours...
                </span>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (form.id !== 'resendForm') return;
    e.preventDefault();

    const btn = document.getElementById('resendBtn');
    const label = document.getElementById('resendLabel');
    const spinner = document.getElementById('resendSpinner');
    const msg = document.getElementById('verifyMsg');
    const alertBox = document.getElementById('resendAlert');
    const csrf = document.querySelector('meta[name="csrf-token"]');

    const resetButton = function () {
        btn.disabled = false;
        spinner.classList.add('hidden');
        spinner.classList.remove('inline-flex');
        label.classList.remove('hidden');
        label.innerHTML = '<i class="fas fa-redo"></i> Renvoyer l\'email de vérification';
    };

    btn.disabled = true;
    label.classList.add('hidden');
    spinner.classList.remove('hidden');
    spinner.classList.add('inline-flex');

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf ? csrf.content : ''
        }
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            msg.textContent = 'Un email de vérification vous a été envoyé. Cliquez sur le lien dans l\'email pour accéder à votre tableau de bord.';
            alertBox.textContent = data.message || 'Un nouvel email de vérification a été envoyé.';
            alertBox.classList.remove('hidden');
            label.innerHTML = '<i class="fas fa-check-circle"></i> Email envoyé ✓';
            label.classList.remove('hidden');
            spinner.classList.add('hidden');
            spinner.classList.remove('inline-flex');
            btn.disabled = true;
            setTimeout(resetButton, 5000);
        } else {
            msg.textContent = data.message || 'Une erreur est survenue. Veuillez réessayer.';
            resetButton();
        }
    })
    .catch(function () {
        msg.textContent = 'Une erreur est survenue. Veuillez réessayer.';
        resetButton();
    });
});
</script>
@endpush
