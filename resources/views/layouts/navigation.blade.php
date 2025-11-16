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
            <ul class="navbar-nav ms-auto">

                <!-- Home -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        Home
                    </a>
                </li>

                <!-- Produk -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ (request()->is('products') || request()->is('product/*')) ? 'active' : '' }}"
                       href="/products">
                        Produk
                    </a>
                </li>

                <!-- Tentang -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">
                        Tentang
                    </a>
                </li>

                <!-- Kontak -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="/contact">
                        Kontak
                    </a>
                </li>

                <!-- Wishlist -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('wishlist') ? 'active' : '' }}" href="/wishlist">

                        <!-- Desktop icon -->
                        <span class="d-none d-lg-inline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 
                                1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 
                                1.815 2.834 3.989 6.286 6.357 3.452-2.368 
                                5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385
                                C13.486.878 10.4.28 8.717 2.01zM8 
                                15C-7.333 4.868 3.279-3.04 7.824 
                                1.143q.09.083.176.171a3 3 0 0 1 
                                .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                        </span>

                        <!-- Mobile text -->
                        <span class="d-inline d-lg-none">
                            Disukai
                        </span>

                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item mx-lg-2">
                    <a class="nav-link {{ request()->is('cart') ? 'active' : '' }}" href="/cart">

                        <!-- Desktop icon -->
                        <span class="d-none d-lg-inline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 
                                1 .5 1H2a.5.5 0 0 1 .485.379L2.89 
                                3H14.5a.5.5 0 0 1 .491.592l-1.5 
                                8A.5.5 0 0 1 13 12H4a.5.5 0 0 
                                1-.491-.408L2.01 3.607 1.61 
                                2H.5a.5.5 0 0 1-.5-.5M3.102 
                                4l1.313 7h8.17l1.313-7zM5 
                                12a2 2 0 1 0 0 4 2 2 0 0 
                                0 0-4m7 0a2 2 0 1 0 0 
                                4 2 2 0 0 0 0-4m-7 
                                1a1 1 0 1 1 0 2 1 
                                1 0 0 1 0-2m7 0a1 
                                1 0 1 1 0 2 1 1 
                                0 0 1 0-2"/>
                            </svg>
                        </span>

                        <!-- Mobile text -->
                        <span class="d-inline d-lg-none">
                            Keranjang
                        </span>

                    </a>
                </li>


                <!-- Guest -->
                @guest
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
                @endguest

                <!-- User Logged In -->
                @auth
                    <li class="nav-item dropdown mx-lg-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Halo, {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/profile">
                                    Update Akun
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

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
