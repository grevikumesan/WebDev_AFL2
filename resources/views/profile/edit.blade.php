@extends('layouts.main')

@section('title', 'Edit Profile')

@section('main_content')
<div class="container pt-2" style="margin-top: -20px;">

    <h2 class="text-center mb-4 fw-bold">Edit Profile</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- BOX DIKELILINGI COLOMN SUPAYA KECIL DI DESKTOP --}}
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5"> 
            {{-- col-lg-5 membuat box kecil di desktop --}}
            
            <div class="card shadow-sm p-4">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- Current Photo --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Saat Ini</label><br>

                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}"
                                 alt="Foto Profil"
                                 width="120" class="rounded mb-2 border">
                        @else
                            <p class="text-muted">Belum ada foto.</p>
                        @endif
                    </div>

                    {{-- Upload New Photo --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti Foto</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Format: jpg, jpeg, png (max 2MB)</small>
                    </div>

                    {{-- Password (Optional) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru (optional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection