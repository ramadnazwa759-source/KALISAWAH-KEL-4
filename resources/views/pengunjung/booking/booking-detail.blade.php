@extends('layouts.app')

@section('title', 'Detail Booking Camping - Kalisawah Adventure')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold text-center mb-6">Detail Booking Camping</h1>

    <div class="bg-white p-6 border rounded-xl mb-6">
        <p><strong>Nama Pemesan:</strong> {{ $booking->nama_pemesan }}</p>
        <p><strong>No HP:</strong> {{ $booking->no_hp }}</p>
        <p><strong>Tanggal:</strong> {{ $booking->tanggal_kunjungan }}</p>
        <p><strong>Jam:</strong> {{ $booking->jam }}</p>
        <p><strong>Jumlah Pengunjung:</strong> {{ $booking->jumlah_pengunjung }}</p>

        <h2 class="font-bold mt-4">Paket Terpilih:</h2>
        <ul class="list-disc pl-6">
            @foreach($booking->bookingItems as $item)
            <li>{{ $item->paketWisata->nama_paket }} x {{ $item->qty }} = Rp{{ number_format($item->subtotal,0,",",".") }}</li>
            @endforeach
        </ul>

        @if($booking->bookingFasilitas->count())
        <h2 class="font-bold mt-4">Fasilitas Tambahan:</h2>
        <ul class="list-disc pl-6">
            @foreach($booking->bookingFasilitas as $f)
            <li>{{ $f->fasilitas->nama_fasilitas }} x {{ $f->qty }} = Rp{{ number_format($f->subtotal,0,",",".") }}</li>
            @endforeach
        </ul>
        @endif

        <h2 class="font-bold mt-4">Total Harga:</h2>
        <p>Rp{{ number_format($booking->total_harga_final,0,",",".") }}</p>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('booking.camping.form') }}" class="px-4 py-2 border rounded">Kembali</a>
        <a href="{{ route('booking.camping.payment', $booking->id) }}" class="px-4 py-2 bg-primary text-white rounded">Lanjut Pembayaran</a>
    </div>
</div>
@endsection