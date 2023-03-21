@extends('layouts.dashboard.main2')

@section('title')
Kategory Article
@endsection

@push('styles')
@livewireStyles
<script src="https://cdn.jsdelivr.net/npm/livewire@2.4.3/dist/livewire.js"></script>
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('kategory-article', 'active')

@section('content')
    <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Kategory Article</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Kategory Article</li>
                    <li class="breadcrumb-item active">Edit Kategory Article</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @livewire('edit-katagory-article', ['data' => $data])
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection