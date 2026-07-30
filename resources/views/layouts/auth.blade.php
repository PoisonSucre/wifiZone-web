<!DOCTYPE html>
<html lang="fr" class="scroll-smooth {{ $themeClass }}">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title>@yield('title', 'Connexion') — {{ config('platform.name') }}</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-darkBg dark:text-gray-100 font-sans antialiased min-h-screen flex flex-col justify-between transition-colors duration-300 relative overflow-x-hidden">

    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-neonGreen/5 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-neonGreen/5 rounded-full filter blur-3xl"></div>
    </div>

    <x-navbar-public />

    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-28 pb-12 relative z-10 w-full">
        @yield('content')
    </main>

    @livewireScripts
    @livewire('toast')
    <x-flash-toast />
    @stack('scripts')
</body>
</html>
