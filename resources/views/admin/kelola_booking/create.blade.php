@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Tambah Booking</h2>
        </div>
        <a href="{{ route('admin.booking-admin.index') }}" class="btn btn-white border shadow-sm px-3 py-2 rounded-3 text-secondary fw-semibold small">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <ul class="mb-0 small fw-medium">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.booking-admin.store') }}" method="POST" id="form-booking">
        @csrf

        {{-- Data Pemesan --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-person-circle text-primary me-2"></i>Data Pemesan</h5>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label small fw-semibold text-secondary">Nama Pemesan</label><input type="text" name="nama_pemesan" class="form-control rounded-3 py-2" required></div>
                <div class="col-md-4"><label class="form-label small fw-semibold text-secondary">Nomor HP</label><input type="text" name="no_hp" class="form-control rounded-3 py-2" required></div>
                <div class="col-md-2"><label class="form-label small fw-semibold text-secondary">Tanggal</label><input type="date" name="tanggal_kunjungan" class="form-control rounded-3 py-2" required></div>
                <div class="col-md-2"><label class="form-label small fw-semibold text-secondary">Jam</label><input type="time" name="jam" class="form-control rounded-3 py-2" required></div>
            </div>
        </div>

        {{-- Paket & Pengunjung --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><i class="bi bi-card-checklist text-primary me-2"></i>Paket Wisata</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="btn-tambah-paket">+ Tambah Paket</button>
            </div>
            <div id="container-paket"></div>

            <div class="mt-4 border-top pt-4">
                <label class="form-label small fw-bold">Total Pengunjung</label>
                <input type="number" name="jumlah_pengunjung" id="input-peserta" class="form-control rounded-3 py-2" value="1" min="1" disabled required>
                <div id="alert-paket" class="text-danger small mt-2">
                    <i class="bi bi-exclamation-circle"></i> Silakan pilih paket wisata terlebih dahulu.
                </div>
            </div>
        </div>

        {{-- Fasilitas & Pembayaran --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold"><i class="bi bi-box-seam text-primary me-2"></i>Fasilitas Tambahan</h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-tambah-fasilitas">+ Tambah</button>
                    </div>
                    <div id="container-fasilitas"></div>
                    <div class="mt-3">
                        <label class="form-label small fw-semibold text-secondary">Catatan</label>
                        <textarea name="catatan" class="form-control rounded-3" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 text-primary me-2"></i>Metode Pembayaran</h5>
                    <select name="metode_pembayaran" class="form-select rounded-3 py-2" required>
                        <option value="transfer">Transfer Bank</option>
                        <option value="qris">QRIS</option>
                        <option value="tunai">Tunai / Cash</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Total --}}
        <div class="card p-4 shadow-sm rounded-4 bg-primary text-white mb-4">
            <h5 class="fw-bold">Total Harga Booking</h5>
            <h1 id="summary-total" class="display-5 fw-bold">Rp0</h1>
            <input type="hidden" name="total_harga" id="hidden-total">
        </div>

        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold rounded-4 shadow">SIMPAN DATA BOOKING</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let pIndex = 0, fIndex = 0;

    function hitungTotal() {
        let total = 0, totalKapasitasPaket = 0;
        let totalPeserta = parseInt($('#input-peserta').val()) || 0;

        $('.paket-row').each(function() {
            let opt = $(this).find('.paket-select option:selected');
            let qty = parseInt($(this).find('.input-qty').val());
            if(opt.val()) {
                total += (parseFloat(opt.data('harga')) * qty);
                totalKapasitasPaket += (parseFloat(opt.data('kapasitas')) * qty);
            }
        });

        if (totalPeserta > totalKapasitasPaket) total += ((totalPeserta - totalKapasitasPaket) * 25000);

        $('.fasilitas-row').each(function() {
            let opt = $(this).find('.fas-select option:selected');
            let qty = parseInt($(this).find('.qty-fas').val());
            if(opt.val()) total += (parseFloat(opt.data('harga')) * qty);
        });

        $('#summary-total').text('Rp' + total.toLocaleString('id-ID'));
        $('#hidden-total').val(total);
    }

    function checkPaketStatus() {
        let adaPaket = $('.paket-row').length > 0;
        $('#input-peserta').prop('disabled', !adaPaket);
        adaPaket ? $('#alert-paket').addClass('d-none') : $('#alert-paket').removeClass('d-none');
        hitungTotal();
    }

    $('#btn-tambah-paket').click(function() {
        $('#container-paket').append(`<div class="row g-2 align-items-center mb-2 paket-row">
            <div class="col-8"><select name="paket[${pIndex}][paket_wisata_id]" class="form-select paket-select" onchange="hitungTotal()"><option value="">Pilih Paket</option>@foreach($paketWisata as $p)<option value="{{$p->id}}" data-harga="{{$p->harga}}" data-kapasitas="5">{{$p->nama_paket}} (Rp{{number_format($p->harga)}})</option>@endforeach</select></div>
            <div class="col-4"><input type="number" name="paket[${pIndex}][qty]" class="form-control text-center input-qty" value="1" min="1" onchange="hitungTotal()"></div>
        </div>`);
        pIndex++;
        checkPaketStatus();
    });

    $('#btn-tambah-fasilitas').click(function() {
        $('#container-fasilitas').append(`<div class="row g-2 align-items-center mb-2 fasilitas-row">
            <div class="col-6"><select name="fasilitas[${fIndex}][fasilitas_id]" class="form-select fas-select" onchange="hitungTotal()"><option value="">Pilih Fasilitas</option>@foreach($fasilitas as $f)<option value="{{$f->id}}" data-harga="{{$f->harga}}">{{$f->nama_fasilitas}} (Rp{{number_format($f->harga)}})</option>@endforeach</select></div>
            <div class="col-3"><input type="number" name="fasilitas[${fIndex}][qty]" class="form-control text-center qty-fas" value="1" min="1" onchange="hitungTotal()"></div>
            <div class="col-3"><button type="button" class="btn btn-outline-danger w-100 btn-hapus-fasilitas" style="height: 38px;">-</button></div>
        </div>`);
        fIndex++;
    });

    $(document).on('click', '.btn-hapus-fasilitas', function() {
        $(this).closest('.fasilitas-row').remove();
        hitungTotal();
    });

    $('#input-peserta').on('input', hitungTotal);
</script>
@endsection
