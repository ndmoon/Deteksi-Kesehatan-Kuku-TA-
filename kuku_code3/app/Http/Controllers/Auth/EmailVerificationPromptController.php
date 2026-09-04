<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerificationPromptController extends Controller
{
    /**
     * Tampilkan halaman verifikasi email.
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('profile.index'))
                    : view('auth.verify-email');
    }
}
