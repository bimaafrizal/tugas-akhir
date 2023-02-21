<div>
    <form wire:submit.prevent="update">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label for="name" class="form-label">Name Kategory Article</label>
                    <input type="text" class="form-control @error('name') is-invalid
                        @enderror" id="name" wire:model="name">
                    @error('name')
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
    </form>
</div>
</div>
