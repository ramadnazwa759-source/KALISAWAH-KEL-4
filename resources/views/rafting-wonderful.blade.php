@extends('layouts.app')

@section('title', 'Wonderful Rafting - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[60vh] min-h-[400px] w-full overflow-hidden">
        <img src="{{ asset('images/raft1.jpg') }}" alt="Wonderful Rafting" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto pt-20">
            <div class="max-w-2xl">
                <div class="inline-block bg-blue-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg mb-6">
                    Cocok untuk Pemula
                </div>
                <h1 class="text-white text-4xl md:text-6xl font-black mb-4 uppercase leading-tight">WONDERFUL</h1>
                <p class="text-gray-200 text-lg font-medium leading-relaxed">
                    Pengalaman rafting singkat yang menyenangkan dan aman bagi pemula atau keluarga.
                </p>
            </div>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-24 px-6 md:px-20 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Left: Details -->
            <div class="lg:col-span-2 space-y-12">
                <div>
                    <h2 class="text-3xl font-black text-dark-navy uppercase tracking-tight mb-6 flex items-center gap-4">
                        <span class="w-3 h-10 bg-primary rounded-full"></span>
                        Deskripsi Paket
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Paket Wonderful dirancang khusus bagi Anda yang ingin mencoba sensasi rafting untuk pertama kalinya. Dengan jarak yang relatif pendek dan jeram yang ramah, paket ini sangat direkomendasikan untuk keluarga dengan anak-anak atau kelompok yang ingin bersenang-senang tanpa rasa khawatir.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 p-8 rounded-[32px] border border-gray-100">
                        <h3 class="text-sm font-black text-primary uppercase tracking-[0.2em] mb-6">Info Teknis</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-4 text-gray-600 font-bold">
                                <i class="fa-solid fa-route text-secondary w-6 text-center"></i>
                                <span>Jarak ± 1 Km</span>
                            </li>
                            <li class="flex items-center gap-4 text-gray-600 font-bold">
                                <i class="fa-solid fa-clock text-secondary w-6 text-center"></i>
                                <span>Durasi 1 Jam</span>
                            </li>
                            <li class="flex items-center gap-4 text-gray-600 font-bold">
                                <i class="fa-solid fa-person-swimming text-secondary w-6 text-center"></i>
                                <span>Guide Profesional</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-[32px] border border-gray-100">
                        <h3 class="text-sm font-black text-primary uppercase tracking-[0.2em] mb-6">Fasilitas Include</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-4 text-gray-600 font-bold">
                                <i class="fa-solid fa-ticket text-green-500 w-6 text-center"></i>
                                <span>Tiket Masuk & Asuransi</span>
                            </li>
                            <li class="flex items-center gap-4 text-gray-600 font-bold">
                                <i class="fa-solid fa-utensils text-green-500 w-6 text-center"></i>
                                <span>Makan 1x</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right: Booking Card -->
            <div class="lg:col-span-1">
                <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-2xl sticky top-32">
                    <div class="mb-8">
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-widest block mb-2">Harga Per Orang</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-dark-navy">Rp 135k</span>
                            <span class="text-gray-400 font-bold">/ Pax</span>
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-2 tracking-widest">(WNA Rp 200.000)</p>
                    </div>

                    <a href="{{ route('booking.rafting') }}?paket=wonderful" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-hover-primary transition-all active:scale-[0.98] shadow-xl shadow-primary/20 mb-6">
                        Booking Sekarang
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>

                    <div class="space-y-4 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-3 text-gray-400">
                            <i class="fa-solid fa-smile-beam text-secondary"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Ramah untuk Pemula</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400">
                            <i class="fa-solid fa-shield-halved text-green-500"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Aman & Berasuransi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NAVIGASI BALIK -->
    <div class="pb-24 px-6 text-center">
        <a href="{{ route('rafting') }}" class="inline-flex items-center gap-3 text-gray-400 font-black text-xs uppercase tracking-[0.2em] hover:text-primary transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Semua Paket
        </a>
    </div>
@endsection
