<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $logo }}">

    
    <!-- Layout config Js -->
    <script src="{{ asset('/auth/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('/auth/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('/auth/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('/auth/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('/auth/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    
    {{-- fontawesome --}}
    <script src="https://kit.fontawesome.com/52cf1628fd.js" crossorigin="anonymous"></script>
    
    
    {{-- jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('css')

    @stack('styles')
</head>

<body>
    @include('sweetalert::alert')

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('components.dashboard2.header')

        @include('components.dashboard2.sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('components.dashboard2.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    @stack('scripts')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('/auth/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ asset('/auth/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('/auth/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('/auth/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('/auth/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('/auth/assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('/auth/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    @yield('script')

</body>

</html>
