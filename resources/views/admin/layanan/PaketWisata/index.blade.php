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
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama_paket }}')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function filterData() {
        let searchText = document.getElementById('searchInput').value.toLowerCase();
        let filterKategori = document.getElementById('kategoriFilter').value.toLowerCase();
        let table = document.getElementById('paketTable');
        let tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let tdNama = tr[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            let tdKategori = tr[i].getElementsByTagName('td')[2].textContent.toLowerCase();

            if (tdNama.includes(searchText) && (filterKategori === "" || tdKategori === filterKategori)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>
@endpush
