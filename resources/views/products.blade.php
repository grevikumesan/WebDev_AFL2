@extends('layouts.main')

@section('title', 'Daftar Produk')

@section('main_content')

    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h1 class="fw-bold section-title">Daftar Produk Kami</h1>
    </div>

    {{-- SEARCH --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <form action="{{ route('products.index') }}" method="GET" class="search-box shadow-sm">
                <input type="text" name="search" class="form-control" placeholder="Cari produk... (misal: gula, beras)"
                    autocomplete="off" value="{{ request('search') }}">
                <button class="btn btn-search" type="submit">Cari</button>
            </form>
        </div>
    </div>

    {{-- LIST PRODUK --}}
    @if ($products->count() > 0)
        <div class="row g-2 g-md-4">
            @foreach ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm product-card">

                        {{-- IMAGE (FIXED HEIGHT 250px) --}}
                        <div class="image-wrapper">
                            {{-- PERBAIKAN ERROR DISINI: Gunakan optional chaining atau default value --}}
                            <span class="category-badge">{{ $product->category->name ?? 'Umum' }}</span>

                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                    loading="lazy">
                            </a>
                        </div>

                        {{-- CARD BODY --}}
                        <div class="card-body d-flex flex-column p-2 p-md-3">
                            <h5 class="product-title mb-1">
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>

                            <p class="product-price mb-1">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                @if ($product->unit)
                                    <small class="unit-text text-muted fw-normal">/ {{ $product->unit }}</small>
                                @endif
                            </p>

                            {{-- LOGIKA STOK --}}
                            <p class="product-stock text-muted mb-2">
                                @if ($product->stock > 0)
                                    Stok: {{ $product->stock }}
                                @else
                                    <span class="text-danger fw-bold">Stok Habis</span>
                                @endif
                            </p>

                            {{-- TOMBOL ACTION (Rata Bawah) --}}
                            <div class="mt-auto d-flex align-items-center gap-2 w-100">
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="btn btn-outline-success btn-sm flex-grow-1 btn-detail">
                                    Detail
                                </a>

                                <div class="d-flex gap-1">
                                    {{-- KERANJANG (Cek Stok) --}}
                                    @if ($product->stock > 0)
                                        <button type="button" class="btn-icon action-btn"
                                            data-url="{{ route('cart.store') }}" data-action="Keranjang"
                                            data-product-id="{{ $product->id }}">
                                            <i class="bi bi-cart-plus-fill pointer-events-none"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn-icon bg-secondary text-white border-0" disabled
                                            title="Stok Habis">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    @endif

                                    {{-- WISHLIST --}}
                                    <button type="button" class="btn-icon action-btn text-muted"
                                        data-url="{{ route('wishlist.store') }}" data-action="Wishlist"
                                        data-product-id="{{ $product->id }}">
                                        <i class="bi bi-heart pointer-events-none"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-end align-items-center mt-5">
            {{ $products->links() }}
        </div>
    @else
        {{-- EMPTY STATE --}}
        <div class="text-center py-5">
            <div class="alert d-inline-block px-4 py-3 bg-light border rounded-4">
                <h4 class="fw-bold h5 text-muted">Produk tidak ditemukan</h4>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-success mt-2">Reset Pencarian</a>
            </div>
        </div>
    @endif

@endsection

@push('styles')
    <style>
        .section-title {
            color: #2d5a3a;
            font-size: 2rem;
        }

        .search-box {
            display: flex;
            background: white;
            border-radius: 50px;
            padding: 4px;
            border: 1px solid #bcead5;
        }

        .search-box input {
            border: none;
            box-shadow: none;
            padding-left: 20px;
            background: transparent;
        }

        .search-box .btn-search {
            background-color: #81c784;
            color: white;
            border-radius: 50px;
            padding: 6px 24px;
            border: none;
            transition: 0.3s;
        }

        .search-box .btn-search:hover {
            background-color: #66bb6a;
        }

        .product-card {
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .image-wrapper {
            position: relative;
            width: 100%;
            height: 250px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s;
        }

        .product-card:hover .image-wrapper img {
            transform: scale(1.1);
        }

        /* Fix Image Fit for first items if needed, or remove if general rule is enough */
        .row.g-2>.col-6:nth-child(1) .image-wrapper img,
        .row.g-2>.col-6:nth-child(2) .image-wrapper img,
        .row.g-2>.col-6:nth-child(3) .image-wrapper img {
            width: 85% !important;
            height: 85% !important;
            object-fit: contain !important;
        }

        .category-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #2d5a3a;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .product-title {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6em;
        }

        .product-price {
            color: #2e7d32;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .product-stock {
            font-size: 0.8rem;
        }

        .btn-detail {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #bcead5;
            background: #eafaf1;
            color: #2d5a3a;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-icon:hover {
            background: #2d5a3a;
            color: white;
            border-color: #2d5a3a;
        }

        .btn-icon:active {
            transform: scale(0.9);
        }

        .pointer-events-none {
            pointer-events: none;
        }

        .pagination-info {
            font-size: 0.9rem;
        }

        .pagination .page-item .page-link {
            color: #2d5a3a;
            border: 1px solid #bcead5;
            margin: 0 2px;
            border-radius: 6px;
        }

        .pagination .page-item.active .page-link {
            background-color: #2d5a3a;
            border-color: #2d5a3a;
            color: white;
        }

        @media (max-width: 576px) {
            .image-wrapper {
                height: 180px;
            }

            .section-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .product-title {
                font-size: 0.85rem;
                min-height: 2.6em;
            }

            .product-price {
                font-size: 0.95rem;
            }

            .card-body {
                padding: 0.5rem !important;
            }

            .btn-detail {
                font-size: 0.75rem;
                padding: 4px 8px;
            }

            .btn-icon {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }

            .category-badge {
                font-size: 0.6rem;
            }

            .pagination-info {
                font-size: 0.75rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
                align-items: center !important;
            }
        }
    </style>
@endpush

@push('scripts')
    {{-- Script Cart/Wishlist tetap sama seperti sebelumnya --}}
    <script>
        @if (Auth::check() && isset($wishlistProductIds))
            window.WishlistSync.set(@json($wishlistProductIds));
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('guestRestrictionModal');
            const toastEl = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastMessage');
            const modalMsg = document.getElementById('modalActionMessage');
            const guestModal = modalEl ? new bootstrap.Modal(modalEl) : null;
            const toast = toastEl ? new bootstrap.Toast(toastEl) : null;

            function showToast(message, type = 'success') {
                if (!toast) return;
                toastBody.textContent = message;
                toastEl.className = 'toast align-items-center text-white border-0 shadow';
                if (type === 'success') toastEl.classList.add('bg-success');
                else if (type === 'info') toastEl.classList.add('bg-info');
                else toastEl.classList.add('bg-danger');
                toast.show();
            }

            async function sendRequest(button) {
                const url = button.dataset.url;
                const action = button.dataset.action;
                const productId = button.dataset.productId;

                if (!window.IS_LOGGED_IN) {
                    if (modalMsg) modalMsg.textContent = `Login dulu untuk akses ${action}.`;
                    if (guestModal) guestModal.show();
                    return;
                }

                const originalHTML = button.innerHTML;
                button.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
                button.disabled = true;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    });

                    if (!response.ok) throw new Error('Server Error');
                    const data = await response.json();

                    if (data.status === 'success') {
                        if (action === 'Wishlist') {
                            button.innerHTML = '<i class="bi bi-heart-fill pointer-events-none"></i>';
                            button.classList.add('text-danger', 'border-danger');
                        } else {
                            button.innerHTML = '<i class="bi bi-check-lg fw-bold"></i>';
                            button.classList.add('btn-success', 'text-white');
                        }
                        showToast(data.message, 'success');
                    } else if (data.status === 'info') {
                        if (action === 'Wishlist') {
                            button.innerHTML = '<i class="bi bi-heart-fill pointer-events-none"></i>';
                            button.classList.add('text-danger', 'border-danger');
                        }
                        showToast(data.message, 'info');
                    }
                } catch (error) {
                    showToast("Terjadi kesalahan sistem.", 'error');
                } finally {
                    setTimeout(() => {
                        button.disabled = false;
                        if (action === 'Keranjang') {
                            button.innerHTML = originalHTML;
                            button.classList.remove('btn-success', 'text-white');
                        }
                        if (action === 'Wishlist' && !button.classList.contains('text-danger')) {
                            button.innerHTML = originalHTML;
                        }
                    }, 1500);
                }
            }

            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.action-btn');
                if (btn) {
                    e.preventDefault();
                    sendRequest(btn);
                }
            });
        });
    </script>
@endpush
