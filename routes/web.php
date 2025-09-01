<?php

use Illuminate\Support\Facades\Route;
// Controller untuk Otentikasi
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;

// Controller untuk Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === RUTE OTENTIKASI (LOGIN & LOGOUT) ===
// Didaftarkan secara manual untuk mengatasi error file 'auth.php' tidak ditemukan
Route::get('login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');


// Halaman utama akan diarahkan ke halaman login oleh middleware 'auth' jika belum login
Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard yang sesuai
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'pelanggan') {
            return redirect()->route('pelanggan.dashboard');
        }
    }
    // Jika belum, tampilkan halaman login
    return view('auth.login');
});

// Grup route untuk ADMIN
// Hanya bisa diakses oleh user yang sudah login DAN memiliki peran 'admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', PelangganController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('reports', ReportController::class)->only(['index']);
});

// Grup route untuk PELANGGAN
// Hanya bisa diakses oleh user yang sudah login DAN memiliki peran 'pelanggan'
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
});

