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
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm"
                        style="background-color:#ffffff; border-radius:16px; overflow:hidden;">

                        {{-- Wrapper Gambar --}}
                        <div style="
                            width:100%;
                            height:250px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            background-color:#f7faf9;
                            border-top-left-radius:16px;
                            border-top-right-radius:16px;">
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

                            {{-- BOX INTERAKTIF (DIATAS TOMBOL) --}}
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

                                {{-- Tombol Tambah ke Keranjang --}}
                                <div class="d-inline-block">
                                    <button type="button"
                                            class="p-0 border-0 add-to-cart-btn" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-stock="{{ $product->stock }}"
                                            style="background:none; color:#2d5a3a; cursor:pointer;">
                                        <i class="bi bi-cart-plus-fill fs-3"></i>
                                    </button>
                                </div>

                                {{-- Tombol Wishlist --}}
                                <button class="p-0 border-0 wishlist-btn" 
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Wishlist
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');
            if (icon.classList.contains('bi-heart-fill')) {
                icon.classList.add('text-danger'); 
                icon.style.color = '';
            } else {
                icon.classList.remove('text-danger');
                icon.style.color = '#3b7d5e';
            }
        });
    });

    // 2. Tombol Tambah ke Keranjang
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    const cardBody = btn.closest('.card-body');
    const cartBoxWrapper = cardBody.querySelector('.cart-box-wrapper');
    const btnAddCart = cartBoxWrapper.querySelector('.btn-add-cart');
    const addedMsg = cartBoxWrapper.querySelector('.added-msg');
    const maxStock = parseInt(btn.getAttribute('data-product-stock'));

    btn.addEventListener('click', () => {
        cartBoxWrapper.style.display = cartBoxWrapper.style.display === 'none' ? 'block' : 'none';
        const qtyInput = cartBoxWrapper.querySelector('.qty-input');
        const btnIncrease = cartBoxWrapper.querySelector('.btn-increase');
        const btnDecrease = cartBoxWrapper.querySelector('.btn-decrease');

        qtyInput.value = 1;
        addedMsg.style.display = 'none';
        btnAddCart.disabled = false;

        // --- + / - tombol ---
        btnIncrease.onclick = () => {
            let val = parseInt(qtyInput.value);
            if(val < maxStock) qtyInput.value = val + 1;
            else alert(`Stok maksimal: ${maxStock}`);
        };
        btnDecrease.onclick = () => {
            let val = parseInt(qtyInput.value);
            if(val > 1) qtyInput.value = val - 1;
        };
    });

    // Tombol Tambah ke cart
    btnAddCart.addEventListener('click', () => {
        const qtyInput = cartBoxWrapper.querySelector('.qty-input');
        const productId = btn.getAttribute('data-product-id');
        const quantity = parseInt(qtyInput.value);

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(res => res.json())
        .then(data => {
            addedMsg.style.display = 'block';
            btnAddCart.disabled = true;
        })
        .catch(err => {
            alert('Terjadi kesalahan, coba lagi.');
            console.error(err);
        });
    });
});

});
</script>
@endpush