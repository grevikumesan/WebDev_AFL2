@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('main_content')
    <div class="row">
        <div class="col">
            <h1 class="d-flex justify-content-between align-items-center">
                <span>Keranjang Belanja</span>
                <span>Barang</span>
            </h1>

            @if($cartItems->isEmpty())
                <p>Keranjang kosong.</p>
            @else
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>

                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
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
    </div>
@endsection
