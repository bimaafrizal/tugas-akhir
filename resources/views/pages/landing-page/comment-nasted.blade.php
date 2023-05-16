<li class="comment">
    @foreach ($comments as $comment)
    <div class="comment-body">
        <h3>{{ $comment->user->name }}</h3>
        <div class="meta">{{ $comment->created_at }}</div>
        <p>{{ $comment->body }}</p>
        <p> <a data-bs-toggle="collapse" href="#collapseEdit{{ $comment->id }}" role="button" aria-expanded="false"
            aria-controls="collapseExample" class="reply">Reply</a> </p>
            <div class="collapse" id="collapseEdit{{ $comment->id }}">
                <div class="card card-body">
                    <form action="{{ route('nasted-comment-store', ['slug' => $slug, 'id' => $comment->id]) }}" method="POST">
                        @csrf
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id=""
                            cols="30" rows="2">{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <ul class="children">
        @if ($comment->children->count())
        @include('pages.landing-page.comment-nasted', ["comments" => $comment->children, 'slug' => $article->slug])
        @endif
    </ul>
    @endforeach
</li>
