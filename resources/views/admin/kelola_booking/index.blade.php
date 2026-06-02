@extends('layouts.admin')

@section('content')
<style>
    /* CSS UTAMA SESUAI MOCKUP */
    .modal-content {
        background: #f1f5f9;
        border-radius: 1.5rem;
        border: none;
    }
    .modal-header {
        background: white;
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 1.5rem 1.5rem 0 0;
    }
    .modal-body { padding: 2rem; }

    /* SEKSI KARTU */
    .form-section {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center; gap: 8px;
    }

    .payment-section { background: #fff7ed; border: 1px solid #fed7aa; }
    .payment-section .section-title { color: #9a3412; }

    /* INPUT STYLE */
    .form-label { font-weight: 600; color: #64748b; font-size: 0.8rem; margin-bottom: 0.4rem; }
    .form-control, .form-select {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* QTY PICKER */
    .input-group-qty-modern {
        display: flex; align-items: center; background: #f8fafc;
        border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 2px; width: fit-content;
    }
    .btn-qty {
        width: 32px; height: 32px; border-radius: 0.5rem; background: white;
        border: 1px solid #e2e8f0; font-weight: bold; display: flex;
        align-items: center; justify-content: center; cursor: pointer;
    }
    .qty-input-modern { border: none !important; background: transparent !important; text-align: center; font-weight: 700; width: 40px; }

    /* TABS HARI */
    .day-tabs { display: flex; gap: 8px; margin-bottom: 1rem; flex-wrap: wrap; }
    .day-tab {
        padding: 8px 16px; background: #f1f5f9; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600; color: #64748b; cursor: pointer; border: 1px solid #e2e8f0;
    }
    .day-tab.active { background: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
    .itinerary-panel { display: none; }
    .itinerary-panel.active { display: block; }

    /* STYLE KARTU PAKET DI MODAL */
    .category-label {
        font-size: 0.75rem; font-weight: 800; color: #2563eb;
        text-transform: uppercase; letter-spacing: 1px; margin-top: 1.5rem; margin-bottom: 0.75rem;
    }
    .package-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 1rem;
        padding: 1.25rem; cursor: pointer; transition: 0.2s; height: 100%;
    }
    .package-card:hover { border-color: #2563eb; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .package-name { font-weight: 800; font-size: 1.1rem; color: #1e293b; margin-bottom: 10px; }
    .package-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .info-label-sm { font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; }
    .info-value-sm { font-size: 0.85rem; color: #1e293b; font-weight: 700; }

    /* SELEKSI PAKET DI FORM */
    .selected-package-box {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem;
        padding: 0.75rem 1rem; display: flex; justify-content: space-between; align-items: center;
    }

    /* SUMMARY CARDS */
    .summary-card { padding: 1.5rem; border-radius: 1rem; height: 100%; }
    .card-blue { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
    .card-green { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .btn-save {
        background: #2563eb; color: white; font-weight: 700; padding: 1rem;
        border-radius: 1rem; width: 100%; border: none; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }
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
                            <td><div class="fw-bold">{{ $b->nama_pemesan }}</div><small class="text-muted">{{ $b->no_hp }}</small></td>
                            <td><div class="fw-bold">{{ date('d M Y', strtotime($b->tanggal_kunjungan)) }}</div></td>
                            <td>{{ $b->jumlah_pengunjung }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($b->total_harga_final,0,',','.') }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $b->status_booking }}</span></td>
                            <td class="text-center pe-3">
                                <button type="button" class="btn btn-sm btn-info text-white rounded-3" data-bs-toggle="modal" data-bs-target="#modalShowBooking{{ $b->id }}"><i class="fas fa-eye"></i></button>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form action="{{ url('/admin/booking-admin') }}" method="POST" class="w-100" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="fw-bold mb-0">Reservasi Baru (Mode Admin)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-section">
                                <div class="section-title"><i class="fas fa-user-circle"></i> Data Pemesan</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama_pemesan" class="form-control" placeholder="Nama pemesan" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor WhatsApp</label>
                                        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Check-In</label>
                                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control" required onchange="renderItinerary()">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Check-Out</label>
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required onchange="renderItinerary()">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jam Check-In</label>
                                        <input type="time" name="jam" class="form-control" value="14:00" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jumlah Orang</label>
                                        <div class="input-group-qty-modern">
                                            <button type="button" class="btn-qty" onclick="changeQtyValue('jml_pengunjung', -1)">-</button>
                                            <input type="number" name="jumlah_pengunjung" id="jml_pengunjung" class="qty-input-modern" value="1" min="1" onchange="calculateTotal()">
                                            <button type="button" class="btn-qty" onclick="changeQtyValue('jml_pengunjung', 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Catatan (Optional)</label>
                                        <input type="text" name="catatan" class="form-control" placeholder="Tulis catatan jika ada">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                        <i class="fas fa-moon me-1"></i> Jumlah Malam: <span id="label_jml_malam">1</span>
                                    </span>
                                    <input type="hidden" name="jumlah_malam" id="jml_malam" value="1">
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-title"><i class="fas fa-map-marked-alt"></i> Paket Wisata (Per Hari)</div>
                                <div id="day-tabs-container" class="day-tabs"></div>
                                <div id="itinerary-panels-container"></div>
                            </div>

                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="section-title mb-0"><i class="fas fa-box-open"></i> Fasilitas Tambahan (Per Malam)</div>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-3" onclick="addFasilitas()">+ Tambah Fasilitas</button>
                                </div>
                                <div id="fasilitas-container"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-section payment-section">
                                <div class="section-title"><i class="fas fa-money-check-alt"></i> Data Pembayaran (Admin Only)</div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe Pembayaran</label>
                                    <select name="pembayaran[tipe_pembayaran]" class="form-select">
                                        <option value="dp">DP (Down Payment)</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Metode</label>
                                    <select name="pembayaran[metode_pembayaran]" class="form-select">
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cash">Cash / Tunai</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nominal Bayar</label>
                                    <input type="number" name="pembayaran[nominal]" class="form-control" placeholder="0">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Upload Bukti</label>
                                    <input type="file" name="pembayaran[bukti_pembayaran]" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="summary-card card-blue">
                                        <small class="d-block mb-1 fw-bold"><i class="fas fa-users"></i> Rata-rata Kapasitas /Malam</small>
                                        <span id="disp-kapasitas" class="fs-3 fw-bold">0</span> <small>Orang</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="summary-card card-green">
                                        <small class="d-block mb-1 fw-bold"><i class="fas fa-calculator"></i> Total Estimasi</small>
                                        <span id="disp-total" class="fs-2 fw-bold">Rp 0</span>
                                        <p class="small mb-0 mt-2 text-success">*Otomatis menghitung semua biaya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-white p-4">
                    <button type="submit" class="btn-save shadow-lg">Konfirmasi & Simpan Booking</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PILIH PAKET (VISUAL) --}}
<div class="modal fade" id="modalVisualPaket" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-2xl border-0" style="border-radius: 2rem;">
            <div class="modal-header border-0 px-4 pt-4">
                <h4 class="fw-800 text-dark mb-0">Pilih Paket</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-5 pt-2" style="max-height: 70vh; overflow-y: auto;">
                @foreach(\App\Models\PaketWisata::all()->groupBy('kategori') as $kategori => $pakets)
                    <div class="category-label">{{ $kategori ?: 'Lainnya' }}</div>
                    <div class="row g-3">
                        @foreach($pakets as $p)
                            <div class="col-md-6">
                                <div class="package-card" onclick="selectPackageFromModal({{ $p->id }}, '{{ $p->nama_paket }}', {{ $p->harga }}, {{ $p->kapasitas }})">
                                    <div class="package-name">{{ $p->nama_paket }}</div>
                                    <div class="package-info-grid">
                                        <div>
                                            <div class="info-label-sm">Harga</div>
                                            <div class="info-value-sm text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                        </div>
                                        <div>
                                            <div class="info-label-sm">Kapasitas</div>
                                            <div class="info-value-sm">{{ $p->kapasitas }} Orang</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let fIdx = 1;
    let targetDayIdx = 0;
    let targetRowIdx = 0;

    $(document).ready(function() {
        $('#bookingTable').DataTable({"ordering": false});
        renderItinerary();
    });

    function renderItinerary() {
        const ci = document.getElementById('tanggal_kunjungan').value;
        const co = document.getElementById('tanggal_selesai').value;
        if (!ci || !co) return;

        const d1 = new Date(ci);
        const d2 = new Date(co);
        const totalMalam = Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)) || 1;

        document.getElementById('jml_malam').value = totalMalam;
        document.getElementById('label_jml_malam').innerText = totalMalam;

        const tabs = document.getElementById('day-tabs-container');
        const panels = document.getElementById('itinerary-panels-container');
        tabs.innerHTML = ''; panels.innerHTML = '';

        for (let i = 0; i < totalMalam; i++) {
            let cur = new Date(d1); cur.setDate(d1.getDate() + i);
            let dateStr = cur.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });

            tabs.insertAdjacentHTML('beforeend', `<div class="day-tab ${i===0?'active':''}" id="tab-${i}" onclick="switchTab(${i})">HARI ${i+1} (${dateStr})</div>`);
            panels.insertAdjacentHTML('beforeend', `
                <div class="itinerary-panel ${i===0?'active':''}" id="panel-${i}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold">Daftar Paket Malam ke-${i+1}</small>
                        <button type="button" class="btn btn-xs btn-link text-decoration-none p-0 fw-bold" onclick="triggerVisualPaket(${i}, 0, true)">+ Pilih Paket</button>
                    </div>
                    <div id="paket-container-${i}">
                        </div>
                </div>
            `);
        }
        calculateTotal();
    }

    function switchTab(idx) {
        document.querySelectorAll('.day-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.itinerary-panel').forEach(p => p.classList.remove('active'));
        document.getElementById(`tab-${idx}`).classList.add('active');
        document.getElementById(`panel-${idx}`).classList.add('active');
    }

    // Fungsi untuk membuka modal pemilihan paket
    function triggerVisualPaket(dayIdx, rowIdx, isNew = false) {
        targetDayIdx = dayIdx;
        if(isNew) {
            const container = document.getElementById(`paket-container-${dayIdx}`);
            targetRowIdx = container.querySelectorAll('.paket-row').length;
        } else {
            targetRowIdx = rowIdx;
        }

        var myModal = new bootstrap.Modal(document.getElementById('modalVisualPaket'));
        myModal.show();
    }

    // Fungsi saat paket dipilih dari modal visual
    function selectPackageFromModal(id, name, price, capacity) {
        const container = document.getElementById(`paket-container-${targetDayIdx}`);

        let html = `
        <div class="row g-2 mb-2 paket-row align-items-center">
            <div class="col-8">
                <div class="selected-package-box" onclick="triggerVisualPaket(${targetDayIdx}, ${targetRowIdx}, false)">
                    <div>
                        <div class="fw-bold small">${name}</div>
                        <div class="text-muted" style="font-size: 10px;">Rp ${price.toLocaleString('id-ID')} | Kap: ${capacity}</div>
                    </div>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </div>
                <input type="hidden" name="itinerary[${targetDayIdx}][paket][${targetRowIdx}][paket_wisata_id]" class="paket-id-val" value="${id}" data-harga="${price}" data-kapasitas="${capacity}">
            </div>
            <div class="col-4">
                <div class="input-group-qty-modern">
                    <button type="button" class="btn-qty" onclick="changeQty(this, -1, true)">-</button>
                    <input type="number" name="itinerary[${targetDayIdx}][paket][${targetRowIdx}][qty]" class="qty-input-modern qty-input" value="1" min="1" oninput="calculateTotal()">
                    <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                </div>
            </div>
        </div>`;

        // Cek jika mengupdate baris yang sudah ada atau nambah baru
        const existingRows = container.querySelectorAll('.paket-row');
        if(targetRowIdx < existingRows.length) {
            existingRows[targetRowIdx].outerHTML = html;
        } else {
            container.insertAdjacentHTML('beforeend', html);
        }

        bootstrap.Modal.getInstance(document.getElementById('modalVisualPaket')).hide();
        calculateTotal();
    }

    function addFasilitas() {
        let html = `
        <div class="row g-2 mb-3 fas-row">
            <div class="col-7">
                <select name="fasilitas[${fIdx}][id]" class="form-select fas-select" onchange="calculateTotal()">
                    <option value="">-- Pilih Fasilitas --</option>
                    @foreach(\App\Models\Fasilitas::where('tipe_fasilitas', 'sewa')->get() as $f)
                        <option value="{{ $f->id }}" data-harga="{{ $f->harga }}">{{ $f->nama_fasilitas }} (Rp {{ number_format($f->harga, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
                <div class="input-group-qty-modern">
                    <button type="button" class="btn-qty" onclick="changeQty(this, -1, true)">-</button>
                    <input type="number" name="fasilitas[${fIdx}][qty]" class="qty-input-modern qty-input" value="1" min="1" oninput="calculateTotal()">
                    <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                </div>
            </div>
        </div>`;
        document.getElementById('fasilitas-container').insertAdjacentHTML('beforeend', html); fIdx++;
        calculateTotal();
    }

    function changeQtyValue(id, val) {
        let input = document.getElementById(id);
        let newVal = parseInt(input.value) + val;
        if (newVal >= 1) { input.value = newVal; calculateTotal(); }
    }

    function changeQty(btn, val, allowDelete = false) {
        let input = btn.parentElement.querySelector('input');
        let newVal = parseInt(input.value) + val;
        if (newVal < 1) {
            if (allowDelete) btn.closest('.row').remove();
            else input.value = 1;
        } else input.value = newVal;
        calculateTotal();
    }

    function calculateTotal() {
        let totalHargaPaket = 0;
        let totalKapasitasSemuaMalam = 0;
        let jmlPengunjung = parseInt(document.getElementById('jml_pengunjung').value) || 0;
        let totalMalam = parseInt(document.getElementById('jml_malam').value) || 1;

        // Hitung Paket dari input hidden
        document.querySelectorAll('.itinerary-panel').forEach((panel, i) => {
            let kapasitasMalamIni = 0;
            panel.querySelectorAll('.paket-row').forEach(row => {
                let input = row.querySelector('.paket-id-val');
                let qty = parseInt(row.querySelector('.qty-input').value) || 0;
                if(input && input.value) {
                    totalHargaPaket += (parseFloat(input.getAttribute('data-harga')) * qty);
                    kapasitasMalamIni += (parseInt(input.getAttribute('data-kapasitas')) * qty);
                }
            });
            if (jmlPengunjung > kapasitasMalamIni && kapasitasMalamIni > 0) {
                totalHargaPaket += ((jmlPengunjung - kapasitasMalamIni) * 25000);
            }
            totalKapasitasSemuaMalam += kapasitasMalamIni;
        });

        // Hitung Fasilitas
        let totalHargaFasilitas = 0;
        document.querySelectorAll('.fas-row').forEach(row => {
            let sel = row.querySelector('.fas-select');
            let qty = parseInt(row.querySelector('.qty-input').value) || 0;
            if(sel && sel.value) {
                let opt = sel.options[sel.selectedIndex];
                totalHargaFasilitas += (parseFloat(opt.getAttribute('data-harga')) * qty * totalMalam);
            }
        });

        document.getElementById('disp-kapasitas').innerText = Math.round(totalKapasitasSemuaMalam / totalMalam) || 0;
        document.getElementById('disp-total').innerText = 'Rp ' + (totalHargaPaket + totalHargaFasilitas).toLocaleString('id-ID');
    }
</script>
@endsection
