<?php

// app/Http/Controllers/RiwayatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Histori;
use Illuminate\Support\Facades\Storage;


class RiwayatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // hanya untuk user login
    }

    public function index()
    {
        $histori = Histori::where('user_id', auth()->id())
            ->with('kondisiKuku','kondisiKuku.penyakits', 'kondisiKuku.rekomendasiPerawatans')
            ->latest()
            ->get();

        return view('riwayat', compact('histori'));
    }

    public function destroy($id)
    {
        $histori = Histori::where('id', $id)
            ->where('user_id', auth()->id()) // hanya bisa hapus milik sendiri
            ->firstOrFail();

        // Hapus gambar jika ada
        if ($histori->image_path) {
            if ($histori->image_path) {
                Storage::disk('public')->delete($histori->image_path);
            }
        }

        $histori->delete();

        return redirect()->back()->with('success', 'Riwayat berhasil dihapus.');
    }
}
