@extends('layouts.auth')

@section('title', 'Vérifiez votre email')
@section('content')
<div class="max-w-md w-full bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 sm:p-10 shadow-xl transition-all duration-300">
    <div class="text-center">
        {{-- Icon --}}
        <div class="mx-auto w-16 h-16 rounded-full bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800/50 flex items-center justify-center mb-5">
            <i class="fas fa-envelope-open-text text-2xl text-purple-500 dark:text-purple-400"></i>
        </div>

        @php $pendingEmail = session('pending_vendor_email'); @endphp

        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">Vérifiez votre email</h2>
        <p class="text-sm text-slate-500 dark:text-gray-400 mb-6">
            Un email a été envoyé à <strong class="text-slate-700 dark:text-gray-200">{{ $pendingEmail }}</strong>. Cliquez sur le lien pour activer votre compte.
        </p>

        {{-- Bouton renvoyer --}}
        <a href="{{ route('vendor.verify-email') }}" class="block w-full bg-neonGreen hover:bg-neonGreen-400 text-white font-bold py-3 px-6 rounded-2xl shadow-neon-button transition-all text-sm mb-6">
            <i class="fas fa-redo mr-2"></i> Renvoyer l'email
        </a>

        {{-- Auto-check discret --}}
        <div class="text-left mb-6">
            @livewire('auth.pending-status')
        </div>

        {{-- Contact --}}
        <p class="text-xs text-slate-400 dark:text-gray-500 mb-4">
            Besoin d'aide ? WhatsApp
            <a href="https://wa.me/22662261391" target="_blank" rel="noopener" class="text-neonGreen font-semibold hover:underline">62 261391</a>
            /
            <a href="https://wa.me/22673525432" target="_blank" rel="noopener" class="text-neonGreen font-semibold hover:underline">73-52-54-32</a>
        </p>

        <a href="{{ route('vendor.login') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-neonGreen dark:hover:text-neonGreen transition-colors">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>
</div>
@endsection
