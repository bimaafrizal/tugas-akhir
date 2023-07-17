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

<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ URL::asset('auth/assets/libs/@simonwep/@simonwep.min.css') }}" />
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
                    <li class="breadcrumb-item active">Gempa</li>
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
                            <div class="d-flex justify-content-start m-2">
                                <div class="mx-1 mt-2">
                                    <br>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgrid" class="btn btn-success">Download Semua Data</button>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <h1>Gempa Terbaru</h1>
                                <p>Kekuatan Gempa: {{ $gempa->strength }} SR </p>
                                <p>Kedalaman: {{ $gempa->depth }} </p>
                                <p>Tanggal: {{ $gempa->date }} </p>
                                <p>Jam: {{ $gempa->time }}</p>
                                <p>Potensi: <b>{{ $gempa->potency }}</b></p>
                                <input type="text" id="longitude" value="{{ $gempa->longitude }}" hidden>
                                <input type="text" id="latitude" value="{{ $gempa->latitude }}" hidden>
                            </div>

                            <div class="d-flex justify-content-center mx-5 mb-4">
                                <div id="map" style="height: 400px; width:100%; position: relative;"></div>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                </div> <!-- end col-->
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <table id="myTable"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">No.</th>
                                        <th data-ordering="false">Lokasi</th>
                                        <th data-ordering="false">Tanggal</th>
                                        <th data-ordering="false">Jam</th>
                                        <th>Kekuatan</th>
                                        <th>Kedalaman</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gempas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->location }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->time }}</td>
                                        <td>{{ $data->strength }}</td>
                                        <td>{{ $data->depth }}</td>
                                        <td>
                                            <a href="{{ route('earthquake.show', ['id' => Crypt::encrypt($data->id)]) }}" class="btn btn-secondary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end row-->

        </div>
    </div> <!-- end col-->

</div> <!-- end row-->

<div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Download Data Gempa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('earthquake.download') }}" method="GET">
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
<!-- Vector map-->
<script src="{{ asset('/auth/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>


<!-- Dashboard init -->
<script src="{{ asset('/auth/assets/js/pages/dashboard-analytics.init.js') }}"></script>

<script src="{{ URL::asset('auth/assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
<script src="{{ URL::asset('auth/assets/js/pages/form-pickers.init.js') }}"></script>
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
    let map = L.map('map').setView([$('#latitude').val(), $('#longitude').val()], 7);
    let marker = L.marker([$('#latitude').val(), $('#longitude').val()]).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>

@endsection
