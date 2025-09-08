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
        // Statistics
        $totalCustomers = Customer::count();
        $totalRevenue = Transaction::where('payment_status', 'Lunas')->sum('total_price');
        $transactionsThisMonth = Transaction::whereMonth('created_at', Carbon::now()->month)->count();
        $newTransactions = Transaction::where('status', 'Baru Masuk')->count();

        // Mengambil transaksi terbaru yang PASTI punya data pelanggan dan layanan
        $recentTransactions = Transaction::with(['customer', 'service'])
            ->whereHas('customer') // Memastikan pelanggan tidak null
            ->whereHas('service')  // Memastikan layanan tidak null
            ->latest()
            ->take(5)
            ->get();

        // Mengambil aktivitas terbaru
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

