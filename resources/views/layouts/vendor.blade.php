<!DOCTYPE html>
<html lang="fr" class="scroll-smooth {{ $themeClass }}">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title>@yield('title', config('platform.name'))</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="vendor-nav">
    @php $vendeurTopbar = auth()->user(); @endphp
    <div class="vendor-layout">
        @yield('sidebar')
        <main class="vendor-main">
            <div class="vendor-topbar" x-data="{ showTopbarLogout: false }">
                <div class="vendor-topbar-greeting">
                    <i class="fas fa-wifi"></i> Salut {{ $vendeurTopbar->prenom ?? '' }} 👋
                </div>
                <div class="vendor-topbar-actions">
                    <button type="button" class="vendor-topbar-icon" onclick="toggleTheme()" aria-label="Basculer le thème">
                        <i class="fas fa-sun"></i>
                        <i class="fas fa-moon"></i>
                    </button>
                    <button type="button" class="vendor-topbar-icon" @click="showTopbarLogout = true" aria-label="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
                <div x-show="showTopbarLogout" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="showTopbarLogout = false" @keydown.escape.window="showTopbarLogout = false">
                    <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/10 text-amber-500 mx-auto mb-4">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Confirmer la déconnexion</h3>
                        <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">Voulez-vous vraiment vous déconnecter ?</p>
                        <div class="flex gap-2">
                            <button type="button" @click="showTopbarLogout = false" class="flex-1 whitespace-nowrap bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-2 px-3 rounded-xl transition-all text-xs">Annuler</button>
                            <form method="POST" action="{{ route('vendor.logout') }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full whitespace-nowrap bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-2 px-3 rounded-xl shadow-neon-button transition-all text-xs flex items-center justify-center gap-1.5">
                                    <i class="fas fa-sign-out-alt text-[10px] shrink-0"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
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
    <x-bottom-nav />
    @livewireScripts
    @livewire('toast')
    <x-flash-toast />
    @stack('scripts')
</body>
</html>
