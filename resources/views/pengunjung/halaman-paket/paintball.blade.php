@extends('layouts.app')

@section('title', 'Wargame Paintball - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ asset('images/wargame1.jpg') }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">PAINT BALL</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Rasakan Sensasi Battle Seru Bersama Tim!</h2>
                <p class="text-white text-lg md:text-xl font-normal mb-10 max-w-lg leading-relaxed">
                    Permainan strategi penuh adrenalin dengan perlengkapan aman dan instruktur profesional.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#paket-paintball" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PAKET PAINTBALL -->
    <section id="paket-paintball" class="py-24 px-6 md:px-20 max-w-7xl mx-auto mt-16 scroll-mt-20">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-dark-navy">Pilihan <span class="text-secondary">Paket Paintball</span></h2>
                <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                <!-- Paket 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 flex flex-col">
                    <div class="relative h-56 overflow-hidden shrink-0">
                        <img src="{{ asset('images/wargame1.jpg') }}" onerror="this.src='https://picsum.photos/600/400?random=1'" alt="Paket 1" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-primary text-xl font-bold mb-2 leading-tight text-center">PAKET - 1</h3>
                        
                        <div class="space-y-4 mb-6 flex-grow mt-4">
                            <div>
                                <h4 class="font-bold text-dark-navy text-sm mb-2"><i class="fa-solid fa-box-open text-secondary mr-2"></i>Detail Paket</h4>
                                <ul class="text-gray-500 text-sm list-disc pl-5 space-y-1">
                                    <li>30 Peluru Paintball</li>
                                    <li>Durasi: 1 Game + 20 Menit</li>
                                    <li>Minimum 4 Peserta</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 mt-auto text-center flex flex-col gap-4">
                            <div>
                                <span class="text-dark-navy font-black text-3xl">Rp 110.000</span> <span class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">/ ORANG</span>
                            </div>
                            <a href="{{ url('booking-paintball') }}" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-yellow-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/40 transition-all duration-300 active:scale-95 shadow-lg shadow-yellow-500/20 cursor-pointer">
                                Pesan Sekarang
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Paket 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 flex flex-col">
                    <div class="relative h-56 overflow-hidden shrink-0">
                        <img src="{{ asset('images/paintball.jpg') }}" onerror="this.src='https://picsum.photos/600/400?random=2'" alt="Paket 2" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-primary text-xl font-bold mb-2 leading-tight text-center">PAKET - 2</h3>
                        
                        <div class="space-y-4 mb-6 flex-grow mt-4">
                            <div>
                                <h4 class="font-bold text-dark-navy text-sm mb-2"><i class="fa-solid fa-box-open text-secondary mr-2"></i>Detail Paket</h4>
                                <ul class="text-gray-500 text-sm list-disc pl-5 space-y-1">
                                    <li>40 Peluru Paintball</li>
                                    <li>Durasi: 1 Game + 20 Menit</li>
                                    <li>Minimum 4 Peserta</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 mt-auto text-center flex flex-col gap-4">
                            <div>
                                <span class="text-dark-navy font-black text-3xl">Rp 140.000</span> <span class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">/ ORANG</span>
                            </div>
                            <a href="{{ url('booking-paintball') }}" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-yellow-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/40 transition-all duration-300 active:scale-95 shadow-lg shadow-yellow-500/20 cursor-pointer">
                                Pesan Sekarang
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: FASILITAS UMUM -->
    <section class="py-24 md:py-32 px-6 md:px-20 bg-light-gray">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-dark-navy uppercase tracking-tight">Fasilitas Umum</h2>
                <div class="w-20 h-1.5 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $fasilitas = [
                        ['icon' => 'fa-user-tie', 'label' => 'Guide'],
                        ['icon' => 'fa-helmet-safety', 'label' => 'Helm'],
                        ['icon' => 'fa-map-location-dot', 'label' => 'Area Battle'],
                        ['icon' => 'fa-vest', 'label' => 'Rompi'],
                        ['icon' => 'fa-gun', 'label' => 'Ram/Borbomer'],
                        ['icon' => 'fa-shield', 'label' => 'Protector'],
                        ['icon' => 'fa-truck-medical', 'label' => 'Team Rescue'],
                        ['icon' => 'fa-ticket', 'label' => 'Tiket'],
                        ['icon' => 'fa-bottle-water', 'label' => 'Air Mineral'],
                    ];
                @endphp

                @foreach($fasilitas as $item)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-4 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-soft-blue text-primary rounded-2xl flex items-center justify-center text-2xl">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center uppercase tracking-wide">{{ $item['label'] }}</span>
                </div>
                @endforeach
            </div>
            
            <p class="text-center text-gray-500 text-sm mt-12">Fasilitas di atas tersedia untuk semua pengunjung / pemesan paket paintball.</p>
        </div>
    </section>

    <!-- OPERASIONAL SECTION -->
    <section class="py-24 px-6 md:px-20 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- KIRI: Jam Operasional Card -->
                <div class="bg-white p-8 rounded-[32px] shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-6">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl shrink-0">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">SETIAP HARI OPEN BOOKING</h4>
                        <div class="text-2xl md:text-3xl font-black text-dark-navy">08.00 - 17.00 WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection