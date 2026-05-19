@extends('layouts.app')

@section('title', $berita->judul . ' - Kalisawah Adventure Banyuwangi')

@section('content')
    <!-- SPACER FOR FIXED NAVBAR -->
    <div class="h-24 bg-primary"></div>

    <!-- BREADCRUMB & HERO HEADER -->
    <section class="bg-soft-blue py-12 px-6 md:px-20">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 font-medium">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                <span class="text-primary font-bold">Kabar Wisata</span>
            </nav>

            <h1 class="text-3xl md:text-5xl font-bold text-dark-navy leading-tight mb-6">
                {{ $berita->judul }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 border-t border-gray-200/80 pt-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fa-solid fa-user-pen text-xs"></i>
                    </div>
                    <span>Oleh Admin Kalisawah</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar text-primary"></i>
                    <span>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-primary"></i>
                    <span>Glenmore, Banyuwangi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ARTICLE CONTENT -->
    <section class="py-16 px-6 md:px-20 max-w-4xl mx-auto">
        <!-- Featured Image -->
        <div class="w-full rounded-3xl overflow-hidden shadow-xl mb-12 relative group max-h-[500px]">
            <img src="{{ $berita->foto ? asset('storage/' . $berita->foto) : 'https://picsum.photos/id/1031/1200/800' }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
        </div>

        <!-- Article Body -->
        <article class="prose prose-lg max-w-none text-gray-600 leading-relaxed font-normal text-justify">
            {!! nl2br(e($berita->isi_berita)) !!}
        </article>

        <!-- CTA & Navigation Back -->
        <div class="mt-16 pt-8 border-t border-gray-150 flex flex-col sm:flex-row items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:gap-4 transition-all group">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Kembali ke Beranda
            </a>
            
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-dark-navy">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md hover:opacity-90 hover:scale-105 transition-all">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center shadow-md hover:opacity-90 hover:scale-105 transition-all">
                    <i class="fa-brands fa-facebook-f text-base"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center shadow-md hover:opacity-90 hover:scale-105 transition-all">
                    <i class="fa-brands fa-twitter text-base"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
