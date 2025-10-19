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
