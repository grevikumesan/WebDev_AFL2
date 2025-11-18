@extends('layouts.main')

@section('title', 'Wishlist Saya')

@section('main_content')
<div class="container mt-5">

    <h1 class="text-center fw-bold text-success mb-5"> Wishlist Saya</h1>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($wishlistItems->isEmpty())
        <p class="text-center text-muted">Wishlist kosong. Tambahkan produk favoritmu!</p>
    @else
        <div class="row g-4">
            @foreach($wishlistItems as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                        @if($product->image)
                            <div class="product-image mb-3" style="height:120px; overflow:hidden; display:flex; justify-content:center; align-items:center;">
                            @if($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="max-height:100%; max-width:100%; object-fit:contain;">
                            @else
                                <div class="bg-secondary text-white w-100 h-100 d-flex align-items-center justify-content-center">No Image</div>
                            @endif
                        </div>

                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                                No Image
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-success">{{ $product->name }}</h5>
                            <p class="card-text fw-medium mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-auto d-flex gap-2">
                                <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">Hapus</button>
                                </form>
                                <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection