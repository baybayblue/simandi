@extends('layouts.app')

@section('title', 'Edit Transaksi ' . $transaction->invoice_code)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Edit Transaksi
            </h2>
            <p class="mt-1 text-sm text-gray-500">Invoice: {{ $transaction->invoice_code }}</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
             <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                Batal
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="mt-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" x-data="transactionForm()">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Customer (read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                        <div class="mt-1 p-3 bg-gray-100 rounded-md text-base font-semibold text-gray-800">
                           {{ $transaction->customer->name }}
                        </div>
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Layanan</label>
                        <select id="service_id" name="service_id" x-model="selectedService" @change="calculateTotal" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price_per_kg }}" {{ $transaction->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)
                                </option>
                            @endforeach
                        </select>
                         @error('service_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Weight Input -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Berat Cucian (kg)</label>
                        <input type="number" name="weight" id="weight" step="0.1" min="0.1" value="{{ old('weight', $transaction->weight) }}" x-model="weight" @input.debounce.500ms="calculateTotal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('weight') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Total Price Display -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                        <div class="mt-1 p-3 bg-gray-100 rounded-md text-lg font-semibold text-gray-800" x-text="totalPrice">
                            Rp 0
                        </div>
                    </div>

                    <!-- Status Cucian -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Cucian</label>
                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="Baru Masuk" {{ $transaction->status == 'Baru Masuk' ? 'selected' : '' }}>Baru Masuk</option>
                            <option value="Proses" {{ $transaction->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $transaction->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Diambil" {{ $transaction->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                     <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select id="payment_status" name="payment_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="Belum Lunas" {{ $transaction->payment_status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Lunas" {{ $transaction->payment_status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('notes', $transaction->notes) }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function transactionForm() {
        return {
            selectedService: '{{ $transaction->service_id }}',
            weight: {{ $transaction->weight }},
            services: @json($services->keyBy('id')),
            totalPrice: 'Rp 0',
            init() {
                this.calculateTotal();
            },
            calculateTotal() {
                if (this.selectedService && this.weight > 0) {
                    const service = this.services[this.selectedService];
                    if (service) {
                        const total = this.weight * service.price_per_kg;
                        this.totalPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
                    }
                } else {
                    this.totalPrice = 'Rp 0';
                }
            }
        }
    }
</script>
@endpush
@endsection

