<!-- @if($histori)
    @foreach($histori as $item)
        <div>
            <p>Nama: {{ $item->nama }}</p>
            <p>Usia: {{ $item->usia }}</p>
            <img src="{{ asset($item->image_path) }}" width="150">
            <p>Kondisi: {{ $item->kondisiKuku->name }}</p>
            <h5>Penyakit:</h5>
            <ul>
                @foreach($item->kondisiKuku->penyakit as $p)
                    <li>{{ $p->penyakit_name }} - {{ $p->description }}</li>
                @endforeach
            </ul>
            <h5>Rekomendasi Perawatan:</h5>
            <ul>
                @foreach($item->kondisiKuku->rekomendasiPerawatan as $r)
                    <li>{{ $r->recommendation }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
@else
    <p>Belum ada riwayat.</p>
@endif -->
