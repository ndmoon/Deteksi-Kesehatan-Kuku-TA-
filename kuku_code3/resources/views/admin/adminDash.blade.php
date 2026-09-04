@extends('admin.be.app')
@section('title', 'Admin Dashboard - CEKU')

@section('content')
<div class="container py-5">
    <!-- Judul Halaman -->
    <h1 class="mb-5 fw-bold text-center text-dark">
        <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin
    </h1>

    <!-- Statistik Card -->
    <div class="row g-4 justify-content-center mb-5">
        <!-- Total Pengguna -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 bg-white">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title text-muted">Total Pengguna</h5>
                    <p class="fs-4 fw-bold text-dark mb-0">{{ $userCount }}</p>
                </div>
            </div>
        </div>

        <!-- Total Riwayat Cek -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 bg-white">
                <div class="card-body text-center">
                    <i class="bi bi-clock-history fs-1 mb-3 text-success"></i>
                    <h5 class="card-title text-muted">Riwayat Cek</h5>
                    <p class="fs-4 fw-bold text-dark mb-0">{{ $historiCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Pengguna -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-semibold text-dark">
                <i class="bi bi-list-task me-2 text-secondary"></i> Daftar Pengguna
            </h6>
        </div>
        <div class="card-body px-0">
            <div class="table-responsive px-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
