<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekomendasiPerawatan;
use App\Models\KondisiKuku;

class RekomendasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $rekomendasi = RekomendasiPerawatan::with('kondisiKuku')->get();
        return view('admin.rekomendasi.index', compact('rekomendasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $kondisiKukus = KondisiKuku::all();
        return view('admin.rekomendasi.create', compact('kondisiKukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'kondisi_kuku_id' => 'required|exists:kondisi_kukus,id',
            'recommendation' => 'required',
        ]);

        RekomendasiPerawatan::create([
            'kondisi_kuku_id' => $request->kondisi_kuku_id,
            'recommendation' => $request->recommendation,
        ]);

        return redirect()->route('admin.rekomendasi.index')->with('success', 'Rekomendasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekomendasiPerawatan $rekomendasi) {
        $kondisiKukus = KondisiKuku::all();
        return view('admin.rekomendasi.edit', compact('rekomendasi', 'kondisiKukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekomendasiPerawatan $rekomendasi) {
        $request->validate([
            'kondisi_kuku_id' => 'required|exists:kondisi_kukus,id',
            'recommendation' => 'required',
        ]);

        $rekomendasi->update([
            'kondisi_kuku_id' => $request->kondisi_kuku_id,
            'recommendation' => $request->recommendation,
        ]);

        return redirect()->route('admin.rekomendasi.index')->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekomendasiPerawatan $rekomendasi) {
        $rekomendasi->delete();
        return redirect()->route('admin.rekomendasi.index')->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
