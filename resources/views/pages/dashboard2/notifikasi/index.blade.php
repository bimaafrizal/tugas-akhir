@extends('layouts.dashboard.main2')

@section('title')
Notification
@endsection

@section('notification', 'active')

@section('css')
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Notifikasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Notifikasi</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Notifikasi Gempa</h5>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">No.</th>
                            @can('notUser')
                            <th data-ordering="false">Name</th>
                            @endcan
                            <th data-ordering="false">Jarak</th>
                            <th data-ordering="false">Potensi</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($earthquakeNotif as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @can('notUser')
                            <td>{{ $item->user->name }}</td>
                            @endcan
                            <td>{{ $item->earthquake->potency }}</td>
                            <td>{{ $item->distance }} KM</td>
                            <td> {{ $item->created_at }} </td>
                            <td> <a href="{{ route('detail-notif-gempa', ['id' => Crypt::encrypt($item->id)]) }}" class="btn btn-primary">Detail</a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Notifikasi Banjir</h5>
            </div>
            <div class="card-body">
                <table id="myTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">No.</th>
                            @can('notUser')
                            <th data-ordering="false">Name</th>
                            @endcan
                            <th data-ordering="false">Jarak</th>
                            <th data-ordering="false">Level</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($floodNotif as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @can('notUser')
                            <td>{{ $item->user->name }}</td>
                            @endcan
                            <td>{{ $item->distance }} KM</td>
                            @if ($item->flood->level == 0)
                            <td> Normal </td>    
                            @endif
                            @if ($item->flood->level == 1)
                            <td> Siaga </td>    
                            @endif
                            @if ($item->flood->level == 2)
                            <td> Waspada</td>    
                            @endif
                            @if ($item->flood->level == 3)
                            <td> Awas </td>    
                            @endif
                            <td> {{ $item->created_at }} </td>
                            <td> <a href="{{ route('detail-notif-banjir', ['id' => Crypt::encrypt($item->id)]) }}" class="btn btn-primary">Detail</a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->



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


<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>
@endsection
