@extends('layouts.auth')

@section('title', 'Mot de passe oublié')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            {{ config('platform.name') }}
        </a>
        <p class="text-sm text-slate-500 dark:text-gray-400">Entrez votre email pour recevoir un lien de réinitialisation.</p>
    </div>

    @if(session('status'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl text-green-700 dark:text-green-400 text-sm text-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.forgot-password.post') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Adresse Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="votre@email.com"
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
            </div>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-4 px-6 rounded-2xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm">
            <i class="fas fa-paper-plane"></i> Envoyer le lien
        </button>
    </form>

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center">
        <a href="{{ route('vendor.login') }}" class="text-sm font-bold text-neonGreen hover:text-neonGreen-400 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
        </a>
    </div>
</div>
@endsection
