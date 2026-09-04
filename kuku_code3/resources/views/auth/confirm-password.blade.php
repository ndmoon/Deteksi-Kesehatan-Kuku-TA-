@extends('layouts.auth')
@section('title', 'Konfirmasi Password - CEKU')

@section('content')
<h3 class="text-center mb-3 fw-bold">Konfirmasi Password</h3>
<p class="text-muted text-center mb-4">Silakan masukkan password Anda sebelum melanjutkan.</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-4">Konfirmasi</button>
    </div>
</form>
@endsection
