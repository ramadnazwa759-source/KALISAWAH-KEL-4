<nav class="fixed top-0 left-0 right-0 z-[999] transition-all duration-300 bg-transparent py-4 px-6 md:px-20 flex justify-between items-center">
    <!-- Left: Logo -->
    <div class="flex items-center">
        <a href="/">
            <img src="{{ asset('images/logoKalisawah.png') }}" alt="Kalisawah Adventure" class="h-10 md:h-12">
        </a>
    </div>

    <!-- Center: Menu -->
    <ul class="hidden lg:flex gap-8 items-center list-none m-0 p-0 font-semibold text-primary">
        <li><a href="/" class="hover:text-hover-primary transition-colors">Beranda</a></li>
        
        <li class="relative dropdown group">
            <a href="#" class="flex items-center gap-1 hover:text-hover-primary transition-colors">
                Paket Wisata <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </a>
            <ul class="dropdown-menu absolute left-0 top-full mt-2 w-64 bg-white border-t-4 border-primary rounded-b-lg shadow-xl hidden py-2 list-none">
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Gathering & Team Building</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Rafting Banyuwangi</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Camping Banyuwangi</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Outbound Banyuwangi</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Wargame Banyuwangi (Paintball)</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Jeep Tour Banyuwangi</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Villa & Menginap</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Adventure Game</a></li>
            </ul>
        </li>

        <li class="relative dropdown group">
            <a href="#" class="flex items-center gap-1 hover:text-hover-primary transition-colors">
                Aktivitas <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </a>
            <ul class="dropdown-menu absolute left-0 top-full mt-2 w-56 bg-white border-t-4 border-primary rounded-b-lg shadow-xl hidden py-2 list-none">
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Rafting</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Camping</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Outbound</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Paintball</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Jeep Adventure</a></li>
                <li><a href="#" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700">Panahan & Shooting Target</a></li>
            </ul>
        </li>

        <li><a href="#" class="hover:text-hover-primary transition-colors">Cerita Kalisawah</a></li>
        <li><a href="#" class="hover:text-hover-primary transition-colors">Fasilitas</a></li>
        <li><a href="#" class="hover:text-hover-primary transition-colors">Kontak</a></li>
    </ul>

    <!-- Right: Mobile Toggle -->
    <div class="flex items-center gap-4">
        <!-- Mobile Toggle -->
        <button onclick="toggleMobileMenu()" class="lg:hidden text-primary text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden absolute top-full left-0 right-0 bg-white shadow-2xl border-t border-gray-100 py-6 px-6 space-y-4">
        <a href="/" class="block font-bold text-primary">Beranda</a>
        <div class="font-bold text-primary border-b border-gray-100 pb-2">Paket Wisata</div>
        <ul class="pl-4 space-y-2 list-none">
            <li><a href="#" class="text-sm text-gray-600">Gathering & Team Building</a></li>
            <li><a href="#" class="text-sm text-gray-600">Rafting Banyuwangi</a></li>
            <li><a href="#" class="text-sm text-gray-600">Camping Banyuwangi</a></li>
        </ul>
        <a href="#" class="block font-bold text-primary">Cerita Kalisawah</a>
        <a href="#" class="block font-bold text-primary">Fasilitas</a>
        <a href="#" class="block font-bold text-primary">Kontak</a>
    </div>
</nav>

