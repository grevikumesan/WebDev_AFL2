@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('main_content')
<div class="container mt-5 mb-5">
    <div class="mb-4">
        <h2 class="fw-bold" style="color: #2d5a3a; font-size: 2rem;">Keranjang Belanja</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <h6 class="text-secondary fw-semibold">Keranjang kosong</h6>
            <p class="text-secondary small mb-4">Belum ada produk yang masuk di keranjang belanja</p>
            <a href="{{ route('products.index') }}" class="btn" style="background: #2d5a3a; color: #fff; border-radius: 8px; font-weight: 500;">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-list">
                    @foreach($cartItems as $item)
                    <div class="cart-item" id="item-row-{{ $item->id }}">
                        <div class="item-image">
                            <a href="{{ route('products.show', $item->product->id) }}">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted small">No Image</div>
                                @endif
                            </a>
                        </div>

                        <div class="item-content">
                            <a href="{{ route('products.show', $item->product->id) }}" class="item-name">
                                {{ $item->product->name }}
                            </a>
                            @if($item->product->category)
                                <p class="item-category">{{ $item->product->category->name }}</p>
                            @endif

                            <p class="item-price mb-1" data-price="{{ $item->product->price }}">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </p>

                            <div class="item-subtotal-wrapper">
                                <small class="text-secondary">Subtotal:</small>
                                <span class="item-subtotal-value" id="subtotal-display-{{ $item->id }}">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="item-actions-wrapper">
                            <div class="qty-control">
                                <button type="button" class="qty-btn minus" onclick="updateCartItem({{ $item->id }}, -1)">
                                    <i class="bi bi-dash"></i>
                                </button>

                                <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" readonly class="qty-input">

                                <button type="button" class="qty-btn plus" onclick="updateCartItem({{ $item->id }}, 1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Hapus item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card">
                    <h5 class="summary-title">Ringkasan Belanja</h5>

                    <div class="summary-row">
                        <span class="text-secondary">Total Item</span>
                        <span class="fw-semibold" id="total-items-display">{{ $cartItems->sum('quantity') }}</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row total">
                        <span>Total Harga</span>
                        <span class="total-amount" id="grand-total-display">
                            Rp {{ number_format($cartItems->sum(function($item) {
                                return $item->product->price * $item->quantity;
                            }), 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout">
                        Lanjut ke Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Layout Kiri: Cart List */
    .cart-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item:hover {
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        border-color: #e8e8e8;
    }

    .item-image {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        background: #f8f8f8;
        border-radius: 8px;
        overflow: hidden;
        margin-right: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-image img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    .item-content {
        flex: 1;
        margin-right: 1rem;
    }

    .item-name {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        text-decoration: none;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .item-category {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-size: 1rem; /* Sedikit diperkecil karena ada subtotal */
        font-weight: 600;
        color: #555;
        margin: 0;
    }

    /* Style Baru untuk Subtotal Item */
    .item-subtotal-wrapper {
        margin-top: 0.25rem;
        font-size: 0.95rem;
    }

    .item-subtotal-value {
        font-weight: 700;
        color: #2d5a3a; /* Hijau Utama */
    }

    /* Layout Tengah Kanan: Actions Wrapper */
    .item-actions-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Quantity Control Styles */
    .qty-control {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        height: 38px;
    }

    .qty-btn {
        width: 32px;
        height: 100%;
        border: none;
        background: transparent;
        color: #555;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .qty-btn:hover {
        background: #f5f5f5;
        color: #2d5a3a;
    }

    .qty-input {
        width: 40px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
        outline: none;
        background: transparent;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Delete Button Style */
    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        background: #fafafa;
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .delete-btn:hover {
        background: #ffe8e8;
        border-color: #ef9a9a;
        color: #d32f2f;
    }

    /* Layout Kanan: Summary Card */
    .summary-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 1.5rem;
        position: sticky;
        top: 2rem; /* Sticky saat discroll */
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .summary-title {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.25rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 1rem 0;
    }

    .summary-row.total {
        margin-bottom: 1.5rem;
    }

    .summary-row.total span {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .total-amount {
        color: #2d5a3a !important;
        font-size: 1.25rem !important;
    }

    .btn-checkout {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        padding: 0.85rem;
        background: #2d5a3a;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-checkout:hover {
        background: #244a30;
        color: white;
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .item-image {
            margin-bottom: 1rem;
        }
        .item-actions-wrapper {
            width: 100%;
            justify-content: space-between;
            margin-top: 1rem;
        }
        .summary-card {
            position: static;
            margin-top: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Helper format rupiah
    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    function updateCartItem(itemId, delta) {
        const qtyInput = document.getElementById(`qty-${itemId}`);
        const itemRow = document.getElementById(`item-row-${itemId}`);

        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + delta;

        if (newQty < 1) return; // Tidak boleh kurang dari 1

        // 1. Update Input Qty Visual
        qtyInput.value = newQty;

        // 2. Update Subtotal Per Produk (Visual)
        const priceVal = parseFloat(itemRow.querySelector('.item-price').getAttribute('data-price')) || 0;
        const newSubtotal = priceVal * newQty;

        // Target element subtotal produk
        const subtotalDisplay = document.getElementById(`subtotal-display-${itemId}`);
        if(subtotalDisplay) {
            subtotalDisplay.textContent = formatRupiah(newSubtotal);
        }

        // 3. Hitung Ulang Total Ringkasan (Visual)
        recalculateGrandTotal();

        // 4. Kirim Update ke Server (Background)
        fetch(`/cart/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PATCH',
                quantity: newQty
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                console.error('Gagal update keranjang di server');
            }
        })
        .catch(err => console.error('Error:', err));
    }

    function recalculateGrandTotal() {
        let totalAmount = 0;
        let totalItems = 0;
        const items = document.querySelectorAll('.cart-item');

        items.forEach(item => {
            const qtyVal = parseInt(item.querySelector('.qty-input').value) || 0;
            const priceVal = parseFloat(item.querySelector('.item-price').getAttribute('data-price')) || 0;

            totalAmount += (qtyVal * priceVal);
            totalItems += qtyVal;
        });

        // Update Ringkasan di Kanan
        document.getElementById('grand-total-display').textContent = formatRupiah(totalAmount);
        document.getElementById('total-items-display').textContent = totalItems;
    }
</script>
@endpush
