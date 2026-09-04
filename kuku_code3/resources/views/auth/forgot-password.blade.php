@extends('layouts.auth')
@section('title', 'Lupa Password - CEKU')

@section('content')
<h5 class="text-center mb-3">Lupa Password</h5>
<p class="text-muted text-center mb-4">Masukkan email Anda untuk menerima link reset password.</p>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('login') }}">Kembali ke Login</a>
</div>
@endsection
