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
                    <li class="breadcrumb-item">EWS</li>
                    <li class="breadcrumb-item active">Show</li>
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
                <h5 class="card-title">Tambah EWS</h5>
                <div class="card-body">
                    <h5>Level Ketinggian Air:
                        <?php if($flood[0]->level == 0) { ?>
                        Normal
                        <?php } else if($flood[0]->level == 1) { ?>
                        Waspada
                        <?php} else if($flood[0]->level == 2) { ?>
                        Siaga
                        <?php } else { ?>
                        Awas
                        <?php } ?>
                    </h5>

                    <div class="text-center">
                        <h1>{{ $ews->name }}</h1>
                        <p>{{ $ews->location }}</p>
                        <p>Status : {{ $ews->status == 1 ? 'Active' : 'Non Active' }}</p>
                        @if ($ews->gmaps_link != null)
                        <div class="container text-center my-5 ratio ratio-16x9">
                            {{ $ews->gmaps_link }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h1>Grafik Ketinggian Air</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
