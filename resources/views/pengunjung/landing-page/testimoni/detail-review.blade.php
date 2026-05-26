@extends('layouts.app')

@section('title', 'Testimoni Pengunjung - Kalisawah Adventure')

@section('content')
<section class="pt-36 md:pt-44 pb-24 px-6 md:px-20 bg-[#f8f9fb] min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10 space-y-4">
            <h1 class="text-4xl md:text-6xl font-bold text-dark-navy mb-4">Kata <span class="text-secondary">Mereka</span></h1>
            <p class="text-gray-500 text-lg font-medium italic max-w-2xl mx-auto">Pendapat jujur dari mereka yang telah merasakan keseruan petualangan bersama Kalisawah Adventure</p>
        </div>

        <!-- Grid Testimoni -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @php
                // Dummy data untuk keperluan frontend-only
                $testimonis = [
                    (object)[
                        'nama' => 'Taufik Hidayat',
                        'instansi' => 'Pertamina',
                        'ulasan' => 'Sangat seru, profesional, dan fasilitas lengkap. Raftingnya benar-benar menantang namun tetap aman bagi pemula.',
                        'foto' => 'https://i.pravatar.cc/150?u=1',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Annisa Putri',
                        'instansi' => 'Universitas Jember',
                        'ulasan' => 'Outboundnya sangat menyenangkan dan penuh tantangan! Tim instruktur ramah dan sangat membantu selama kegiatan berlangsung.',
                        'foto' => 'https://i.pravatar.cc/150?u=2',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Andi Prabowo',
                        'instansi' => 'Bank Mandiri',
                        'ulasan' => 'Acara team building yang menyenangkan dan terorganisir. Kami mendapatkan banyak pelajaran tentang kerja sama tim.',
                        'foto' => 'https://i.pravatar.cc/150?u=3',
                        'rating' => 4
                    ],
                    (object)[
                        'nama' => 'Siti Rahmawati',
                        'instansi' => 'SMPN 1 Glenmore',
                        'ulasan' => 'Belajar sambil bermain di Kalisawah sangat seru! Anak-anak sangat antusias mengikuti setiap sesi kegiatannya.',
                        'foto' => 'https://i.pravatar.cc/150?u=4',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Budi Santoso',
                        'instansi' => 'Komunitas Motor',
                        'ulasan' => 'Pengalaman rafting terbaik di Banyuwangi. Arusnya pas dan pemandangan di sekitar sungai sangat asri.',
                        'foto' => 'https://i.pravatar.cc/150?u=5',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Dewi Lestari',
                        'instansi' => 'Keluarga Cemara',
                        'ulasan' => 'Tempat yang sangat ramah anak untuk camping. Fasilitasnya bersih dan udaranya sangat sejuk.',
                        'foto' => 'https://i.pravatar.cc/150?u=6',
                        'rating' => 4
                    ],
                    (object)[
                        'nama' => 'Rizky Ramadhan',
                        'instansi' => 'PT. Maju Bersama',
                        'ulasan' => 'Gathering perusahaan paling berkesan. Koordinasi tim Kalisawah sangat mantap, dari penjemputan sampai acara selesai.',
                        'foto' => 'https://i.pravatar.cc/150?u=7',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Maya Indah',
                        'instansi' => 'SMA 1 Banyuwangi',
                        'ulasan' => 'Pemandangannya indah banget! Selain dapet serunya, kita juga dapet foto-foto estetik buat diupload di sosmed.',
                        'foto' => 'https://i.pravatar.cc/150?u=8',
                        'rating' => 5
                    ],
                    (object)[
                        'nama' => 'Fajar Sidik',
                        'instansi' => 'Jeep Enthusiast',
                        'ulasan' => 'Track jeep tour-nya bener-bener gokil! Drivernya jago dan tau spot-spot foto yang keren banget.',
                        'foto' => 'https://i.pravatar.cc/150?u=9',
                        'rating' => 5
                    ],
                ];
            @endphp

            @foreach ($testimonis as $testimoni)
                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col h-full group">
                    <!-- User Profile -->
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-soft-blue group-hover:border-secondary transition-colors shrink-0 shadow-sm">
                            <img src="{{ $testimoni->foto }}" alt="{{ $testimoni->nama }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-navy text-lg leading-tight">{{ $testimoni->nama }}</h4>
                            <p class="text-secondary text-xs font-bold uppercase tracking-[0.1em] mt-1">{{ $testimoni->instansi }}</p>
                        </div>
                    </div>
                    
                    <!-- Stars -->
                    <div class="flex gap-1.5 mb-6">
                        @for($i=0; $i<$testimoni->rating; $i++)
                            <i class="fa-solid fa-star text-secondary text-sm"></i>
                        @endfor
                        @for($i=0; $i<(5 - $testimoni->rating); $i++)
                            <i class="fa-solid fa-star text-gray-100 text-sm"></i>
                        @endfor
                    </div>

                    <!-- Review Content -->
                    <p class="text-gray-500 leading-relaxed italic flex-grow">
                        "{{ $testimoni->ulasan }}"
                    </p>
                    
                    <!-- Decorative Quote -->
                    <div class="mt-8 flex justify-end opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-quote-right text-3xl text-primary"></i>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination / Footer Info -->
        <div class="mt-24 text-center">
            <div class="inline-flex items-center justify-center gap-2 px-6 py-2 bg-white rounded-full border border-gray-100 text-gray-400 text-xs font-bold uppercase tracking-widest shadow-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Review Terverifikasi Pelanggan
            </div>
        </div>
    </div>
</section>
@endsection
