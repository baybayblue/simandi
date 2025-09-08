@extends('layouts.app')

{{-- Judul Halaman "Pintar" --}}
@section('title', Auth::user()->role === 'admin' ? 'Laporan Transaksi' : 'Laporan Saya')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{-- Judul Konten "Pintar" --}}
                @if (Auth::user()->role === 'admin')
                    Laporan Transaksi
                @else
                    Laporan Pengeluaran Saya
                @endif
            </h2>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="mt-6 bg-white p-6 rounded-xl shadow-md">
        <form action="{{ Auth::user()->role === 'admin' ? route('admin.reports.index') : route('pelanggan.laporan.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="flex items-center space-x-2">
                 <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    <i data-lucide="filter" class="mr-2 h-4 w-4"></i>
                    Filter
                </button>
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.reports.index') : route('pelanggan.laporan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Summary & Actions -->
    <div class="mt-8 bg-white p-6 rounded-xl shadow-md">
        <div class="md:flex md:items-center md:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Ringkasan Periode Ini</h3>
                <p class="mt-1 text-3xl font-bold text-indigo-600">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
                <p class="text-sm font-medium text-gray-500">
                    {{-- Keterangan "Pintar" --}}
                    @if (Auth::user()->role === 'admin')
                        Total Pendapatan dari Transaksi Lunas
                    @else
                        Total Pengeluaran dari Transaksi Lunas
                    @endif
                </p>
            </div>
            {{-- Tombol Ekspor hanya untuk admin --}}
            @if (Auth::user()->role === 'admin')
            <div class="mt-4 flex items-center space-x-3 md:mt-0">
                <a href="#" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                    <i data-lucide="file-text" class="mr-2 h-4 w-4"></i>
                    Cetak PDF
                </a>
                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800">
                    <i data-lucide="file-spreadsheet" class="mr-2 h-4 w-4"></i>
                    Export Excel
                </a>
            </div>
            @endif
        </div>
    </div>


    <!-- Report Table -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                {{-- Kolom Pelanggan hanya untuk admin --}}
                                @if (Auth::user()->role === 'admin')
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Cucian</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.transactions.show', $transaction->id) : route('pelanggan.transactions.show', $transaction->id) }}">{{ $transaction->invoice_code }}</a>
                                    </td>
                                    @if (Auth::user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->customer->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->payment_status }}
                                        </span>
                                    </td>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="text-center py-12">
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

