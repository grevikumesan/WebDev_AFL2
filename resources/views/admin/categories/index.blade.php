@extends('layouts.main')

@section('main_content')
<div class="container-fluid px-2 px-md-3 px-lg-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2 mb-3 mb-md-4">
        <h3 class="fw-bold text-dark fs-5 fs-md-4">Kelola Kategori</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success fw-bold px-3 px-md-4 fs-7 fs-md-6">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-7 fs-md-6 py-2 py-md-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show fs-7 fs-md-6 py-2 py-md-3" role="alert">
            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-7 fs-md-6">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-2 ps-md-4 py-2 py-md-3">Nama Kategori</th>
                            <th class="ps-1 ps-md-2">Jumlah Produk</th>
                            <th class="ps-1 ps-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="ps-2 ps-md-4 fw-bold">{{ $category->name }}</td>
                            <td class="ps-1 ps-md-2">
                                <span class="badge bg-info text-white">{{ $category->products_count }}</span>
                            </td>
                            <td class="ps-1 ps-md-2">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-warning text-white p-1 p-md-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus kategori ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger p-1 p-md-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 py-md-5 text-muted">
                                <i class="bi bi-tag display-6 d-block mb-2 opacity-50"></i>
                                <small class="fs-7">Belum ada kategori.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-2 p-md-3 d-flex justify-content-end">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

