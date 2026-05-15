@extends('layouts.app')

@section('title', 'Detail Pemesanan - Kalisawah Adventure')

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

    <!-- SUMMARY SECTION -->
    <section id="ringkasan" class="pt-32 pb-60 px-6 bg-[#F8FAFC] scroll-mt-20">
        <div class="max-w-[850px] mx-auto">
            
            <div class="mb-16 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-dark-navy mb-4">Rincian Reservasi</h2>
                <div class="w-16 h-1.5 bg-secondary mx-auto rounded-full"></div>
                <p class="mt-8 text-gray-400 font-medium max-w-lg mx-auto text-lg">Pastikan seluruh data di bawah ini sudah benar untuk menghindari kesalahan saat hari H.</p>
            </div>

            <!-- DATA LIST (Populated by JS) -->
            <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 border border-gray-100 space-y-12">
                
                <!-- Main Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Nama Pelanggan</label>
                            <p id="display_nama" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">No. WhatsApp</label>
                            <p id="display_wa" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Paket Pilihan</label>
                            <p id="display_paket" class="text-2xl font-black text-primary border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Tanggal Reservasi</label>
                            <p id="display_tanggal" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Waktu Kedatangan</label>
                            <p id="display_waktu" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div class="flex flex-col gap-6 w-full">
                            <div class="flex gap-10">
                                <div class="flex-1">
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Pengunjung Tambahan</label>
                                    <p id="display_orang" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">0</p>
                                </div>
                                <div id="tenda_display_container" class="flex-1 hidden">
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Tenda</label>
                                    <p id="display_tenda" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">0</p>
                                </div>
                            </div>
                            <div id="ukuran_tenda_display_container" class="hidden">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Ukuran Tenda (Sewa Lahan)</label>
                                <p id="display_ukuran_tenda" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ADD-ONS SUMMARY (JS Toggled) -->
                <div id="addons_container" class="pt-12 border-t-2 border-gray-50 hidden">
                    <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-secondary rounded-full"></span>
                        Tambahan Layanan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div id="fasilitas_list_container" class="bg-blue-50/30 rounded-3xl p-6 border border-blue-50 hidden">
                            <p class="text-sm font-black text-primary uppercase mb-4 tracking-widest">Fasilitas</p>
                            <ul id="display_fasilitas" class="space-y-3"></ul>
                        </div>

                        <div id="makanan_list_container" class="bg-orange-50/30 rounded-3xl p-6 border border-orange-50 hidden">
                            <p class="text-sm font-black text-secondary uppercase mb-4 tracking-widest">Paket Makanan</p>
                            <ul id="display_makanan" class="space-y-3"></ul>
                        </div>
                    </div>
                </div>

                <!-- 4. RINCIAN HARGA SECTION -->
                <div id="pricing_container" class="pt-12 border-t-2 border-gray-100 mt-12">
                    <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary rounded-full"></span>
                        Rincian Harga
                    </h3>
                    
                    <div class="space-y-4 bg-gray-50/40 rounded-3xl p-8 border border-gray-100">
                        <div id="price_items_container" class="space-y-4">
                            <!-- JS Items: Packages, Visitors, Add-ons -->
                        </div>

                        <div class="pt-8 border-t-2 border-gray-200 mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-2xl font-black text-dark-navy uppercase tracking-tighter">Total Pembayaran</span>
                            <span class="text-4xl font-black text-primary drop-shadow-sm" id="display_total">Rp 0</span>
                        </div>
                    </div>
                    <p class="mt-4 text-center text-gray-400 text-sm italic font-medium">*Pembayaran DP minimal 10%, pelunasan dilakukan saat kedatangan di lokasi (Check-in)</p>
                </div>
            </div>

            <!-- FOOTER BUTTONS -->
            <div class="mt-24 pt-12 border-t-2 border-gray-200 flex flex-row flex-nowrap items-center justify-between gap-4 md:gap-8">
                <a href="{{ route('booking.create') }}" 
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-200 active:scale-[0.98] shadow-sm uppercase tracking-widest">
                    Kembali
                </a>
                
                <button type="button" id="confirmBtn" onclick="goToPayment()"
                    style="background-color: #FFC236;"
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-200 active:scale-[0.98] shadow-lg shadow-yellow-500/20 uppercase tracking-widest gap-3">
                    <span>Lanjut</span>
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- LOADING OVERLAY -->
    <div id="loadingOverlayDetail" class="fixed inset-0 z-[200] bg-primary/95 hidden items-center justify-center flex-col text-white backdrop-blur-md">
        <div class="w-24 h-24 border-8 border-white/20 rounded-full flex items-center justify-center mb-8 relative">
            <div class="absolute inset-0 border-8 border-secondary border-t-transparent rounded-full animate-spin"></div>
        </div>
        <h3 class="text-3xl font-black mb-2">Memproses Pesanan</h3>
        <p class="text-blue-200">Mohon tunggu sebentar...</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let data = null;
            try {
                data = JSON.parse(localStorage.getItem('booking_data'));
            } catch (e) {
                console.error("Error parsing booking data", e);
            }

            if (!data || !data.nama_pemesan || !data.selected_packages || data.selected_packages.length === 0) {
                alert('Data booking tidak ditemukan atau tidak lengkap. Silakan isi kembali data reservasi Anda.');
                window.location.href = "{{ route('booking.create') }}";
                return;
            }

            // Prices Data
            const PRICING_CONFIG = {
                pakets: {
                    'Nyaman Camp': { price: 350000, pax: 6, includesTenda: true },
                    'Seru Camp': { price: 185000, pax: 4, includesTenda: true },
                    'Santai Camp': { price: 150000, pax: 4, includesTenda: true },
                    'Bawa Tenda Sendiri': { price: 25000, pax: 0, includesTenda: false }
                },
                fasilitas: {
                    1: { name: 'Peralatan Masak', price: 50000 },
                    2: { name: 'Kayu Api Unggun', price: 25000 },
                    3: { name: 'Tabung Gas', price: 35000 },
                    4: { name: 'Sleeping Bag', price: 10000 },
                    5: { name: 'Sound System', price: 100000 },
                    6: { name: 'Matras Tebal', price: 20000 }
                },
                makanan: {
                    101: { name: 'Paket Prasmanan', price: 30000 },
                    102: { name: 'Paket Nasi Kotak', price: 16000 }
                }
            };

            const formatIDR = (val) => {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            };

            // Map Data
            document.getElementById('display_nama').innerText = data.nama_pemesan;
            document.getElementById('display_wa').innerText = data.no_hp;
            document.getElementById('display_tanggal').innerText = data.tanggal_kunjungan;
            document.getElementById('display_waktu').innerText = data.jam + ' WIB';
            document.getElementById('display_orang').innerText = data.total_pengunjung;

            // Clear and start populating
            let totalHarga = 0;
            const priceItemsContainer = document.getElementById('price_items_container');
            priceItemsContainer.innerHTML = ''; 

            // 1. Calculate Packages & Extra Tickets
            let totalCapacity = 0;
            let packagesPrice = 0;
            const packagesDisplay = document.getElementById('display_paket');
            packagesDisplay.innerHTML = '';
            
            let hasSewaLahan = false;

            // Header for Packages
            priceItemsContainer.innerHTML += `
                <div class="text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Subtotal Paket & Tiket</div>
            `;

            data.selected_packages.forEach(pkg => {
                const config = PRICING_CONFIG.pakets[pkg.name];
                
                if (pkg.name === 'Bawa Tenda Sendiri') {
                    hasSewaLahan = true;
                    packagesDisplay.innerHTML += `<div class="text-sm font-bold text-gray-500 mb-1">${pkg.name}</div>`;
                } else {
                    const subtotal = config.price * pkg.qty;
                    packagesPrice += subtotal;
                    totalCapacity += (config.pax * pkg.qty);
                    
                    packagesDisplay.innerHTML += `<div class="text-sm font-bold text-gray-500 mb-1">${pkg.name} x ${pkg.qty}</div>`;
                    
                    priceItemsContainer.innerHTML += `
                        <div class="flex justify-between items-center text-sm md:text-base">
                            <span class="text-gray-500 font-medium">${pkg.name} (${pkg.qty} x ${formatIDR(config.price)})</span>
                            <span class="text-dark-navy font-bold">${formatIDR(subtotal)}</span>
                        </div>
                    `;
                }
            });

            if (packagesDisplay.innerHTML === '') packagesDisplay.innerText = '-';

            // 2. Extra People Calculation
            const extraPeople = parseInt(data.total_pengunjung) || 0;
            const extraTicketPrice = extraPeople * 25000;
            
            if (extraPeople > 0) {
                priceItemsContainer.innerHTML += `
                    <div class="flex justify-between items-center text-sm md:text-base">
                        <span class="text-gray-500 font-medium">Pengunjung Tambahan (${extraPeople} x ${formatIDR(25000)})</span>
                        <span class="text-dark-navy font-bold">${formatIDR(extraTicketPrice)}</span>
                    </div>
                `;
            }

            // 3. Sewa Lahan Logic
            let sewaLahanPrice = 0;
            if (hasSewaLahan) {
                document.getElementById('tenda_display_container').classList.remove('hidden');
                document.getElementById('display_tenda').innerText = data.jumlah_tenda || 0;
                document.getElementById('ukuran_tenda_display_container').classList.remove('hidden');
                const ukuran = data.ukuran_tenda === '3-4' ? 'Tenda 3-4 Orang' : 'Tenda 6+ Orang';
                document.getElementById('display_ukuran_tenda').innerText = ukuran;
                
                sewaLahanPrice = data.ukuran_tenda === '6+' ? 50000 : 25000;
                
                priceItemsContainer.innerHTML += `
                    <div class="flex justify-between items-center text-sm md:text-base">
                        <span class="text-gray-500 font-medium">Sewa Lahan (${ukuran})</span>
                        <span class="text-dark-navy font-bold">${formatIDR(sewaLahanPrice)}</span>
                    </div>
                `;
            }
            
            totalHarga += packagesPrice + extraTicketPrice + sewaLahanPrice;

            // 2. Handle Add-ons (Fasilitas)
            let hasAddons = false;

            if (Object.keys(data.fasilitas).length > 0) {
                hasAddons = true;
                const container = document.getElementById('fasilitas_list_container');
                const list = document.getElementById('display_fasilitas');
                container.classList.remove('hidden');

                // Header for Services
                priceItemsContainer.innerHTML += `
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mt-6 mb-4">Tambahan Layanan</div>
                `;
                
                Object.entries(data.fasilitas).forEach(([id, qty]) => {
                    const item = PRICING_CONFIG.fasilitas[id];
                    const subtotal = item.price * qty;
                    totalHarga += subtotal;

                    // Update Data List
                    list.innerHTML += `<li class="flex justify-between items-center text-dark-navy font-bold">
                        <span class="text-gray-400 text-sm">${item.name}</span>
                        <span class="bg-white px-3 py-1 rounded-lg text-primary shadow-sm">${qty}x</span>
                    </li>`;

                    // Update Pricing List
                    priceItemsContainer.innerHTML += `
                        <div class="flex justify-between items-center text-sm md:text-base">
                            <span class="text-gray-500 font-medium">${item.name} (${qty} x ${formatIDR(item.price)})</span>
                            <span class="text-dark-navy font-bold">${formatIDR(subtotal)}</span>
                        </div>
                    `;
                });
            }

            // 3. Handle Add-ons (Makanan)
            if (Object.keys(data.makanan).length > 0) {
                hasAddons = true;
                const container = document.getElementById('makanan_list_container');
                const list = document.getElementById('display_makanan');
                container.classList.remove('hidden');

                // Add spacing if header not already added for add-ons
                if (Object.keys(data.fasilitas).length === 0) {
                     priceItemsContainer.innerHTML += `
                        <div class="text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mt-6 mb-4">Tambahan Layanan</div>
                    `;
                }
                
                Object.entries(data.makanan).forEach(([id, qty]) => {
                    const item = PRICING_CONFIG.makanan[id];
                    const subtotal = item.price * qty;
                    totalHarga += subtotal;

                    // Update Data List
                    list.innerHTML += `<li class="flex justify-between items-center text-dark-navy font-bold">
                        <span class="text-gray-400 text-sm">${item.name}</span>
                        <span class="bg-white px-3 py-1 rounded-lg text-secondary shadow-sm">${qty}x</span>
                    </li>`;

                    // Update Pricing List
                    priceItemsContainer.innerHTML += `
                        <div class="flex justify-between items-center text-sm md:text-base">
                            <span class="text-gray-500 font-medium">${item.name} (${qty} x ${formatIDR(item.price)})</span>
                            <span class="text-dark-navy font-bold">${formatIDR(subtotal)}</span>
                        </div>
                    `;
                });
            }

            if (hasAddons) {
                document.getElementById('addons_container').classList.remove('hidden');
            }

            // 4. Update TOTAL
            document.getElementById('display_total').innerText = formatIDR(totalHarga);
        });

        function goToPayment() {
            const btn = document.getElementById('confirmBtn');
            btn.disabled = true;
            btn.querySelector('span').innerText = 'Memproses...';
            
            document.getElementById('loadingOverlayDetail').classList.remove('hidden');
            document.getElementById('loadingOverlayDetail').classList.add('flex');

            // Redirect to payment page
            setTimeout(() => {
                window.location.href = "{{ route('pembayaran.camping') }}";
            }, 800);
        }
    </script>
@endsection
