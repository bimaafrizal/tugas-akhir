<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @if (Session::has('error'))
                            {{ session('error') }}
                            {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div> --}}
                            @endif

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autofocus>
                                        @error('password')
                                        {{ $message }}
                                        <div class="invalid-feedback">
                                        </div>
                                        @enderror
                                </div>
                                <label for="password_confirmation"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password Confirmation') }}</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation')
                                        is-invalid
                                    @enderror" name="password_confirmation" required autofocus>
                                    @error('password_confirmation')
                                    {{ $message }}
                                    <div class="invalid-feedback">
                                    </div>
                                    @enderror
                                    <input id="email" type="hiden" class="form-control" name="email" value="{{ $email }}" hidden>
                                    <input id="token" type="hiden" class="form-control" name="token" value="{{ $token }}" hidden>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
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
