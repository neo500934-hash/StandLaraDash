<!-- Sidebar -->
<aside class="sidebar">
    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <button class="sidebar-close" aria-label="Close sidebar">
            <i class="bi bi-x-lg"></i>
        </button>

        <ul class="nav-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="nav-icon"><i class="ph ph-squares-four"></i></span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-badge nav-badge-soft">Main</span>
                </a>
            </li>


        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-user">
            <a href="#" class="sidebar-footer-profile">
                <img src="{{ asset('assets/img/profile-img.webp') }}" alt="User" class="sidebar-footer-avatar">
                <div class="sidebar-footer-info">
                    <div class="sidebar-footer-name">John Doe</div>
                    <div class="sidebar-footer-role">Product Admin</div>
                </div>
            </a>
            <div class="sidebar-footer-actions">
                <a href="#" class="sidebar-footer-action" title="Settings">
                    <i class="bi bi-gear"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: contents">
                    @csrf
                    <button type="submit" class="sidebar-footer-action sidebar-footer-logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
