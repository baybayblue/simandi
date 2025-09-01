<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'address' => 'nullable|string',
        ]);

        // Buat customer baru
        Customer::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Biasanya untuk detail, tapi kita bisa langsung arahkan ke edit
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:15|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
        ]);

        // Update data customer
        $customer->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Hapus data customer
        $customer->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}

