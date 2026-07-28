@extends('layouts.auth')

@section('title', 'Connexion')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300 hover:border-neonGreen/30 hover:shadow-neon-glow">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            {{ config('platform.name') }}
        </a>
        <p class="text-sm text-slate-500 dark:text-gray-400">Ravi de vous revoir ! Connectez-vous à votre espace.</p>
    </div>

    @livewire('auth.login-form')

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center space-y-2">
        <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400">
            Pas encore de compte ?
            <a href="{{ route('vendor.register') }}" class="font-bold text-neonGreen hover:text-neonGreen-400 transition-colors">S'inscrire gratuitement</a>
        </p>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400">
            <a href="{{ route('vendor.forgot-password') }}" class="font-bold text-slate-400 hover:text-neonGreen transition-colors">Mot de passe oublié ?</a>
        </p>
        <p>
            <a href="/" class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </p>
    </div>
</div>
@endsection
