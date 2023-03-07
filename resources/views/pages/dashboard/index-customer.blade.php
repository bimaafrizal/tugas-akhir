@extends('layouts.dashboard.main')
@section('dashboard', 'active')

@section('title')
Dashboard
@endsection

@section('content')

<div class="page-heading">
    <h3>Profile Statistics</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Profile Views</h6>
                                    <h6 class="font-extrabold mb-0">112.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Followers</h6>
                                    <h6 class="font-extrabold mb-0">183.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Following</h6>
                                    <h6 class="font-extrabold mb-0">80.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Saved Post</h6>
                                    <h6 class="font-extrabold mb-0">112</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                    <div id="map2" style="height: 400px; width:100%; position: relative;" hidden></div>
                    <br />
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <p id="demo"></p>
                        <input type="text" id="latitude" name="latitude"
                            value="{{ $user->latitude != null ? $user->latitude : '' }}" hidden>
                        <input type="text" id="longitude" name="longitude"
                            value="{{ $user->longitude != null ? $user->longitude : '' }}" hidden>
                        <button class="btn btn-primary" id="button-location" onclick="getLocation()">Get Your
                            Location</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="{{ asset('assets/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Europe</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">862</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-europe"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="{{ asset('assets/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">America</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">375</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-america"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-danger" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="{{ asset('assets/images/bootstrap-icons.svg#circle-fill') }}" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Indonesia</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">1025</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-indonesia"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Comments</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('assets/images/faces/5.jpg') }}">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Si Cantik</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">Congratulations on your graduation!</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('assets/images/faces/2.jpg') }}">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Si Ganteng</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">Wow amazing design! Can you make another
                                                    tutorial for
                                                    this design?</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

//geolocation
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

// manual
<script>
    // console.log($('#latitude').val());
    // Create a map centered on a specific location
    let map = L.map('map').setView([-7.50000, 111.000], 10);
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
