@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('main_content')
    @if($product)
        <div class="row align-items-start py-4">
            <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset('images/' . $product -> image) }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $product -> name }}"
                     style="border-radius:18px; max-height:400px; object-fit:cover;">
            </div>

            <div class="col-md-6" style="color:#335b48;">
                <span class="badge rounded-pill mb-3 px-3 py-2"
                      style="background-color:#bcead5; color:#2d5a3a; font-weight:500;">
                    {{ $product->category->name }}
                </span>

                <h1 class="fw-bold mb-3" style="color:#2d5a3a;">{{ $product -> name }}</h1>
                <p class="fw-bold fs-4" style="color:#3b7d5e;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                    @if($product->unit)
                        / {{ $product->unit }}
                    @endif
                </p>

                <h5 class="fw-bold mt-4" style="color:#2e5947;">Deskripsi Produk:</h5>

                <p class="mt-2" style="line-height:1.7; color:#3e6454;">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>

                {{-- quantity + cart + wishlist --}}

                <div class="mt-4">

                    {{-- QUANTITY (+/-) --}}
                    <div class="mb-3 text-start" style="max-width:150px;">
                        <label class="fw-bold mb-1" style="color:#2e5947;">Jumlah:</label>

                        <div class="d-flex align-items-center"
                             style="background:#eafaf1; border:1px solid #bcead5; border-radius:10px; padding:6px 10px;">

                            <button type="button"
                                    onclick="changeQty(-1)"
                                    style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">
                                -
                            </button>

                            <input id="qtyInput" type="text" value="1"
                                   class="form-control text-center mx-2"
                                   style="width:50px; border:none; background:transparent; color:#2e5947; font-weight:600;"
                                   readonly>

                            <button type="button"
                                    onclick="changeQty(1)"
                                    style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- BUTTON TAMBAH KERANJANG + FAVORIT --}}
                    <div class="d-flex align-items-center gap-3 mt-4">

                        {{-- 1. TOMBOL FAVORIT --}}
                        <button class="btn wishlist-btn order-first p-0 border-0"
                                style="font-size: 1.8rem; color:#3b7d5e; background:none;">
                            {{-- Menggunakan bi-heart agar JS bisa toggle --}}
                            <i class="bi bi-heart"></i> 
                        </button>
                        
                        {{-- 2. TOMBOL TAMBAH KERANJANG --}}
                        <button class="btn flex-grow-1"
                                style="background-color:#bcead5; color:#2d5a3a; border:none; border-radius:10px;
                                        font-weight:600; padding:10px 20px; transition:all 0.3s;">
                            Tambah Keranjang
                        </button>
                    </div>

                    {{-- KEMBALI  --}}
                    <div class="mt-4">
                        <a href="/products"
                           class="btn"
                           style="background-color:#eafaf1; border:1px solid #bcead5; color:#2d5a3a; border-radius:10px; font-weight:500; padding:10px 20px;">
                            <i class="bi bi-arrow-left"></i> Kembali ke Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- buat mengubah kuantitas --}}
        <script>
            function changeQty(val) {
                let qty = document.getElementById('qtyInput');
                let current = parseInt(qty.value);

                if (current + val >= 1) {
                    qty.value = current + val;
                }
            }
        </script>

    @else
        <div class="alert text-center mt-5"
             style="background-color:#eafaf1; color:#335b48; border:1px solid #bcead5; border-radius:12px;">
            <h4 class="fw-bold">Produk tidak ditemukan</h4>
            <a href="/products"
               class="btn mt-3"
               style="background-color:#bcead5; color:#2d5a3a; border:none; border-radius:10px; font-weight:500;">
                Kembali ke Produk
            </a>
        </div>
    @endif
@endsection

{{-- buat hati biar bisa jadi warna merah --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        // Asumsi icon awal adalah bi-heart (kosong)
        btn.innerHTML = '<i class="bi bi-heart"></i>';

        btn.addEventListener('click', function () {
            const icon = this.querySelector('i');

            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');
            icon.classList.toggle('text-danger'); 
        });
    });
});
</script>
@endpush