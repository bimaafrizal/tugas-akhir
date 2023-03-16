@extends('layouts.dashboard.main')
@section('dashboard', 'active')

@section('title')
Dashboard
@endsection

@section('content')

<div class="page-heading">
    <h3>Dashboard</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">

                <section class="vh-10">
                    <div class="container py-5 h-100">

                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12">

                                <div class="card" style="color: #4B515D; border-radius: 35px;">
                                    <div class="card-body p-4">

                                        <div class="d-flex">
                                            <h6 class="flex-grow-1">{{ $cuaca != null ? $cuaca->name : 'Unknow' }}</h6>
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
                                                        <i class="fas fa-wind fa-fw" style="color: #868B94;"></i> <span
                                                            class="ms-1">
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
                                                        <i class="fas fa-cloud fa-fw" style="color: #868B94;"></i><span
                                                            class="ms-1">
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
                                                        <i class="fas fa-eye fa-fw" style="color: #868B94;"></i> <span
                                                            class="ms-1">
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
                                                        <span class="small">{{ Str::substr($item->dt_txt, strpos($item->dt_txt, ' ')) }}</span>
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
            <div class="row mb-2">
                <div class="col-12">

                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Get New Location
                        </button>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                    <div id="map2" style="height: 400px; width:100%; position: relative;" hidden></div>
                    <p id="demo"></p>
                    <input type="text" id="latitude" name="latitude"
                        value="{{ $user->latitude != null ? $user->latitude : '' }}" hidden>
                    <input type="text" id="longitude" name="longitude"
                        value="{{ $user->longitude != null ? $user->longitude : '' }}" hidden>
                    <button class="btn btn-primary" id="button-location" onclick="getLocation()">Get Your
                        Location</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


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
