<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kali Sawah</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #F4F7FE;
            color: #333;
            overflow: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar_pembuat {
            width: 260px;
            min-width: 260px;
            background: white;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #e0e0e0;
            z-index: 10;
            overflow-y: auto; /* Tambahan agar sidebar bisa scroll jika menu banyak */
        }

        .logo-area {
            padding: 30px 20px;
            text-align: center;
        }

        .logo-area img {
            width: 150px;
        }

        .sidebar-label {
            padding: 20px 25px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #adb5bd;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1a1a1a;
            font-weight: 500;
            transition: 0.3s;
            cursor: pointer;
        }

        .menu-item i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .menu-item.active {
            background: #4188FF;
            color: white;
            border-radius: 0 50px 50px 0;
            margin-right: 20px;
        }

        .menu-item:hover:not(.active) {
            background: #f0f4ff;
            color: #4188FF;
        }

        /* ================= SUBMENU ================= */
        .menu-group {
            display: flex;
            flex-direction: column;
        }

        .submenu {
            display: none;
            flex-direction: column;
            background: #fcfcfc;
        }

        .submenu.show {
            display: flex;
        }

        /* ================= MAIN ================= */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        .navbar_pembuat {
            height: 70px;
            min-height: 70px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            border-bottom: 1px solid #e0e0e0;
            width: 100%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            position: relative;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-menu_pembuat {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            min-width: 160px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-radius: 10px;
            border: 1px solid #edf2f7;
            z-index: 100;
        }

        .dropdown-menu_pembuat.show {
            display: block;
        }

        .dropdown-menu_pembuat a {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ff4d4d;
            font-size: 14px;
            font-weight: 600;
        }

        .container-custom {
            padding: 40px;
            flex: 1;
            overflow-y: auto;
        }

        .page-title {
            color: #4188FF;
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 24px;
        }
    </style>

    @stack('styles')
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar_pembuat">

    <div class="logo-area">
        <img src="{{ asset('uploud/logo.png') }}" alt="Logo">
    </div>

    <!-- DASHBOARD -->
    <a href="/admin/dashboard" class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i> Dashboard
    </a>

    <!-- GROUP 1: MANAJEMEN WEBSITE -->
    <div class="sidebar-label">Manajemen Website</div>

    <!-- WISATA -->
    <div class="menu-group">
        <div class="menu-item parent-toggle">
            <i class="fa-solid fa-mountain-sun"></i> Wisata
            <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:10px;"></i>
        </div>
        <div class="submenu">
            <a href="/admin/wisata/profil" class="menu-item" style="padding-left:50px;">Profil Wisata</a>
            <a href="/admin/wisata/galeri" class="menu-item" style="padding-left:50px;">Galeri</a>
            <a href="/admin/wisata/fasilitas" class="menu-item" style="padding-left:50px;">Fasilitas</a>
        </div>
    </div>

    <!-- KONTEN -->
    <div class="menu-group">
        <div class="menu-item parent-toggle">
            <i class="fa-solid fa-newspaper"></i> Konten
            <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:10px;"></i>
        </div>
        <div class="submenu">
            <a href="/admin/berita" class="menu-item" style="padding-left:50px;">Berita</a>
        </div>
    </div>


    <!-- GROUP 2: MANAJEMEN OPERASIONAL -->
    <div class="sidebar-label" style="margin-top: 10px;">Manajemen Operasional</div>

    <!-- PAKET -->
    <div class="menu-group">
        <div class="menu-item parent-toggle">
            <i class="fa-solid fa-box"></i> Layanan Wisata
            <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:10px;"></i>
        </div>
        <div class="submenu">
            <a href="{{ route('admin.paket-wisata.index') }}" class="menu-item" style="padding-left:50px;">Paket Wisata</a>
            <a href="{{ route('admin.kategori-paket.index') }}" class="menu-item" style="padding-left:50px;">Kategori Paket</a>
            <a href="#" class="menu-item" style="padding-left:50px;">Fasilitas Paket</a>
            <a href="#" class="menu-item" style="padding-left:50px;">Diskon</a>
        </div>
    </div>

    <!-- TRANSAKSI -->
    <div class="menu-group">
        <div class="menu-item parent-toggle">
            <i class="fa-solid fa-calendar-check"></i> Transaksi
            <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:10px;"></i>
        </div>
        <div class="submenu">
            <a href="/admin/booking" class="menu-item" style="padding-left:50px;">Booking</a>
            <a href="/admin/fasilitas-booking" class="menu-item" style="padding-left:50px;">Fasilitas Booking</a>
            <a href="/admin/pembayaran" class="menu-item" style="padding-left:50px;">Pembayaran</a>
        </div>
    </div>

    <!-- OPERASIONAL -->
    <div class="menu-group">
        <div class="menu-item parent-toggle">
            <i class="fa-solid fa-gears"></i> Inventaris
            <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:10px;"></i>
        </div>
        <div class="submenu">
            <a href="/admin/inventaris" class="menu-item" style="padding-left:50px;">Inventaris</a>
            <a href="{{ route('admin.jenis-inventaris.index') }}" class="menu-item" style="padding-left:50px;">Jenis Inventaris</a>
            <a href="/admin/pengeluaran" class="menu-item" style="padding-left:50px;">Pengeluaran</a>
            <a href="/admin/kategori-pengeluaran" class="menu-item" style="padding-left:50px;">Kategori Pengeluaran</a>
        </div>
    </div>

    <div style="margin-bottom: 30px;"></div> <!-- Spacer bawah -->
</div>

<!-- ================= MAIN ================= -->
<div class="main-content">

    <div class="navbar_pembuat">
        <div id="currentDate" style="font-weight: 500; color: #666;"></div>

        <div class="user-profile" id="profileTrigger">
            <span>Admin Kalisawah</span>
            <img src="https://ui-avatars.com/api/?name=Admin+Kalisawah&background=4188FF&color=fff">
            <i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i>

            <div class="dropdown-menu_pembuat" id="logoutDropdown">
                <a href="#" onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>
    </div>

    <div class="container-custom">
        @yield('content')
    </div>

</div>

<!-- ================= SCRIPT ================= -->
<script>
// Toggle Submenu
document.querySelectorAll('.parent-toggle').forEach(item => {
    item.addEventListener('click', function () {
        const submenu = this.nextElementSibling;
        const icon = this.querySelector('.fa-chevron-down');

        submenu.classList.toggle('show');

        // Animasi rotasi icon (opsional)
        if(submenu.classList.contains('show')) {
            icon.style.transform = "rotate(180deg)";
        } else {
            icon.style.transform = "rotate(0deg)";
        }
    });
});

// Dropdown Profile
const profileTrigger = document.getElementById('profileTrigger');
const logoutDropdown = document.getElementById('logoutDropdown');

profileTrigger.addEventListener('click', function (e) {
    e.stopPropagation();
    logoutDropdown.classList.toggle('show');
});

window.addEventListener('click', function () {
    logoutDropdown.classList.remove('show');
});

// Real-time Date
document.getElementById('currentDate').innerText =
    new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

// Logout Function
function logout() {
    if(confirm('Apakah Anda yakin ingin keluar?')) {
        localStorage.removeItem("token");
        window.location.href = "/admin/login";
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
