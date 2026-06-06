@extends('layouts.admin')

@section('title', 'Data Pengeluaran')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Pengeluaran</h2>
            <p class="text-muted mb-0">Kelola catatan biaya operasional harian</p>
        </div>
        <button class="btn btn-primary px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Pengeluaran
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Bukti</th> {{-- Kolom Baru --}}
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>Rp {{ number_format($item->jumlah_uang, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d M Y') }}</td>
                            <td>
                                @if($item->bukti_pengeluaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pengeluaran) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-image"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.pengeluaran.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            {{-- ... isi modal edit tetap sama ... --}}
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('admin.pengeluaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pengeluaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            {{-- Field input sama seperti sebelumnya --}}
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select name="id_kategori" class="form-select" required>
                                                    @foreach($kategori as $k)
                                                        <option value="{{ $k->id }}" {{ $item->id_kategori == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control" value="{{ $item->keterangan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah Uang</label>
                                                <input type="number" name="jumlah_uang" class="form-control" value="{{ $item->jumlah_uang }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" name="tanggal_pengeluaran" class="form-control" value="{{ $item->tanggal_pengeluaran }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Dicatat Oleh</label>
                                                <input type="text" name="dicatat_oleh" class="form-control" value="{{ $item->dicatat_oleh }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bukti Baru (Opsional)</label>
                                                @if($item->bukti_pengeluaran)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $item->bukti_pengeluaran) }}" class="img-thumbnail" width="100">
                                                    </div>
                                                @endif
                                                <input type="file" name="bukti_pengeluaran" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengeluaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah tetap sama --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
