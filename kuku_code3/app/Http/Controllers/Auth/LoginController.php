<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Tentukan redirect tujuan setelah login berhasil
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        Log::info('Login berhasil: ' . $user->email . ' sebagai ' . $user->role);

        if ($user->role === 'admin') {
            // Redirect ke route admin.dashboard (pastikan route ini sudah ada)
            return redirect()->route('admin.adminDash');
        }

        // Redirect ke route dashboard user biasa (pastikan route ini sudah ada)
        return redirect()->route('dashboard');
    }

    /**
     * Membuat middleware
     */
    public function __construct()
    {
        // Middleware hanya boleh diakses oleh guest kecuali logout
        $this->middleware('guest')->except('logout');
        // Middleware auth hanya untuk logout (user harus login untuk logout)
        $this->middleware('auth')->only('logout');
    }
}
