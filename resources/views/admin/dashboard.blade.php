@extends('layouts.app')

{{-- Judul Halaman --}}
@section('title', 'Dashboard Admin')

{{-- Konten Halaman --}}
@section('content')
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cash-register"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Transaksi Hari Ini</span>
                            <span class="info-box-number">
                                10
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tshirt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cucian Belum Diambil</span>
                            <span class="info-box-number">41</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pendapatan Bulan Ini</span>
                            <span class="info-box-number">Rp 760.000</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pelanggan</span>
                            <span class="info-box-number">25</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Selamat Datang, Admin!</h5>
                        </div>
                        <div class="card-body">
                            <p>Anda telah berhasil masuk ke panel admin Simandi Laundry. Dari sini Anda dapat mengelola data pelanggan, layanan, transaksi, dan melihat laporan.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
