<div class="card mb-3 shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            <span class="fw-bold text-dark">Order #{{ $order->id }}</span>
            <span class="text-muted small ms-2">{{ $order->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div>
            @php
                $badges = [
                    'unpaid' => 'bg-warning text-dark',
                    'pending' => 'bg-info text-white',
                    'paid' => 'bg-success',
                    'completed' => 'bg-primary',
                    'cancelled' => 'bg-danger',
                ];
                $labels = [
                    'unpaid' => 'Belum Bayar',
                    'pending' => 'Menunggu Admin',
                    'paid' => 'Dibayar',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }} rounded-pill px-3">
                {{ $labels[$order->status] ?? $order->status }}
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- List Produk --}}
            <div class="col-md-8">
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('images/' . $item->product->image) }}"
                             style="width:50px; height:50px; object-fit:cover; border-radius:6px;" class="me-3 bg-light">
                        <div>
                            <h6 class="mb-0 small fw-bold">{{ $item->product->name }}</h6>
                            <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3 pt-2 border-top">
                    <span class="fw-bold">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="col-md-4 d-flex flex-column justify-content-center align-items-end gap-2 mt-3 mt-md-0">

                @if($action == 'upload')
                    <p class="text-muted small text-end mb-1">Silakan transfer & upload bukti.</p>
                    <button type="button" class="btn btn-success btn-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $order->id }}">
                        <i class="bi bi-upload me-1"></i> Upload Bukti
                    </button>
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="w-100">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Yakin batalkan pesanan?')">Batalkan</button>
                    </form>

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
                                            <label class="form-label">Pilih Foto Bukti Transfer</label>
                                            <input type="file" name="payment_proof" class="form-control" required accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success w-100">Kirim Bukti</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @elseif($action == 'waiting')
                    <div class="alert alert-info py-2 px-3 small mb-0 w-100 text-center">
                        <i class="bi bi-hourglass-split"></i> Sedang dicek admin
                    </div>
                    @if($order->payment_proof)
                        <a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">Lihat Bukti Anda</a>
                    @endif

                @elseif($action == 'history')
                    @if($order->status == 'paid')
                         <div class="alert alert-success py-1 px-2 small mb-0 w-100 text-center">Pembayaran Diterima</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
