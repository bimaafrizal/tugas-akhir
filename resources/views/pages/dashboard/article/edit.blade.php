@extends('layouts.dashboard.main')

@section('article', 'active')

@section('title')
Edit Article
@endsection

@push('trix')

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
@endpush

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Article</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Article</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Article</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('article.update', ['slug' => $article->slug]) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">Title*</label>
                                    <input type="text" class="form-control @error('title') is-invalid
                                    @enderror" id="title" name="title" value="{{ old('title', $article->title) }}">
                                    <input type="hidden" class="form-control" id="slug" name="slug" required
                                        value="{{ old('slug', $article->slug) }}">
                                    <input type="hidden" class="form-control" id="oldSlug" name="oldSlug" required
                                        value="{{ old('slug', $article->slug) }}">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="cover" class="form-label">Cover*</label>
                                    <input type="file" class="form-control @error('cover') is-invalid
                                    @enderror" id="cover" name="cover">
                                    @error('cover')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="kategory_article_id" class="form-label">Kategory Article</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" name="kategory_article_id" id="kategory_article_id">
                                            <option>Pilih kategory</option>
                                            @foreach ($kategories as $item)
                                            <option value="{{ $item->id }}" @if (old('kategory_article_id', $article->kategory_article_id) == $item->id)
                                                selected
                                                @endif >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="body" class="form-label">Body*</label>
                                    <textarea type="text" name="body" class="form-control @error('body') is-invalid
                                    @enderror" id="body-content">
                                    {{ old('body', $article->body) }}
                                </textarea>
                                    {{-- <trix-editor input="body"></trix-editor> --}}
                                    @error('body')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');
    title.addEventListener('change', function () {
        fetch('/check-slug?title=' + title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        console.log(slug.value);
    });

    
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#body-content'), {
            ckfinder: {
                uploadUrl: "{{route('images-upload').' ? _token = '.csrf_token()}}",
            }
        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
