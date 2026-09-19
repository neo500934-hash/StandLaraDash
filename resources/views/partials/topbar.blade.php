<!-- Header -->
<header class="header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="LiteAdmin">
            <span>LiteAdmin</span>
        </a>
    </div>

    <button class="sidebar-toggle" title="Toggle Sidebar" aria-label="Toggle Sidebar">
        <i class="bi bi-list"></i>
    </button>



    <div class="header-right">
        <div class="header-actions-desktop">


            {{-- <div class="header-action-wrap dropdown">
                <button class="header-action dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                    title="Messages">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="header-badge">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end inbox-menu">
                    <div class="dropdown-head">
                        <h6>Messages</h6>
                        <a href="#">Open Chat</a>
                    </div>
                    <div class="menu-list">
                        <a href="#" class="menu-item unread">
                            <img src="{{ asset('assets/img/avatars/avatar-2.webp') }}" alt=""
                                class="menu-avatar">
                            <div class="menu-content">
                                <div class="menu-title">Mia Rodriguez</div>
                                <div class="menu-text">Can you review the analytics wireframe today?</div>
                                <span class="menu-time">2m ago</span>
                            </div>
                        </a>
                        <a href="#" class="menu-item unread">
                            <img src="{{ asset('assets/img/avatars/avatar-3.webp') }}" alt=""
                                class="menu-avatar">
                            <div class="menu-content">
                                <div class="menu-title">Dev Channel</div>
                                <div class="menu-text">Build passed. Ready for production deploy.</div>
                                <span class="menu-time">12m ago</span>
                            </div>
                        </a>
                        <a href="#" class="menu-item">
                            <img src="{{ asset('assets/img/avatars/avatar-4.webp') }}" alt=""
                                class="menu-avatar">
                            <div class="menu-content">
                                <div class="menu-title">Sarah Kim</div>
                                <div class="menu-text">Shared a file: Q1-forecast-report.pdf</div>
                                <span class="menu-time">35m ago</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="header-action-wrap dropdown">
                <button class="header-action dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                    title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="header-badge">4</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end alert-menu">
                    <div class="dropdown-head">
                        <h6>Notifications</h6>
                        <a href="#" data-notification-action="mark-all-read">Mark all read</a>
                    </div>
                    <div class="menu-list">
                        <a href="#" class="menu-item unread">
                            <span class="menu-icon info"><i class="bi bi-rocket-takeoff"></i></span>
                            <div class="menu-content">
                                <div class="menu-title">Deploy Ready</div>
                                <div class="menu-text">Sprint 24 release has passed QA checks.</div>
                                <span class="menu-time">5m ago</span>
                            </div>
                        </a>
                        <a href="#" class="menu-item unread">
                            <span class="menu-icon warning"><i class="bi bi-exclamation-triangle"></i></span>
                            <div class="menu-content">
                                <div class="menu-title">Storage threshold</div>
                                <div class="menu-text">Media bucket reached 81% utilization.</div>
                                <span class="menu-time">58m ago</span>
                            </div>
                        </a>
                        <a href="#" class="menu-item">
                            <span class="menu-icon success"><i class="bi bi-check2-circle"></i></span>
                            <div class="menu-content">
                                <div class="menu-title">Payment received</div>
                                <div class="menu-text">Invoice #INV-3921 was settled successfully.</div>
                                <span class="menu-time">2h ago</span>
                            </div>
                        </a>
                    </div>
                    <div class="menu-foot">
                        <a href="#">View all notifications <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div> --}}

            <button class="header-action theme-toggle" title="Toggle Theme" aria-label="Toggle Theme">
                <i class="ph ph-moon-stars theme-icon-dark"></i>
                <i class="ph ph-sun theme-icon-light"></i>
            </button>

            <div class="header-action-wrap dropdown user-dropdown">
                <button class="dropdown-toggle user-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/img/profile-img.webp') }}" alt="User" class="user-avatar">
                    <div class="user-brief">
                        <span class="user-name">John Doe</span>
                        <span class="user-role">Product Admin</span>
                    </div>
                    <i class="bi bi-chevron-down user-chevron"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end user-menu">
                    <div class="user-menu-head">
                        <img src="{{ asset('assets/img/profile-img.webp') }}" alt="User" class="user-menu-avatar">
                        <div>
                            <div class="user-menu-name">John Doe</div>
                            <div class="user-menu-email">john.doe@example.com</div>
                        </div>
                    </div>
                    <div class="user-menu-body">
                        <a class="user-menu-item" href="#"><i class="bi bi-person"></i><span>My
                                Profile</span></a>
                        <a class="user-menu-item" href="#"><i
                                class="bi bi-sliders"></i><span>Preferences</span></a>
                        <a class="user-menu-item" href="#"><i class="bi bi-activity"></i><span>Activity
                                Log</span></a>
                        <a class="user-menu-item" href="#"><i
                                class="bi bi-credit-card"></i><span>Billing</span></a>
                    </div>
                    <div class="user-menu-foot">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="user-menu-logout"><i class="bi bi-box-arrow-right"></i><span>Sign
                                    Out</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-actions-mobile">


            <button class="header-action mobile-menu-toggle" title="More" aria-label="More">
                <i class="bi bi-three-dots"></i>
            </button>
        </div>
    </div>
</header>


{{-- <div class="mobile-header-menu">
    <div class="mobile-header-menu-content">
        <button class="mobile-menu-item theme-toggle" title="Toggle Theme">
            <i class="ph ph-moon-stars theme-icon-dark"></i>
            <i class="ph ph-sun theme-icon-light"></i>
            <span class="mobile-menu-label">Theme</span>
        </button>

        <a href="#" class="mobile-menu-item">
            <i class="bi bi-bell"></i>
            <span class="badge">4</span>
            <span class="mobile-menu-label">Alerts</span>
        </a>

        <a href="#" class="mobile-menu-item">
            <i class="bi bi-chat-left-text"></i>
            <span class="mobile-menu-label">Messages</span>
        </a>

        <a href="#" class="mobile-menu-item">
            <i class="bi bi-calendar3"></i>
            <span class="mobile-menu-label">Calendar</span>
        </a>

        <a href="#" class="mobile-menu-item">
            <i class="bi bi-person"></i>
            <span class="mobile-menu-label">Profile</span>
        </a>

        <a href="#" class="mobile-menu-item">
            <i class="bi bi-sliders"></i>
            <span class="mobile-menu-label">Settings</span>
        </a>

        <a href="#" class="mobile-menu-item mobile-menu-item-danger">
            <i class="bi bi-box-arrow-right"></i>
            <span class="mobile-menu-label">Sign Out</span>
        </a>
    </div>
</div> --}}
