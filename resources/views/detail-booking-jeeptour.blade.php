@extends('layouts.app')

@section('title', 'Detail Pemesanan Jeep Tour - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[60vh] min-h-[500px] w-full overflow-hidden flex items-center justify-center text-center">
        <img src="{{ asset('images/outbond.jpg') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h1 class="text-white text-4xl md:text-6xl font-bold mb-6 leading-tight uppercase tracking-tight">
                ADVENTURE JEEP
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed">
                Periksa kembali rincian perjalanan Jeep Adventure Anda.
            </p>
        </div>
    </section>

    <!-- SUMMARY SECTION -->
    <section id="ringkasan" class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Rincian Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <!-- DATA LIST (Populated by JS) -->
            <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 border border-gray-100 space-y-12">
                
                <!-- Main Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Nama Pemesan</label>
                            <p id="display_nama" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Nomor HP</label>
                            <p id="display_wa" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Jumlah Orang</label>
                            <p id="display_pax" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Tanggal Booking</label>
                            <p id="display_tanggal" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Jam</label>
                            <p id="display_waktu" class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">-</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-2 ml-1">Metode Pembayaran</label>
                            <p class="text-2xl font-black text-dark-navy border-b-2 border-gray-50 pb-2">Transfer Bank</p>
                        </div>
                    </div>
                </div>

                <!-- SELECTED PACKAGES LIST -->
                <div class="pt-12 border-t-2 border-gray-50">
                    <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-secondary rounded-full"></span>
                        Paket yang Dipilih
                    </h3>
                    
                    <div id="display_packages_list" class="space-y-4">
                        <!-- JS Items -->
                    </div>
                </div>

                <!-- RINCIAN HARGA SECTION -->
                <div id="pricing_container" class="pt-12 border-t-2 border-gray-100">
                    <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary rounded-full"></span>
                        Rincian Harga
                    </h3>
                    
                    <div class="space-y-4 bg-gray-50/40 rounded-3xl p-8 border border-gray-100">
                        <div id="price_items_list" class="space-y-4">
                            <!-- JS Items -->
                        </div>

                        <div class="pt-8 border-t-2 border-gray-200 mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-2xl font-black text-dark-navy uppercase tracking-tighter">Total Pembayaran</span>
                            <span class="text-4xl font-black text-primary drop-shadow-sm" id="display_total">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER BUTTONS -->
            <div class="mt-24 pt-12 pb-40 flex flex-row flex-nowrap items-center justify-between gap-4 md:gap-8 border-t-2 border-gray-200">
                <a href="{{ route('booking.jeeptour') }}" 
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 hover:-translate-y-1 transition-all duration-300 active:scale-[0.97] shadow-sm uppercase tracking-widest">
                    Kembali
                </a>
                
                <button type="button" id="confirmBtn" onclick="goToPayment()"
                    style="background-color: #FFC236;"
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] hover:-translate-y-1 transition-all duration-300 active:scale-[0.97] shadow-lg shadow-yellow-500/20 uppercase tracking-widest gap-3">
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

            if (!data || !data.nama_pemesan || !data.selected_packages || data.category !== 'jeeptour') {
                return;
            }

            const formatIDR = (val) => {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            };

            // Map Data
            document.getElementById('display_nama').innerText = data.nama_pemesan;
            document.getElementById('display_wa').innerText = data.no_hp;
            document.getElementById('display_tanggal').innerText = data.tanggal_kunjungan;
            document.getElementById('display_waktu').innerText = data.jam + ' WIB';

            let totalHarga = 0;
            let totalPax = 0;
            const packageListContainer = document.getElementById('display_packages_list');
            const priceItemsContainer = document.getElementById('price_items_list');
            
            packageListContainer.innerHTML = '';
            priceItemsContainer.innerHTML = '';

            data.selected_packages.forEach(pkg => {
                const price = pkg.price || 0;
                const subtotal = price * pkg.qty;
                totalHarga += subtotal;
                totalPax += pkg.qty;

                // Display List
                packageListContainer.innerHTML += `
                    <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                        <span class="font-bold text-dark-navy uppercase tracking-wide text-sm">${pkg.name}</span>
                        <span class="bg-white px-4 py-1 rounded-lg text-primary font-black shadow-sm">${pkg.qty} Orang</span>
                    </div>
                `;

                // Pricing List
                priceItemsContainer.innerHTML += `
                    <div class="flex justify-between items-center text-lg">
                        <span class="text-gray-500 font-bold">${pkg.name} (${pkg.qty} x ${formatIDR(price)})</span>
                        <span class="text-dark-navy font-black">${formatIDR(subtotal)}</span>
                    </div>
                `;
            });

            document.getElementById('display_pax').innerText = totalPax + ' Orang';

            // Update TOTAL
            document.getElementById('display_total').innerText = formatIDR(totalHarga);
        });

        function goToPayment() {
            const btn = document.getElementById('confirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<span>Memproses...</span>';
            
            document.getElementById('loadingOverlayDetail').classList.remove('hidden');
            document.getElementById('loadingOverlayDetail').classList.add('flex');

            setTimeout(() => {
                window.location.href = "{{ route('pembayaran.jeeptour') }}";
            }, 800);
        }
    </script>
@endsection
