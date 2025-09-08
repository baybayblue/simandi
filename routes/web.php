<?php

use Illuminate\Support\Facades\Route;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
// use App\Http\Controllers\Admin\UserController; // Dihapus karena tidak perlu
use App\Http\Controllers\Admin\ActivityLogController;
// Auth Controller
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// Pelanggan Controller
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');


// Grup route untuk ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', PelangganController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('transactions', TransactionController::class);
    // Route::resource('users', UserController::class); // Dihapus karena tidak perlu
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    // Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    // Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

    // --- Rute untuk Pengajuan Hapus ---
    Route::get('deletion-requests', [TransactionController::class, 'showDeletionRequests'])->name('transactions.deletion-requests');
    Route::post('transactions/{transaction}/approve-deletion', [TransactionController::class, 'approveDeletion'])->name('transactions.approve-deletion');
    Route::post('transactions/{transaction}/reject-deletion', [TransactionController::class, 'rejectDeletion'])->name('transactions.reject-deletion');
});

// Grup route untuk PELANGGAN
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/transaksi/baru', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transaksi/baru', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    
    // Rute untuk pelanggan mengajukan hapus
    Route::post('transaksi/{transaction}/request-deletion', [TransactionController::class, 'requestDeletion'])->name('transactions.request-deletion');
});

