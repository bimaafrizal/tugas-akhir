<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">

    <!-- LOGO -->
    @if ($logo == null)    
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('auth/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('auth/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/dashboard" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('auth/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('auth/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    @else
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset($logo) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset($logo) }}" alt="" height="30">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/dashboard" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset($logo) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset($logo) }}" alt="" height="30">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
        
    @endif

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('dashboard')" href="/dashboard">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                    </a>
                </li>
                @can('superadmin')
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('kategory-article')" href="{{ route('kategory-article') }}">
                        <i class=" ri-file-mark-line"></i> <span data-key="t-widgets">Kategori Article</span>
                    </a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('disaster')" href="{{ route('disaster.index') }}">
                        <i class="ri-meteor-line"></i> <span data-key="t-widgets">Setting Notifikasi Bencana</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('landing-page')" href="{{ route('landing-page.index') }}">
                        <i class=" ri-pages-line"></i> <span data-key="t-widgets">Setting Landing Page</span>
                    </a>
                </li>
                @endcan
                @can('notUser')
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('manajemen-user')" href="{{ route('manajemen-user.index') }}">
                        <i class="ri-team-line"></i> <span data-key="t-widgets">Manajemen User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('article')" href="{{ route('article.index') }}">
                        <i class=" ri-newspaper-line"></i> <span data-key="t-widgets">Article</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('template')" href="{{ route('template.index') }}">
                        <i class="ri-function-fill"></i> <span data-key="t-widgets">Template Notifikasi</span>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('ews')" href="{{ route('ews.index') }}">
                        <i class=" ri-flood-line"></i> <span data-key="t-widgets">EWS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('earthquake')" href="{{ route('earthquake.index') }}">
                        <i class="ri-earthquake-line"></i> <span data-key="t-widgets">Gempa</span>
                    </a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('notification')" href="{{ route('notif.index') }}">
                        <i class="ri-chat-history-line"></i> <span data-key="t-widgets">Notifikasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('profile')" href="{{ route('profile.index') }}">
                        <i class="ri-user-line"></i> <span data-key="t-widgets">Profile</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
