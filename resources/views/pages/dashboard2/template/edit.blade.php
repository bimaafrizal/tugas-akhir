@extends('layouts.dashboard.main2')

@section('title')
Template Notifikasi
@endsection

@section('template', 'active')


@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Template Notifikasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Template Notifikasi</li>
                    <li class="breadcrumb-item active">Edit</li>
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
                <h5 class="card-title mb-0">Edit Template</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('template.update', ['id' => encrypt($data->id)]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Bencana*</label>
                        <input type="text" class="form-control @error('disaster_id') is-invalid
                        @enderror" id="disaster_id" name="disaster_id" value="{{ old('disaster_id', $data->disaster->name) }}" readonly>
                        @error('disaster_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="strength" class="form-label">Isi Notifikasi*</label>
                        <br>
                        <small class="bg-white text-danger">Perthatian!! jika ingin menghapus inputan pilihan(tombol biru) hapus semua kareakter dari $ sampai akhit karakter inputan pilihan contoh $level maka hapus '$' dan 'level'</small> <br>
                        <small class="bg-white text-danger">Jangan merubah atau menambah karakter input pilihan(tombol biru), contoh $level jangan dirubah $level1</small>
                        <br>
                        <div class="my-1">
                            <?php if($data->disaster_id == 1) { ?>
                                <button type="button" class="badge text-bg-primary option">Level</button>
                                <button type="button" class="badge text-bg-primary option">Jarak</button>
                                <button type="button" class="badge text-bg-primary option">Unit EWS</button>
                            <?php } else if($data->disaster_id == 2) { ?>
                                    <button type="button" class="badge text-bg-primary option2">Longitude</button>
                                    <button type="button" class="badge text-bg-primary option2">Latitude</button>
                                    <button type="button" class="badge text-bg-primary option2">Kedalaman</button>
                                    <button type="button" class="badge text-bg-primary option2">Kekuatan</button>
                                    <button type="button" class="badge text-bg-primary option2">Jarak</button>
                            <?php } else { ?>
                                    <button type="button" class="badge text-bg-primary option3">Cuaca</button>
                                    <button type="button" class="badge text-bg-primary option3">Suhu</button>
                                    <button type="button" class="badge text-bg-primary option3">Suhu Terasa</button>
                                    <button type="button" class="badge text-bg-primary option3">Tanggal</button>
                            <?php }  ?>
                        </div>
                        <textarea name="body" class="form-control @error('body') is-invalid
                        @enderror" id="body" cols="30" rows="10">{{ old('body', $data->body) }}</textarea>
                        @error('body')
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
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection


@section('script')

<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>

    <script>
        $(document).ready(function () { 
            $('.option').click(function() {
                let body = $('#body');
                let currentValue = body.val();
                let option = $(this).text();

                if(option == "Level") {
                    option = "$level"
                } else if(option == 'Jarak') {
                    option = "$distance"
                } else if(option == 'Unit EWS') {
                    option = "$ews_name"
                }

                let selectionStart = body.prop('selectionStart');
                let selectionEnd = body.prop('selectionEnd');
                let updatedValue = currentValue.substring(0, selectionStart) +  option + currentValue.substring(selectionEnd);

                $('#body').val(updatedValue);
            });
            
            $('.option2').click(function() {
                let body = $('#body');
                let currentValue = body.val();
                let option = $(this).text();

                if(option == "Longitude") {
                    option = "$longitude"
                } else if(option == 'Latitude') {
                    option = "$latitude";
                } else if(option == 'Kedalaman') {
                    option = "$depth"
                }  else if(option == 'Kekuatan') {
                    option = "$strength";
                } else if(option == 'Jarak') {
                    option = "$distance";
                }

                let selectionStart = body.prop('selectionStart');
                let selectionEnd = body.prop('selectionEnd');
                let updatedValue = currentValue.substring(0, selectionStart) + option + currentValue.substring(selectionEnd);

                $('#body').val(updatedValue);
            });

            $('.option3').click(function() {
                let body = $('#body');
                let currentValue = body.val();
                let option = $(this).text();

                if(option == "Cuaca") {
                    option = "$cuaca"
                } else if(option == 'Suhu') {
                    option = " $temp";
                } else if(option == 'Suhu Terasa') {
                    option = "$feels_like"
                }  else if(option == 'Tanggal') {
                    option = "$dt_txt";
                } 

                let selectionStart = body.prop('selectionStart');
                let selectionEnd = body.prop('selectionEnd');
                let updatedValue = currentValue.substring(0, selectionStart) + option + currentValue.substring(selectionEnd);
                
                $('#body').val(updatedValue);
            });
        });

    </script>

@endsection
