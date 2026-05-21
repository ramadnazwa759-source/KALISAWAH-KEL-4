@extends('layouts.admin')

@section('title', 'Daftar Fasilitas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Daftar Fasilitas</h2>
            <p class="text-muted mb-0">Kelola item fasilitas tambahan, harga sewa, dan kuantitas stok</p>
        </div>
        <button class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Fasilitas
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3" style="width: 5%">No.</th>
                            <th class="py-3" style="width: 10%">Gambar</th>
                            <th class="py-3" style="width: 25%">Nama Fasilitas</th>
                            <th class="py-3" style="width: 15%">Kategori</th>
                            <th class="py-3" style="width: 10%">Tipe</th>
                            <th class="py-3" style="width: 15%">Harga</th>
                            <th class="py-3" style="width: 8%">Stok</th>
                            <th class="py-3" style="width: 10%">Status</th>
                            <th class="py-3 text-center" style="width: 12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px;">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <i class="fas fa-box text-muted"></i>
                                    @endif
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ $item->nama_fasilitas }}</span></td>
                            <td>
                                <span class="badge bg-light text-secondary border px-2 py-1 rounded-2">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge px-2 py-1 rounded-2
                                    {{ $item->tipe_fasilitas == 'sewa' ? 'bg-info text-white' : ($item->tipe_fasilitas == 'paket' ? 'bg-primary text-white' : 'bg-secondary text-white') }}">
                                    {{ ucfirst($item->tipe_fasilitas) }}
                                </span>
                            </td>
                            <td>{{ $item->harga ? 'Rp ' . number_format($item->harga, 0, ',', '.') : '-' }}</td>
                            <td>{{ $item->stok ?? '-' }}</td>
                            <td>
                                <span class="badge px-2 py-1 rounded-2 {{ $item->status == 'aktif' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning btn-sm text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm rounded-3" onclick="confirmDelete('{{ $item->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold">Edit Fasilitas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.fasilitas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body px-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nama Fasilitas</label>
                                                    <input type="text" name="nama_fasilitas" class="form-control rounded-3" value="{{ $item->nama_fasilitas }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Kategori Fasilitas</label>
                                                    <select name="kategori_fasilitas_id" class="form-select rounded-3">
                                                        <option value="">-- Tanpa Kategori --</option>
                                                        @foreach(\App\Models\KategoriFasilitas::all() as $kat)
                                                            <option value="{{ $kat->id }}" {{ $item->kategori_fasilitas_id == $kat->id ? 'selected' : '' }}>
                                                                {{ $kat->nama_kategori }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Tipe Fasilitas</label>
                                                    <select name="tipe_fasilitas" class="form-select rounded-3" required>
                                                        <option value="informasi" {{ $item->tipe_fasilitas == 'informasi' ? 'selected' : '' }}>Informasi</option>
                                                        <option value="paket" {{ $item->tipe_fasilitas == 'paket' ? 'selected' : '' }}>Paket</option>
                                                        <option value="sewa" {{ $item->tipe_fasilitas == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Harga</label>
                                                    <input type="number" name="harga" class="form-control rounded-3" value="{{ $item->harga }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Stok</label>
                                                    <input type="number" name="stok" class="form-control rounded-3" value="{{ $item->stok }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control rounded-3" rows="3">{{ $item->deskripsi }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <select name="status" class="form-select rounded-3" required>
                                                        <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="nonaktif" {{ $item->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Ubah Gambar</label>
                                                    <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada item fasilitas yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Tambah Fasilitas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Fasilitas</label>
                            <input type="text" name="nama_fasilitas" class="form-control rounded-3" placeholder="Contoh: Sewa Tenda Dome" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori Fasilitas</label>
                            <select name="kategori_fasilitas_id" class="form-select rounded-3">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(\App\Models\KategoriFasilitas::all() as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tipe Fasilitas</label>
                            <select name="tipe_fasilitas" class="form-select rounded-3" required>
                                <option value="sewa">Sewa</option>
                                <option value="paket">Paket</option>
                                <option value="informasi">Informasi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Harga</label>
                            <input type="number" name="harga" class="form-control rounded-3" placeholder="Kosongkan jika gratis">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control rounded-3" placeholder="Jumlah kuantitas">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control rounded-3" rows="3" placeholder="Deskripsi spesifikasi fasilitas..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select rounded-3" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gambar/Foto Fasilitas</label>
                            <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan Fasilitas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Fasilitas?',
            text: "Item yang sudah terikat dengan paket wisata mungkin akan terpengaruh!",
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
