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

<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.highcharts.com/highcharts.js"></script>
@endsection

@section('dashboard', 'active')

@section('content')
<style>
    .legend {
        background-color: white;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
    }

    .legend-icon {
        width: 20px;
        /* Adjust the width as needed */
        height: 20px;
        /* Adjust the height as needed */
        margin-right: 5px;
    }

</style>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Dashboards</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-12">
        <div class="d-flex flex-column h-100">
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
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Users</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countUser }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="users" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Admin</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countAdmin }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="user" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Super Admin</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countSuperAdmin }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="user" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Kategori Artikel</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countKetegoryArticle }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="tag" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Artikel</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countArticle }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="clipboard" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Alat EWS</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $countEws }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                            <i data-feather="monitor" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3>Peta Lokasi Bencana Tahun Ini</h3>
                                <div class="data mb-1">
                                    <form action="" method="GET">
                                        @csrf
                                        <select name="month" id="" class="form-control d-inline" style="width: 150px">
                                            <option value="" selected>Pilih Bulan</option>
                                            @foreach ($listMonths as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary d-inline">Submit</button>
                                    </form>
                                </div>
                            </div>
                            <div id="map3" style="height: 400px; width:100%; position: relative;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <a class="twitter-timeline" data-width="100%" data-height="800"
                                href="https://twitter.com/infoBMKG?ref_src=twsrc%5Etfw">
                                Tweets by infoBMKG</a>
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="pie-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Tabel Bencana Tahun Ini</h3>
                            <table id="example"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">No.</th>
                                        <th data-ordering="false">Jenis</th>
                                        <th>Lokasi</th>
                                        <th>Detail Lokasi</th>
                                        <th>Kedalaman</th>
                                        <th>Kekuatan</th>
                                        <th>Level</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($earthquakeThisYear != null)
                                    @foreach ($earthquakeThisYear as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>Gempa</td>
                                        <td>{{ $item->latitude }}, {{ $item->longitude }}</td>
                                        <td>{{ $item->location != null ? $item->location : '-' }}</td>
                                        <td>{{ $item->depth }}</td>
                                        <td>{{ $item->strength }}</td>
                                        <td>-</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('earthquake.show', ['id' => Crypt::encrypt($item->id)]) }}"
                                                class="btn btn-secondary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if ($floodThisYear != null)
                                    @foreach ($floodThisYear as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>Banjir</td>
                                        <td>{{ $item->ews->name }}</td>
                                        <td>{{ $item->ews->regency->name }},{{ $item->ews->province->name }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        @if ($item->level == 1)
                                        <td>Waspada</td>
                                        @elseif($item->level == 2)
                                        <td>Siaga</td>
                                        @else
                                        <td>Awas</td>
                                        @endif
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('ews.show', ['ew' => encrypt($item->ews->id)]) }}"
                                                class="btn btn-secondary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->

<input type="text" value="{{ $earthquakeThisYear }}" id="gempa" hidden>
<input type="text" value="{{ $ews }}" id="ews" hidden>
<input type="text" value="{{ $countEarthquake }}" id="countGempa" hidden>
<input type="text" value="{{ $countFlood }}" id="countBanjir" hidden>
@endsection

@section('script')
<!-- Vector map-->
<script src="{{ asset('/auth/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>


<!-- Dashboard init -->
<script src="{{ asset('/auth/assets/js/pages/dashboard-analytics.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('/auth/assets/js/app.js') }} "></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('auth/assets/js/pages/datatables.init.js') }}"></script>

<script>
    // icon
    const floodIcon = L.icon({
        iconUrl: 'auth/assets/images/flood.png',
        iconSize: [20, 20],
    });
    const earthquakeIcon = L.icon({
        iconUrl: 'auth/assets/images/earthquake.png',
        iconSize: [30, 30],
    });

    let map3 = L.map('map3').setView([-3.00000, 115.000], 5);

    let dataGempa = document.getElementById("gempa").value;
    if (dataGempa != "") {
        console.log("Betul");
    }

    let convertGempaObj = JSON.parse(dataGempa);
    let dataEws = document.getElementById("ews").value;
    let convertEwsObj = JSON.parse(dataEws);

    convertGempaObj.forEach(e => {
        L.marker([e.latitude, e.longitude], {
            icon: earthquakeIcon
        }).addTo(map3).bindPopup('<p>Kekuatan:' + e.strength + ' SR</p><p> Kedalaman:' + e.depth +
            ' KM</p><p>' + e.time + ',' + e.date + '</p>');

    });
    convertEwsObj.forEach(element => {
        L.marker([element.latitude, element.longitude], {
            icon: floodIcon
        }).addTo(map3).bindPopup(element.name);
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map3);

    const legend = L.control({
        position: "bottomright"
    });
    const pin_gempa = '/auth/assets/images/earthquake.png';
    const pin_banjir = '/auth/assets/images/flood.png';

    legend.onAdd = function (map) {
        let div = L.DomUtil.create("div", "legend");
        div.innerHTML = `<h6>Informasi</h6>
    <div>
      <img class="legend-icon" src="{{ asset('auth/assets/images/earthquake.png') }}" alt="Category 1 Icon">
      <span>Gempa</span>
    </div></br>
    <div>
      <img class="legend-icon" src="{{ asset('auth/assets/images/flood.png') }}" alt="Category 2 Icon">
      <span>Alat EWS</span>
    </div>`;
        return div;
    }

    legend.addTo(map3);

</script>

<script>
    let countGempa = parseInt($('#countGempa').val());
    let countBanjir = parseInt($('#countBanjir').val());

    let total = countBanjir + countGempa;
    let percentGempa = countGempa / total * 100;
    let percentBanjir = countBanjir / total * 100;

    let dataPie = [{
            name: 'Gempa',
            y: countGempa,
            persen: percentGempa,
        },
        {
            name: 'Banjir',
            y: countBanjir,
            persen: percentBanjir
        }
    ];

    Highcharts.chart('pie-chart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Bencana Tahun Ini',
            align: 'center'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>({point.y:.0f}) | {point.persen} %</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: ({point.y:.0f}) | {point.persen} %'
                }
            }
        },

        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: dataPie
        }]
    });

</script>
@endsection
