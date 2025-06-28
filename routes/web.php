<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PenyewaanController; // Pastikan ini di-use

// Halaman umum
Route::get('/', function () {
    return view('beranda');
});

Route::get('/panduan', function () {
    return view('panduan');
});

Route::get('/tentang', function () {
    return view('tentang');
});

// Proses Sewa (Frontend)
Route::get('/sewa', [SewaController::class, 'index'])->name('sewa'); // Ini tetap menggunakan SewaController
// >>>>>> UBAH RUTE INI: Pastikan ini menggunakan PenyewaanController <<<<<<
Route::get('/form-sewa', [PenyewaanController::class, 'showFormSewa'])->name('form.sewa'); // Sekarang menggunakan PenyewaanController
Route::post('/sewa/proses', [PenyewaanController::class, 'store'])->name('sewa.proses');
Route::get('/sewa/berhasil/{penyewaan}', [PenyewaanController::class, 'success'])->name('sewa.berhasil');

// Login Admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Group route untuk admin yang memerlukan otentikasi dan peran admin
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/konfirmasi/cetak', [AdminController::class, 'cetakPenyewaanPDF'])->name('konfirmasi.cetak');


    // Rute untuk menampilkan daftar konfirmasi penyewaan
    Route::get('/konfirmasi-penyewaan', [AdminController::class, 'showKonfirmasiPenyewaan'])->name('konfirmasi-penyewaan.index');

    // Rute untuk aksi konfirmasi dan tolak penyewaan
    Route::post('/konfirmasi-penyewaan/{id}/konfirmasi', [AdminController::class, 'konfirmasiPenyewaan'])->name('konfirmasi-penyewaan');
    Route::delete('/konfirmasi-penyewaan/{id}/tolak', [AdminController::class, 'tolakPenyewaan'])->name('tolak-penyewaan');

    // Rute untuk menambah admin baru
    Route::get('/tambah-admin', [AdminController::class, 'showAddAdminForm'])->name('tambah-admin.form');
    Route::post('/tambah-admin', [AdminController::class, 'storeAdmin'])->name('tambah-admin.store');

    // Tampilkan form hapus admin
   Route::get('/hapus-admin', [AdminController::class, 'showHapusAdminForm'])->name('hapus-admin.form');

    // Rute untuk pengelolaan penyewaan oleh admin
    Route::resource('/penyewaan', PenyewaanController::class);

    Route::get('/konfirmasi', [AdminController::class, 'showKonfirmasiPenyewaan'])->name('konfirmasi');
    
    // Rute logout admin
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
    Route::delete('/hapus-admin/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.hapus-admin');

// Redirect rute 'login' default ke admin login (jika diperlukan oleh middleware Authenticate)
Route::get('/login', function () {
    return redirect()->route('admin.login.form');
})->name('login');




    
