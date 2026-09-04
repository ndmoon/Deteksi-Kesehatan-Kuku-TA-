<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Histori;
use App\Models\KondisiKuku;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // semua method butuh login
    }

    public function index()
    {
        return view('dashboard');
    }

    public function upload(Request $request)
    {
        $request->validate([
            // 'nama' => 'required|string|max:255',
            // 'usia' => 'required|integer|min:1',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'predictions' => 'required|string',
        ]);

        $file = $request->file('image_path');
        $path = $file->store('uploads', 'public');
        $imageUrl = Storage::url($path);

        $predictions = json_decode($request->predictions, true);
        if(!$predictions || count($predictions)==0){
            return response()->json(['error'=>'Prediksi tidak valid'],422);
        }

        $topPredictions = collect($predictions)
            ->sortByDesc('prob')
            ->take(2)
            ->values();

        $mainPrediction = $topPredictions->first();

        // cari kondisi kuku di DB
        $kondisi = KondisiKuku::where('name', $mainPrediction['name'])->first();
        if (!$kondisi) {
            return response()->json([
                'error' => 'Label model tidak ditemukan di database'
            ], 422);
        }

        $histori = Histori::create([
            'user_id' => Auth::id(),
            // 'nama' => $request->nama,
            // 'usia' => $request->usia,
            'image_path' => $path,
            'kondisi_kuku_id' => $kondisi->id,
            'prediction' => $mainPrediction['name'],
            'confidence' => $mainPrediction['prob'],
        ]);

        $penyakitList = $kondisi->penyakits()->get(['penyakit_name','description']);
        $rekomendasiList = $kondisi->rekomendasiPerawatans()->pluck('recommendation');

        return response()->json([
            // 'nama' => $histori->nama,
            // 'usia' => $histori->usia,
            'image_url' => $imageUrl,
            'kondisi' => $topPredictions->map(function ($p) {
                $k = KondisiKuku::where('name', $p['name'])->first();
                return [
                    'display_name' => $k?->display_name ?? $p['name'],
                    'confidence'   => round($p['prob'] * 100, 2),
                    // 'description'  => $k?->description ?? '-',
                ];
            }),
            'description' => $kondisi->description ?? '-',
            'penyakit' => $penyakitList,
            'rekomendasi' => $rekomendasiList,
        ]);

        // pakai display_name dan description dari DB
        // $mappedPredictions = $topPredictions->map(function ($p) {
        //     $kondisi = KondisiKuku::where('name', $p['name'])->first();

        //     return [
        //         'display_name' => $kondisi?->display_name ?? $p['name'],
        //         'description'  => $kondisi?->description ?? '-',
        //         'prob'          => $p['prob'],
        //     ];
        // });

        // return response()->json([
        //     'nama' => $histori->nama,
        //     'usia' => $histori->usia,
        //     'image_url' => $imageUrl,
        //     'predictions' => $predictions,
        //     'kondisi' => [
        //         'name' => $kondisi->name,
        //         'display_name' => $kondisi->display_name,
        //         'description' => $kondisi->description, 
        //     ],
        //     'penyakit' => $penyakitList,
        //     'rekomendasi' => $rekomendasiList,
        // ]);
    }



    // public function upload(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'image_path' => 'required|image|mimes:jpg,jpeg,png|max:5120',
    //             'nama' => 'required|string|max:255',
    //             'usia' => 'required|integer|min:1|max:120',
    //         ]);

    //         // Simpan file upload
    //         $image = $request->file('image_path');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('uploads'), $imageName);
    //         $imagePath = 'uploads/' . $imageName;

    //         // Panggil ML model untuk dapatkan nama kondisi
    //         $namaKondisi = $this->callMLModel($imagePath); // asumsi method ini sudah kamu buat

    //         // Cari kondisi kuku terkait
    //         $kondisi = KondisiKuku::where('name', $namaKondisi)->firstOrFail();

    //         // Simpan histori ke database
    //         $histori = Histori::create([
    //             'user_id' => auth()->id(),
    //             'nama' => $request->nama,
    //             'usia' => $request->usia,
    //             'image_path' => $imagePath,
    //             'kondisi_kuku_id' => $kondisi->id,
    //         ]);

    //         // Ambil list penyakit dan rekomendasi dalam bentuk array string
    //         $penyakitList = $kondisi->penyakits()->get(['penyakit_name', 'description']);
    //         $rekomendasi = $kondisi->rekomendasiPerawatans()->pluck('recommendation')->toArray();
    //         // Tambahkan rekomendasi umum
    //         $rekomendasiTambahan = [
    //             "Perawatan kuku : jangan biarkan panjang, potong kuku datar, jangan mengikuti pola merah, harus dibersihkan.",
    //             "Perawatan kuku kaki : gunakan sepatu jangan terlalu sempit, jika kaki berkeringat istirahatkan dengan melepas sepatu dan kaus kaki, jangan biarkan sampai lembab."
    //         ];

    //         $rekomendasiList = array_merge($rekomendasi, $rekomendasiTambahan);
    //         $deskripsiKondisi = $kondisi->description;

    //         // Return response JSON sesuai format frontend
    //         return response()->json([
    //             'image_path' => $histori->image_path,
    //             'nama' => $request->nama,
    //             'usia' => $request->usia,
    //             'kondisi_kuku' => $kondisi->name,
    //             'deskripsi_kondisi' => $deskripsiKondisi,
    //             'image_url' => asset($histori->image_path),
    //             'penyakit' => $penyakitList,
    //             'rekomendasi' => $rekomendasiList,
    //         ]);
    //     } catch (\Exception $e) {
    //         // Kirim pesan error spesifik agar mudah debugging
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    // private function callMLModel($imagePath)
    // {
    //     // Simulasi response dari model ML (di dunia nyata pakai HTTP request)
    //     return KondisiKuku::inRandomOrder()->first()->name;
    // }


    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image_path' => 'required|file|mimes:jpg,jpeg,png|max:5120',
    //         'nama' => 'required|string|max:255',
    //         'usia' => 'required|integer|min:1|max:120',
    //     ], [
    //         'image_path.required' => 'Gambar wajib diunggah.',
    //         'image_path.mimes' => 'Format gambar harus JPG atau PNG.',
    //         'image_path.max' => 'Ukuran gambar maksimal 5MB.',
    //     ]);

    //     $image = $request->file('image_path');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();

    //     // Simpan file ke folder public/uploads
    //     $image->move(public_path('uploads'), $imageName);

    //     // Simpan path relatif ke database (sesuaikan dengan path penyimpanan)
    //     $path = 'uploads/' . $imageName;

    //     $kondisi = KondisiKuku::inRandomOrder()->first();

    //     $histori = Histori::create([
    //         'user_id' => auth()->id(),
    //         'nama' => $request->nama,
    //         'usia' => $request->usia,
    //         'image_path' => $path,
    //         'kondisi_kuku_id' => $kondisi->id,
    //     ]);

    //     // Ambil data relasi
    //     $penyakitList = $kondisi->penyakit()->pluck('penyakit_name');
    //     $rekomendasiList = $kondisi->rekomendasiPerawatan()->pluck('recommendation');

    //     return response()->json([
    //         'nama' => $histori->nama,
    //         'usia' => $histori->usia,
    //         'image_path' => $histori->image_path,
    //         'kondisi_kuku' => $kondisi->name,
    //         'penyakit' => $penyakitList,
    //         'rekomendasi' => $rekomendasiList
    //     ]);
    // }


    // public function riwayat()
    // {
    //     $histori = Histori::where('user_id', auth()->id())
    //         ->with('kondisiKuku.penyakit', 'kondisiKuku.rekomendasiPerawatan')
    //         ->latest()
    //         ->get();

    //     if ($histori->isEmpty()) {
    //         return view('riwayat', ['histori' => null]); // tidak tampilkan apapun jika belum upload
    //     }

    //     return view('riwayat', compact('histori'));
    // }


    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image_path' => 'required|file|mimes:image/jpeg,image/png|max:5120',
    //         'nama' => 'required|string|max:255',
    //         'usia' => 'required|integer|min:1|max:120',
    //     ], [
    //         'image_path.required' => 'Gambar wajib diunggah.',
    //         'image_path.mimetypes' => 'Format gambar harus JPG atau PNG.',
    //         'image_path.max' => 'Ukuran gambar maksimal 5MB.',
    //     ]);

    //     // Jika lolos validasi, simpan file dan proses lainnya
    //     $image = $request->file('image_path');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
    //     // $image->move(public_path('uploads'), $imageName);


    //     $path = $request->file('image_path')->store('uploads', 'public');
    //     $kondisi = KondisiKuku::inRandomOrder()->first();

    //     $histori = Histori::create([
    //         'user_id' => auth()->id(),
    //         'nama' => $request->nama,
    //         'usia' => $request->usia,
    //         'image_path' => $path,
    //         'kondisi_kuku_id' => $kondisi->id,
    //     ]);

    //     // Load relasi
    //     $penyakitList = $kondisi->penyakit()->pluck('penyakit_name');
    //     $rekomendasiList = $kondisi->rekomendasiPerawatan()->pluck('recommendation');

    //     return response()->json([
    //         'nama' => $histori->nama,
    //         'usia' => $histori->usia,
    //         'image_path' => $histori->image_path,
    //         'kondisi_kuku' => $kondisi->name,
    //         'penyakit' => $penyakitList,
    //         'rekomendasi' => $rekomendasiList
    //     ]);
    // }
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image_path' => 'required|image|mimes:jpg,jpeg,png|max:5120',
    //         'nama' => 'required|string',
    //         'usia' => 'required|integer',
    //     ]);

    //     // Simpan file
    //     $path = $request->file('image_path')->store('uploads', 'public');

    //     // Deteksi kondisi kuku (contoh dummy)
    //     $kondisiKuku = KondisiKuku::inRandomOrder()->first(); // Sesuaikan dengan logika deteksi

    //     // Simpan histori
    //     $histori = Histori::create([
    //         'user_id' => auth()->id(),
    //         'nama' => $request->nama,
    //         'usia' => $request->usia,
    //         'image_path' => $path,
    //         'kondisi_kuku_id' => $kondisiKuku->id,
    //     ]);

    //     // Ambil kembali data lengkap
    //     $histori->load('kondisiKuku.penyakit', 'kondisiKuku.rekomendasiPerawatan');

    //     return view('dashboard', [
    //         'histori' => $histori
    //     ]);
    // }

}
