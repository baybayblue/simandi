@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Action Buttons -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
            <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
            Kembali ke Daftar Transaksi
        </a>
        <div class="space-x-3">
            <button onclick="printInvoice()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i data-lucide="printer" class="-ml-1 mr-2 h-5 w-5 text-gray-500"></i>
                Cetak Nota
            </button>
            <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i data-lucide="edit" class="-ml-1 mr-2 h-5 w-5"></i>
                Edit Transaksi
            </a>
        </div>
    </div>

    <!-- Invoice -->
    <div id="invoice-content" class="bg-white shadow sm:rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 lg:flex lg:items-center lg:justify-between">
            <div>
                <h3 class="text-2xl leading-6 font-bold text-gray-900">
                    Invoice #{{ $transaction->invoice_code }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Tanggal Masuk: {{ $transaction->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                </p>
            </div>
            <div class="mt-4 lg:mt-0">
                <p class="text-sm font-medium text-gray-500">Status Pembayaran</p>
                 <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $transaction->payment_status }}
                </span>
            </div>
        </div>

        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <!-- Customer Details -->
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Pelanggan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <p class="font-semibold">{{ $transaction->customer->name }}</p>
                        <p>{{ $transaction->customer->email }}</p>
                        <p>{{ $transaction->customer->phone }}</p>
                        <p class="text-gray-600">{{ $transaction->customer->address }}</p>
                    </dd>
                </div>
                <!-- Service Details -->
                 <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Detail Cucian</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="space-y-2">
                           <div class="flex justify-between">
                               <span>Layanan</span>
                               <span class="font-medium">{{ $transaction->service->name }}</span>
                           </div>
                           <div class="flex justify-between">
                               <span>Harga per Kg</span>
                               <span class="font-medium">Rp {{ number_format($transaction->service->price_per_kg, 0, ',', '.') }}</span>
                           </div>
                           <div class="flex justify-between">
                               <span>Berat</span>
                               <span class="font-medium">{{ $transaction->weight }} Kg</span>
                           </div>
                        </div>
                    </dd>
                </div>
                <!-- Status & Dates -->
                 <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status & Jadwal</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                         <div class="space-y-2">
                           <div class="flex justify-between">
                               <span>Status Cucian</span>
                               <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($transaction->status)
                                        @case('Baru') bg-blue-100 text-blue-800 @break
                                        @case('Proses') bg-yellow-100 text-yellow-800 @break
                                        @case('Selesai') bg-green-100 text-green-800 @break
                                        @case('Diambil') bg-gray-100 text-gray-800 @break
                                    @endswitch">
                                    {{ $transaction->status }}
                                </span>
                           </div>
                           <div class="flex justify-between">
                               <span>Tanggal Selesai</span>
                               <span class="font-medium">{{ $transaction->completion_date ? $transaction->completion_date->isoFormat('D MMM YYYY, HH:mm') : '-' }}</span>
                           </div>
                           <div class="flex justify-between">
                               <span>Tanggal Diambil</span>
                               <span class="font-medium">{{ $transaction->pickup_date ? $transaction->pickup_date->isoFormat('D MMM YYYY, HH:mm') : '-' }}</span>
                           </div>
                        </div>
                    </dd>
                </div>
                 <!-- Notes -->
                @if($transaction->notes)
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                       {{ $transaction->notes }}
                    </dd>
                </div>
                @endif
                 <!-- Total Price -->
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50 rounded-b-lg">
                    <dt class="text-lg font-bold text-gray-900">Total Biaya</dt>
                    <dd class="mt-1 text-lg font-bold text-indigo-600 sm:mt-0 sm:col-span-2 text-right">
                       Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>

@push('scripts')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice-content, #invoice-content * {
            visibility: visible;
        }
        #invoice-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
<script>
    function printInvoice() {
        window.print();
    }
</script>
@endpush
@endsection

