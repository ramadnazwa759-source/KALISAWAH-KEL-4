@extends('layouts.app')

@section('title', 'Paket 1 Day Adventure - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ asset('images/outbond.jpg') }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="1 Day Adventure" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">1 Day Adventure</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Paket Gathering 1 Hari</h2>
                <p class="text-white/90 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl">
                    Program gathering seru selama satu hari penuh. Diisi dengan berbagai aktivitas team building dan interaksi alam untuk sinergi tim yang lebih baik.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#paket-detail" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Pilihan Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PILIHAN PAKET -->
    <section id="paket-detail" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan <span class="text-secondary">Paket 1 Day</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-gray-500 font-medium">Pilih paket petualangan 1 hari penuh untuk kebersamaan tim Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center">
            
            <!-- Card 1: KALISAWAH EXPLORER -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="https://picsum.photos/600/400?random=11" alt="Explorer" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6">
                        <span class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">Premium Corporate</span>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">KALISAWAH EXPLORER</h3>
                        <p class="text-gray-500 text-sm italic mb-3">“Pengalaman lengkap untuk event corporate premium”</p>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-regular fa-clock"></i>
                            <span>Durasi ± 7 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Aktivitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>War Game - Paintball</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Rafting Adventure</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Fun Jeep</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 520.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (Pax)</span>
                        </div>
                        <a href="{{ url('/booking-gathering') }}?paket=Kalisawah%20Explorer&harga=520000" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/20">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: KALISAWAH CHALLENGE (BEST SELLER) -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-2xl border-2 border-secondary flex flex-col group relative transform md:-translate-y-4 transition-all duration-300">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
                    <span class="bg-secondary text-white text-xs font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-xl whitespace-nowrap">BEST SELLER</span>
                </div>
                
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="https://picsum.photos/600/400?random=12" alt="Challenge" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8 flex flex-col flex-grow bg-secondary/5">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">KALISAWAH CHALLENGE</h3>
                        <p class="text-gray-500 text-sm italic mb-3">“Pilihan terbaik untuk membangun kebersamaan tim secara efektif”</p>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-regular fa-clock"></i>
                            <span>Durasi ± 6 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Aktivitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Fun Outbound</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>War Game - Paintball</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Rafting Adventure</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-secondary/20 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 360.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (Pax)</span>
                        </div>
                        <a href="{{ url('/booking-gathering') }}?paket=Kalisawah%20Challenge&harga=360000" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/20">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: KALISAWAH ACTION -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="https://picsum.photos/600/400?random=13" alt="Action" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">KALISAWAH ACTION</h3>
                        <p class="text-gray-500 text-sm italic mb-3">“Paket hemat dengan pengalaman tetap maksimal”</p>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-regular fa-clock"></i>
                            <span>Durasi ± 3.5 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Aktivitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>War Game - Paintball</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Rafting Adventure</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 290.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (Pax)</span>
                        </div>
                        <a href="{{ url('/booking-gathering') }}?paket=Kalisawah%20Action&harga=290000" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/20">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
