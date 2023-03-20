@extends('layouts.dashboard.main2')

@section('title')
EWS
@endsection

@section('ews', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">EWS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">EWS</li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah EWS</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('ews.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control @error('name') is-invalid
                            @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid
                            @enderror" id="location" name="location" value="{{ old('location') }}">
                            @error('location')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="api_url" class="form-label">Api URL*</label>
                            <input type="text" class="form-control @error('api_url') is-invalid
                            @enderror" id="api_url" name="api_url" value="{{ old('api_url') }}">
                            @error('api_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="api_key" class="form-label">Api Key</label>
                            <input type="text" class="form-control @error('api_key') is-invalid
                            @enderror" id="api_key" name="api_key" value="{{ old('api_key') }}">
                            @error('api_key')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid
                            @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}">
                            @error('longitude')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid
                            @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            @error('latitude')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gmaps_link" class="form-label">Gmaps Link</label>
                            <input type="text" class="form-control @error('gmaps_link') is-invalid
                            @enderror" id="gmaps_link" name="gmaps_link" value="{{ old('gmaps_link') }}">
                            @error('gmaps_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
