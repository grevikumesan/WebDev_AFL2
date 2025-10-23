@extends('layouts.main')

@section('title', 'Kontak Kami')

@section('main_content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="text-center mb-5 fw-bold text-success-emphasis">Kontak Kami</h1>

            <div class="card shadow-sm border-0 rounded-4" style="background-color: #f5fff5;">
                <div class="card-body p-5">

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-success">📍 Alamat:</h5>
                        <p class="text-muted">Jl. Raya Perning No. 358, Kec. Jetis, Kabupaten Mojokerto</p>
                    </div>

                    {{-- Telepon --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-success">📞 Telepon:</h5>
                        <p class="text-muted">0856-5507-8878 - Fenny</p>
                    </div>

                    {{-- Jam Buka --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-success">🕓 Jam Buka:</h5>
                        <p class="text-muted">Senin-Jumat : 08.00 - 17.00<br></p>
                    </div>

                    {{-- Info tambahan --}}
                    <div class="alert alert-success mt-4 border-0 rounded-3" style="background-color: #d8f8d8; color:#2f5e2f;">
                        <strong>💡 Info:</strong> Untuk pemesanan dalam jumlah besar, silakan hubungi kami terlebih dahulu
                        untuk memastikan ketersediaan stok.
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
