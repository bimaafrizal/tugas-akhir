<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify OTP</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify OTP') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf
                            @if (Session::has('error'))
                            {{ session('error') }}
                            {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div> --}}
                            @endif

                            <div class="form-group row">
                                <label for="otp"
                                    class="col-md-4 col-form-label text-md-right">{{ __('OTP Code') }}</label>

                                <div class="col-md-6">
                                    <input id="otp" type="text" class="form-control"
                                        name="otp" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Verify OTP') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
