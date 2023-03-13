@extends('layouts.dashboard.main')

@section('ews', 'active')

@section('title')
Edit EWS
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit EWS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">EWS</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit EWS</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('ews.update', ['id' => encrypt($data->id)]) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">Name*</label>
                                    <input type="text" class="form-control @error('name') is-invalid
                                    @enderror" id="name" name="name" value="{{ old('name', $data->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid
                                    @enderror" id="location" name="location" value="{{ old('location', $data->location) }}">
                                    @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="api_url" class="form-label">API URL*</label>
                                    <input type="text" class="form-control @error('api_url') is-invalid
                                    @enderror" id="api_url" name="api_url" value="{{ old('api_url', $data->api_url) }}">
                                    @error('api_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="api_key" class="form-label">API KEY</label>
                                    <input type="text" class="form-control @error('api_key') is-invalid
                                    @enderror" id="api_key" name="api_key" value="{{ old('api_key', $data->api_key) }}">
                                    @error('api_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid
                                    @enderror" id="longitude" name="longitude" value="{{ old('longitude', $data->longitude) }}">
                                    @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control @error('latitude') is-invalid
                                    @enderror" id="latitude" name="latitude" value="{{ old('latitude', $data->latitude) }}">
                                    @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="gmaps_link" class="form-label">Gmaps Link</label>
                                    <input type="text" class="form-control @error('gmaps_link') is-invalid
                                    @enderror" id="gmaps_link" name="gmaps_link" value="{{ old('gmaps_link', $data->gmaps_link) }}">
                                    @error('gmaps_link')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

