@extends('layouts.app')

@section('title', 'Booking Paintball - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION (Easy to change)
        $heroImage = asset('images/wargame1.jpg');
        $heroTitle = 'PAINT BALL';
        $heroSubtitle = 'Siapkan Strategi dan Team Terbaikmu!';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-[80vh] min-h-[600px] w-full overflow-hidden flex items-center justify-center text-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Hero Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px]"></div>
        </div>

        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight uppercase tracking-tight drop-shadow-2xl">
                {!! $heroTitle !!}
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
                {{ $heroSubtitle }}
            </p>
        </div>
    </section>

    <!-- CONTENT SECTION -->
    <section class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <!-- PACKAGE TITLE -->
            <div class="mb-12">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest bg-white px-8 py-4 rounded-2xl shadow-sm border border-gray-100 inline-block">
                    Paintball Adventure
                </h3>
            </div>

            <!-- FORM START -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                
                <!-- 1. CORE DATA SECTION -->
                <div class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2.5">
                            <label for="nama_pemesan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nama Pemesan</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Masukkan nama Anda" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
 
                        <!-- Whatsapp -->
                        <div class="space-y-2.5">
                            <label for="no_hp" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="space-y-2.5">
                            <label for="tanggal_kunjungan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Tanggal Booking</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>

                        <!-- Jam Booking -->
                        <div class="space-y-2.5 md:col-span-2">
                            <label for="jam" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jam Booking</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>
                    </div>

                    <!-- Paket Terpilih Section -->
                    <div class="space-y-6 pt-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] ml-1">Daftar Paket Dipilih</h4>
                            <button type="button" onclick="openPackageSelector()" class="text-[11px] font-bold text-primary hover:text-hover-primary transition-colors flex items-center gap-2 mr-1">
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
                    <a href="{{ url('paintball') }}" 
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/20 active:scale-95 shadow-sm uppercase tracking-widest cursor-pointer">
                        Kembali
                    </a>
                    
                    <button type="submit" id="submitBtn"
                        style="background-color: #FFC236;"
                        class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-yellow-500/30 active:scale-95 shadow-md uppercase tracking-widest gap-3 cursor-pointer">
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
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden p-8">
            <h3 class="text-xl font-black text-dark-navy mb-6">Pilih Paket Paintball</h3>
            <div class="grid grid-cols-1 gap-4">
                <button type="button" onclick="addPackage('Paket 1')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary uppercase">Paket 1 (30 Peluru)</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 110.000 / Orang</span>
                </button>
                <button type="button" onclick="addPackage('Paket 2')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary uppercase">Paket 2 (40 Peluru)</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 140.000 / Orang</span>
                </button>
            </div>
            <button type="button" onclick="closePackageSelector()" class="mt-8 w-full py-4 text-gray-400 font-bold hover:text-gray-600 transition-colors uppercase tracking-widest text-sm">Tutup</button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const PACKAGES_CONFIG = {
            'Paket 1': { price: 110000 },
            'Paket 2': { price: 140000 }
        };

        let selectedPackages = [];

        function openPackageSelector() {
            document.getElementById('packageModal').classList.remove('hidden');
            document.getElementById('packageModal').classList.add('flex');
        }

        function closePackageSelector() {
            document.getElementById('packageModal').classList.add('hidden');
            document.getElementById('packageModal').classList.remove('flex');
        }

        function addPackage(name) {
            const existing = selectedPackages.find(p => p.name === name);
            if (existing) {
                existing.qty++;
            } else {
                selectedPackages.push({ name: name, qty: 4 });
            }
            renderSelectedPackages();
            closePackageSelector();
        }

        function updatePackageQty(index, delta) {
            if (selectedPackages[index].qty <= 4 && delta < 0) return;
            selectedPackages[index].qty += delta;
            renderSelectedPackages();
        }

        function renderSelectedPackages() {
            const container = document.getElementById('selected_packages_container');
            container.innerHTML = '';

            selectedPackages.forEach((pkg, index) => {
                const config = PACKAGES_CONFIG[pkg.name];
                const html = `
                    <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-200 flex items-center justify-between gap-4 shadow-sm group hover:shadow-md transition-all duration-300">
                        <div class="flex-1">
                            <span class="block font-bold text-dark-navy text-lg uppercase tracking-wide group-hover:text-primary transition-colors">${pkg.name}</span>
                            <span class="block text-xs text-gray-400 font-bold mt-1">Rp ${new Intl.NumberFormat('id-ID').format(config.price)} / Orang</span>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-50/50 p-2 rounded-2xl border border-gray-100">
                            <button type="button" onclick="updatePackageQty(${index}, -1)" 
                                class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm ${pkg.qty <= 4 ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''}"><i class="fa-solid fa-minus text-xs"></i></button>
                            <span class="w-10 text-center font-black text-primary text-lg">${pkg.qty}</span>
                            <button type="button" onclick="updatePackageQty(${index}, 1)" 
                                class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            });

            if (selectedPackages.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-[2rem]">
                        <p class="text-sm text-gray-400 italic font-medium mb-4">Belum ada paket dipilih</p>
                        <button type="button" onclick="openPackageSelector()" class="text-[11px] font-black text-primary uppercase tracking-widest hover:text-secondary transition-colors flex items-center justify-center gap-2 mx-auto">
                            <i class="fa-solid fa-plus"></i> Tambah Paket Sekarang
                        </button>
                    </div>
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Default load paket 1
            addPackage('Paket 1');
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedPackages.length === 0) {
                alert('Silakan pilih minimal 1 paket paintball.');
                return;
            }

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span>Memproses...</span>';

            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');

            // Kita hapus baris yang override selectedPackages[0].qty karena sekarang multi paket
            // (Sebelumnya: selectedPackages[0].qty = jumlahPeserta;)

            // Collect Data
            const formData = {
                nama_pemesan: document.getElementById('nama_pemesan').value,
                no_hp: document.getElementById('no_hp').value,
                tanggal_kunjungan: document.getElementById('tanggal_kunjungan').value,
                jam: document.getElementById('jam').value,
                total_pengunjung: selectedPackages.reduce((acc, curr) => acc + curr.qty, 0),
                selected_packages: selectedPackages,
                category: 'paintball'
            };

            // Save to localStorage
            localStorage.setItem('booking_data', JSON.stringify(formData));

            setTimeout(() => {
                window.location.href = "{{ url('detail-booking-paintball') }}";
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
