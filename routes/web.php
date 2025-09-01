<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller Otentikasi
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ActivityLogController; // Tambahkan ini

// Controller untuk Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;


// Rute Otentikasi
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');


// Grup route untuk ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', PelangganController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('reports', ReportController::class)->only(['index']);

    // Rute untuk Log Aktivitas
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
});


// Grup route untuk PELANGGAN
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
});

