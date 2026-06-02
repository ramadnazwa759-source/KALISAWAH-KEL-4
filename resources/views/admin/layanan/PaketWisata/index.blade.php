@extends('layouts.admin')

@section('title', 'Daftar Paket Wisata')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-gray-800">Paket Wisata</h2>
        <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Paket Baru
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" id="searchInput" class="form-control bg-light border-0" placeholder="🔍 Cari nama paket..." onkeyup="filterData()">
                </div>
                <div class="col-md-4">
                    <select id="kategoriFilter" class="form-select bg-light border-0" onchange="filterData()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="paketTable">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Paket</th>
                            <th>Kategori</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-bold text-dark">{{ $item->nama_paket }}</span></td>
                            <td class="kategori-col">{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
                            <td>{{ $item->durasi }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->kapasitas }} Orang</td>
                            <td>
                                <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}"><i class="fas fa-edit"></i></button>

                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.paket-wisata.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <form action="{{ route('admin.paket-wisata.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-0 p-4">
                                            <h5 class="modal-title fw-bold">Edit Paket Wisata</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4 pb-4">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label class="form-label fw-semibold">Nama Paket</label><input type="text" name="nama_paket" class="form-control" value="{{ $item->nama_paket }}" required></div>
                                                <div class="col-md-6"><label class="form-label fw-semibold">Kategori</label>
                                                    <select name="kategori_paket_id" class="form-select" required>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $item->kategori_paket_id == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4"><label class="form-label fw-semibold">Harga (Rp)</label><input type="number" name="harga" class="form-control" value="{{ $item->harga }}" required></div>
                                                <div class="col-md-4"><label class="form-label fw-semibold">Durasi</label><input type="text" name="durasi" class="form-control" value="{{ $item->durasi }}" required></div>
                                                <div class="col-md-4"><label class="form-label fw-semibold">Kapasitas</label><input type="number" name="kapasitas" class="form-control" value="{{ $item->kapasitas }}" required></div>
                                                <div class="col-12"><label class="form-label fw-semibold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3" required>{{ $item->deskripsi }}</textarea></div>
                                                <div class="col-12"><label class="form-label fw-semibold">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif" {{ $item->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Gambar Paket</label>
                                                    @if($item->gambar)
                                                        <div class="mb-2"><img src="{{ asset('storage/' . $item->gambar) }}" alt="gambar" width="100" class="img-thumbnail"></div>
                                                    @endif
                                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4"><button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('admin.paket-wisata.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">Tambah Paket Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Paket</label><input type="text" name="nama_paket" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Kategori</label>
                            <select name="kategori_paket_id" class="form-select" required>
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label fw-semibold">Harga (Rp)</label><input type="number" name="harga" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-semibold">Durasi</label><input type="text" name="durasi" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-semibold">Kapasitas</label><input type="number" name="kapasitas" class="form-control" required></div>
                        <div class="col-12"><label class="form-label fw-semibold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3" required></textarea></div>
                        <div class="col-12"><label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Gambar Paket</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4"><button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary px-4">Simpan Paket</button></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function filterData() {
        let searchText = document.getElementById('searchInput').value.toLowerCase();
        let filterKategori = document.getElementById('kategoriFilter').value.toLowerCase();
        let table = document.getElementById('paketTable');
        let tr = table.getElementsByTagName('tr');
        for (let i = 1; i < tr.length; i++) {
            let tdNama = tr[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            let tdKategori = tr[i].getElementsByTagName('td')[2].textContent.toLowerCase();
            tr[i].style.display = (tdNama.includes(searchText) && (filterKategori === "" || tdKategori === filterKategori)) ? "" : "none";
        }
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Paket?',
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
