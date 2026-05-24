@php
    $footerData = [
        'location' => [
            'name' => 'Kalisawah Adventure',
            'address' => 'Songgon, Kab. Banyuwangi, Jawa Timur 68463',
            'maps_link' => 'https://maps.app.goo.gl/q59qwu'
        ],
        'package_menu' => [
            ['label' => 'Rafting Banyuwangi'],
            ['label' => 'Outbound Banyuwangi'],
            ['label' => 'Camping'],
            ['label' => 'Wargame'],
            ['label' => 'Jeep Tour'],
            ['label' => 'Adventure Game'],
        ],
        'about_menu' => [
            ['label' => 'Tentang Kalisawah'],
            ['label' => 'Cerita Kalisawah'],
            ['label' => 'FAQ'],
        ],
        'contact' => [
            'phone' => '+62 812-3456-7890',
            'email' => 'info@kalisawah.com',
            'socials' => [
                ['icon' => 'fa-instagram', 'url' => '#'],
                ['icon' => 'fa-tiktok', 'url' => '#'],
                ['icon' => 'fa-youtube', 'url' => '#'],
            ]
        ],
        'copyright' => [
            'year' => date('Y'),
            'text' => 'Kalisawah Adventure | All Rights Reserved'
        ]
    ];
@endphp

<footer id="footer" class="bg-dark-navy text-white pt-20 pb-10 px-6 md:px-20 scroll-mt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- Col 1: Logo & Info -->
        <div>
            <img src="{{ asset('images/logo-kalisawah-white.png') }}" alt="{{ $footerData['location']['name'] }}" class="h-12 mb-6">
            <h3 class="text-xl font-bold mb-4">{{ $footerData['location']['name'] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                {{ $footerData['location']['address'] }}
            </p>
            <a href="{{ $footerData['location']['maps_link'] }}" target="_blank" class="text-secondary hover:underline flex items-center gap-2 text-sm font-semibold">
                <i class="fa-solid fa-location-dot"></i> Lihat di Maps
            </a>
        </div>

        <!-- Col 2: Paket Seru -->
        <div>
            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">Paket Seru</h3>
            <ul class="space-y-3 text-gray-400 text-sm list-none p-0">
                @foreach($footerData['package_menu'] as $menu)
                    <li class="cursor-default">{{ $menu['label'] }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Col 3: Tentang Kami -->
        <div>
            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">Tentang Kami</h3>
            <ul class="space-y-3 text-gray-400 text-sm list-none p-0">
                @foreach($footerData['about_menu'] as $menu)
                    <li class="cursor-default">{{ $menu['label'] }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Col 4: Hubungi Kami -->
        <div>
            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">Hubungi Kami</h3>
            <ul class="space-y-4 text-gray-400 text-sm list-none p-0">
                <li class="flex items-center gap-3 cursor-default">
                    <i class="fa-solid fa-phone text-secondary"></i> {{ $footerData['contact']['phone'] }}
                </li>
                <li class="flex items-center gap-3 cursor-default">
                    <i class="fa-solid fa-envelope text-secondary"></i> {{ $footerData['contact']['email'] }}
                </li>
            </ul>
            <div class="flex gap-4 mt-8">
                @foreach($footerData['contact']['socials'] as $social)
                    <a href="{{ $social['url'] }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary transition-colors">
                        <i class="fa-brands {{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="max-w-7xl mx-auto border-t border-white/10 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
        <p>© {{ $footerData['copyright']['year'] }} {{ $footerData['copyright']['text'] }}</p>
        <div class="flex gap-6">
            <span class="cursor-default">Syarat & Ketentuan</span>
            <span class="cursor-default">Kebijakan Privasi</span>
        </div>
    </div>
</footer>


