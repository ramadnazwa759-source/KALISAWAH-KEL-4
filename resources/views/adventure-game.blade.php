@extends('layouts.app')

@section('title', 'Adventure Game - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION
        $heroImage = (isset($hero->image) && $hero->image) ? asset('storage/' . $hero->image) : asset('images/outbond.jpg');
        $heroTitle = $hero->title ?? 'ADVENTURE GAME';
        $heroSubtitle = $hero->subtitle ?? 'Asah Ketepatan & Fokusmu!';
        $heroDescription = $hero->description ?? null;
        $heroButtonText = $hero->button_text ?? 'Lihat Paket Adventure';
        $heroButtonLink = $hero->button_link ?? '#paket-adventure';
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
                            <span class="font-bold tracking-wide text-sm md:text-base uppercase">Melatih Fokus & Konsentrasi Tinggi</span>
                        </div>
                        <div class="flex items-center gap-3 text-white/90">
                            <i class="fa-solid fa-circle-check text-secondary"></i>
                            <span class="font-bold tracking-wide text-sm md:text-base uppercase">Peralatan Aman & Standar Olahraga</span>
                        </div>
                        <div class="flex items-center gap-3 text-white/90">
                            <i class="fa-solid fa-circle-check text-secondary"></i>
                            <span class="font-bold tracking-wide text-sm md:text-base uppercase">Instruktur yang Ramah & Berpengalaman</span>
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

    <!-- PILIHAN PAKET ADVENTURE -->
    <section id="paket-adventure" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan <span class="text-secondary">Paket Adventure</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-gray-500 font-medium">Pilih tantangan ketangkasanmu dan rasakan keseruan membidik sasaran.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto justify-center">
            
            @foreach($pakets as $paket)
            <!-- Card: {{ $paket->nama_paket }} -->
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                <div class="relative h-64 overflow-hidden shrink-0">
                    <img src="{{ $paket->gambar ?? 'https://images.unsplash.com/photo-1595590424283-b8f17842773f?q=80&w=600&auto=format&fit=crop' }}" onerror="this.src='{{ asset('images/outbond.jpg') }}'" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-6 left-6">
                        <span class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                            {{ str_contains(strtolower($paket->nama_paket), 'panahan') ? 'Fokus & Ketenangan' : 'Uji Akurasi' }}
                        </span>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">{{ $paket->nama_paket }}</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid {{ str_contains(strtolower($paket->nama_paket), 'panahan') ? 'fa-bullseye' : 'fa-crosshairs' }}"></i>
                            <span>{{ str_contains(strtolower($paket->nama_paket), 'panahan') ? 'Fokus & Ketenangan' : 'Akurasi & Konsentrasi' }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Detail Paket
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                @php
                                    $deskripsiItems = explode("\n", $paket->deskripsi);
                                @endphp
                                @foreach($deskripsiItems as $item)
                                    @if(trim($item))
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                        <span>{!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $item) !!}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">
                                {{ str_contains(strtolower($paket->nama_paket), 'panahan') ? 'Per Paket (10 Anak Panah)' : 'Per Paket (5 Peluru)' }}
                            </span>
                        </div>
                        <a href="{{ route('booking-adventure-game', ['paket' => $paket->nama_paket]) }}" class="w-full bg-secondary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-yellow-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/40 transition-all duration-300 active:scale-[0.97] shadow-lg shadow-yellow-500/20 cursor-pointer">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

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
                        ['icon' => 'fa-bullseye', 'label' => 'Target & Safety gear'],
                        ['icon' => 'fa-user-tie', 'label' => 'Instruktur Berpengalaman'],
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
            
            <p class="text-center text-gray-500 text-sm mt-12">Fasilitas di atas tersedia untuk semua pengunjung / pemesan paket shooting target & panahan.</p>
        </div>
    </section>

    <!-- SECTION: KETENTUAN & INFO BOOKING -->
    <section class="py-24 md:py-32 px-6 md:px-20 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16 items-stretch">
                <!-- KETENTUAN ADVENTURE GAME -->
                <div class="bg-white p-8 md:p-12 rounded-[40px] border border-gray-100 shadow-xl shadow-gray-200/50 h-full flex flex-col">
                    <h3 class="text-xl md:text-2xl font-bold text-dark-navy mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-secondary text-3xl"></i>
                        Ketentuan Adventure Game
                    </h3>
                    <ul class="space-y-5 flex-grow">
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Minimal usia peserta adalah <strong>7 tahun</strong> demi keamanan.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Wajib mematuhi instruksi instruktur selama membidik / menembak.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Dilarang mengarahkan busur / senapan ke arah selain sasaran target.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Peralatan yang rusak akibat kelalaian peserta wajib diganti.</span>
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
                            <span class="font-medium text-sm md:text-base leading-relaxed">Bisa langsung dipesan di lokasi (Kalisawah Cafe & Resto).</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Untuk rombongan besar, direkomendasikan booking H-1.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Dapatkan harga khusus untuk paket bundle dengan outbound / wargame / camping.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- SPACER DENGAN FOOTER -->
    <div class="pb-36 bg-white"></div>

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
