<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HistoriController;
use App\Http\Controllers\Admin\KondisiKukuController;
use App\Http\Controllers\Admin\PenyakitController;
use App\Http\Controllers\Admin\RekomendasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Auth\LoginController;


// use App\Http\Kernel;

// Route::get('/debug-middleware', function (Kernel $kernel) {
//     return $kernel->debugMiddleware();
// });


// Route::get('/test-admin', function () {
//     return 'Berhasil akses halaman admin';
// })->middleware(['auth', 'admin']);

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

// ========================
// Admin Routes
// ========================
// ->middleware(['auth', 'admin'])
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Dashboard
    // Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.adminDash');
    Route::get('/', [AdminController::class, 'index'])->name('admin.adminDash');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Histori
    Route::get('histori', [HistoriController::class, 'index'])->name('admin.histori.index');
    Route::get('histori/create', [HistoriController::class, 'create'])->name('admin.histori.create');
    Route::post('histori', [HistoriController::class, 'store'])->name('admin.histori.store');
    Route::get('histori/{histori}/edit', [HistoriController::class, 'edit'])->name('admin.histori.edit');
    Route::put('histori/{histori}', [HistoriController::class, 'update'])->name('admin.histori.update');
    Route::delete('histori/{histori}', [HistoriController::class, 'destroy'])->name('admin.histori.destroy');
    Route::get('histori-filter', [HistoriController::class, 'filter'])->name('admin.histori.filter');

    // Kondisi Kuku
    Route::get('kondisi', [KondisiKukuController::class, 'index'])->name('admin.kondisi.index');
    Route::get('kondisi/create', [KondisiKukuController::class, 'create'])->name('admin.kondisi.create');
    Route::post('kondisi', [KondisiKukuController::class, 'store'])->name('admin.kondisi.store');
    Route::get('kondisi/{kondisi}/edit', [KondisiKukuController::class, 'edit'])->name('admin.kondisi.edit');
    Route::put('kondisi/{kondisi}', [KondisiKukuController::class, 'update'])->name('admin.kondisi.update');
    Route::delete('kondisi/{kondisi}', [KondisiKukuController::class, 'destroy'])->name('admin.kondisi.destroy');

    // Penyakit
    Route::get('penyakit', [PenyakitController::class, 'index'])->name('admin.penyakit.index');
    Route::get('penyakit/create', [PenyakitController::class, 'create'])->name('admin.penyakit.create');
    Route::post('penyakit', [PenyakitController::class, 'store'])->name('admin.penyakit.store');
    Route::get('penyakit/{penyakit}/edit', [PenyakitController::class, 'edit'])->name('admin.penyakit.edit');
    Route::put('penyakit/{penyakit}', [PenyakitController::class, 'update'])->name('admin.penyakit.update');
    Route::delete('penyakit/{penyakit}', [PenyakitController::class, 'destroy'])->name('admin.penyakit.destroy');

    // Rekomendasi Perawatan
    Route::get('rekomendasi', [RekomendasiController::class, 'index'])->name('admin.rekomendasi.index');
    Route::get('rekomendasi/create', [RekomendasiController::class, 'create'])->name('admin.rekomendasi.create');
    Route::post('rekomendasi', [RekomendasiController::class, 'store'])->name('admin.rekomendasi.store');
    Route::get('rekomendasi/{rekomendasi}/edit', [RekomendasiController::class, 'edit'])->name('admin.rekomendasi.edit');
    Route::put('rekomendasi/{rekomendasi}', [RekomendasiController::class, 'update'])->name('admin.rekomendasi.update');
    Route::delete('rekomendasi/{rekomendasi}', [RekomendasiController::class, 'destroy'])->name('admin.rekomendasi.destroy');

});

// User Routes

Route::middleware(['auth'])->group(function () {
    // Dashboard, upload, riwayat
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/upload', [DashboardController::class, 'upload'])->name('upload');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])
        ->name('histori.destroy');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::get('/redirect', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.adminDash')
            : redirect()->route('dashboard');
    }
    return redirect()->route('admin.adminDash');
})->name('redirect');

// ========================
// Auth Routes
// ========================
require __DIR__.'/auth.php';

// Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
//     Route::get('/', [AdminController::class, 'index'])->name('admin.adminDash');

//     Route::resource('users', UserController::class);
//     Route::resource('histori', HistoriController::class);
//     Route::resource('kondisi', KondisiKukuController::class);
//     Route::resource('penyakit', PenyakitController::class);
//     Route::resource('rekomendasi', RekomendasiPerawatanController::class);
//     Route::get('histori-filter', [HistoriController::class, 'filter'])->name('histori.filter');
// });
// Kirim ulang verifikasi email dari profil
        // Route::post('/verification/send', function (Request $request) {
        //     if ($request->user()->hasVerifiedEmail()) {
        //         return back()->with('status', 'Email sudah terverifikasi');
        //     }

        //     $request->user()->sendEmailVerificationNotification();
        //     return back()->with('status', 'Link verifikasi telah dikirim ke email Anda');
        // })->middleware('throttle:6,1')->name('profile.verification.send');

        // // Callback saat user klik link verifikasi dari email
        // Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        //     $request->fulfill();
        //     return redirect()->route('profile.index')->with('status', 'Email berhasil diverifikasi');
        // })->middleware('signed')->name('verification.verify');
// Route::middleware(['auth'])->group(function () {
//     // Dashboard
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::post('/upload', [DashboardController::class, 'upload'])->name('upload');

//     // Profile
//     Route::prefix('profile')->group(function () {
//         Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
//         Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//         Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
//         Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

//         // Kirim ulang verifikasi email dari profil (opsional)
//         Route::post('/verification/send', function (Request $request) {
//             if ($request->user()->hasVerifiedEmail()) {
//                 return back()->with('status', 'Email sudah terverifikasi');
//             }

//             $request->user()->sendEmailVerificationNotification();
//             return back()->with('status', 'Link verifikasi telah dikirim ke email Anda');
//         })->middleware('throttle:6,1')->name('profile.verification.send');

//         // Callback saat user klik link verifikasi dari email
//         Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//             $request->fulfill();
//             return redirect()->route('profile.index')->with('status', 'Email berhasil diverifikasi');
//         })->middleware('signed')->name('verification.verify');
//     });
// });

