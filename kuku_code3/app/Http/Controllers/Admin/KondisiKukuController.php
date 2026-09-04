<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KondisiKuku;
use Illuminate\Http\Request;

class KondisiKukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $kondisi = KondisiKuku::all();
        return view('admin.kondisi.index', compact('kondisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.kondisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:kondisi_kukus,name',
            'description' => 'nullable'
        ]);

        KondisiKuku::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KondisiKuku $kondisi) {
        return view('admin.kondisi.edit', compact('kondisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KondisiKuku $kondisi) {
        $request->validate([
            'name' => 'required|unique:kondisi_kukus,name,' . $kondisi->id,
            'description' => 'nullable'
        ]);

        $kondisi->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KondisiKuku $kondisi) {
        $kondisi->delete();
        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil dihapus.');
    }
}
