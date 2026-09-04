@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Riwayat Analisis')

@section('content')
<h1 class="mb-4">Riwayat Analisis Kuku</h1>

@if ($histori->isEmpty())
    <p>Belum ada riwayat analisis. Silakan lakukan analisis terlebih dahulu.</p>
@else
    <div class="list-group">
        @foreach ($histori as $item)
            <div class="list-group-item mb-3">
                <!-- <p><strong>Nama :</strong> {{ $item->nama }}</p> -->
                <!-- <p><strong>Usia :</strong> {{ $item->usia }}</p> -->
                <p><strong>Kondisi Kuku :</strong> {{ $item->kondisiKuku->display_name ?? '-' }}</p>
                <img 
                    src="{{ Storage::url($item->image_path) }}" 
                    alt="Gambar Kuku"
                    style="max-width: 150px; border-radius: 8px;"
                    class="mb-2"
                />
                <p><strong>Deskripsi Kondisi :</strong></p>
                <p>
                    {{ $item->kondisiKuku->description ?? 'Deskripsi belum tersedia.' }}
                </p>
                <h6>Kemungkinan atau tanda awal Masalah Kesehatan/Penyakit yang dialami :</h6>
                <ul>
                    @foreach($item->kondisiKuku->penyakits as $penyakit)
                        <li><strong>{{ $penyakit->penyakit_name }}</strong>: {{ $penyakit->description }}</li>
                    @endforeach
                </ul>

                <h6>Rekomendasi Perawatan Kuku :</h6>
                <ul>
                    @foreach($item->kondisiKuku->rekomendasiPerawatans as $rekomendasi)
                        <li>{{ $rekomendasi->recommendation }}</li>
                    @endforeach
                </ul>
                
                <!-- Tombol Hapus -->
                <button
                    type="button"
                    class="btn btn-link text-danger p-0 mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal{{ $item->id }}"
                    title="Hapus Riwayat">
                    <i class="bi bi-trash"></i> Hapus Riwayat
                </button>

                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade"
                     id="deleteModal{{ $item->id }}"
                     tabindex="-1"
                     aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title text-danger">
                                    Konfirmasi Hapus Riwayat
                                </h5>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p>
                                    Yakin ingin menghapus riwayat analisis
                                    <strong>
                                        {{ $item->kondisiKuku->display_name ?? $item->kondisiKuku->name }}
                                    </strong>?
                                </p>
                                <small class="text-muted">
                                    Data yang dihapus tidak dapat dikembalikan.
                                </small>
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <form action="{{ route('histori.destroy', $item->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger">
                                        Ya, Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
@endif
@endsection
