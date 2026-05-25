@extends('layouts.app')

@section('title', 'Cerita Seru - Kalisawah Adventure Banyuwangi')

@section('content')
    @php
        // HERO CONFIGURATION
        $heroImage = (isset($hero->image) && $hero->image) ? asset('storage/' . $hero->image) : 'https://picsum.photos/id/1044/1920/600';
        $heroTitle = $hero->title ?? 'Cerita Seru di Kalisawah';
        $heroSubtitle = $hero->subtitle ?? 'Kumpulan momen berkesan, dokumentasi kegiatan, dan kabar terbaru dari Kalisawah Adventure.';
    @endphp

    <!-- Hero Section Kabar -->
    <section class="relative py-24 bg-dark-navy text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ $heroImage }}" alt="{{ $heroTitle }}" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-20 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">{!! str_replace('Kalisawah', '<span class="text-secondary">Kalisawah</span>', $heroTitle) !!}</h1>
            <p class="text-lg md:text-xl max-w-2xl mx-auto opacity-90 leading-relaxed">
                {{ $heroSubtitle }}
            </p>
        </div>
    </section>

    <!-- Kabar Grid -->
    <section class="py-20 px-6 md:px-20 max-w-7xl mx-auto">
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

        <!-- Pagination -->
        <div class="mt-20">
            {{ $kabars->links() }}
        </div>
    </section>
@endsection
