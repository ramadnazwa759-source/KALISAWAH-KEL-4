@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Pembayaran</h2>
            <p class="text-muted small">
                Kelola verifikasi bukti pembayaran, update status, dan integrasi kas pemasukan otomatis.
            </p>
        </div>
    </div>

    {{-- ALERT NOTIFIKASI DARI CONTROLLER --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="pembayaranTable">
                    <thead class="text-secondary small text-uppercase">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Kode Booking</th>
                            <th>Pemesan</th>
                            <th>Bukti Transfer</th>
                            <th>Nominal</th>
                            <th>Status Verifikasi</th>
                            <th class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $key => $item)
                        @php
                            $statusBadge = $item->status_verifikasi == 'valid'
                                ? 'bg-success-subtle text-success border border-success'
                                : ($item->status_verifikasi == 'ditolak'
                                    ? 'bg-danger-subtle text-danger border border-danger'
                                    : 'bg-warning-subtle text-warning border border-warning');
                        @endphp
                        <tr>
                            <td class="fw-bold">{{ $key + 1 }}</td>
                            <td>
                                <span class="badge" style="background: #E6F0FF; color: #0066FF; font-weight:600; padding: 6px 12px;">
                                    {{ $item->booking->kode_booking ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->booking->nama_pemesan ?? '-' }}</div>
                                <small class="text-muted">{{ $item->booking->telepon ?? '' }}</small>
                            </td>
                            <td>
                                @if($item->bukti_pembayaran)
                                    <button type="button" class="btn btn-sm btn-light border rounded-3 shadow-sm px-3"
                                            onclick="previewBukti('{{ asset('storage/' . $item->bukti_pembayaran) }}')">
                                        <i class="fas fa-eye text-primary me-1"></i> Lihat Bukti
                                    </button>
                                @else
                                    <span class="text-muted small italic">Belum Upload</span>
                                @endif
                            </td>
                            <td class="fw-bold text-success">Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $statusBadge }} text-uppercase px-3 py-2 rounded-pill small">
                                    {{ $item->status_verifikasi }}
                                </span>
                            </td>
                           <td class="text-center">
                            <button class="btn btn-sm btn-primary rounded-2 shadow-sm px-1 py-2 "
                                onclick="bukaModal(
                                    '{{ $item->id }}',
                                    '{{ $item->status_verifikasi }}',
                                    '{{ addslashes($item->catatan ?? '') }}'
                                )" style="font-size: 0.75rem;">
                                <i class="fas fa-check-double" style="font-size: 0.7rem;"></i> Proses
                            </button>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pembayaran masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- MODAL VERIFIKASI --}}
<div class="modal fade" id="modalVerifikasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-shield-alt text-primary me-2"></i>Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Menggunakan Form Submit HTML standard agar sinkron dengan return back() Controller --}}
            <form id="formVerifikasi" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Ubah Status Verifikasi</label>
                        <select name="status_verifikasi" id="status_verifikasi" class="form-select rounded-3" required>
                            <option value="pending">⏳ PENDING (Belum Dicek)</option>
                            <option value="valid">✅ VALID (Uang Masuk Kas/Pemasukan)</option>
                            <option value="ditolak">❌ DITOLAK (Bukti Salah / Palsu)</option>
                        </select>
                        <div class="form-text text-muted small mt-1">
                            *Jika dipilih <b>VALID</b>, sistem otomatis mengubah status booking menjadi lunas & mencatat kas masuk.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Catatan Internal / Alasan Tolak</label>
                        <textarea name="catatan" id="catatan_verifikasi" class="form-control rounded-3" rows="3" placeholder="Contoh: Transfer via BCA Mandiri an. Pengirim sesuai, atau alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light border rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSubmitVerifikasi" class="btn btn-primary rounded-3 shadow-sm px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL POPUP PREVIEW BUKTI TRANSAKSI --}}
<div class="modal fade" id="modalPreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-secondary">Foto Bukti Transfer Pemesan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img src="" id="imgPreviewTarget" class="img-fluid rounded-3 border shadow-sm" style="max-height: 500px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#pembayaranTable')) {
            $('#pembayaranTable').DataTable().destroy();
        }
        $('#pembayaranTable').DataTable({
            paging: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false,
            scrollX: true,
            language: {
                search: "Cari Pembayaran:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pembayaran"
            }
        });

        // Efek loading saat form disubmit murni agar tidak klik ganda
        document.getElementById('formVerifikasi').addEventListener('submit', function() {
            let btn = document.getElementById('btnSubmitVerifikasi');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        });
    </script>
    <script>
    // Fungsi Trigger Preview Gambar
    function previewBukti(urlSrc) {
        document.getElementById('imgPreviewTarget').src = urlSrc;
        new bootstrap.Modal(document.getElementById('modalPreview')).show();
    }

    // Mengubah Action Route Form Secara Dinamis saat Modal Dibuka
    function bukaModal(id, status, catatan) {
        let form = document.getElementById('formVerifikasi');
        form.action = '/admin/pembayaran/' + id; // Set action url post Laravel target ke ID ini

        document.getElementById('status_verifikasi').value = status;
        document.getElementById('catatan_verifikasi').value = catatan;
        new bootstrap.Modal(document.getElementById('modalVerifikasi')).show();
    }
</script>
@endpush
