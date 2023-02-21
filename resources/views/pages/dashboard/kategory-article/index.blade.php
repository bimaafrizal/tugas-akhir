@extends('layouts.dashboard.main')

@section('kategory-article', 'active')

@section('title')
Kategori Article
@endsection

@push('styles')
@livewireStyles
<script src="https://cdn.jsdelivr.net/npm/livewire@2.4.3/dist/livewire.js"></script>
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>DataTable</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable</li>
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
                @livewire('kategory-article-table')
            </div>
        </div>

    </section>
</div>

@livewire('create-kategory-article')

<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

</script>
<script>
    window.addEventListener('close-modal', event => {
        $('#create-kategory').modal('hide');
    })

</script>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('refresh-datatable', function () {
            Livewire.hook('afterDomUpdate', function () {
                // Initialize DataTables in the $nextTick callback
                Livewire.once('afterDomUpdate', () => {
                    const table = $('#myTable').DataTable();
                });
            });
        });
    });

</script>
@endsection
