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
                                <a href="{{ route('panduan.booking') }}" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">Panduan Booking</a>
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
                                <a href="{{ route('panduan.booking') }}" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">Panduan Booking</a>
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
    <section id="tentang-kalisawah" class="py-24 px-6 md:px-20 bg-soft-blue mt-12 overflow-hidden scroll-mt-20">
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

    <!-- SECTION 3.5: PENCARIAN BOOKING (PRECISE TRAVEL BAR) -->
    <section id="pencarian-booking" class="py-20 px-6 md:px-20 bg-[#f8f9fb]">
        <div class="max-w-[1100px] mx-auto">
            <!-- Title Section -->
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0057c2] mb-3">Cari Booking Anda</h2>
                <p class="text-gray-500 font-medium">Temukan riwayat pesanan Anda dengan memasukkan data di bawah ini</p>
            </div>

            <!-- Single Elegant Card -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 p-8 md:p-10">
                <form id="search-booking-form" action="{{ route('search.results') }}" method="GET" class="flex flex-col md:flex-row items-end gap-6">
                    
                    <!-- Field 1: Phone (26%) -->
                    <div class="w-full md:w-[26%]">
                        <label class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-3 ml-1">Nomor HP</label>
                        <div class="relative group">
                            <input type="text" name="phone" id="search-phone" placeholder="Contoh: 0812..." required
                                class="w-full h-[56px] px-6 bg-white border border-gray-200 rounded-xl outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <!-- Field 2: Date (26%) -->
                    <div class="w-full md:w-[26%]">
                        <label class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-3 ml-1">Tanggal Booking</label>
                        <div class="relative group">
                            <input type="date" name="date" id="search-date" required
                                class="w-full h-[56px] px-6 bg-white border border-gray-200 rounded-xl outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>
                    </div>

                    <!-- Field 3: Name (32%) -->
                    <div class="w-full md:w-[32%]">
                        <label class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-3 ml-1">Nama Pemesan</label>
                        <div class="relative group">
                            <input type="text" name="name" id="search-name" placeholder="Nama lengkap Anda" required
                                class="w-full h-[56px] px-6 bg-white border border-gray-200 rounded-xl outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <!-- Search Button (16%) -->
                    <div class="w-full md:w-[16%]">
                        <button type="submit" class="w-full h-[56px] bg-primary hover:bg-hover-primary text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all hover:shadow-lg active:scale-[0.98]">
                            <span>Cari</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('search-booking-form').addEventListener('submit', function(e) {
            const phone = document.getElementById('search-phone').value.trim();
            const date = document.getElementById('search-date').value.trim();
            const name = document.getElementById('search-name').value.trim();

            if (!phone || !date || !name) {
                e.preventDefault();
                alert('Lengkapi nama, tanggal booking, dan nomor HP terlebih dahulu.');
            }
        });
    </script>



    <!-- SECTION 4: PILIH PAKET SERU KAMU -->
    <section id="aktivitas" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy">Pilih Paket <span class="text-secondary">Seru Kamu</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($categories as $category)
            <a href="{{ $category->slug }}" class="group bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl transition-all hover:-translate-y-2 flex flex-col h-full">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $category->gambar ? asset('storage/' . $category->gambar) : 'https://picsum.photos/id/1019/600/400' }}" alt="{{ $category->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-primary text-xl font-bold mb-3 leading-tight group-hover:text-hover-primary transition-colors">{{ $category->nama }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $category->deskripsi }}</p>
                    <div class="mt-auto block w-full text-center bg-secondary text-white py-3 rounded-xl font-bold shadow-md group-hover:bg-secondary/90 transition-all">
                        Lihat Detail <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-soft-blue text-primary text-2xl mb-4">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-navy mb-1">Belum Ada Kategori Wisata</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Silakan tambahkan data kategori wisata melalui panel admin atau database.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- SECTION 5: LOGO CAROUSEL -->
    <section class="py-20 bg-light-gray overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-20 mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-dark-navy">
                 <span class="text-secondary">Experience</span>
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
    <section id="cerita-seru" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div>
                <h2 class="text-3xl md:text-5xl font-bold text-dark-navy mb-4">Cerita Seru di <span class="text-secondary">Kalisawah</span></h2>
                <p class="text-gray-500 font-medium italic">Dokumentasi kegiatan seru dari berbagai perusahaan, sekolah, dan komunitas</p>
            </div>
            <a href="{{ route('kabar.index') }}" class="bg-soft-blue text-primary px-6 py-3 rounded-full font-bold hover:bg-primary hover:text-white transition-all flex items-center gap-2 shadow-sm">
                Lihat Semua Cerita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($kabars as $kabar)
            <x-news-card 
                :image="$kabar->foto ? asset('storage/' . $kabar->foto) : 'https://picsum.photos/seed/' . $kabar->id . '/800/600'"
                :date="\Carbon\Carbon::parse($kabar->tanggal)->translatedFormat('d F Y')"
                :title="$kabar->judul"
                :description="Str::limit(strip_tags($kabar->isi_berita), 120)"
                :slug="Str::slug($kabar->judul)"
            />
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-soft-blue text-primary text-2xl mb-4">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-navy mb-1">Belum Ada Cerita Seru</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Nantikan rangkuman cerita dan kegiatan seru kami berikutnya di Kalisawah Adventure.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- SECTION 7: KATA MEREKA (Testimoni) -->
    <section class="py-24 px-6 md:px-20 bg-soft-blue relative">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-start mb-16">
                <div class="text-left">
                    <h2 class="text-3xl md:text-5xl font-bold text-dark-navy mb-4">Kata <span class="text-secondary">Mereka</span></h2>
                    <p class="text-gray-500 font-medium">Pendapat mereka setelah kegiatan seru bersama Kalisawah</p>
                </div>
                <a href="{{ route('testimoni.create') }}" class="w-12 h-12 md:w-14 md:h-14 bg-primary text-white rounded-2xl flex items-center justify-center shadow-xl hover:bg-hover-primary hover:rotate-90 transition-all duration-500 group" title="Tulis Review">
                    <i class="fa-solid fa-plus text-xl md:text-2xl"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                @php
                    $testis = [
                        ['Taufik Hidayat', 'Pertamina', 'Sangat seru, profesional, dan fasilitas lengkap. Raftingnya benar-benar menantang namun tetap aman bagi pemula.', 'https://i.pravatar.cc/150?u=1'],
                        ['Annisa Putri', 'Universitas Jember', 'Outboundnya sangat menyenangkan dan penuh tantangan! Tim instruktur ramah dan sangat membantu.', 'https://i.pravatar.cc/150?u=2'],
                        ['Andi Prabowo', 'Bank Mandiri', 'Acara team building yang menyenangkan dan terorganisir. Kami mendapatkan banyak pelajaran tentang kerja sama.', 'https://i.pravatar.cc/150?u=3'],
                        ['Siti Rahmawati', 'SMPN 1 Glenmore', 'Belajar sambil bermain di Kalisawah sangat seru! Anak-anak sangat antusias mengikuti kegiatan.', 'https://i.pravatar.cc/150?u=4'],
                    ];
                @endphp
                @foreach($testis as $t)
                <x-testimoni-card 
                    :name="$t[0]"
                    :instansi="$t[1]"
                    :review="$t[2]"
                    :image="$t[3]"
                />
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('testimoni.index') }}" class="bg-primary text-white px-10 py-4 rounded-xl font-bold shadow-lg hover:bg-hover-primary transition-all">Lihat Semua Testimoni</a>
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
