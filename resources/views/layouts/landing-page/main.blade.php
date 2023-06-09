<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('landing-page/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('landing-page/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing-page/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('landing-page/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: SoftLand - v4.10.0
  * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  @include('sweetalert::alert')

  @include('components/landing-page/header')

  @yield('content')

  @include('components/landing-page/footer')
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('landing-page/vendor/aos/aos.js') }} "></script>
  <script src="{{ asset('landing-page/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing-page/js/main.js') }}"></script>
  <script src="{{ asset('plugins/summernote/summernote-bs4.js') }}"></script>

</body>

</html>