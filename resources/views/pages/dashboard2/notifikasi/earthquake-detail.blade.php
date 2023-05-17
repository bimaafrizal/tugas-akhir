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
                    <li class="breadcrumb-item active">Notifikasi Gempa</li>
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
                
               <p class="text-wrap" style="text-align: justify">User berada pada jarak {{ $data->distance }} km dari titik gempa. Gempa berada pada kedalaman {{ $data->earthquake->depth }} dengan kekuatan {{ $data->earthquake->strength }}, pukul {{ $data->earthquake->time }}, {{ $data->earthquake->date }}
            </p>

            <div class="d-flex justify-content-start">
                <a href="{{ route('earthquake.show', ['id' => Crypt::encrypt($data->earthquake_id)]) }}" class="btn btn-primary">Detail Gempa</a>
            </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>



@endsection

