@extends('layouts.app')

{{-- Judul halaman "pintar": Berubah sesuai peran pengguna --}}
@section('title', Auth::user()->role === 'admin' ? 'Manajemen Transaksi' : 'Riwayat Transaksi Saya')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{-- Judul konten "pintar" --}}
                @if (Auth::user()->role === 'admin')
                    Manajemen Transaksi
                @else
                    Riwayat Transaksi Saya
                @endif
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            {{-- Tombol "pintar": Link-nya berbeda untuk admin dan pelanggan --}}
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.transactions.create') : route('pelanggan.transactions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i data-lucide="plus-circle" class="mr-2 h-5 w-5"></i>
                @if (Auth::user()->role === 'admin')
                    Tambah Transaksi
                @else
                    Buat Pesanan Baru
                @endif
            </a>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                {{-- Kolom "Pelanggan" hanya muncul untuk admin --}}
                                @if (Auth::user()->role === 'admin')
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Cucian</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">{{ $transaction->invoice_code }}</td>
                                    @if (Auth::user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->customer->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->payment_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->isoFormat('D MMM YYYY') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Link detail "pintar" --}}
                                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.transactions.show', $transaction->id) : route('pelanggan.transactions.show', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Pesan "pintar" --}}
                                    <td colspan="{{ Auth::user()->role === 'admin' ? '7' : '6' }}" class="text-center py-12">
                                        <div class="text-center">
                                            <i data-lucide="folder-search" class="mx-auto h-12 w-12 text-gray-400"></i>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                                @if(Auth::user()->role === 'admin')
                                                    Belum ada transaksi
                                                @else
                                                    Kamu belum punya riwayat pesanan
                                                @endif
                                            </h3>
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
    <!-- Pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection

