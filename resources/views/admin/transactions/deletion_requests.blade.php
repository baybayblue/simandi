@extends('layouts.app')

@section('title', 'Pengajuan Hapus Transaksi')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Tinjau Pengajuan Hapus
            </h2>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan Pengajuan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Diajukan</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($requests as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}">{{ $transaction->invoice_code }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 max-w-xs">{{ $transaction->deletion_reason }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->updated_at->isoFormat('D MMM YYYY') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <form action="{{ route('admin.transactions.approve-deletion', $transaction->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Setujui & Hapus</button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject-deletion', $transaction->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="text-center">
                                            <i data-lucide="inbox" class="mx-auto h-12 w-12 text-gray-400"></i>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan</h3>
                                            <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada pengajuan pembatalan dari pelanggan.</p>
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
        {{ $requests->links() }}
    </div>
</div>
@endsection
