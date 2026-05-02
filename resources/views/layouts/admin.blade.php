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
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; height: 100vh; background-color: #F4F7FE; color: #333; overflow: hidden; }

        /* --- SIDEBAR (Fixed Width) --- */
        .sidebar_pembuat {
            width: 260px; min-width: 260px; background: white; display: flex; flex-direction: column;
            border-right: 1px solid #e0e0e0; z-index: 10;
        }
        .logo-area { padding: 30px 20px; text-align: center; }
        .logo-area img { width: 150px; }

        .menu-item {
            padding: 15px 25px; display: flex; align-items: center;
            text-decoration: none; color: #1a1a1a; font-weight: 500; transition: 0.3s;
        }
        .menu-item i { margin-right: 15px; width: 20px; text-align: center; }
        .menu-item.active {
            background: #4188FF; color: white; border-radius: 0 50px 50px 0; margin-right: 20px;
        }
        .menu-item:hover:not(.active) { background: #f0f4ff; }

        /* --- MAIN CONTENT AREA --- */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-width: 0; }

        /* NAVBAR (Locked Height & Position) */
        .navbar_pembuat {
            height: 70px; min-height: 70px; background: white; display: flex; justify-content: space-between;
            align-items: center; padding: 0 40px; border-bottom: 1px solid #e0e0e0; width: 100%;
        }

        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; position: relative; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }

        .dropdown-menu_pembuat {
            display: none; position: absolute; top: 50px; right: 0;
            background: white; min-width: 160px; box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-radius: 10px; border: 1px solid #edf2f7; z-index: 100; overflow: hidden;
        }
        .dropdown-menu_pembuat.show { display: block; }
        .dropdown-menu_pembuat a { padding: 12px 20px; display: flex; align-items: center; gap: 10px; text-decoration: none; color: #ff4d4d; font-size: 14px; font-weight: 600; }

        /* CONTENT SCROLLABLE */
        .container-custom { padding: 40px; flex: 1; overflow-y: auto; }
        .page-title { color: #4188FF; font-weight: 700; margin-bottom: 30px; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar_pembuat">
        <div class="logo-area">
            <img src="{{ asset('uploud/logo.png') }}" alt="Logo">
        </div>
        {{-- MENU SIDEBAR TETAP LENGKAP --}}
        <a href="/admin/dashboard" class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="/admin/booking" class="menu-item {{ Request::is('admin/booking*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-plus"></i> Booking
        </a>
        <a href="#" class="menu-item"><i class="fa-solid fa-box"></i> Paket Wisata</a>
        <a href="#" class="menu-item"><i class="fa-solid fa-tent"></i> Fasilitas</a>
        <a href="#" class="menu-item"><i class="fa-solid fa-image"></i> Galeri</a>
        <a href="#" class="menu-item"><i class="fa-solid fa-newspaper"></i> Berita</a>
        <a href="#" class="menu-item"><i class="fa-solid fa-chart-line"></i> Laporan</a>
    </div>

    <div class="main-content">
        <div class="navbar_pembuat">
            <div class="date-now text-muted small" id="currentDate"></div>

            <div class="user-profile" id="profileTrigger">
                <span class="fw-bold small">Admin Kalisawah</span>
                <img src="https://ui-avatars.com/api/?name=Admin+Kalisawah&background=random" alt="User">
                <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>

                <div class="dropdown-menu_pembuat" id="logoutDropdown">
                    <a href="javascript:void(0)" onclick="logout()">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="container-custom">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const profileTrigger = document.getElementById('profileTrigger');
        const logoutDropdown = document.getElementById('logoutDropdown');
        if(profileTrigger) {
            profileTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                logoutDropdown.classList.toggle('show');
            });
        }
        window.addEventListener('click', () => {
            if (logoutDropdown && logoutDropdown.classList.contains('show')) {
                logoutDropdown.classList.remove('show');
            }
        });

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').innerText = new Date().toLocaleDateString('id-ID', options);

        function logout() {
            localStorage.removeItem("token");
            window.location.href = "/admin/login";
        }
    </script>
    @stack('scripts')
</body>
</html>