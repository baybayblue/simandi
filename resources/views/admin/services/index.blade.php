@extends('layouts.app')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Layanan</li>
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
                            <h3 class="card-title">Daftar Layanan Laundry</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.services.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i> Tambah Layanan
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
                                        <th>Jenis Layanan</th>
                                        <th>Harga per Kg (Rp)</th>
                                        <th>Estimasi Selesai (Hari)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $service)
                                        <tr>
                                            <td>{{ $loop->iteration + $services->firstItem() - 1 }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ number_format($service->price_per_kg, 0, ',', '.') }}</td>
                                            <td>{{ $service->estimated_completion_days }}</td>
                                            <td>
                                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus layanan ini?')"><i class="fas fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data layanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         <div class="card-footer clearfix">
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

