@extends('layouts.landing-page.main')

@section('title')
    Welcome
@endsection

@section('home')
    class="active "
@endsection
@section('content')
    <!-- ======= Hero Section ======= -->
  <section class="hero-section" id="hero">

    <div class="wave">

      <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
          </g>
        </g>
      </svg>

    </div>

    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 hero-text-image">
          <div class="row">
            <div class="col-lg-8 text-center text-lg-start">
              <h1 data-aos="fade-right">{{ $page->title }}</h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">{{ $page->subtitle }}</p>
              {{-- <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500"><a href="#" class="btn btn-outline-white">Get started</a></p> --}}
            </div>
            <div class="col-lg-4 iphone-wrap">
              <img src="{{ $page->image_title != null ? asset($page->image_title) : asset('landing-page/img/phone_1.png') }} " alt="Image" class="phone-1" data-aos="fade-right">
              <img src="{{  $page->image_title2 != null ? asset($page->image_title2) : asset('landing-page/img/phone_2.png') }}" alt="Image" class="phone-2" data-aos="fade-right" data-aos-delay="200">
            </div>
          </div>
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Home Section ======= -->
    <section class="section">
      <div class="container">

        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-5" data-aos="fade-up">
            <h2 class="section-heading">Fitur</h2>
          </div>
        </div>

        <div class="row">
          @foreach ($fiturs as $fitur)
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="">
            <div class="feature-1 text-center">
              <div class="wrap-icon icon-1">
                {!! $fitur->logo !!}
              </div>
              <h3 class="mb-3">{{ $fitur->title }}</h3>
              <p>{{ $fitur->body }}</p>
            </div>
          </div>
          @endforeach

        </div>

      </div>
    </section>

    <section class="section">

      <div class="container">

        <div class="row">
          @foreach ($collabs as $collab)
          <div class="col-md-2">
            <img src="{{ asset($collab->logo) }}" style="width: 100%" alt="" class="img-fluid">
          </div>
          @endforeach
        </div>
      </div>

    </section>

    <section class="section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4 me-auto">
            <h2 class="mb-4">{{ $page->title_about1 }}</h2>
            <p class="mb-4">{{ $page->about1 }}</p>
            {{-- <p><a href="#" class="btn btn-primary">Download Now</a></p> --}}
          </div>
          <div class="col-md-6" data-aos="fade-left">
            <img src="{{  $page->image1 != null ? asset($page->image1) : asset('landing-page/img/undraw_svg_2.svg') }}" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4 ms-auto order-2">
            <h2 class="mb-4">{{ $page->title_about2 }}</h2>
            <p class="mb-4">{{ $page->about2 }}</p>
            {{-- <p><a href="#" class="btn btn-primary">Download Now</a></p> --}}
          </div>
          <div class="col-md-6" data-aos="fade-right">
            <img src="{{  $page->image2 != null ? asset($page->image2) : asset('landing-page/img/undraw_svg_3.svg') }}" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection