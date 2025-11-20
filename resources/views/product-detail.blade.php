@extends('layouts.main')

@section('title')
    {{ $product->name ?? $title }}
@endsection

@section('main_content')
    @if($product)
        <h1 class="text-center mb-5 fw-bold text-success" style="color:#2d5a3a !important;">
            Detail Produk
        </h1>

        <div class="row align-items-start py-4">
            {{-- KOLOM KIRI: GAMBAR --}}
            <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset('images/' . $product->image) }}"
                    class="img-fluid rounded shadow-sm"
                    alt="{{ $product->name }}"
                    style="border-radius:18px; max-height:400px; object-fit:cover;">
            </div>

            {{-- KOLOM KANAN: DETAIL PRODUK --}}
            <div class="col-md-6" style="color:#335b48;">

                <span class="badge rounded-pill mb-3 px-3 py-2"
                      style="background-color:#bcead5; color:#2d5a3a; font-weight:500;">
                    {{ $product->category->name }}
                </span>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="fw-bold mb-0" style="color:#2d5a3a;">{{ $product->name }}</h1>

                    {{-- IKON HATI (WISHLIST) --}}
                    <button class="btn wishlist-btn p-0 border-0"
                            data-product-id="{{ $product->id }}"
                            style="font-size: 2rem; color:#3b7d5e; background:none; line-height: 1;">
                         <i class="bi bi-heart"></i>
                    </button>
                </div>

                <p class="fw-bold fs-4" style="color:#3b7d5e;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                    @if($product->unit)
                        / {{ $product->unit }}
                    @endif
                </p>
                <p class="fw-bold" style="color:#2e5947;">
                    Stok Tersedia: {{ $product->stock }}
                </p>

                {{-- FORM QUANTITY + KERANJANG --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mt-4" id="cartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="d-flex align-items-end gap-3 mb-4">

                        {{-- Quantity --}}
                        <div style="max-width:130px;">
                            <label for="qtyInput" class="fw-bold mb-1" style="color:#2e5947;">Jumlah:</label>
                            <div class="d-flex align-items-center"
                                 style="background:#eafaf1; border:1px solid #bcead5; border-radius:10px; padding:6px 10px; height: 44px;">

                                <button type="button" onclick="changeQty(-1)" style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">-</button>
                                <input id="qtyInput" name="quantity" type="text" value="1"
                                       class="form-control text-center mx-2"
                                       style="width:50px; border:none; background:transparent; color:#2e5947; font-weight:600;"
                                       readonly>
                                <button type="button" onclick="changeQty(1)" style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">+</button>
                            </div>
                        </div>

                        {{-- Tombol Tambah Keranjang --}}
                        <button type="submit" class="btn btn-lg flex-grow-1"
                                 style="background-color:#bcead5; color:#2d5a3a; font-weight:600; border:none; border-radius:10px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; gap:8px;">
                            <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center mt-5" role="alert">
            <h4 class="alert-heading">Produk Tidak Ditemukan!</h4>
            <p>Maaf, produk yang Anda cari tidak tersedia atau ID-nya salah.</p>
            <a href="{{ route('products.index') }}" class="btn mt-3" style="background-color:#bcead5; color:#2d5a3a;">Kembali ke Daftar Produk</a>
        </div>
    @endif

    <!-- Tampilin pop up kalo masih jadi guest -->
    <div class="modal fade" id="guestRestrictionModal" tabindex="-1"
         data-bs-backdrop="false" data-bs-keyboard="true"
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Menyimpan intended action
    let intendedAction = {
        type: '', // 'wishlist' atau 'cart'
        productId: null,
        productName: '',
        callback: null
    };

    // Helper function untuk Guest Restriction dengan Modal
    const showGuestRestrictionModal = (actionType, productId = null, productName = '', callback = null) => {
        // Simpan intended action
        intendedAction.type = actionType;
        intendedAction.productId = productId;
        intendedAction.productName = productName;
        intendedAction.callback = callback;

        // Update pesan modal berdasarkan action type
        const actionText = actionType === 'wishlist' ? 'menyimpan ke wishlist' : 'menambahkan ke keranjang belanja';
        document.getElementById('modalActionMessage').textContent =
            `Untuk ${actionText}, silakan masuk ke akun Anda atau daftar baru.`;

        // Tampilkan modal
        const guestModal = new bootstrap.Modal(document.getElementById('guestRestrictionModal'));
        guestModal.show();
    };

    const setupRedirectButtons = () => {
        const loginBtn = document.querySelector('.login-redirect-btn');
        const registerBtn = document.querySelector('.register-redirect-btn');

        if (loginBtn) {
            // Simpan intended action di sessionStorage sebelum redirect
            loginBtn.addEventListener('click', function(e) {
                if (intendedAction.type) {
                    sessionStorage.setItem('intendedAction', JSON.stringify(intendedAction));
                }
            });
        }

        if (registerBtn) {
            // Simpan intended action di sessionStorage sebelum redirect
            registerBtn.addEventListener('click', function(e) {
                if (intendedAction.type) {
                    sessionStorage.setItem('intendedAction', JSON.stringify(intendedAction));
                }
            });
        }
    };

    // Check jika ada intended action setelah login/register
    const checkIntendedAction = () => {
        const savedAction = sessionStorage.getItem('intendedAction');
        if (savedAction) {
            const action = JSON.parse(savedAction);

            // Execute callback jika ada setelah user login/register
            if (action.callback && typeof action.callback === 'function') {
                setTimeout(() => {
                    action.callback();
                }, 500);
            }

            // Clear saved action
            sessionStorage.removeItem('intendedAction');
        }
    };

    // Menjalankan fungsi-fungsi di atas
    setupRedirectButtons();
    checkIntendedAction();

    // MENGATUR KUANTITAS
    function changeQty(delta) {
        const qtyInput = document.getElementById('qtyInput');
        let currentQty = parseInt(qtyInput.value);
        let maxStock = parseInt("{{ $product->stock ?? 0 }}");

        let newQty = currentQty + delta;

        if (newQty < 1) {
            newQty = 1;
        }

        if (newQty > maxStock) {
            alert(`Maaf, stok maksimal hanya ${maxStock}.`);
            newQty = maxStock;
        }

        qtyInput.value = newQty;
    }

    // WISHLIST dengan Login Check
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const productId = this.getAttribute('data-product-id');

            // Ketika user belum log in
            if (!window.IS_LOGGED_IN) {
                e.preventDefault();

                const afterLoginCallback = () => {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');

                    if (icon.classList.contains('bi-heart-fill')) {
                        icon.style.color = '#dc3545';
                        addToWishlist(productId);
                    }
                };

                showGuestRestrictionModal('wishlist', productId, '', afterLoginCallback);
                return;
            }

            const icon = this.querySelector('i');
            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');

            if (icon.classList.contains('bi-heart-fill')) {
                icon.style.color = '#dc3545';
                addToWishlist(productId);
            } else {
                icon.style.color = '#3b7d5e';
                removeFromWishlist(productId);
            }
        });
    });

    // KERANJANG dengan Login Check
    const cartForm = document.getElementById('cartForm');
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            if (!window.IS_LOGGED_IN) {
                e.preventDefault();
                showGuestRestrictionModal('cart', "{{ $product->id }}", "{{ $product->name }}");
            }
        });
    }

    function addToWishlist(productId) {
        console.log('Adding to wishlist:', productId);
    }

    function removeFromWishlist(productId) {
        console.log('Removing from wishlist:', productId);
    }
});
</script>

<!-- Font Awesome & Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endpush
