@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Log Aktivitas Sistem</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Log Aktivitas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Semua Aktivitas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Pengguna</th>
                                <th>Deskripsi</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration + $logs->firstItem() - 1 }}</td>
                                    <td>{{ $log->user->name ?? 'Sistem' }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->diffForHumans() }} ({{ $log->created_at->format('d M Y, H:i') }})</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada aktivitas yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                   {{ $logs->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
