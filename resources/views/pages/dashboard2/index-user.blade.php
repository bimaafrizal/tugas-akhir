@extends('layouts.dashboard.main2')

@section('title')
Dashboard
@endsection

@section('css')
<!-- plugin css -->
<link href="{{ asset('/auth/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

{{-- leafet --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
@endsection

@section('dashboard', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Analytics</li>
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
                            <div class="row">

                                <div class="col-8 m-3">
                                    <h3>SELAMAT DATANG DI AWAS BENCANA</h3>
                                    <p fs-1>Awas Bencana merupakan sebuah web yang memiliki fungsi untuk meningkatkan
                                        kewaspadaan terhadap bencana.</p>
                                </div>
                                <div class="col-3">
                                    <img src="{{ asset('auth/assets/images/flood-pana.png') }}" class="img-fluid" alt=""
                                        style="height: auto; width:100%">
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-12">
                    <section class="vh-10">
                        <div class="container py-5 h-100">

                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">

                                    <div class="card" style="color: #4B515D; border-radius: 35px;">
                                        <div class="card-body p-4">

                                            <div class="d-flex">
                                                <h6 class="flex-grow-1">{{ $cuaca != null ? $cuaca->name : 'Unknow' }}
                                                </h6>
                                            </div>

                                            <div class="d-flex flex-column text-center mt-5 mb-4">
                                                @if ($cuaca != null)
                                                <div class="d-flex justify-content-center">
                                                    <img src=" https://openweathermap.org/img/wn/{{ $cuaca->weather[0]->icon }}.png"
                                                        width="150px">
                                                </div>
                                                @endif
                                                <span class="small"
                                                    style="color: #868B94">{{ $cuaca != null ? $cuaca->weather[0]->main : 'Unknow' }}</span>
                                                <h6 class="display-4 mb-0 font-weight-bold" style="color: #1C2331;">
                                                    {{ $cuaca != null ? round($cuaca->main->temp) : 'Unknow' }}°C </h6>
                                                <div>Feels Like: <span class="ms-1">
                                                        {{ $cuaca != null ? round($cuaca->main->feels_like) : 'Unknow' }}°C
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-evenly">
                                                        <div>
                                                            <i class="fas fa-wind fa-fw" style="color: #868B94;"></i>
                                                            <span class="ms-1">
                                                                {{ $cuaca != null ? round($cuaca->wind->speed) : 'Unknow' }}
                                                                km/h
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-compass fa-fw" style="color: #868B94;"></i>
                                                            <span class="ms-1">
                                                                {{ $cuaca != null ? round($cuaca->wind->deg) : 'Unknow' }}°
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-evenly">
                                                        <div>
                                                            <i class="fas fa-cloud fa-fw"
                                                                style="color: #868B94;"></i><span class="ms-1">
                                                                {{ $cuaca != null ? round($cuaca->clouds->all) : 'Unknow' }}%
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-droplet fa-fw" style="color: #868B94;"></i>
                                                            <span class="ms-1">
                                                                {{ $cuaca != null ? round($cuaca->main->humidity) : 'Unknow' }}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-8"></div> --}}
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-evenly">
                                                        <div></div>
                                                        <div>
                                                            <i class="fas fa-eye fa-fw" style="color: #868B94;"></i>
                                                            <span class="ms-1">
                                                                {{ $cuaca != null ? round($cuaca->visibility) /1000 : 'Unknow' }}km
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($cuacas as $item)
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="d-flex justify-content-center">
                                                        <img src=" https://openweathermap.org/img/wn/{{ $item->weather[0]->icon }}.png"
                                                            width="100px">
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        {{ $cuaca != null ? round($item->main->temp) : 'Unknow' }}°C
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <span class="small"><b>{{ $item->weather[0]->main }}</b></span>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <span
                                                            class="small">{{ Str::substr($item->dt_txt, strpos($item->dt_txt, ' ')) }}</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                                <h2 class="mb-2">Get New Location</h2>
                            </div>
                            <div class="col-12">
                                <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                                <div id="map2" style="height: 400px; width:100%; position: relative;" hidden></div>
                                <p id="demo"></p>
                                <input type="text" id="latitude" name="latitude"
                                    value="{{ $user->latitude != null ? $user->latitude : '' }}" hidden>
                                <input type="text" id="longitude" name="longitude"
                                    value="{{ $user->longitude != null ? $user->longitude : '' }}" hidden>
                            </div>
                            <div class="d-flex justify-content-center">

                                <button class="btn btn-primary" id="button-location" onclick="getLocation()">Get Your
                                    Location</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

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


{{-- geolocation --}}
<script>
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        document.getElementById('latitude').setAttribute('value', position.coords.latitude);
        document.getElementById('longitude').setAttribute('value', position.coords.longitude);

        let longitude = $('#longitude').val();
        let latitude = $('#latitude').val();

        //send data
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('send-location') }}",
                    data: {
                        latitude: latitude,
                        longitude: longitude,
                    },
                    cache: false,

                    success: function (msg) {
                        console.log(msg);
                    },
                    error: function (data) {
                        console.log('error: ', data)
                    }
                });
            })
        });

        // Create a map centered on a specific location
        document.getElementById('map2').hidden = false;
        var map = L.map('map2').setView([latitude, longitude], 13);
        document.getElementById('map').hidden = true;

        // Add a tile layer to the map (in this example, we're using the OpenStreetMap tile layer)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        //set marker
        // Add a marker to the map
        let marker = L.marker([latitude, longitude]).addTo(map);

        map.on('click', function (e) {
            // Get the latitude and longitude of the clicked location
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            var lat = e.latlng.lat.toFixed(4);
            var lng = e.latlng.lng.toFixed(4);

            // Log the coordinates to the console
            console.log('Latitude:', lat, 'Longitude:', lng);
            $("#longitude").attr('value', lng);
            $('#latitude').attr('value', lat);

            //update data
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('send-location') }}",
                        data: {
                            latitude: lat,
                            longitude: lng,
                        },
                        cache: false,

                        success: function (msg) {
                            console.log(msg);
                        },
                        error: function (data) {
                            console.log('error: ', data)
                        }
                    });
                })
            });
        });
    }

</script>

{{-- manual --}}
<script>
    // console.log($('#latitude').val());
    // Create a map centered on a specific location
    let map = L.map('map').setView([-7.50000, 111.000], 14);
    let marker = null;
    if ($('#longitude').val() !== '') {
        map.setView([$('#latitude').val(), $('#longitude').val()], 14);
        marker = L.marker([$('#latitude').val(), $('#longitude').val()]).addTo(map);
    }

    // Add a tile layer to the map (in this example, we're using the OpenStreetMap tile layer)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    // Add a marker to the map
    map.on('click', function (e) {
        // Get the latitude and longitude of the clicked location
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
        var lat = e.latlng.lat.toFixed(4);
        var lng = e.latlng.lng.toFixed(4);

        // Log the coordinates to the console
        console.log('Latitude:', lat, 'Longitude:', lng);
        $("#longitude").attr('value', lng);
        $('#latitude').attr('value', lat);

        //update data
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('send-location') }}",
                    data: {
                        latitude: lat,
                        longitude: lng,
                    },
                    cache: false,

                    success: function (msg) {
                        console.log(msg);
                    },
                    error: function (data) {
                        console.log('error: ', data)
                    }
                });
            })
        });
    });

</script>
@endsection
