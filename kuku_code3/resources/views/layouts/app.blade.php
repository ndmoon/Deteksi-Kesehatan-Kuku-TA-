<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CEKU - Dashboard')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff5f8; /* soft pink background */
        }

        /* Navbar */
        .navbar {
            transition: background 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffffcc;
            backdrop-filter: blur(5px);
        }
        .navbar.scrolled {
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: #EC407A !important;
        }
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            transition: color 0.2s ease;
        }
        .nav-link:hover {
            color: #EC407A !important;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 12px;
            border: 1px solid #f0a9c5;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .dropdown-item:hover {
            background-color: #F8BBD0;
            color: #EC407A;
        }

        /* Footer */
        footer {
            background-color: #EC407A;
            color: #fff;
            font-size: 0.9rem;
        }

        /* Sticky Navbar */
        .navbar.sticky-top {
            top: 0;
            z-index: 1030;
        }

        .offcanvas-half {
            width: 50vw !important;
        }
        @media (max-width: 576px) {
            .offcanvas-half {
                width: 75vw !important;
            }
        }

    </style>

    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center">
                <!-- Ikon Kuku - Outline -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" width="1em" height="1em"
                    fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true" focusable="false" class="me-2">
                <!-- Ujung jari -->
                <path d="M7 2h10a4 4 0 0 1 4 4v7a6 6 0 0 1-6 6H9a6 6 0 0 1-6-6V6a4 4 0 0 1 4-4z"/>
                <!-- Plat kuku -->
                <rect x="8.5" y="9" width="7" height="9" rx="2.5"/>
                <!-- Garis kutikula (sedikit lengkung) -->
                <path d="M9.8 11.3a4.4 4.4 0 0 1 4.4 0"/>
                </svg> CEKU
            </a>

            <!-- Tombol menu untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar desktop -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        @php
                            $isDashboard = Request::routeIs('dashboard');
                            $isRiwayat   = Request::routeIs('riwayat');
                            $isProfile   = Request::routeIs('profile.*');
                        @endphp

                        {{-- BERANDA --}}
                        @if(!$isDashboard)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    Beranda
                                </a>
                            </li>
                        @endif

                        {{-- RIWAYAT --}}
                        @if(!$isRiwayat)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('riwayat') }}">
                                    Riwayat
                                </a>
                            </li>
                        @endif

                        {{-- PROFIL --}}
                        @if(!$isProfile)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.index') }}">
                                    Profil
                                </a>
                            </li>
                        @endif

                        {{-- KELUAR --}}
                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @endauth
                    </ul>
            </div>
        </div>
    </nav>

    <!-- Offcanvas sidebar untuk mobile -->
    <div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="offcanvasMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel"><!-- Ikon Kuku - Outline -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" width="1em" height="1em"
                    fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true" focusable="false" class="me-2">
                <!-- Ujung jari -->
                <path d="M7 2h10a4 4 0 0 1 4 4v7a6 6 0 0 1-6 6H9a6 6 0 0 1-6-6V6a4 4 0 0 1 4-4z"/>
                <!-- Plat kuku -->
                <rect x="8.5" y="9" width="7" height="9" rx="2.5"/>
                <!-- Garis kutikula (sedikit lengkung) -->
                <path d="M9.8 11.3a4.4 4.4 0 0 1 4.4 0"/>
                </svg></i> CEKU</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav fs-5">
            @auth
                <li class="nav-item mb-3">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Beranda
                    </a>
                </li>

                <li class="nav-item mb-3">
                    <a class="nav-link" href="{{ route('riwayat') }}">
                        <i class="bi bi-clock-history me-2"></i> Riwayat
                    </a>
                </li>

                <li class="nav-item mb-3">
                    <a class="nav-link" href="{{ route('profile.index') }}">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            @endauth
            </ul>
        </div>
    </div>

    <!-- Wrapper untuk konten + footer -->
    <div class="d-flex flex-column min-vh-100">

        <!-- Main Content -->
        <main class="flex-grow-1">
            <div class="container py-5">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-3 mt-auto">
            <small>© {{ date('Y') }} CEKU. All rights reserved.</small>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar Scroll Shadow -->
    <script>
        document.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 10) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
