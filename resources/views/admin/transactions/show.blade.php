@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $transaction->invoice_code)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with Back Button -->
    <div class="mb-6">
        {{-- Tombol kembali "pintar" --}}
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.transactions.index') : route('pelanggan.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
            <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    <!-- Invoice Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-8 py-6">
            <!-- Invoice Header -->
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Nota Transaksi</h2>
                    <p class="text-sm text-indigo-600 font-semibold">{{ $transaction->invoice_code }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Tanggal Masuk</p>
                    <p class="font-medium text-gray-700">{{ $transaction->created_at->isoFormat('D MMMM YYYY') }}</p>
                </div>
            </div>

            <!-- Customer & Service Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 border-t border-gray-200 pt-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Untuk Pelanggan:</h3>
                    <p class="mt-2 text-lg font-medium text-gray-900">{{ $transaction->customer->name }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->customer->phone }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->customer->address }}</p>
                </div>
                <div class="md:text-right">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Layanan yang Dipilih:</h3>
                    <p class="mt-2 text-lg font-medium text-gray-900">{{ $transaction->service->name }}</p>
                    <p class="text-sm text-gray-600">Rp {{ number_format($transaction->service->price_per_kg, 0, ',', '.') }} / kg</p>
                </div>
            </div>

            <!-- Transaction Details Table -->
            <div class="mt-8">
                <table class="min-w-full">
                    <thead class="border-b border-gray-300">
                        <tr>
                            <th class="py-2 text-left text-sm font-semibold text-gray-600">Deskripsi</th>
                            <th class="py-2 text-right text-sm font-semibold text-gray-600">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <td class="py-4 text-sm text-gray-800">Berat Cucian</td>
                            <td class="py-4 text-right text-sm text-gray-800">{{ $transaction->weight }} kg</td>
                        </tr>
                        <tr class="font-bold">
                            <td class="py-4 text-base text-gray-900">Total Biaya</td>
                            <td class="py-4 text-right text-base text-gray-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Statuses -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6 border-t border-gray-200 pt-6">
                 <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Status Cucian:</h3>
                     <span class="mt-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @switch($transaction->status)
                            @case('Baru Masuk') bg-blue-100 text-blue-800 @break
                            @case('Proses') bg-yellow-100 text-yellow-800 @break
                            @case('Selesai') bg-green-100 text-green-800 @break
                            @case('Diambil') bg-gray-100 text-gray-800 @break
                        @endswitch px-3 py-1">
                        {{ $transaction->status }}
                    </span>
                </div>
                 <div class="md:text-right">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Status Pembayaran:</h3>
                    <span class="mt-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1">
                        {{ $transaction->payment_status }}
                    </span>
                </div>
            </div>

        </div>
        
        <!-- Actions / Footer -->
        <div class="bg-gray-50 px-8 py-4 flex justify-end items-center space-x-3">
             <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i data-lucide="printer" class="mr-2 h-4 w-4"></i>
                Cetak Nota
            </button>
            {{-- Tombol "Edit" hanya muncul untuk admin --}}
            @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                <i data-lucide="pencil" class="mr-2 h-4 w-4"></i>
                Edit Transaksi
            </a>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .bg-gray-50, .shadow-md, a, button {
            box-shadow: none !important;
            border: none !important;
        }
        .mb-6, .flex.justify-end {
            display: none !important;
        }
    }
</style>
@endsection

