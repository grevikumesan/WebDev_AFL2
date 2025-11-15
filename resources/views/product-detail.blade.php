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

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="fw-bold mb-0" style="color:#2d5a3a;">{{ $product -> name }}</h1>
                    
                     <button class="btn wishlist-btn p-0 border-0"
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

                <h5 class="fw-bold mt-4" style="color:#2e5947;">Deskripsi Produk:</h5>

                <p class="mt-2" style="line-height:1.7; color:#3e6454;">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>

                {{-- Quantity + Keranjang --}}
                <div class="mt-4">
                    <div class="d-flex align-items-end gap-3 mb-4">

                        {{-- Quantity --}}
                        <div style="max-width:130px;">
                            <label class="fw-bold mb-1" style="color:#2e5947;">Jumlah:</label>
                            <div class="d-flex align-items-center"
                                 style="background:#eafaf1; border:1px solid #bcead5; border-radius:10px; padding:6px 10px; height: 44px;"> 
                                
                                <button type="button" onclick="changeQty(-1)" style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">-</button>
                                <input id="qtyInput" type="text" value="1"
                                       class="form-control text-center mx-2"
                                       style="width:50px; border:none; background:transparent; color:#2e5947; font-weight:600;"
                                       readonly>
                                <button type="button" onclick="changeQty(1)" style="background:none; border:none; font-size:20px; font-weight:bold; color:#2d5a3a;">+</button>
                            </div>
                        </div>

                        {{-- Tombol Ikon Tambah Keranjang --}}
                        <button class="btn ms-2"
                                style="background-color:#bcead5; color:#2d5a3a; border:none; border-radius:10px; height: 44px; width: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="bi bi-cart-plus-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        

{{-- ikon hati --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        // Inisialisasi ikon hati kosong 
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