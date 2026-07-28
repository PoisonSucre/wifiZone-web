<aside class="vendor-sidebar" id="sidebar">
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
            <form method="POST" action="{{ route($logoutRoute) }}" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-action-btn sidebar-logout-btn">
                    <div class="action-icon-wrapper logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="action-label">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</aside>
