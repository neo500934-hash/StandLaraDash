<!-- Sidebar -->
<aside class="sidebar">
    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <button class="sidebar-close" aria-label="{{ __('Close sidebar') }}">
            <i class="bi bi-x-lg"></i>
        </button>

        <ul class="nav-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('blank') ? 'active' : '' }}" href="{{ route('blank') }}">
                    <span class="nav-icon"><i class="ph ph-squares-four"></i></span>
                    <span class="nav-text">{{ __('Blank') }}</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="nav-icon"><i class="ph ph-squares-four"></i></span>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                    <span class="nav-badge nav-badge-soft">{{ __('Main') }}</span>
                </a>
            </li> --}}


        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-user">
            <a href="#" class="sidebar-footer-profile">
                <span class="user-avatar user-initials">{{ auth()->user()->initials() }}</span>

                <div class="sidebar-footer-info">
                    <div class="sidebar-footer-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-footer-role">{{ auth()->user()->rankName() }}</div>
                </div>
            </a>
            <div class="sidebar-footer-actions">
                <a href="#" class="sidebar-footer-action" title="{{ __('Settings') }}">
                    <i class="bi bi-gear"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: contents">
                    @csrf
                    <button type="submit" class="sidebar-footer-action sidebar-footer-logout"
                        title="{{ __('Logout') }}">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
