<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin CEKU')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb; /* putih abu modern */
            color: #333;
        }

        /* Header */
        .header {
            background: #ffffff;
            color: #333;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header h4 {
            font-weight: 600;
            margin: 0;
            color: #111827;
        }
        .header .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        /* Sidebar */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 20px 0;
            width: 230px;
            position: fixed;
            top: 56px; 
            bottom: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }
        .sidebar a:hover {
            background: #f3f4f6;
            border-left: 4px solid #3b82f6; /* biru elegan */
            color: #1d4ed8;
        }
        .sidebar a.active {
            background: #eef2ff;
            border-left: 4px solid #2563eb;
            color: #1e40af;
            font-weight: 600;
        }
        .sidebar i {
            margin-right: 8px;
        }

        /* Sidebar aktif (mobile) */
        .sidebar.active {
            transform: translateX(-100%);
        }

        /* Main */
        main {
            margin-left: 230px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        /* Footer */
        footer {
            background: #ffffff;
            color: #6b7280;
            padding: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }

        /* Mobile */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1050;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            main {
                margin-left: 0;
            }
        }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            color: #333;
        }

        main {
            flex: 1 0 auto; /* mengambil sisa tinggi agar footer tetap di bawah */
            margin-left: 230px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        footer {
            flex-shrink: 0;
            background: #ffffff;
            color: #6b7280;
            padding: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }

        /* Sidebar tetap seperti sebelumnya */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 20px 0;
            width: 230px;
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        /* Mobile adjustments */
        @media (max-width: 992px) {
            main {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .btn-primary {
                font-size: 14px;
                padding: 6px 12px;
            }
            h4 {
                font-size: 18px;
            }
        }

    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="d-flex align-items-center">
            <!-- Tombol toggle sidebar -->
            <button id="sidebarToggle" class="btn btn-outline-secondary d-lg-none me-2">
                <i class="bi bi-list"></i>
            </button>
            <h4>
                <i class="bi bi-shield-check text-primary me-1"></i> Admin CEKU
            </h4>
        </div>

        <div>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('admin.adminDash') }}" class="{{ request()->routeIs('admin.adminDash') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.histori.index') }}" class="{{ request()->routeIs('admin.histori.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Histori
        </a>
        <a href="{{ route('admin.kondisi.index') }}" class="{{ request()->routeIs('admin.kondisi.*') ? 'active' : '' }}">
            <i class="bi bi-activity"></i> Kondisi
        </a>
        <a href="{{ route('admin.penyakit.index') }}" class="{{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
            <i class="bi bi-heart-pulse"></i> Penyakit
        </a>
        <a href="{{ route('admin.rekomendasi.index') }}" class="{{ request()->routeIs('admin.rekomendasi.*') ? 'active' : '' }}">
            <i class="bi bi-lightbulb"></i> Rekomendasi
        </a>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <medium>© {{ date('Y') }} CEKU. All rights reserved.</medium>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");

            if (toggleBtn) {
                toggleBtn.addEventListener("click", function () {
                    sidebar.classList.toggle("active");
                });
            }
        });
    </script>
</body>
</html>
