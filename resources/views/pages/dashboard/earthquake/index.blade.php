@extends('layouts.dashboard.main')

@section('earthquake', 'active')

@section('title')
Gempa
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Gempa</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gempa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h3>Gempa Terbaru</h3>
                        <p>Kekuatan Gempa: {{ $gempa->strength }} M </p>
                        <p>Kedalaman: {{ $gempa->depth }} </p>
                        <p>Jam: {{ $gempa->jam }}</p>
                        <p>Tanggal: {{ $gempa->tanggal }} </p>
                        <input type="text" id="latitude" value="{{ $gempa->latitude }}" hidden>
                        <input type="text" id="longitude" value="{{ $gempa->longitude }}" hidden>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div id="map" style="height: 400px; width:100%; position: relative;"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    let map = L.map('map').setView([$('#longitude').val(), $('#latitude').val()], 7);
    let marker = L.marker([$('#longitude').val(), $('#latitude').val()]).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);


</script>
@endsection
