@extends('layouts.main')

@section('title')
    {{ $product->name ?? 'Detail Produk' }}
@endsection

@section('main_content')
    @if (isset($product) && $product)
        {{-- HEADER --}}
        <h1 class="text-center mb-5 fw-bold section-title" style="color:#2d5a3a;">
            Detail Produk
        </h1>

        <div class="row align-items-start py-4">
            {{-- KOLOM KIRI: GAMBAR --}}
            <div class="col-md-6 mb-4 text-center">
                <div class="p-3 bg-light rounded-4 shadow-sm d-flex align-items-center justify-content-center"
                    style="min-height: 400px;">
                    <img src="{{ asset('images/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}"
                        style="max-height:400px; object-fit:contain;">
                </div>
            </div>

            {{-- KOLOM KANAN: INFO --}}
            <div class="col-md-6" style="color:#335b48;">

                <span class="badge rounded-pill mb-3 px-3 py-2"
                    style="background-color:#bcead5; color:#2d5a3a; font-weight:500;">
                    {{ $product->category->name ?? 'Umum' }}
                </span>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="fw-bold mb-0 text-dark">{{ $product->name }}</h1>

                    {{-- TOMBOL WISHLIST --}}
                    <button type="button" class="btn p-0 border-0 action-btn text-muted"
                        data-url="{{ route('wishlist.store') }}" data-action="Wishlist"
                        data-product-id="{{ $product->id }}"
                        style="font-size: 2rem; background:none; line-height: 1; transition: transform 0.2s;">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                {{-- LOGIKA TAMPILAN STOK --}}
                <p class="fw-bold fs-5" style="color:#2e5947;">
                    @if($product->stock > 0)
                        Stok Tersedia: <span id="maxStock">{{ $product->stock }}</span>
                    @else
                        <span class="text-danger">Stok Habis</span>
                    @endif
                </p>

                <hr class="my-4" style="border-color: #bcead5;">

                {{-- KONTROL QUANTITY & HARGA --}}
                <div class="d-flex flex-wrap align-items-center gap-4 mb-4">
                    {{-- Input Jumlah --}}
                    <div>
                        <label for="qtyInput" class="fw-bold mb-2 d-block small text-uppercase"
                            style="color:#2e5947; letter-spacing: 1px;">Jumlah</label>
                        <div class="d-flex align-items-center shadow-sm"
                            style="background:white; border:1px solid #bcead5; border-radius:50px; padding:5px 10px;">

                            <button type="button" onclick="changeQty(-1)"
                                class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; background:#eafaf1; color:#2d5a3a;"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-dash fw-bold"></i>
                            </button>

                            <input id="qtyInput" type="text" value="{{ $product->stock > 0 ? 1 : 0 }}"
                                class="form-control text-center mx-2 border-0 fw-bold"
                                style="width:50px; background:transparent; color:#2e5947; font-size: 1.1rem;" readonly>

                            <button type="button" onclick="changeQty(1)"
                                class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; background:#eafaf1; color:#2d5a3a;"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-plus fw-bold"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Total Harga --}}
                    <div>
                        <label class="fw-bold mb-2 d-block small text-uppercase"
                            style="color:#2e5947; letter-spacing: 1px;">Total Harga</label>
                        <div id="subtotalDisplay" class="fw-bold fs-2" style="color:#2d5a3a;">
                            Rp {{ number_format($product->stock > 0 ? $product->price : 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    @if ($product->stock > 0)
                        {{-- Tambah Keranjang --}}
                        <button type="button" class="btn btn-lg flex-grow-1 action-btn shadow-sm"
                            data-url="{{ route('cart.store') }}" data-action="Keranjang"
                            data-product-id="{{ $product->id }}"
                            style="background-color:#eafaf1; color:#2d5a3a; border:1px solid #bcead5; border-radius:12px; font-weight:600;">
                            <i class="bi bi-cart-plus me-2"></i> Tambah Keranjang
                        </button>

                        {{-- Beli Sekarang --}}
                        <button type="button" id="buyNowBtn" class="btn btn-lg flex-grow-1 shadow-sm"
                            style="background-color:#2d5a3a; color:white; border-radius:12px; font-weight:600;">
                            Beli Sekarang
                        </button>
                    @else
                        {{-- Tombol Habis --}}
                        <button type="button" class="btn btn-lg flex-grow-1 shadow-sm bg-secondary text-white border-0"
                            disabled style="border-radius:12px; font-weight:600;">
                            <i class="bi bi-x-circle me-2"></i> Stok Habis
                        </button>
                    @endif
                </div>

                <p class="text-muted small mt-3 text-center text-sm-start">
                    <i class="bi bi-shield-check me-1"></i> Jaminan produk original & berkualitas.
                </p>

            </div>
        </div>
    @else
        <div class="alert alert-warning text-center mt-5 rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-circle fs-1 d-block mb-3"></i>
            <h4 class="alert-heading fw-bold">Produk Tidak Ditemukan!</h4>
            <p>Maaf, produk yang Anda cari tidak tersedia atau ID-nya salah.</p>
            <a href="{{ route('products.index') }}" class="btn btn-success mt-3 rounded-pill px-4">Kembali ke Daftar
                Produk</a>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        @if (Auth::check())
            // Inisialisasi dari backend
            var initialWishlist = {{ $isWishlist ? 'true' : 'false' }};
            if (initialWishlist) {
                window.WishlistSync.add("{{ $product->id }}");
            }
        @endif

        // --- 1. INISIALISASI VARIABEL AMAN ---
        var productPrice = Number("{{ $product->price ?? 0 }}");
        var maxStock = Number("{{ $product->stock ?? 0 }}");
        var defaultProductId = "{{ $product->id ?? '' }}";
        var cartUrl = "{{ route('cart.store') }}";

        // --- 2. LOGIKA QUANTITY ---
        function changeQty(delta) {
            // Jika stok 0, hentikan
            if(maxStock <= 0) return;

            var qtyInput = document.getElementById('qtyInput');
            if (!qtyInput) return;

            var currentQty = parseInt(qtyInput.value) || 1;
            var newQty = currentQty + delta;

            if (newQty < 1) newQty = 1;
            if (newQty > maxStock) {
                newQty = maxStock;
                alert('Maaf, stok hanya tersisa ' + maxStock + ' item.');
            }

            qtyInput.value = newQty;
            updateSubtotal(newQty);
        }

        function updateSubtotal(qty) {
            var subtotal = productPrice * qty;
            var displayEl = document.getElementById('subtotalDisplay');
            if (displayEl) {
                // Format rupiah sederhana
                displayEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }
        }

        // --- 3. LOGIKA AJAX ---
        document.addEventListener('DOMContentLoaded', function() {

            var modalEl = document.getElementById('guestRestrictionModal');
            var toastEl = document.getElementById('liveToast');
            var toastBody = document.getElementById('toastMessage');
            var modalMsg = document.getElementById('modalActionMessage');

            var guestModal = modalEl ? new bootstrap.Modal(modalEl) : null;
            var toast = toastEl ? new bootstrap.Toast(toastEl) : null;

            function showToast(message, type) {
                if (!toast) return;
                // Default type success
                type = type || 'success';

                toastBody.textContent = message;
                toastEl.className = 'toast align-items-center text-white border-0 shadow';

                if (type === 'success') toastEl.classList.add('bg-success');
                else if (type === 'info') toastEl.classList.add('bg-info');
                else toastEl.classList.add('bg-danger');

                toast.show();
            }

            // Fungsi Utama Request
            async function sendRequest(button, isBuyNow) {
                isBuyNow = isBuyNow || false;

                // Ambil data dari atribut tombol atau fallback ke variable global
                var url = button.dataset.url || cartUrl;
                var action = button.dataset.action || "Keranjang";
                var productId = button.dataset.productId || defaultProductId;

                var qtyInput = document.getElementById('qtyInput');
                var quantity = parseInt(qtyInput ? qtyInput.value : 1);

                // Cek Stok lagi sebelum kirim (Client Side Check)
                if (maxStock <= 0) {
                    alert('Stok habis!');
                    return;
                }

                // Cek Global variable login dari main.blade.php
                if (typeof window.IS_LOGGED_IN !== 'undefined' && !window.IS_LOGGED_IN) {
                    if (modalMsg) modalMsg.textContent = 'Login dulu untuk ' + (isBuyNow ? 'membeli produk' :
                        'akses ' + action) + '.';
                    if (guestModal) guestModal.show();
                    return;
                }

                // Loading UI
                var originalHTML = button.innerHTML;
                button.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
                button.disabled = true;

                // Ambil CSRF
                var csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                var csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                try {
                    var response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    });

                    // Cek status HTTP
                    if (!response.ok) {
                        // Coba baca error JSON dengan aman
                        var errorData = await response.json().catch(function() {
                            return {};
                        });
                        throw new Error(errorData.message || 'Server Error: ' + response.status);
                    }

                    var data = await response.json();

                    // Handle Sukses
                    if (data.status === 'success') {

                        if (isBuyNow) {
                            window.location.href = "{{ route('cart.index') }}";
                            return;
                        }

                        if (action === 'Wishlist') {
                            var icon = button.querySelector('i');
                            if (icon) icon.className = 'bi bi-heart-fill';
                            button.classList.remove('text-success');
                            button.classList.add('text-danger');

                            button.style.transform = 'scale(1.2)';
                            setTimeout(function() {
                                button.style.transform = 'scale(1)';
                            }, 200);
                        }
                        showToast(data.message, 'success');

                    } else if (data.status === 'info') {
                        // Info (misal: sudah ada di wishlist)
                        if (action === 'Wishlist') {
                            var icon = button.querySelector('i');
                            if (icon) icon.className = 'bi bi-heart-fill';
                            button.classList.remove('text-success');
                            button.classList.add('text-danger');
                        }
                        showToast(data.message, 'info');
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }

                } catch (error) {
                    console.error(error);
                    showToast("Gagal memproses: " + error.message, 'error');
                } finally {
                    // Reset tombol jika tidak redirect
                    if (!isBuyNow) {
                        setTimeout(function() {
                            button.disabled = false;
                            // Jika bukan wishlist, kembalikan teks/icon awal
                            if (action !== 'Wishlist') {
                                button.innerHTML = originalHTML;
                            } else {
                                // Jika wishlist, pertahankan icon hati
                                var isLiked = button.classList.contains('text-danger');
                                // Pastikan struktur HTML icon valid
                                button.innerHTML = '<i class="bi ' + (isLiked ? 'bi-heart-fill' :
                                    'bi-heart') + '"></i>';
                            }
                        }, 500);
                    }
                }
            }

            // Event Listener Tombol Biasa
            var actionBtns = document.querySelectorAll('.action-btn');
            actionBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sendRequest(this, false);
                });
            });

            // Event Listener Tombol Beli
            var buyNowBtn = document.getElementById('buyNowBtn');
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sendRequest(this, true);
                });
            }
        });
    </script>
@endpush
