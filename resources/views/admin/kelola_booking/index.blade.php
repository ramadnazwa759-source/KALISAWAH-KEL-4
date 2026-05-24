@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Daftar Booking Wisata</h2>
            <p class="text-muted small">Kelola reservasi, status pembayaran, dan data kedatangan.</p>
        </div>
        <a href="{{ route('admin.booking-admin.store') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Booking Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="bookingTable">
                    <thead class="text-secondary small text-uppercase">
                        <tr>
                            <th style="min-width: 50px;">No</th>
                            <th style="min-width: 140px;">Kode</th>
                            <th style="min-width: 200px;">Pemesan</th>
                            <th style="min-width: 130px;">Tanggal</th>
                            <th style="min-width: 100px;">Waktu</th>
                            <th style="min-width: 120px;">Pengunjung</th>
                            <th style="min-width: 130px;">Total</th>
                            <th style="min-width: 160px;">Status</th>
                            <th class="text-center" style="min-width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $b)
                        <tr>
                            <td class="text-center fw-bold">{{ $key + 1 }}</td>
                            <td><span class="badge" style="background: #E6F0FF; color: #0066FF; font-weight: 600;">{{ $b->kode_booking }}</span></td>
                            <td>
                                <div class="fw-bold text-dark">{{ $b->nama_pemesan }}</div>
                                <div class="text-muted small">{{ $b->no_hp }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->format('d M Y') }}</td>
                            <td>{{ $b->jam }} WIB</td>
                            <td>
                                <div class="fw-bold">{{ $b->jumlah_pengunjung }} Org</div>
                                <small class="text-danger">(+{{ $b->jumlah_tiket_tambahan ?? 0 }} Tiket)</small>
                            </td>
                            <td class="fw-bold text-success text-nowrap">Rp {{ number_format($b->total_harga_final, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning mb-1">{{ ucfirst($b->status_booking) }}</span><br>
                                <span class="badge bg-danger-subtle text-danger">{{ str_replace('_', ' ', ucfirst($b->status_pembayaran)) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.booking-admin.show', $b->id) }}" class="btn btn-sm btn-info text-white rounded-3 shadow-sm" title="Detail"><i class="fas fa-eye"></i></a>

                                    <button type="button" class="btn btn-sm btn-warning text-white rounded-3 shadow-sm btn-edit" title="Edit"
                                        data-id="{{ $b->id }}"
                                        data-kode="{{ $b->kode_booking }}"
                                        data-nama="{{ $b->nama_pemesan }}"
                                        data-status="{{ $b->status_booking }}"
                                        data-pembayaran="{{ $b->status_pembayaran }}"
                                        data-diskon="{{ $b->diskon_manual }}"
                                        data-catatan="{{ $b->catatan }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger text-white rounded-3 shadow-sm" onclick="confirmDelete('{{ $b->id }}', '{{ $b->kode_booking }}')" title="Hapus"><i class="fas fa-trash"></i></button>
                                    <form id="delete-form-{{ $b->id }}" action="{{ route('admin.booking-admin.destroy', $b->id) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
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

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Booking: <span id="label_kode" class="text-primary"></span></h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3">
                        <small class="text-muted d-block">Nama Pemesan:</small>
                        <span id="label_nama" class="fw-bold text-dark"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Booking</label>
                        <select name="status_booking" id="edit_status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="dikonfirmasi">Dikonfirmasi</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" id="edit_pembayaran" class="form-select">
                            <option value="belum_bayar">Belum Bayar</option>
                            <option value="dp">DP</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diskon Manual</label>
                        <input type="number" name="diskon_manual" id="edit_diskon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" id="edit_catatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#bookingTable').DataTable({
            "paging": true, "searching": true, "ordering": false, "info": true, "autoWidth": false, "scrollX": true,
            "language": { "search": "Cari data:", "paginate": { "previous": "Previous", "next": "Next" } }
        });
    });

    $('.btn-edit').on('click', function() {
        let id = $(this).data('id');
        $('#label_kode').text($(this).data('kode'));
        $('#label_nama').text($(this).data('nama'));
        $('#formEdit').attr('action', '/admin/booking-admin/' + id);
        $('#edit_status').val($(this).data('status'));
        $('#edit_pembayaran').val($(this).data('pembayaran'));
        $('#edit_diskon').val($(this).data('diskon'));
        $('#edit_catatan').val($(this).data('catatan'));
        new bootstrap.Modal('#editModal').show();
    });

    function confirmDelete(id, kode) {
        Swal.fire({
            title: 'Hapus Booking?',
            text: `Yakin ingin menghapus booking ${kode}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
        });
    }
</script>
@endsection
