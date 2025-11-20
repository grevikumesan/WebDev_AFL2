@extends('layouts.main')

@section('title', 'Wishlist Saya')

@section('main_content')
<div class="container mt-5 mb-5">
    <div class="mb-5">
        {{-- Ubah warna teks menjadi hijau (#2d5a3a) dan hapus paragraf koleksi --}}
        <h2 class="fw-bold" style="color: #2d5a3a; font-size: 2rem;">Wishlist Saya</h2>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="text-center py-5">
            {{-- Ikon hati dihapus di sini --}}

            <h6 class="text-secondary fw-semibold">Wishlist kosong</h6>
            <p class="text-secondary small mb-4">Belum ada produk yang disimpan</p>

            {{-- Tombol diganti warnanya jadi hijau (#2d5a3a) --}}
            <a href="{{ route('products.index') }}" class="btn" style="background: #2d5a3a; color: #fff; border-radius: 8px; font-weight: 500;">
                Jelajahi Produk
            </a>
        </div>
    @else
        <div class="wishlist-list">
            @foreach($wishlistItems as $product)
            <div class="wishlist-item" data-product-id="{{ $product->id }}">
                <div class="item-image">
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    </a>
                </div>

                <div class="item-content">
                    <a href="{{ route('products.show', $product->id) }}" class="item-name">
                        {{ $product->name }}
                    </a>
                    @if($product->category)
                    <p class="item-category">{{ $product->category->name }}</p>
                    @endif
                    <p class="item-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="item-actions">
                    <button class="action-btn remove-wishlist" data-product-id="{{ $product->id }}" title="Hapus dari wishlist" type="button">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                    <button class="action-btn add-cart" data-product-id="{{ $product->id }}" title="Tambah ke keranjang" type="button">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .wishlist-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .wishlist-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.25rem;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .wishlist-item:hover {
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border-color: #e8e8e8;
    }

    .wishlist-item.removing {
        animation: slideOut 0.3s ease forwards;
    }

    @keyframes slideOut {
        to {
            opacity: 0;
            transform: translateX(-20px);
        }
    }

    .item-image {
        flex-shrink: 0;
        width: 130px;
        height: 130px;
        background: #f8f8f8;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-image a {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .item-image img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .item-image:hover img {
        transform: scale(1.08);
    }

    .item-content {
        flex: 1;
        min-width: 0;
    }

    .item-name {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        text-decoration: none;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        transition: color 0.2s;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item-name:hover {
        color: #555;
    }

    .item-category {
        font-size: 0.85rem;
        color: #999;
        margin: 0.25rem 0;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-size: 1.15rem;
        font-weight: 700;
        color: #2d5a3a;
        margin: 0;
    }

    .item-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .action-btn {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background: #fafafa;
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        border-color: #d0d0d0;
        background: #f0f0f0;
    }

    .action-btn:active {
        transform: scale(0.95);
    }

    .action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .remove-wishlist:hover {
        color: #e63946;
        border-color: #e63946;
        background: #ffe8e8;
    }

    .add-cart:hover {
        color: #2d5a3a;
        border-color: #2d5a3a;
        background: #e8f5e9;
    }

    @media (max-width: 576px) {
        .wishlist-item {
            gap: 1rem;
            padding: 1rem;
        }

        .item-image {
            width: 100px;
            height: 100px;
        }

        .item-name {
            font-size: 0.95rem;
        }

        .item-price {
            font-size: 1rem;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function showToast(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: auto; min-width: 300px;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            const div = document.createElement('div');
            div.innerHTML = alertHTML;
            document.body.appendChild(div.firstElementChild);
        }

        // Handle remove from wishlist
        document.querySelectorAll('.remove-wishlist').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.getAttribute('data-product-id');
                const card = this.closest('.wishlist-item');

                if (!productId || !card) return;

                this.disabled = true;

                fetch('{{ route("wishlist.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: parseInt(productId) })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    if (data && data.status === 'success' && data.action === 'removed') {
                        card.classList.add('removing');
                        setTimeout(() => {
                            card.remove();
                            const remaining = document.querySelectorAll('.wishlist-item').length;
                            if (remaining === 0) {
                                location.reload();
                            }
                        }, 300);
                    } else {
                        this.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('Gagal menghapus dari wishlist', 'error');
                    this.disabled = false;
                });
            });
        });

        // Handle add to cart
        document.querySelectorAll('.add-cart').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.getAttribute('data-product-id');

                if (!productId) return;

                this.disabled = true;

                fetch('{{ route("cart.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: parseInt(productId), quantity: 1 })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    this.disabled = false;
                    if (data && data.status === 'success') {
                        // Notifikasi sukses dihilangkan sesuai request
                        // showToast(data.message || 'Ditambahkan ke keranjang', 'success');
                    } else {
                        showToast(data?.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showToast('Gagal menambahkan ke keranjang', 'error');
                    this.disabled = false;
                });
            });
        });
    } catch (err) {
        console.error('Script initialization error:', err);
    }
})();
</script>
@endpush
