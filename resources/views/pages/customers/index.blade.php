@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users mr-2"></i>Data Pelanggan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pelanggan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-alt mr-2"></i>
                                Daftar Pelanggan
                                @if (isset($totalPelanggan))
                                    <span class="badge badge-info ml-2">{{ $totalPelanggan }} Total</span>
                                @endif
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Tambah Pelanggan
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
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form action="{{ route('customers.index') }}" method="GET" class="mb-4">
                                <div class="form-row">
                                    <div class="col-md-4 mb-2">
                                        <label for="search_query">Cari (Nama / No. Telpon)</label>
                                        <div class="input-group">
                                            <input type="text" name="search_query" id="search_query" class="form-control"
                                                placeholder="Masukkan nama atau nomor telpon" value="{{ request('search_query') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="start_date">Dari Tanggal</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                                value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="end_date">Sampai Tanggal</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                                value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <label for="limit">Limit</label>
                                        <select name="limit" id="limit" class="form-control" onchange="this.form.submit()">
                                            @foreach ([10, 25, 50, 100] as $option)
                                                <option value="{{ $option }}" {{ request('limit', 10) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Cari</button>
                                        <a href="{{ route('customers.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-sync-alt"></i> Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No. Telpon</th>
                                            <th style="width: 15%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customers as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>{{ $item->nomor_telpon }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-info btn-sm" onclick="showPelangganDetail('{{ $item->id }}')" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('customers.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        {{-- Tombol Toggle Status --}}
                                                        <button type="button" class="btn btn-primary btn-sm toggle-status-btn"
                                                                data-id="{{ $item->id }}" 
                                                                data-status="{{ $item->status }}"
                                                                title="Ubah Status">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('customers.destroy', $item->id) }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data pelanggan yang ditemukan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $customers->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="pelangganDetailModal" tabindex="-1" role="dialog" aria-labelledby="pelangganDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pelangganDetailModalLabel">Detail Data Pelanggan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8" id="detail_nama"></dd>
                                <dt class="col-sm-4">No. Telpon</dt>
                                <dd class="col-sm-8" id="detail_no_hp"></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8" id="detail_alamat"></dd>
                                <dt class="col-sm-4">Tanggal Daftar</dt>
                                <dd class="col-sm-8" id="detail_created_at"></dd>
                                <dt class="col-sm-4">Terakhir Diperbarui</dt>
                                <dd class="col-sm-8" id="detail_updated_at"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi konfirmasi hapus
        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Data sedang dalam proses penghapusan.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Fungsi menampilkan detail pelanggan
        function showPelangganDetail(id) {
            fetch(`/customers/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detail_nama').innerText = data.nama || '-';
                    document.getElementById('detail_no_hp').innerText = data.nomor_telpon || '-';
                    document.getElementById('detail_alamat').innerText = data.alamat || '-';

                    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                    document.getElementById('detail_created_at').innerText = new Date(data.created_at).toLocaleDateString('id-ID', options);
                    document.getElementById('detail_updated_at').innerText = new Date(data.updated_at).toLocaleDateString('id-ID', options);

                    $('#pelangganDetailModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching pelanggan data:', error);
                    Swal.fire('Error!', 'Gagal memuat data pelanggan. ' + error.message, 'error');
                });
        }

        // Event listener untuk tombol toggle status
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-status-btn');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const customerId = this.dataset.id;
                    const currentStatus = this.dataset.status;

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: `Apakah Anda yakin ingin mengubah status pelanggan ini menjadi ${currentStatus === 'Aktif' ? 'Tidak Aktif' : 'Aktif'}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ubah!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            toggleStatus(customerId);
                        }
                    });
                });
            });

            function toggleStatus(id) {
                const url = `{{ url('customers') }}/${id}/toggle-status`;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _token: csrfToken
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => Promise.reject(errorData));
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire('Berhasil!', data.message, 'success')
                        .then(() => {
                            window.location.reload(); // Muat ulang halaman untuk melihat perubahan
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', error.message || 'Gagal mengubah status.', 'error');
                });
            }
        });
    </script>
@endpush
