@extends('layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Formulir Edit Layanan
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Perbarui detail layanan laundry di bawah ini.
            </p>

            <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')
                <!-- Jenis Layanan -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Jenis Layanan</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="package" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg"
                               placeholder="Contoh: Cuci Kering Setrika">
                    </div>
                    @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Harga per Kg -->
                <div>
                    <label for="price_per_kg" class="block text-sm font-medium text-gray-700">Harga per Kg</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="price_per_kg" id="price_per_kg" value="{{ old('price_per_kg', $service->price_per_kg) }}" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-8 py-2 sm:text-sm border-gray-300 rounded-lg"
                               placeholder="Contoh: 7000">
                    </div>
                    @error('price_per_kg')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Estimasi Tanggal Selesai -->
                <div>
                    <label for="estimated_completion_date" class="block text-sm font-medium text-gray-700">Estimasi Tanggal Selesai</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="calendar-days" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input type="date" name="estimated_completion_date" id="estimated_completion_date" value="{{ old('estimated_completion_date', $service->estimated_completion_date ? \Carbon\Carbon::parse($service->estimated_completion_date)->format('Y-m-d') : '') }}" required
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg">
                    </div>
                    @error('estimated_completion_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-5">
                    <div class="flex justify-between">
                         <button type="button" onclick="deleteConfirmation('{{ route('admin.services.destroy', $service->id) }}')" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Hapus Layanan Ini
                        </button>
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.services.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update
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
    function deleteConfirmation(deleteUrl) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data layanan yang dihapus tidak dapat dikembalikan!",
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

