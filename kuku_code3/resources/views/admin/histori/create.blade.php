@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Tambah Histori Deteksi</h2>
    <form action="{{ route('admin.histori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="mb-2">
            <label>Usia</label>
            <input type="number" name="usia" class="form-control">
        </div>
        <div class="mb-2">
            <label>Kondisi Kuku</label>
            <select name="kondisi_kuku_id" class="form-control" required>
                @foreach($kondisi as $k)
                <option value="{{ $k->id }}">{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Upload Foto Kuku</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.histori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
