@extends('layouts.app')

@section('title', 'Profil Saya - CEKU')

@section('content')

{{-- Notifikasi Sukses --}}
@if(session('success'))
<div class="card border-0 shadow-sm mb-4" id="success-alert">
    <div class="card-body d-flex align-items-center text-success">
        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
        <div>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" onclick="this.closest('#success-alert').style.display='none'" aria-label="Close"></button>
    </div>
</div>
@endif

{{-- Notifikasi Error --}}
@if($errors->any())
<div class="card border-0 shadow-sm mb-4" id="error-alert">
    <div class="card-body d-flex align-items-start text-danger">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
        <div>
            <strong>Terjadi Kesalahan:</strong>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close ms-auto" onclick="this.closest('#error-alert').style.display='none'" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Bagian atas: foto + nama --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body d-flex align-items-center p-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                         alt="avatar"
                         class="rounded-circle me-4 shadow-sm"
                         width="90"
                         height="90">
                    
                    <div>
                        <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                        <p class="mb-1 text-muted">
                            <i class="bi bi-person-badge"></i> {{ ucfirst(Auth::user()->role) }}
                        </p>
                        <small class="text-muted">
                            <i class="bi bi-calendar-check"></i> Member sejak {{ Auth::user()->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold text-dark">Informasi Akun</h6>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                </div>
                <div class="card-body row px-4 py-3">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Nama</small>
                        <p class="fw-semibold mb-0">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Email</small>
                        <p class="fw-semibold mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Role</small>
                        <p class="fw-semibold mb-0">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    {{-- Status Email dihapus --}}
                </div>
            </div>

            {{-- Tombol Hapus Akun --}}
            <div class="text-center my-4">
                <form method="POST" action="{{ route('profile.destroy') }}" 
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger px-4 py-2 rounded-pill">
                        <i class="bi bi-trash me-1"></i> Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Sembunyikan notifikasi sukses setelah 5 detik
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = 'none';
        }, 5000);
    }

    // Sembunyikan notifikasi error setelah 5 detik
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 5000);
    }
});
</script>
@endpush
