@extends('layouts.main')

@section('main_content')
<div class="container-fluid px-2 px-md-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-2 py-md-3">
                    <h5 class="mb-0 fw-bold fs-6 fs-md-5">Edit User: {{ $user->name }}</h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-2 mb-md-3">
                            <label class="form-label fs-7 fs-md-6">Nama</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $user->name }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-2 mb-md-3">
                            <label class="form-label fs-7 fs-md-6">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" value="{{ $user->email }}" required>
                        </div>

                        {{-- Role --}}
                        <div class="mb-2 mb-md-3">
                            <label class="form-label fw-bold text-danger fs-7 fs-md-6">Role (Peran)</label>
                            <select name="role" class="form-select form-select-sm">
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <small class="text-muted fs-8 d-block mt-1">Hati-hati memberikan akses Admin.</small>
                        </div>

                        {{-- Password --}}
                        <div class="mb-2 mb-md-3">
                            <label class="form-label fs-7 fs-md-6">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Isi jika ingin reset">
                        </div>
                        <div class="mb-3 mb-md-4">
                            <label class="form-label fs-7 fs-md-6">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-sm">
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm fs-7 fs-md-6">Batal</a>
                            <button type="submit" class="btn btn-success fw-bold btn-sm fs-7 fs-md-6">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
