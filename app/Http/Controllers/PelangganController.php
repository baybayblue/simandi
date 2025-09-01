<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        // Logika Filter hanya berdasarkan nama atau nomor telepon
        if ($request->filled('search_query')) {
            $search = $request->input('search_query');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nomor_telpon', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tanggal daftar (created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $limit = $request->input('limit', 10);
        $customers = $query->paginate($limit);

        $totalPelanggan = Pelanggan::count();

        return view('pages.customers.index', compact('customers', 'totalPelanggan'));
    }

    /**
     * Menampilkan form untuk membuat pelanggan baru.
     */
    public function create()
    {
        return view('pages.customers.create');
    }

    /**
     * Menyimpan pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'alamat'       => 'required|string',
            'nomor_telpon' => 'required|string|max:20',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail pelanggan. Digunakan untuk modal detail.
     */
    public function show(Pelanggan $customer)
    {
        return response()->json($customer);
    }

    /**
     * Menampilkan form untuk mengedit pelanggan.
     */
    public function edit(Pelanggan $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    /**
     * Memperbarui data pelanggan di database.
     */
    public function update(Request $request, Pelanggan $customer)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'alamat'       => 'required|string',
            'nomor_telpon' => 'required|string|max:20',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Menghapus pelanggan dari database.
     */
    public function destroy(Pelanggan $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
