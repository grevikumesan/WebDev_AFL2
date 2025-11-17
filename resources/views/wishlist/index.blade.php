@extends('layouts.main')

@section('title', 'Wishlist Saya')

@section('main_content')
<div class="container mt-4">
    <h1 class="mb-4">Wishlist Saya</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($wishlistItems->isEmpty())
        <p>Wishlist kosong.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wishlistItems as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
