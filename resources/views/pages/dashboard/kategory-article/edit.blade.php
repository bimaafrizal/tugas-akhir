@extends('layouts.dashboard.main')

@section('kategory-article', 'active')

@section('title')
Kategori Article
@endsection

@push('styles')
@livewireStyles
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Kategori</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Kategory Article</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Kategory Article</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                @livewire('edit-katagory-article', ['data' => $data])
            </div>
        </div>
    </section>
</div>
@endsection