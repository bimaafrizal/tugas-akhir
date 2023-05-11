@extends('layouts.dashboard.main2')

@section('title')
EWS
@endsection

@section('ews', 'active')

@section('css')
<!-- plugin css -->
<link href="{{ asset('/auth/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

{{-- leafet --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">EWS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">EWS</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row h-100">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="row">

                    <div class="col-8 m-3">
                        <h3>EWS(Early Warning System)</h3>
                        <p fs-1>Early warning system adalah sebuah alat produksi prodi D3 Teknik Informatika Universitas Sebelas Maret untuk mendeteksi banjir.</p>
                    </div>
                    <div class="col-3 my-2">
                        <img src="{{ asset('auth/assets/images/ews.jpeg') }}" class="img-fluid" alt=""
                            style="height: auto; max-height: 400px; width:100%">
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div> <!-- end col-->
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-body p-0">
                <div id="map" style="height: 400px; width:100%; position: relative;"></div>
            </div> <!-- end card-body-->
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-start mb-2">
        <div class="mx-1">
            <a href="{{ route('ews.create') }}" class="btn btn-primary">Tambah EWS</a>
        </div>
        <div class="mx-1">
            <a href="{{ route('ews.download-data', ['id' => Crypt::encrypt(0)]) }}" class="btn btn-success">Download Semua Data</a>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    @foreach ($datas as $data)
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data->name }}</h5>
                <p class="card-text">
                    {{ $data->location }}
                    <br>
                    Status : {{ $data->status == 1 ? 'Active' : 'Non Active' }}
                </p>
                <div class="d-flex justify-content-end">
                    <div class="mx-1">
                        <a href="{{ route('ews.edit', ['id' => encrypt($data->id)]) }}" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="mx-1">
                        <a href="{{ route('ews.show', ['ew' => encrypt($data->id)]) }}" class="btn btn-secondary">Detail</a>
                    </div>
                    <div class="mx-1">
                        @if ($data->status == 1)
                            <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="0">
                                <button type="submit" class="btn btn-danger">Non Active</button>
                            </form>
                            @else
                            <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="1">
                                <button type="submit" class="btn btn-info">Active</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {{ $datas->onEachSide(5)->links() }}
    </div>
    <input type="text" value="{{ $allDatas }}" id="data" hidden>
</div>
@endsection

@section('script')
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

<script>
     let map = L.map('map').setView([-7.50000, 111.000], 8);
     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

    let data = document.getElementById("data").value;
    let convertObj = JSON.parse(data);
    convertObj.forEach(element => {
        let marker = L.marker([element.latitude, element.longitude]).addTo(map).bindPopup(element.name);
    });
    
</script>
@endsection
