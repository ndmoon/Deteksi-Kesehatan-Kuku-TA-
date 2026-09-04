@extends('admin.be.app')

@section('content')
<div class="container">
    <h2>Edit Rekomendasi Perawatan</h2>
    <form action="{{ route('admin.rekomendasi.update',$rekomendasi->id) }}" method="POST">
        @csrf @method('PUT')<div class="mb-2">
            <label>Kondisi Kuku</label>
            <select name="kondisi_kuku_id" class="form-control" required>
                @foreach($kondisiKukus as $k)
                <option value="{{ $k->id }}" {{ $rekomendasi->kondisi_kuku_id==$k->id?'selected':'' }}>{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Rekomendasi Perawatan</label>
            <input type="text" name="recommendation" class="form-control" value="{{ $rekomendasi->recommendation }}" required>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.rekomendasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
