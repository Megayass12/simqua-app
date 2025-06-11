<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Login;
use App\Http\Controllers\C_Regist;
use App\Http\Controllers\C_Pendaftaran;
use App\Http\Controllers\C_Profil;
use App\Http\Controllers\C_Daful;
use App\Http\Controllers\C_Informasi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('master.V_WebProfil');
});

Route::get('/ppdb', function () {
    return view('auth.V_Landing');
})->name('ppdb');

// Route Register untuk user
Route::get('/register', [C_Regist::class, 'daftar'])->name('register');
Route::post('/register', [C_Regist::class, 'daftarUser']);

// Route Login
Route::get('/login', [C_Login::class, 'masuk'])->name('login');
Route::post('/login', [C_Login::class, 'cekData'])->name('cekData');
Route::post('/logout', [C_Login::class, 'logout'])->name('logout');

// Route yang hanya bisa diakses oleh user yang sudah login (pakai middleware user)
Route::middleware(['user'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('master.V_Dashboard');
//     })->name('V_Dashboard');
});
    // Pendaftaran
    Route::get('/pendaftaran', [C_Pendaftaran::class, 'pendaftaran'])->name('V_Pendaftaran');
    Route::get('/daftar-ulang', [C_Daful::class, 'index'])->name('daftarUlang.index');
    Route::post('/daftar-ulang', [C_Daful::class, 'simpanDaftarUlang'])->name('daftarUlang.simpan');

    // Pendaftaran
    Route::post('/pendaftaran/simpan', [C_Pendaftaran::class, 'simpan'])->name('pendaftaran.simpan');
    Route::get('/pendaftaran/{id}', [C_Pendaftaran::class, 'show'])->name('pendaftaran.show');

    // Informasi
    Route::get('/informasi', [C_Informasi::class, 'ShowDataInformasi'])->name('informasi.index');
    Route::post('/informasi', [C_Informasi::class, 'store'])->name('informasi.store');
    Route::get('/informasi/{id}/detail', [C_Informasi::class, 'detail'])->name('informasi.detail');
    Route::post('/informasi/{id}/update', [C_Informasi::class, 'update'])->name('informasi.update');
    Route::delete('/informasi/{id}', [C_Informasi::class, 'destroy'])->name('informasi.destroy');

Route::middleware(['admin'])->group(function () {
    // Verifikasi
    Route::get('/admin/verifikasi', [C_Pendaftaran::class, 'adminPendaftaran'])->name('admin.pendaftaran');
    Route::put('/admin/verifikasi/{id}/{status}', [C_Pendaftaran::class, 'ubahStatus'])->name('admin.verifikasi');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('master.V_Dashboard');
    })->name('V_Dashboard');
    Route::get('/profil', [C_Profil::class, 'profil'])->name('V_Profil');
    Route::put('/profil', [C_Profil::class, 'update'])->name('profil.update');
});
