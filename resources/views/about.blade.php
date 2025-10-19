@extends('layouts.main')

@section('title')
    {{ $title }} {{-- dari controller --}}
@endsection

@section('main_content')
    <!-- Title-->
    <section class="py-5 text-center bg-light shadow-sm mb-5">
        <div class="container">
            <h1 class="display-5 fw-bold text-success mb-3">{{ $title }}</h1>
            <p class="lead text-muted">Tempat Anda mendapatkan kebutuhan pokok berkualitas sejak 2010</p>
        </div>
    </section>

    <!-- About -->
    <section class="container mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('images/aboutwebdev.jpg') }}"
                     alt="Tentang Kami"
                     class="img-fluid rounded-4 shadow-lg">
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
                    <h3 class="fw-bold text-success mb-3">Siapa Kami?</h3>
                    <p class="text-muted" style="text-align: justify;">
                        {{ $description }} {{-- dari controller --}}
                    </p>

                    <h4 class="fw-bold text-success mt-4">Visi Kami</h4>
                    <p class="text-muted">
                        Menjadi toko sembako terpercaya yang selalu menyediakan kebutuhan rumah tangga dengan harga bersahabat dan pelayanan terbaik.
                    </p>

                    <h4 class="fw-bold text-success mt-4">Misi Kami</h4>
                    <ul class="text-muted">
                        <li>Menyediakan produk berkualitas dengan harga kompetitif.</li>
                        <li>Memberikan pelayanan cepat, ramah, dan terpercaya.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Toko -->
    <section class="bg-success bg-opacity-10 py-5">
        <div class="container text-center">
            <h2 class="fw-bold text-success mb-4">Nilai-Nilai Kami</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="display-5 text-success mb-3">🤝</div>
                        <h5 class="fw-bold">Kepercayaan</h5>
                        <p class="text-muted">Kami membangun hubungan jangka panjang dengan pelanggan melalui kejujuran dan integritas.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="display-5 text-success mb-3">💚</div>
                        <h5 class="fw-bold">Pelayanan</h5>
                        <p class="text-muted">Setiap pelanggan adalah prioritas. Kami melayani dengan sepenuh hati dan profesional.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="display-5 text-success mb-3">🌿</div>
                        <h5 class="fw-bold">Kualitas</h5>
                        <p class="text-muted">Kami memastikan setiap produk yang dijual memenuhi standar kualitas terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
