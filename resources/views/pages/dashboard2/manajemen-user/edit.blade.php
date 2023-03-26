@extends('layouts.dashboard.main2')

@section('title')
Manajemen User
@endsection

@section('manajemen-user', 'active')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Manajemen User</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item">Manajemen User</li>
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
                <h5 class="card-title">Edit Admin</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('manajemen-user.update', ['id' => encrypt($data->id)]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control @error('name') is-invalid
                            @enderror" id="name" name="name" value="{{ old('name', $data->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control @error('email') is-invalid
                            @enderror" id="email" name="email" value="{{ old('email', $data->email) }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone_num" class="form-label">Nomor HP*</label>
                            <input type="number" class="form-control @error('phone_num') is-invalid
                            @enderror" id="phone_num" name="phone_num"
                                value="{{ old('phone_num', $data->phone_num) }}">
                            @error('phone_num')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @if ($data->role_id != 1)
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role*</label>
                            <select class="form-select @error('role_id') is-invalid
                            @enderror" id="role_id" name="role_id">
                                <option value="">Open this select menu</option>
                                @foreach ($roles as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('role_id', $data->role_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @else
                        <input type="number" class="form-control @error('role_id') is-invalid
                            @enderror" id="role_id" name="role_id"
                                value="{{ old('role_id', $data->role_id) }}" hidden>
                        @endif
                        <div class="mb-3">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control @error('password') is-invalid
                            @enderror" id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password*</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid
                            @enderror" id="password_confirmation" name="password_confirmation"
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
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
<script src="{{ asset('/auth/assets/libs/masonry-layout/masonry-layout.min.js') }}"></script>
<script src="{{ asset('/auth/assets/js/pages/card.init.js') }}"></script>
<script src="{{ asset('/auth/assets/libs/prismjs/prismjs.min.js') }}"></script>

<script src="{{ asset('/auth//assets/js/app.js') }}"></script>
@endsection
