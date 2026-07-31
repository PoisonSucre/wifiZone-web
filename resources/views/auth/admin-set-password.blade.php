@extends('layouts.auth')

@section('title', 'Nouveau mot de passe — Admin')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-3 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow mb-2">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            {{ config('platform.name') }}
        </a>
        <p class="text-sm text-slate-500 dark:text-gray-400">Espace administrateur — choisissez un nouveau mot de passe.</p>
    </div>

    <form method="POST" action="{{ route('admin.set-password.post') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" value="{{ $email }}" disabled
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-100 dark:bg-darkBg/40 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-500 dark:text-gray-500 text-sm cursor-not-allowed">
            </div>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ showPassword: false }">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Nouveau mot de passe</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-lock"></i>
                </span>
                <input :type="showPassword ? 'text' : 'password'" name="password" required
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-neonGreen transition-colors">
                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400 mb-2">Confirmer le mot de passe</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" required
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-neonGreen focus:ring-2 focus:ring-neonGreen/10 transition-all text-sm">
            </div>
            @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-4 px-6 rounded-2xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm">
            <i class="fas fa-key"></i> Définir mon mot de passe
        </button>
    </form>

    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-darkBorder/40 text-center">
        <a href="{{ route('admin.login') }}" class="text-sm font-bold text-neonGreen hover:text-neonGreen-400 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
        </a>
    </div>
</div>
@endsection
