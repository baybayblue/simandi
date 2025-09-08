<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     * Logika "pintar": Jika yang login pelanggan, hanya tampilkan transaksinya.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Transaction::with(['customer', 'service'])->latest();

        // Jika yang login adalah pelanggan
        if ($user->role === 'pelanggan') {
            $customer = Customer::where('email', $user->email)->first();
            if ($customer) {
                $query->where('customer_id', $customer->id);
            } else {
                // Jika data pelanggan tidak ada, tampilkan kosong
                $query->where('customer_id', -1); 
            }
        }

        $transactions = $query->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan formulir untuk membuat transaksi baru.
     * Logika "pintar": Mengirim data yang berbeda untuk admin dan pelanggan.
     */
    public function create()
    {
        $user = Auth::user();
        $services = Service::all();
        $customers = [];

        // Jika admin, ambil semua data pelanggan
        if ($user->role === 'admin') {
            $customers = Customer::all();
        }

        return view('admin.transactions.create', compact('services', 'customers'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     * Logika "pintar": Menentukan customer_id secara otomatis jika pembuatnya pelanggan.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
            // Jika admin, customer_id wajib diisi
            'customer_id' => ($user->role === 'admin' ? 'required|exists:customers,id' : 'nullable'),
        ]);

        $service = Service::find($validated['service_id']);
        $totalPrice = $validated['weight'] * $service->price_per_kg;
        $customerId = null;

        // Jika pelanggan yang membuat, cari ID pelanggannya berdasarkan email
        if ($user->role === 'pelanggan') {
            $customer = Customer::where('email', $user->email)->firstOrFail();
            $customerId = $customer->id;
        } else {
            // Jika admin, ambil dari input form
            $customerId = $validated['customer_id'];
        }

        Transaction::create([
            'invoice_code' => 'INV-' . strtoupper(Str::random(8)),
            'customer_id' => $customerId,
            'service_id' => $validated['service_id'],
            'user_id' => $user->id, // Admin/Pelanggan yang membuat
            'weight' => $validated['weight'],
            'total_price' => $totalPrice,
            'status' => 'Baru Masuk',
            'payment_status' => 'Belum Lunas',
            'notes' => $validated['notes'],
        ]);

        $redirectRoute = $user->role === 'admin' ? 'admin.transactions.index' : 'pelanggan.dashboard';
        return redirect()->route($redirectRoute)->with('success', 'Transaksi baru berhasil dibuat!');
    }
    
    // ... (method show, edit, update, destroy tetap sama seperti sebelumnya) ...

    public function show(Transaction $transaction)
    {
        // (Tidak ada perubahan, method show sudah aman)
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $services = Service::all();
        $customers = Customer::all();
        return view('admin.transactions.edit', compact('transaction', 'services', 'customers'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
            'status' => 'required|in:Baru Masuk,Proses,Selesai,Diambil',
            'payment_status' => 'required|in:Belum Lunas,Lunas',
            'notes' => 'nullable|string',
        ]);
        
        $service = Service::find($validated['service_id']);
        $validated['total_price'] = $validated['weight'] * $service->price_per_kg;

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

