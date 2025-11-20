@extends('layouts.main')

@section('title', 'Dashboard')

@section('main_content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Dashboard Overview</h3>
        <span class="text-muted">Halo, Admin! 👋</span>
    </div>

    {{-- ROW 1: KARTU STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #198754, #20c997);">
                <div class="card-body">
                    <h6 class="text-white-50">Total Pendapatan</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <small><i class="bi bi-cash-stack me-1"></i> Dari pesanan lunas</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #0dcaf0, #3d8bfd);">
                <div class="card-body">
                    <h6 class="text-white-50">Menunggu Konfirmasi</h6>
                    <h3 class="fw-bold mb-0">{{ $pendingOrders }}</h3>
                    <small><i class="bi bi-hourglass-split me-1"></i> Perlu dicek</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Total Produk</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalProducts }}</h3>
                    <small class="text-success"><i class="bi bi-box-seam me-1"></i> Stok tersedia</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-body">
                    <h6 class="text-muted">Total Pelanggan</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalCustomers }}</h3>
                    <small class="text-primary"><i class="bi bi-people me-1"></i> User terdaftar</small>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 2: TABEL PESANAN TERBARU --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Pesanan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $badges = [
                                                'unpaid' => 'warning', 'pending' => 'info',
                                                'paid' => 'success', 'completed' => 'primary', 'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $badges[$order->status] }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light border">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none fw-bold small">Lihat Semua Pesanan &rarr;</a>
                </div>
            </div>
        </div>

        {{-- SIDEBAR MINI: MENU CEPAT --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success py-2 text-start">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary py-2 text-start">
                            <i class="bi bi-people me-2"></i> Kelola User
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary py-2 text-start">
                            <i class="bi bi-receipt me-2"></i> Cek Pesanan Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
