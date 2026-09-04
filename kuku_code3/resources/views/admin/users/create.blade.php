@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Tambah User</h2>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection