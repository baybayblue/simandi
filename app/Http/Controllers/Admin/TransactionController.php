<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index()
    {
        // Mengambil data transaksi beserta relasi customer dan service
        $transactions = Transaction::with(['customer', 'service'])->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        return view('admin.transactions.create', compact('customers', 'services'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $total_price = $service->price_per_kg * $request->weight;

        // Membuat kode invoice unik
        $invoice_code = 'INV-' . now()->format('Ymd') . '-' . mt_rand(1000, 9999);

        Transaction::create([
            'invoice_code' => $invoice_code,
            'customer_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'user_id' => Auth::id(), // Mengambil ID admin yang sedang login
            'weight' => $request->weight,
            'total_price' => $total_price,
            'status' => 'masuk', // Status default
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu transaksi.
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Menampilkan form untuk mengedit transaksi.
     */
    public function edit(Transaction $transaction)
    {
        $customers = Customer::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $statuses = ['masuk', 'proses', 'selesai', 'diambil'];
        return view('admin.transactions.edit', compact('transaction', 'customers', 'services', 'statuses'));
    }

    /**
     * Memperbarui data transaksi di database.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
            'status' => 'required|in:masuk,proses,selesai,diambil',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $total_price = $service->price_per_kg * $request->weight;

        // Menentukan tanggal selesai dan tanggal diambil berdasarkan status
        $completion_date = $transaction->completion_date;
        $pickup_date = $transaction->pickup_date;

        if ($request->status == 'selesai' && is_null($completion_date)) {
            $completion_date = now();
        }

        if ($request->status == 'diambil' && is_null($pickup_date)) {
            $pickup_date = now();
        }

        $transaction->update([
            'customer_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'weight' => $request->weight,
            'total_price' => $total_price,
            'status' => $request->status,
            'completion_date' => $completion_date,
            'pickup_date' => $pickup_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus data transaksi dari database.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }
}
