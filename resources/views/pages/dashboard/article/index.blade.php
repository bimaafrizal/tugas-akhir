@extends('layouts.dashboard.main')

@section('article', 'active')

@section('title')
Article
@endsection

@push('styles')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Article</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Article</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-start mb-2">
                        <a href="{{ route('article.create') }}" class="btn btn-primary">Tambah
                            Article</a>
                    </div>
                    <table id="myTable" class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $article->title }}</td>
                                <td>{{ Str::limit(strip_tags($article->body), 50, '...') }}</td>
                                @if ($article->is_active == 1)
                                <td>Active</td>
                                @else
                                <td>Non Active</td>
                                @endif
                                <td>
                                    <a href="" class="btn btn-info mb-1">Show</a>
                                    <a href="{{ route('article.edit', ['slug' => $article->slug]) }}" class="btn btn-warning mb-1">Edit</a>
                                    @if ($article->is_active == 1)
                                    <form action="{{ route('article.edit-status', ['slug' => $article->slug]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="is_active" value="0" id="">
                                        <button type="submit" class="btn btn-danger mb-1">Non Active</button>
                                    </form>
                                    @else
                                    <form action="{{ route('article.edit-status', ['slug' => $article->slug]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="is_active" value="1" id="">
                                        <button type="submit" class="btn btn-success mb-1">Non Active</button>
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
