@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Tambah Penyakit</h2>
    <form action="{{ route('admin.penyakit.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>Kondisi Kuku</label>
            <select name="kondisi_kuku_id" class="form-control" required>
                @foreach($kondisiKukus as $k)
                <option value="{{ $k->id }}">{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Penyakit</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.penyakit.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
