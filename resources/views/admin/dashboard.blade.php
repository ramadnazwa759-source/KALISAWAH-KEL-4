@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Style khusus Dashboard yang tidak ada di layout utama */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }
    .card-stat {
        padding: 25px;
        border-radius: 12px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .card-orange { background: #F6A05D; }
    .card-blue { background: #88B1F3; }
    .card-red { background: #D99A9A; }

    .stat-info h3 { font-size: 16px; font-weight: 500; opacity: 0.9; margin-bottom: 10px; }
    .stat-info p { font-size: 36px; font-weight: 700; margin-bottom: 0; }
    .card-stat i { font-size: 40px; opacity: 0.3; }

    .info-box {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .info-header {
        padding: 15px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }
    .info-body { padding: 25px; line-height: 1.6; color: #555; }
</style>
@endpush

@section('content')
    <h1 class="page-title">Dashboard Admin</h1>

    <div class="stats-grid">
        <div class="card-stat card-orange">
            <div class="stat-info">
                <h3>Total Booking</h3>
                <p id="totalBooking">0</p>
            </div>
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <div class="card-stat card-blue">
            <div class="stat-info">
                <h3>Booking Hari ini</h3>
                <p id="bookingHariIni">0</p>
            </div>
            <i class="fa-solid fa-square-check"></i>
        </div>
        <div class="card-stat card-red">
            <div class="stat-info">
                <h3>Pengunjung</h3>
                <p id="totalPengunjung">0</p>
            </div>
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="info-box">
        <div class="info-header">
            <i class="fa-solid fa-comment-dots" style="color: #8E44AD;"></i> Tentang Sistem
        </div>
        <div class="info-body">
            <p>Selamat Datang Admin Kalisawah!</p>
            <p>Berikut ini informasi mengenai sistem pengelolaan wisata Kalisawah Adventure yang digunakan untuk mengelola booking, paket wisata, fasilitas, dan barang camping.</p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pastikan token ada sebelum hit API
    const token = localStorage.getItem("token");
    if (!token) window.location.href = "/admin/login";

    // Fungsi Load Data dari API
    async function loadDashboard() {
        try {
            const res = await fetch("http://127.0.0.1:8000/api/dashboard", {
                headers: { "Authorization": "Bearer " + token }
            });

            if (res.status === 401) {
                localStorage.removeItem("token");
                window.location.href = "/admin/login";
                return;
            }

            const data = await res.json();
            document.getElementById("totalBooking").innerText = data.totalBooking || 0;
            document.getElementById("bookingHariIni").innerText = data.bookingHariIni || 0;
            document.getElementById("totalPengunjung").innerText = data.totalPengunjung || 0;
        } catch (e) {
            console.error("Gagal mengambil data dari API Dashboard");
        }
    }

    // Jalankan fungsi saat halaman siap
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboard();
    });
</script>
@endpush
