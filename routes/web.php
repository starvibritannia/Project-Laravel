<?php

use Illuminate\Support\Facades\Route;

// 1. Import Semua Controller
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController; // Tambahan Baru untuk Login

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// BAGIAN 1: PENGUNJUNG / UMUM (PUBLIC)
// ==========================================
// Route ini bisa diakses siapa saja tanpa login

// Halaman Utama (Form Tap In)
Route::get('/', [VisitController::class, 'create'])->name('visit.create');

// Proses Simpan Data Tap In
Route::post('/tap-in', [VisitController::class, 'store'])->name('visit.store');

// Halaman Form Tap Out
Route::get('/tap-out', [VisitController::class, 'tapOutForm'])->name('visit.tap-out');

// Proses Tap Out
Route::post('/tap-out-process', [VisitController::class, 'tapOutProcess'])->name('visit.tap-out-process');


// ==========================================
// BAGIAN 2: OTENTIKASI (LOGIN & LOGOUT)
// ==========================================

// Menampilkan Form Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses Login (Cek Email & Password)
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// BAGIAN 3: ADMIN AREA (PROTECTED)
// ==========================================
// Semua route di dalam grup ini HANYA bisa diakses jika sudah Login.
// Jika belum login, otomatis dilempar ke halaman login.

Route::middleware(['auth'])->group(function () {
    
    // 1. Menu Utama Admin (Landing Page setelah Login)
    Route::get('/admin/menu', function () {
        return view('admin.menu');
    })->name('admin.menu');

    // 2. Dashboard Pantau Pengunjung
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 3. Proses Pengembalian Barang (Tombol "Terima Barang")
    Route::post('/admin/return/{id}', [AdminController::class, 'returnItem'])->name('admin.return');

    // 4. Manajemen Barang (CRUD Tambah, Edit, Hapus Barang)
    // Otomatis membuat route: index, create, store, show, edit, update, destroy
    Route::resource('items', ItemController::class);


// Route untuk menghapus riwayat kunjungan secara manual
Route::delete('/admin/visit/delete/{id}', [AdminController::class, 'destroyVisit'])->name('admin.visit.destroy');
});