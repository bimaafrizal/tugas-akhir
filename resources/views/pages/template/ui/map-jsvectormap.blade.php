@extends('layouts.dashboard.main')

@section('vector', 'active')
@section('maps', 'active')

@section('title')
Vector Map
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>JS Vector Map</h3>
                <p class="text-subtitle text-muted">We use the <a
                        href="https://github.com/themustafaomar/jsvectormap" target="_blank">Jsvectormap</a>
                    plugin to create vector maps.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">JS Vector Map</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">World Map</h5>
                    </div>
                    <div class="card-body">
                        <div id="world-map" class="w-100" style="height: 450px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection