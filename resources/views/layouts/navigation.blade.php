<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Toko -->
        <a class="navbar-brand fw-bold fs-4 text-dark" href="/">
            Toko Wilujeng
        </a>

        <!-- Mobile Nav -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Nav href -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                       href="/">
                        Home
                    </a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ (request()->is('products') || request()->is('product/*')) ? 'active' : '' }}"
                        href="/products">
                        Produk
                    </a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                       href="/about">
                        Tentang
                    </a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                       href="/contact">
                        Kontak
                    </a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('wishlist') ? 'active' : '' }}"
                       href="/wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                    </svg>
                    </a>
                </li>

                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('cart') ? 'active' : '' }}"
                       href="/cart">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </a>
                </li>

                @guest
                    {{-- Jika user adalah GUEST (belum login), tampilkan ini --}}
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}"
                        href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                        href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @else
                    {{-- Jika user SUDAH LOGIN, tampilkan ini --}}
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link" href="#">
                            Halo, {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item mx-lg-2">
                        <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 1.2rem 0;
    }

    .navbar .navbar-brand {
        color: #2d3748;
        font-size: 1.4rem;
    }

    .navbar-nav .nav-link {
        transition: all 0.3s ease;
        padding: 0.6rem 1.2rem;
        font-size: 1.05rem;
        color: #4a5568;
        font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
        background-color: #f7fafc;
        border-radius: 0.5rem;
        color: #2d3748;
    }

    .navbar-nav .nav-link.active {
        background-color: #edf2f7;
        border-radius: 0.5rem;
        color: #2d3748;
        font-weight: 600;
    }

    body {
        padding-top: 76px;
    }
</style>
