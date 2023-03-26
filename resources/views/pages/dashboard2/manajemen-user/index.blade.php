@extends('layouts.dashboard.main2')

@section('title')
Manajemen User
@endsection

@section('manajemen-user', 'active')

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
            <h4 class="mb-sm-0">Manajemen User</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Manajemen User</li>
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
                <h5 class="card-title mb-0">Daftar Admin</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start mb-2">
                    <div class="mx-1">
                        <a href="{{ route('manajemen-user.create') }}" class="btn btn-primary">Tambah Admin</a>
                    </div>
                    <div class="mx-1">
                        <a href="{{ route('manajemen-user.download', ['id' => Crypt::encrypt($admins[0]->role_id)]) }}" class="btn btn-success">Download Data Admin</a>
                    </div>
                </div>
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
                            <th data-ordering="false">Name</th>
                            <th>Email</th>
                            <th>Nomor Hp</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone_num }}</td>
                            <td>{{ $admin->role->name }}</td>
                            <td> @if ($admin->status == 1)
                                <span class="badge badge-soft-success">Active</span>
                                @else
                                <span class="badge badge-soft-warning">Non Active</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="{{ route('manajemen-user.edit', ['id' => encrypt($admin->id)]) }}" class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                        </li>
                                        @if ($admin->status == 1)
                                        <form action="{{ route('manajemen-user.edit-status', ['id' => encrypt($admin->id) ]) }}" method="POST" class="d-inline">
                                            <li>
                                                <button type="submit" class="dropdown-item remove-item-btn">
                                                    @csrf
                                                    <input type="hidden" name="is_active" value="0" id="">
                                                    <i class="ri-eye-close-fill align-bottom me-2 text-muted">
                                                        Non Active
                                                    </i>
                                                </button>
                                            </li>
                                        </form>
                                        @else
                                        <form action="{{ route('manajemen-user.edit-status', ['id' => encrypt($admin->id) ]) }}" method="POST" class="d-inline">
                                            <li>
                                                <button type="submit" class="dropdown-item remove-item-btn">

                                                    <i class=" ri-eye-fill align-bottom me-2 text-muted">
                                                        @csrf
                                                        <input type="hidden" name="is_active" value="1" id="">
                                                    </i> Active
                                                </button>
                                            </li>
                                        </form>
                                        @endif
                                    </ul>
                                </div>
                            </td>
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
                <h5 class="card-title mb-0">Daftar User</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start mb-2">
                    <a href="{{ route('manajemen-user.download', ['id' => Crypt::encrypt($users[0]->role_id)]) }}" class="btn btn-success">Download Data User</a>
                </div>
                <table id="myTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">No.</th>
                            <th data-ordering="false">Name</th>
                            <th>Email</th>
                            <th>Nomor Hp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_num }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="{{ route('manajemen-user.edit', ['id' => encrypt($user->id)]) }}" class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
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
