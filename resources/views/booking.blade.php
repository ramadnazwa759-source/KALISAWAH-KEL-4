@extends('layouts.app')

@section('title', 'Layanan Camping - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[60vh] min-h-[500px] w-full overflow-hidden flex items-center justify-center text-center">
        <img src="{{ asset('images/camping.jpg') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h1 class="text-white text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Layanan Camping Kalisawah <br> Adventure
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed">
                Kalisawah Adventure menawarkan pengalaman camping di alam terbuka dengan suasana asri dan private.
            </p>
        </div>
    </section>

    <!-- CONTENT SECTION (Full-width vertical flow, no main card) -->
    <section class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <!-- PACKAGE TITLE -->
            <div class="mb-12">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest bg-white px-8 py-4 rounded-2xl shadow-sm border border-gray-100 inline-block">
                    {{ request('paket') ? 'Paket ' . request('paket') : 'Pilih Paket Camp' }}
                </h3>
            </div>

            <!-- FORM START -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                <input type="hidden" id="paket_hidden" value="{{ request('paket', 'Pilih Paket Camp') }}">
                
                <!-- 1. CORE DATA SECTION -->
                <div class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2.5">
                            <label for="nama_pemesan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Name</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Enter your name" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
 
                        <!-- Whatsapp -->
                        <div class="space-y-2.5">
                            <label for="no_hp" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Whatsapp</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Enter your number" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="space-y-2.5">
                            <label for="tanggal_kunjungan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Tanggal</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>

                        <!-- Jam -->
                        <div class="space-y-2.5">
                            <label for="jam" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jam</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy">
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
                        
                        <div id="selected_packages_container" class="space-y-6">
                            <!-- JS populated -->
                        </div>
                    </div>

                    <!-- Jumlah Grid (Visitor Section) -->
                    <div class="space-y-6 pt-6">
                        <div class="p-8 md:p-10 bg-white rounded-[2rem] border border-gray-200 shadow-sm space-y-6">
                            <div class="flex items-center justify-between gap-4">
                                <label for="jumlah_orang" class="text-[11px] font-bold text-primary uppercase tracking-[0.1em]">Pengunjung Tambahan</label>
                                <div class="flex items-center gap-4 bg-gray-50/50 p-2 rounded-2xl border border-gray-100">
                                    <button type="button" onclick="decrement('jumlah_orang')" 
                                        class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-lg shadow-sm">-</button>
                                    <input type="number" id="jumlah_orang" name="jumlah_orang" value="0" min="0" readonly
                                        class="w-10 bg-transparent text-center font-bold text-primary text-sm outline-none">
                                    <button type="button" onclick="increment('jumlah_orang')" 
                                        class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-lg shadow-sm">+</button>
                                </div>
                            </div>
                            <p class="text-[11px] font-medium text-gray-400 italic">“Tambahan orang di luar kapasitas paket dikenakan Rp 25.000/orang.”</p>
                        </div>
                        
                        <div id="jumlah_tenda_wrapper" class="hidden p-8 bg-white rounded-[2rem] border border-gray-200 shadow-sm flex items-center justify-between gap-4">
                            <label for="jumlah_tenda" class="text-[11px] font-bold text-primary uppercase tracking-[0.1em]">Jumlah Tenda</label>
                            <input type="number" id="jumlah_tenda" name="jumlah_tenda" min="0" value="0" 
                                class="w-20 text-right font-bold text-primary outline-none bg-transparent">
                        </div>

                        <!-- DYNAMIC FIELD: Ukuran Tenda (Only for Bawa Tenda Sendiri) -->
                        <div id="ukuran_tenda_container" class="hidden p-8 bg-white rounded-[2rem] border border-gray-200 shadow-sm flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-tent text-primary text-sm"></i>
                                <label for="ukuran_tenda" class="text-[11px] font-bold text-primary uppercase tracking-[0.1em]">Ukuran Tenda</label>
                            </div>
                            <select id="ukuran_tenda" name="ukuran_tenda" 
                                class="w-full md:w-64 h-[46px] px-4 rounded-xl border border-gray-200 font-bold text-primary focus:border-primary outline-none bg-white appearance-none cursor-pointer text-sm">
                                <option value="3-4">Tenda Kapasitas 3–4 Orang</option>
                                <option value="6+">Tenda Kapasitas 6+ Orang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. TAMBAH FASILITAS SECTION -->
                <div class="space-y-10">
                    <div class="text-center">
                        <h3 class="text-2xl md:text-3xl font-black text-dark-navy uppercase tracking-wide">Tambah Fasilitas</h3>
                        <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @php
                            $fasilitas = [
                                ['id' => 1, 'name' => 'Peralatan masak piknik 1 set', 'price' => 'Rp.50.000.-/set', 'desc' => '• 1 Kompor<br>• 1 Set Barbeque Pan<br>• 1 Set Peralatan Makan'],
                                ['id' => 2, 'name' => 'Kayu Api Unggun', 'price' => 'Rp.25.000,-/ikat'],
                                ['id' => 3, 'name' => 'Tabung gas portable', 'price' => 'Rp.35.000,-/tabung'],
                                ['id' => 4, 'name' => 'Sleeping bag', 'price' => 'Rp.10.000,-'],
                                ['id' => 5, 'name' => 'Sound System', 'price' => 'Rp.100.000,-/3 jam'],
                                ['id' => 6, 'name' => 'Matras tebal', 'price' => 'Rp.20.000 /malam']
                            ];
                        @endphp

                        @foreach($fasilitas as $item)
                        <div class="group bg-white rounded-3xl border border-gray-100 p-6 md:p-8 hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                        <h4 class="font-black text-dark-navy text-xl leading-tight">{{ $item['name'] }}</h4>
                                    </div>
                                    <p class="text-primary font-bold text-sm mb-4">{{ $item['price'] }}</p>
                                    @if(isset($item['desc']))
                                    <div class="bg-gray-50/80 rounded-2xl p-5 border-l-4 border-secondary/30">
                                        <p class="text-gray-500 text-sm font-medium leading-relaxed italic">{!! $item['desc'] !!}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-2xl border border-gray-100 self-end md:self-center">
                                    <button type="button" onclick="decrement('fasilitas_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">-</button>
                                    <input type="number" id="fasilitas_{{ $item['id'] }}" name="fasilitas[{{ $item['id'] }}]" value="0" min="0" readonly
                                        class="w-14 bg-transparent text-center font-black text-dark-navy text-xl outline-none">
                                    <button type="button" onclick="increment('fasilitas_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">+</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. PAKET MAKANAN SECTION -->
                <div class="space-y-10">
                    <div class="text-center">
                        <h3 class="text-2xl md:text-3xl font-black text-dark-navy uppercase tracking-wide">Paket makanan</h3>
                        <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        @php
                            $makanan = [
                                ['id' => 101, 'name' => 'Paket Prasmanan', 'price' => '(Rp.25.000 - Rp.35.000) /Porsi'],
                                ['id' => 102, 'name' => 'Paket Nasi Kotak', 'price' => '(Rp.16.000,-)/Porsi']
                            ];
                        @endphp

                        @foreach($makanan as $item)
                        <div class="group bg-white rounded-3xl border border-gray-100 p-6 md:p-8 hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                        <h4 class="font-black text-dark-navy text-xl leading-tight">{{ $item['name'] }}</h4>
                                    </div>
                                    <p class="text-primary font-bold text-sm">{{ $item['price'] }}</p>
                                </div>
                                <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-2xl border border-gray-100 self-end md:self-center">
                                    <button type="button" onclick="decrement('makanan_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">-</button>
                                    <input type="number" id="makanan_{{ $item['id'] }}" name="makanan[{{ $item['id'] }}]" value="0" min="0" readonly
                                        class="w-14 bg-transparent text-center font-black text-dark-navy text-xl outline-none">
                                    <button type="button" onclick="increment('makanan_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">+</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 p-6 bg-blue-50/50 rounded-2xl border-l-4 border-primary italic">
                        <p class="font-bold text-primary">Menu Makanan Ala Menu Desa</p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-24 pt-12 flex flex-row flex-nowrap items-center justify-between gap-4 md:gap-8 border-t-2 border-gray-200">
                    <a href="{{ route('camping') }}" 
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

    <!-- SCRIPTS -->
    <!-- PACKAGE SELECTOR MODAL -->
    <div id="packageModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closePackageSelector()"></div>
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden p-8">
            <h3 class="text-xl font-black text-dark-navy mb-6">Pilih Paket</h3>
            <div class="grid grid-cols-1 gap-4">
                <button type="button" onclick="addPackage('Nyaman Camp')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary">Nyaman Camp</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 350.000 / 6 Orang</span>
                </button>
                <button type="button" onclick="addPackage('Seru Camp')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary">Seru Camp</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 185.000 / 4 Orang</span>
                </button>
                <button type="button" onclick="addPackage('Santai Camp')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary">Santai Camp</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 150.000 / 4 Orang</span>
                </button>
                <button type="button" onclick="addPackage('Bawa Tenda Sendiri')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary">Bawa Tenda Sendiri</span>
                    <span class="block text-xs text-gray-400 font-bold">Tiket Rp 25.000 / Orang</span>
                </button>
            </div>
            <button type="button" onclick="closePackageSelector()" class="mt-8 w-full py-4 text-gray-400 font-bold hover:text-gray-600">Batal</button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const PACKAGES_CONFIG = {
            'Nyaman Camp': { price: 350000, pax: 6, includesTenda: true },
            'Seru Camp': { price: 185000, pax: 4, includesTenda: true },
            'Santai Camp': { price: 150000, pax: 4, includesTenda: true },
            'Bawa Tenda Sendiri': { price: 25000, pax: 0, includesTenda: false }
        };

        let selectedPackages = [];

        function increment(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value) + 1;
        }

        function decrement(id) {
            const input = document.getElementById(id);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function openPackageSelector() {
            document.getElementById('packageModal').classList.remove('hidden');
            document.getElementById('packageModal').classList.add('flex');
        }

        function closePackageSelector() {
            document.getElementById('packageModal').classList.add('hidden');
            document.getElementById('packageModal').classList.remove('flex');
        }

        function addPackage(name) {
            selectedPackages.push({ name: name, qty: 1 });
            renderSelectedPackages();
            closePackageSelector();
            updateTendaVisibility();
        }

        function removePackage(index) {
            selectedPackages.splice(index, 1);
            renderSelectedPackages();
            updateTendaVisibility();
        }

        function updatePackageQty(index, delta) {
            selectedPackages[index].qty = Math.max(1, selectedPackages[index].qty + delta);
            renderSelectedPackages();
        }

        function renderSelectedPackages() {
            const container = document.getElementById('selected_packages_container');
            container.innerHTML = '';

            selectedPackages.forEach((pkg, index) => {
                const config = PACKAGES_CONFIG[pkg.name];
                const html = `
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-200 flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex-1">
                            <span class="block font-bold text-dark-navy text-lg uppercase tracking-wide">${pkg.name}</span>
                            <span class="block text-xs text-gray-400 font-bold mt-1">${config.pax > 0 ? 'Kapasitas ' + config.pax + ' Orang' : 'Sewa Lahan'}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-primary text-sm">${pkg.qty} Paket</span>
                        </div>
                    </div>
                `;
                container.innerHTML += html;
            });

            if (selectedPackages.length === 0) {
                container.innerHTML = '<p class="text-xs text-gray-400 italic text-center py-4 border-2 border-dashed border-gray-100 rounded-2xl">Belum ada paket dipilih</p>';
            }
        }

        function updateTendaVisibility() {
            const hasCustomTenda = selectedPackages.some(pkg => !PACKAGES_CONFIG[pkg.name].includesTenda);
            const tendaWrapper = document.getElementById('jumlah_tenda_wrapper');
            const ukuranTendaContainer = document.getElementById('ukuran_tenda_container');

            if (hasCustomTenda) {
                tendaWrapper.classList.remove('hidden');
                ukuranTendaContainer.classList.remove('hidden');
                ukuranTendaContainer.classList.add('flex');
            } else {
                tendaWrapper.classList.add('hidden');
                ukuranTendaContainer.classList.add('hidden');
                ukuranTendaContainer.classList.remove('flex');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const initialPaket = document.getElementById('paket_hidden').value;
            if (initialPaket && initialPaket !== 'Pilih Paket Camp') {
                addPackage(initialPaket);
            } else {
                renderSelectedPackages();
            }
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedPackages.length === 0) {
                alert('Silakan pilih minimal satu paket.');
                return;
            }

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = 'Memproses...';

            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');

            // Collect Data
            const formData = {
                nama_pemesan: document.getElementById('nama_pemesan').value,
                no_hp: document.getElementById('no_hp').value,
                tanggal_kunjungan: document.getElementById('tanggal_kunjungan').value,
                jam: document.getElementById('jam').value,
                total_pengunjung: document.getElementById('jumlah_orang').value,
                jumlah_tenda: document.getElementById('jumlah_tenda').value,
                ukuran_tenda: document.getElementById('ukuran_tenda').value,
                selected_packages: selectedPackages,
                fasilitas: {},
                makanan: {}
            };

            // Collect Dynamic Items
            document.querySelectorAll('input[id^="fasilitas_"]').forEach(input => {
                const id = input.id.split('_')[1];
                if(parseInt(input.value) > 0) formData.fasilitas[id] = parseInt(input.value);
            });
            document.querySelectorAll('input[id^="makanan_"]').forEach(input => {
                const id = input.id.split('_')[1];
                if(parseInt(input.value) > 0) formData.makanan[id] = parseInt(input.value);
            });

            // Save to localStorage
            localStorage.setItem('booking_data', JSON.stringify(formData));

            // Redirect
            setTimeout(() => {
                window.location.href = "{{ route('booking.detail') }}";
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
