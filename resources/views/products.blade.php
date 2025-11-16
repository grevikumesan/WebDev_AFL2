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
                <div class="col-6 col-sm-6 col-md-4 mb-4">
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

                            <div class="d-flex justify-content-start align-items-end gap-3 mt-3">
                                {{-- Lihat Detail --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="btn flex-grow-1"
                                   style="background-color:#eafaf1; color:#2d5a3a; border:1px solid #bcead5; font-weight:500; border-radius:10px; transition:all 0.3s;">
                                    Lihat Detail
                                </a>

                                {{-- Tombol Tambah ke Keranjang (Harus Login) --}}
                                <div class="d-inline-block">
                                    <button type="button"
                                            class="p-0 border-0 add-to-cart-btn" 
                                            data-action-name="keranjang"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-stock="{{ $product->stock }}"
                                            style="background:none; color:#2d5a3a; cursor:pointer;">
                                        <i class="bi bi-cart-plus-fill fs-3"></i>
                                    </button>
                                </div>

                                {{-- Tombol Wishlist (Harus Login) --}}
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

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let intendedAction = {
        type: '', // 'wishlist' atau 'cart'
        productId: null,
        productName: '',
        callback: null
    };

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

    // Setup redirect buttons dengan intended action
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

    // Inisialisasi redirect buttons
    setupRedirectButtons();

    // Check intended setelah kembali dari login/register
    checkIntendedAction();

    // 1. Wishlist (Love Icon) Logic & Restriction
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const actionName = this.getAttribute('data-action-name');
            const productId = this.getAttribute('data-product-id');

            // --- GUEST RESTRICTION ---
            if (!window.IS_LOGGED_IN) {
                e.preventDefault();
                
                // Callback untuk setelah login/register
                const afterLoginCallback = () => {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');
                    
                    if (icon.classList.contains('bi-heart-fill')) {
                        icon.style.color = '#dc3545';
                        // AJAX call untuk add wishlist
                        addToWishlist(productId);
                    }
                };

                showGuestRestrictionModal('wishlist', productId, '', afterLoginCallback);
                return;
            }
            
            // --- LOGGED-IN USER LOGIC ---
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

    // 2. Tombol Tambah ke Keranjang (Cart Icon) Logic & Restriction
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        const cardBody = btn.closest('.card-body');
        const cartBoxWrapper = cardBody.querySelector('.cart-box-wrapper');
        const btnAddCart = cartBoxWrapper.querySelector('.btn-add-cart');
        const addedMsg = cartBoxWrapper.querySelector('.added-msg');
        const maxStock = parseInt(btn.getAttribute('data-product-stock'));
        const actionName = btn.getAttribute('data-action-name');
        const productId = btn.getAttribute('data-product-id');
        const productName = btn.getAttribute('data-product-name');

        // 2.1 Click pada Ikon Keranjang (Show/Hide Box)
        btn.addEventListener('click', (e) => {
            // --- GUEST RESTRICTION ---
            if (!window.IS_LOGGED_IN) {
                e.preventDefault();
                
                // Callback untuk setelah login/register
                const afterLoginCallback = () => {
                    // Tampilkan cart box setelah login
                    cartBoxWrapper.style.display = 'block';
                    initializeCartBox();
                };

                showGuestRestrictionModal('cart', productId, productName, afterLoginCallback);
                return;
            }
            
            // --- LOGGED-IN USER LOGIC ---
            // Toggle tampilan box
            cartBoxWrapper.style.display = cartBoxWrapper.style.display === 'none' ? 'block' : 'none';
            initializeCartBox();
        });

        // Function untuk initialize cart box
        const initializeCartBox = () => {
            const qtyInput = cartBoxWrapper.querySelector('.qty-input');
            const btnIncrease = cartBoxWrapper.querySelector('.btn-increase');
            const btnDecrease = cartBoxWrapper.querySelector('.btn-decrease');

            // Reset state box
            qtyInput.value = 1;
            addedMsg.style.display = 'none';
            btnAddCart.disabled = false;

            // --- + / - tombol logika ---
            btnIncrease.onclick = () => {
                let val = parseInt(qtyInput.value);
                if(val < maxStock) qtyInput.value = val + 1;
                else alert(`Stok maksimal: ${maxStock}`);
            };
            btnDecrease.onclick = () => {
                let val = parseInt(qtyInput.value);
                if(val > 1) qtyInput.value = val - 1;
            };
        };

        // 2.2 Click pada Tombol 'Tambah ke Keranjang' di dalam Box (AJAX POST)
        btnAddCart.addEventListener('click', () => {
            const qtyInput = cartBoxWrapper.querySelector('.qty-input');
            const quantity = parseInt(qtyInput.value);

            // Fetch request ke rute cart.add
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                // Tampilkan pesan sukses dan nonaktifkan tombol
                addedMsg.style.display = 'block';
                btnAddCart.disabled = true;
                // Sembunyikan box setelah beberapa detik
                setTimeout(() => cartBoxWrapper.style.display = 'none', 2000); 
            })
            .catch(err => {
                alert('Terjadi kesalahan saat menambahkan ke keranjang. Coba lagi.');
                console.error(err);
            });
        });
    });

    // Mock functions untuk wishlist
    function addToWishlist(productId) {
        console.log('Adding to wishlist:', productId);
        // AJAX implementation here
    }

    function removeFromWishlist(productId) {
        console.log('Removing from wishlist:', productId);
        // AJAX implementation here
    }
});
</script>
@endpush