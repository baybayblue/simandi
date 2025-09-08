@extends('layouts.app')

@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Formulir Transaksi Baru
            </h2>
        </div>
    </div>

    <!-- Create Form -->
    <div class="mt-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md">
            {{-- Form akan mengirim ke rute yang benar, tergantung peran --}}
            <form action="{{ Auth::user()->role === 'admin' ? route('admin.transactions.store') : route('pelanggan.transactions.store') }}" method="POST" x-data="transactionForm()">
                @csrf
                <div class="space-y-6">

                    {{-- Logika "Pintar": Kolom ini hanya muncul jika yang login adalah admin --}}
                    @if (Auth::user()->role === 'admin')
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">Pilih Pelanggan</label>
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Pilih Layanan</label>
                        <select id="service_id" name="service_id" x-model="selectedService" @change="calculateTotal" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price_per_kg }}">{{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)</option>
                            @endforeach
                        </select>
                         @error('service_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Weight Input -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Berat Cucian (kg)</label>
                        <input type="number" name="weight" id="weight" step="0.1" min="0.1" x-model="weight" @input.debounce.500ms="calculateTotal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: 5.5">
                        @error('weight') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                     <!-- Total Price Display -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estimasi Total Biaya</label>
                        <div class="mt-1 p-3 bg-gray-100 rounded-md text-lg font-semibold text-gray-800" x-text="totalPrice">
                            Rp 0
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Tolong jangan disetrika terlalu panas."></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Transaksi
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
            selectedService: '',
            weight: 0,
            services: @json($services->keyBy('id')),
            totalPrice: 'Rp 0',
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

