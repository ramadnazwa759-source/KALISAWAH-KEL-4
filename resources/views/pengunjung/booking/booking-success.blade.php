@extends('layouts.app')

@section('title', 'Booking Berhasil Camping - Kalisawah Adventure')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold text-center mb-6">Booking Camping Berhasil</h1>

    <div class="bg-white p-6 border rounded-xl mb-6">
        <p><strong>Kode Booking:</strong> {{ $booking->kode_booking }}</p>
        <p><strong>Status:</strong> {{ $booking->status_booking }}</p>
        <p><strong>Total Harga:</strong> Rp{{ number_format($booking->total_harga_final,0,",",".") }}</p>
    </div>

    <form action="{{ url('/api/pembayaran/'.$pembayaran->id.'/upload-bukti') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block font-bold mb-1">Upload Bukti DP / Pembayaran</label>
            <input type="file" name="bukti_pembayaran" class="w-full">
        </div>

        <button type="submit" class="px-4 py-2 bg-primary text-white rounded">Upload Bukti</button>
    </form>
</div>
@endsection