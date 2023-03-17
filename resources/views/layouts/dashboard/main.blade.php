<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{-- asset --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <script src="https://kit.fontawesome.com/52cf1628fd.js" crossorigin="anonymous"></script>
    {{-- Jquery --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- DataTable --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>

    {{-- livewire --}}
    @stack('styles')

    {{-- trix --}}
    @stack('trix')
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="app">
        @include('components.dashboard.side-bar')
        <div id="main">
            @include('components.dashboard.header')
            @yield('content')

            @include('components.dashboard.footer')
        </div>
    </div>

    {{-- trix --}}
    @stack('attachment-file')

    {{-- livewire --}}
    @stack('scripts')

    {{-- asset --}}
    <script src="{{ asset('assets/js/bootstrap.js') }} "></script>
    <script src="{{ asset('assets/js/app.js') }} "></script>

    <!-- Need: Apexcharts -->
    {{-- <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

</body>

</html>
