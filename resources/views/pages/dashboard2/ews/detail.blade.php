@extends('layouts.dashboard.main2')

@section('title')
EWS
@endsection

@section('ews', 'active')

@section('css')
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

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
                    <li class="breadcrumb-item">EWS</li>
                    <li class="breadcrumb-item active">Show</li>
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
                <div class="card-body">
                    {{-- {{ dd($flood[0]->level) }} --}}
                    {{-- {{ dd(gettype($flood)) }} --}}
                    @if ($flood != "[]")
                    <h5>Level Ketinggian Air:
                        @if ($flood[0]->level == 0)
                            Normal
                        @endif
                        @if ($flood[0]->level == 1)
                            Siaga
                        @endif
                        @if ($flood[0]->level == 2)
                            Waspada
                        @endif
                        @if ($flood[0]->level == 3)
                            Awas
                        @endif
                    </h5>
                    @else
                    <h5>Level Ketinggian Air: -
                    </h5>
                        
                    @endif

                    <div class="text-center">
                        <h1>{{ $ews->name }}</h1>
                        <p>{{ $ews->regency->name }}, {{ $ews->province->name }}</p>
                        <p>{{ $ews->detail }}</p>
                        <p>Status : {{ $ews->status == 1 ? 'Active' : 'Non Active' }}</p>
                        @if ($ews->gmaps_link != null && $ews->longitude == null && $ews->latitude == null)
                        <div class="container text-center my-5 ratio ratio-16x9">
                            {{ $ews->gmaps_link }}
                        </div>
                        @endif
                        @if ($ews->longitude != null && $ews->latitude != null)
                            <input type="text" id="longitude" value="{{ $ews->longitude }}" hidden>
                            <input type="text" id="latitude" value="{{ $ews->latitude }}" hidden>
                            <div class="mx-2">
                                <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h1>Grafik Ketinggian Air(Realtime)</h1>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center my-2">
                    <h1>Tabel Ketinggian Air</h1>
                </div>
                <div class="d-flex justify-content-start mb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">Download Data</button>
                </div>
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">No.</th>
                            <th data-ordering="false">EWS</th>
                            <th>Level</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flood as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->ews->name }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="text" name="" id="id" value="{{ Crypt::encrypt($ews->id) }}" hidden>
<div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Download Data EWS {{ $ews->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ews.download-data', ['id' => Crypt::encrypt($ews->id)]) }}" method="GET">
                    <div class="row g-3">
                        <small class="bg-danger text-white">Jika ingin mendownload semua data, kosongkan form di bawah
                            ini</small>
                        @csrf
                        <div class="col-xxl-6">
                            <div>
                                <label for="firstName" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" data-provider="flatpickr"
                                    data-date-format="d M, Y" id="firstDate" name="tanggal_mulai">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="lastName" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" data-provider="flatpickr"
                                    data-date-format="d M, Y" id="lasDate" name="tanggal_akhir">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Download Data</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
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
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

<script>
    var ctx = document.getElementById("chart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Level',
                data: [],
                borderWidth: 1,
                fill: false,
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Status',
                        font: {
                            size: 16
                        }
                    },
                    min: 0,
                    max: 3,
                    ticks: {
                        font: {
                            size: 12
                        },
                        callback: function(value, index, values) {
                            if(value === 0) {
                                return 'Normal';
                            } else if(value === 1) {
                                return 'Siaga';
                            } else if(value === 2) {
                                return 'Waspada';
                            } else if(value === 3) {
                                return 'Awas';
                            }
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)',
                        lineWidth: 1,
                    }
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.parsed.y || 0;
                            let index = context.dataIndex;
                            let data = context.dataset.data;
                            let created_at_data = context.dataset.created_at_data;
                            let created_at = created_at_data[index];

                            let formattedDate = new Date(created_at).toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric'
                            });

                            if(value == 0){
                                value = "normal";
                            } else if(value == 1){
                                value = "siaga";
                            } else if(value == 2){
                                value = "waspada";
                            } else if(value == 3){
                                value = "awas";
                            }

                            label = "";
                            label += 'level: '+ value +' - ' + formattedDate;
                            return label;
                        }
                    }
                }
            }
        }
    });

    var updateChart = function () {
        let idEws = $('#id').val();
        // console.log(idEws);
        $.ajax({
            url: "{{ route('ews.get-data') }}",
            type: 'get',
            data: {
                id: idEws
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                const level = data.map(item => item.level);
                const lastValue = level[0];

                let datasetColor = 'blue';
                if(lastValue === 1) {
                    datasetColor = 'yellow';
                } else if(lastValue === 2) {
                    datasetColor = 'orange';
                } else if(lastValue === 3) {
                    datasetColor = 'red';
                }

                myChart.data.labels = Array.from({ length: level.length }, (_, index) => index + 1);
                myChart.data.datasets[0].data = level;
                myChart.data.datasets[0].created_at_data = data.map(item => item.created_at);
                myChart.data.datasets[0].backgroundColor = datasetColor;
                myChart.update();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    updateChart();
    setInterval(() => {
        updateChart();
    }, 1000);
</script>

<script>
    let longitude = document.getElementById('longitude').value;
    let latitude = document.getElementById('latitude').value;

    let map = L.map('map').setView([latitude, longitude], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
         maxZoom: 18,
    }).addTo(map);
        let marker = L.marker([latitude, longitude]).addTo(map);
</script>

@endsection
