@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-6">
        Dashboard
    </h2>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pelanggan -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Transaksi Bulan Ini -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Transaksi Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-800">{{ $transactionsThisMonth }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
        </div>
        <!-- Transaksi Baru -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Cucian Baru Masuk</p>
                <p class="text-3xl font-bold text-gray-800">{{ $newTransactions }}</p>
            </div>
            <div class="bg-indigo-100 text-indigo-600 rounded-full p-3">
                <i data-lucide="shirt" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Transactions Table (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">Transaksi Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($recentTransactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600"><a href="{{ route('admin.transactions.show', $transaction->id) }}">{{ $transaction->invoice_code }}</a></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->customer->name }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activities (1/3 width) -->
        <div class="lg:col-span-1">
             <div class="bg-white shadow rounded-xl">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Aktivitas Terbaru</h3>
                </div>
                <div class="p-2">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse ($recentActivities as $activity)
                            <li class="p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100">
                                            @switch($activity->action)
                                                @case('created') <i data-lucide="plus-circle" class="h-5 w-5 text-green-500"></i> @break
                                                @case('updated') <i data-lucide="edit-3" class="h-5 w-5 text-yellow-500"></i> @break
                                                @case('deleted') <i data-lucide="trash-2" class="h-5 w-5 text-red-500"></i> @break
                                                @default <i data-lucide="info" class="h-5 w-5 text-gray-500"></i>
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1">
                                        <p class="text-sm text-gray-600">
                                            {{ $activity->description }} oleh <span class="font-medium text-gray-900">{{ $activity->user->name ?? 'Sistem' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            <time>{{ $activity->created_at->diffForHumans() }}</time>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @empty
                             <li class="p-4 text-center text-sm text-gray-500">
                                Belum ada aktivitas terbaru.
                            </li>
                        @endforelse
                    </ul>
                </div>
                 <div class="px-4 py-3 sm:px-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                    <a href="{{ route('admin.activity_logs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Lihat semua aktivitas &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

