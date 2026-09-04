@extends('admin.be.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
        <h2 class="fw-bold">Daftar User</h2>
        <a href="{{ route('admin.users.create') }}" 
        class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
            <i class="bi bi-person-plus me-2"></i> Tambah User
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

    <!-- Tabel user -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="fw-medium">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-outline-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Hapus user ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada user.
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
