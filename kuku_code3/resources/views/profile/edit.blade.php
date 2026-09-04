@extends('layouts.app')

@section('title', 'Edit Profil - CEKU')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-person-circle me-2"></i> Edit Profil & Password
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" 
                                        data-bs-target="#profil" type="button" role="tab">
                                    <i class="bi bi-person"></i> Profil
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="password-tab" data-bs-toggle="tab" 
                                        data-bs-target="#password" type="button" role="tab">
                                    <i class="bi bi-shield-lock"></i> Password
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="profileTabContent">
                            {{-- Tab Profil --}}
                            <div class="tab-pane fade show active" id="profil" role="tabpanel">
                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama</label>
                                    <input type="text" id="name" name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', Auth::user()->name) }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" id="email" name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tab Password --}}
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                {{-- Password Lama --}}
                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                                    <input type="password" id="current_password" name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           autocomplete="current-password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password Baru --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="form-control" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Semua Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
