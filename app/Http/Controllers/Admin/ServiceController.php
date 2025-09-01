<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar semua layanan.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Menampilkan form untuk membuat layanan baru.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Menyimpan layanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|integer|min:0',
            'estimated_completion_date' => 'required|date',
        ]);

        // Menggunakan nama kolom yang benar: estimated_completion_date
        Service::create([
            'name' => $request->name,
            'price_per_kg' => $request->price_per_kg,
            'estimated_completion_date' => $request->estimated_completion_date,
        ]);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit layanan.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Memperbarui data layanan di database.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|integer|min:0',
            'estimated_completion_date' => 'required|date',
        ]);

        // Menggunakan nama kolom yang benar: estimated_completion_date
        $service->update([
            'name' => $request->name,
            'price_per_kg' => $request->price_per_kg,
            'estimated_completion_date' => $request->estimated_completion_date,
        ]);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus data layanan dari database.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }
}

