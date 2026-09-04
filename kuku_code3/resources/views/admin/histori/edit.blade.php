@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Edit Histori Deteksi</h2>
    <form action="{{ route('admin.histori.update',$histori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ $histori->user_id == $u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $histori->nama }}">
        </div>

        <div class="mb-2">
            <label>Usia</label>
            <input type="number" name="usia" class="form-control" value="{{ $histori->usia }}">
        </div>

        <div class="mb-2">
            <label>Kondisi Kuku</label>
            <select name="kondisi_kuku_id" class="form-control" required>
                @foreach($kondisi as $k)
                <option value="{{ $k->id }}" {{ $histori->kondisi_kuku_id == $k->id ? 'selected' : '' }}>
                    {{ $k->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Foto Kuku</label>
            <input type="file" name="image" class="form-control">
            <br>
            <img src="{{ asset('storage/'.$histori->image_path) }}" width="120">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.histori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
