@extends('layouts.app')

@section('title', 'Tambah Transaksi Baru')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Transaksi Baru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Transaksi</h3>
                </div>
                <form action="{{ route('admin.transactions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customer_id">Pilih Pelanggan</label>
                            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_id">Pilih Layanan</label>
                            <select name="service_id" id="service_id" class="form-control @error('service_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="weight">Berat Cucian (Kg)</label>
                            <input type="number" step="0.1" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}" placeholder="Contoh: 5.5" required>
                             @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                             @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
