@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Formulir Transaksi Baru
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Input data cucian pelanggan baru.
            </p>

            <form action="{{ route('admin.transactions.store') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                <!-- Pelanggan -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Pilih Pelanggan</label>
                    <select id="customer_id" name="customer_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        <option value="" disabled selected>-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Layanan -->
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700">Pilih Layanan</label>
                    <select id="service_id" name="service_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        <option value="" disabled selected>-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-price="{{ $service->price_per_kg }}">
                                {{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Berat Cucian (Kg) -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Berat Cucian (Kg)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" step="0.01" name="weight" id="weight" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 py-2 sm:text-sm border-gray-300 rounded-lg"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Kg</span>
                        </div>
                    </div>
                     @error('weight')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Total Biaya (otomatis) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                    <p id="total-price-display" class="mt-2 text-2xl font-bold text-indigo-600">Rp 0</p>
                </div>
                
                <!-- Catatan -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <div class="mt-1">
                        <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-lg"></textarea>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="pt-5">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.transactions.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
    const serviceSelect = document.getElementById('service_id');
    const weightInput = document.getElementById('weight');
    const totalPriceDisplay = document.getElementById('total-price-display');

    function calculateTotal() {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const pricePerKg = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const weight = parseFloat(weightInput.value) || 0;
        const total = pricePerKg * weight;

        totalPriceDisplay.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(total);
    }

    serviceSelect.addEventListener('change', calculateTotal);
    weightInput.addEventListener('input', calculateTotal);
</script>
@endpush
@endsection

