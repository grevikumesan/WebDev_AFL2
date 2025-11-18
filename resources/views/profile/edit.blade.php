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

                {{-- FORM UPDATE PROFILE --}}
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

                    <button type="submit" class="btn btn-success w-100 fw-bold" style="background-color: #2d5a3a; border-color: #2d5a3a;">
                        Simpan Perubahan
                    </button>
                </form>

                {{-- Tombol Logout dengan Trigger Modal --}}
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-danger w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Logout
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-center" style="background:#bcead5; color:#2d5a3a; border-bottom: none;">
                <h5 class="modal-title w-100 fw-bold" id="logoutModalLabel">
                    Konfirmasi Logout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-sign-out-alt fa-3x" style="color: #2d5a3a;"></i>
                    </div>
                    <h5 style="color: #2d5a3a; margin-bottom: 8px;">Yakin ingin logout?</h5>
                    <p class="text-muted" style="margin-bottom: 4px;">
                        Anda akan keluar dari akun dan perlu login kembali untuk mengakses fitur.
                    </p>
                </div>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal" 
                            style="border-radius: 12px; font-weight: 500;">
                        Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 fw-bold"
                                style="background-color: #dc3545; border-color: #dc3545; border-radius: 12px;">
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styling untuk modal logout */
#logoutModal .modal-content {
    border: 2px solid #bcead5;
}

#logoutModal .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

#logoutModal .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

#logoutModal .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

#logoutModal .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

/* Animasi untuk modal */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}
</style>
@endpush