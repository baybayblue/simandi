@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-6">
        Selamat Datang, {{ Auth::user()->name }}!
    </h2>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Pesanan -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Total Pengeluaran -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSpending ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Cucian Aktif -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Cucian Aktif</p>
                <p class="text-3xl font-bold text-gray-800">{{ $activeTransactions ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                <i data-lucide="shirt" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Riwayat Pesanan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentTransactions ?? [] as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->invoice_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($transaction->status)
                                        @case('Baru Masuk') bg-blue-100 text-blue-800 @break
                                        @case('Proses') bg-yellow-100 text-yellow-800 @break
                                        @case('Selesai') bg-green-100 text-green-800 @break
                                        @case('Diambil') bg-gray-100 text-gray-800 @break
                                    @endswitch">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('pelanggan.transactions.show', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Kamu belum punya riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

