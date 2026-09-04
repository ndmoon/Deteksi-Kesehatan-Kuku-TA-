@extends('layouts.app')

@section('title', 'Hasil Analisis')

@section('content')
<h1 class="mb-4">Hasil Analisis Kuku</h1>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Nama :</strong> {{ $histori->nama }}</p>
        <p><strong>Usia :</strong> {{ $histori->usia }}</p>
        <p><strong>Kondisi Kuku :</strong> {{ $kondisi->name }}</p>
        <p><strong>Gambar Kuku :</strong></p>
        <img src="{{ asset($histori->image_path) }}" alt="Gambar Kuku" class="img-fluid rounded mb-3" style="max-width: 300px;">

        <h5>Daftar Penyakit Terkait :</h5>
        @if($penyakitList->isEmpty())
            <p>Tidak ada data penyakit terkait.</p>
        @else
            <ul>
                @foreach($penyakitList as $penyakit)
                    <li><strong>{{ $penyakit->penyakit_name }}</strong>: {{ $penyakit->description }}</li>
                @endforeach
            </ul>
        @endif

        <h5>Rekomendasi Perawatan :</h5>
        @if($rekomendasiList->isEmpty())
            <p>Tidak ada rekomendasi perawatan.</p>
        @else
            <ul>
                @foreach($rekomendasiList as $rekomendasi)
                    <li>{{ $recommendation }}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Unggah Gambar Baru</a>
    </div>
</div>
@endsection
