@extends('layouts.dashboard.main')

@section('article', 'active')

@section('title')
Crate Article
@endsection

@push('trix')
{{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script> --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-ext-table.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-ext-table.min.js"></script> --}}
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('trix/trix.css') }}">
<script type="text/javascript" src="{{ asset('trix/trix.js') }}"></script> --}}
@endpush

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Create Article</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Article</li>
                        <li class="breadcrumb-item active" aria-current="page">Create Article</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">Title*</label>
                                    <input type="text" class="form-control @error('title') is-invalid
                                    @enderror" id="title" name="title" value="{{ old('title') }}">
                                    <input type="hidden" class="form-control" id="slug" name="slug" required 
                                        value="{{ old('slug') }}">
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
                                            <option value="{{ $item->id }}" @if (old('kategory_article_id')==$item->id)
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
                                    {{old('body') }}
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
    // ClassicEditor
    //     .create(document.querySelector('#body-content'), {
    //         toolbar: {
    //             items: [
    //                 'heading',
    //                 '|',
    //                 'bold',
    //                 'italic',
    //                 'link',
    //                 '|',
    //                 'imageUpload',
    //                 'mediaEmbed',
    //                 '|',
    //                 'undo',
    //                 'redo'
    //             ]
    //         },
    //         language: 'en',
    //         image: {
    //             toolbar: [
    //                 'imageTextAlternative',
    //                 '|',
    //                 'imageStyle:full',
    //                 'imageStyle:side',
    //                 '|',
    //                 'linkImage'
    //             ],
    //             upload: {
    //                 url: '{{route("images-upload")}}',
    //                 method: 'POST',
    //                 withCredentials: true,
    //                 headers: {
    //                     'X-CSRF-Token': '{{ csrf_token() }}',
    //                     'Accept': 'application/json'
    //                 }
    //             }
    //         }
    //     })
    //     .then(editor => {
    //         console.log(editor);
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });
    // $(document).ready(function () {
    // $('#body-content').summernote({
    //     codemirror: {
    //         mode: 'text/html',
    //         htmlMode: true,
    //         lineNumbers: true,
    //         theme: 'monokai'
    //     },
    //     toolbar: [
    //         // Define a custom toolbar
    //         ['style', ['style']],
    //         ['font', ['bold', 'italic', 'underline', 'clear']],
    //         ['fontname', ['fontname']],
    //         ['color', ['color']],
    //         ['para', ['ul', 'ol', 'paragraph']],
    //         ['height', ['height']],
    //         ['table', ['table']],
    //         ['insert', ['link', 'picture', 'video']],
    //         ['view', ['fullscreen', 'codeview', 'help']]
    //     ]
    // popover: {
    //     image: [
    //         ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
    //         ['float', ['floatLeft', 'floatRight', 'floatNone']],
    //         ['remove', ['removeMedia']]
    //     ],
    //     link: [
    //         ['link', ['linkDialogShow', 'unlink']]
    //     ],
    //     table: [
    //         ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
    //         ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
    //     ],
    //     air: [
    //         ['color', ['color']],
    //         ['font', ['bold', 'underline', 'clear']],
    //         ['para', ['ul', 'paragraph']],
    //         ['table', ['table']],
    //         ['insert', ['link', 'picture']]
    //     ]
    // },
    // fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
    // styleTags: [
    //     'p',
    //     {
    //         title: 'Blockquote',
    //         tag: 'blockquote',
    //         className: 'blockquote',
    //         value: 'blockquote'
    //     },
    //     'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
    // ],
    // lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0',
    //     '3.0'
    // ]
    // });
    // });
    // class MyUploadAdapter {
    //     constructor(loader) {
    //         this.loader = loader;
    //     }

    //     upload() {
    //         return this.loader.file
    //             .then(file => new Promise((resolve, reject) => {
    //                 this._initRequest();
    //                 this._initListeners(resolve, reject, file);
    //                 this._sendRequest(file);
    //             }));
    //     }

    //     abort() {
    //         if (this.xhr) {
    //             this.xhr.abort();
    //         }
    //     }

    //     _initRequest() {
    //         const xhr = this.xhr = new XMLHttpRequest();

    //         xhr.open('POST', "{{route('images-upload', ['_token' => csrf_token() ])}}", true);
    //         xhr.responseType = 'json';
    //     }

    //     _initListeners(resolve, reject, file) {
    //         const xhr = this.xhr;
    //         const loader = this.loader;
    //         const genericErrorText = `Couldn't upload file: ${ file.name }.`;

    //         xhr.addEventListener('error', () => reject(genericErrorText));
    //         xhr.addEventListener('abort', () => reject());
    //         xhr.addEventListener('load', () => {
    //             const response = xhr.response;

    //             if (!response || response.error) {
    //                 return reject(response && response.error ? response.error.message : genericErrorText);
    //             }

    //             resolve(response);
    //         });

    //         if (xhr.upload) {
    //             xhr.upload.addEventListener('progress', evt => {
    //                 if (evt.lengthComputable) {
    //                     loader.uploadTotal = evt.total;
    //                     loader.uploaded = evt.loaded;
    //                 }
    //             });
    //         }
    //     }

    //     _sendRequest(file) {
    //         const data = new FormData();

    //         data.append('upload', file);

    //         this.xhr.send(data);
    //     }
    // }

    // function MyCustomUploadAdapterPlugin(editor) {
    //     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
    //         return new MyUploadAdapter(loader);
    //     };
    // }

</script>
{{-- <script>
    CKEDITOR.replace('body-content', {
        filebrowserUploadUrl: "{{route('images-upload', ['_token' => csrf_token() ])}}",
filebrowserUploadMethod: 'form'
});
</script> --}}
@endsection

{{-- @push('attachment-file')
    <script>
        (function() {
            var HOST = "{{ route('images-upload') }}"; //pass the route

addEventListener("trix-attachment-add", function(event) {
if (event.attachment.file) {
uploadFileAttachment(event.attachment)
}
})

function uploadFileAttachment(attachment) {
uploadFile(attachment.file, setProgress, setAttributes)

function setProgress(progress) {
attachment.setUploadProgress(progress)
}

function setAttributes(attributes) {
attachment.setAttributes(attributes)
}
}

function uploadFile(file, progressCallback, successCallback) {
var formData = createFormData(file);
var xhr = new XMLHttpRequest();

xhr.open("POST", HOST, true);
xhr.setRequestHeader('X-CSRF-TOKEN', getMeta('csrf-token'));

xhr.upload.addEventListener("progress", function(event) {
var progress = event.loaded / event.total * 100
progressCallback(progress)
})

xhr.addEventListener("load", function(event) {
var attributes = {
url: xhr.responseText,
href: xhr.responseText + "?content-disposition=attachment"
}
successCallback(attributes)
})

xhr.send(formData)
}

function createFormData(file) {
var data = new FormData()
data.append("Content-Type", file.type)
data.append("file", file)
return data
}

function getMeta(metaName) {
const metas = document.getElementsByTagName('meta');

for (let i = 0; i < metas.length; i++) { if (metas[i].getAttribute('name')===metaName) { return
    metas[i].getAttribute('content'); } } return '' ; } })(); </script> @endpush --}}
