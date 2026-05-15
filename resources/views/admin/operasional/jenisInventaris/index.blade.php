@php
    /*
        PROTEKSI ERROR:
        Jika $data tidak dikirim dari Controller, kita buat koleksi kosong.
    */
    $data = $data ?? collect();
@endphp

@extends('layouts.admin')

@section('title', 'Jenis Inventaris')

@push('styles')
<style>
    /* Hilangkan min-height 100vh agar tidak double scroll dengan layout utama */
    .content-wrapper-custom {
        padding: 0;
        background-color: transparent;
    }

    /* Header Styling */
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header-title {
        color: #2D3748;
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }

    .btn-tambah {
        background-color: #4188FF;
        color: white !important;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(65, 136, 255, 0.2);
    }

    .btn-tambah:hover {
        background-color: #2d6cd1;
        transform: translateY(-2px);
    }

    /* Card & Table Styling */
    .card-custom-box {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        padding: 2rem;
    }

    .search-filter-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
    }

    .search-wrapper i {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #A0AEC0;
    }

    .form-control-custom {
        padding-left: 3rem;
        height: 50px;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        background-color: #FAFBFF;
        transition: all 0.2s;
    }

    .filter-wrapper {
        min-width: 220px;
    }

    .form-select-custom {
        height: 50px;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        background-color: #FAFBFF;
        color: #718096;
        font-weight: 500;
        padding: 0 1rem;
        cursor: pointer;
    }

    /* Table Design */
    .table-custom thead th {
        background: #F8FAFC;
        color: #718096;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 1.25rem;
        border: none;
    }

    .table-custom tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }

    /* Badges */
    .badge-kat {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-block;
    }
    .kat-outdoor { background-color: #E6FFFA; color: #047481; }
    .kat-elektronik { background-color: #FFFBEB; color: #B45309; }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: white;
    }
    .btn-edit { background-color: #FFB020; }
    .btn-delete { background-color: #F04438; }
</style>
@endpush

@section('content')
<div class="content-wrapper-custom">

    <!-- Header -->
    <div class="header-container">
        <h2 class="header-title">Jenis Inventaris</h2>
        <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Jenis Inventaris
        </button>
    </div>

    <!-- NOTIFIKASI DISAMAKAN DENGAN KATEGORI PAKET -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom-box">
        <!-- Search & Filter -->
        <div class="search-filter-row">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control form-control-custom" placeholder="Cari inventaris Kalisawah...">
            </div>

            <div class="filter-wrapper">
                <select class="form-select form-select-custom" onchange="location = this.value;">
                    <option value="{{ route('admin.jenisInventaris.index') }}" {{ !request('kategori') ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach(['Peralatan Camping', 'Peralatan Rafting', 'Peralatan paintball', 'Peralatan Outbound', 'Peralatan Panahan', 'Peralatan Elektronik', 'Peralatan Pertukangan & Kebersihan'] as $kat)
                        <option value="{{ route('admin.jenisInventaris.index', ['kategori' => $kat]) }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th width="80" class="text-center">No.</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-center" width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $item->nama_barang }}</span></td>
                            <td class="text-center">
                                <span class="badge-kat {{ $item->kategori == 'Peralatan Elektronik' ? 'kat-elektronik' : 'kat-outdoor' }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.jenisInventaris.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDelete('{{ $item->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0 pb-0" style="padding: 2rem;">
                                        <h5 class="modal-title fw-bold">Edit Jenis Inventaris</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.jenisInventaris.update', $item->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body" style="padding: 2rem;">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control form-control-custom" value="{{ $item->nama_barang }}" required style="padding-left: 1.5rem;">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Kategori</label>
                                                <select name="kategori" class="form-select form-select-custom">
                                                    @foreach(['Peralatan Camping', 'Peralatan Rafting', 'Peralatan paintball', 'Peralatan Outbound', 'Peralatan Panahan', 'Peralatan Elektronik', 'Peralatan Pertukangan & Kebersihan'] as $kat)
                                                        <option value="{{ $kat }}" {{ $item->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3" style="border-radius: 12px;">{{ $item->keterangan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0" style="padding: 0 2rem 2rem 2rem;">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                            <button type="submit" class="btn-tambah" style="margin-bottom: 0;">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data inventaris.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0" style="padding: 2rem;">
                <h5 class="modal-title fw-bold">Tambah Jenis Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.jenisInventaris.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control form-control-custom" style="padding-left: 1.5rem;" placeholder="Contoh: Perahu Karet" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select form-select-custom" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Peralatan Camping">Peralatan Camping</option>
                            <option value="Peralatan Rafting">Peralatan Rafting</option>
                            <option value="Peralatan paintball">Peralatan paintball</option>
                            <option value="Peralatan Outbound">Peralatan Outbound</option>
                            <option value="Peralatan Panahan">Peralatan Panahan</option>
                            <option value="Peralatan Elektronik">Peralatan Elektronik</option>
                            <option value="Peralatan Pertukangan & Kebersihan">Peralatan Pertukangan & Kebersihan</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" style="border-radius: 12px;" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding: 0 2rem 2rem 2rem;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn-tambah" style="margin-bottom: 0;">Simpan Inventaris</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi Hapus (Sama persis gayanya dengan Kategori Paket)
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Jenis Inventaris?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
