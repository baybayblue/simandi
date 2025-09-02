@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Formulir Edit Transaksi
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Perbarui detail transaksi untuk Invoice: <strong>{{ $transaction->invoice_code }}</strong>
            </p>

            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')
                <!-- Pelanggan -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Pilih Pelanggan</label>
                    <select id="customer_id" name="customer_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $transaction->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Layanan -->
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700">Pilih Layanan</label>
                    <select id="service_id" name="service_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-price="{{ $service->price_per_kg }}" {{ $transaction->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Berat Cucian (Kg) -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Berat Cucian (Kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $transaction->weight) }}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-2">
                </div>

                 <!-- Total Biaya (otomatis) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                    <p id="total-price-display" class="mt-2 text-2xl font-bold text-indigo-600">Rp 0</p>
                </div>

                <!-- Status Cucian -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Cucian</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $transaction->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Pembayaran -->
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                    <select id="payment_status" name="payment_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                        @foreach($paymentStatuses as $p_status)
                        <option value="{{ $p_status }}" {{ $transaction->payment_status == $p_status ? 'selected' : '' }}>{{ $p_status }}</option>
                        @endforeach
                    </select>
                </div>
                
                 <!-- Catatan -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-lg">{{ old('notes', $transaction->notes) }}</textarea>
                </div>

                <!-- Action Buttons -->
                <div class="pt-5">
                    <div class="flex justify-between">
                         <button type="button" onclick="deleteConfirmation('{{ route('admin.transactions.destroy', $transaction->id) }}')" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Hapus Transaksi Ini
                        </button>
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.transactions.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
    
    // Initial calculation on page load for edit form
    document.addEventListener('DOMContentLoaded', calculateTotal);

    serviceSelect.addEventListener('change', calculateTotal);
    weightInput.addEventListener('input', calculateTotal);

    function deleteConfirmation(deleteUrl) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data transaksi yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = deleteUrl;
                form.submit();
            }
        })
    }
</script>
@endpush
@endsection

