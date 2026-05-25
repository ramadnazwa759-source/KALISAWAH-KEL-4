@extends('layouts.app')

@section('title', 'Fun River Rafting - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION
        $heroImage = (isset($hero->image) && $hero->image) ? asset('storage/' . $hero->image) : asset('images/rafting.jpg');
        $heroTitle = $hero->title ?? 'Fun River Rafting';
        $heroSubtitle = $hero->subtitle ?? 'Tantang Adrenalinmu!';
        $heroDescription = $hero->description ?? null;
        $heroButtonText = $hero->button_text ?? 'Lihat Paket Rafting';
        $heroButtonLink = $hero->button_link ?? '#paket-rafting';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ $heroImage }}" alt="{{ $heroTitle }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">{{ $heroTitle }}</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">{{ $heroSubtitle }}</h2>
                
                <div class="space-y-3 mb-10">
                    @if($heroDescription)
                        <p class="text-white/90 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl">
                            {{ $heroDescription }}
                        </p>
                    @else
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
                    @endif
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ $heroButtonLink }}" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        {{ $heroButtonText }}
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
            @forelse ($pakets ?? [] as $paket)
                @php
                    $isPopular = $paket->is_popular ?? false;
                @endphp
                <div class="bg-white rounded-[32px] overflow-hidden {{ $isPopular ? 'shadow-2xl border-2 border-secondary relative transform md:-translate-y-4' : 'shadow-xl border border-gray-100 hover:shadow-2xl' }} flex flex-col group transition-all duration-300">
                    
                    {{-- Badge Paling Laris --}}
                    @if($isPopular)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
                            <span class="bg-secondary text-white text-xs font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-xl whitespace-nowrap">
                                PALING LARIS
                            </span>
                        </div>
                    @endif

                    <div class="relative h-64 overflow-hidden shrink-0">
                        <img src="{{ asset($paket->gambar) }}" alt="{{ $paket->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        {{-- Badge Custom --}}
                        @if(!$isPopular && ($paket->badge ?? false))
                            <div class="absolute top-6 left-6">
                                <span class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                                    {{ $paket->badge }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 flex flex-col flex-grow {{ $isPopular ? 'bg-secondary/5' : '' }}">
                        <div class="mb-6">
                            <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">{{ $paket->nama }}</h3>
                            <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                                <i class="fa-solid fa-route"></i>
                                <span>Jarak ± {{ $paket->jarak }}</span>
                                <span class="mx-1">•</span>
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $paket->durasi }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-5 mb-8 flex-grow">
                            <div>
                                <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                    Fasilitas
                                </h4>
                                <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                    @if(isset($paket->fasilitas) && (is_array($paket->fasilitas) || is_object($paket->fasilitas)))
                                        @foreach ($paket->fasilitas as $item)
                                            <li class="flex items-start gap-3">
                                                <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                                <span>{{ $item }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="pt-6 border-t {{ $isPopular ? 'border-secondary/20' : 'border-gray-100' }} mt-auto">
                            <div class="flex flex-col mb-6">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-dark-navy font-black text-3xl">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                    @if($paket->harga_coret)
                                        <span class="text-gray-400 line-through text-sm">Rp {{ number_format($paket->harga_coret, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Orang</span>
                            </div>
                            <a href="{{ route('booking.rafting', $paket->slug) }}" class="w-full {{ $isPopular ? 'bg-secondary hover:opacity-90 shadow-lg shadow-secondary/20' : 'bg-primary hover:bg-hover-primary' }} text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 transition-all active:scale-[0.98]">
                                Pesan Sekarang
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-box-open text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400 uppercase tracking-widest">Belum ada paket yang tersedia</h3>
                    <p class="text-gray-400 mt-2 font-medium">Silakan hubungi admin atau cek kembali beberapa saat lagi.</p>
                </div>
            @endforelse
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
                        ['icon' => 'fa-square-parking', 'label' => 'Area Parkir'],
                        ['icon' => 'fa-mosque', 'label' => 'Mushola'],
                        ['icon' => 'fa-bath', 'label' => 'Kamar Mandi'],
                        ['icon' => 'fa-shower', 'label' => 'Ruang Bilas'],
                        ['icon' => 'fa-house', 'label' => 'Aula'],
                        ['icon' => 'fa-wifi', 'label' => 'Free WiFi'],
                        ['icon' => 'fa-couch', 'label' => 'Rest Area'],
                        ['icon' => 'fa-volume-high', 'label' => 'Sound System'],
                        ['icon' => 'fa-camera', 'label' => 'Dokumentasi'],
                        ['icon' => 'fa-user-tie', 'label' => 'Guide Profesional'],
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
            
            <p class="text-center text-gray-500 text-sm mt-12">Fasilitas di atas tersedia untuk semua pengunjung / pemesan paket rafting.</p>
        </div>
    </section>

    <!-- SECTION: KETENTUAN & INFO BOOKING -->
    <section class="py-24 md:py-32 px-6 md:px-20 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16 items-stretch">
                <!-- KETENTUAN RAFTING -->
                <div class="bg-white p-8 md:p-12 rounded-[40px] border border-gray-100 shadow-xl shadow-gray-200/50 h-full flex flex-col">
                    <h3 class="text-xl md:text-2xl font-bold text-dark-navy mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-secondary text-3xl"></i>
                        Ketentuan Rafting
                    </h3>
                    <ul class="space-y-5 flex-grow">
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Minimal usia peserta adalah <strong>5 tahun</strong>.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Wajib menggunakan safety gear selama aktivitas.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Ikuti instruksi guide untuk keselamatan.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Tidak diperbolehkan membuang sampah ke sungai.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Kondisi cuaca dapat mempengaruhi aktivitas (demi keamanan).</span>
                        </li>
                    </ul>
                </div>

                <!-- INFORMASI BOOKING -->
                <div class="bg-primary p-8 md:p-12 rounded-[40px] text-white shadow-2xl shadow-primary/20 h-full relative overflow-hidden flex flex-col">
                    <!-- Decor -->
                    <i class="fa-solid fa-calendar-check absolute -right-12 -bottom-12 text-[250px] text-white/5 rotate-12"></i>
                    
                    <h3 class="text-xl md:text-2xl font-bold mb-8 flex items-center gap-3 relative z-10">
                        <i class="fa-solid fa-calendar-day text-secondary text-3xl"></i>
                        Informasi Booking
                    </h3>
                    <ul class="space-y-5 relative z-10 flex-grow">
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Open booking setiap hari.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Reservasi minimal H-1 sebelum kegiatan.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">DP (Down Payment) diperlukan untuk penguncian jadwal.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Pelunasan dilakukan saat hari kegiatan di lokasi.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Hubungi admin jika ada perubahan jadwal atau pembatalan.</span>
                        </li>
                    </ul>
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