@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoice: <strong>{{ $transaction->invoice_code }}</strong></h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <!-- Tambahkan tombol cetak di sini jika diperlukan -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Detail Pelanggan</h4>
                                    <p><strong>Nama:</strong> {{ $transaction->customer->name }}</p>
                                    <p><strong>Email:</strong> {{ $transaction->customer->email }}</p>
                                    <p><strong>Telepon:</strong> {{ $transaction->customer->phone }}</p>
                                    <p><strong>Alamat:</strong> {{ $transaction->customer->address }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>Detail Cucian</h4>
                                    <p><strong>Layanan:</strong> {{ $transaction->service->name }}</p>
                                    <p><strong>Harga/Kg:</strong> Rp {{ number_format($transaction->service->price_per_kg, 0, ',', '.') }}</p>
                                    <p><strong>Berat:</strong> {{ number_format($transaction->weight, 2) }} kg</p>
                                    <hr>
                                    <p class="h4"><strong>Total Biaya: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                            <hr>
                            @if($transaction->notes)
                                <h4>Catatan</h4>
                                <p>{{ $transaction->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Status & Riwayat</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Status Saat Ini:</strong>
                                @php
                                    $statusClass = [
                                        'masuk' => 'badge-info',
                                        'proses' => 'badge-warning',
                                        'selesai' => 'badge-success',
                                        'diambil' => 'badge-secondary',
                                    ][$transaction->status];
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                            </p>
                            <hr>
                            <p><strong>Tanggal Masuk:</strong><br>{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            <p><strong>Tanggal Selesai Dicuci:</strong><br>{{ $transaction->completion_date ? $transaction->completion_date->format('d M Y, H:i') : '-' }}</p>
                            <p><strong>Tanggal Diambil:</strong><br>{{ $transaction->pickup_date ? $transaction->pickup_date->format('d M Y, H:i') : '-' }}</p>
                            <hr>
                            <p><strong>Diproses Oleh:</strong><br>{{ $transaction->user->name }}</p>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
