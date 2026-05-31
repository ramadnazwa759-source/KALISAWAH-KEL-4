@extends('layouts.admin')

@section('content')
<style>
    .modal-content { background: #fff; border-radius: 24px; border: none; }
    .form-control, .form-select { border: 1px solid #E5E7EB; padding: 10px 14px; border-radius: 12px; }
    .step-icon { width: 30px; height: 30px; border-radius: 50%; background: #2563EB; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; flex-shrink: 0; }
    .input-group-qty { display: flex; border: 1px solid #E5E7EB; border-radius: 12px; overflow: hidden; height: 48px; }
    .input-group-qty button { border: none; background: #F9FAFB; padding: 0 16px; color: #6B7280; font-weight: bold; transition: 0.3s; }
    .input-group-qty button:hover { background: #E5E7EB; }
    .input-group-qty input { border: none; text-align: center; width: 100%; font-weight: 600; }
    .table-wrap { overflow: auto; border-radius: 16px; }
    .table thead th { background-color: #f8fafc; padding: 18px 16px !important; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
    .table tbody td { padding: 18px 16px !important; white-space: nowrap; vertical-align: middle; }
    .card { border-radius: 16px !important; }
    table.dataTable.no-footer { border-bottom: none !important; }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { padding: 1rem; }
    .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { padding: 1rem; }
    .card-detail { border: 1px solid #E5E7EB; border-radius: 16px; padding: 16px; height: 100%; }
    .badge-status { font-size: 0.85em; padding: 6px 12px; border-radius: 8px; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 class="fw-bold text-dark mb-1">Daftar Booking Wisata</h2></div>
        <button type="button" class="btn btn-primary px-4 py-2 rounded-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBooking">
            <i class="fas fa-plus me-2"></i> Tambah Booking
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-wrap">
                <table class="table table-hover align-middle" id="bookingTable">
                    <thead class="text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Kunjungan</th>
                            <th>Orang</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $b)
                        <tr>
                            <td class="ps-3">{{ $key + 1 }}</td>
                            <td><span class="badge bg-primary px-3 py-2 rounded-3">{{ $b->kode_booking }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $b->nama_pemesan }}</div>
                                <small class="text-muted">{{ $b->no_hp }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->format('d M Y') }}</div>
                                <small class="text-muted">{{ $b->jam }}</small>
                            </td>
                            <td>{{ $b->jumlah_pengunjung }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($b->total_harga_final,0,',','.') }}</td>
                            <td>
                                <span class="badge bg-warning text-dark mb-1">{{ ucfirst($b->status_booking) }}</span><br>
                                <span class="badge bg-danger">{{ ucfirst($b->status_pembayaran) }}</span>
                            </td>
                            <td class="text-center pe-3">
                                <button type="button" class="btn btn-sm btn-info text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalShowBooking{{ $b->id }}"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-warning text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalEditBooking{{ $b->id }}"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahBooking" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ url('/admin/booking-admin') }}" method="POST" class="w-100" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg">
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="fw-bold mb-0">Tambah Booking Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3"><div class="step-icon">1</div><h6 class="fw-bold text-primary mb-0">Data Pemesan</h6></div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label small fw-semibold">Nama Pemesan</label><input type="text" name="nama_pemesan" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">No HP</label><input type="text" name="no_hp" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Tanggal Kunjungan</label><input type="date" name="tanggal_kunjungan" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Tanggal Selesai</label><input type="date" name="tanggal_selesai" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Jam</label><input type="time" name="jam" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Jumlah Pengunjung</label><input type="number" name="jumlah_pengunjung" class="form-control" min="1" value="0" oninput="calculateTotal()" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Catatan</label><input type="text" name="catatan" class="form-control"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2"><div class="step-icon">2</div><h6 class="fw-bold text-primary mb-0">Paket Wisata</h6></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPaket()">+ Tambah Paket</button>
                        </div>
                        <div id="paket-container">
                            <div class="row g-2 mb-2">
                                <div class="col-8">
                                    <select name="paket[0][paket_wisata_id]" class="form-select" onchange="calculateTotal()">
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach(\App\Models\PaketWisata::all() as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-kapasitas="{{ $p->kapasitas }}">{{ $p->nama_paket }} (Rp {{ number_format($p->harga, 0, ',', '.') }} | Kap: {{ $p->kapasitas }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="paket[0][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2"><div class="step-icon">3</div><h6 class="fw-bold text-primary mb-0">Fasilitas Tambahan</h6></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFasilitas()">+ Tambah Fasilitas</button>
                        </div>
                        <div id="fasilitas-container">
                            <div class="row g-2 mb-2">
                                <div class="col-8">
                                    <select name="fasilitas[0][id]" class="form-select" onchange="calculateTotal()">
                                        <option value="">-- Pilih Fasilitas --</option>
                                        @foreach(\App\Models\Fasilitas::all() as $f)
                                            <option value="{{ $f->id }}" data-harga="{{ $f->harga }}">{{ $f->nama_fasilitas }} (Rp {{ number_format($f->harga, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="fasilitas[0][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6"><div class="p-3 text-center rounded-4 border"><small class="text-muted d-block">Kapasitas</small><span id="disp-kapasitas" class="fw-bold fs-5 text-dark">0</span></div></div>
                        <div class="col-md-6"><div class="p-3 text-center rounded-4 border"><small class="text-muted d-block">Total Estimasi</small><span id="disp-total" class="fw-bold text-primary fs-5">Rp 0</span></div></div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4"><button type="submit" class="btn btn-primary w-100">Simpan Booking</button></div>
            </div>
        </form>
    </div>
</div>

@foreach($data as $b)
<div class="modal fade" id="modalShowBooking{{ $b->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg p-4">
            <div class="modal-header border-0 pb-3">
                <h5 class="fw-bold">Detail {{ $b->kode_booking }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card-detail">
                            <p class="mb-1 text-muted small">Pemesan</p>
                            <h6 class="fw-bold">{{ $b->nama_pemesan }} ({{ $b->no_hp }})</h6>
                            <p class="mb-1 text-muted small mt-3">Kunjungan</p>
                            <h6 class="fw-bold">{{ $b->tanggal_kunjungan }} - {{ $b->tanggal_selesai }}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-detail">
                            <p class="mb-1 text-muted small">Total Harga Final</p>
                            <h4 class="fw-bold text-primary">Rp {{ number_format($b->total_harga_final, 0, ',', '.') }}</h4>
                            <p class="mb-1 text-muted small mt-3">Status</p>
                            <span class="badge bg-warning text-dark">{{ $b->status_booking }}</span>
                            <span class="badge bg-success">{{ $b->status_pembayaran }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBooking{{ $b->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('/admin/booking-admin/'.$b->id) }}" method="POST" class="w-100">
            @csrf @method('PUT')
            <div class="modal-content shadow-lg">
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="fw-bold mb-0">Edit: {{ $b->kode_booking }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="mb-3"><label class="form-label small fw-semibold">Diskon Manual</label><input type="number" name="diskon_manual" class="form-control" value="{{ $b->diskon_manual }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Tanggal Reschedule</label><input type="date" name="tanggal_reschedule" class="form-control" value="{{ $b->tanggal_reschedule }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Alasan Reschedule</label><input type="text" name="alasan_reschedule" class="form-control" value="{{ $b->alasan_reschedule }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Status Booking</label>
                        <select name="status_booking" class="form-select">
                            <option value="pending" {{ $b->status_booking == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $b->status_booking == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $b->status_booking == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4"><button type="submit" class="btn btn-warning w-100 text-white">Update Data</button></div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    let pIdx = 1;
    let fIdx = 1;

    function addPaket() {
        let html = `<div class="row g-2 mb-2"><div class="col-8"><select name="paket[${pIdx}][paket_wisata_id]" class="form-select" onchange="calculateTotal()"><option value="">-- Pilih Paket --</option>@foreach(\App\Models\PaketWisata::all() as $p)<option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-kapasitas="{{ $p->kapasitas }}">{{ $p->nama_paket }} (Rp {{ number_format($p->harga, 0, ',', '.') }})</option>@endforeach</select></div><div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="paket[${pIdx}][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div></div>`;
        document.getElementById('paket-container').insertAdjacentHTML('beforeend', html); pIdx++;
    }

    function addFasilitas() {
        let html = `<div class="row g-2 mb-2"><div class="col-8"><select name="fasilitas[${fIdx}][id]" class="form-select" onchange="calculateTotal()"><option value="">-- Pilih Fasilitas --</option>@foreach(\App\Models\Fasilitas::all() as $f)<option value="{{ $f->id }}" data-harga="{{ $f->harga }}">{{ $f->nama_fasilitas }} (Rp {{ number_format($f->harga, 0, ',', '.') }})</option>@endforeach</select></div><div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="fasilitas[${fIdx}][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div></div>`;
        document.getElementById('fasilitas-container').insertAdjacentHTML('beforeend', html); fIdx++;
    }

    function changeQty(btn, val, allowDelete = false) {
        let input = btn.parentElement.querySelector('input');
        let newVal = parseInt(input.value) + val;
        if (newVal < 1) { if (allowDelete) btn.closest('.row').remove(); else input.value = 1; }
        else { input.value = newVal; }
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0; let totalKapasitas = 0;
        document.querySelectorAll('#paket-container .row').forEach(row => {
            let sel = row.querySelector('select'); let qty = parseInt(row.querySelector('input').value) || 0;
            if(sel.value) {
                let opt = sel.options[sel.selectedIndex];
                total += (parseInt(opt.getAttribute('data-harga')) * qty);
                totalKapasitas += (parseInt(opt.getAttribute('data-kapasitas')) * qty);
            }
        });
        document.querySelectorAll('#fasilitas-container .row').forEach(row => {
            let sel = row.querySelector('select'); let qty = parseInt(row.querySelector('input').value) || 0;
            if(sel.value) {
                let opt = sel.options[sel.selectedIndex];
                total += (parseInt(opt.getAttribute('data-harga')) * qty);
            }
        });
        document.getElementById('disp-kapasitas').innerText = totalKapasitas;
        document.getElementById('disp-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    $(document).ready(function() { $('#bookingTable').DataTable({"ordering": false}); });
</script>
@endsection
