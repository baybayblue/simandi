@extends('layouts.app')

@section('title', 'Edit Data Layanan')

@section('content')
<div class="container-fluid">
     <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Layanan</a></li>
                        <li class="breadcrumb-item active">Edit Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Layanan</h3>
                        </div>
                        <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Jenis Layanan</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $service->name) }}" required>
                                     @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price_per_kg">Harga per Kg (Rp)</label>
                                    <input type="number" class="form-control @error('price_per_kg') is-invalid @enderror" id="price_per_kg" name="price_per_kg" value="{{ old('price_per_kg', $service->price_per_kg) }}" required>
                                     @error('price_per_kg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="estimated_completion_date">Estimasi Tanggal Selesai</label>
                                    {{-- FIX: Check if the date is not null before formatting --}}
                                    <input type="date" class="form-control @error('estimated_completion_date') is-invalid @enderror" id="estimated_completion_date" name="estimated_completion_date" value="{{ old('estimated_completion_date', $service->estimated_completion_date ? $service->estimated_completion_date->format('Y-m-d') : '') }}" required>
                                     @error('estimated_completion_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

