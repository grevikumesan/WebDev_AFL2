@extends('layouts.main')

@section('title', 'Checkout')

@section('main_content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="receiver_name" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp / HP</label>
                            <input type="text" name="receiver_phone" class="form-control" placeholder="Contoh: 08123..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Nama jalan, RT/RW, Kelurahan..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Jangan dibanting"></textarea>
                        </div>

                        <button type="submit" id="submit-btn" class="d-none"></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @php $grandTotal = 0; @endphp
                        @foreach($cartItems as $item)
                            @php $total = $item->product->price * $item->quantity; $grandTotal += $total; @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="my-0">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="text-muted">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 mt-3" style="border-top: 2px solid #f0f0f0;">
                            <span>Total Pembayaran</span>
                            <span style="color: #2d5a3a;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </li>
                    </ul>

                    <button onclick="document.getElementById('submit-btn').click()" class="btn w-100 py-3 fw-bold text-white" style="background-color: #25D366;">
                        <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
