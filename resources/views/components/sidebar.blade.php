<aside class="vendor-sidebar" id="sidebar" x-data="{ showLogoutModal: false }">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <div class="sidebar-logo-wrapper">
                <div class="sidebar-logo-glow"></div>
                <i class="fas {{ $logoIcon }} sidebar-logo"></i>
            </div>
            <span class="sidebar-brand">{{ $brandText }}</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">{{ $navLabel }}</div>
            @foreach($links as $link)
                @php $isActive = $activeRoute === $link['route']; @endphp
                <a href="{{ $link['url'] }}" wire:navigate class="sidebar-link {{ $isActive ? 'active' : '' }}">
                    <div class="link-indicator"></div>
                    <div class="link-icon-wrapper">
                        <i class="fas {{ $link['icon'] }}"></i>
                    </div>
                    <span class="link-label">{{ $link['label'] }}</span>
                    @if(!empty($link['badge']))
                        <span class="link-badge">{{ $link['badge'] }}</span>
                    @endif
                    <svg class="link-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </a>
            @endforeach
        </nav>

        <div class="sidebar-footer">
            <button type="button" class="sidebar-action-btn" onclick="toggleTheme()" title="Basculer le thème">
                <div class="action-icon-wrapper">
                    <i class="fas fa-sun hidden dark:inline" id="theme-sun"></i>
                    <i class="fas fa-moon inline dark:hidden" id="theme-moon"></i>
                </div>
                <span class="action-label">Thème</span>
                <div class="action-toggle">
                    <div class="toggle-knob"></div>
                </div>
            </button>
            <form method="POST" action="{{ route($logoutRoute) }}" class="sidebar-logout-form" id="logout-form" x-ref="logoutForm">
                @csrf
                <button type="button" class="sidebar-action-btn sidebar-logout-btn" @click="showLogoutModal = true">
                    <div class="action-icon-wrapper logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="action-label">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Logout Confirmation Modal (Alpine.js inline) -->
    <div x-show="showLogoutModal" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.outside="showLogoutModal = false" @keydown.escape.window="showLogoutModal = false">
        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/10 text-amber-500 mx-auto mb-4">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white text-center mb-1">Confirmer la déconnexion</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 text-center mb-5">Voulez-vous vraiment vous déconnecter ?</p>
            <div class="flex gap-3">
                <button type="button" @click="showLogoutModal = false" class="flex-1 bg-slate-100 dark:bg-darkBorder/50 hover:bg-slate-200 dark:hover:bg-darkBorder text-slate-600 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white font-bold py-3 px-4 rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                    Annuler
                </button>
                <button type="button" @click="showLogoutModal = false; $refs.logoutForm.submit()" class="flex-1 bg-neonGreen hover:bg-neonGreen-400 text-white font-extrabold py-3 px-4 rounded-xl shadow-neon-button transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </button>
            </div>
        </div>
    </div>
</aside>