@extends('layouts.auth')

@section('title', 'Vérifiez votre email')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center">
        {{-- Icon --}}
        <div class="mx-auto w-16 h-16 rounded-full bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800/50 flex items-center justify-center mb-5">
            <i class="fas fa-envelope-open-text text-2xl text-purple-500 dark:text-purple-400"></i>
        </div>

        {{-- Title --}}
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">
            Vérifiez votre adresse email
        </h2>
        @php
            $pendingEmail = session('pending_vendor_email');
        @endphp
        <p class="text-sm text-slate-500 dark:text-gray-400 mb-5">
            Un email de vérification a été envoyé à
            <strong class="text-slate-700 dark:text-gray-200">{{ $pendingEmail }}</strong>.
            Cliquez sur le lien dans l'email pour activer votre compte.
        </p>

        {{-- Steps --}}
        <div class="text-left bg-slate-50 dark:bg-darkBg/60 border border-slate-100 dark:border-darkBorder rounded-2xl p-4 mb-5 space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-neonGreen text-white flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">Compte créé</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Votre inscription a été enregistrée</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 animate-pulse">
                    <i class="fas fa-envelope text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-amber-600 dark:text-amber-400">Vérification email</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Cliquez sur le lien dans l'email reçu</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-darkBorder text-slate-400 dark:text-gray-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-rocket text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 dark:text-gray-500">Compte activé</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Accès immédiat au tableau de bord</p>
                </div>
            </div>
        </div>

        {{-- Bouton renvoyer email --}}
        <a href="{{ route('vendor.verify-email') }}" class="block w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-bold py-3 px-6 rounded-2xl shadow-neon-button transition-all text-sm mb-5">
            <i class="fas fa-redo mr-2"></i> Renvoyer l'email de vérification
        </a>

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
