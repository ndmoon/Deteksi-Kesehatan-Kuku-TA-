<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update data profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => ['required', 'current_password'],
            'password'              => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
