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
        <div class="card">
            <div class="card-header">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-start mb-2">
                        <a href="{{ route('ews.create') }}" class="btn btn-primary">Tambah
                            EWS</a>
                    </div>
                    <table id="myTable" class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>API URL</th>
                                <th>API Key</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Gmaps Link</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $data->name }} </td>
                                <td>{{ $data->location != null ? $data->location : '-' }}  </td>
                                <td>{{ $data->api_url }}  </td>
                                <td>{{ $data->api_key != null ? $data->api_key : '-' }}  </td>
                                <td>{{ $data->longitude != null ? $data->longitude : '-' }}  </td>
                                <td>{{ $data->latitude != null ? $data->latitude : '-' }}  </td>
                                <td>{{ $data->gmaps_link != null ? $data->gmaps_link : '-' }}  </td>
                                <td>{{ $data->status == 1 ? 'Active' : 'Non Active' }}  </td>
                                <td>
                                    <a href="{{ route('ews.edit', ['id' => encrypt($data->id)]) }}" class="btn btn-warning">Edit</a>
                                    @if ($data->status == 1)      
                                    <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="is_active" value="0">
                                        <button type="submit" class="btn btn-danger">Non Active</button>
                                    </form>
                                    @else
                                    <form action="{{ route('ews.edit-status', ['id' => encrypt($data->id)]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn btn-info">Active</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>
@endsection
