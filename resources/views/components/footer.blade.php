@php

    $footerCategories = \App\Models\KategoriPaket::all();

    $footerData = [
        'location' => [
            'name' => 'Kalisawah Adventure',
            'address' => 'Glenmore, Kab. Banyuwangi, Jawa Timur 68466',
            'maps_link' => 'https://maps.google.com'
        ],

        'about_menu' => [
            [
                'label' => 'Tentang Kalisawah',
                'url' => '#tentang-kalisawah'
            ],
            [
                'label' => 'Cerita Kalisawah',
                'url' => '#cerita-kalisawah'
            ],
            [
                'label' => 'Testimoni Wisata',
                'url' => '#testimoni'
            ],
        ],

        'contact' => [
            'phone' => '+62 812-3456-7890',
            'email' => 'info@kalisawah.com',

            'socials' => [
                [
                    'icon' => 'fa-instagram',
                    'url' => '#'
                ],
                [
                    'icon' => 'fa-tiktok',
                    'url' => '#'
                ],
                [
                    'icon' => 'fa-youtube',
                    'url' => '#'
                ],
            ]
        ],

        'copyright' => [
            'year' => date('Y'),
            'text' => 'Kalisawah Adventure | All Rights Reserved'
        ]
    ];

@endphp

<footer id="footer"
    class="bg-dark-navy text-white pt-20 pb-10 px-6 md:px-20 scroll-mt-20">

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

        {{-- Logo & Lokasi --}}
        <div>

            <img src="{{ asset('images/logo-kalisawah-white.png') }}"
                 alt="{{ $footerData['location']['name'] }}"
                 class="h-12 mb-6"
                 onerror="this.src='https://picsum.photos/200/50'">

            <h3 class="text-xl font-bold mb-4">
                {{ $footerData['location']['name'] }}
            </h3>

            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                {{ $footerData['location']['address'] }}
            </p>

            <a href="{{ $footerData['location']['maps_link'] }}"
               target="_blank"
               class="text-secondary hover:underline flex items-center gap-2 text-sm font-semibold">

                <i class="fa-solid fa-location-dot"></i>

                Lihat di Maps

            </a>

        </div>

        {{-- Paket Wisata Dinamis --}}
        <div>

            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">
                Paket Seru
            </h3>

            <ul class="space-y-3 text-gray-400 text-sm list-none p-0">

                @forelse($footerCategories as $category)

                    <li>

                        <a href="{{ route('pengunjung.booking.booking-form', ['kategori' => $category->id]) }}"
                           class="hover:text-secondary transition-colors block py-0.5">

                            {{ $category->nama_kategori }}

                        </a>

                    </li>

                @empty

                    <li class="text-gray-500">
                        Belum ada kategori paket
                    </li>

                @endforelse

            </ul>

        </div>

        {{-- Tentang --}}
        <div>

            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">
                Tentang Kami
            </h3>

            <ul class="space-y-3 text-gray-400 text-sm list-none p-0">

                @foreach($footerData['about_menu'] as $menu)

                    <li>

                        <a href="{{ $menu['url'] }}"
                           class="hover:text-secondary transition-colors block py-0.5">

                            {{ $menu['label'] }}

                        </a>

                    </li>

                @endforeach

            </ul>

        </div>

        {{-- Kontak --}}
        <div>

            <h3 class="text-lg font-bold mb-6 border-l-4 border-secondary pl-3">
                Hubungi Kami
            </h3>

            <ul class="space-y-4 text-gray-400 text-sm list-none p-0">

                <li class="flex items-center gap-3">

                    <i class="fa-solid fa-phone text-secondary"></i>

                    {{ $footerData['contact']['phone'] }}

                </li>

                <li class="flex items-center gap-3">

                    <i class="fa-solid fa-envelope text-secondary"></i>

                    {{ $footerData['contact']['email'] }}

                </li>

            </ul>

            <div class="flex gap-4 mt-8">

                @foreach($footerData['contact']['socials'] as $social)

                    <a href="{{ $social['url'] }}"
                       class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary transition-colors text-white">

                        <i class="fa-brands {{ $social['icon'] }}"></i>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Bottom Footer --}}
    <div class="max-w-7xl mx-auto border-t border-white/10 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">

        <p>
            © {{ $footerData['copyright']['year'] }}
            {{ $footerData['copyright']['text'] }}
        </p>

        <div class="flex gap-6">

            <span class="hover:text-gray-400 cursor-pointer">
                Syarat & Ketentuan
            </span>

            <span class="hover:text-gray-400 cursor-pointer">
                Kebijakan Privasi
            </span>

        </div>

    </div>

</footer>