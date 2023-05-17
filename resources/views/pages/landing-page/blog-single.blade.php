@extends('layouts.landing-page.main')

@section('title')
{{ $article->title }}
@endsection
@section('content')
<main id="main">

    <!-- ======= Single Blog Section ======= -->
    <section class="hero-section inner-page">
        <div class="wave">

            <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                        <path
                            d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z"
                            id="Path"></path>
                    </g>
                </g>
            </svg>

        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-10 text-center hero-text">
                            <h1 data-aos="fade-up" data-aos-delay="">{{ $article->title }}</h1>
                            <p class="mb-5" data-aos="fade-up" data-aos-delay="100">{{ $article->created_at->diffForHumans() }} &bullet;
                                By <a href="#" class="text-white">{{ $article->user->name }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="site-section mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-content">
                    <div class="d-flex justify-content-center mt-2">
                        <img src="{{ asset($article->cover) }}" alt="cover" class="img-fluid"
                            style="max-height: 500px; background-size: cover">
                    </div>

                    {!! $article->body !!}
                    <div class="pt-5">
                        <p>Categories: <a href="#">{{ $article->kategory->name }}</a></p>
                    </div>

                    <div class="pt-5">

                        <div class="comment-form-wrap pt-2">
                            <h3 class="mb-2">Leave a comment</h3>
                            <form action="{{ route('comment-store', ['slug' => $article->slug]) }}" method="POST"
                                class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="body" id="message" cols="30" rows="10"
                                        class="form-control @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
                                    @error('body')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <input type="submit" value="Post Comment" class="btn btn-primary">
                                </div>

                            </form>
                        </div>
                        <h3 class="mb-5">{{ $countComment }} Comments</h3>
                        <ul class="comment-list">

                            @include('pages.landing-page.comments', ["comments" => $comments, 'slug' => $article->slug])

                        </ul>
                        <!-- END comment-list -->
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ======= CTA Section ======= -->
    <section class="section cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                    <h2>Starts Publishing Your Apps</h2>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <p><a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-apple"></i><span>App
                                store</span></a> <a href="#" class="btn d-inline-flex align-items-center"><i
                                class="bx bxl-play-store"></i><span>Google play</span></a></p>
                </div>
            </div>
        </div>
    </section><!-- End CTA Section -->

</main><!-- End #main -->
@endsection
