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
                            <th>Pembayaran</th>
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
                                <div class="text-success fw-bold">Rp {{ number_format($b->nominal_bayar ?? 0, 0,',','.') }}</div>
                                <div class="text-danger small">Kurang: Rp {{ number_format(max(0, $b->total_harga_final - ($b->nominal_bayar ?? 0)), 0,',','.') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark mb-1">{{ ucfirst($b->status_booking) }}</span><br>
                                <span class="badge bg-danger">{{ ucfirst($b->status_pembayaran) }}</span>
                            </td>
                            <td class="text-center pe-3">
                                <button type="button" class="btn btn-sm btn-info text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalShowBooking{{ $b->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalEditBooking{{ $b->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="{{ url('/admin/pembayaran?booking_id='.$b->id.'&nominal_bayar='.max(0, $b->total_harga_final - ($b->nominal_bayar ?? 0)).'&nama_pemesan='.urlencode($b->nama_pemesan)) }}" class="btn btn-sm btn-success text-white rounded-3">
                                <i class="fas fa-money-bill"></i>
                                 </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH BOOKING --}}
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
                            <div class="col-md-4"><label class="form-label small fw-semibold">Tanggal</label><input type="date" name="tanggal_kunjungan" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Jam</label><input type="time" name="jam" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label small fw-semibold">Jumlah Pengunjung</label><input type="number" name="jumlah_pengunjung" class="form-control" min="1" value="0" oninput="calculateTotal()" required></div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6"><label class="form-label small fw-semibold">Check-Out</label><input type="date" name="tanggal_checkout" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Jumlah Malam</label><input type="number" name="jumlah_malam" class="form-control" min="1" value="1"></div>
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
                                    <select name="fasilitas[0][fasilitas_id]" class="form-select" onchange="calculateTotal()">
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
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3"><div class="step-icon">4</div><h6 class="fw-bold text-primary mb-0">Informasi Pembayaran</h6></div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label small fw-semibold">Metode</label><select name="metode_pembayaran" class="form-select"><option value="cash">Cash</option><option value="transfer">Transfer</option></select></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Tipe</label><select name="tipe_pembayaran" class="form-select"><option value="dp">DP</option><option value="pelunasan">Pelunasan</option></select></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Nominal Bayar</label><input type="number" name="nominal_bayar" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Bukti Pembayaran</label><input type="file" name="bukti_pembayaran" class="form-control" accept="image/*"></div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4"><div class="p-3 text-center rounded-4 border"><small class="text-muted d-block">Kapasitas</small><span id="disp-kapasitas" class="fw-bold fs-5 text-dark">0</span></div></div>
                        <div class="col-md-4"><div class="p-3 text-center rounded-4 border"><small class="text-muted d-block">Tiket Tambahan</small><span id="disp-tiket" class="fw-bold fs-5 text-dark">0</span></div></div>
                        <div class="col-md-4"><div class="p-3 text-center rounded-4 border"><small class="text-muted d-block">Total Estimasi</small><span id="disp-total" class="fw-bold text-primary fs-5">Rp 0</span></div></div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4"><button type="submit" class="btn btn-primary w-100">Simpan Booking</button></div>
            </div>
        </form>
    </div>
</div>

{{-- MODALS SHOW & EDIT (DITAMBAHKAN SESUAI KEBUTUHAN ANDA SEBELUMNYA) --}}
@foreach($data as $b)
<div class="modal fade" id="modalShowBooking{{ $b->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg p-4">
            <div class="modal-header border-0 pb-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="background:#EFF6FF; color:#2563EB; width: 45px; height: 45px; display:flex; align-items:center; justify-content:center; border-radius:12px;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Detail Booking</h5>
                        <p class="text-muted mb-0 small">{{ $b->kode_booking }}</p>
                    </div>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <span class="badge bg-success-subtle text-success badge-status">{{ ucfirst($b->status_booking) }}</span>
                    <span class="badge bg-danger-subtle text-danger badge-status">{{ strtoupper($b->status_pembayaran) }}</span>
                </div>
            </div>
            <div class="modal-body py-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card-detail">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pemesan</h6>
                            <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Nama Pemesan</span><span class="fw-bold">{{ $b->nama_pemesan }}</span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="text-muted small">No HP</span><span class="fw-bold">{{ $b->no_hp }}</span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Tanggal Kunjungan</span><span class="fw-bold">{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->format('d M Y') }}</span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Jam Kunjungan</span><span class="fw-bold">{{ $b->jam }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-muted small">Jumlah Orang</span><span class="fw-bold">{{ $b->jumlah_pengunjung }}</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-detail">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-box me-2"></i>Paket Wisata</h6>
                            @foreach(($b->bookingItem ?? []) as $dp)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">{{ $dp->paketWisata->nama_paket ?? '-' }} (x{{ $dp->qty }})</span>
                                <span class="fw-bold">Rp {{ number_format($dp->subtotal ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-detail">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-plus-circle me-2"></i>Fasilitas Tambahan</h6>
                            @forelse(($b->bookingFasilitas ?? []) as $df)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">{{ $df->fasilitas->nama_fasilitas ?? '-' }} (x{{ $df->qty }})</span>
                                <span class="fw-bold">Rp {{ number_format($df->subtotal ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @empty
                            <span class="text-muted small">-</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-detail">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-wallet me-2"></i>Ringkasan Biaya</h6>
                            <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Total Harga (Sebelum Diskon)</span><span class="fw-bold">Rp {{ number_format($b->total_harga_final + ($b->diskon_manual ?? 0), 0, ',', '.') }}</span></div>
                            <div class="d-flex justify-content-between mb-2 text-danger"><span class="small">Diskon Manual</span><span class="fw-bold">- Rp {{ number_format($b->diskon_manual ?? 0, 0, ',', '.') }}</span></div>
                            <hr class="my-2 border-dashed">
                            <div class="d-flex justify-content-between"><span class="text-muted small">Total Harga (Setelah Diskon)</span><span class="fw-bold text-primary">Rp {{ number_format($b->total_harga_final, 0, ',', '.') }}</span></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-detail d-flex align-items-center">
                            <div class="me-4"><i class="fas fa-credit-card text-primary fs-4"></i></div>
                            <div class="flex-grow-1">
                                <div class="text-muted small">Metode Bayar</div>
                                <div class="fw-bold">{{ ucfirst($b->metode_pembayaran) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-3"><button type="button" class="btn btn-light w-100 rounded-3 py-2" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBooking{{ $b->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('/admin/booking-admin/'.$b->id) }}" method="POST" class="w-100">
            @csrf @method('PUT')
            <div class="modal-content shadow-lg">
                <div class="modal-header border-bottom px-4 py-3">
                    <h5 class="fw-bold mb-0">Edit Booking: {{ $b->kode_booking }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="mb-3"><label class="small text-muted d-block">Nama Pemesan</label><div class="fw-bold text-dark">{{ $b->nama_pemesan }}</div></div>
                    <div class="mb-3"><label class="small text-muted d-block">Total Harga</label><div class="fw-bold text-success">Rp {{ number_format($b->total_harga_final,0,',','.') }}</div></div>
                    <hr>
                    <div class="mb-3"><label class="form-label small fw-semibold">Diskon Manual</label><input type="number" name="diskon_manual" class="form-control" value="{{ $b->diskon_manual }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Tanggal Reschedule</label><input type="date" name="tanggal_reschedule" class="form-control" value="{{ $b->tanggal_reschedule }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Alasan Reschedule</label><input type="text" name="alasan_reschedule" class="form-control" value="{{ $b->alasan_reschedule }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Jumlah Reschedule</label><input type="number" name="jumlah_reschedule" class="form-control" value="{{ $b->jumlah_reschedule }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Check-Out</label><input type="date" name="tanggal_checkout" class="form-control" value="{{ $b->tanggal_selesai }}"></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Jumlah Malam</label><input type="number" name="jumlah_malam" class="form-control" min="1" value="{{ $b->jumlah_malam ?? 1 }}"></div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4"><button type="submit" class="btn btn-warning w-100 text-white">Update Data</button></div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    let pIdx = 1; let fIdx = 1;
    function addPaket() {
        let html = `<div class="row g-2 mb-2"><div class="col-8"><select name="paket[${pIdx}][paket_wisata_id]" class="form-select" onchange="calculateTotal()"><option value="">-- Pilih Paket --</option>@foreach(\App\Models\PaketWisata::all() as $p)<option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-kapasitas="{{ $p->kapasitas }}">{{ $p->nama_paket }} (Rp {{ number_format($p->harga, 0, ',', '.') }} | Kap: {{ $p->kapasitas }})</option>@endforeach</select></div><div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="paket[${pIdx}][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div></div>`;
        document.getElementById('paket-container').insertAdjacentHTML('beforeend', html); pIdx++;
    }
    function addFasilitas() {
        let html = `<div class="row g-2 mb-2"><div class="col-8"><select name="fasilitas[${fIdx}][fasilitas_id]" class="form-select" onchange="calculateTotal()"><option value="">-- Pilih Fasilitas --</option>@foreach(\App\Models\Fasilitas::all() as $f)<option value="{{ $f->id }}" data-harga="{{ $f->harga }}">{{ $f->nama_fasilitas }} (Rp {{ number_format($f->harga, 0, ',', '.') }})</option>@endforeach</select></div><div class="col-4"><div class="input-group-qty"><button type="button" onclick="changeQty(this, -1, true)">-</button><input type="number" name="fasilitas[${fIdx}][qty]" class="form-control" value="1" min="1" oninput="calculateTotal()"><button type="button" onclick="changeQty(this, 1)">+</button></div></div></div>`;
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
        let pengunjung = parseInt(document.querySelector('input[name="jumlah_pengunjung"]').value) || 0;
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
            if(sel.value) { total += (parseInt(sel.options[sel.selectedIndex].getAttribute('data-harga')) * qty); }
        });
        let selisih = Math.max(0, pengunjung - totalKapasitas);
        total += (selisih * 25000);
        document.getElementById('disp-kapasitas').innerText = totalKapasitas;
        document.getElementById('disp-tiket').innerText = selisih;
        document.getElementById('disp-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    $(document).ready(function() {
        $('#bookingTable').DataTable({
            "ordering": false
        });
    });
</script>
@endsection
