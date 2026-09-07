<!DOCTYPE html>
<html lang="fr" class="scroll-smooth {{ $themeClass }}">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title>@yield('title', config('platform.name'))</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-darkBg dark:text-gray-100 font-sans antialiased transition-colors duration-300 selection:bg-neonGreen selection:text-black">
    @yield('navbar')
    <main class="flex-1">
        <x-alert />
        @yield('content')
    </main>
    <x-footer />
    @livewireScripts
    @livewire('toast')
    <x-flash-toast />
    @stack('scripts')
</body>
</html>
