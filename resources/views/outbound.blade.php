@extends('layouts.app')

@section('title', 'Fun Outbound - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION
        $heroImage = (isset($hero->image) && $hero->image) ? asset('storage/' . $hero->image) : asset('images/outbond.jpg');
        $heroTitle = $hero->title ?? 'FUN OUTBOUND';
        $heroSubtitle = $hero->subtitle ?? 'Bangun Kekompakan, Seru Bareng Team!';
        $heroDescription = $hero->description ?? 'Game seru & team building untuk family gathering, company outing, dan kebersamaan di alam terbuka Kalisawah Adventure.';
        $heroButtonText = $hero->button_text ?? 'Pesan Sekarang';
        $heroButtonLink = $hero->button_link ?? route('booking.outbound');
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ $heroImage }}" alt="{{ $heroTitle }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">{{ $heroTitle }}</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">{{ $heroSubtitle }}</h2>
                <p class="text-white/90 text-sm md:text-base font-bold tracking-wide mb-10 leading-relaxed max-w-xl">
                    {{ $heroDescription }}
                </p>
                <div class="flex flex-wrap gap-4">
                    @php
                        $hasPackages = isset($pakets) && count($pakets) > 0;
                        // Determine the final link: if the hero has a custom link, use it, 
                        // but if it's the default booking link, we apply the package check logic.
                        $isDefaultBooking = $heroButtonLink == route('booking.outbound');
                    @endphp
                    
                    <div class="flex flex-col gap-3">
                        <a @if(!$isDefaultBooking || $hasPackages) href="{{ $heroButtonLink }}" @else href="javascript:void(0)" @endif 
                           class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg text-center text-base
                           @if(!$isDefaultBooking || $hasPackages) hover:bg-hover-primary transform hover:-translate-y-1 @else opacity-60 cursor-not-allowed pointer-events-none @endif">
                            {{ $heroButtonText }}
                        </a>
                        
                        @if($isDefaultBooking && !$hasPackages)
                            <p class="text-white/60 text-xs font-medium italic">
                                Silakan tunggu hingga admin menambahkan paket outbound
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PAKET OUTBOUND SECTION -->
    <section id="paket-outbound" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan <span class="text-secondary">Paket Outbound</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-gray-500 font-medium italic">"Building Teamwork, Creating Memories"</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
            @forelse ($pakets ?? [] as $paket)
                <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                    {{-- Image Section --}}
                    <div class="relative h-64 overflow-hidden shrink-0">
                        <img src="{{ asset($paket->gambar) }}" alt="{{ $paket->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-6 left-6">
                            <span class="bg-primary text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                                Outbound Kalisawah
                            </span>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <div class="mb-6">
                            <h3 class="text-primary text-2xl font-black mb-4 leading-tight uppercase">{{ $paket->nama }}</h3>
                            
                            {{-- Info Row 1: Pax & Duration --}}
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-bold uppercase tracking-widest">
                                    <i class="fa-solid fa-users text-secondary"></i>
                                    <span>Min. {{ $paket->minimal_pax }} Pax</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-bold uppercase tracking-widest">
                                    <i class="fa-regular fa-clock text-secondary"></i>
                                    <span>{{ $paket->durasi }}</span>
                                </div>
                            </div>

                            {{-- Info Row 2: Operational --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    <span>{{ $paket->operasional }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                    <i class="fa-solid fa-clock"></i>
                                    <span>{{ $paket->jam }}</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Facilities --}}
                        <div class="space-y-5 mb-8 flex-grow">
                            <div>
                                <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                    Fasilitas Include
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

                        {{-- Price & Button --}}
                        <div class="pt-6 border-t border-gray-100 mt-auto">
                            <div class="flex flex-col mb-6">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-dark-navy font-black text-3xl">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                    <span class="text-gray-400 text-sm font-bold uppercase">/ Pax</span>
                                </div>
                            </div>
                            <a href="{{ route('booking.outbound', $paket->slug) }}" class="w-full bg-primary text-white py-3 rounded-xl font-bold text-base uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-hover-primary transition-all active:scale-[0.98] shadow-lg shadow-primary/10">
                                Pesan Sekarang
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="col-span-full py-20 text-center bg-white rounded-[40px] border-2 border-dashed border-gray-100 shadow-sm">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-mountain-sun text-gray-200 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400 uppercase tracking-widest">Paket outbound belum tersedia</h3>
                    <p class="text-gray-400 mt-2 font-medium">Tim admin kami sedang menyiapkan paket seru untuk Anda.</p>
                </div>
            @endforelse
        </div>
    </section>

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