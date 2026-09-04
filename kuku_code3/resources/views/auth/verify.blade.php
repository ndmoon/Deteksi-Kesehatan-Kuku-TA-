@extends('layouts.app')

@section('title', 'Email Terverifikasi - CEKU')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body text-center p-5">

                {{-- Icon --}}
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #28a745;"></i>
                </div>

                <h3 class="fw-bold mb-3">Email Berhasil Diverifikasi 🎉</h3>
                <p class="text-muted mb-4">
                    Terima kasih telah memverifikasi email Anda: 
                    <strong>{{ Auth::user()->email }}</strong>.<br>
                    Sekarang akun Anda sudah aktif sepenuhnya dan dapat digunakan.
                </p>

                {{-- Tombol ke dashboard --}}
                <a href="{{ route('dashboard') }}" class="btn btn-success">
                    Lanjut ke Dashboard
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
