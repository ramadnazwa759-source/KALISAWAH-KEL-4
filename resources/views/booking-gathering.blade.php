@extends('layouts.app')

@section('title', 'Booking Gathering - Kalisawah Adventure')

@section('content')
    @php
        $paketName = request('paket', 'Paket Gathering');
        $is1Day = in_array(strtolower($paketName), ['kalisawah explorer', 'kalisawah challenge', 'kalisawah action']);
        $is2D1N = in_array(strtolower($paketName), ['kalisawah ultimate', 'kalisawah bonding', 'kalisawah kebersamaan']);
        
        $heroImage = asset('images/outbond.jpg'); // Adjust as needed
        $heroTitle = strtoupper($paketName);
        
        if ($is1Day) {
            $heroTopText = '1 Day Adventure';
        } elseif ($is2D1N) {
            $heroTopText = '2D1N Gathering';
        } else {
            $heroTopText = 'Gathering & Team Building';
        }

        if (strtolower($paketName) == 'kalisawah explorer' || strtolower($paketName) == 'kalisawah ultimate') {
            $heroSubtitle = '“Pengalaman lengkap untuk event corporate premium”';
        } elseif (strtolower($paketName) == 'kalisawah challenge') {
            $heroSubtitle = '“Pilihan terbaik untuk membangun kebersamaan tim secara efektif”';
        } elseif (strtolower($paketName) == 'kalisawah bonding') {
            $heroSubtitle = '“Pilihan terbaik untuk membangun kekompakan tim secara efektif”';
        } elseif (strtolower($paketName) == 'kalisawah action' || strtolower($paketName) == 'kalisawah kebersamaan') {
            $heroSubtitle = '“Paket hemat dengan pengalaman tetap maksimal”';
        } else {
            $heroSubtitle = 'Pesan Paket Gathering & Team Building Anda Sekarang!';
        }
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-[80vh] min-h-[600px] w-full overflow-hidden flex items-center justify-center text-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Gathering Kalisawah" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px]"></div>
        </div>

        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h3 class="text-secondary text-xl md:text-3xl font-black mb-2 tracking-widest uppercase drop-shadow-lg">{{ $heroTopText }}</h3>
            <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight uppercase tracking-tight drop-shadow-2xl">
                {{ $heroTitle }}
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
                {{ $heroSubtitle }}
            </p>
        </div>
    </section>

    <!-- CONTENT SECTION -->
    <section class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <div class="mb-12">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest bg-white px-8 py-4 rounded-2xl shadow-sm border border-gray-100 inline-block">
                    Gathering Package
                </h3>
            </div>

            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                <input type="hidden" id="paket_hidden" value="{{ $paketName }}">
                <input type="hidden" id="harga_hidden" value="{{ request('harga', 0) }}">
                
                <div class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2.5">
                            <label for="nama_pemesan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nama Pemesan</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Masukkan nama Anda" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                        <div class="space-y-2.5">
                            <label for="no_hp" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2.5">
                            <label for="tanggal_kunjungan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Tanggal Booking</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>
                        <div class="space-y-2.5">
                            <label for="jam" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jam</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy">
                        </div>
                    </div>

                    <!-- Jumlah Peserta Section -->
                    <div class="space-y-2.5">
                        <label for="jumlah_peserta" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jumlah Peserta (Min. 20 Pax)</label>
                        <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="20" min="20" required onchange="renderSelectedPackages()"
                            class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                    </div>

                    <!-- Paket Terpilih Section -->
                    <div class="space-y-6 pt-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] ml-1">Ringkasan Pesanan</h4>
                            <button type="button" onclick="openPackageSelector()" class="text-[11px] font-bold text-primary hover:text-hover-primary transition-colors flex items-center gap-2 mr-1 active:scale-95">
                                <i class="fa-solid fa-plus-circle text-[10px]"></i> TAMBAH PAKET
                            </button>
                        </div>
                        
                        <div id="selected_packages_container" class="space-y-4">
                            <!-- JS populated -->
                        </div>
                    </div>



                </div>

                <!-- Navigation Buttons -->
                <div class="mt-24 pt-12 flex flex-row flex-nowrap items-center justify-between gap-4 md:gap-8 border-t-2 border-gray-200">
                    <a href="javascript:history.back()" 
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-200 active:scale-[0.98] shadow-sm uppercase tracking-widest">
                        Kembali
                    </a>
                    
                    <button type="submit" id="submitBtn"
                        style="background-color: #FFC236;"
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-200 active:scale-[0.98] shadow-lg shadow-yellow-500/20 uppercase tracking-widest gap-3">
                        <span>Lanjut</span>
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>
                </div>

            </form>
        </div>
    </section>

    <!-- LOADING OVERLAY -->
    <div id="loadingOverlay" class="fixed inset-0 z-[200] bg-primary/95 hidden items-center justify-center flex-col text-white backdrop-blur-md">
        <div class="w-24 h-24 border-8 border-white/20 rounded-full flex items-center justify-center mb-8 relative">
            <div class="absolute inset-0 border-8 border-secondary border-t-transparent rounded-full animate-spin"></div>
        </div>
        <h3 class="text-3xl font-black mb-2">Memproses Data</h3>
        <p class="text-blue-200">Mohon tunggu sebentar...</p>
    </div>

    <!-- PACKAGE SELECTOR MODAL -->
    <div id="packageModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closePackageSelector()"></div>
        <div class="relative w-full max-w-5xl max-h-[90vh] overflow-y-auto bg-white rounded-[32px] shadow-2xl p-8 md:p-12 z-10 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-black text-dark-navy uppercase tracking-wider">Tambah Paket Gathering</h3>
                <button type="button" onclick="closePackageSelector()" class="text-gray-400 hover:text-gray-600 transition-colors text-2xl active:scale-95"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div id="package_modal_options" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- JS dynamically populates this based on category -->
            </div>
            <button type="button" onclick="closePackageSelector()" class="mt-8 w-full py-4 text-gray-400 font-bold hover:text-gray-600 transition-colors uppercase tracking-widest text-sm active:scale-95">Batal</button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const CATEGORIES_CONFIG = {
            'Kalisawah Explorer': { 
                price: 520000, 
                category: '1day', 
                img: 'https://picsum.photos/600/400?random=11', 
                duration: '± 7 Jam', 
                desc: '“Pengalaman lengkap untuk event corporate premium”', 
                tag: 'Premium Corporate' 
            },
            'Kalisawah Challenge': { 
                price: 360000, 
                category: '1day', 
                img: 'https://picsum.photos/600/400?random=12', 
                duration: '± 6 Jam', 
                desc: '“Pilihan terbaik untuk membangun kebersamaan tim secara efektif”', 
                tag: 'Best Seller' 
            },
            'Kalisawah Action': { 
                price: 290000, 
                category: '1day', 
                img: 'https://picsum.photos/600/400?random=13', 
                duration: '± 3.5 Jam', 
                desc: '“Paket hemat dengan pengalaman tetap maksimal”', 
                tag: 'Hemat Seru' 
            },
            'Kalisawah Ultimate': { 
                price: 685000, 
                category: '2d1n', 
                img: 'https://picsum.photos/600/400?random=21', 
                duration: '2 Hari 1 Malam', 
                desc: '“Pengalaman lengkap untuk event corporate premium”', 
                tag: 'Premium Corporate' 
            },
            'Kalisawah Bonding': { 
                price: 445000, 
                category: '2d1n', 
                img: 'https://picsum.photos/600/400?random=22', 
                duration: '2 Hari 1 Malam', 
                desc: '“Pilihan terbaik untuk membangun kekompakan tim secara efektif”', 
                tag: 'Best Seller' 
            },
            'Kalisawah Kebersamaan': { 
                price: 320000, 
                category: '2d1n', 
                img: 'https://picsum.photos/600/400?random=23', 
                duration: '2 Hari 1 Malam', 
                desc: '“Paket hemat dengan pengalaman tetap maksimal”', 
                tag: 'Hemat Seru' 
            }
        };

        let selectedPackages = [];
        let activeCategory = '1day';

        function openPackageSelector() {
            const container = document.getElementById('package_modal_options');
            container.innerHTML = '';
            
            Object.keys(CATEGORIES_CONFIG).forEach(name => {
                const pkg = CATEGORIES_CONFIG[name];
                if (pkg.category !== activeCategory) return;
                
                const isAdded = selectedPackages.some(p => p.name === name);
                const isBestSeller = pkg.tag === 'Best Seller';
                
                const html = `
                    <div class="bg-white rounded-[32px] overflow-hidden shadow-xl border ${isBestSeller ? 'border-secondary' : 'border-gray-100'} flex flex-col group hover:shadow-2xl transition-all duration-300 relative text-left">
                        ${isBestSeller ? `
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
                            <span class="bg-secondary text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-xl whitespace-nowrap">BEST SELLER</span>
                        </div>
                        ` : `
                        <div class="absolute top-4 left-4 z-20">
                            <span class="bg-blue-600 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">${pkg.tag}</span>
                        </div>
                        `}
                        
                        <div class="relative h-44 overflow-hidden shrink-0">
                            <img src="${pkg.img}" alt="${name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="p-6 flex flex-col flex-grow ${isBestSeller ? 'bg-secondary/5' : ''}">
                            <div class="mb-4">
                                <h3 class="text-primary text-lg font-black mb-1 leading-tight uppercase">${name}</h3>
                                <p class="text-gray-500 text-xs italic mb-2">${pkg.desc}</p>
                                <div class="flex items-center gap-2 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>${pkg.duration}</span>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t ${isBestSeller ? 'border-secondary/20' : 'border-gray-100'} mt-auto">
                                <div class="flex flex-col mb-4">
                                    <span class="text-dark-navy font-black text-2xl">Rp ${new Intl.NumberFormat('id-ID').format(pkg.price)}</span>
                                    <span class="text-gray-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">Per Orang (Pax)</span>
                                </div>
                                <button type="button" onclick="${isAdded ? '' : `addPackage('${name}')`}" 
                                    class="w-full ${isAdded ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-secondary text-white hover:opacity-90 active:scale-[0.98]'} py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-md">
                                    ${isAdded ? 'Sudah Dipilih' : 'Pilih Paket'}
                                    <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            });
            
            document.getElementById('packageModal').classList.remove('hidden');
            document.getElementById('packageModal').classList.add('flex');
        }

        function closePackageSelector() {
            document.getElementById('packageModal').classList.add('hidden');
            document.getElementById('packageModal').classList.remove('flex');
        }

        function addPackage(name) {
            const config = CATEGORIES_CONFIG[name];
            if (config) {
                activeCategory = config.category;
                const existing = selectedPackages.find(p => p.name === name);
                if (!existing) {
                    selectedPackages.push({ name: name, price: config.price });
                }
            }
            renderSelectedPackages();
            closePackageSelector();
        }

        function removePackage(index) {
            selectedPackages.splice(index, 1);
            renderSelectedPackages();
        }

        function renderSelectedPackages() {
            const container = document.getElementById('selected_packages_container');
            container.innerHTML = '';
            
            const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 20;

            selectedPackages.forEach((pkg, index) => {
                const totalHarga = pkg.price * jumlahPeserta;
                const html = `
                    <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-200 flex items-center justify-between gap-4 shadow-sm group hover:shadow-md transition-all duration-300">
                        <div class="flex-1">
                            <span class="block font-bold text-dark-navy text-lg uppercase tracking-wide group-hover:text-primary transition-colors">${pkg.name}</span>
                            <span class="block text-xs text-gray-400 font-bold mt-1">Rp ${new Intl.NumberFormat('id-ID').format(pkg.price)} / Orang</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="removePackage(${index})" 
                                class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm"><i class="fa-solid fa-trash text-sm"></i></button>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            });

            if (selectedPackages.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-[2rem]">
                        <p class="text-sm text-gray-400 italic font-medium mb-4">Belum ada paket dipilih</p>
                        <button type="button" onclick="openPackageSelector()" class="text-[11px] font-black text-primary uppercase tracking-widest hover:text-secondary transition-colors">
                            + Pilih Paket Sekarang
                        </button>
                    </div>
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Check hidden input first, then URL param
            let initialPaketRaw = document.getElementById('paket_hidden').value;
            if (!initialPaketRaw || initialPaketRaw === 'Paket Gathering') {
                const urlParams = new URLSearchParams(window.location.search);
                initialPaketRaw = urlParams.get('paket');
            }

            if (initialPaketRaw && CATEGORIES_CONFIG[initialPaketRaw]) {
                addPackage(initialPaketRaw);
            } else {
                renderSelectedPackages();
            }
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedPackages.length === 0) {
                alert('Silakan pilih minimal satu paket gathering.');
                return;
            }

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span>Memproses...</span>';

            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');

            const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 20;

            // Collect Data
            const formData = {
                nama_pemesan: document.getElementById('nama_pemesan').value,
                no_hp: document.getElementById('no_hp').value,
                tanggal_kunjungan: document.getElementById('tanggal_kunjungan').value,
                jam: document.getElementById('jam').value,
                jumlah_peserta: jumlahPeserta,
                selected_packages: selectedPackages.map(pkg => ({
                    name: pkg.name,
                    price: pkg.price,
                    qty: jumlahPeserta
                })),
                category: 'gathering'
            };

            // Save to localStorage
            localStorage.setItem('booking_data', JSON.stringify(formData));

            setTimeout(() => {
                window.location.href = "{{ url('/detail-booking-gathering') }}"; 
            }, 800);
        });
    </script>

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
