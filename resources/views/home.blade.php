@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('main_content')
    <section class="text-center py-5 shadow-sm"
             style="background: linear-gradient(135deg, #e8f5e9, #d9fdd3); border-radius: 0 0 40px 40px;">
        <div class="container">
            <h1 class="display-5 fw-bold text-success mb-3">🌿 Mau beli apa hari ini?</h1>
            <p class="lead text-muted mb-4">
                Kebutuhan pokok Anda, langsung dari <strong>Toko Wilujeng</strong>.
            </p>

            <!-- Search Bar -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <form action="/products" method="GET" class="d-flex bg-white shadow-lg rounded-pill p-2"
                          autocomplete="off"> {{-- hilangin riwayat input --}}
                        <input
                            type="text"
                            name="search"
                            class="form-control border-0 rounded-pill px-3 shadow-none"
                            placeholder="🔍 Cari produk... contoh: gula, rokok, sabun..."
                            style="font-size: 1.05rem; background-color: transparent; outline: none;"
                            autocomplete="off" {{-- hilangin riwayat input --}}
                        >
                        <button class="btn btn-soft-green rounded-pill px-4 fw-semibold shadow-none border-0" type="submit"
                                style="background-color: #81c784; color: white;">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <!-- kategori -->
            <h5 class="mt-5 text-secondary">Atau pilih kategori:</h5>
            <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                <a href="/products?kategori=Sembako"
                   class="btn btn-outline-success rounded-pill px-4 py-2 shadow-sm">
                    🥖 Sembako
                </a>
                <a href="/products?kategori=Rokok"
                   class="btn btn-outline-secondary rounded-pill px-4 py-2 shadow-sm">
                    🚬 Rokok
                </a>
                <a href="/products?kategori=Sampo%20%26%20Sabun"
                   class="btn btn-outline-success rounded-pill px-4 py-2 shadow-sm">
                    🧴 Sampo & Sabun
                </a>
            </div>
        </div>
    </section>

    <section class="container mt-5">
        <h2 class="text-center mb-5 fw-bold text-success">
            Kenapa Belanja di Toko Wilujeng?
        </h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-3 bg-white rounded-4">
                    <div class="card-body">
                        <div class="display-5 mb-3">💰</div>
                        <h5 class="fw-bold text-success">Harga Terjangkau</h5>
                        <p class="text-muted mb-0">
                            Harga bersaing dan ramah di kantong untuk semua kalangan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-3 bg-white rounded-4">
                    <div class="card-body">
                        <div class="display-5 mb-3">🌸</div>
                        <h5 class="fw-bold text-success">Produk Berkualitas</h5>
                        <p class="text-muted mb-0">
                            Kami hanya menjual produk dengan kualitas terbaik dan terpercaya.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-3 bg-white rounded-4">
                    <div class="card-body">
                        <div class="display-5 mb-3">🤝</div>
                        <h5 class="fw-bold text-success">Pelayanan Ramah</h5>
                        <p class="text-muted mb-0">
                            Kami siap melayani dengan sepenuh hati dan profesional.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center py-5 mt-5"
             style="background: linear-gradient(135deg, #a8e6cf, #c8e6c9); border-radius: 20px;">
        <div class="container">
            <h3 class="fw-bold text-dark mb-3">💚 Belanja mudah, cepat, dan aman hanya di Toko Wilujeng!</h3>
            <a href="/products" class="btn btn-success px-5 py-2 rounded-pill fw-semibold shadow">
                Lihat Semua Produk
            </a>
        </div>
    </section>
@endsection
