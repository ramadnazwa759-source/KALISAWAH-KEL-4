@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.booking-admin.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h3 class="fw-bold">Detail Booking: {{ $booking->kode_booking }}</h3>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white fw-bold">Informasi Pelanggan & Kunjungan</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><td width="30%">Nama Pemesan</td><td>: <b>{{ $booking->nama_pemesan }}</b></td></tr>
                        <tr><td>No. HP</td><td>: {{ $booking->no_hp }}</td></tr>
                        <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d-m-Y') }}</td></tr>
                        <tr><td>Jam</td><td>: {{ $booking->jam }} WIB</td></tr>
                        <tr><td>Jumlah Pengunjung</td><td>: {{ $booking->jumlah_pengunjung }} Orang</td></tr>
                        <tr><td>Catatan</td><td>: {{ $booking->catatan ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Detail Pesanan</div>
                <div class="card-body">
                    <h6 class="fw-bold">Paket Wisata:</h6>
                    <ul class="list-group mb-3">
                        @foreach($booking->bookingItem as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $item->paketWisata->nama_paket ?? 'N/A' }} (x{{ $item->qty }})
                            <span>Rp {{ number_format($item->subtotal, 0) }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <h6 class="fw-bold">Fasilitas Tambahan:</h6>
                    <ul class="list-group">
                        @foreach($booking->bookingFasilitas as $f)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $f->fasilitas->nama_fasilitas ?? 'N/A' }} (x{{ $f->qty }})
                            <span>Rp {{ number_format($f->subtotal, 0) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Ringkasan Keuangan</div>
                <div class="card-body">
                    <p>Total Paket & Fasilitas: <b>Rp {{ number_format($booking->total_harga, 0) }}</b></p>
                    <p>Tiket Tambahan ({{ $booking->jumlah_tiket_tambahan }}): <b>Rp {{ number_format($booking->subtotal_tiket_tambahan, 0) }}</b></p>
                    <hr>
                    <p>Diskon Manual: <b class="text-danger">- Rp {{ number_format($booking->diskon_manual, 0) }}</b></p>
                    <h4 class="text-primary">Total: Rp {{ number_format($booking->total_harga_final, 0) }}</h4>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Status & Reschedule</div>
                <div class="card-body">
                    <p>Status Booking: <b>{{ ucfirst($booking->status_booking) }}</b></p>
                    <p>Status Pembayaran: <b>{{ ucfirst($booking->status_pembayaran) }}</b></p>
                    <hr>
                    <small class="text-muted">
                        Jumlah Reschedule: {{ $booking->jumlah_reschedule }}x <br>
                        Tanggal Reschedule: {{ $booking->tanggal_reschedule ?? '-' }} <br>
                        Alasan: {{ $booking->alasan_reschedule ?? '-' }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
