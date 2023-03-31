@extends('layouts.dashboard.main2')

@section('title')
Setting Landing Page
@endsection

@section('landing-page', 'active')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Setting Landing Page</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Setting Landing Page</li>
                    <li class="breadcrumb-item active">Edit Fitur</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('landing-page.update-fitur', ['id' => encrypt($data->id)]) }}" method="POST">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control @error('title') is-invalid
                    @enderror" id="title" name="title"
                            value="{{ old('title', $data->title) }}">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Body*</label>
                        <input type="text" class="form-control @error('body') is-invalid
                    @enderror" id="body" name="body"
                            value="{{ old('body', $data->body) }}">
                        @error('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo*</label><br>
                        <a href="https://icons.getbootstrap.com/"><small>Gunakan bootstrap icons</small></a>
                        <input type="text" class="form-control @error('logo') is-invalid
                    @enderror" id="logo" name="logo"
                            value="{{ old('logo', $data->logo) }}">
                        @error('logo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>

@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

@endsection
