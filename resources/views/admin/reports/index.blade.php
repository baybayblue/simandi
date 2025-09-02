@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold leading-tight text-gray-900">
            Laporan Transaksi
        </h2>
        <p class="mt-1 text-sm text-gray-600">Analisis dan ekspor data transaksi Anda.</p>
    </div>

    <!-- Filter and Actions Card -->
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <div class="md:flex md:items-center md:justify-between">
            <!-- Filter Form -->
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex-grow md:flex md:items-end md:space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-center space-x-2 pt-5">
                     <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i data-lucide="filter" class="mr-2 h-4 w-4"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center p-2 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50" title="Reset Filter">
                        <i data-lucide="rotate-cw" class="h-4 w-4"></i>
                    </a>
                </div>
            </form>
            <!-- Action Buttons -->
            <div class="mt-4 md:mt-0 md:ml-6 flex items-center space-x-3 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6">
                <a href="#" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i data-lucide="file-text" class="mr-2 h-4 w-4 text-red-500"></i>
                    PDF
                </a>
                <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i data-lucide="file-spreadsheet" class="mr-2 h-4 w-4 text-green-600"></i>
                    Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white border-l-4 border-blue-500 p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="wallet" class="h-8 w-8 text-blue-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan (Lunas)</dt>
                        <dd class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-white border-l-4 border-green-500 p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="receipt" class="h-8 w-8 text-green-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Transaksi</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ count($transactions) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>


    <!-- Report Table -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h3>
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="overflow-hidden border-b border-gray-200">
                     <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}">{{ $transaction->invoice_code }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $transaction->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="text-center">
                                            <i data-lucide="file-search" class="mx-auto h-12 w-12 text-gray-400"></i>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data transaksi</h3>
                                            <p class="mt-1 text-sm text-gray-500">Tidak ada transaksi yang ditemukan untuk rentang tanggal yang dipilih.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

