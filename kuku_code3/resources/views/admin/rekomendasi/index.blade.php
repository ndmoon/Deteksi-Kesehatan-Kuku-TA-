@extends('admin.be.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
        <h2 class="fw-bold mb-0">Rekomendasi Perawatan</h2>
        <a href="{{ route('admin.rekomendasi.create') }}" 
        class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle me-1"></i> Tambah Rekomendasi
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Rekomendasi -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kondisi Kuku</th>
                            <th>Rekomendasi Perawatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekomendasi as $r)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $r->kondisiKuku->name ?? '-' }}</span>
                                </td>
                                <td>{{ $r->recommendation }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.rekomendasi.edit',$r->id) }}" 
                                       class="btn btn-outline-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.rekomendasi.destroy',$r->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Hapus rekomendasi ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada rekomendasi perawatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
