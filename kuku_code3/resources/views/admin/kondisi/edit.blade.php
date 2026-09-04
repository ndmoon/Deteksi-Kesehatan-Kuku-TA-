@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Edit Kondisi Kuku</h2>
    <form action="{{ route('admin.kondisi.update',$kondisi->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-2">
            <label>Nama Kondisi</label>
            <input type="text" name="name" class="form-control" value="{{ $kondisi->nama }}" required>
        </div>
        <div class="mb-2">
            <label>Nama Tampilan</label>
            <input type="text" name="display_name" class="form-control" value="{{ $kondisi->display_name }}" required>
        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $kondisi->deskripsi }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.kondisi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
