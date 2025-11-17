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
            <button class="navbar-toggler border-0" type="button" onclick="toggleMobileMenu()">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbarNav" style="transition:0.3s;">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Home, Produk, Tentang, Kontak -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('products') || request()->is('product/*') ? 'active' : '' }}" href="/products">Produk</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">Tentang</a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Kontak</a>
                </li>

                <!-- Wishlist -->
                <li class="nav-item mx-lg-2">
                    @if(Auth::check())
                        <a class="nav-link" href="/wishlist">
                    @else
                        <a class="nav-link nav-wishlist" href="#">
                    @endif
                        <i class="bi bi-heart me-1 d-none d-lg-inline"></i>
                        <span class="d-inline d-lg-none">Disukai</span>
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item mx-lg-2">
                    @if(Auth::check())
                        <a class="nav-link" href="/cart">
                    @else
                        <a class="nav-link nav-cart" href="#">
                    @endif
                        <i class="bi bi-cart me-1 d-none d-lg-inline"></i>
                        <span class="d-inline d-lg-none">Keranjang</span>
                    </a>
                </li>

                <!-- Desktop Profile -->
                @guest
                    <li class="nav-item mx-lg-2 d-none d-lg-block">
                        <a href="{{ route('login') }}" class="nav-link">
                            <img src="/images/foto.jpeg" alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item mx-lg-2 d-none d-lg-block">
                        <a href="/profile" class="nav-link">
                            <img src="{{ Auth::user()->profile_photo_url ?? '/images/foto.jpeg' }}" alt="Profile" class="rounded-circle" style="width:36px; height:36px;">
                        </a>
                    </li>
                @endauth

                <!-- Mobile: Akun -->
                <li class="nav-item d-lg-none">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link">Akun</a>
                    @endguest

                    @auth
                        <a href="/profile" class="nav-link">Akun</a>
                    @endauth
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Guest Restriction Modal -->
<div class="modal fade" id="guestRestrictionModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true" aria-labelledby="guestRestrictionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header text-center" style="background:#bcead5; color:#2d5a3a; border-bottom: none;">
        <h5 class="modal-title w-100 fw-bold" id="guestRestrictionModalLabel">Toko Wilujeng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="mb-4">
          <i class="fas fa-users fa-3x mb-3" style="color:#2d5a3a;"></i>
          <h5 style="color:#2d5a3a; margin-bottom:4px;">Bergabunglah Dengan Kami</h5>
          <p class="text-muted" id="modalActionMessage">Untuk menggunakan wishlist atau keranjang.</p>
          <p class="text-muted small">Nikmati pengalaman belanja yang personal.</p>
        </div>
        <div class="d-grid gap-2 mb-3">
          <a href="{{ route('login') }}" class="btn py-3 fw-semibold login-redirect-btn" style="background:#2d5a3a; color:white; border-radius:12px; font-size:1.1rem;">Masuk ke Akun</a>
        </div>
        <p class="text-muted mb-1" style="font-size:0.9rem;">Belum punya akun?</p>
        <a href="{{ route('register') }}" class="fw-semibold register-redirect-btn" style="color:#2d5a3a; font-size:1rem;">Daftar Sekarang - Gratis</a>
      </div>
    </div>
  </div>
</div>

<!-- Hamburger toogle -->
<script>
function toggleMobileMenu() {
    const nav = document.getElementById("navbarNav");
    const btn = document.querySelector(".navbar-toggler");

    // toggle menu
    nav.classList.toggle("show");

    // toggle icon
    btn.classList.toggle("open");
}
</script>

<!-- Guest Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const guestModal = new bootstrap.Modal(document.getElementById('guestRestrictionModal'));

    const showGuestModal = (actionName = "") => {
        const msg = actionName === "wishlist"
            ? "Untuk menyimpan produk ke wishlist, silakan login dulu."
            : "Untuk menambahkan ke keranjang, silakan login dulu.";
        document.getElementById('modalActionMessage').textContent = msg;
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
/* Navbar Items */
.navbar-toggler-icon {
    background-image: none !important;
    width: 24px;
    height: 2px;
    background-color: black;
    position: relative;
    transition: 0.3s ease;
}

/* Garis tambahan */
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

/* Posisi 3 garis */
.navbar-toggler-icon::before {
    top: -7px;
}
.navbar-toggler-icon::after {
    top: 7px;
}

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


/* Mobile View */
@media (max-width: 991px) {
    .navbar-nav .nav-item { width: 100%; }
    .navbar-nav .nav-link { justify-content: flex-start; padding-left: 1rem; }
}

/* Mengubah icon hamburger ke X  */
.navbar-toggler.open .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath stroke='black' stroke-width='2' d='M2 2 L14 14 M14 2 L2 14'/%3E%3C/svg%3E");
}
</style>