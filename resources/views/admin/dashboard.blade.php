<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Kalisawah Adventure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite('resources/css/app.css')

    <style>
        :root {
            --sidebar-bg: #ffffff;
            --main-bg: #f8faff;
            --primary-blue: #3b82f6;
            --card-orange: #f5a623;
            --card-blue: #7fb1ff;
            --card-pink: #d99694;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--main-bg);
            margin: 0;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 2px solid #eef2f6;
            display: flex;
            flex-direction: column;
        }

        .logo-section {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .logo-section img {
            max-width: 180px; /* Sesuaikan ukuran logo */
        }

        .menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .menu li {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            color: #555;
            font-weight: 500;
        }

        .menu li i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .menu li.active {
            background: var(--primary-blue);
            color: #fff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .menu li:hover:not(.active) {
            background: #f0f7ff;
            color: var(--primary-blue);
        }

        /* --- MAIN CONTENT --- */
        .main {
            flex: 1;
            padding: 30px;
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .date-display {
            color: #888;
            font-size: 0.9rem;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .admin-profile i {
            font-size: 2rem;
            color: #ccc;
        }

        h2.page-title {
            color: var(--primary-blue);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 25px;
        }

        /* --- CARDS --- */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            padding: 25px;
            border-radius: 12px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .card-info h3 { margin: 0; font-size: 1.1rem; font-weight: 400; }
        .card-info h1 { margin: 5px 0 0; font-size: 2.5rem; }
        .card-icon { font-size: 2.5rem; opacity: 0.5; }

        .bg-orange { background: var(--card-orange); }
        .bg-blue { background: var(--card-blue); }
        .bg-pink { background: var(--card-pink); }

        /* --- BOX CONTENT --- */
        .info-box {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }

        .info-box-header {
            background: #fff;
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            color: #555;
            font-weight: 600;
        }

        .info-box-header i { color: #8e44ad; margin-right: 10px; }

        .info-box-body {
            padding: 25px;
            line-height: 1.6;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <nav class="sidebar">
        <div class="logo-section">
            <img src="{{ asset('uploud/logo.png') }}" alt="Kalisawah Adventure">
        </div>
        <ul class="menu">
            <li class="active"><i class="fa-solid fa-house"></i> Dashboard</li>
            <li><i class="fa-solid fa-calendar-plus"></i> Booking Wisata</li>
            <li><i class="fa-solid fa-list-check"></i> Fasilitas</li>
            <li><i class="fa-solid fa-tent"></i> Barang Camping</li>
            <li><i class="fa-solid fa-newspaper"></i> Berita</li>
        </ul>
    </nav>

    <main class="main">
        <header class="top-navbar">
            <div class="date-display">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
            <div class="admin-profile">
                <span>Admin Kalisawah</span>
                <i class="fa-solid fa-circle-user"></i>
            </div>
        </header>

        <h2 class="page-title">Dashboard Admin</h2>

        <div class="cards-container">
            <div class="card bg-orange">
                <div class="card-info">
                    <h3>Total Booking</h3>
                    <h1>{{ $totalBooking ?? 200 }}</h1>
                </div>
                <div class="card-icon"><i class="fa-solid fa-calendar-days"></i></div>
            </div>

            <div class="card bg-blue">
                <div class="card-info">
                    <h3>Booking Hari Ini</h3>
                    <h1>{{ $bookingHariIni ?? 8 }}</h1>
                </div>
                <div class="card-icon"><i class="fa-solid fa-square-check"></i></div>
            </div>

            <div class="card bg-pink">
                <div class="card-info">
                    <h3>Pengunjung</h3>
                    <h1>{{ $totalPengunjung ?? 180 }}</h1>
                </div>
                <div class="card-icon"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>

        <div class="info-box">
            <div class="info-box-header">
                <i class="fa-solid fa-comment-dots"></i> Tentang Sistem
            </div>
            <div class="info-box-body">
                <p><strong>Selamat Datang Admin Kalisawah!</strong></p>
                <p>Berikut ini informasi mengenai sistem pengelolaan wisata Kalisawah Adventure yang digunakan untuk mengelola booking, paket wisata, fasilitas, dan barang camping.</p>
            </div>
        </div>


    </main>
</div>

</body>
</html>
