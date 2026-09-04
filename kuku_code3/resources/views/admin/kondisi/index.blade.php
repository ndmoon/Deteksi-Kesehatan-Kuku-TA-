@extends('admin.be.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Kondisi Kuku</h2>

    <!-- Tabel Kondisi Kuku -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Nama Tampilan</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kondisi as $k)
                        <tr>
                            <td>{{ $k->name }}</td>
                            <td>{{ $k->display_name }}</td>
                            <td>{{ $k->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3">Tidak ada data kondisi kuku</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
