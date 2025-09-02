<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk kartu statistik
        $totalCustomers = Customer::count();
        $totalRevenue = Transaction::where('payment_status', 'Lunas')->sum('total_price');
        $transactionsThisMonth = Transaction::whereMonth('created_at', Carbon::now()->month)->count();
        $newTransactions = Transaction::where('status', 'Baru Masuk')->count();

        // Data untuk tabel
        $recentTransactions = Transaction::with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();
            
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalRevenue',
            'transactionsThisMonth',
            'newTransactions',
            'recentTransactions',
            'recentActivities'
        ));
    }
}
