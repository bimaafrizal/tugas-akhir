@extends('layouts.auth')

@section('title')
Verify Phone Number
@endsection

@section('content')
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="assets/images/logo-light.png" alt="" height="20">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="mb-4">
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                        <i class="ri-mail-line"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 mt-4">
                                <div class="text-muted text-center mb-4 mx-lg-3">
                                    <h4>Verify Your Phone Number</h4>
                                    <p>Please enter the 4 digit code sent to <span class="fw-semibold">your phone
                                            number</span></p>
                                    @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                </div>

                                <form autocomplete="off" method="POST" action="{{ route('otp.verify') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                <input type="text"
                                                    class="form-control form-control-lg bg-light border-light text-center"
                                                    onkeyup="moveToNext(1, event)" name="digit1" maxLength="1"
                                                    id="digit1-input">
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                <input type="text"
                                                    class="form-control form-control-lg bg-light border-light text-center"
                                                    onkeyup="moveToNext(2, event)" name="digit2" maxLength="1"
                                                    id="digit2-input">
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                <input type="text"
                                                    class="form-control form-control-lg bg-light border-light text-center"
                                                    onkeyup="moveToNext(3, event)" name="digit3" maxLength="1"
                                                    id="digit3-input">
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                <input type="text"
                                                    class="form-control form-control-lg bg-light border-light text-center"
                                                    onkeyup="moveToNext(4, event)" name="digit4" maxLength="1"
                                                    id="digit4-input">
                                            </div>
                                        </div><!-- end col -->
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success w-100">Confirm</button>
                                    </div>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Didn't receive a code ? <a href="{{ route('verification.otp') }}"
                                class="fw-semibold text-primary text-decoration-underline">Resend</a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>
                                document.write(new Date().getFullYear())

                            </script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->
@endsection