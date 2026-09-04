@extends('layouts.auth')
@section('title', 'Daftar - CEKU')

@section('content')
<h6 class="text-center mb-3">Isikan data diri Anda.</h6>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input id="name" type="text" name="name" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Daftar</button>
</form>

<div class="mt-3 text-center">
    Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk</a>
</div>
@endsection
