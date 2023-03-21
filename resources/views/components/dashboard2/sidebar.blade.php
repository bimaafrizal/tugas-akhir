<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('auth/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('auth/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
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

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('dashboard')" href="/dashboard">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('kategory-article')" href="{{ route('kategory-article') }}">
                        <i class=" ri-file-mark-line"></i> <span data-key="t-widgets">Kategori Article</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  @yield('article')" href="{{ route('article.index') }}">
                        <i class=" ri-newspaper-line"></i> <span data-key="t-widgets">Article</span>
                    </a>
                </li>
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

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>