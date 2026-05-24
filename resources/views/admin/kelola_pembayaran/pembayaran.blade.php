@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Pembayaran</h2>
            <p class="text-muted small">Kelola verifikasi bukti pembayaran dan status transaksi.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="pembayaranTable">
                    <thead class="text-secondary small text-uppercase">
                        <tr>
                            <th style="min-width: 50px;">No</th>
                            <th style="min-width: 140px;">Kode Booking</th>
                            <th style="min-width: 200px;">Pemesan</th>
                            <th style="min-width: 120px;">Bukti</th>
                            <th style="min-width: 130px;">Nominal</th>
                            <th style="min-width: 160px;">Status</th>
                            <th class="text-center" style="min-width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-pembayaran">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Verifikasi --}}
<div class="modal fade" id="modalVerifikasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formVerifikasi">
                @csrf
                <div class="modal-body px-4">
                    <input type="hidden" id="pembayaran_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Status Verifikasi</label>
                        <select id="status_verifikasi" class="form-select rounded-3" required>
                            <option value="pending">Pending</option>
                            <option value="valid">Valid (Terima)</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Catatan</label>
                        <textarea id="catatan_verifikasi" class="form-control rounded-3" rows="2" placeholder="Masukkan catatan jika ada..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSubmit" class="btn btn-primary rounded-3 shadow-sm px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable agar tampilannya sama persis dengan tabel Booking
        $('#pembayaranTable').DataTable({
            "paging": true, "searching": true, "ordering": false, "info": true, "autoWidth": false, "scrollX": true,
            "language": { "search": "Cari data:", "paginate": { "previous": "Previous", "next": "Next" } }
        });
        loadData();
    });

    function loadData() {
        fetch('/api/pembayaran', { headers: { 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById('tbody-pembayaran');
            tbody.innerHTML = '';

            data.forEach((item, index) => {
                // Styling badge mirip booking
                let statusBadge = item.status_verifikasi == 'valid' ? 'bg-success-subtle text-success' :
                                 (item.status_verifikasi == 'ditolak' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning');

                tbody.innerHTML += `
                    <tr>
                        <td class="text-center fw-bold">${index + 1}</td>
                        <td><span class="badge" style="background: #E6F0FF; color: #0066FF; font-weight: 600;">${item.booking?.kode_booking ?? '-'}</span></td>
                        <td class="fw-bold text-dark">${item.booking?.nama_pemesan ?? '-'}</td>
                        <td>${item.bukti_pembayaran ? `<a href="/storage/${item.bukti_pembayaran}" target="_blank" class="btn btn-sm btn-info text-white rounded-3 shadow-sm"><i class="fas fa-image"></i></a>` : '-'}</td>
                        <td class="fw-bold text-success text-nowrap">Rp ${new Intl.NumberFormat('id-ID').format(item.nominal)}</td>
                        <td><span class="badge ${statusBadge}">${item.status_verifikasi.toUpperCase()}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning text-white rounded-3 shadow-sm" onclick="bukaModal(${item.id}, '${item.status_verifikasi}', '${item.catatan ?? ''}')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
    }

    function bukaModal(id, status, catatan) {
        document.getElementById('pembayaran_id').value = id;
        document.getElementById('status_verifikasi').value = status;
        document.getElementById('catatan_verifikasi').value = catatan;
        new bootstrap.Modal(document.getElementById('modalVerifikasi')).show();
    }

    // ... (logic submit tetap sama)
</script>
@endpush
