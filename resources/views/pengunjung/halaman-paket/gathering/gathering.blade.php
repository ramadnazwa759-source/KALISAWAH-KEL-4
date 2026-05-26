@extends('layouts.app')

@section('title', 'Gathering & Team Building - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION (Consistent with Booking Rafting/Outbound)
        $heroImage = asset('images/outbond.jpg');
        $heroTitle = 'GATHERING & TEAM BUILDING';
        $heroSubtitle = 'Tingkatkan Kekompakan Tim Anda!';
        $heroDescription = 'Program khusus untuk corporate gathering, family outing, dan team building yang dirancang seru dan bermakna di alam terbuka Kalisawah Adventure.';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ $heroImage }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Gathering Kalisawah" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl animate-fade-in">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">{{ $heroTitle }}</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">{{ $heroSubtitle }}</h2>
                <p class="text-white/90 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl">
                    {{ $heroDescription }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#paket-gathering" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- INFO PAKET CARD (GATHERING) -->
    <div id="paket-gathering" class="mt-12 py-14 px-6 md:px-20 max-w-6xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan Paket <span class="text-secondary">Gathering</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14 max-w-5xl mx-auto">
            
            <!-- PAKET 1 -->
            <div class="bg-white rounded-[32px] shadow-2xl border border-gray-100 p-10 flex flex-col group hover:-translate-y-2 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] transition-all duration-300 relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-secondary/5 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex-grow relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black text-dark-navy uppercase tracking-tight mb-6">Paket 1 Day Adventure</h3>
                    <p class="text-gray-500 font-medium leading-relaxed mb-8 text-lg">
                        Program gathering seru selama satu hari penuh. Diisi dengan berbagai aktivitas team building, fun games, dan interaksi di alam terbuka yang dirancang khusus untuk meningkatkan kekompakan, komunikasi, dan sinergi tim Anda.
                    </p>
                </div>
                <div class="pt-8 border-t border-gray-100 mt-auto relative z-10">
                    <a href="{{ url('/gathering/1day') }}" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-base uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/30">
                        Pesan Sekarang
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- PAKET 2 -->
            <div class="bg-white rounded-[32px] shadow-2xl border border-gray-100 p-10 flex flex-col group hover:-translate-y-2 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] transition-all duration-300 relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-secondary/5 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex-grow relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black text-dark-navy uppercase tracking-tight mb-6">Paket 2D1N</h3>
                    <p class="text-gray-500 font-medium leading-relaxed mb-8 text-lg">
                        Paket gathering menginap 2 Hari 1 Malam. Nikmati kebersamaan ekstra dengan program malam keakraban, api unggun, dan dilanjutkan dengan aktivitas team building di hari berikutnya untuk pengalaman yang tak terlupakan.
                    </p>
                </div>
                <div class="pt-8 border-t border-gray-100 mt-auto relative z-10">
                    <a href="{{ url('/gathering/2d1n') }}" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-base uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/30">
                        Pesan Sekarang
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- KEUNGGULAN SECTION -->
    <section class="py-24 md:py-32 px-6 md:px-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 md:mb-24">
                <h2 class="text-3xl md:text-4xl font-bold text-dark-navy">Keunggulan <span class="text-secondary">Kalisawah</span></h2>
                <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <!-- Benefit 1 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">FASILITATOR PROFESIONAL</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Pendamping berpengalaman yang memastikan setiap aktivitas berjalan terarah dan optimal</p>
                </div>
                
                <!-- Benefit 2 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">AMAN & NYAMAN</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Pendampingan instruktur berpengalaman prosedur yang terkontrol</p>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">ALAM ASERI & EKSLUSIF</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Lokasi privat di tengah alam Songgon Banyuwangi yang asri & nyaman</p>
                </div>

                <!-- Benefit 4 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">PROGRAM TERARAHAN</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Setiap sesi memiliki tujuan jelas untuk hasil yang terukur dan relevan</p>
                </div>

                <!-- Benefit 5 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">MEMBANGUN KEKOMPAKAN</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Program dirancang untuk memperkuat kolaborasi tim komunikasi, dan kepercayaan tim</p>
                </div>

                <!-- Benefit 6 -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-face-smile"></i>
                    </div>
                    <h4 class="font-bold text-dark-navy text-lg uppercase tracking-wide">FUN & BERKESAN</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed">Pengalaman yang menyenangkan kesan mendalam dan nilai yang terasa setelah kegiatan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FASILITAS UMUM SECTION -->
    <section class="py-24 md:py-32 px-6 md:px-20 bg-light-gray">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16 md:mb-24">
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
                        ['icon' => 'fa-helmet-safety', 'label' => 'Peralatan'],
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
            
            <p class="text-center text-gray-500 text-sm mt-8">Fasilitas di atas tersedia untuk semua pemesan paket gathering & team building.</p>
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
