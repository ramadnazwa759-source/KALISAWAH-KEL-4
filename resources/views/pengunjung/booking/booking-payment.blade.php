@extends('layouts.app')

@section('title', 'Pembayaran Camping - Kalisawah Adventure')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold text-center mb-6">Pembayaran Camping</h1>

    <form action="{{ url('/api/pembayaran/'.$booking->id.'/metode') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-bold mb-1">Tipe Pembayaran</label>
            <select name="tipe_pembayaran" class="w-full px-4 py-2 border rounded">
                <option value="">Pilih tipe</option>
                <option value="dp" {{ $pembayaran->tipe_pembayaran=='dp'?'selected':'' }}>DP</option>
                <option value="pelunasan" {{ $pembayaran->tipe_pembayaran=='pelunasan'?'selected':'' }}>Pelunasan</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="w-full px-4 py-2 border rounded">
                <option value="">Pilih metode</option>
                <option value="transfer" {{ $pembayaran->metode_pembayaran=='transfer'?'selected':'' }}>Transfer</option>
                <option value="cash" {{ $pembayaran->metode_pembayaran=='cash'?'selected':'' }}>Cash</option>
                <option value="qris" {{ $pembayaran->metode_pembayaran=='qris'?'selected':'' }}>QRIS</option>
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('booking.camping.detail', $booking->id) }}" class="px-4 py-2 border rounded">Kembali</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded">Konfirmasi Pembayaran</button>
        </div>
    </form>
</div>
@endsection