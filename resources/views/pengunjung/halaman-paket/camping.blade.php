@extends('layouts.app')

@section('title', 'Family & Adventure Camping - Kalisawah Adventure')

@section('content')
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ asset('images/camping-hero.jpg') }}" alt="Kalisawah Camping Ground" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2 uppercase">Camping Ground</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Malam Penuh Bintang!</h2>
                
                <div class="space-y-3 mb-10">
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Suasana Asri Tepi Aliran Sungai</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Keamanan Terjamin & Crew Siaga 24 Jam</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <i class="fa-solid fa-circle-check text-secondary"></i>
                        <span class="font-bold tracking-wide text-sm md:text-base uppercase">Peralatan Camp Berkualitas & Bersih</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="#pilihan-paket" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Pilihan Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="pilihan-paket" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy uppercase tracking-tight">Pilihan <span class="text-secondary">Paket Camping</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-gray-500 font-medium">Temukan paket berkemah terbaik yang sesuai dengan kebutuhan liburanmu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center items-stretch">
            
            @forelse($pakets as $paket)
            <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border border-gray-100 flex flex-col group hover:shadow-2xl transition-all duration-300">
                
                <div class="relative h-64 overflow-hidden shrink-0">
                    @if($paket->foto)
                        <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <img src="{{ asset('images/default-camping.jpg') }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @endif
                    
                    @if($paket->label_promo)
                    <div class="absolute top-6 left-6">
                        <span class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                            {{ $paket->label_promo }}
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-6">
                        <h3 class="text-primary text-2xl font-black mb-2 leading-tight uppercase">{{ $paket->nama_paket }}</h3>
                        <div class="flex items-center gap-2 text-gray-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-users"></i>
                            <span>Kapasitas Min. {{ $paket->minimal_peserta ?? '2' }} Orang</span>
                            <span class="mx-1">•</span>
                            <i class="fa-regular fa-moon"></i>
                            <span>{{ $paket->durasi ?? '2 Hari 1 Malam' }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="font-black text-dark-navy text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-secondary rounded-full"></span>
                                Fasilitas Termasuk
                            </h4>
                            <ul class="text-gray-500 text-sm font-medium space-y-2.5">
                                @if($paket->fasilitas_list)
                                    {{-- Asumsi data fasilitas disimpan dalam bentuk array/JSON atau string text dipisah koma --}}
                                    @foreach(explode(',', $paket->fasilitas_list) as $fasilitasItem)
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                        <span>{{ trim($fasilitasItem) }}</span>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                        <span>Tenda Dome Standard & Matras</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-check text-green-500 mt-1"></i>
                                        <span>Akses Kamar Mandi & Listrik Camp</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 mt-auto">
                        <div class="flex flex-col mb-6">
                            <span class="text-dark-navy font-black text-3xl">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Per Paket / Orang</span>
                        </div>
                        <a href="{{ route('booking.camping') }}?paket={{ $paket->slug ?? $paket->id }}" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-hover-primary transition-all active:scale-[0.98]">
                            Pesan Sekarang
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-3 text-center py-12">
                <div class="text-gray-300 text-6xl mb-4">
                    <i class="fa-solid fa-tent-arrows-down"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-navy">Belum Ada Paket Tersedia</h3>
                <p class="text-gray-400 text-sm mt-1">Silakan hubungi administrator atau kembali dalam beberapa saat lagi.</p>
            </div>
            @endforelse

        </div>
    </section>

    <section class="py-24 md:py-32 px-6 md:px-20 bg-light-gray">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-dark-navy uppercase tracking-tight">Fasilitas Umum Area</h2>
                <div class="w-20 h-1.5 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $fasilitasUmum = [
                        ['icon' => 'fa-square-parking', 'label' => 'Parkir Luas'],
                        ['icon' => 'fa-mosque', 'label' => 'Mushola'],
                        ['icon' => 'fa-bath', 'label' => 'Kamar Mandi Bersih'],
                        ['icon' => 'fa-fire', 'label' => 'Spot Api Unggun'],
                        ['icon' => 'fa-plug', 'label' => 'Sumber Listrik'],
                        ['icon' => 'fa-wifi', 'label' => 'Free WiFi Area'],
                        ['icon' => 'fa-shield-halved', 'label' => 'Keamanan 24 Jam'],
                        ['icon' => 'fa-faucet', 'label' => 'Air Bersih Alami'],
                        ['icon' => 'fa-camera', 'label' => 'Spot Foto Keren'],
                        ['icon' => 'fa-kit-medical', 'label' => 'P3K & Safety Crew'],
                    ];
                @endphp

                @foreach($fasilitasUmum as $item)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-4 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-soft-blue text-primary rounded-2xl flex items-center justify-center text-2xl">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center uppercase tracking-wide">{{ $item['label'] }}</span>
                </div>
                @endforeach
            </div>
            
            <p class="text-center text-gray-500 text-sm mt-12">Fasilitas ground camping disediakan sepenuhnya demi kenyamanan bermalam di Kalisawah Adventure.</p>
        </div>
    </section>

    <section class="py-24 md:py-32 px-6 md:px-20 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16 items-stretch">
                <div class="bg-white p-8 md:p-12 rounded-[40px] border border-gray-100 shadow-xl shadow-gray-200/50 h-full flex flex-col">
                    <h3 class="text-xl md:text-2xl font-bold text-dark-navy mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-secondary text-3xl"></i>
                        Ketentuan Camping
                    </h3>
                    <ul class="space-y-5 flex-grow">
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Menjaga kebersihan sekitar tenda dan kavling *camping ground*.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Dilarang merusak vegetasi alam atau menebang pohon sembarangan.</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Dilarang membuat perapian di luar area yang sudah disediakan (*spot* api unggun).</span>
                        </li>
                        <li class="flex gap-4 items-start text-gray-600">
                            <i class="fa-solid fa-check text-green-500 mt-1.5"></i>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Menjaga ketenangan saat jam istirahat malam (mulai pukul 22.00 WIB).</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-primary p-8 md:p-12 rounded-[40px] text-white shadow-2xl shadow-primary/20 h-full relative overflow-hidden flex flex-col">
                    <i class="fa-solid fa-calendar-check absolute -right-12 -bottom-12 text-[250px] text-white/5 rotate-12"></i>
                    
                    <h3 class="text-xl md:text-2xl font-bold mb-8 flex items-center gap-3 relative z-10">
                        <i class="fa-solid fa-calendar-day text-secondary text-3xl"></i>
                        Informasi Reservasi
                    </h3>
                    <ul class="space-y-5 relative z-10 flex-grow">
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Pemesanan tempat terbuka setiap hari.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Reservasi disarankan dilakukan paling lambat H-2 sebelum kedatangan.</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Konfirmasi pesanan dilakukan melalui transfer uang muka (DP).</span>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[12px]"></i>
                            </div>
                            <span class="font-medium text-sm md:text-base leading-relaxed">Pelunasan sisa pembayaran dapat diselesaikan langsung di pos registrasi lokasi.</span>
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