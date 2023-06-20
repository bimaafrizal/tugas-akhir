@extends('layouts.dashboard.main2')

@section('title')
Notification
@endsection

@section('notification', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Notifikasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Notifikasi</li>
                    <li class="breadcrumb-item active">Notifikasi Banjir</li>
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
                <h5 class="card-title mb-0">Notifikasi Banjir</h5>
            </div>
            <div class="card-body">
                @can('notUser')
                <p class="text-wrap" style="text-align: justify">User berada pada jarak {{ $data->distance }} km saat anda berada di titik lokasi {{ $data->user_latitude }}, {{ $data->user_longitude }} dari alat pemantauan {{ $data->flood->ews->name }} dengan kondisi berada di level 
                 <?php if($data->flood->level == 0) { ?>
                     Aman
                 <?php } else if($data->flood->level == 1) { ?>
                     Siaga
                 <?php } else if($data->flood->level == 2) { ?>
                     Waspada
                 <?php } else if($data->flood->level == 3) { ?>
                     Awas
                 <?php } ?>
                </p>
                @endcan
                @can('user')
                <p class="text-wrap" style="text-align: justify">Anda berada pada jarak {{ $data->distance }} km saat anda berada di titik lokasi {{ $data->user_latitude }}, {{ $data->user_longitude }} dari alat pemantauan {{ $data->flood->ews->name }} dengan kondisi berada di level 
                 <?php if($data->flood->level == 0) { ?>
                     Aman
                 <?php } else if($data->flood->level == 1) { ?>
                     Siaga
                 <?php } else if($data->flood->level == 2) { ?>
                     Waspada
                 <?php } else if($data->flood->level == 3) { ?>
                     Awas
                 <?php } ?>
                </p>
                @endcan
            </div>
        </div>
    </div>
    <!--end col-->
</div>



@endsection

