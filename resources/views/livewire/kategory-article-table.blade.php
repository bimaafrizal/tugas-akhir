<div>
    <div class="table-responsive">
        <div class="d-flex justify-content-start mb-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-kategory">Tambah
                Kategori</button>
        </div>
        <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
            style="width:100%">
            <thead>
                <tr>
                    <th data-ordering="false">No.</th>
                    <th data-ordering="false">Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategories as $kategory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategory->name }}</td>
                    <td>
                        @if ($kategory->status == 1)
                        Active
                        @else
                        Non Active
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-warning"
                            href="{{ route('kategory-edit', ['id' => encrypt($kategory->id)]) }}">Edit</a>
                        @if ($kategory->status == 1)
                        <form class="d-inline"
                            wire:submit.prevent="editStatus({{ $kategory->id }}, {{ $kategory->status }})">
                            <button class="btn btn-danger">Non Active</button>
                        </form>
                        @else
                        <form class="d-inline"
                            wire:submit.prevent="editStatus({{ $kategory->id }}, {{ $kategory->status }})">
                            <button class="btn btn-success">Active</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
