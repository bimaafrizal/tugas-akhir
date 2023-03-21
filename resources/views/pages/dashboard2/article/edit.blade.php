@extends('layouts.dashboard.main2')

@section('title')
Article
@endsection

@section('article', 'active')

@section('css')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Article</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Article</li>
                    <li class="breadcrumb-item active">Edit</li>
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
                <h5 class="card-title">Edit Article</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('article.update', ['slug' => $article->slug]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title*</label>
                            <input type="text" class="form-control @error('title') is-invalid
                            @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <input type="text" class="form-control" id="slug" name="slug" required 
                            value="{{ old('slug', $article->slug) }}" hidden>
                            <input type="hidden" class="form-control" id="oldSlug" name="oldSlug" required
                            value="{{ old('slug', $article->slug) }}">
                        </div>
                        <div class="mb-3">
                            <label for="cover" class="form-label">Cover*</label>
                            <input type="file" class="form-control @error('cover') is-invalid
                                    @enderror" id="cover" name="cover">
                            @error('cover')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="api_url" class="form-label">Kategory Article*</label>
                            <select class="form-control" data-choices name="kategory_article_id"
                                id="choices-single-default">
                                <option>Pilih kategory</option>
                                @foreach ($kategories as $item)
                                <option value="{{ $item->id }}" @if (old('kategory_article_id', $article->kategory_article_id)==$item->id)
                                    selected
                                    @endif >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body*</label>
                            <textarea type="text" name="body" class="form-control @error('body') is-invalid
                                    @enderror" id="body-content">
                                    {{ old('body', $article->body) }}
                                </textarea>
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
    </div>
</div>
@endsection

@section('script')
<script>
        const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');
    title.addEventListener('change', function () {
        fetch('/check-slug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
        console.log(slug.value);
    });

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

<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
