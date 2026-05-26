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
                            <label for="no_hp" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">NOMOR HP</label>
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
                                <label for="jumlah_pengunjung" class="text-[11px] font-bold text-primary uppercase tracking-[0.1em]">Pengunjung Tambahan</label>
                                <div class="flex items-center gap-4 bg-gray-50/50 p-2 rounded-2xl border border-gray-100">
                                    <button type="button" onclick="decrement('jumlah_pengunjung')" 
                                        class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-lg shadow-sm">-</button>
                                    <input type="number" id="jumlah_pengunjung" name="jumlah_pengunjung" value="0" min="0" readonly
                                        class="w-10 bg-transparent text-center font-bold text-primary text-sm outline-none">
                                    <button type="button" onclick="increment('jumlah_pengunjung')" 
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

                <!-- Catatan Section -->
                <div class="space-y-2.5">
                    <label for="catatan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Ada permintaan khusus? Tulis di sini..." 
                        class="w-full p-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400"></textarea>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="pt-6 text-center">
                    <button type="submit" class="h-[60px] w-full max-w-sm mx-auto bg-primary text-white font-bold text-lg rounded-2xl hover:bg-hover-primary transition-all shadow-lg shadow-primary/30">
                        Booking Sekarang
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
            'Nyaman Camp': {
                id: 1, // Sesuaikan dengan ID di database
                price: 350000,
                capacity: 6,
            },
            'Seru Camp': {
                id: 2, // Sesuaikan dengan ID di database
                price: 185000,
                capacity: 4,
            },
            'Santai Camp': {
                id: 3, // Sesuaikan dengan ID di database
                price: 150000,
                capacity: 4,
            },
            'Bawa Tenda Sendiri': {
                id: 4, // Sesuaikan dengan ID di database
                price: 25000, // Harga per orang
                capacity: 1, // Kapasitas per tiket
            }
        };

        const bookingForm = document.getElementById('bookingForm');
        const selectedPackagesContainer = document.getElementById('selected_packages_container');
        const packageModal = document.getElementById('packageModal');
        const loadingOverlay = document.getElementById('loadingOverlay');

        let selectedPackages = new Map();

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function openPackageSelector() {
            packageModal.classList.remove('hidden');
            packageModal.classList.add('flex');
        }

        function closePackageSelector() {
            packageModal.classList.add('hidden');
            packageModal.classList.remove('flex');
        }

        function addPackage(packageName) {
            if (!selectedPackages.has(packageName)) {
                selectedPackages.set(packageName, { ...PACKAGES_CONFIG[packageName], qty: 1 });
            }
            renderSelectedPackages();
            closePackageSelector();
        }

        function removePackage(packageName) {
            selectedPackages.delete(packageName);
            renderSelectedPackages();
        }

        function updateQuantity(packageName, change) {
            if (selectedPackages.has(packageName)) {
                const pkg = selectedPackages.get(packageName);
                pkg.qty = Math.max(1, pkg.qty + change);
                renderSelectedPackages();
            }
        }

        function renderSelectedPackages() {
            if (selectedPackages.size === 0) {
                selectedPackagesContainer.innerHTML = `
                    <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-2xl">
                        <p class="text-gray-400 font-medium">Belum ada paket yang dipilih.</p>
                        <button type="button" onclick="openPackageSelector()" class="mt-4 text-sm font-bold text-primary hover:underline">
                            + Tambah Paket
                        </button>
                    </div>
                `;
                return;
            }

            selectedPackagesContainer.innerHTML = Array.from(selectedPackages.entries()).map(([name, pkg]) => `
                <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-bold text-dark-navy">${name}</h5>
                            <p class="text-sm text-primary font-semibold">${formatRupiah(pkg.price)}</p>
                        </div>
                        <button type="button" onclick="removePackage('${name}')" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <div class="flex justify-end items-center mt-4">
                        <div class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-gray-200">
                            <button type="button" onclick="updateQuantity('${name}', -1)" class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-all font-bold">-</button>
                            <input type="number" value="${pkg.qty}" min="1" readonly class="w-10 bg-transparent text-center font-bold text-dark-navy text-sm outline-none">
                            <button type="button" onclick="updateQuantity('${name}', 1)" class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-all font-bold">+</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        bookingForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');

            const formData = new FormData(bookingForm);
            const data = Object.fromEntries(formData.entries());

            const payload = {
                nama_pemesan: data.nama_pemesan,
                no_hp: data.no_hp,
                tanggal_kunjungan: data.tanggal_kunjungan,
                jam: data.jam,
                jumlah_pengunjung: parseInt(data.jumlah_pengunjung) || 0,
                catatan: data.catatan || '',
                paket: [],
                fasilitas: []
            };

            selectedPackages.forEach(pkg => {
                payload.paket.push({
                    paket_wisata_id: pkg.id,
                    qty: pkg.qty
                });
            });

            document.querySelectorAll('input[name^="fasilitas["]').forEach(input => {
                if (input.type === 'number' && parseInt(input.value) > 0) {
                    const id = input.id.split('_')[1];
                    payload.fasilitas.push({
                        fasilitas_id: parseInt(id),
                        qty: parseInt(input.value)
                    });
                }
            });

            try {
                const response = await fetch('/api/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                loadingOverlay.classList.add('hidden');
                loadingOverlay.classList.remove('flex');

                if (!response.ok) {
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join('\n');
                    } else if (result.message) {
                        errorMessage = result.message;
                    }
                    alert(`Error: ${errorMessage}`);
                    return;
                }

                alert('Booking berhasil! Kode Booking: ' + result.data.kode_booking);
                window.location.href = `/tracking?kode_booking=${result.data.kode_booking}`;

            } catch (error) {
                loadingOverlay.classList.add('hidden');
                loadingOverlay.classList.remove('flex');
                console.error('Submission error:', error);
                alert('Terjadi kesalahan saat mengirim data. Periksa koneksi Anda.');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            renderSelectedPackages();
        });

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