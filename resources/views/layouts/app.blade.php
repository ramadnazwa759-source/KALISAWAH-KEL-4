    <!DOCTYPE html>
    <html>
    <head>
        <title>Kalisawah Adventure</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">Kalisawah</div>

        <ul>
            <li>Home</li>
            <li>Paket</li>
            <li>Galeri</li>
            <li>Event</li>
            <li>Kontak</li>
        </ul>
    </nav>

    @yield('content')

    </body>
    </html>