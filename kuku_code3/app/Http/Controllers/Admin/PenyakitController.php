<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use App\Models\KondisiKuku;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $penyakit = Penyakit::with('kondisiKuku')->get();
        return view('admin.penyakit.index', compact('penyakit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $kondisiKukus = KondisiKuku::all();
        return view('admin.penyakit.create', compact('kondisiKukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'kondisi_kuku_id' => 'required|exists:kondisi_kukus,id',
            'penyakit_name' => 'required|unique:penyakits,penyakit_name',
            'description' => 'nullable',
        ]);

        Penyakit::create([
            'kondisi_kuku_id' => $request->kondisi_kuku_id,
            'penyakit_name' => $request->penyakit_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.penyakit.index')->with('success', 'Penyakit berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyakit $penyakit) {
        $kondisiKukus = KondisiKuku::all();
        return view('admin.penyakit.edit', compact('penyakit', 'kondisiKukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyakit $penyakit) {
        $request->validate([
            'kondisi_kuku_id' => 'required|exists:kondisi_kukus,id',
            'penyakit_name' => 'required|unique:penyakits,penyakit_name,' . $penyakit->id,
            'description' => 'nullable',
        ]);

        $penyakit->update([
            'kondisi_kuku_id' => $request->kondisi_kuku_id,
            'penyakit_name' => $request->penyakit_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.penyakit.index')->with('success', 'Penyakit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyakit $penyakit) {
        $penyakit->delete();
        return redirect()->route('admin.penyakit.index')->with('success', 'Penyakit berhasil dihapus.');
    }
}
