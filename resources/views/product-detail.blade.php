@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('main_content')
    @if($product)
        <div class="row align-items-center">
            <!-- gambar produk -->
            <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset('images/' . $product -> image) }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $product -> name }}"
                     style="border-radius:18px; max-height:400px; object-fit:cover;">
            </div>

            <!-- desc -->
            <div class="col-md-6" style="color:#335b48;">
                <span class="badge rounded-pill mb-3 px-3 py-2"
                      style="background-color:#bcead5; color:#2d5a3a; font-weight:500;">
                    {{ $product->category->name }}
                </span>

                <h1 class="fw-bold mb-3" style="color:#2d5a3a;">{{ $product -> name }}</h1>
                <p class="fw-bold fs-4" style="color:#3b7d5e;">
                    {{-- num formatter --}}
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                    @if($product->unit)
                        / {{ $product->unit }}
                    @endif
                </p>

                <h5 class="fw-bold mt-4" style="color:#2e5947;">Deskripsi Produk:</h5>

                {{-- isi deskripsi produk --}}
                <p class="mt-2" style="line-height:1.7; color:#3e6454;">
                    {{-- ternary if ada, tunjukin, else Tidak ada desc... --}}
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>

                <div class="mt-4">
                    <a href="/products"
                       class="btn"
                       style="background-color:#bcead5; color:#2d5a3a; border:none; border-radius:10px; font-weight:500; padding:10px 20px; transition:all 0.3s;">
                        Kembali ke Produk
                    </a>
                </div>
            </div>
        </div>
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
