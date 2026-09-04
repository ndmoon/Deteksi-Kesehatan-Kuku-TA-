<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Histori;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // semua method butuh login
    }

    public function index()
    {
        return view('home');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'usia'   => 'required|integer|min:1',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('gambar')->store('uploads', 'public');

        Histori::create([
            'user_id'         => Auth::id(),
            'nama'            => $request->nama,
            'usia'            => $request->usia,
            'kondisi_kuku_id' => null,
            'image_path'      => $path,
        ]);

        return redirect()->back()->with('success', 'Gambar berhasil diunggah!');
    }
}
