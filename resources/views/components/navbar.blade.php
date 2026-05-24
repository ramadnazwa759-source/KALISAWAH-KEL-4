<nav class="fixed top-0 left-0 right-0 z-[999] transition-all duration-300 bg-transparent py-4 px-6 md:px-20 flex justify-between items-center">
    <!-- Left: Logo -->
    <div class="flex items-center">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logoKalisawah.png') }}" alt="Kalisawah Adventure" class="h-10 md:h-12">
        </a>
    </div>

    <!-- Center: Menu -->
    <ul class="hidden lg:flex gap-8 items-center list-none m-0 p-0 font-semibold text-primary">
        <li><a href="{{ route('home') }}" class="hover:text-hover-primary transition-colors">Beranda</a></li>
        
        <li class="relative dropdown">
            <button id="desktop-dropdown-btn" class="flex items-center gap-1 hover:text-hover-primary transition-colors outline-none focus:outline-none py-2 cursor-pointer">
                Paket Wisata <i id="desktop-chevron" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300"></i>
            </button>
            <ul id="desktop-dropdown-menu" class="hidden absolute left-0 top-full mt-0 w-64 bg-white border-t-4 border-primary rounded-b-xl shadow-2xl py-3 list-none transform translate-y-2 transition-all duration-300 opacity-0">
                <li><a href="{{ route('camping') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Camping</a></li>
                <li><a href="{{ route('rafting') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Rafting</a></li>
                <li><a href="{{ route('outbound') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Outbound</a></li>
                <li><a href="/paintball" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Paintball</a></li>
                <li><a href="{{ route('adventure-game') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Adventure Game</a></li>
                <li><a href="{{ route('gathering') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Gathering</a></li>
                <li><a href="{{ route('jeeptour') }}" class="block px-6 py-3 hover:bg-soft-blue text-sm transition-colors text-gray-700 font-medium hover:text-primary">Jeep Tour</a></li>
            </ul>
        </li>

        <li><a href="/#paket-seru" class="hover:text-hover-primary transition-colors">Aktivitas</a></li>
        <li><a href="{{ url('/#tentang-kalisawah') }}" class="hover:text-hover-primary transition-colors">Tentang Kalisawah</a></li>
        <li><a href="{{ route('kabar.index') }}" class="hover:text-hover-primary transition-colors">Cerita Kalisawah</a></li>
        <li><a href="#footer" class="hover:text-hover-primary transition-colors">Kontak</a></li>
    </ul>

    <!-- Right: Mobile Toggle -->
    <div class="flex items-center gap-4">
        <!-- Mobile Toggle -->
        <button onclick="toggleMobileMenu()" class="lg:hidden text-primary text-2xl focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden absolute top-full left-0 right-0 bg-white shadow-2xl border-t border-gray-100 py-6 px-6 space-y-4 max-h-[80vh] overflow-y-auto">
        <a href="{{ route('home') }}" class="block font-bold text-primary">Beranda</a>
        
        <div class="space-y-2">
            <button onclick="toggleMobileDropdown()" class="w-full flex justify-between items-center font-bold text-primary border-b border-gray-100 pb-2 outline-none">
                Paket Wisata <i id="mobile-chevron" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
            </button>
            <ul id="mobile-dropdown" class="hidden pl-4 space-y-3 list-none mt-2 border-l-2 border-soft-blue">
                <li><a href="{{ route('camping') }}" class="block text-sm text-gray-600 hover:text-primary">Camping</a></li>
                <li><a href="{{ route('rafting') }}" class="block text-sm text-gray-600 hover:text-primary">Rafting</a></li>
                <li><a href="{{ route('outbound') }}" class="block text-sm text-gray-600 hover:text-primary">Outbound</a></li>
                <li><a href="/paintball" class="block text-sm text-gray-600 hover:text-primary">Paintball</a></li>
                <li><a href="{{ route('adventure-game') }}" class="block text-sm text-gray-600 hover:text-primary">Adventure Game</a></li>
                <li><a href="{{ route('gathering') }}" class="block text-sm text-gray-600 hover:text-primary">Gathering</a></li>
                <li><a href="{{ route('jeeptour') }}" class="block text-sm text-gray-600 hover:text-primary">Jeep Tour</a></li>
            </ul>
        </div>

        <a href="{{ url('/#tentang-kalisawah') }}" class="block font-bold text-primary">Tentang Kalisawah</a>
        <a href="/#paket-seru" class="block font-bold text-primary">Aktivitas</a>
        <a href="{{ route('kabar.index') }}" class="block font-bold text-primary">Cerita Kalisawah</a>
        <a href="#footer" class="block font-bold text-primary">Kontak</a>
    </div>
</nav>

<script>
    // Desktop Dropdown Toggle
    const dropdownBtn = document.getElementById('desktop-dropdown-btn');
    const dropdownMenu = document.getElementById('desktop-dropdown-menu');
    const desktopChevron = document.getElementById('desktop-chevron');

    dropdownBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isHidden = dropdownMenu.classList.contains('hidden');
        
        if (isHidden) {
            dropdownMenu.classList.remove('hidden');
            setTimeout(() => {
                dropdownMenu.classList.remove('opacity-0', 'translate-y-2');
                desktopChevron.classList.add('rotate-180');
            }, 10);
        } else {
            dropdownMenu.classList.add('opacity-0', 'translate-y-2');
            desktopChevron.classList.remove('rotate-180');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 300);
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('opacity-0', 'translate-y-2');
            desktopChevron.classList.remove('rotate-180');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 300);
        }
    });

    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Mobile Dropdown Toggle
    function toggleMobileDropdown() {
        const dropdown = document.getElementById('mobile-dropdown');
        const chevron = document.getElementById('mobile-chevron');
        dropdown.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
</script>

<style>
    html {
        scroll-behavior: smooth;
    }
</style>
