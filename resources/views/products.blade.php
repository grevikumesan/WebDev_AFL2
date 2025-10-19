@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('main_content')
    <h1 class="text-center mb-5 fw-bold text-success" style="color:#2d5a3a !important;">
        Daftar Produk Kami
    </h1>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm"
                        style="background-color:#ffffff; border-radius:16px; overflow:hidden;">

                        <!-- Wrapper gambar agar ga nge-zoom -->
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
                                {{-- num formatter --}}
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                @if($product->unit)
                                    / {{ $product->unit }}
                                @endif
                            </p>

                            <a href="/product/{{ $product->id }}"
                               class="btn w-100"
                               style="background-color:#bcead5; color:#2d5a3a; border:none; font-weight:500; border-radius:10px; transition:all 0.3s;">
                                Lihat Detail
                            </a>
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
                    <a href="/products"
                       class="btn"
                       style="background-color:#bcead5; color:#2d5a3a; font-weight:500; border-radius:10px;">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection
