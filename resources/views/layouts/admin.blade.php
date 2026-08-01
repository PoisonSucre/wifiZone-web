<!DOCTYPE html>
<html lang="fr" class="scroll-smooth {{ $themeClass }}">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title>@yield('title', 'Admin') — {{ config('platform.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body>
    <div class="vendor-layout">
        @yield('sidebar')
        <main class="vendor-main">
            <div class="vendor-topbar">
                <button class="sidebar-toggle" onclick="toggleVendorSidebar()" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="vendor-topbar-brand"><i class="fas fa-shield-alt"></i> Admin — {{ config('platform.name') }}</div>
            </div>
            <div class="sidebar-overlay" onclick="document.querySelector('.vendor-sidebar').classList.remove('open'); this.classList.remove('active')"></div>
            @hasSection('header')
                <div class="vendor-header-static">
                    @yield('header')
                </div>
            @endif
            <div class="vendor-content" id="vendor-content">
                <x-alert />
                @yield('content')
            </div>
        </main>
    </div>
    @livewireScripts
    @livewire('toast')
    <x-flash-toast />
    @stack('scripts')
</body>
</html>
