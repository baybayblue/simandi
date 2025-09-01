@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Transaksi ({{ $transaction->invoice_code }})</h3>
                </div>
                <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customer_id">Pilih Pelanggan</label>
                            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_id">Pilih Layanan</label>
                            <select name="service_id" id="service_id" class="form-control @error('service_id') is-invalid @enderror" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $transaction->service_id) == $service->id ? 'selected' : '' }}>
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
                            <input type="number" step="0.1" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $transaction->weight) }}" required>
                             @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status Cucian</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach ($statuses as $status)
                                     <option value="{{ $status }}" {{ old('status', $transaction->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $transaction->notes) }}</textarea>
                             @error('notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Transaksi</button>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
