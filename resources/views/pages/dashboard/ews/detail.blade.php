@extends('layouts.dashboard.main')

@section('ews', 'active')

@section('title')
Detail EWS
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
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">EWS</li>
                        <li class="breadcrumb-item active" aria-current="page">EWS Detail</li>
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
                <input type="text" name="" id="id" value="{{ $ews->id }}" hidden>
                <div class="text-start">
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
                </div>
                <div class="text-center">
                    <h1>{{ $ews->name }}</h1>
                    <small>{{ $ews->location }}</small>
                    <p>Status : {{ $ews->status == 1 ? 'Active' : 'Non Active' }}</p>
                    @if ($ews->gmaps_link != null)
                    <div class="container text-center my-5 ratio ratio-16x9">
                        {{ $ews->gmaps_link }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h1>Grafik Ketinggian Air</h1>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("chart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Level',
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    var updateChart = function () {
        let idEws = $('#id').val();
        console.log(idEws);
        $.ajax({
            url: "{{ route('ews.get-data') }}",
            type: 'get',
            data: {
                id: idEws
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                // myChart.data.labels = data.labels;
                // myChart.data.datasets[0].data = data.data;
                // myChart.update();

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    updateChart();
    setInterval(() => {
        updateChart();
    }, 60000);

</script>
<script>
    //   let idEws = $('#id').val();
    // $(function () {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     let id = $('#id').val();
    //     console.log(id);
    //     $(function () {
    //         $.ajax({
    //             type: 'POST',
    //             url: "{{ route('ews.get-data') }}",
    //             // data: {
    //             //     id: id,
    //             // },
    //             cache: false,

    //             success: function (msg) {
    //                 console.log(msg);
    //             },
    //             error: function (data) {
    //                 console.log('error: ', data)
    //             }
    //         });
    //     })
    // });
    // console.log(idEws);
    // let updateChart = function () {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('ews.get-data') }}",
    //         data: {
    //             id: idEws
    //         },
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function (data) {
    //             // console.log(id);
    //             console.log(data);
    //             // chart.data.labels = data.labels;
    //             // chart.datasets[0].data = data.data;
    //             // chart.update();
    //         },
    //         error: function (data) {
    //             console.log(data);
    //         }
    //     });
    // }
    // updateChart();
    // setInterval(() => {
    //     updateChart();
    // }, 60000);

</script>
@endpush
