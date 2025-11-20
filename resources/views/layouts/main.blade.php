<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Toko Wilujeng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* === GLOBAL VARIABLES === */
        :root {
            --primary: #2d5a3a;
            --secondary: #bcead5;
            --bg-light: #f8fef9;
            --text-dark: #335b48;
        }

        /* === PERBAIKAN UTAMA DI SINI === */
        html,
        body {
            height: 100%;
            /* Paksa tinggi 100% */
            margin: 0;
            /* Hapus margin bawaan browser */
            padding: 0;
            /* Hapus padding bawaan */
            width: 100%;
            /* Lebar full */
            overflow-x: hidden;
            /* Cegah scroll samping */
            background-color: var(--bg-light);
        }

        body {
            display: flex;
            /* Aktifkan Flexbox */
            flex-direction: column;
            /* Susunan Vertikal (Atas ke Bawah) */
            font-family: 'Poppins', sans-serif;
        }

        /* Content Wrapper */
        main {
            flex: 1;
            /* Main mengambil SISA ruang kosong */
            padding-top: 90px;
            /* Jarak dari Navbar */
            padding-bottom: 60px;
            /* Jarak ke Footer */
            width: 100%;
            /* Pastikan main juga full width */
        }

        /* Footer Full Width & Bottom */
        footer {
            background: linear-gradient(180deg, #def7e8 0%, #bcead5 100%);
            color: var(--primary);
            width: 100%;
            /* Lebar Penuh */
            margin-top: auto;
            /* Dorong ke paling bawah */
            position: relative;
            /* Pastikan posisi aman */
            bottom: 0;
            /* Tempel ke bawah */
        }

        /* === RESPONSIVE TEXT === */
        @media (max-width: 576px) {
            body {
                font-size: 14px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

        /* Style Utilities */
        .text-primary-dark {
            color: var(--primary) !important;
        }

        .btn-primary-custom {
            background-color: var(--primary);
            color: white;
            border-radius: 10px;
            border: none;
            padding: 8px 20px;
        }

        .btn-primary-custom:hover {
            background-color: #1e4028;
            color: #fff;
        }
    </style>
    @stack('styles')
</head>

<body> {{-- Hapus class d-flex di sini karena sudah di handle di CSS body --}}

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main>
        <div class="container">
            @yield('main_content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="pt-5 pb-3">
        {{-- Container ini membatasi KONTEN footer agar di tengah, tapi BACKGROUND tetap full width --}}
        <div class="container">
            <div class="row g-4 text-center justify-content-center">

                {{-- Brand --}}
                <div class="col-md-4">
                    <h5 class="fw-bold text-uppercase mb-3">Toko Wilujeng</h5>
                    <p class="small mx-auto" style="max-width: 300px;">
                        Solusi belanja kebutuhan pokok berkualitas dengan harga bersahabat.
                    </p>
                </div>

                {{-- Kontak --}}
                <div class="col-md-4">
                    <h5 class="fw-bold text-uppercase mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled small d-inline-block text-start">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2 text-success"></i> Mojokerto, Jawa Timur
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-whatsapp me-2 text-success"></i> 0856-5507-8878 (Fenny)
                        </li>
                    </ul>
                </div>

                {{-- Jam --}}
                <div class="col-md-4">
                    <h5 class="fw-bold text-uppercase mb-3">Jam Operasional</h5>
                    <p class="small">
                        <i class="bi bi-clock-fill me-2 text-success"></i> Setiap Hari: 08.00 - 17.00
                    </p>
                </div>
            </div>

            <hr style="opacity: 0.1; margin-top: 2rem;">
            <div class="text-center small opacity-75">
                &copy; 2025 Toko Wilujeng. All Rights Reserved.
            </div>
        </div>
    </footer>

    {{-- Global Components (Toast & Modal) --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 10000;">
        <div id="liveToast" class="toast align-items-center text-white border-0 shadow" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMessage">Notification</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="guestRestrictionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-header border-0 justify-content-center" style="background-color: var(--bg-soft);">
                    <i class="bi bi-lock-fill text-primary-dark fs-1"></i>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <h6 class="fw-bold text-primary-dark">Akses Terbatas</h6>
                    <p class="text-muted small mb-3" id="modalActionMessage">Silakan login dulu.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary-custom btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.IS_LOGGED_IN = {{ Auth::check() ? 'true' : 'false' }};
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. SETUP TOAST (Notifikasi) ---
            const toastEl = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastMessage');
            // Cek apakah elemen ada sebelum di-new
            const toastInstance = toastEl ? new bootstrap.Toast(toastEl) : null;

            function showToast(message, type = 'success') {
                if (!toastEl || !toastInstance) return;

                toastBody.textContent = message;
                toastEl.className = 'toast align-items-center text-white border-0 shadow';

                if (type === 'success') toastEl.classList.add('bg-success');
                else if (type === 'info') toastEl.classList.add('bg-secondary');
                else toastEl.classList.add('bg-danger');

                toastInstance.show();
            }

            // --- 2. GLOBAL HANDLER CLICK ---
            document.body.addEventListener('click', async function(e) {
                    // Cari tombol .action-btn terdekat
                    const button = e.target.closest('.action-btn');
                    if (!button) return;

                    e.preventDefault();

                    // A. CEK STATUS PROCESSING (Anti Spam Klik)
                    if (button.classList.contains('is-processing') || button.disabled) {
                        return;
                    }

                    // B. CEK LOGIN
                    // Pastikan window.IS_LOGGED_IN didefinisikan di layout utama
                    if (typeof window.IS_LOGGED_IN !== 'undefined' && !window.IS_LOGGED_IN) {
                        // Tampilkan modal login kamu di sini
                        const modalEl = document.getElementById('guestRestrictionModal');
                        if (modalEl) {
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                        } else {
                            alert('Silakan login terlebih dahulu.');
                        }
                        return;
                    }

                    // C. AMBIL DATA
                    const url = button.dataset.url;
                    const action = button.dataset.action;
                    const productId = button.dataset.productId;
                    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

                    if (!url || !csrfTokenMeta) {
                        console.error("URL atau CSRF Token hilang");
                        return;
                    }

                    // D. SET STATE LOADING
                    button.classList.add('is-processing'); // Kunci tombol
                    const originalContent = button.innerHTML;
                    const isWishlist = action === 'Wishlist';

                    // Ubah icon jadi loading (kecuali wishlist biar ga jelek kedip2)
                    if (!isWishlist) {
                        button.innerHTML =
                            '<span class="spinner-border spinner-border-sm" role="status"></span>';
                        button.disabled = true;
                    } else {
                        // Efek visual sedikit transparan
                        button.style.opacity = '0.7';
                    }

                    try {
                        // Ambil Quantity (Hanya untuk Cart)
                        let quantity = 1;
                        const qtyInput = document.getElementById('qtyInput');
                        if (qtyInput && action !== 'Wishlist') {
                            quantity = qtyInput.value;
                        }

                        // E. FETCH REQUEST
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        });

                        // F. CEK RESPONSE HTTP (Bukan JSON-nya dulu)
                        if (!response.ok) {
                            throw new Error(`HTTP Error: ${response.status}`);
                        }

                        const data = await response.json();

                        // G. LOGIKA SUKSES
                        showToast(data.message, 'success');

                        // --- LOGIKA UPDATE UI WISHLIST ---
                        if (isWishlist) {
                            const icon = button.querySelector('i');

                            if (data.action === 'added') {
                                // 1. SIMPAN KE LOCALSTORAGE
                                WishlistSync.add(productId);

                                // 2. UPDATE UI BUTTON
                                button.classList.add('text-danger', 'border-danger');
                                button.classList.remove('text-muted', 'text-secondary');
                                if (icon) {
                                    icon.classList.remove('bi-heart');
                                    icon.classList.add('bi-heart-fill');
                                }

                                // Animasi Pop
                                button.style.transform = 'scale(1.2)';
                                setTimeout(() => button.style.transform = 'scale(1)', 200);

                            } else if (data.action === 'removed') {
                                // 1. HAPUS DARI LOCALSTORAGE
                                WishlistSync.remove(productId);

                                // 2. CEK: Apakah di halaman wishlist?
                                const wishlistCard = button.closest('.col-6, .col-md-3');
                                const isWishlistPage = document.getElementById(
                                'wishlist-container-wrapper');

                                if (isWishlistPage && wishlistCard) {
                                    // HAPUS CARD DARI DOM
                                    wishlistCard.style.transition = 'all 0.4s ease';
                                    wishlistCard.style.opacity = '0';
                                    wishlistCard.style.transform = 'translateX(-20px)';

                                    setTimeout(() => {
                                        wishlistCard.remove();
                                        // Reload jika kosong
                                        if (document.querySelectorAll(
                                                '#wishlist-container-wrapper .col-6').length ===
                                            0) {
                                            window.location.reload();
                                        }
                                    }, 400);
                                } else {
                                    // UPDATE UI di halaman lain (products/detail)
                                    button.classList.remove('text-danger', 'border-danger');
                                    button.classList.add('text-muted');
                                    if (icon) {
                                        icon.classList.remove('bi-heart-fill');
                                        icon.classList.add('bi-heart');
                                    }
                                }
                            }
                        } else if (action === 'Keranjang') {
                            // Reset tombol keranjang jadi centang hijau sesaat
                            button.innerHTML = '<i class="bi bi-check-lg"></i>';
                            button.classList.add('btn-success', 'text-white');
                            setTimeout(() => {
                                button.innerHTML = originalContent;
                                button.classList.remove('btn-success', 'text-white');
                            }, 2000);
                        }

                    } else {
                        // Backend kirim status: error/info
                        showToast(data.message, 'warning');
                    }

                } catch (error) {
                    console.error('AJAX Error:', error);
                    showToast("Gagal memproses: " + error.message, 'error');
                } finally {
                    // H. RESET TOMBOL (WAJIB)
                    button.classList.remove('is-processing');
                    button.style.opacity = '1';

                    if (!isWishlist && action !== 'Keranjang') {
                        // Jika keranjang, resetnya dihandle logic success diatas biar icon checknya kelihatan
                        button.disabled = false;
                        button.innerHTML = originalContent;
                    } else if (!isWishlist) {
                        button.disabled = false;
                        // Logic reset innerHTML keranjang ada di dalam blok success
                    }
                }
            });
        });
    </script>
    <script>
        // === WISHLIST SYNC SYSTEM ===
        window.WishlistSync = {
            // Key untuk localStorage
            STORAGE_KEY: 'user_wishlist_ids',

            // Ambil data wishlist dari localStorage
            get() {
                try {
                    const data = localStorage.getItem(this.STORAGE_KEY);
                    return data ? JSON.parse(data) : [];
                } catch (e) {
                    return [];
                }
            },

            // Simpan ke localStorage
            set(ids) {
                try {
                    localStorage.setItem(this.STORAGE_KEY, JSON.stringify(ids));
                    // Trigger event untuk sync antar tab
                    window.dispatchEvent(new CustomEvent('wishlistChanged', {
                        detail: {
                            ids
                        }
                    }));
                } catch (e) {
                    console.error('Failed to save wishlist:', e);
                }
            },

            // Tambah ID ke wishlist
            add(productId) {
                const ids = this.get();
                if (!ids.includes(productId)) {
                    ids.push(productId);
                    this.set(ids);
                }
            },

            // Hapus ID dari wishlist
            remove(productId) {
                let ids = this.get();
                ids = ids.filter(id => id != productId);
                this.set(ids);
            },

            // Cek apakah produk ada di wishlist
            has(productId) {
                return this.get().includes(productId);
            },

            // Update UI button berdasarkan status
            updateButton(button, productId) {
                const icon = button.querySelector('i');
                const isInWishlist = this.has(productId);

                if (isInWishlist) {
                    button.classList.add('text-danger', 'border-danger');
                    button.classList.remove('text-muted', 'text-secondary');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                } else {
                    button.classList.remove('text-danger', 'border-danger');
                    button.classList.add('text-muted');
                    if (icon) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                }
            },

            // Sync semua tombol wishlist di halaman
            syncAllButtons() {
                document.querySelectorAll('[data-action="Wishlist"]').forEach(button => {
                    const productId = button.dataset.productId;
                    if (productId) {
                        this.updateButton(button, productId);
                    }
                });
            },

            // Inisialisasi sync saat page load
            init() {
                // Sync UI saat halaman dimuat
                this.syncAllButtons();

                // Listen perubahan dari tab lain
                window.addEventListener('storage', (e) => {
                    if (e.key === this.STORAGE_KEY) {
                        this.syncAllButtons();
                    }
                });

                // Listen custom event (untuk sync di tab yang sama)
                window.addEventListener('wishlistChanged', () => {
                    this.syncAllButtons();
                });
            }
        };

        // Jalankan sync saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            if (window.IS_LOGGED_IN) {
                WishlistSync.init();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
