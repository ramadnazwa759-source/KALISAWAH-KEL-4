@extends('layouts.app')

@section('title', 'Rincian Booking')

@section('content')
<div class="bg-slate-50/50 min-h-screen pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Status --}}
        <div class="flex justify-center mb-6">
            <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">
                Rincian Booking
            </span>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-blue-600 font-bold tracking-widest uppercase text-sm mb-2">Konfirmasi Pesanan</h2>
            <h1 class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight">Detail Pesanan Anda</h1>
            <div class="w-16 h-1.5 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- Info Pelanggan --}}
        <div class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-gray-100 mb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-8">
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Pelanggan</h4>
                    <p class="text-xl md:text-2xl font-black text-slate-800">{{ $booking->nama_pemesan }}</p>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">No. Whatsapp</h4>
                    <p class="text-xl md:text-2xl font-black text-slate-800">{{ $booking->no_hp }}</p>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal Check-In</h4>
                    <p class="text-xl md:text-2xl font-black text-slate-800">{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jam Kedatangan</h4>
                    <p class="text-xl md:text-2xl font-black text-slate-800">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</p>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jumlah Pengunjung</h4>
                    <p class="text-xl md:text-2xl font-black text-slate-800">{{ (int)$booking->jumlah_pengunjung }} Orang</p>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Lama Menginap</h4>
                    <p class="text-xl md:text-2xl font-black text-blue-600">{{ (int)$booking->jumlah_malam }} Malam</p>
                </div>
            </div>
        </div>

        {{-- Aktivitas Per Hari --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1.5 h-6 bg-amber-400 rounded-full"></div>
            <h2 class="text-lg md:text-xl font-black text-slate-800 tracking-wide uppercase">Aktivitas Per Hari</h2>
        </div>

        <div class="space-y-8 mb-16">
            @php
                $tanggalMulai = \Carbon\Carbon::parse($booking->tanggal_kunjungan);
                $totalMalam = (int)$booking->jumlah_malam;
            @endphp

            @for($i = 0; $i < $totalMalam; $i++)
                @php
                    $itemsHari = $booking->items->where('hari', $i);
                    $fasilitasHari = $booking->fasilitas->where('hari', $i);
                    $tanggalHariIni = $tanggalMulai->copy()->addDays($i)->translatedFormat('l, d F Y');
                @endphp

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <h3 class="font-black text-sm md:text-base text-slate-800 uppercase tracking-wide mb-4">Hari {{ $i + 1 }} - {{ $tanggalHariIni }}</h3>
                    <div class="border-b border-gray-100 mb-6"></div>

                    {{-- List Paket --}}
                    <div class="space-y-4">
                        @if($itemsHari->count() > 0)
                            @foreach($itemsHari->groupBy('paket_wisata_id') as $group)
                                @php
                                    $namaPaket = $group->first()->paketWisata->nama_paket ?? 'Paket Wisata';
                                    $totalQty = $group->sum('qty');
                                    $totalSubtotal = $group->sum('subtotal');
                                @endphp
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-700 uppercase">{{ $namaPaket }} ({{ (int)$totalQty }}x)</span>
                                    <span class="text-base font-black text-slate-900">Rp {{ number_format((float)$totalSubtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak ada aktivitas paket.</p>
                        @endif
                    </div>

                    {{-- Fasilitas Hari Ini --}}
                    @if($fasilitasHari->count() > 0)
                        <div class="mt-6 pt-6 border-t border-dashed border-gray-200">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4">Fasilitas Tambahan</p>
                            <div class="space-y-3">
                                @foreach($fasilitasHari as $fas)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-blue-600 uppercase">{{ $fas->fasilitas->nama_fasilitas ?? 'Item Fasilitas' }} ({{ (int)$fas->qty }}x)</span>
                                        <span class="text-sm font-black text-blue-600">Rp {{ number_format((float)$fas->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endfor

            {{-- Tiket Tambahan --}}
            @if((int)($booking->subtotal_tiket_tambahan ?? 0) > 0)
                <div class="bg-orange-50 rounded-3xl p-6 md:p-8 shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-2 h-6 bg-orange-400 rounded-full"></div>
                        <h3 class="font-black text-sm md:text-base text-orange-900 uppercase tracking-wide">Tiket Tambahan</h3>
                    </div>
                    <div class="border-b border-orange-200 mb-6"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-orange-800 uppercase">Tambahan Pengunjung ({{ (int)$booking->jumlah_tiket_tambahan }} Orang)</span>
                        <span class="text-base font-black text-orange-900">Rp {{ number_format((float)$booking->subtotal_tiket_tambahan, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Rekapitulasi Harga --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
            <h2 class="text-lg md:text-xl font-black text-slate-800 tracking-wide uppercase">Rekapitulasi Harga</h2>
        </div>

        <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 mb-16">
            <span class="text-base md:text-lg font-black text-slate-800 uppercase tracking-wide">Total Pembayaran Keseluruhan</span>
            <span class="text-4xl md:text-5xl font-black text-blue-600">Rp {{ number_format((float)($booking->total_harga_final ?? 0), 0, ',', '.') }}</span>
        </div>

        <div class="flex flex-col items-center gap-4">
            @if($booking->status_pembayaran == 'belum_bayar')
                <p class="text-sm text-gray-400 text-center">Mohon periksa kembali detail pesanan Anda sebelum lanjut ke pembayaran.</p>
                <a href="{{ route('pengunjung.booking.booking-payment', $booking->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition shadow-lg shadow-blue-200 uppercase tracking-widest text-center w-full sm:w-auto">
                    Pilih Metode Pembayaran
                </a>
                <a href="{{ route('pengunjung.booking.edit', $booking->id) }}" class="text-gray-500 hover:text-blue-600 font-bold text-sm underline mt-2 transition">
                    Ubah Detail Pesanan
                </a>
            @endif
        </div>

    </div>
</div>
@endsection