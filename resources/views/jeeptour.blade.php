@extends('layouts.app')

@section('title', 'Fun Jeep Adventure - Kalisawah Adventure')

@section('content')
    @php
        $heroImage = asset('images/outbond.jpg');
        $heroTitle = 'FUN JEEP ADVENTURE';
        $heroSubtitle = 'Relax, Ride, Enjoy the Journey.';
        $heroDescription = 'Jelajahi petualangan seru melintasi jalur offroad menantang dan nikmati keindahan eksotis kaki Gunung Raung bersama Jeep Tour Kalisawah Adventure!';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ $heroImage }}" alt="Fun Jeep Adventure Kalisawah" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-black mb-2 uppercase tracking-tight drop-shadow-2xl">
                    {{ $heroTitle }}
                </h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6 drop-shadow-lg">
                    "{{ $heroSubtitle }}"
                </h2>
                <p class="text-white/95 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl drop-shadow-md">
                    {{ $heroDescription }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#keterangan-paket" 
                       class="bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 active:scale-[0.98] shadow-lg shadow-blue-500/20 uppercase tracking-widest text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT SECTION (PREMIUM TOURISM STYLE) -->
    <section id="keterangan-paket" class="py-28 px-6 md:px-20 bg-[#F8FAFC] relative scroll-mt-20">
        <div class="max-w-5xl mx-auto relative z-10">

            <!-- AESTHETICS DESKRIPSI (CENTERED CONTAINER, LEFT ALIGNED EDITORIAL TEXT) -->
            <div class="max-w-3xl mx-auto mb-24 space-y-12">
                <div class="text-center mb-8">
                    <span class="text-primary text-xs font-black tracking-[0.25em] uppercase bg-blue-50 px-5 py-2 rounded-full border border-blue-100/50">Tentang Perjalanan</span>
                </div>
                
                <div class="space-y-8 text-left">
                    <p class="text-gray-500 font-light text-lg md:text-xl leading-relaxed">
                        Nikmati perjalanan santai menyusuri keindahan alam Songgon, Banyuwangi bersama Jeep Kalisawah. Melintasi hamparan persawahan hijau, kawasan perkebunan yang eksotik, serta jalur pedesaan yang asri hingga menuju air terjun alami yang menyegarkan, setiap perjalanan menghadirkan suasana rileks dan penuh pesona. Perpaduan udara pegunungan yang bersih, nuansa hutan pinus yang sejuk, dan panorama alam yang beragam menjadikan pengalaman ini lebih dari sekadar perjalanan, tetapi momen untuk benar-benar menikmati alam dan kebersamaan.
                    </p>
                    <p class="text-gray-500 font-light text-lg md:text-xl leading-relaxed">
                        Dirancang untuk semua kalangan, program Jeep Kalisawah menawarkan perjalanan yang aman, nyaman, dan menyenangkan dengan didampingi driver dan guide berpengalaman. Rute yang variatif—mulai dari persawahan, perkebunan, hingga destinasi air terjun—memberikan pengalaman yang lengkap tanpa jalur ekstrem, sehingga cocok untuk keluarga, sekolah, hingga kegiatan corporate gathering. Dapat dikombinasikan dengan aktivitas lain seperti rafting, camping, dan outbound, Tour Jeep Kalisawah menjadi pilihan yang cocok untuk melengkapi pengalaman kebersamaan yang lebih berkesan dan tak terlupakan.
                    </p>
                </div>
            </div>

            <!-- GORGEOUS AESTHETIC GRID CARDS (6 INDEPENDENT PREMIUM CARDS) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- 1. DURASI -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Durasi</span>
                            <h3 class="text-2xl font-black text-dark-navy tracking-tight">± 3,5 Menit</h3>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Durasi optimal perjalanan</span>
                </div>

                <!-- 2. KAPASITAS -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Kapasitas</span>
                            <h3 class="text-2xl font-black text-dark-navy tracking-tight">Minimum 5 Orang</h3>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Sangat pas untuk rombongan</span>
                </div>

                <!-- 3. PRICE -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-yellow-50 text-secondary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Price</span>
                            <h3 class="text-3xl font-black text-secondary tracking-tight">Rp. 275 K</h3>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Per orang (PAX) hemat seru</span>
                </div>

                <!-- 4. DESTINASI -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-route"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Destinasi</span>
                            <p class="text-base font-black text-dark-navy leading-relaxed">
                                Tiket Tasinis, Air Telunjuk Raung, Rowo Bayu, Villa Bujeng, GGC
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Jalur wisata terbaik & asri</span>
                </div>

                <!-- 5. PERBEKALAN -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Perbekalan</span>
                            <p class="text-base font-black text-dark-navy leading-relaxed">
                                Makan, Snack, Air Mineral
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Termasuk penuh dalam pemesanan</span>
                </div>

                <!-- 6. AMAN & NYAMAN -->
                <div class="bg-white rounded-[28px] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100/80 p-8 flex flex-col justify-between hover:shadow-[0_25px_50px_rgba(0,0,0,0.07)] hover:-translate-y-1.5 transition-all duration-300 group">
                    <div class="space-y-6">
                        <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-xl shadow-inner transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Aman & Nyaman</span>
                            <p class="text-base font-black text-dark-navy leading-relaxed">
                                Guide & Sopir Berpengalaman
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-6 font-medium block border-t border-gray-50 pt-4">Petualangan terjamin seru & aman</span>
                </div>

            </div>

            <!-- ELEGANT CENTERED CTA BUTTON (SMALL, SHADOW SOFT, HOVER LIFT, SCALE PRESS) -->
            <div class="mt-24 flex justify-center">
                <a href="https://wa.me/6281234567890?text=Halo%20Kalisawah%20Adventure,%20saya%20tertarik%20untuk%20memesan%20paket%20Fun%20Jeep%20Adventure%20Banyuwangi!" 
                   target="_blank"
                   style="background-color: #FFC236;"
                   class="btn-action px-10 py-4 rounded-2xl text-white font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-[#FFD15B] hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/20 active:scale-[0.98] transition-all duration-300 shadow-md shadow-yellow-500/10 cursor-pointer">
                    <span>Pesan Sekarang</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- SPACER DENGAN FOOTER -->
    <div class="pb-36 bg-[#F8FAFC]"></div>

    <style>
        .font-script {
            font-family: 'Pacifico', cursive;
        }
        .btn-action:active {
            transform: scale(0.95);
        }
    </style>
@endsection
