@extends('layouts.main')

@section('main_content')
    <div class="container-fluid px-2 px-md-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-2 py-md-3">
                        <h5 class="mb-0 fw-bold fs-6 fs-md-5">Tambah Produk Baru</h5>
                    </div>
                    <div class="card-body p-2 p-md-3">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama Produk --}}
                            <div class="mb-2 mb-md-3">
                                <label class="form-label fs-7 fs-md-6">Nama Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-2 mb-md-3">
                                <label class="form-label fs-7 fs-md-6">Kategori <span class="text-danger">*</span></label>

                                {{-- PENTING: name harus 'category_id', bukan 'category' --}}
                                <select name="category_id"
                                    class="form-select form-select-sm @error('category_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>

                                    {{-- Loop Kategori dari Database --}}
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-2">
                                {{-- Harga --}}
                                <div class="col-6 col-md-12 mb-2 mb-md-3">
                                    <label class="form-label fs-7 fs-md-6">Harga (Rp) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="price"
                                        class="form-control form-control-sm @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback fs-8">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="col-6 col-md-12 mb-2 mb-md-3">
                                    <label class="form-label fs-7 fs-md-6">Stok Awal <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="stock"
                                        class="form-control form-control-sm @error('stock') is-invalid @enderror"
                                        value="{{ old('stock') }}" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback fs-8">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Satuan --}}
                            <div class="mb-2 mb-md-3">
                                <label class="form-label fs-7 fs-md-6">Satuan (Unit)</label>
                                <input type="text" name="unit" class="form-control form-control-sm"
                                    placeholder="Contoh: kg, pcs" value="{{ old('unit') }}">
                            </div>

                            {{-- Gambar --}}
                            <div class="mb-3 mb-md-4">
                                <label class="form-label fs-7 fs-md-6">Foto Produk</label>
                                <input type="file" name="image"
                                    class="form-control form-control-sm @error('image') is-invalid @enderror"
                                    accept="image/*">
                                <small class="text-muted fs-8">JPG, PNG. Max 2MB.</small>
                                @error('image')
                                    <div class="invalid-feedback fs-8">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between">
                                <a href="{{ route('admin.products.index') }}"
                                    class="btn btn-secondary btn-sm fs-7 fs-md-6">Batal</a>
                                <button type="submit" class="btn btn-success fw-bold btn-sm fs-7 fs-md-6">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
