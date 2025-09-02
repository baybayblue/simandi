<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Tetapkan tanggal default: awal dan akhir bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Ambil data transaksi berdasarkan rentang tanggal
        $transactions = Transaction::with(['customer', 'service', 'user'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->paginate(20);

        // Hitung total pendapatan dari transaksi yang difilter
        $totalRevenue = $transactions->sum('total_price');

        return view('admin.reports.index', compact('transactions', 'totalRevenue', 'startDate', 'endDate'));
    }
}

