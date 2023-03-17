@extends('layouts.dashboard.main')

@section('ews', 'active')

@section('title')
EWS
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>EWS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">EWS</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="d-flex justify-content-start">
            <a href="{{ route('ews.create') }}" class="btn btn-primary mb-2">Add EWS</a>
        </div>
        <div class="row">
            @foreach ($datas as $data)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->name }}</h4>
                            <p class="card-text">
                                {{ $data->location }}
                            </p>
                            <p>
                                Status: {{ $data->status == 1 ? 'Active' : 'Non Active' }}
                            </p>
                            @if ($data->gmaps_link != null)
                            <div class="container text-center my-5 ratio ratio-16x9">
                                {{ $data->gmaps_link }}
                            </div>
                            @endif
                            <div class="d-flex justify-content-end">
                                <div class="mx-1">
                                    <a href="{{ route('ews.edit', ['id' => encrypt($data->id)]) }}"
                                        class="btn btn-warning">Edit</a>
                                </div>
                                <div class="mx-1">
                                    <a href="{{ route('ews.show', ['ew' => encrypt($data->id)]) }}"
                                        class="btn btn-primary">Detail</a>
                                </div>
                                @if ($data->status == 1)
                                <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}"
                                    method="POST" class="d-inline mx-1">
                                    @csrf
                                    <input type="hidden" name="is_active" value="0">
                                    <button type="submit" class="btn btn-danger">Non Active</button>
                                </form>
                                @else
                                <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}"
                                    method="POST" class="d-inline mx-1">
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
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>
@endsection
