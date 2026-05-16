@extends('layouts.app')

@section('title', 'Fun Outbound - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION (Consistent with Booking Rafting)
        $heroImage = asset('images/outbond.jpg');
        $heroTitle = 'FUN OUTBOUND';
        $heroSubtitle = 'Bangun Kekompakan, Seru Bareng Team!';
        $heroDescription = 'Game seru & team building untuk family gathering, company outing, dan kebersamaan di alam terbuka Kalisawah Adventure.';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ $heroImage }}" alt="Fun Outbound Kalisawah" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">{{ $heroTitle }}</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">{{ $heroSubtitle }}</h2>
                <p class="text-white/90 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl">
                    {{ $heroDescription }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('booking.outbound') }}" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- INFO PAKET CARD -->
    <div class="mt-12 py-14 px-6 md:px-20 max-w-6xl mx-auto">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 lg:p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                
                <!-- Info Kegiatan -->
                <div class="flex items-start gap-5 pt-4 md:pt-0">
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Info Kegiatan</h4>
                        <div class="font-bold text-dark-navy text-lg">Min. 20 Pax</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Team Building & Fun Game</div>
                    </div>
                </div>

                <!-- Operasional -->
                <div class="flex items-start gap-5 pt-6 md:pt-0 md:pl-12">
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Operasional</h4>
                        <div class="font-bold text-dark-navy text-lg">Setiap Hari <span class="text-sm font-medium text-gray-500">(By Booking)</span></div>
                        <div class="text-sm text-gray-500 font-medium mt-1">08.00 – 17.00 WIB</div>
                    </div>
                </div>

                <!-- Harga -->
                <div class="flex items-start gap-5 pt-6 md:pt-0 md:pl-12">
                    <div class="w-12 h-12 bg-yellow-50 text-secondary rounded-xl flex items-center justify-center shrink-0 text-xl">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Harga Per Orang</h4>
                        <div class="font-black text-secondary text-3xl md:text-4xl tracking-tight mt-1">110K <span class="text-lg text-gray-500 font-bold">/ PAX</span></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FASILITAS UMUM SECTION -->
    <section class="py-16 px-6 md:px-20 bg-light-gray">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-dark-navy">Fasilitas</h2>
                <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $fasilitas = [
                        ['icon' => 'fa-ticket', 'label' => 'Tiket Masuk'],
                        ['icon' => 'fa-cookie', 'label' => 'Snack & Teh'],
                        ['icon' => 'fa-bottle-water', 'label' => 'Air Mineral'],
                        ['icon' => 'fa-user-tie', 'label' => 'Fasilitator'],
                        ['icon' => 'fa-helmet-safety', 'label' => 'Peralatan Outbound'],
                        ['icon' => 'fa-hand-holding-dollar', 'label' => 'Service Charge'],
                        ['icon' => 'fa-volume-high', 'label' => 'Sound System'],
                        ['icon' => 'fa-microphone', 'label' => 'Panggung'],
                        ['icon' => 'fa-house', 'label' => 'Aula / Mushola'],
                        ['icon' => 'fa-bath', 'label' => 'Kamar Mandi'],
                        ['icon' => 'fa-wifi', 'label' => 'Free WiFi'],
                        ['icon' => 'fa-square-parking', 'label' => 'Free Parkir'],
                    ];
                @endphp

                @foreach($fasilitas as $item)
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                            <i class="fa-solid {{ $item['icon'] }}"></i>
                        </div>
                        <span class="font-bold text-dark-navy text-sm text-center">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
            
            <p class="text-center text-gray-500 text-sm mt-8">Fasilitas di atas tersedia untuk semua pemesan paket outbound.</p>
        </div>
    </section>

    <style>
        .font-script {
            font-family: 'Pacifico', cursive;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection