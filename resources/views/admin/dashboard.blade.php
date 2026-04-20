<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            margin: 0;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 220px;
            background: #fff;
            height: 100vh;
            border-right: 1px solid #ddd;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            padding: 12px 20px;
        }

        .menu li.active {
            background: #2d7ff9;
            color: #fff;
            border-radius: 6px;
        }

        .main {
            flex: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logout-btn {
            background: red;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .cards {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            color: #fff;
        }

        .orange { background: #f39c12; }
        .blue { background: #4a90e2; }
        .red { background: #e74c3c; }

        .box {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Kalisawah Adventure</h2>
        <ul class="menu">
            <li class="active">Dashboard</li>
            <li>Booking Wisata</li>
            <li>Fasilitas</li>
            <li>Barang Camping</li>
            <li>Berita</li>
        </ul>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <div><strong>Dashboard Admin</strong></div>

            <!-- ✅ LOGOUT -->
            <form action="/logout" method="POST">
                @csrf
                <button class="logout-btn">Logout</button>
            </form>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card orange">
                <h3>Total Booking</h3>
                <h1>{{ $totalBooking ?? 0 }}</h1>
            </div>

            <div class="card blue">
                <h3>Booking Hari Ini</h3>
                <h1>{{ $bookingHariIni ?? 0 }}</h1>
            </div>

            <div class="card red">
                <h3>Pengunjung</h3>
                <h1>{{ $totalPengunjung ?? 0 }}</h1>
            </div>
        </div>

        <!-- BOX -->
        <div class="box">
            <h4>Tentang Sistem</h4>
            <p>
                Selamat datang di sistem admin Kalisawah Adventure.
                Kelola booking, fasilitas, dan data wisata di sini.
            </p>
        </div>

    </div>
</div>

</body>
</html>
