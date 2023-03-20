@extends('layouts.dashboard.main2')

@section('title')
EWS
@endsection

@section('ews', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">EWS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">EWS</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="d-flex justify-content-start mb-2">
        <a href="{{ route('ews.create') }}" class="btn btn-primary">Tambah EWS</a>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    @foreach ($datas as $data)
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data->name }}</h5>
                <p class="card-text">
                    {{ $data->location }}
                    <br>
                    Status : {{ $data->status == 1 ? 'Active' : 'Non Active' }}
                </p>
                <div class="d-flex justify-content-end">
                    <div class="mx-1">
                        <a href="{{ route('ews.edit', ['id' => encrypt($data->id)]) }}" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="mx-1">
                        <a href="{{ route('ews.show', ['ew' => encrypt($data->id)]) }}" class="btn btn-secondary">Detail</a>
                    </div>
                    <div class="mx-1">
                        @if ($data->status == 1)
                            <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="0">
                                <button type="submit" class="btn btn-danger">Non Active</button>
                            </form>
                            @else
                            <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="1">
                                <button type="submit" class="btn btn-info">Active</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('script')
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
