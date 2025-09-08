<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard khusus untuk pelanggan.
     */
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();

        // Jika data customer tidak ditemukan, beri pesan error.
        if (!$customer) {
            return view('pelanggan.dashboard')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        // Ambil statistik khusus untuk pelanggan ini
        $totalTransactions = Transaction::where('customer_id', $customer->id)->count();
        $totalSpending = Transaction::where('customer_id', $customer->id)->where('payment_status', 'Lunas')->sum('total_price');
        $activeTransactions = Transaction::where('customer_id', $customer->id)->whereNotIn('status', ['Diambil'])->count();
        
        // Ambil 5 transaksi terakhir
        $recentTransactions = Transaction::where('customer_id', $customer->id)
            ->with('service')
            ->latest()
            ->take(5)
            ->get();

        return view('pelanggan.dashboard', compact('totalTransactions', 'totalSpending', 'activeTransactions', 'recentTransactions'));
    }

    /**
     * Menampilkan nota detail transaksi (dengan pemeriksaan keamanan).
     */
    public function show(Transaction $transaction)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();

        // Pastikan pelanggan hanya bisa melihat transaksinya sendiri
        if ($transaction->customer_id !== $customer->id) {
            abort(403, 'Akses Ditolak');
        }

        return view('transactions.show', compact('transaction'));
    }
}

