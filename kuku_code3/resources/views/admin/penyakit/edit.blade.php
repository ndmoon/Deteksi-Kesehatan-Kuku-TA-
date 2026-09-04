@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Edit Penyakit</h2>
    <form action="{{ route('admin.penyakit.update',$penyakit->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-2">
            <label>Kondisi Kuku</label>
            <select name="kondisi_kuku_id" class="form-control" required>
                @foreach($kondisiKukus as $k)
                <option value="{{ $k->id }}" {{ $penyakit->kondisi_kuku_id==$k->id?'selected':'' }}>{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Penyakit</label>
            <input type="text" name="name" class="form-control" value="{{ $penyakit->name }}" required>
        </div>
        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $penyakit->description }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.penyakit.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
