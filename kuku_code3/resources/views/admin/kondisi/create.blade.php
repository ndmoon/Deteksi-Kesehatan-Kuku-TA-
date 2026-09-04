@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Tambah Kondisi Kuku</h2>
    <form action="{{ route('admin.kondisi.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>Nama Kondisi</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Nama Tampilan</label>
            <input type="text" name="display_name" class="form-control" required>
        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kondisi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
