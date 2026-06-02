@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Pembayaran</h2>
            <p class="text-muted small">
                Kelola verifikasi bukti pembayaran dan status transaksi.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="pembayaranTable">

                    <thead class="text-secondary small text-uppercase">
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>Pemesan</th>
                            <th>Bukti</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pembayaran as $key => $item)
                        @php
                            $statusBadge =
                                $item->status_verifikasi == 'valid'
                                    ? 'bg-success-subtle text-success'
                                    : ($item->status_verifikasi == 'ditolak'
                                        ? 'bg-danger-subtle text-danger'
                                        : 'bg-warning-subtle text-warning');
                        @endphp
                        <tr>
                            <td class="fw-bold">{{ $key + 1 }}</td>
                            <td>
                                <span class="badge" style="background: #E6F0FF; color: #0066FF; font-weight:600;">
                                    {{ $item->booking->kode_booking ?? '-' }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">{{ $item->booking->nama_pemesan ?? '-' }}</td>
                            <td>
                                @if($item->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info text-white rounded-3 shadow-sm">
                                        <i class="fas fa-image"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="fw-bold text-success">Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $statusBadge }}">{{ strtoupper($item->status_verifikasi) }}</span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning text-white rounded-3 shadow-sm"
                                    onclick="bukaModal(
                                        '{{ $item->id }}',
                                        '{{ $item->status_verifikasi }}',
                                        '{{ addslashes($item->catatan ?? '') }}'
                                    )">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
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
                            <option value="valid">Valid</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Catatan</label>
                        <textarea id="catatan_verifikasi" class="form-control rounded-3" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 shadow-sm px-4">Simpan</button>
                </div>
            </form>
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
            scrollX: true
        });
    });

    function bukaModal(id, status, catatan) {
        document.getElementById('pembayaran_id').value = id;
        document.getElementById('status_verifikasi').value = status;
        document.getElementById('catatan_verifikasi').value = catatan;
        new bootstrap.Modal(document.getElementById('modalVerifikasi')).show();
    }

    document.getElementById('formVerifikasi').addEventListener('submit', function(e) {
        e.preventDefault();
        let id = document.getElementById('pembayaran_id').value;
        fetch('/admin/pembayaran/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                _method: 'PUT',
                status_verifikasi: document.getElementById('status_verifikasi').value,
                catatan: document.getElementById('catatan_verifikasi').value
            })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            window.location.reload();
        })
        .catch(err => {
            console.log(err);
            alert('Terjadi kesalahan');
        });
    });
</script>
@endpush
