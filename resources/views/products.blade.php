@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('main_content')
    <h1 class="text-center mb-5 fw-bold text-success" style="color:#2d5a3a !important;">
        Daftar Produk Kami
    </h1>

    {{-- Search Bar --}}
    <div class="row justify-content-center mt-4 pb-5">
        <div class="col-md-8">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex bg-white shadow-lg rounded-pill p-2"
                  autocomplete="off">
                <input
                    type="text"
                    name="search"
                    class="form-control border-0 rounded-pill px-3 shadow-none"
                    placeholder="🔍 Cari produk... contoh: gula, rokok, sabun"
                    style="font-size: 1.05rem; background-color: transparent; outline: none;"
                    autocomplete="off">
                <button class="btn btn-soft-green rounded-pill px-4 fw-semibold shadow-none border-0" type="submit"
                        style="background-color: #81c784; color: white;">
                    Cari
                </button>
            </form>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                 <div class="col-6 col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm"
                        style="background-color:#ffffff; border-radius:16px; overflow:hidden;">
                        {{-- Wrapper Gambar --}}
                        <div class="product-image-wrapper"
     style="width:100%; height:250px; display:flex; align-items:center; justify-content:center; background-color:#f7faf9; border-top-left-radius:16px; border-top-right-radius:16px;">

                            <img src="{{ asset('images/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 style="
                                     max-width:100%;
                                     max-height:100%;
                                     object-fit:contain;
                                     border-top-left-radius:16px;
                                     border-top-right-radius:16px;">
                        </div>

                        <div class="card-body" style="color:#335b48;">
                            <span class="badge rounded-pill mb-3 px-3 py-2"
                                  style="background-color:#bcead5; color:#2d5a3a; font-weight:500;">
                                {{ $product->category->name }}
                            </span>

                            <h5 class="card-title fw-semibold">{{ $product->name }}</h5>
                            <p class="fw-bold fs-5" style="color:#3b7d5e;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                @if($product->unit)
                                    / {{ $product->unit }}
                                @endif
                            </p>

                            <p class="mb-3" style="color:#2d5a3a; font-weight:600;">
                                Stok: {{ $product->stock }}
                            </p>

                            {{-- KUANTITAS & KERANJANG --}}
                            <div class="cart-box-wrapper mb-2" style="display:none;">
                                <div class="p-3 border rounded shadow-sm bg-light cart-box">
                                    <h6 class="fw-bold mb-2 cart-product-name" style="color:#2d5a3a;">
                                        {{ $product->name }}
                                    </h6>
                                    <div class="d-flex align-items-center mb-2 gap-2">
                                        <button type="button" class="btn-decrease" style="background:none; border:none; font-size:18px; font-weight:bold; color:#2d5a3a;">-</button>
                                        <input type="text" class="form-control qty-input text-center" value="1" readonly
                                               style="width:50px; border:none; background:transparent; color:#2e5947; font-weight:600;">
                                        <button type="button" class="btn-increase" style="background:none; border:none; font-size:18px; font-weight:bold; color:#2d5a3a;">+</button>
                                    </div>
                                    <button type="button" class="btn-add-cart btn btn-sm w-100"
                                            style="background-color:#bcead5; color:#2d5a3a; font-weight:600; border:none; border-radius:8px; font-size:0.9rem;">
                                        Tambah ke Keranjang
                                    </button>
                                    <p class="added-msg text-success fw-bold mt-2" style="display:none; font-size:0.9rem;">Sudah ditambahkan ke keranjang</p>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-start align-items-center product-card-action gap-2 gap-sm-3 mt-3">
                                {{-- Lihat Detail --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                class="btn btn-detail w-100 w-sm-auto flex-grow-1 flex-sm-grow-1"
                                style="background-color:#eafaf1; color:#2d5a3a; border:1px solid #bcead5; font-weight:500; border-radius:10px; transition:all 0.3s;">
                                    Lihat Detail
                                </a>

                                {{-- Container untuk icon di mobile --}}
                                <div class="d-flex d-sm-none justify-content-center w-100 gap-4 mobile-icons">
                                    {{-- Tombol Tambah ke Keranjang --}}
                                    <button type="button"
                                            class="p-0 border-0 add-to-cart-btn icon-btn"
                                            data-action-name="keranjang"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-stock="{{ $product->stock }}"
                                            style="background:none; color:#2d5a3a; cursor:pointer;">
                                        <i class="bi bi-cart-plus-fill fs-3"></i>
                                    </button>

                                    {{-- Tombol Wishlist --}}
                                    <button class="p-0 border-0 wishlist-btn"
                                            data-action-name="wishlist"
                                            data-product-id="{{ $product->id }}"
                                            style="background:none; color:#3b7d5e; cursor:pointer;">
                                        <i class="bi bi-heart fs-3"></i>
                                    </button>
                                </div>

                                {{-- Icon untuk desktop --}}
                                <div class="d-none d-sm-flex align-items-center gap-3 desktop-icons">
                                    {{-- Tombol Tambah ke Keranjang --}}
                                    <button type="button"
                                            class="p-0 border-0 add-to-cart-btn icon-btn"
                                            data-action-name="keranjang"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-stock="{{ $product->stock }}"
                                            style="background:none; color:#2d5a3a; cursor:pointer;">
                                        <i class="bi bi-cart-plus-fill fs-3"></i>
                                    </button>

                                    {{-- Tombol Wishlist --}}
                                    <button class="p-0 border-0 wishlist-btn"
                                            data-action-name="wishlist"
                                            data-product-id="{{ $product->id }}"
                                            style="background:none; color:#3b7d5e; cursor:pointer;">
                                        <i class="bi bi-heart fs-3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert"
                     style="background-color:#eafaf1; color:#335b48; border:1px solid #bcead5; border-radius:12px;">
                    <h4 class="alert-heading fw-bold">Maaf!</h4>
                    <p>Produk yang Anda cari tidak ditemukan.</p>
                    <hr style="border-top:1px solid #bcead5;">
                    <a href="{{ route('products.index') }}"
                       class="btn"
                       style="background-color:#bcead5; color:#2d5a3a; font-weight:500; border-radius:10px;">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
    @endif

<!-- Guest Restriction Modal -->
<div class="modal fade" id="guestRestrictionModal" tabindex="-1"
         data-bs-backdrop="true" data-bs-keyboard="true"
         aria-labelledby="guestRestrictionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-center" style="background:#bcead5; color:#2d5a3a; border-bottom: none;">
                    <h5 class="modal-title w-100 fw-bold" id="guestRestrictionModalLabel">
                        Toko Wilujeng
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="mb-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-users fa-3x" style="color: #2d5a3a;"></i>
                        </div>
                        <h5 style="color: #2d5a3a; margin-bottom: 8px;">Bergabunglah Dengan Kami</h5>
                        <p class="text-muted" id="modalActionMessage" style="margin-bottom: 4px;">
                            Untuk menambahkan produk ke wishlist atau keranjang belanja
                        </p>
                        <p class="text-muted small">
                            Nikmati pengalaman berbelanja yang lebih personal
                        </p>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('login') }}" class="btn py-3 fw-semibold login-redirect-btn"
                           style="background-color: #2d5a3a; color: white; border-radius: 12px; font-size: 1.1rem;">
                            Masuk ke Akun
                        </a>
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold register-redirect-btn"
                           style="color: #2d5a3a; font-size: 1rem;">
                            Daftar Sekarang - Gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* Mobile View */
@media (max-width: 576px) {
    .product-card-action .btn-detail {
        font-size: 0.55rem !important;
        padding: 0.3rem 0.5rem !important;
        line-height: 1.2 !important;
        min-height: 28px;
    }

    .mobile-icons .add-to-cart-btn i,
    .mobile-icons .wishlist-btn i {
        font-size: 1.1rem !important;
    }
}

/* Desktop View */
@media (min-width: 577px) {
    .product-card-action {
        flex-direction: row !important;
    }
    
    .desktop-icons .add-to-cart-btn i,
    .desktop-icons .wishlist-btn i {
        font-size: 1.3rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Cek status login dari PHP ke JS
        const isLoggedIn = @json(auth()->check());

        // Siapin modal
        const guestModalElement = document.getElementById('guestRestrictionModal');
        const guestModal = new bootstrap.Modal(guestModalElement);
        const modalMessage = document.getElementById('modalActionMessage');

        // 1. Logika Tombol Wishlist
        document.querySelectorAll('.wishlist-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const actionName = this.dataset.actionName; // "wishlist"

                // KALO BELUM LOGIN: Tampilkan modal
                if (!isLoggedIn) {
                    modalMessage.textContent = 'Untuk menambahkan produk ke ' + actionName;
                    guestModal.show();
                    return; // Stop
                }

                // KALO SUDAH LOGIN: Kirim data (AJAX/Fetch)
                const productId = this.dataset.productId;
                const icon = this.querySelector('i');

                fetch('{{ route('wishlist.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting untuk keamanan
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Ganti ikon jadi 'filled'
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        button.disabled = true; // Biar nggak diklik lagi
                    }
                    // Tampilkan notifikasi (ganti 'alert' dengan 'toast' nanti)
                    alert(data.message);
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // 2. Logika Tombol Keranjang
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const actionName = this.dataset.actionName; // "keranjang"

                // KALO BELUM LOGIN: Tampilkan modal
                if (!isLoggedIn) {
                    modalMessage.textContent = 'Untuk menambahkan produk ke ' + actionName;
                    guestModal.show();
                    return; // Stop
                }

                // KALO SUDAH LOGIN: Kirim data (AJAX/Fetch)
                const productId = this.dataset.productId;
                const icon = this.querySelector('i');

                fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1  // Kirim quantity 1 sebagai default
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Ganti ikon jadi 'checked'
                        icon.classList.remove('bi-cart-plus-fill');
                        icon.classList.add('bi-cart-check-fill');
                        button.disabled = true; // Biar nggak diklik lagi
                    }
                    // Tampilkan notifikasi (ganti 'alert' dengan 'toast' nanti)
                    alert(data.message);
                })
                .catch(error => console.error('Error:', error));
            });
        });

    });
</script>
@endpush