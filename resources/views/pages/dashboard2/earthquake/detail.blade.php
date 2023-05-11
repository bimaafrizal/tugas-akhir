@extends('layouts.dashboard.main2')

@section('title')
Gempa
@endsection

@section('css')
<!-- plugin css -->
<link href="{{ asset('/auth/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

{{-- leafet --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>

@endsection

@section('earthquake', 'active')

@section('content')
    <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Gempa</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Gempa</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-12">
        <div class="d-flex flex-column h-50">
            <div class="row h-100">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="text-center mt-3">
                                <h1>Gempa Terbaru</h1>
                                <p>Kekuatan Gempa: {{ $gempa->strength }} SR </p>
                                <p>Kedalaman: {{ $gempa->depth }} </p>
                                <p>Tanggal: {{ $gempa->date }} </p>
                                <p>Jam: {{ $gempa->time }}</p>
                                <p>Potensi: <b>{{ $gempa->potency }}</b></p>
                                <input type="text" id="latitude" value="{{ $gempa->latitude }}" hidden>
                                <input type="text" id="longitude" value="{{ $gempa->longitude }}" hidden>
                            </div>

                            <div class="d-flex justify-content-center mx-5 mb-4">
                                <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

        </div>
    </div> <!-- end col-->

</div> <!-- end row-->
@endsection

@section('script')
<!-- Vector map-->
<script src="{{ asset('/auth/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>


<!-- Dashboard init -->
<script src="{{ asset('/auth/assets/js/pages/dashboard-analytics.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('/auth/assets/js/app.js') }} "></script>

<script>
    let map = L.map('map').setView([$('#longitude').val(), $('#latitude').val()], 10);
    let marker = L.marker([$('#longitude').val(), $('#latitude').val()]).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

</script>
@endsection
