<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'service'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($subq) use ($search) {
                      $subq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        return view('admin.transactions.create', compact('customers', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
        ]);

        $service = Service::findOrFail($request->service_id);
        $totalPrice = $service->price_per_kg * $request->weight;

        // Generate unique invoice code
        $invoiceCode = 'TRX-' . Carbon::now()->format('Ymd') . '-' . strtoupper(uniqid());

        Transaction::create([
            'invoice_code' => $invoiceCode,
            'customer_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'weight' => $request->weight,
            'total_price' => $totalPrice,
            'status' => 'Baru', // Default status
            'payment_status' => 'Belum Lunas', // Default payment status
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $customers = Customer::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $statuses = ['Baru', 'Proses', 'Selesai', 'Diambil'];
        $paymentStatuses = ['Belum Lunas', 'Lunas'];

        return view('admin.transactions.edit', compact('transaction', 'customers', 'services', 'statuses', 'paymentStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0.1',
            'status' => 'required|in:Baru,Proses,Selesai,Diambil',
            'payment_status' => 'required|in:Belum Lunas,Lunas',
        ]);

        $service = Service::findOrFail($request->service_id);
        $totalPrice = $service->price_per_kg * $request->weight;

        $transaction->update([
            'customer_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'weight' => $request->weight,
            'total_price' => $totalPrice,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
            // Automatically set completion/pickup date based on status
            'completion_date' => $request->status == 'Selesai' ? now() : $transaction->completion_date,
            'pickup_date' => $request->status == 'Diambil' ? now() : $transaction->pickup_date,
        ]);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Data transaksi berhasil dihapus.');
    }
}

