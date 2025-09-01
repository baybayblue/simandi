@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Transaksi</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.transactions.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-square"></i> Tambah Transaksi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat (Kg)</th>
                                <th>Total Biaya</th>
                                <th>Status</th>
                                <th>Tgl Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration + $transactions->firstItem() - 1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}">
                                            <strong>{{ $transaction->invoice_code }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $transaction->customer->name }}</td>
                                    <td>{{ $transaction->service->name }}</td>
                                    <td>{{ number_format($transaction->weight, 2) }}</td>
                                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'masuk' => 'badge-info',
                                                'proses' => 'badge-warning',
                                                'selesai' => 'badge-success',
                                                'diambil' => 'badge-secondary',
                                            ][$transaction->status];
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                                    </td>
                                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
