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
        <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">
            Un email de vérification vous a été envoyé. Cliquez sur le lien dans l'email pour accéder à votre tableau de bord.
        </p>
    </div>

    <div class="space-y-3" x-data="{ loading: false }">
        <form method="POST" action="{{ route('vendor.verify-email.resend') }}" @submit="loading = true">
            @csrf
            <input type="hidden" name="email" value="{{ session('pending_vendor_email', old('email')) }}">
            <button type="submit" :disabled="loading" class="w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3.5 px-6 rounded-2xl shadow-neon-button transition-all flex items-center justify-center gap-3 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="!loading" class="flex items-center gap-3">
                    <i class="fas fa-redo"></i> Renvoyer l'email de vérification
                </span>
                <span x-show="loading" class="flex items-center gap-3">
                    <i class="fas fa-spinner fa-spin"></i> Envoi en cours...
                </span>
            </button>
        </form>
    </div>
</div>
@endsection
