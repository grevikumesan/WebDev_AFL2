@extends('layouts.main')

@section('main_content')
<div class="container-fluid px-2 px-md-3 px-lg-4">
    <h3 class="fw-bold mb-3 mb-md-4 text-dark fs-5 fs-md-4">Kelola Pesanan Masuk</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-7 fs-md-6">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 py-md-3 ps-2 ps-md-4">ID</th>
                            <th class="ps-1 ps-md-2">Pelanggan</th>
                            <th class="ps-1 ps-md-2">Total</th>
                            <th class="ps-1 ps-md-2 d-none d-lg-table-cell">Bukti</th>
                            <th class="ps-1 ps-md-2">Status</th>
                            <th class="ps-1 ps-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-2 ps-md-4 fw-bold" style="font-size: 12px;">#{{ $order->id }}</td>

                            {{-- Info Pelanggan --}}
                            <td class="ps-1 ps-md-2">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold" style="font-size: 12px;">{{ $order->receiver_name }}</span>
                                    <small class="text-muted" style="font-size: 10px;">{{ $order->created_at->format('d M Y') }}</small>
                                </div>
                            </td>

                            {{-- Total --}}
                            <td class="fw-bold text-success ps-1 ps-md-2" style="font-size: 12px;">
                                <span class="d-block">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>

                            {{-- Bukti (Desktop Only) --}}
                            <td class="ps-1 ps-md-2 d-none d-lg-table-cell">
                                @if($order->payment_proof)
                                    <button class="btn btn-sm btn-outline-primary p-1" data-bs-toggle="modal" data-bs-target="#proofModal{{ $order->id }}">
                                        <i class="bi bi-image"></i> <span class="d-none d-md-inline">Lihat</span>
                                    </button>
                                    <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header py-2">
                                                    <h5 class="modal-title fs-7">Bukti #{{ $order->id }}</h5>
                                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center bg-light">
                                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded">
                                                </div>
                                                <div class="modal-footer py-2">
                                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-sm btn-secondary">Full Size</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-danger" style="font-size: 10px;">Belum upload</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="ps-1 ps-md-2">
                                @php
                                    $badges = [
                                        'unpaid' => 'warning text-dark',
                                        'pending' => 'info text-white',
                                        'completed' => 'success',
                                        'paid' => 'primary',
                                        'cancelled' => 'danger',
                                    ];
                                    $label = strtoupper($order->status);
                                    if($order->status == 'completed') $label = 'SELESAI';
                                    if($order->status == 'unpaid') $label = 'BELUM';
                                    if($order->status == 'pending') $label = 'TUNGGU';
                                @endphp
                                <span class="badge bg-{{ $badges[$order->status] ?? 'secondary' }}" style="font-size: 10px;">
                                    {{ $label }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="ps-1 ps-md-2">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle p-1" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        Ubah
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 dropdown-menu-sm" style="font-size: 12px;">
                                        @if($order->status == 'pending')
                                            <li>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button class="dropdown-item text-success fw-bold py-1" type="submit">
                                                        <i class="bi bi-check-circle me-1"></i>Terima
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="unpaid">
                                                    <button class="dropdown-item text-warning py-1" type="submit">
                                                        <i class="bi bi-x-circle me-1"></i>Tolak
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        @if($order->status != 'completed')
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button class="dropdown-item text-primary py-1" type="submit">Selesai</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 py-md-5 text-muted">
                                <i class="bi bi-inbox display-6 d-block mb-2 opacity-50"></i>
                                <small class="fs-7">Belum ada pesanan.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-2 p-md-3 d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
