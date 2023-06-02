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
                    <li class="breadcrumb-item active">Edit</li>
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
                    <form method="POST" action="{{ route('ews.update', ['id' => encrypt($data->id)]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control @error('name') is-invalid
                            @enderror" id="name" name="name" value="{{ old('name', $data->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="province" class="form-label">Provinsi*</label>
                            <select class="form-select mb-3 @error('province_id') is-invalid
                            @enderror" aria-label="Default select example" name="province_id"
                                id="province">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinces as $item)
                                @if (old('province_id') == $item->id || $item->id == $data->province_id)
                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option> 
                                @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('province_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="regency" class="form-label">Kabupaten*</label>
                            <select class="form-select mb-3 @error('regency_id') is-invalid
                            @enderror" aria-label="Default select example" name="regency_id"
                                id="regency">
                                @foreach ($regencies as $item)
                                @if (old('province_id') == $item->id || $item->id == $data->regency_id)
                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option> 
                                @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                                    
                                @endforeach
                                
                            </select>
                            @error('regency_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail Lokasi</label>
                            <input type="text" class="form-control @error('detail') is-invalid
                            @enderror" id="detail" name="detail" value="{{ old('detail') }}">
                            @error('detail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="api_url" class="form-label">Api URL*</label>
                            <input type="text" class="form-control @error('api_url') is-invalid
                            @enderror" id="api_url" name="api_url" value="{{ old('api_url', $data->api_url) }}">
                            @error('api_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="api_key" class="form-label">Api Key</label>
                            <input type="text" class="form-control @error('api_key') is-invalid
                            @enderror" id="api_key" name="api_key" value="{{ old('api_key', $data->api_key) }}">
                            @error('api_key')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid
                            @enderror" id="longitude" name="longitude" value="{{ old('longitude', $data->longitude) }}">
                            @error('longitude')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid
                            @enderror" id="latitude" name="latitude" value="{{ old('latitude', $data->latitude) }}">
                            @error('latitude')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gmaps_link" class="form-label">Gmaps Link</label>
                            <input type="text" class="form-control @error('gmaps_link') is-invalid
                            @enderror" id="gmaps_link" name="gmaps_link" value="{{ old('gmaps_link', $data->gmaps_link) }}">
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

<script>
    $(document).ready(function () {
        $('#province').click(function () {
            let provinces_id = $('#province').val();
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('get-regency') }}",
                        data: {
                            id: provinces_id,
                        },
                        cache: false,

                        success: function (msg) {
                            $('#regency').removeAttr('disabled');
                            $('#regency').html(msg);
                        },
                        error: function (data) {
                            console.log('error: ', data)
                        }
                    });
                })
            });
        });
    });

</script>
@endsection
