<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
            Cek Kuku
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Menu kiri -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                </li>
            </ul>

            <!-- Menu kanan -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="me-2">{{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> Profil
                            </a>
                            <a class="dropdown-item" href="{{ route('riwayat.index') }}">
                                <i class="bi bi-clock-history me-2"></i> Histori
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-semibold" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
