@extends('layouts.auth')
@section('title', 'Reset Password - CEKU')

@section('content')
<h5 class="text-center mb-3">Reset Password</h5>
<p class="text-muted text-center mb-4">Masukkan password baru Anda.</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <!-- token dari email -->
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('login') }}">Kembali ke Login</a>
</div>
@endsection
