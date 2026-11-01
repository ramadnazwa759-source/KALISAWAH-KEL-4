@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .dash-subtitle { margin: 6px 0 28px; color: #5B6B86; font-size: 15px; }

    /* Banner sambutan */
    .hero {
        display: flex;
        align-items: center;
        gap: 32px;
        padding: 36px 40px;
        border-radius: 24px;
        color: #fff;
        background: linear-gradient(120deg, #1D4ED8 0%, #2563EB 55%, #0EA5E9 100%);
        box-shadow: 0 18px 40px rgba(29, 78, 216, .25);
        margin-bottom: 28px;
    }
    .hero-body { flex: 1; }
    .hero-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 99px;
        background: rgba(255, 255, 255, .18);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
    }
    .hero h2 { margin: 16px 0 10px; font-size: 28px; font-weight: 800; }
    .hero p { margin: 0; max-width: 620px; font-size: 16px; line-height: 1.7; color: #EAF1FF; }
    .hero-icon {
        flex: none;
        width: 120px;
        height: 120px;
        border-radius: 30px;
        background: rgba(255, 255, 255, .14);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
    }
    .hero-icon i:last-child { color: #FBBF24; margin-left: -14px; font-size: 26px; align-self: flex-start; margin-top: 30px; }

    /* Kartu akses cepat */
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
    }
    .quick-card {
        display: block;
        padding: 24px;
        border-radius: 20px;
        background: #fff;
        border: 1px solid #E5EAF5;
        color: inherit;
        text-decoration: none;
        transition: transform .2s, box-shadow .2s;
    }
    .quick-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(29, 78, 216, .14);
        color: inherit;
    }
    .quick-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .quick-card h3 { margin: 16px 0 6px; font-size: 17px; font-weight: 700; }
    .quick-card p { margin: 0; font-size: 14px; line-height: 1.55; color: #5B6B86; }

    .ic-blue   { background: #E8F0FF; color: #1D4ED8; }
    .ic-amber  { background: #FEF3C7; color: #92400E; }
    .ic-green  { background: #DCFCE7; color: #166534; }
    .ic-purple { background: #F3E8FF; color: #6B21A8; }

    @media (max-width: 800px) {
        .hero { flex-direction: column; align-items: flex-start; padding: 28px 24px; }
        .hero-icon { display: none; }
    }
</style>
@endpush

@section('content')
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="dash-subtitle">Ringkasan pengelolaan wisata Kalisawah Adventure</p>

    {{-- Banner sambutan --}}
    <section class="hero">
        <div class="hero-body">
            <span class="hero-badge">TENTANG SISTEM</span>
            <h2>Selamat Datang Admin</h2>
            <p>
                Sistem pengelolaan wisata Kalisawah Adventure untuk mengelola
                paket wisata, fasilitas, dan barang camping.
            </p>
        </div>
        <div class="hero-icon">
            <i class="fa-solid fa-mountain-sun"></i>
        </div>
    </section>

    {{-- Akses cepat --}}
    <section class="quick-grid">

        <a href="#" class="quick-card"> {{-- route('admin.paket.index') --}}
            <div class="quick-icon ic-amber"><i class="fa-solid fa-map-location-dot"></i></div>
            <h3>Paket Wisata</h3>
            <p>Atur paket, harga, dan deskripsi destinasi.</p>
        </a>

        <a href="#" class="quick-card"> {{-- route('admin.fasilitas.index') --}}
            <div class="quick-icon ic-green"><i class="fa-solid fa-house-flag"></i></div>
            <h3>Fasilitas</h3>
            <p>Pantau fasilitas yang tersedia di lokasi wisata.</p>
        </a>

        <a href="#" class="quick-card"> {{-- route('admin.camping.index') --}}
            <div class="quick-icon ic-purple"><i class="fa-solid fa-campground"></i></div>
            <h3>Barang Camping</h3>
            <p>Kelola stok dan penyewaan perlengkapan camping.</p>
        </a>
    </section>
@endsection

@push('scripts')
<script>
    /* Script lama yang cek localStorage dihapus total agar tidak menendang
       user balik ke login. Keamanan dijaga oleh Middleware 'auth' di web.php */
</script>
@endpush
