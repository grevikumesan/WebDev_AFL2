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
                                <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="max-height:100%; max-width:100%; object-fit:contain;">
                            @else
                                <div class="bg-secondary text-white w-100 h-100 d-flex align-items-center justify-content-center">No Image</div>
                            @endif
                        </div>

                        <!-- Info Produk & Aksi -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-success">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</h5>

                            <!-- Form Update Quantity -->
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex mb-2 gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width:70px;">
                                <button type="submit" class="btn btn-sm btn-primary flex-1">Update</button>
                            </form>

                            <!-- Form Hapus Item -->
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
