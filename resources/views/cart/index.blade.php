@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('main_content')
<div class="container mt-5">
    <h1 class="text-center fw-bold text-success mb-5">Keranjang Belanja</h1>

    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p class="text-center text-muted">Keranjang kosong. Tambahkan produk favoritmu!</p>
    @else
        <div class="row g-4">
            @foreach($cartItems as $item)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm rounded-4 d-flex flex-column overflow-hidden">
                        <!-- Gambar Produk -->
                        <div class="product-image" style="height:150px; overflow:hidden; display:flex; justify-content:center; align-items:center;">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('images/' . $item->product->image) }}"
                                     alt="{{ $item->product->name }}"
                                     style="max-height:100%; max-width:100%; object-fit:contain;">
                            @else
                                <div class="bg-secondary text-white w-100 h-100 d-flex align-items-center justify-content-center">No Image</div>
                            @endif
                        </div>

                        <!-- Info Produk & Aksi -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-success mb-2">
                                {{ $item->product->name ?? 'Produk tidak ditemukan' }}
                            </h5>

                            <!-- Harga Satuan -->
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                <i class="bi bi-tag"></i> Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }} / pcs
                            </p>

                            <!-- Form Update Quantity -->
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PATCH')

                                <!-- Quantity Controls dengan Tombol +/- -->
                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                                     style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary"
                                            onclick="updateQuantity({{ $item->id }}, -1, {{ $item->product->price ?? 0 }})"
                                            style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-dash fw-bold"></i>
                                    </button>

                                    <input type="number"
                                           name="quantity"
                                           id="qty-{{ $item->id }}"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           class="form-control form-control-sm text-center mx-2"
                                           style="width:60px; font-weight: 600; border: none; background: transparent;"
                                           onchange="updateSubtotal({{ $item->id }}, {{ $item->product->price ?? 0 }})"
                                           readonly>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary"
                                            onclick="updateQuantity({{ $item->id }}, 1, {{ $item->product->price ?? 0 }})"
                                            style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-plus fw-bold"></i>
                                    </button>
                                </div>

                                <!-- Subtotal Display -->
                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded"
                                     style="background-color: #e8f5e9;">
                                    <span class="fw-semibold text-success" style="font-size: 0.9rem;">Subtotal:</span>
                                    <span class="fw-bold text-success" id="subtotal-{{ $item->id }}">
                                        Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Tombol Update (Pindah ke bawah) -->
                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="bi bi-arrow-repeat"></i> Update Keranjang
                                </button>
                            </form>

                            <!-- Form Hapus Item -->
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Belanja (Summary) -->
        <div class="row mt-5">
            <div class="col-md-4 ms-auto">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="bi bi-receipt"></i> Ringkasan Belanja
                        </h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item:</span>
                            <span class="fw-semibold">{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Total Harga:</span>
                            <span class="fw-bold text-success fs-5">
                                Rp {{ number_format($cartItems->sum(function($item) {
                                    return ($item->product->price ?? 0) * $item->quantity;
                                }), 0, ',', '.') }}
                            </span>
                        </div>
                        <button class="btn btn-success w-100 py-2 fw-semibold">
                            <i class="bi bi-cart-check-fill"></i> Lanjut ke Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
// Function untuk update quantity dengan tombol +/-
function updateQuantity(itemId, delta, price) {
    const qtyInput = document.getElementById(`qty-${itemId}`);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + delta;

    // Validasi minimum 1
    if (newQty < 1) {
        newQty = 1;
    }

    qtyInput.value = newQty;
    updateSubtotal(itemId, price);
}

// Function untuk update subtotal display (real-time)
function updateSubtotal(itemId, price) {
    const qtyInput = document.getElementById(`qty-${itemId}`);
    const subtotalElement = document.getElementById(`subtotal-${itemId}`);

    const quantity = parseInt(qtyInput.value) || 1;
    const subtotal = price * quantity;

    // Format rupiah Indonesia
    subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
}
</script>
@endpush
@endsection
