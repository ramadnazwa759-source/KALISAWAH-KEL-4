@extends('layouts.admin')

@section('title', 'Pengeluaran Operasional')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-1">Daftar Pengeluaran Operasional</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-2"></i> Tambah Pengeluaran
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-2">
                    <label class="small text-muted">Tanggal Awal</label>
                    <input type="date" id="tglAwal" class="form-control" onchange="filterTable()">
                </div>
                <div class="col-md-1 text-center mt-3">s/d</div>
                <div class="col-md-2">
                    <label class="small text-muted">Tanggal Akhir</label>
                    <input type="date" id="tglAkhir" class="form-control" onchange="filterTable()">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Kategori</label>
                    <select id="kategoriFilter" class="form-select" onchange="filterTable()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->nama_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted">Search</label>
                    <input type="text" id="searchFilter" class="form-control" onkeyup="filterTable()" placeholder="Cari keterangan atau kategori...">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">NO</th>
                        <th>KATEGORI</th>
                        <th>KETERANGAN</th>
                        <th>JUMLAH</th>
                        <th>TANGGAL PENGELUARAN</th>
                        <th>DICATAT OLEH</th>
                        <th>BUKTI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach($pengeluaranOperasional as $item)
                    <tr data-tgl="{{ $item->tanggal_pengeluaran }}" data-kat="{{ $item->kategori->nama_kategori ?? 'N/A' }}">
                        <td class="ps-4">{{ $loop->iteration }}</td>
                        <td><span class="badge bg-info-subtle text-info">{{ $item->kategori->nama_kategori ?? 'N/A' }}</span></td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-danger fw-bold">Rp {{ number_format($item->jumlah_uang, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d M Y') }}</td>
                        <td>{{ $item->dicatat_oleh }}</td>
                        <td>
                            @if($item->bukti_pengeluaran)
                                <a href="{{ asset('storage/'.$item->bukti_pengeluaran) }}" target="_blank"><i class="fas fa-file-alt text-secondary"></i></a>
                            @else - @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <form action="{{ route('admin.pengeluaran.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <small class="text-muted">Gunakan filter di atas untuk mencari data spesifik</small>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const tglAwal = document.getElementById('tglAwal').value;
    const tglAkhir = document.getElementById('tglAkhir').value;
    const kategori = document.getElementById('kategoriFilter').value;
    const search = document.getElementById('searchFilter').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {
        const rowTgl = row.getAttribute('data-tgl');
        const rowKat = row.getAttribute('data-kat');
        const rowText = row.innerText.toLowerCase();

        let show = true;
        if (tglAwal && rowTgl < tglAwal) show = false;
        if (tglAkhir && rowTgl > tglAkhir) show = false;
        if (kategori && rowKat !== kategori) show = false;
        if (search && !rowText.includes(search)) show = false;

        row.style.display = show ? '' : 'none';
    });
}
</script>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Uang</label>
                        <input type="number" name="jumlah_uang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_pengeluaran" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Bukti (Foto)</label>
                        <input type="file" name="bukti_pengeluaran" class="form-control" accept="image/*">
                    </div>
                    <input type="hidden" name="dicatat_oleh" value="{{ auth()->user()->name ?? 'Admin' }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
