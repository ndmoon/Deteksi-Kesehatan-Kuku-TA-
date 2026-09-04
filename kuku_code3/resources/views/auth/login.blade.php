@extends('layouts.auth') 
@section('title', 'Login - CEKU')

@section('content')
<h6 class="text-center mb-3 text-muted">Silahkan masukkan email dan password Anda.</h6>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control" required autofocus>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>

    <!-- Remember Me -->
    <!-- <div class="form-check mb-3">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label for="remember" class="form-check-label">Ingat saya</label>
    </div> -->

    <button type="submit" class="btn btn-primary w-100">Masuk</button>
</form>

<!-- <div class="mt-3 text-center">
    <a href="{{ route('password.request') }}">Lupa Password?</a>
</div> -->
<div class="mt-2 text-center">
    Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar</a>
</div>
@endsection
