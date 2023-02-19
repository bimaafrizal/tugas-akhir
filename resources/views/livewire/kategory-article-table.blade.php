<div>
    <div class="table-responsive">
        <div class="d-flex justify-content-start mb-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-kategory">Tambah
                Permintaan</button>
        </div>
        <table id="myTable" class="table  table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategories as $kategory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategory->name }}</td>
                    <td>
                        <span class="badge bg-success">Active</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
