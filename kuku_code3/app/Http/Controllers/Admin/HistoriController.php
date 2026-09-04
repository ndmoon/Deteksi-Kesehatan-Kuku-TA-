<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use App\Models\User;
use App\Models\KondisiKuku;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.histori.index', compact('users'));
    }

    /**
     * API / AJAX filter histori
     */

    // public function filter(Request $request)
    // {
    //     $query = Histori::with(['user', 'kondisi_kuku']);

    //     if ($request->user_id) {
    //         $query->where('user_id', $request->user_id);
    //     }

    //     if ($request->search) {
    //         $query->where('nama', 'like', "%{$request->search}%");
    //     }

    //     if ($request->start_date) {
    //         $query->whereDate('created_at', '>=', $request->start_date);
    //     }

    //     if ($request->end_date) {
    //         $query->whereDate('created_at', '<=', $request->end_date);
    //     }

    //     $histori = $query->orderBy('created_at', 'desc')->paginate(10);

    //     // Debug: pastikan data terkirim
    //     // return response()->json($histori);

    //     return response()->json([
    //         'data' => $histori->items(),
    //         'links' => [
    //             'prev' => $histori->previousPageUrl(),
    //             'next' => $histori->nextPageUrl(),
    //         ],
    //         'meta' => [
    //             'current_page' => $histori->currentPage(),
    //             'last_page' => $histori->lastPage(),
    //         ],
    //     ]);
    // }
    public function filter(Request $request)
    {
        $userId = $request->query('user_id');

        $historisQuery = Histori::with(['user', 'kondisiKuku']);

        if ($userId) {
            $historisQuery->where('user_id', $userId);
        }

        $historis = $historisQuery->latest()->paginate(5);

        return response()->json([
            'data' => $historis->items(),
            'links' => [
                'next' => $historis->nextPageUrl(),
                'prev' => $historis->previousPageUrl(),
            ],
            'meta' => [
                'current_page' => $historis->currentPage(),
                'last_page' => $historis->lastPage(),
            ]
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $kondisi = KondisiKuku::all();
        return view('admin.histori.create', compact('users','kondisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nama' => 'nullable|string|max:255',
            'usia' => 'nullable|integer',
            'kondisi_kuku_id' => 'required',
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('histori', 'public');

        Histori::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'usia' => $request->usia,
            'kondisi_kuku_id' => $request->kondisi_kuku_id,
            'image_path' => $path,
        ]);

        return redirect()->route('admin.histori.index')->with('success','Histori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Histori $histori)
    {
        $users = User::all();
        $kondisi = KondisiKuku::all();
        return view('admin.histori.edit', compact('histori','users','kondisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Histori $histori)
{
    $request->validate([
        'user_id' => 'required',
        'nama' => 'nullable|string|max:255',
        'usia' => 'nullable|integer',
        'kondisi_kuku_id' => 'required',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = [
        'user_id' => $request->user_id,
        'nama' => $request->nama,
        'usia' => $request->usia,
        'kondisi_kuku_id' => $request->kondisi_kuku_id,
    ];

    if ($request->hasFile('image')) {
        // hapus foto lama
        if ($histori->image_path && file_exists(storage_path('app/public/'.$histori->image_path))) {
            unlink(storage_path('app/public/'.$histori->image_path));
        }
        // simpan foto baru
        $path = $request->file('image')->store('histori', 'public');
        $data['image_path'] = $path;
    }

    $histori->update($data);

    return redirect()->route('admin.histori.index')->with('success','Histori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Histori $histori)
    {
        if ($histori->image_path && file_exists(storage_path('app/public/'.$histori->image_path))) {
            unlink(storage_path('app/public/'.$histori->image_path));
        }
        $histori->delete();

        // Jika request dari AJAX
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Histori dihapus']);
        }

        return back()->with('success','Histori dihapus');
    }
}
