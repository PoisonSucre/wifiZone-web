<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>404 — Page introuvable | {{ config('platform.name') }}</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 dark:bg-[#0A0A0C] dark:text-gray-100 font-sans antialiased flex items-center justify-center px-4 py-16 transition-colors duration-300 selection:bg-neonGreen selection:text-black">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-8 sm:p-10 shadow-sm text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-neonGreen/10 flex items-center justify-center">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 20.5C12.8284 20.5 13.5 19.8284 13.5 19C13.5 18.1716 12.8284 17.5 12 17.5C11.1716 17.5 10.5 18.1716 10.5 19C10.5 19.8284 11.1716 20.5 12 20.5Z" fill="#10B981"/>
                    <path d="M8.5 15.5C10.5 13.7 13.5 13.7 15.5 15.5" stroke="#10B981" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M5.5 11.8C9.2 8.4 14.8 8.4 18.5 11.8" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" opacity="0.85"/>
                    <path d="M2.5 8.2C7.9 3.4 16.1 3.4 21.5 8.2" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" opacity="0.6"/>
                </svg>
            </div>

            <p class="text-7xl sm:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-neonGreen to-neonGreen-400 tracking-tight leading-none mb-3">404</p>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white mb-3">
                Oups ! Cette page est introuvable
            </h1>
            <p class="text-sm text-slate-600 dark:text-gray-400 mb-8 leading-relaxed">
                La page que vous cherchez n'existe pas, a été déplacée ou supprimée.
                Vérifiez l'adresse saisie ou retournez à l'accueil.
            </p>

            <div class="space-y-3">
                <a href="{{ route('home') }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-neonGreen text-white font-bold px-4 py-3 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-home"></i>
                    Retour à l'accueil
                </a>
                @if(config('platform.support_email'))
                <a href="mailto:{{ config('platform.support_email') }}"
                   class="w-full inline-flex items-center justify-center gap-2 text-sm font-bold text-slate-600 dark:text-gray-400 hover:text-neonGreen dark:hover:text-neonGreen transition-colors">
                    <i class="fas fa-headset"></i>
                    Contacter le support
                </a>
                @endif
            </div>
        </div>

        <p class="text-center mt-6 text-xs text-slate-400 dark:text-gray-500">
            {{ config('platform.name') }} — Designed by Raider Corporation
        </p>
    </div>
</body>
</html>
