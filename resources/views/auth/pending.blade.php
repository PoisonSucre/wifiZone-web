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
                    <i class="fas fa-clock text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-amber-600 dark:text-amber-400">Validation en cours</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">L'administrateur vérifie vos informations</p>
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
            Une question ? Contactez-nous au <strong class="text-slate-600 dark:text-gray-300">66 63 59 58 / 64 65 86 44</strong>
        </p>

        {{-- Back --}}
        <a href="{{ route('vendor.login') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-neonGreen dark:hover:text-neonGreen transition-colors">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>
</div>
@endsection
