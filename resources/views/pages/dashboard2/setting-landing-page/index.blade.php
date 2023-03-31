@extends('layouts.dashboard.main2')

@section('title')
Setting Landing Page
@endsection

@section('landing-page', 'active')

@section('css')
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Setting Landing Page</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Setting Landing Page</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pill-justified-home-1" role="tab">
                            Home
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-profile-1" role="tab">
                            About
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-messages-1" role="tab">
                            Fitur
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-settings-1" role="tab">
                            Kerja Sama
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-footer" role="tab">
                            Footer
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="pill-justified-home-1" role="tabpanel">
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <form action="{{ route('landing-page.home-edit') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('auth/assets/images/home.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="title" class="form-label">Title(Kotak Merah)*</label>
                                <input type="text" class="form-control @error('title') is-invalid
                            @enderror" id="title" name="title" value="{{ old('title', $page->title) }}">
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Subtitle(Kotak Hijau)*</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid
                            @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}">
                                @error('subtitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image_title" class="form-label">Image 1(Kotak Orange)</label>
                                <input type="file" class="form-control @error('image_title') is-invalid
                            @enderror" id="image_title" name="image_title">
                                @error('image_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image_title2" class="form-label">Image 2(Kotak Ungu)</label>
                                <input type="file" class="form-control @error('image_title2') is-invalid
                            @enderror" id="image_title2" name="image_title2">
                                @error('image_title2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid
                            @enderror" id="logo" name="logo">
                                @error('logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="pill-justified-profile-1" role="tabpanel">
                        <form action="{{ route('landing-page.about-edit') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('auth/assets/images/home2.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="title_about1" class="form-label">Title About 1(Kotak Merah)*</label>
                                <input type="text" class="form-control @error('title_about1') is-invalid
                            @enderror" id="title_about1" name="title_about1"
                                    value="{{ old('title_about1', $page->title_about1) }}">
                                @error('title_about1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="about1" class="form-label">About 1(Kotak Ungu)*</label>
                                <textarea id="about1" name="about1" cols="30" rows="5" class="form-control @error('about1') is-invalid
                                @enderror">{{ old('about1', $page->about1) }}</textarea>
                                @error('about1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image1" class="form-label">Image 1(Kotak Hijau)</label>
                                <input type="file" class="form-control @error('image1') is-invalid
                            @enderror" id="image1" name="image1" value="{{ old('image1') }}">
                                @error('image1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="title_about2" class="form-label">Title About 2(Kotak Orange)*</label>
                                <input type="text" class="form-control @error('title_about2') is-invalid
                            @enderror" id="title_about2" name="title_about2"
                                    value="{{ old('title_about2', $page->title_about2) }}">
                                @error('title_about2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="about2" class="form-label">About 2(Kotak Biru)*</label>
                                <textarea id="about2" name="about2" cols="30" rows="5" class="form-control @error('about2') is-invalid
                                @enderror">{{ old('about2', $page->about2) }}</textarea>
                                @error('about2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image2" class="form-label">Image 2(Kotak Pink)</label>
                                <input type="file" class="form-control @error('image2') is-invalid
                            @enderror" id="image2" name="image2" value="{{ old('image2') }}">
                                @error('image2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="pill-justified-messages-1" role="tabpanel">
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('landing-page.create-fitur') }}" class="btn btn-primary">Tambah Fitur</a>
                        </div>
                        <div class="mt-2">
                            <table id="example"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">No.</th>
                                        <th data-ordering="false">Nama</th>
                                        <th>Body</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fiturs as $fitur)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $fitur->title }}</td>
                                        <td>{{ $fitur->body }}</td>
                                        <div class="text-center">
                                            <td>  {!! $fitur->logo !!}</td>
                                        </div>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="{{ route('landing-page.edit-fitur', ['id' => encrypt($fitur->id)]) }}" class="dropdown-item edit-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('landing-page.delete-fitur', ['id' => encrypt($fitur->id)]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item edit-item-btn"><i
                                                            class=" ri-chat-delete-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                        </form>
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
                    <div class="tab-pane" id="pill-justified-settings-1" role="tabpanel">
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('landing-page.create-instansi') }}" class="btn btn-primary">Tambah Instansi</a>
                        </div>
                        <div class="mt-2">
                            <table id="table2"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">No.</th>
                                        <th data-ordering="false">Nama</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collabs as $collab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $collab->title }}</td>
                                        <div class="text-center">
                                            <td>  <img src="{{ asset($collab->logo) }}" alt="" style="max-width: 20%; max-height: 20%" class="img-fluid"> </td>
                                        </div>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="{{ route('landing-page.edit-instansi', ['id' => encrypt($collab->id)]) }}" class="dropdown-item edit-item-btn"><i
                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                            Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('landing-page.delete-instansi', ['id' => encrypt($collab->id)]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item edit-item-btn"><i
                                                            class=" ri-chat-delete-fill align-bottom me-2 text-muted"></i>
                                                            Delete</button>
                                                        </form>
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
                    <div class="tab-pane" id="pill-justified-footer" role="tabpanel">
                        <form action="{{ route('landing-page.footer-edit') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('auth/assets/images/home3.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="footer" class="form-label">Footer(Kotak Pink)*</label>
                                <input type="text" class="form-control @error('footer') is-invalid
                            @enderror" id="footer" name="footer" value="{{ old('footer', $page->footer) }}">
                                @error('footer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Link Twitter(Kotak Orange)</label>
                                <input type="text" class="form-control @error('twitter') is-invalid
                            @enderror" id="twitter" name="twitter" value="{{ old('twitter', $page->twitter) }}">
                                @error('twitter')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Link Facebook(Kotak Hijau)</label>
                                <input type="text" class="form-control @error('facebook') is-invalid
                            @enderror" id="facebook" name="facebook" value="{{ old('facebook', $page->facebook) }}">
                                @error('facebook')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Link Instagram(Kotak Ungu)</label>
                                <input type="text" class="form-control @error('instagram') is-invalid
                            @enderror" id="instagram" name="instagram"
                                    value="{{ old('instagram', $page->instagram) }}">
                                @error('instagram')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">Link Linkedin(Kotak Merah)</label>
                                <input type="text" class="form-control @error('linkedin') is-invalid
                            @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $page->linkedin) }}">
                                @error('linkedin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
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

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>

@endsection
