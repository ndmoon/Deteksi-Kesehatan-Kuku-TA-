@extends('layouts.app')

@section('title', 'Verifikasi Email - CEKU')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body text-center p-5">

                {{-- Icon --}}
                <div class="mb-4">
                    <i class="bi bi-envelope-check" style="font-size: 3rem; color: #0d6efd;"></i>
                </div>

                <h3 class="fw-bold mb-3">Verifikasi Alamat Email Anda</h3>
                <p class="text-muted mb-4">
                    Kami telah mengirimkan tautan verifikasi ke email Anda: 
                    <strong>{{ Auth::user()->email }}</strong>.<br>
                    Silakan klik tautan tersebut pada kotak masuk email untuk menyelesaikan proses verifikasi.
                </p>

                {{-- Alert jika link baru terkirim --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success text-start">
                        ✅ Tautan verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                @endif

                {{-- Kirim ulang verifikasi --}}
                <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                {{-- Logout jika ingin keluar --}}
                <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        Keluar
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
