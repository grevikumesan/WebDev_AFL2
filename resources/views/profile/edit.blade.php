@extends('layouts.main')

@section('title', 'Edit Profile')

@section('main_content')
    <div class="container pt-2" style="margin-top: -20px;">

        <h2 class="text-center mb-4 fw-bold">Edit Profile</h2>

        {{-- Pesan sukses --}}
        @if (session('success'))
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

        {{-- BOX DIKELILINGI COLUMN SUPAYA KECIL DI DESKTOP --}}
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">

                <div class="card shadow-sm p-4">

                    {{-- FORM UPDATE PROFILE --}}
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Profile Photo Section (Centered at Top) --}}
                        <div class="text-center mb-4">
                            <div class="profile-photo-wrapper position-relative d-inline-block"
                                style="width: 120px; height: 120px;">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil"
                                        class="rounded-circle border" id="profilePreview"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #2d5a3a !important;">
                                @else
                                    <div class="rounded-circle border d-flex align-items-center justify-content-center"
                                        id="profilePreview"
                                        style="width: 120px; height: 120px; background-color: #e9ecef; border: 3px solid #2d5a3a !important;">
                                        <i class="fas fa-user fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <input type="file" name="image" id="imageInput" class="d-none"
                                accept="image/jpeg,image/jpg,image/png">

                            <input type="hidden" name="delete_image" id="deleteImageInput" value="0">

                            <div class="mt-2">
                                <label for="imageInput" class="small" style="cursor: pointer;">
                                    <i class="fas fa-camera me-1"></i> Ganti Foto Profil
                                </label>
                                @if ($user->image)
                                    <span id="btnHapusFoto" class="small" style="cursor: pointer;">
                                        |
                                        <i class="fas fa-trash me-1"></i> Hapus Foto Profil
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        {{-- Password (Optional) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold"
                            style="background-color: #2d5a3a; border-color: #2d5a3a;">
                            Simpan Perubahan
                        </button>
                    </form>

                    {{-- Tombol Logout dengan Trigger Modal --}}
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-danger w-100 fw-bold" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const deleteInput = document.getElementById('deleteImageInput');
            const btnHapus = document.getElementById('btnHapusFoto');

            // Kita tidak pakai const untuk preview di sini, karena elemennya bisa berubah dari DIV ke IMG
            // Jadi kita ambil elemennya secara 'fresh' di dalam event listener nanti.

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            // Ambil elemen preview saat ini
                            let previewElement = document.getElementById('profilePreview');

                            // LOGIKA BARU: Cek apakah elemen saat ini adalah DIV (state kosong)
                            if (previewElement.tagName === 'DIV') {
                                // 1. Buat elemen IMG baru
                                const newImg = document.createElement('img');
                                newImg.src = event.target.result;
                                newImg.id = 'profilePreview'; // Pasang ID yang sama
                                newImg.className = 'rounded-circle border';

                                // Copy style dari elemen asli supaya ukurannya sama
                                newImg.style.width = '120px';
                                newImg.style.height = '120px';
                                newImg.style.objectFit = 'cover';
                                newImg.style.border = '3px solid #2d5a3a';

                                // 2. Ganti DIV lama dengan IMG baru di HTML
                                previewElement.parentNode.replaceChild(newImg, previewElement);
                            } else {
                                // Jika sudah IMG, cukup ganti src-nya
                                previewElement.src = event.target.result;
                            }

                            // Reset input delete (karena user barusan upload gambar baru)
                            deleteInput.value = '0';

                            // Tampilkan tombol hapus
                            if (btnHapus) {
                                btnHapus.style.display = 'inline';
                                // Pastikan isinya ada (karena kadang hidden via CSS/JS)
                                if (btnHapus.innerHTML.trim() === '') {
                                    btnHapus.innerHTML =
                                        '<i class="fas fa-trash me-1"></i> Hapus Foto Profil';
                                }
                            }
                        }

                        reader.readAsDataURL(file);
                    }
                });
            }

            // Logika Hapus Foto (Opsional: disesuaikan agar reset preview ke ikon lagi jika mau)
            if (btnHapus) {
                btnHapus.addEventListener('click', function() {
                    if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;

                    deleteInput.value = '1'; // Tandai untuk dihapus di server
                    imageInput.value = ''; // Reset input file
                    this.style.display = 'none'; // Sembunyikan tombol hapus

                    // Kembalikan preview ke mode "Kosong" (DIV dengan Icon)
                    let previewElement = document.getElementById('profilePreview');
                    if (previewElement.tagName === 'IMG') {
                        const newDiv = document.createElement('div');
                        newDiv.id = 'profilePreview';
                        newDiv.className =
                            'rounded-circle border d-flex align-items-center justify-content-center';
                        newDiv.style.width = '120px';
                        newDiv.style.height = '120px';
                        newDiv.style.backgroundColor = '#e9ecef';
                        newDiv.style.border = '3px solid #2d5a3a';
                        newDiv.innerHTML = '<i class="fas fa-user fa-3x text-muted"></i>';

                        previewElement.parentNode.replaceChild(newDiv, previewElement);
                    }
                });
            }
        });
    </script>
@endpush
