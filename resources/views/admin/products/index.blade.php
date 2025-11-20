@extends('layouts.main')

@section('main_content')
    <div class="container-fluid px-2 px-md-3 px-lg-4">
        {{-- Header & Tombol Tambah --}}
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2 mb-3 mb-md-4">
            <h3 class="fw-bold text-dark fs-5 fs-md-4">Kelola Produk</h3>
            <div class="d-flex gap-2 w-100 w-sm-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-info fw-bold px-2 px-md-3 fs-7 fs-md-6">
                    <i class="bi bi-tag me-1"></i> <span class="d-none d-sm-inline">Kategori</span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success fw-bold px-2 px-md-3 fs-7 fs-md-6">
                    <i class="bi bi-plus-lg me-1"></i> <span class="d-none d-sm-inline">Tambah Produk</span><span
                        class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fs-7 fs-md-6 py-2 py-md-3" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Produk --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 fs-7 fs-md-6">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-2 ps-md-4 py-2 py-md-3">Gambar</th>
                                <th class="ps-1 ps-md-2">Nama</th>
                                <th class="ps-1 ps-md-2 d-none d-lg-table-cell">Kategori</th>
                                <th class="ps-1 ps-md-2">Harga</th>
                                <th class="ps-1 ps-md-2 d-none d-md-table-cell">Stok</th>
                                <th class="ps-1 ps-md-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    {{-- Gambar --}}
                                    <td class="ps-2 ps-md-4">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="rounded border bg-light"
                                                style="width: 35px; height: 35px; object-fit: cover;">
                                        @else
                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted"
                                                style="width: 35px; height: 35px; font-size: 10px;">
                                                No Img
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Nama + Kategori Mobile --}}
                                    <td class="fw-bold text-dark ps-1 ps-md-2">
                                        <span class="d-block text-truncate">{{ $product->name }}</span>
                                        <span class="d-lg-none d-block text-muted fw-normal" style="font-size: 11px;">
                                            {{ $product->category?->name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    {{-- Kategori (Desktop Only) --}}
                                    <td class="ps-1 ps-md-2 d-none d-lg-table-cell">
                                        <span class="badge bg-secondary fw-normal px-2 py-1 rounded-pill"
                                            style="font-size: 11px;">
                                            {{ $product->category?->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>

                                    {{-- Harga --}}
                                    <td class="fw-bold text-success ps-1 ps-md-2">
                                        <span class="d-block" style="font-size: 12px;">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @if ($product->unit)
                                            <small class="text-muted fw-normal d-none d-sm-inline"
                                                style="font-size: 10px;">/ {{ $product->unit }}</small>
                                        @endif
                                    </td>

                                    {{-- Stok (Tablet & Up) --}}
                                    <td class="ps-1 ps-md-2 d-none d-md-table-cell">
                                        @if ($product->stock > 0)
                                            <span class="badge bg-success-subtle text-success border border-success fw-bold"
                                                style="font-size: 11px;">
                                                {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger fw-bold"
                                                style="font-size: 11px;">
                                                Habis
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="ps-1 ps-md-2">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning text-white p-1 p-md-2" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin hapus {{ $product->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger p-1 p-md-2"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 py-md-5 text-muted">
                                        <i class="bi bi-box-seam display-6 d-block mb-2 opacity-50"></i>
                                        <small class="fs-7">Belum ada produk.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-2 p-md-3 d-flex justify-content-end">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
