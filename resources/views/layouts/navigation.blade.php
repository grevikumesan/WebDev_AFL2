<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="z-index:9999;">
    <div class="container">

        {{-- BRAND / LOGO --}}
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}" style="color: #2d5a3a;">
            Toko Wilujeng
        </a>

        {{-- TAMPILAN MOBILE (HEADER ATAS) --}}
        <div class="d-flex align-items-center d-lg-none ms-auto">

            @guest
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success me-2">Masuk</a>
            @endguest

            @auth
                {{-- Icon Pesanan (Sebelah Kiri Foto) --}}
                <a href="{{ route('orders.index') }}" class="me-3 text-dark position-relative">
                    <i class="bi bi-receipt fs-4"></i>
                </a>

                {{-- Foto Profil & Nama --}}
                <a href="{{ route('profile.edit') }}" class="d-flex align-items-center text-decoration-none me-2">
                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/foto.jpeg') }}"
                        alt="Profile" class="rounded-circle border" style="width:35px; height:35px; object-fit: cover;">

                    <span class="ms-2 fw-bold text-dark small text-truncate" style="max-width: 80px;">
                        {{ explode(' ', Auth::user()->name)[0] }}
                    </span>
                </a>
            @endauth

            {{-- Hamburger Menu --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        {{-- ISI MENU NAVIGASI --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- 1. LOGIKA MENU HOME / DASHBOARD --}}
                <li class="nav-item mx-lg-2">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a class="nav-link nav-item-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @else
                        <a class="nav-link nav-item-custom {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    @endif
                </li>

                {{-- 2. LOGIKA MENU PRODUK / KELOLA PRODUK --}}
                <li class="nav-item mx-lg-2">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a class="nav-link nav-item-custom {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">Kelola Produk</a>
                    @else
                        <a class="nav-link nav-item-custom {{ request()->routeIs('products.index') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">Produk</a>
                    @endif
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">Tentang</a>
                </li>
                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Kontak</a>
                </li>

                {{-- MENU KHUSUS MOBILE --}}
                @auth
                    <li class="nav-item d-lg-none mt-2 border-top pt-2">
                        <span class="text-muted small px-3">Menu User</span>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-item-custom" href="{{ route('wishlist.index') }}">Wishlist Saya</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-item-custom" href="{{ route('cart.index') }}">Keranjang Belanja</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-item-custom" href="{{ route('orders.index') }}">Pesanan Saya</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-item-custom" href="{{ route('profile.edit') }}">Akun Saya</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-item-custom text-danger fw-bold" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            Logout
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth

                @guest
                    {{-- Mobile Login --}}
                    <li class="nav-item d-lg-none mt-2">
                        <a href="{{ route('login') }}" class="btn btn-success w-100">Masuk Akun</a>
                    </li>
                    {{-- Desktop Login --}}
                    <li class="nav-item ms-lg-2 d-none d-lg-block">
                        <a href="{{ route('login') }}" class="btn fw-bold px-4"
                            style="background:#2d5a3a; color:white; border-radius: 20px;">
                            Masuk
                        </a>
                    </li>
                @endguest

                {{-- DROPDOWN USER (KHUSUS DESKTOP) --}}
                @auth
                    <li class="nav-item dropdown ms-lg-3 d-none d-lg-flex align-items-center">
                        <a class="nav-link dropdown-toggle d-flex align-items-center user-dropdown-btn" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/foto.jpeg') }}"
                                alt="Profile" class="rounded-circle border me-2"
                                style="width:32px; height:32px; object-fit: cover;">
                            <span class="fw-semibold text-dark small">{{ Auth::user()->name }}</span>
                        </a>

                        {{-- 3. LABEL ADMIN (Di luar dropdown, sebelah kanan user) --}}
                        @if (Auth::user()->role == 'admin')
                            <span class="badge bg-danger ms-2 rounded-pill">ADMIN</span>
                        @endif

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2"
                            aria-labelledby="navbarDropdown">
                            {{-- Wishlist --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('wishlist.index') }}">
                                    <i class="bi bi-heart me-2 text-secondary"></i> Wishlist
                                </a>
                            </li>
                            {{-- Keranjang --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart me-2 text-secondary"></i> Keranjang
                                </a>
                            </li>
                            {{-- Pesanan Saya --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('orders.index') }}">
                                    <i class="bi bi-receipt me-2 text-secondary"></i> Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            {{-- Akun Saya --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2 text-secondary"></i> Akun Saya
                                </a>
                            </li>
                            {{-- Logout --}}
                            <li>
                                <a class="dropdown-item py-2 text-danger fw-bold" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- MODAL GUEST TETAP SAMA --}}
<div class="modal fade" id="guestRestrictionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header text-center" style="background:#bcead5; color:#2d5a3a;">
                <h5 class="modal-title w-100 fw-bold">Toko Wilujeng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <h5 class="fw-bold" style="color:#2d5a3a;">Bergabunglah Dengan Kami</h5>
                <p class="text-muted" id="modalActionMessage">Untuk menggunakan wishlist atau keranjang.</p>

                <div class="d-grid gap-2 my-3">
                    <a href="{{ route('login') }}" class="btn py-3 fw-semibold"
                        style="background:#2d5a3a; color:white;">Masuk ke Akun</a>
                </div>

                <p class="text-muted">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="fw-semibold" style="color:#2d5a3a;">Daftar Sekarang -
                    Gratis</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        const nav = document.getElementById("navbarNav");
        const btn = document.querySelector(".navbar-toggler");

        nav.classList.toggle("show");
        btn.classList.toggle("open");
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const guestModal = new bootstrap.Modal(document.getElementById('guestRestrictionModal'));

        const showGuestModal = (actionName = "") => {
            document.getElementById('modalActionMessage').textContent =
                actionName === "wishlist" ?
                "Untuk menyimpan produk ke wishlist, silakan login dulu." :
                "Untuk menambahkan ke keranjang, silakan login dulu.";

            guestModal.show();
        };

        @guest
        document.querySelectorAll('.nav-wishlist').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                showGuestModal("wishlist");
            });
        });

        document.querySelectorAll('.nav-cart').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                showGuestModal("cart");
            });
        });
    @endguest
    });
</script>

<style>
    /* REMOVE HOVER WHITE BACKGROUND PADA TOGGLER */
    .custom-toggler,
    .custom-toggler:hover,
    .custom-toggler:focus,
    .custom-toggler:active {
        background-color: transparent !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* HAMBURGER BASE */
    .navbar-toggler-icon {
        background-image: none !important;
        width: 24px;
        height: 2px;
        background-color: black;
        position: relative;
        transition: 0.3s ease;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        content: "";
        position: absolute;
        left: 0;
        width: 24px;
        height: 2px;
        background-color: black;
        transition: 0.3s ease;
    }

    .navbar-toggler-icon::before {
        top: -7px;
    }

    .navbar-toggler-icon::after {
        top: 7px;
    }

    /* ICON X */
    .navbar-toggler.open .navbar-toggler-icon {
        background-color: transparent;
    }

    .navbar-toggler.open .navbar-toggler-icon::before {
        transform: rotate(45deg);
        top: 0;
    }

    .navbar-toggler.open .navbar-toggler-icon::after {
        transform: rotate(-45deg);
        top: 0;
    }

    /* NAV ITEM HOVER EFFECT - BACKGROUND PUTIH */
    .nav-item-custom {
        border-radius: 8px;
        transition: all 0.3s ease;
        margin: 2px 4px;
        padding: 8px 12px !important;
    }

    .nav-item-custom:hover {
        background-color: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    /* ACTIVE STATE */
    .nav-item-custom.active {
        background-color: #f8f9fa !important;
        font-weight: 600;
        color: #2d5a3a !important;
    }

    /* CUSTOM DROPDOWN BUTTON (User Profile) */
    <style>.user-dropdown-btn {
        border: 1px solid #e0e0e0;
        padding: 5px 15px 5px 5px !important;
        border-radius: 50px;
        transition: all 0.3s ease;
        background-color: white;
    }

    .user-dropdown-btn:hover,
    .user-dropdown-btn.show {
        border-color: #2d5a3a;
        box-shadow: 0 2px 8px rgba(45, 90, 58, 0.1);
    }

    .nav-item-custom {
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 8px 12px !important;
        color: #555;
        font-weight: 500;
    }

    .nav-item-custom:hover {
        color: #2d5a3a;
        background-color: #f4f9f6;
    }

    .nav-item-custom.active {
        color: #2d5a3a !important;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: white;
            padding-bottom: 1rem;
            border-top: 1px solid #f0f0f0;
            margin-top: 0.5rem;
        }

        .nav-item-custom {
            padding: 10px 15px !important;
        }
    }
</style>
</style>
