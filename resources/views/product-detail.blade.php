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
                             style="font-size: 2rem; color:#3b7d5e; background:none; line-height: 1;">
                         {{-- Ikon akan diisi oleh JS, awalnya biarkan kosong atau bi-heart --}}
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

                <h5 class="fw-bold mt-4" style="color:#2e5947;">Deskripsi Produk:</h5>

                <p class="mt-2" style="line-height:1.7; color:#3e6454;">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>

                {{-- FORM QUANTITY + KERANJANG --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
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

                        {{-- Tombol Tambah Keranjang (Submit Form) --}}
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
@endsection

{{-- JAVASCRIPT --}}
@push('scripts')
<script>
    // --- FUNGSI 1: MENGATUR KUANTITAS ---
    function changeQty(delta) {
        const qtyInput = document.getElementById('qtyInput');
        let currentQty = parseInt(qtyInput.value);
        let maxStock = parseInt("{{ $product->stock ?? 0 }}"); // Ambil stok dari Blade

        let newQty = currentQty + delta;

        // Batasan: minimal 1
        if (newQty < 1) {
            newQty = 1;
        }

        // Batasan: maksimal sesuai stok
        if (newQty > maxStock) {
            // Opsional: berikan feedback ke user jika stok habis
            alert(`Maaf, stok maksimal hanya ${maxStock}.`);
            newQty = maxStock;
        }

        qtyInput.value = newQty;
    }

    // --- FUNGSI 2: WISHLIST (Ikon Hati) ---
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');

                // Toggle ikon dan warna
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
                
                // Tambahkan/Hapus warna merah (text-danger)
                if (icon.classList.contains('bi-heart-fill')) {
                    icon.classList.add('text-danger'); 
                    icon.style.color = ''; // Biarkan class mengatur warna
                } else {
                    icon.classList.remove('text-danger');
                    icon.style.color = '#3b7d5e'; // Kembali ke warna default hijau
                }

                // IDEALNYA: Kirim AJAX request ke rute 'wishlist.add' atau 'wishlist.remove' di sini.
                console.log('Wishlist status diubah (simulasi).');
            });
        });
    });
</script>
@endpush