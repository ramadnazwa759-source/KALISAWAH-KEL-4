@extends('layouts.admin')

@section('title', 'Inventaris Per Unit')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-gray-800 mb-1">Inventaris Per Unit</h2>
            <p class="text-muted small mb-0">Kelola dan lacak aset/barang inventaris secara detail per satuan unit</p>
        </div>
        <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Register Unit Baru
        </button>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert Error Validasi --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Gagal Menyimpan Data:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableInventarisUnit">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3" style="width: 5%">No.</th>
                            <th class="py-3" style="width: 15%">Kode Barang</th>
                            <th class="py-3" style="width: 20%">Nama Barang</th>
                            <th class="py-3" style="width: 15%">Lokasi</th>
                            <th class="py-3" style="width: 15%">Kondisi</th>
                            <th class="py-3" style="width: 15%">Rincian Pembelian</th>
                            <th class="py-3 text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace px-2 py-1.5 fs-7">{{ $item->kode_barang }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $item->jenisInventaris->nama_barang ?? 'Tanpa Nama' }}</span>
                                <small class="text-muted fs-7">{{ $item->jenisInventaris->subkategori->nama_subkategori ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-danger me-2 small"></i>
                                    <span>{{ $item->lokasi->nama_lokasi ?? 'Belum Ditentukan' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($item->kondisi_unit == 'Bagus' || $item->kondisi_unit == 'Baik' || $item->kondisi_unit == 'Baru')
                                    <span class="badge bg-soft-success text-success rounded-pill px-3">Bagus / Baru</span>
                                @elseif($item->kondisi_unit == 'Rusak Ringan')
                                    <span class="badge bg-soft-warning text-warning rounded-pill px-3">Rusak Ringan</span>
                                @else
                                    <span class="badge bg-soft-danger text-danger rounded-pill px-3">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                <small class="d-block text-dark fw-semibold">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</small>
                                <small class="text-muted d-block fs-7">{{ $item->tanggal_beli ? date('d M Y', strtotime($item->tanggal_beli)) : '-' }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-warning btn-sm text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_inventaris_perunit }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm rounded-3" onclick="confirmDeleteUnit('{{ $item->id_inventaris_perunit }}', '{{ $item->kode_barang }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    {{-- AMAN: Menggunakan URL String manual agar terbebas dari validasi strict parameter rute Laravel --}}
                                    <form id="delete-form-{{ $item->id_inventaris_perunit }}" action="{{ url('/admin/inventaris-perunit/' . $item->id_inventaris_perunit) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="modalEdit{{ $item->id_inventaris_perunit }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold">Edit Register Unit [{{ $item->kode_barang }}]</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    {{-- AMAN: Menggunakan URL String manual murni menuju target ID --}}
                                    <form action="{{ url('/admin/inventaris-perunit/' . $item->id_inventaris_perunit) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body px-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Pilih Barang / Jenis</label>
                                                    <select name="id_jenis_inventaris" class="form-select rounded-3" required>
                                                        @foreach($jenisInventaris as $jenis)
                                                            <option value="{{ $jenis->id }}" {{ $item->id_jenis_inventaris == $jenis->id ? 'selected' : '' }}>
                                                                {{ $jenis->nama_barang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Lokasi Penyimpanan</label>
                                                    <select name="id_lokasi" class="form-select rounded-3" required>
                                                        @foreach($lokasi as $lok)
                                                            <option value="{{ $lok->id_lokasi }}" {{ $item->id_lokasi == $lok->id_lokasi ? 'selected' : '' }}>
                                                                {{ $lok->nama_lokasi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Kode Unik Barang</label>
                                                    <input type="text" name="kode_barang" class="form-control rounded-3 font-monospace" value="{{ $item->kode_barang }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Kondisi Unit</label>
                                                    <select name="kondisi_unit" class="form-select rounded-3" required>
                                                        <option value="Baik" {{ $item->kondisi_unit == 'Baik' || $item->kondisi_unit == 'Bagus' ? 'selected' : '' }}>Bagus / Baru</option>
                                                        <option value="Rusak Ringan" {{ $item->kondisi_unit == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                        <option value="Rusak Berat" {{ $item->kondisi_unit == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Tanggal Beli</label>
                                                    <input type="date" name="tanggal_beli" class="form-control rounded-3" value="{{ $item->tanggal_beli ? date('Y-m-d', strtotime($item->tanggal_beli)) : '' }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Harga Beli (Rp)</label>
                                                    <input type="number" step="1" name="harga_beli" class="form-control rounded-3" value="{{ (int)$item->harga_beli }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold small">Sumber Pembelian / Vendor</label>
                                                    <input type="text" name="sumber_pembelian" class="form-control rounded-3" value="{{ $item->sumber_pembelian }}" placeholder="Contoh: PT. Jaya Abadi, Tokopedia, Dana BOS">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pb-4 px-4">
                                            <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 rounded-3">Update Data Unit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada registrasi unit inventaris tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Register Unit Inventaris Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/inventaris-perunit') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Pilih Master Barang</label>
                            <select name="id_jenis_inventaris" class="form-select rounded-3" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($jenisInventaris as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lokasi Penyimpanan Awal</label>
                            <select name="id_lokasi" class="form-select rounded-3" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasi as $lok)
                                    <option value="{{ $lok->id_lokasi }}">{{ $lok->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kode Unik / Serial Number Unit</label>
                            <input type="text" name="kode_barang" class="form-control rounded-3 font-monospace" placeholder="Contoh: INV-LAPTOP-001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kondisi Awal Unit</label>
                            <select name="kondisi_unit" class="form-select rounded-3" required>
                                <option value="Baik">Bagus / Baru</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tanggal Pembelian</label>
                            <input type="date" name="tanggal_beli" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Harga Beli Satuan (Rp)</label>
                            <input type="number" step="1" name="harga_beli" class="form-control rounded-3" placeholder="Contoh: 7500000" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Sumber Pembelian / Toko / Pendanaan</label>
                            <input type="text" name="sumber_pembelian" class="form-control rounded-3" placeholder="Contoh: CV. Computindo Perkasa (E-Katalog 2026)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan Registrasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteUnit(id, kodeBarang) {
        Swal.fire({
            title: 'Hapus Registrasi Unit?',
            text: `Apakah Anda yakin ingin menghapus unit dengan kode "${kodeBarang}" dari sistem?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 border-0 shadow-sm',
                confirmButton: 'btn btn-danger px-4 py-2 rounded-3',
                cancelButton: 'btn btn-light px-4 py-2 rounded-3'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
