<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="z-index:9999;">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand fw-bold fs-4 text-dark" href="/">Toko Wilujeng</a>

        <!-- Mobile profile + toggler -->
        <div class="d-flex align-items-center d-lg-none">

            @guest
                <a href="{{ route('login') }}" class="me-2">
                    <img src="/images/foto.jpeg" alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                </a>
            @endguest

            @auth
                <a href="/profile" class="me-2">
                    <img src="{{ Auth::user()->profile_photo_url ?? '/images/foto.jpeg' }}" alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                </a>
            @endauth

            <!-- Burger button -->
            <button class="navbar-toggler border-0 custom-toggler" type="button" onclick="toggleMobileMenu()">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- NAV ITEMS -->
        <div class="navbar-collapse collapse" id="navbarNav" style="transition:0.3s;">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->is('products') || request()->is('product/*') ? 'active' : '' }}" href="/products">Produk</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->is('about') ? 'active' : '' }}" href="/about">Tentang</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link nav-item-custom {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Kontak</a>
                </li>

                <!-- Wishlist -->
                <li class="nav-item mx-lg-2">
                    @if(Auth::check())
                        <a class="nav-link nav-item-custom" href="/wishlist">
                    @else
                        <a class="nav-link nav-item-custom nav-wishlist" href="#">
                    @endif
                        <i class="bi bi-heart me-1 d-none d-lg-inline"></i>
                        <span class="d-inline d-lg-none">Disukai</span>
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item mx-lg-2">
                    @if(Auth::check())
                        <a class="nav-link nav-item-custom" href="/cart">
                    @else
                        <a class="nav-link nav-item-custom nav-cart" href="#">
                    @endif
                        <i class="bi bi-cart me-1 d-none d-lg-inline"></i>
                        <span class="d-inline d-lg-none">Keranjang</span>
                    </a>
                </li>

                <!-- Desktop Profile -->
                @guest
                    <li class="nav-item mx-lg-2 d-none d-lg-block">
                        <a href="{{ route('login') }}" class="nav-link nav-item-custom">
                            <img src="/images/foto.jpeg" 
                                alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item mx-lg-2 d-none d-lg-block">
                        <a href="/profile" class="nav-link nav-item-custom">
                            <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/images/foto.jpeg' }}" 
                                alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                        </a>
                    </li>
                @endauth

                <!-- Mobile: Akun -->
                <li class="nav-item d-lg-none">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link nav-item-custom">Akun</a>
                    @endguest
                    @auth
                        <a href="/profile" class="nav-link nav-item-custom">Akun</a>
                    @endauth
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Guest Restriction Modal -->
<div class="modal fade" id="guestRestrictionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px;">
      <div class="modal-header text-center" style="background:#bcead5; color:#2d5a3a;">
        <h5 class="modal-title w-100 fw-bold">Toko Wilujeng</h5>
      </div>
      <div class="modal-body text-center p-4">
        <h5 class="fw-bold" style="color:#2d5a3a;">Bergabunglah Dengan Kami</h5>
        <p class="text-muted" id="modalActionMessage">Untuk menggunakan wishlist atau keranjang.</p>

        <div class="d-grid gap-2 my-3">
          <a href="{{ route('login') }}" class="btn py-3 fw-semibold" style="background:#2d5a3a; color:white;">Masuk ke Akun</a>
        </div>

        <p class="text-muted">Belum punya akun?</p>
        <a href="{{ route('register') }}" class="fw-semibold" style="color:#2d5a3a;">Daftar Sekarang - Gratis</a>
      </div>
    </div>
  </div>
</div>

<!-- Toggle Script -->
<script>
function toggleMobileMenu() {
    const nav = document.getElementById("navbarNav");
    const btn = document.querySelector(".navbar-toggler");

    nav.classList.toggle("show");
    btn.classList.toggle("open");
}
</script>

<!-- Guest Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const guestModal = new bootstrap.Modal(document.getElementById('guestRestrictionModal'));

    const showGuestModal = (actionName = "") => {
        document.getElementById('modalActionMessage').textContent =
            actionName === "wishlist"
                ? "Untuk menyimpan produk ke wishlist, silakan login dulu."
                : "Untuk menambahkan ke keranjang, silakan login dulu.";

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

.navbar-toggler-icon::before { top: -7px; }
.navbar-toggler-icon::after  { top: 7px; }

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
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

/* ACTIVE STATE */
.nav-item-custom.active {
    background-color: #f8f9fa !important;
    font-weight: 600;
    color: #2d5a3a !important;
}

/* DESKTOP VIEW */
@media (min-width: 992px) {
    .nav-item-custom {
        margin: 0 4px;
    }
}

/* MOBILE FULL WIDTH */
@media (max-width: 991px) {
    .navbar-nav .nav-item { 
        width: 100%; 
        margin: 2px 0;
    }
    
    .navbar-nav .nav-link { 
        padding-left: 1rem; 
        border-radius: 6px;
    }
    
    .nav-item-custom {
        margin: 4px 0;
        padding: 10px 16px !important;
    }
    
    .nav-item-custom:hover {
        background-color: #f8f9fa !important;
    }
}

.nav-item-custom img {
    transition: transform 0.3s ease;
}

.nav-item-custom:hover img {
    transform: scale(1.05);
}
</style>