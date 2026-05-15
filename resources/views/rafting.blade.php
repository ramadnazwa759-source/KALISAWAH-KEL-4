@extends('layouts.app')

@section('title', 'Fun River Rafting - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ asset('images/rafting.jpg') }}" alt="Fun River Rafting" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">Fun River Rafting</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Tantang Adrenalinmu!</h2>
                
                <div class="space-y-3 mb-10">
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Finish Paling Jauh di Sungai Badeng</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Guide Berpengalaman & Bersertifikat</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Rekomendasi untuk Pencinta Petualangan</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="#paket-rafting" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Paket Rafting
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PILIHAN PAKET RAFTING -->
    <section id="paket-rafting" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan <span class="text-secondary">Paket Rafting</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-gray-500 font-medium">Pilih rute petualanganmu menyusuri derasnya Sungai Badeng.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center">
            
            <!-- Card 1: LONG TRIP -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="{{ asset('images/raft3.jpg') }}" alt="Long Trip Rafting" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6">
                        <span class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">Lebih Aman Lebih Puas</span>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">LONG TRIP</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-route"></i>
                            <span>Jarak ± 6 Km</span>
                            <span class="mx-1">•</span>
                            <i class="fa-regular fa-clock"></i>
                            <span>3 - 3.5 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Fasilitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Tiket masuk wisata & asuransi</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Makan 1x, snack 2x, air mineral</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 250.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (WNA Rp 350.000)</span>
                        </div>
                        <a href="{{ route('booking.rafting') }}?paket=long-trip" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-hover-primary transition-all active:scale-[0.98]">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: ADVENTURE (PALING LARIS) -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-2xl border-2 border-secondary flex flex-col group relative transform md:-translate-y-4 transition-all duration-300">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
                    <span class="bg-secondary text-white text-xs font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-xl whitespace-nowrap">PALING LARIS</span>
                </div>
                
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="{{ asset('images/raft2.jpg') }}" alt="Adventure Rafting" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8 flex flex-col flex-grow bg-secondary/5">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">ADVENTURE</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-route"></i>
                            <span>Jarak ± 4.5 Km</span>
                            <span class="mx-1">•</span>
                            <i class="fa-regular fa-clock"></i>
                            <span>1.5 - 2 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Fasilitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Tiket masuk & asuransi</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Makan 1x, snack 1x, air mineral</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-secondary/20 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 165.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (WNA Rp 250.000)</span>
                        </div>
                        <a href="{{ route('booking.rafting') }}?paket=adventure" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-[0.98] shadow-lg shadow-secondary/20">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: WONDERFUL -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="{{ asset('images/raft1.jpg') }}" alt="Wonderful Rafting" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">WONDERFUL</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-route"></i>
                            <span>Jarak ± 1 Km</span>
                            <span class="mx-1">•</span>
                            <i class="fa-regular fa-clock"></i>
                            <span>1 Jam</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Fasilitas
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Tiket masuk & asuransi</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                    <span>Makan 1x</span>
                                </li>
                                <li class="flex items-start gap-3 italic">
                                    <i class="fa-solid fa-info-circle text-blue-400 mt-1"></i>
                                    <span>Cocok untuk pemula</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp 135.000</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang (WNA Rp 200.000)</span>
                        </div>
                        <a href="{{ route('booking.rafting') }}?paket=wonderful" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-hover-primary transition-all active:scale-[0.98]">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- FASILITAS UMUM & KETENTUAN -->
    <section class="py-24 px-6 md:px-20 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                
                <!-- Fasilitas Umum -->
                <div>
                    <h2 class="text-3xl font-black text-dark-navy uppercase tracking-tight mb-10 flex items-center gap-4">
                        <span class="w-3 h-10 bg-primary rounded-full"></span>
                        Fasilitas Umum
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                        @php
                            $fasilitas = [
                                ['icon' => 'fa-helmet-safety', 'label' => 'Peralatan Lengkap'],
                                ['icon' => 'fa-user-tie', 'label' => 'Guide & Rescue'],
                                ['icon' => 'fa-van-shuttle', 'label' => 'Transport Lokal'],
                                ['icon' => 'fa-lock', 'label' => 'Locker'],
                                ['icon' => 'fa-mosque', 'label' => 'Mushola'],
                                ['icon' => 'fa-bath', 'label' => 'Kamar Mandi'],
                                ['icon' => 'fa-wifi', 'label' => 'Free Wifi'],
                                ['icon' => 'fa-square-parking', 'label' => 'Area Parkir'],
                                ['icon' => 'fa-house', 'label' => 'Aula / Rest Area'],
                            ];
                        @endphp

                        @foreach($fasilitas as $item)
                            <div class="bg-white p-6 rounded-[24px] border border-gray-100 flex flex-col items-center gap-4 shadow-sm hover:shadow-md transition-all">
                                <div class="w-14 h-14 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-2xl">
                                    <i class="fa-solid {{ $item['icon'] }}"></i>
                                </div>
                                <span class="font-bold text-dark-navy text-[11px] uppercase tracking-widest text-center">{{ $item['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Ketentuan & Info -->
                <div class="space-y-8">
                    <!-- Ketentuan -->
                    <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-full -mr-16 -mt-16"></div>
                        
                        <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-secondary text-2xl"></i>
                            Ketentuan Rafting
                        </h3>
                        
                        <ul class="space-y-4">
                            <li class="flex gap-4 items-start">
                                <div class="w-6 h-6 bg-secondary/10 text-secondary rounded-full flex items-center justify-center shrink-0 mt-0.5 font-black text-xs">!</div>
                                <p class="text-gray-500 font-medium text-sm leading-relaxed">Minimal usia peserta adalah <strong>5 tahun</strong>.</p>
                            </li>
                            <li class="flex gap-4 items-start">
                                <div class="w-6 h-6 bg-secondary/10 text-secondary rounded-full flex items-center justify-center shrink-0 mt-0.5 font-black text-xs">!</div>
                                <p class="text-gray-500 font-medium text-sm leading-relaxed">Jadwal keberangkatan menyesuaikan dengan antrean booking.</p>
                            </li>
                            <li class="flex gap-4 items-start mt-6 pt-6 border-t border-gray-100">
                                <span class="text-red-500 font-black uppercase text-[10px] tracking-[0.2em] mt-1">Dilarang bagi:</span>
                            </li>
                            <li class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2 text-gray-400 font-bold text-xs uppercase tracking-wider">
                                    <i class="fa-solid fa-xmark text-red-400"></i>
                                    <span>Ibu Hamil</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400 font-bold text-xs uppercase tracking-wider">
                                    <i class="fa-solid fa-xmark text-red-400"></i>
                                    <span>Penyakit Jantung</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400 font-bold text-xs uppercase tracking-wider">
                                    <i class="fa-solid fa-xmark text-red-400"></i>
                                    <span>Epilepsi</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="bg-primary p-10 rounded-[40px] text-white shadow-xl shadow-primary/20 relative overflow-hidden">
                        <i class="fa-solid fa-clock absolute -right-10 -bottom-10 text-[200px] text-white/5 rotate-12"></i>
                        <h3 class="text-xl font-black uppercase tracking-[0.2em] mb-6">Informasi Booking</h3>
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-white/10 rounded-3xl flex items-center justify-center text-3xl">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-blue-100 font-bold text-xs uppercase tracking-widest mb-1">Jam Operasional Booking</p>
                                <p class="text-3xl font-black tracking-tight">08.00 - 16.00 <span class="text-lg">WIB</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
        .grid > div {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
@endsection