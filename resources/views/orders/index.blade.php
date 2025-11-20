@extends('layouts.main')

@section('title', 'Pesanan Saya')

@section('main_content')
<div class="container mt-5 mb-5">
    <h2 class="fw-bold mb-4 text-center" style="color: #2d5a3a;">Riwayat Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-unpaid" type="button">Belum Bayar</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button">Menunggu Konfirmasi</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-history" type="button">Riwayat Selesai</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        {{-- TAB 1: BELUM BAYAR --}}
        <div class="tab-pane fade show active" id="pills-unpaid">
            @forelse($orders->where('status', 'unpaid') as $order)
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold">Order #{{ $order->id }}</h5>
                            <span class="badge bg-warning text-dark">Belum Dibayar</span>
                        </div>

                        {{-- List Barang --}}
                        @foreach($order->items as $item)
                            <div class="d-flex align-items-center mb-2">
                                {{-- Gambar Kecil --}}
                                <img src="{{ asset('images/' . $item->product->image) }}"
                                     alt="{{ $item->product->name }}"
                                     class="rounded me-2 border"
                                     style="width: 40px; height: 40px; object-fit: cover;">

                                <div>
                                    <p class="mb-0 small fw-semibold">{{ $item->product->name }}</p>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                            <h6 class="fw-bold text-success">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h6>

                            {{-- Tombol Upload --}}
                            <button class="btn btn-success btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $order->id }}">
                                <i class="bi bi-upload me-1"></i> Upload Bukti Bayar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal Upload (Sama seperti sebelumnya) --}}
                <div class="modal fade" id="uploadModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Upload Bukti Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('orders.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Total Tagihan</label>
                                        <input type="text" class="form-control" value="Rp {{ number_format($order->total_price, 0, ',', '.') }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Bukti Transfer <span class="text-danger">*</span></label>
                                        <input type="file" name="payment_proof" class="form-control" required accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success w-100 fw-bold">Kirim Bukti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Tidak ada tagihan belum dibayar.</div>
            @endforelse
        </div>

        {{-- TAB 2: MENUNGGU KONFIRMASI (UPDATED) --}}
        <div class="tab-pane fade" id="pills-pending">
            @forelse($orders->where('status', 'pending') as $order)
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold">Order #{{ $order->id }}</h5>
                            <span class="badge bg-info text-white">Menunggu Konfirmasi</span>
                        </div>

                        {{-- LIST BARANG YANG DIBELI --}}
                        <div class="mb-3 pb-2 border-bottom">
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-center mb-2">
                                    {{-- Gambar Produk --}}
                                    <img src="{{ asset('images/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="rounded me-3 border bg-light"
                                         style="width: 50px; height: 50px; object-fit: cover;">

                                    {{-- Detail Nama & Qty --}}
                                    <div>
                                        <h6 class="mb-0 small fw-bold">{{ $item->product->name }}</h6>
                                        <small class="text-muted">
                                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total Harga --}}
                        <div class="d-flex justify-content-end mb-3">
                            <span class="fw-bold text-dark">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        {{-- Alert Status --}}
                        <div class="alert alert-info mb-0 small">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hourglass-split fs-5 me-3"></i>
                                <div>
                                    <strong>Bukti pembayaran sedang diperiksa oleh Admin.</strong><br>
                                    <span class="text-muted">Status akan berubah otomatis setelah dikonfirmasi.</span>
                                </div>
                            </div>
                            @if($order->payment_proof)
                                <div class="mt-2 ps-4 ms-2">
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="fw-bold text-decoration-none">
                                        <i class="bi bi-image me-1"></i>Lihat bukti yang diupload
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Tidak ada pesanan menunggu konfirmasi.</div>
            @endforelse
        </div>

        {{-- TAB 3: RIWAYAT SELESAI --}}
        <div class="tab-pane fade" id="pills-history">
            @forelse($orders->whereIn('status', ['paid', 'completed', 'cancelled']) as $order)
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold">Order #{{ $order->id }}</h5>
                            @if($order->status == 'paid' || $order->status == 'completed')
                                <span class="badge bg-success">Lunas / Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </div>

                         {{-- List Barang History (Opsional biar lengkap) --}}
                         @foreach($order->items as $item)
                            <p class="mb-1 small text-muted">
                                {{ $item->product->name }} ({{ $item->quantity }}x)
                            </p>
                        @endforeach

                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <span class="text-muted small">Tanggal: {{ $order->created_at->format('d M Y') }}</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">Belum ada riwayat pesanan.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link { color: #555; font-weight: 600; }
    .nav-pills .nav-link.active { background-color: #2d5a3a; color: #fff; }
</style>
@endpush
