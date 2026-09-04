<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Histori;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     // Pastikan hanya admin yang bisa akses
    //     $this->middleware(['auth', 'admin']);
    // }

    public function dashboard()
    {
        return view('admin.adminDash'); 
    }

    public function index()
    {
        // Hitung jumlah user
        $userCount = User::count();

        // Hitung jumlah histori (jika tabel ada)
        $historiCount = Histori::count() ?? 0;

        $users = User::latest()->take(5)->get();

        // Kirim data ke view
        return view('admin.adminDash', compact('userCount', 'historiCount', 'users'));
    }
}
