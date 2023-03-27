@extends('layouts.dashboard.main2')

@section('title')
Setting Bencana
@endsection

@section('disaster', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Setting Bencana</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Setting Bencana</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Bencana</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('disaster.update', ['id' => encrypt($data->id)]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Bencana*</label>
                        <input type="text" class="form-control @error('name') is-invalid
                        @enderror" id="name" name="name" value="{{ old('name', $data->name) }}" readonly>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="strength" class="form-label">Kekuatan Bencana*</label>
                        <br>
                        <small>Dalam Scala Ricter</small>
                        <input type="number" class="form-control @error('strength') is-invalid
                        @enderror" id="strength" name="strength" value="{{ old('strength', $data->strength) }}" {{ $data->id == 1 ? 'readonly' : '' }}>
                        @error('strength')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="distance" class="form-label">Jarak Bencana*</label>
                        <br>
                        <small>Dalam KM</small>
                        <input type="number" class="form-control @error('distance') is-invalid
                        @enderror" id="distance" name="distance" value="{{ old('distance', $data->distance) }}">
                        @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="depth" class="form-label">Kedalaman Bencana*</label>
                        <br>
                        <small>Dalam KM</small>
                        <input type="number" class="form-control @error('depth') is-invalid
                        @enderror" id="depth" name="depth" value="{{ old('depth', $data->depth) }}" {{ $data->id == 1 ? 'readonly' : '' }}>
                        @error('depth')
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
    <!--end col-->
</div>
<!--end row-->

@endsection


@section('script')

<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
