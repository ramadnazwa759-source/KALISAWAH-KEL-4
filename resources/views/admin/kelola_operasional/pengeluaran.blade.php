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

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Gagal Temukan Data --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Summary Box Rangkuman Error Validasi Form --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <div class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Validasi Gagal! Periksa kembali inputan Anda:</div>
            <ul class="mb-0 mt-2 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <th>Bukti</th>
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

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('admin.pengeluaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pengeluaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Kategori</label>
                                                <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                                    @foreach($kategori as $k)
                                                        <option value="{{ $k->id }}" {{ old('id_kategori', $item->id_kategori) == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $item->keterangan) }}" required>
                                                @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jumlah Uang (Rp)</label>
                                                <input type="number" name="jumlah_uang" class="form-control @error('jumlah_uang') is-invalid @enderror" value="{{ old('jumlah_uang', $item->jumlah_uang) }}" required>
                                                @error('jumlah_uang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tanggal</label>
                                                <input type="date" name="tanggal_pengeluaran" class="form-control @error('tanggal_pengeluaran') is-invalid @enderror" value="{{ old('tanggal_pengeluaran', $item->tanggal_pengeluaran) }}" required>
                                                @error('tanggal_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Dicatat Oleh</label>
                                                <input type="text" name="dicatat_oleh" class="form-control @error('dicatat_oleh') is-invalid @enderror" value="{{ old('dicatat_oleh', $item->dicatat_oleh) }}" required>
                                                @error('dicatat_oleh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Bukti Baru (Opsional)</label>
                                                @if($item->bukti_pengeluaran)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $item->bukti_pengeluaran) }}" class="img-thumbnail" width="100">
                                                    </div>
                                                @endif
                                                <input type="file" name="bukti_pengeluaran" class="form-control @error('bukti_pengeluaran') is-invalid @enderror" accept="image/*">
                                                <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                                                @error('bukti_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahLabel">Tambah Pengeluaran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                            <option value="" disabled {{ old('id_kategori') == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Contoh: Pembelian ATK Kantor" value="{{ old('keterangan') }}" required>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Uang (Rp)</label>
                        <input type="number" name="jumlah_uang" class="form-control @error('jumlah_uang') is-invalid @enderror" placeholder="Contoh: 150000" min="1" value="{{ old('jumlah_uang') }}" required>
                        @error('jumlah_uang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal_pengeluaran" class="form-control @error('tanggal_pengeluaran') is-invalid @enderror" value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}" required>
                        @error('tanggal_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dicatat Oleh</label>
                        <input type="text" name="dicatat_oleh" class="form-control @error('dicatat_oleh') is-invalid @enderror" placeholder="Nama Admin" value="{{ old('dicatat_oleh') }}" required>
                        @error('dicatat_oleh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bukti Pengeluaran (Opsional)</label>
                        <input type="file" name="bukti_pengeluaran" class="form-control @error('bukti_pengeluaran') is-invalid @enderror" accept="image/*">
                        <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                        @error('bukti_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Membuka kembali modal yang bermasalah secara otomatis setelah reload halaman
    document.addEventListener("DOMContentLoaded", function () {
        @if($errors->any())
            @if(session('last_action') === 'store')
                var modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
                modalTambah.show();
            @elseif(session('last_action') === 'update' && session('action_id'))
                var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit' + '{{ session("action_id") }}'));
                modalEdit.show();
            @endif
        @endif
    });

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
