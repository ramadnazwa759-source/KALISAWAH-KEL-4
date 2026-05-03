@extends('layouts.app')

@section('title', 'Beranda - Kalisawah Adventure Banyuwangi')

@section('content')
    <!-- SECTION 1: HERO CAROUSEL -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <div class="swiper heroSwiper h-full w-full">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide relative">
                    <img src="https://picsum.photos/id/1015/1920/1080" alt="Hero 1" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
                    <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto">
                        <div class="max-w-2xl">
                            <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2">Rafting & Outbound</h1>
                            <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Seru di Banyuwangi</h2>
                            <p class="text-white text-lg md:text-xl font-normal mb-10 max-w-lg leading-relaxed">
                                Rasakan pengalaman tak terlupakan di Kali Sawah Adventure, menyatu dengan alam yang asri.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">Lihat Paket</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide relative">
                    <img src="https://picsum.photos/id/1016/1920/1080" alt="Hero 2" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
                    <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto">
                        <div class="max-w-2xl">
                            <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2">Camping Seru</h1>
                            <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Bernapas Bersama Alam</h2>
                            <p class="text-white text-lg md:text-xl font-normal mb-10 max-w-lg leading-relaxed">
                                Nikmati malam bertabur bintang di area camping eksklusif Kalisawah Adventure.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">Lihat Paket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Swiper Navigation -->
            <div class="swiper-button-next !text-white !w-12 !h-12 after:!text-2xl hidden md:flex"></div>
            <div class="swiper-button-prev !text-white !w-12 !h-12 after:!text-2xl hidden md:flex"></div>
            <div class="swiper-pagination !bottom-10"></div>
        </div>
    </section>

    <!-- SECTION 2: TRUST SIGNAL -->
    <section class="relative z-20 -mt-16 md:-mt-24 px-6 md:px-20 max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 flex flex-col items-center">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-10 text-dark-navy">
                Kenapa Memilih <span class="text-secondary underline decoration-primary decoration-4 underline-offset-8">Kalisawah Adventure?</span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 w-full">
                <!-- Card 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mb-4 text-secondary text-2xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold text-primary block">20.000+</span>
                    <span class="text-gray-500 text-sm font-semibold">Peserta</span>
                </div>
                <!-- Card 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 text-primary text-2xl">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold text-primary block">500+</span>
                    <span class="text-gray-500 text-sm font-semibold text-wrap">Corporate & Komunitas</span>
                </div>
                <!-- Card 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mb-4 text-secondary text-2xl">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold text-primary block">300+</span>
                    <span class="text-gray-500 text-sm font-semibold text-wrap">Sekolah / Kampus</span>
                </div>
                <!-- Card 4 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 text-primary text-2xl">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold text-primary block">10+</span>
                    <span class="text-gray-500 text-sm font-semibold">Tahun Pengalaman</span>
                </div>
                <!-- Card 5 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-4 text-green-500 text-2xl">
                        <i class="fa-brands fa-google"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-bold text-primary block">4.9 <i class="fa-solid fa-star text-secondary text-sm"></i></span>
                    <span class="text-gray-500 text-sm font-semibold">(1.200+ review)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: KENALAN DENGAN KALISAWAH -->
    <section class="py-24 px-6 md:px-20 bg-soft-blue mt-12 overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            <!-- Left: Image -->
            <div class="w-full lg:w-1/2 relative">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-secondary/20 rounded-full -z-10 animate-pulse"></div>
                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-primary/10 rounded-full -z-10"></div>
                <img src="https://picsum.photos/id/1018/800/600" alt="Tentang Kalisawah" class="rounded-3xl shadow-2xl w-full object-cover">
            </div>
            <!-- Right: Text -->
            <div class="w-full lg:w-1/2">
                <h3 class="text-xl font-bold text-primary mb-2">Kenalan dengan <span class="text-secondary">Kalisawah</span></h3>
                <h2 class="text-3xl md:text-4xl font-bold text-dark-navy mb-6 leading-tight">Apa itu Kalisawah Adventure?</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Kalisawah adalah destinasi wisata petualangan alam di Banyuwangi yang menawarkan rafting seru, camping di alam, dan berbagai aktivitas outbound yang dirancang untuk menyatukan Anda dengan alam.
                </p>
                <div class="space-y-4 mb-10">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-primary">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-navy">Menyatu dengan Alam</h4>
                            <p class="text-gray-500 text-sm">Lokasi asri di pinggiran sungai dan sawah.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-primary">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-navy">Seru & Edukatif</h4>
                            <p class="text-gray-500 text-sm">Program outbound yang melatih team building.</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-flex items-center gap-2 text-primary font-bold text-lg hover:gap-4 transition-all">
                    Tentang Kalisawah <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 3.5: PENCARIAN BOOKING (COMPACT OVAL STYLE) -->
    <section id="pencarian-booking" class="py-12 px-6 md:px-20 relative z-30 flex justify-center">
        <div class="w-full max-w-5xl">
            <div class="text-center mb-8">
                <h3 class="text-2xl md:text-3xl font-black text-dark-navy mb-2 tracking-tight">Temukan Data Booking Anda</h3>
                <p class="text-gray-500 font-medium">Masukkan nomor HP, tanggal booking, atau nama.</p>
            </div>

            <div class="bg-white rounded-full shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-gray-100 p-2 md:p-3 flex items-center gap-2 max-w-4xl mx-auto">
                <form id="search-booking-form" action="{{ route('search.results') }}" method="GET" class="flex flex-col md:flex-row items-center w-full">
                    <!-- Field 1: Phone -->
                    <div class="flex-1 px-6 border-r border-gray-100 last:border-0 py-1">
                        <label class="block text-[9px] font-black text-secondary uppercase tracking-widest mb-1">Nomor HP</label>
                        <input type="text" name="phone" id="search-phone" placeholder="0812..." 
                            class="w-full border-none focus:ring-0 p-0 font-bold text-dark-navy placeholder:text-gray-300 outline-none bg-transparent text-sm">
                    </div>

                    <!-- Field 2: Date -->
                    <div class="flex-1 px-6 border-r border-gray-100 last:border-0 py-1">
                        <label class="block text-[9px] font-black text-secondary uppercase tracking-widest mb-1">Tanggal</label>
                        <input type="date" name="date" id="search-date" 
                            class="w-full border-none focus:ring-0 p-0 font-bold text-dark-navy text-xs outline-none bg-transparent">
                    </div>

                    <!-- Field 3: Name -->
                    <div class="flex-1 px-6 border-r border-gray-100 last:border-0 py-1">
                        <label class="block text-[9px] font-black text-secondary uppercase tracking-widest mb-1">Nama</label>
                        <input type="text" name="name" id="search-name" placeholder="Budi..." 
                            class="w-full border-none focus:ring-0 p-0 font-bold text-dark-navy placeholder:text-gray-300 outline-none bg-transparent text-sm">
                    </div>

                    <!-- Compact Button -->
                    <div class="px-4 shrink-0">
                        <button type="submit" class="h-[45px] px-8 bg-primary text-white rounded-full font-bold text-sm shadow-md hover:bg-hover-primary transition-all active:scale-[0.95] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('search-booking-form').addEventListener('submit', function(e) {
            const phone = document.getElementById('search-phone').value;
            const date = document.getElementById('search-date').value;
            const name = document.getElementById('search-name').value;

            if (!phone && !date && !name) {
                e.preventDefault();
                alert('Silakan isi minimal satu kolom untuk mencari data booking Anda.');
            }
        });
    </script>



    <!-- SECTION 4: PILIH PAKET SERU KAMU -->
    <section class="py-24 px-6 md:px-20 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy">Pilih Paket <span class="text-secondary">Seru Kamu</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $pakets = [
                    ['Rafting Banyuwangi', 'Sensasi arung jeram seru & menantang di Sungai Banyuwangi', 'id/1019'],
                    ['Outbound Banyuwangi', 'Kegiatan outbound seru untuk kerja sama tim & pengembangan diri', 'id/1020'],
                    ['Camping Banyuwangi', 'Pengalaman camping seru di alam bebas dengan fasilitas lengkap', 'id/1021'],
                    ['Gathering & Team Building', 'Acara gathering seru & menyenangkan untuk perusahaan dan komunitas', 'id/1022'],
                    ['Wargame Paintball', 'Permainan paintball seru dan menegangkan di alam terbuka', 'id/1023'],
                    ['Jeep Tour Banyuwangi', 'Jelajahi keindahan Banyuwangi dengan jeep offroad', 'id/1024'],
                    ['Villa & Menginap', 'Nikmati penginapan nyaman di tengah alam Banyuwangi', 'id/1025'],
                    ['Adventure Game', 'Panahan, shooting target, dan permainan seru lainnya', 'id/1026'],
                ];
            @endphp
            @foreach($pakets as $paket)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl transition-all hover:-translate-y-2">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://picsum.photos/{{ $paket[2] }}/600/400" alt="{{ $paket[0] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-primary text-xl font-bold mb-3 leading-tight group-hover:text-hover-primary transition-colors">{{ $paket[0] }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $paket[1] }}</p>
                    @php
                        $route = '#';
                        if ($paket[0] == 'Camping Banyuwangi') {
                            $route = route('camping');
                        }
                    @endphp
                    <a href="{{ $route }}" class="block w-full text-center bg-secondary text-white py-3 rounded-xl font-bold shadow-md hover:bg-secondary/90 transition-all">Lihat Detail <i class="fa-solid fa-chevron-right ml-1 text-xs"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- SECTION 5: LOGO CAROUSEL -->
    <section class="py-20 bg-light-gray overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-20 mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-dark-navy">
                Yang Sudah Seru di <span class="text-secondary">Kalisawah</span>
            </h2>
        </div>
        
        <!-- Corporate Loop -->
        <div class="flex flex-col gap-12">
            <div class="flex overflow-hidden group">
                <div class="flex animate-loop-scroll group-hover:paused space-x-16 items-center">
                    @for($i=1; $i<=8; $i++)
                        <img src="https://via.placeholder.com/150x80?text=Corporate+{{$i}}" alt="Client" class="max-w-none grayscale hover:grayscale-0 transition-all opacity-50 hover:opacity-100 h-12">
                    @endfor
                </div>
                <!-- Duplicate for infinite effect -->
                <div class="flex animate-loop-scroll group-hover:paused space-x-16 items-center ml-16" aria-hidden="true">
                    @for($i=1; $i<=8; $i++)
                        <img src="https://via.placeholder.com/150x80?text=Corporate+{{$i}}" alt="Client" class="max-w-none grayscale hover:grayscale-0 transition-all opacity-50 hover:opacity-100 h-12">
                    @endfor
                </div>
            </div>

            <!-- Schools Loop -->
            <div class="flex overflow-hidden group">
                <div class="flex animate-loop-scroll-reverse group-hover:paused space-x-16 items-center">
                    @for($i=1; $i<=8; $i++)
                        <img src="https://via.placeholder.com/150x80?text=School+{{$i}}" alt="Client" class="max-w-none grayscale hover:grayscale-0 transition-all opacity-50 hover:opacity-100 h-12">
                    @endfor
                </div>
                <div class="flex animate-loop-scroll-reverse group-hover:paused space-x-16 items-center ml-16" aria-hidden="true">
                    @for($i=1; $i<=8; $i++)
                        <img src="https://via.placeholder.com/150x80?text=School+{{$i}}" alt="Client" class="max-w-none grayscale hover:grayscale-0 transition-all opacity-50 hover:opacity-100 h-12">
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: CERITA SERU DI KALISAWAH (Blog) -->
    <section class="py-24 px-6 md:px-20 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div>
                <h2 class="text-3xl md:text-5xl font-bold text-dark-navy mb-4">Cerita Seru di <span class="text-secondary">Kalisawah</span></h2>
                <p class="text-gray-500 font-medium italic">Dokumentasi kegiatan seru dari berbagai perusahaan, sekolah, dan komunitas</p>
            </div>
            <a href="#" class="bg-soft-blue text-primary px-6 py-3 rounded-full font-bold hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                Lihat Semua Cerita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @for($i=1; $i<=3; $i++)
            <article class="bg-white rounded-3xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl transition-all flex flex-col h-full">
                <div class="relative h-64">
                    <span class="absolute top-4 left-4 z-10 bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">Corporate</span>
                    <img src="https://picsum.photos/id/{{ 1030 + $i }}/800/600" alt="Blog" class="w-full h-full object-cover">
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center gap-3 text-gray-400 text-xs font-semibold mb-4">
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-calendar"></i> 24 April 2025</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot"></i> Banyuwangi</span>
                    </div>
                    <h3 class="text-primary text-xl font-bold mb-4 leading-tight">Gathering Seru PT. Pertamina di Kalisawah Adventure</h3>
                    <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                        Mengusung tema "Unity in Adventure", tim Pertamina sukses menggelar kegiatan outbound dan rafting yang luar biasa...
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="text-primary font-bold flex items-center gap-2 hover:gap-4 transition-all">Baca Cerita <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </article>
            @endfor
        </div>
    </section>

    <!-- SECTION 7: KATA MEREKA (Testimoni) -->
    <section class="py-24 px-6 md:px-20 bg-soft-blue">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-dark-navy mb-4">Kata <span class="text-secondary">Mereka</span></h2>
                <p class="text-gray-500 font-medium">Pendapat mereka setelah kegiatan seru bersama Kalisawah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                @php
                    $testis = [
                        ['Taufik Hidayat', 'Pertamina', 'Sangat seru, profesional, dan fasilitas lengkap. Raftingnya benar-benar menantang namun tetap aman bagi pemula.'],
                        ['Annisa Putri', 'Universitas Jember', 'Outboundnya sangat menyenangkan dan penuh tantangan! Tim instruktur ramah dan sangat membantu selama kegiatan.'],
                        ['Andi Prabowo', 'Bank Mandiri', 'Acara team building yang menyenangkan dan terorganisir. Kami mendapatkan banyak pelajaran tentang kerja sama tim.'],
                        ['Siti Rahmawati', 'SMPN 1 Jangkar', 'Belajar sambil bermain di Kalisawah sangat seru! Anak-anak sangat antusias mengikuti setiap sesi kegiatannya.'],
                    ];
                @endphp
                @foreach($testis as $index => $t)
                <div class="bg-white p-8 rounded-3xl shadow-lg relative pt-12">
                    <div class="absolute -top-6 left-8 w-14 h-14 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img src="https://i.pravatar.cc/150?u={{$index}}" alt="User" class="w-full h-full object-cover">
                    </div>
                    <div class="text-secondary text-4xl font-serif absolute top-4 right-8 opacity-20">"</div>
                    <div class="flex gap-1 mb-4">
                        @for($i=0; $i<5; $i++)
                            <i class="fa-solid fa-star text-secondary text-xs"></i>
                        @endfor
                    </div>
                    <p class="text-gray-500 text-sm italic mb-6 leading-relaxed">"{{ $t[2] }}"</p>
                    <div>
                        <h4 class="font-bold text-dark-navy">{{ $t[0] }}</h4>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider">{{ $t[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="#" class="bg-primary text-white px-10 py-4 rounded-xl font-bold shadow-lg hover:bg-hover-primary transition-all">Lihat Semua Testimoni</a>
            </div>
        </div>
    </section>

    <!-- SECTION 8: LOKASI & CTA -->
    <section class="py-24 px-6 md:px-20 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Location -->
            <div>
                <h2 class="text-3xl font-bold text-dark-navy mb-8">Lokasi Kalisawah Adventure</h2>
                <div class="bg-light-gray rounded-3xl overflow-hidden shadow-xl mb-8 relative group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15792.89547514304!2d114.1293375!3d-8.2801456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd153e7f6e3001f%3A0x600c73336d8d6411!2sKali%20Sawah%20Adventure!5e0!3m2!1sid!2sid!4v1714041000000!5m2!1sid!2sid" 
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <i class="fa-solid fa-map-location-dot text-primary text-xl mt-1"></i>
                        <p class="text-gray-600">Jl. Blambangan, Dusun Tegalrejo, Desa Sumbergondo, Kecamatan Glenmore, Banyuwangi</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-soft-blue p-4 rounded-2xl flex items-center gap-3">
                            <i class="fa-solid fa-train text-primary"></i>
                            <span class="text-sm font-semibold text-dark-navy">20 menit dari Stasiun Karangasem</span>
                        </div>
                        <div class="bg-soft-blue p-4 rounded-2xl flex items-center gap-3">
                            <i class="fa-solid fa-plane text-primary"></i>
                            <span class="text-sm font-semibold text-dark-navy">25 menit dari Bandara Banyuwangi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Banner -->
            <div class="relative rounded-3xl overflow-hidden p-10 md:p-16 text-center text-white min-h-[500px] flex flex-col justify-center items-center shadow-2xl">
                <img src="https://picsum.photos/id/1039/1200/800" alt="CTA" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-bold mb-6">Siap Seru Bareng Kalisawah?</h2>
                    <p class="text-lg md:text-xl opacity-90 mb-10 max-w-md mx-auto">Hubungi kami sekarang untuk booking paket seru di Kalisawah Adventure!</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#" class="bg-secondary hover:bg-secondary/90 text-dark-navy px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg transition-all transform hover:-translate-y-1">
                            <i class="fa-solid fa-calendar-check text-xl"></i> Booking Sekarang
                        </a>
                    </div>
                    <p class="mt-10 text-sm font-medium opacity-80 italic">"Hanya 30 menit dari pusat kota Banyuwangi"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SWIPER INITIALIZATION -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.heroSwiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
            });
        });
    </script>

    <!-- CUSTOM ANIMATION STYLES -->
    <style>
        @keyframes loop-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
        @keyframes loop-scroll-reverse {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        .animate-loop-scroll {
            animation: loop-scroll 30s linear infinite;
        }
        .animate-loop-scroll-reverse {
            animation: loop-scroll-reverse 30s linear infinite;
        }
        .paused {
            animation-play-state: paused;
        }
    </style>
@endsection