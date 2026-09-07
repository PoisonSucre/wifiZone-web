@extends('layouts.auth')

@section('title', 'Compte en attente')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center">
        {{-- Icon --}}
        <div class="mx-auto w-16 h-16 rounded-full bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 flex items-center justify-center mb-5">
            <i class="fas fa-hourglass-half text-2xl text-amber-500 animate-pulse"></i>
        </div>

        {{-- Title --}}
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">
            Inscription en attente
        </h2>
        <p class="text-sm text-slate-500 dark:text-gray-400 mb-5">
            Votre compte a bien été créé. Il est en cours de validation par notre équipe.
        </p>

        {{-- Email non vérifié : alerte + bouton --}}
        @php
            $pendingEmail = session('pending_vendor_email');
            $vendeur = $pendingEmail ? \App\Models\Vendeur::where('email', $pendingEmail)->first() : null;
            $emailNotVerified = $vendeur && !$vendeur->email_verified_at;
        @endphp

        @if($emailNotVerified)
            <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/50 rounded-2xl p-4 mb-5 text-left">
                <div class="flex items-start gap-3 mb-3">
                    <i class="fas fa-envelope-open-text text-amber-500 mt-0.5 shrink-0"></i>
                    <div>
                        <p class="text-sm font-bold text-amber-700 dark:text-amber-400">Email non vérifié</p>
                        <p class="text-xs text-amber-600/70 dark:text-amber-500/70 mt-1">
                            Vérifiez votre boîte de réception (et vos spams) pour l'email de confirmation envoyé à <strong>{{ $pendingEmail }}</strong>.
                        </p>
                    </div>
                </div>
                <a href="{{ route('vendor.verify-email') }}" class="block w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-bold py-2.5 px-5 rounded-xl text-sm text-center transition-all">
                    <i class="fas fa-redo mr-1"></i> Renvoyer l'email de vérification
                </a>
            </div>
        @endif

        {{-- Steps --}}
        <div class="text-left bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder rounded-2xl p-4 mb-5 space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full {{ $emailNotVerified ? 'bg-neonGreen' : 'bg-neonGreen' }} text-white flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Compte créé</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Votre inscription a été enregistrée</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full {{ $emailNotVerified ? 'bg-slate-200 dark:bg-darkBorder text-slate-400' : 'bg-amber-500 text-white animate-pulse' }} flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas {{ $emailNotVerified ? 'fa-envelope' : 'fa-clock' }} text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold {{ $emailNotVerified ? 'text-slate-400 dark:text-gray-500' : 'text-amber-600 dark:text-amber-400' }}">{{ $emailNotVerified ? 'Vérification email' : 'Validation en cours' }}</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">{{ $emailNotVerified ? 'Cliquez sur le lien dans l\'email reçu' : 'L\'administrateur vérifie vos informations' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-darkBorder text-slate-400 dark:text-gray-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-lock text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 dark:text-gray-500">Activation</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Vous recevrez un email de confirmation</p>
                </div>
            </div>
        </div>

        {{-- Livewire Status Checker --}}
        <div class="text-left mb-5">
            @livewire('auth.pending-status')
        </div>

        {{-- Contact --}}
        <p class="text-xs text-slate-400 dark:text-gray-500 mb-4">
            Une question ? Contactez-nous sur WhatsApp au
            <a href="https://wa.me/22562261391" target="_blank" rel="noopener" class="text-neonGreen font-semibold hover:underline">62 261391</a>
            /
            <a href="https://wa.me/22573525432" target="_blank" rel="noopener" class="text-neonGreen font-semibold hover:underline">73-52-54-32</a>
        </p>

        {{-- Back --}}
        <a href="{{ route('vendor.login') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-neonGreen dark:hover:text-neonGreen transition-colors">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>
</div>
@endsection
