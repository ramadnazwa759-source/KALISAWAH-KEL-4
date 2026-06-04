@extends('layouts.admin')

@section('content')
<style>
    .modal-content { background: #f8fafc; border-radius: 1.5rem; border: none; }
    .modal-header { background: white; padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; border-radius: 1.5rem 1.5rem 0 0; }
    .modal-body { padding: 2rem; }

    .form-section {
        background: white; border-radius: 1rem; padding: 1.75rem;
        margin-bottom: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px; }
    .payment-section { background: #fff7ed; border: 1px solid #fed7aa; }
    .payment-section .section-title { color: #9a3412; }

    .form-label { font-weight: 600; color: #64748b; font-size: 0.85rem; margin-bottom: 0.5rem; }
    .form-control, .form-select { background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 0.75rem; padding: 0.6rem 1rem; font-size: 0.95rem; font-weight: 500; transition: all 0.2s; }
    .form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); background-color: #fff; }
    
    .input-group-qty-modern { display: flex; align-items: center; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 0.75rem; padding: 3px; width: fit-content; }
    .btn-qty { width: 34px; height: 34px; border-radius: 0.5rem; background: white; border: 1px solid #cbd5e1; font-weight: bold; color: #334155; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-qty:hover { background: #e2e8f0; }
    .qty-input-modern { border: none !important; background: transparent !important; text-align: center; font-weight: 700; width: 45px; color: #1e293b; }

    .day-tabs { display: flex; gap: 10px; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .day-tab { padding: 10px 20px; background: #f1f5f9; border-radius: 30px; font-size: 0.85rem; font-weight: 700; color: #64748b; cursor: pointer; border: 1px solid #cbd5e1; transition: all 0.2s; }
    .day-tab:hover { background: #e2e8f0; }
    .day-tab.active { background: #2563eb; color: white; border-color: #2563eb; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2); }
    
    .itinerary-panel { display: none; }
    .itinerary-panel.active { display: block; }

    .item-card { background: #ffffff; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
    .item-card:hover { border-color: #3b82f6; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1); transform: translateY(-2px); }
    
    .item-row { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; transition: all 0.2s; margin-top: 0.5rem; }
    
    .summary-card { padding: 1.5rem; border-radius: 1rem; height: 100%; display: flex; flex-direction: column; justify-content: center; }
    .card-blue { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
    .card-green { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .btn-save { background: #2563eb; color: white; font-weight: 700; padding: 1.2rem; border-radius: 1rem; width: 100%; border: none; font-size: 1.1rem; transition: all 0.2s; }
    .btn-save:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2); }
    
    .empty-state-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 0.75rem; padding: 2rem; text-align: center; color: #64748b; }
    
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 class="fw-bold text-dark mb-1">Daftar Booking Wisata</h2></div>
        <button type="button" class="btn btn-primary px-4 py-2 rounded-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBooking">
            <i class="fas fa-plus me-2"></i> Tambah Booking
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="bookingTable">
                    <thead class="text-secondary small text-uppercase bg-light">
                        <tr>
                            <th class="ps-4 text-center" style="width: 60px;">No</th>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Kunjungan</th>
                            <th class="text-center">Orang</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center pe-4" style="width: 140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $b)
                        <tr>
                            <td class="ps-4 text-center fw-medium text-secondary">{{ $key + 1 }}</td>
                            <td><span class="badge bg-primary px-3 py-2 rounded-3 fw-bold">{{ $b->kode_booking }}</span></td>
                            <td>
                                <div class="fw-bold text-dark mb-1">{{ $b->nama_pemesan }}</div>
                                <small class="text-muted d-block"><i class="fab fa-whatsapp text-success me-1"></i>{{ $b->no_hp }}</small>
                            </td>
                            <td><div class="fw-bold text-secondary">{{ date('d M Y', strtotime($b->tanggal_kunjungan)) }}</div></td>
                            <td class="text-center"><span class="badge bg-light text-dark border px-2 py-2">{{ $b->jumlah_pengunjung }} Org</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($b->total_harga_final,0,',','.') }}</td>
                            <td><span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-medium">{{ $b->status_booking }}</span></td>
                            <td class="text-center pe-4">
                                <div class="d-inline-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-info text-white rounded-3 shadow-sm px-2.5 py-2" data-bs-toggle="modal" data-bs-target="#modalShowBooking{{ $b->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <a href="{{ url('/admin/booking-admin/'.$b->id.'/edit') }}" class="btn btn-sm btn-warning text-dark rounded-3 shadow-sm px-2.5 py-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ url('/admin/booking-admin/'.$b->id) }}" method="POST" id="delete-form-{{ $b->id }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger rounded-3 shadow-sm px-2.5 py-2" onclick="confirmDelete({{ $b->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/booking-admin') }}" method="POST" class="w-100" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="jumlah_tiket_tambahan" id="hidden_tiket_tambahan" value="0">
            <input type="hidden" name="harga_tiket_tambahan" value="25000">
            <input type="hidden" name="subtotal_tiket_tambahan" id="hidden_subtotal_tiket" value="0">
            <input type="hidden" name="total_harga" id="hidden_total_harga" value="0">
            <input type="hidden" name="total_harga_final" id="hidden_total_harga_final" value="0">

            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-calendar-plus me-2"></i> Reservasi Baru</h5>
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
                                        <input type="text" name="nama_pemesan" class="form-control" required placeholder="Masukkan nama pemesan">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor WhatsApp</label>
                                        <input type="text" name="no_hp" class="form-control" required placeholder="08xxxxxxxxxx">
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
                                        <label class="form-label">Total Pengunjung</label>
                                        <div class="input-group-qty-modern w-100">
                                            <button type="button" class="btn-qty w-25" onclick="changeQtyValue('jml_pengunjung', -1)">-</button>
                                            <input type="number" name="jumlah_pengunjung" id="jml_pengunjung" class="qty-input-modern w-50" value="1" min="1" onchange="calculateTotal()">
                                            <button type="button" class="btn-qty w-25" onclick="changeQtyValue('jml_pengunjung', 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Catatan Tambahan</label>
                                        <input type="text" name="catatan" class="form-control" placeholder="Catatan...">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill border border-primary">
                                        <i class="fas fa-moon me-1"></i> Durasi: <span id="label_jml_malam" class="fw-bold">0</span> Malam
                                    </span>
                                    <input type="hidden" name="jumlah_malam" id="jml_malam" value="0">
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-title"><i class="fas fa-map-marked-alt"></i> Pemilihan Paket Wisata (Per Hari)</div>
                                <div id="day-tabs-container" class="day-tabs"></div>
                                <div id="itinerary-panels-container">
                                    <div class="empty-state-box">
                                        <i class="fas fa-calendar-alt fs-2 mb-2 text-muted"></i>
                                        <p class="mb-0 fw-bold">Silakan pilih tanggal Check-In dan Check-Out terlebih dahulu.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-title mb-3"><i class="fas fa-box-open"></i> Fasilitas Tambahan (Per Malam)</div>
                                
                                <div class="d-flex gap-2 overflow-auto custom-scrollbar pb-2 mb-3 border-bottom">
                                    @php $firstFas = true; @endphp
                                    @foreach($groupedFasilitas as $katName => $items)
                                        <button type="button" class="btn btn-sm rounded-pill px-4 py-2 fw-bold text-nowrap {{ $firstFas ? 'btn-primary' : 'btn-light text-secondary border' }} fas-tab-btn" onclick="switchFasTab(this, 'fas-pane-{{ Str::slug($katName) }}')">
                                            {{ $katName }}
                                        </button>
                                        @php $firstFas = false; @endphp
                                    @endforeach
                                </div>

                                <div class="fas-panes-container mb-4">
                                    @php $firstFasPane = true; @endphp
                                    @foreach($groupedFasilitas as $katName => $items)
                                        <div id="fas-pane-{{ Str::slug($katName) }}" class="fas-pane {{ $firstFasPane ? 'd-block' : 'd-none' }}">
                                            <div class="row g-2">
                                                @foreach($items as $f)
                                                <div class="col-md-6">
                                                    <div class="border rounded-3 p-3 item-card h-100 d-flex flex-column justify-content-between" onclick="addFasilitasData({{ $f->id }}, '{{ addslashes($f->nama_fasilitas) }}', {{ $f->harga }})">
                                                        <div class="fw-bold text-dark mb-2">{{ $f->nama_fasilitas }}</div>
                                                        <div class="text-success fw-bold text-end">Rp {{ number_format($f->harga, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @php $firstFasPane = false; @endphp
                                    @endforeach
                                </div>
                                
                                <div class="pt-3 border-top">
                                    <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-shopping-cart"></i> Item Fasilitas Terpilih:</h6>
                                    <div id="fasilitas-container"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-section payment-section">
                                <div class="section-title"><i class="fas fa-wallet"></i> Pembayaran Form</div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe Pembayaran</label>
                                    <select name="tipe_pembayaran" class="form-select" required>
                                        <option value="dp">DP (Down Payment)</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Metode</label>
                                    <select name="metode_pembayaran" class="form-select" required>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cash">Cash / Tunai</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nominal Bayar (Rp)</label>
                                    <input type="number" name="nominal" class="form-control" placeholder="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diskon Manual (Rp)</label>
                                    <input type="number" name="diskon_manual" id="diskon_manual" class="form-control" placeholder="0" value="0" oninput="calculateTotal()">
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="summary-card card-blue shadow-sm">
                                        <small class="d-block mb-1 fw-bold text-uppercase"><i class="fas fa-users"></i> Kapasitas Disediakan /Malam</small>
                                        <div class="d-flex align-items-baseline gap-2">
                                            <span id="disp-kapasitas" class="fs-1 fw-bold">0</span> <span class="fw-bold">Orang</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="summary-card card-green shadow-sm">
                                        <small class="d-block mb-1 fw-bold text-uppercase"><i class="fas fa-calculator"></i> Total Estimasi Biaya</small>
                                        <span id="disp-total" class="fs-2 fw-bold text-success">Rp 0</span>
                                        <p class="small mb-0 mt-2 fw-bold text-success">*Otomatis menghitung semua item dan denda over-capacity.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light p-4 rounded-bottom-4">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-check-circle me-2"></i> Konfirmasi & Simpan Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const groupedPaket = {!! json_encode($groupedPaket) !!};
    let globalPaketIdx = 0; 
    let fIdx = 0; 

    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#bookingTable')) {
            $('#bookingTable').DataTable().destroy();
        }
        $('#bookingTable').DataTable({"ordering": false});
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data booking ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    function switchFasTab(btnElement, paneId) {
        document.querySelectorAll('.fas-tab-btn').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-light', 'text-secondary', 'border');
        });
        btnElement.classList.remove('btn-light', 'text-secondary', 'border');
        btnElement.classList.add('btn-primary');
        
        document.querySelectorAll('.fas-pane').forEach(pane => {
            pane.classList.remove('d-block');
            pane.classList.add('d-none');
        });
        document.getElementById(paneId).classList.remove('d-none');
        document.getElementById(paneId).classList.add('d-block');
    }

    function switchCatTab(btnElement, paneId, dayIdx) {
        document.querySelectorAll(`.cat-btn-${dayIdx}`).forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-light', 'text-secondary', 'border');
        });
        btnElement.classList.remove('btn-light', 'text-secondary', 'border');
        btnElement.classList.add('btn-primary');
        
        document.querySelectorAll(`.cat-pane-${dayIdx}`).forEach(pane => {
            pane.classList.remove('d-block');
            pane.classList.add('d-none');
        });
        document.getElementById(paneId).classList.remove('d-none');
        document.getElementById(paneId).classList.add('d-block');
    }

    function switchTab(idx) {
        document.querySelectorAll('.day-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.itinerary-panel').forEach(p => p.classList.remove('active'));
        document.getElementById(`tab-${idx}`).classList.add('active');
        document.getElementById(`panel-${idx}`).classList.add('active');
    }

    function renderItinerary() {
        const ci = document.getElementById('tanggal_kunjungan').value;
        const co = document.getElementById('tanggal_selesai').value;
        const tabs = document.getElementById('day-tabs-container');
        const panels = document.getElementById('itinerary-panels-container');

        if (!ci || !co) {
            tabs.innerHTML = ''; 
            panels.innerHTML = `
                <div class="empty-state-box">
                    <i class="fas fa-calendar-alt fs-2 mb-2 text-muted"></i>
                    <p class="mb-0 fw-bold">Silakan pilih tanggal Check-In dan Check-Out terlebih dahulu.</p>
                </div>`;
            document.getElementById('jml_malam').value = 0;
            document.getElementById('label_jml_malam').innerText = 0;
            calculateTotal();
            return;
        }

        const d1 = new Date(ci);
        const d2 = new Date(co);
        let totalMalam = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
        if (totalMalam < 1) totalMalam = 1;

        document.getElementById('jml_malam').value = totalMalam;
        document.getElementById('label_jml_malam').innerText = totalMalam;

        tabs.innerHTML = ''; 
        panels.innerHTML = '';

        for (let i = 0; i < totalMalam; i++) {
            let cur = new Date(d1); cur.setDate(d1.getDate() + i);
            let dateStr = cur.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });

            tabs.insertAdjacentHTML('beforeend', `<div class="day-tab ${i===0?'active':''}" id="tab-${i}" onclick="switchTab(${i})">HARI ${i+1} (${dateStr})</div>`);
            
            let tabsHtml = `<div class="d-flex gap-2 overflow-auto custom-scrollbar pb-2 mb-3 border-bottom">`;
            let panesHtml = `<div class="tab-content mb-4">`;
            
            let isFirstCat = true;
            for (const katName in groupedPaket) {
                let slug = katName.replace(/[^a-zA-Z0-9]/g, '-').toLowerCase();
                let activeBtn = isFirstCat ? 'btn-primary' : 'btn-light text-secondary border';
                let activePane = isFirstCat ? 'd-block' : 'd-none';

                tabsHtml += `<button type="button" class="btn btn-sm rounded-pill px-4 py-2 fw-bold text-nowrap ${activeBtn} cat-btn-${i}" onclick="switchCatTab(this, 'pane-${slug}-${i}', ${i})">${katName}</button>`;

                let cardsHtml = `<div class="row g-2">`;
                groupedPaket[katName].forEach(p => {
                    let formattedHarga = parseInt(p.harga).toLocaleString('id-ID');
                    let safeNama = p.nama_paket.replace(/'/g, "\\'");
                    
                    cardsHtml += `
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 item-card h-100 d-flex flex-column justify-content-between" onclick="addPaketData('${p.id}', '${safeNama}', '${p.harga}', '${p.kapasitas}', ${i})">
                            <div class="fw-bold text-dark mb-2">${p.nama_paket}</div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info"><i class="fas fa-users"></i> ${p.kapasitas} Org</span>
                                <span class="text-success fw-bold">Rp ${formattedHarga}</span>
                            </div>
                        </div>
                    </div>`;
                });
                cardsHtml += `</div>`;
                
                panesHtml += `<div id="pane-${slug}-${i}" class="cat-pane-${i} ${activePane}">${cardsHtml}</div>`;
                isFirstCat = false;
            }
            tabsHtml += `</div>`;
            panesHtml += `</div>`;

            panels.insertAdjacentHTML('beforeend', `
                <div class="itinerary-panel ${i===0?'active':''}" id="panel-${i}">
                    <div class="bg-white border rounded-3 p-3 mb-3 shadow-sm">
                        ${tabsHtml}
                        ${panesHtml}
                        <div class="pt-3 border-top">
                            <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-shopping-cart"></i> Item Paket Terpilih:</h6>
                            <div id="paket-container-${i}"></div>
                        </div>
                    </div>
                </div>
            `);
        }
        calculateTotal();
    }

    function addPaketData(id, nama, harga, kapasitas, dayIdx) {
        let currentPaketIdx = globalPaketIdx++;
        let html = `
        <div class="row g-2 item-row paket-row align-items-center">
            <div class="col-md-7">
                <div class="fw-bold text-dark fs-6 mb-1">${nama}</div>
                <div class="text-muted small">
                    <span class="badge bg-info text-dark shadow-sm me-2"><i class="fas fa-users"></i> Kapasitas: ${kapasitas} Orang</span>
                    <span class="fw-bold text-success"><i class="fas fa-tag"></i> Rp ${parseInt(harga).toLocaleString('id-ID')}</span>
                </div>
                <input type="hidden" name="paket[${currentPaketIdx}][paket_wisata_id]" value="${id}">
                <input type="hidden" name="paket[${currentPaketIdx}][hari]" value="${dayIdx + 1}">
                <input type="hidden" name="paket[${currentPaketIdx}][harga]" value="${harga}">
                <input type="hidden" class="paket-harga-hidden" value="${harga}">
                <input type="hidden" class="paket-kapasitas-hidden" value="${kapasitas}">
            </div>
            <div class="col-md-4">
                <div class="input-group-qty-modern mx-auto">
                    <button type="button" class="btn-qty" onclick="changeQty(this, -1, true)">-</button>
                    <input type="number" name="paket[${currentPaketIdx}][qty]" class="qty-input-modern qty-input" value="1" min="1" oninput="calculateTotal()">
                    <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                </div>
            </div>
            <div class="col-md-1 text-end">
                 <button type="button" class="btn btn-sm btn-danger rounded-3" onclick="this.closest('.paket-row').remove(); calculateTotal()"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        
        document.getElementById(`paket-container-${dayIdx}`).insertAdjacentHTML('beforeend', html);
        calculateTotal();
    }

    function addFasilitasData(id, nama, harga) {
        let html = `
        <div class="row g-2 item-row fas-row align-items-center">
            <div class="col-md-7">
                <div class="fw-bold text-dark fs-6 mb-1">${nama}</div>
                <div class="text-muted small">
                    <span class="fw-bold text-success"><i class="fas fa-tag"></i> Rp ${parseInt(harga).toLocaleString('id-ID')} /malam</span>
                </div>
                <input type="hidden" name="fasilitas[${fIdx}][fasilitas_id]" value="${id}">
                <input type="hidden" name="fasilitas[${fIdx}][harga]" value="${harga}">
                <input type="hidden" class="fas-harga-hidden" value="${harga}">
            </div>
            <div class="col-md-4">
                <div class="input-group-qty-modern mx-auto">
                    <button type="button" class="btn-qty" onclick="changeQty(this, -1, true)">-</button>
                    <input type="number" name="fasilitas[${fIdx}][qty]" class="qty-input-modern qty-input" value="1" min="1" oninput="calculateTotal()">
                    <button type="button" class="btn-qty" onclick="changeQty(this, 1)">+</button>
                </div>
            </div>
            <div class="col-md-1 text-end">
                 <button type="button" class="btn btn-sm btn-danger rounded-3" onclick="this.closest('.fas-row').remove(); calculateTotal()"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        
        document.getElementById('fasilitas-container').insertAdjacentHTML('beforeend', html); 
        fIdx++;
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
            if (allowDelete) {
                btn.closest('.item-row').remove();
            } else {
                input.value = 1;
            }
        } else {
            input.value = newVal;
        }
        calculateTotal();
    }

    function calculateTotal() {
        let totalHargaPaket = 0;
        let totalKapasitasSemuaMalam = 0;
        let totalTiketTambahan = 0;
        let totalBiayaTiketTambahan = 0;
        const HARGA_TIKET_TAMBAHAN = 25000;

        let jmlPengunjung = parseInt(document.getElementById('jml_pengunjung').value) || 0;
        let totalMalam = parseInt(document.getElementById('jml_malam').value) || 0;

        document.querySelectorAll('.itinerary-panel').forEach((panel) => {
            let kapasitasMalamIni = 0;
            panel.querySelectorAll('.paket-row').forEach(row => {
                let qty = parseInt(row.querySelector('.qty-input').value) || 0;
                let harga = parseFloat(row.querySelector('.paket-harga-hidden').value) || 0;
                let kapasitas = parseInt(row.querySelector('.paket-kapasitas-hidden').value) || 0;
                
                totalHargaPaket += (harga * qty);
                kapasitasMalamIni += (kapasitas * qty);
            });
            
            if (kapasitasMalamIni > 0 && jmlPengunjung > kapasitasMalamIni) {
                let overCapacity = jmlPengunjung - kapasitasMalamIni;
                totalTiketTambahan += overCapacity;
                totalBiayaTiketTambahan += (overCapacity * HARGA_TIKET_TAMBAHAN);
            }
            totalKapasitasSemuaMalam += kapasitasMalamIni;
        });

        let totalHargaFasilitas = 0;
        document.querySelectorAll('.fas-row').forEach(row => {
            let qty = parseInt(row.querySelector('.qty-input').value) || 0;
            let harga = parseFloat(row.querySelector('.fas-harga-hidden').value) || 0;
            totalHargaFasilitas += (harga * qty * (totalMalam > 0 ? totalMalam : 1));
        });

        let diskonManual = parseFloat(document.getElementById('diskon_manual').value) || 0;
        let totalHarga = totalHargaPaket + totalHargaFasilitas + totalBiayaTiketTambahan;
        let totalHargaFinal = totalHarga - diskonManual;
        
        if (totalHargaFinal < 0) totalHargaFinal = 0;

        document.getElementById('disp-kapasitas').innerText = totalKapasitasSemuaMalam;
        document.getElementById('disp-total').innerText = 'Rp ' + totalHargaFinal.toLocaleString('id-ID');
        document.getElementById('hidden_total_harga').value = totalHarga;
        document.getElementById('hidden_total_harga_final').value = totalHargaFinal;
        document.getElementById('hidden_tiket_tambahan').value = totalTiketTambahan;
        document.getElementById('hidden_subtotal_tiket').value = totalBiayaTiketTambahan;
    }
</script>
@endsection