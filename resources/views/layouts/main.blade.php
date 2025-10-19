<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Toko Wilujeng</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* === Pastel Green Theme (Soft Edition) ===
           Mint Mist: #eafaf1
           Soft Mint: #d6f5e3
           Pastel Green: #bcead5
           Text Leaf: #335b48
           Accent Green: #a8dec6
        */

        body {
            background-color: #f8fef9;
            color: #335b48;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        nav.navbar {
            background: linear-gradient(120deg, #d8f8e4, #bcead5);
            box-shadow: none;
        }

        nav .navbar-brand {
            color: #335b48 !important;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        nav .nav-link {
            color: #335b48 !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav .nav-link:hover {
            color: #1b5e20 !important;
        }

        nav.navbar {
            background: linear-gradient(120deg, #d8f8e4, #bcead5);
            box-shadow: none;
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
        }

        /* hamburger */
        .navbar-toggler {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            outline: none !important;
            padding: 0.25rem 0.5rem;
            margin-top: 2px; /* sejajar dengan tulisan brand */
        }

        /* garis hamburger */
        .navbar-toggler-icon {
            background-image: none !important;
            width: 24px;
            height: 2px;
            background-color: #335b48;
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: "";
            position: absolute;
            left: 0;
            width: 24px;
            height: 2px;
            background-color: #335b48;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            top: -7px;
        }

        .navbar-toggler-icon::after {
            top: 7px;
        }

        /* X on toggle */
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-color: transparent;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 0;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            top: 0;
        }


        /* Main */
        main {
            padding-top: 80px;
            padding-bottom: 60px;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #def7e8, #bcead5);
            color: #2e5947;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        footer h5 {
            font-weight: 700;
            color: #2d5a3a;
        }

        footer p {
            color: #3e6454;
            font-size: 0.96rem;
            margin-bottom: 0.6rem;
        }

        .footer-section {
            padding: 0 1rem;
        }

        .footer-bottom {
            background-color: rgba(0, 0, 0, 0.03);
            color: #3b5e4e;
            font-size: 0.9rem;
        }

        /* Card / Button */
        .card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
        }

        .btn-pastel-green {
            background-color: #bcead5;
            color: #2d5a3a;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-pastel-green:hover {
            background-color: #a7e0c6;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main class="flex-grow-1 animate_animated animate_fadeIn">
        <div class="container">
            @yield('main_content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="pt-5 pb-4 mt-auto">
        <div class="container text-center text-md-start">
            <div class="row">

                <div class="col-md-4 col-lg-4 mx-auto mb-4">
                    <h5 class="text-uppercase fw-bold mb-4">Toko Wilujeng</h5>
                    <p>
                        Penyedia kebutuhan pokok Anda. Kami berkomitmen untuk
                        memberikan produk berkualitas dengan harga terjangkau
                        dan pelayanan yang ramah.
                    </p>
                </div>

                <div class="col-md-4 col-lg-4 mx-auto mb-4">
                    <h5 class="text-uppercase fw-bold mb-4">Kontak Kami</h5>
                    <p>
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        {{-- dari homecontroller --}}
                        {{-- Ganti yang asli --}}
                        Jl. Raya Perning No. 358, Kec. Jetis, Kabupaten Mojokerto, Jawa Timur
                    </p>
                    <p>
                        <i class="bi bi-telephone-fill me-2"></i>
                        {{-- dari homecontroller --}}
                        0856-5507-8878 - Fenny
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 mx-auto mb-md-0 mb-4">
                    <h5 class="text-uppercase fw-bold mb-4">Jam Buka</h5>
                    <p>
                        {{-- GANTI INI DENGAN DATA ASLI --}}
                        <i class="bi bi-clock-fill me-2"></i>
                        Senin - Minggu : 08.00 - 17.00
                </div>

            </div>
        </div>

        <div class="text-center p-3 mt-4" style="background-color: rgba(0, 0, 0, 0.2);">
            &copy; 2025 Toko Wilujeng. All Rights Reserved.
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
