<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" href="{{ $logo }}">

    <!-- Layout config Js -->
    <script src="{{ asset('auth/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('auth/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('auth/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('auth/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('auth/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    
    @stack('css')

</head>

<body>
    @yield('content')

    
    <!-- JAVASCRIPT -->
    <script src="{{ asset('auth/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('auth/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('auth/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('auth/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('auth/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('auth/assets/js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('auth/assets/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ asset('auth/assets/js/pages/particles.app.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('auth/assets/js/pages/password-addon.init.js') }}"></script>

    @stack('scripts')
</body>

</html>