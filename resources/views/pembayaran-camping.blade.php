@extends('layouts.app')

@section('title', 'Pembayaran Camping - Kalisawah Adventure')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[60vh] min-h-[500px] w-full overflow-hidden flex items-center justify-center text-center">
        <img src="{{ asset('images/camping.jpg') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h1 class="text-white text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Detail Pembayaran
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed">
                Selesaikan pembayaran Anda untuk mengonfirmasi pesanan petualangan camping Anda.
            </p>
        </div>
    </section>

    <!-- PAYMENT SECTION -->
    <section id="pembayaran" class="py-24 px-6 bg-[#F8FAFC] scroll-mt-20">
        <div class="max-w-[850px] mx-auto">

            <!-- MAIN CONTENT CARD -->
            <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 border border-gray-100 space-y-16">
                
                <!-- 1. RINGKASAN PESANAN (TOP) -->
                <div>
                    <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-secondary rounded-full"></span>
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-6">
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Nama Pelanggan</span>
                            <span id="display_nama" class="text-dark-navy font-black">-</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Paket Camping</span>
                            <span id="display_paket" class="text-primary font-black">-</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Tanggal</span>
                            <span id="display_tanggal" class="text-dark-navy font-black">-</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Jumlah Orang / Tenda</span>
                            <span id="display_jumlah" class="text-dark-navy font-black">-</span>
                        </div>
                        
                        <div class="pt-8 border-t-2 border-gray-100 mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-2xl font-black text-dark-navy uppercase tracking-tighter">Total yang Harus Dibayar</span>
                            <span class="text-4xl font-black text-primary drop-shadow-sm" id="display_total">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- 2. JENIS PEMBAYARAN -->
                <div class="pt-16 border-t-2 border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-8 mb-12">
                        <div>
                            <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest flex items-center gap-3">
                                <span class="w-2 h-8 bg-primary rounded-full"></span>
                                Pilih Jenis Pembayaran
                            </h3>
                        </div>

                        <div class="relative w-full">
                            <div class="flex flex-col gap-3">
                                <label class="text-[13px] font-bold text-gray-400 ml-1">Pilihan Pembayaran</label>
                                <div class="relative group">
                                    <select id="paymentTypeSelect" onchange="handleTypeChange()" 
                                        class="w-full h-[60px] pl-6 pr-12 rounded-xl border border-blue-200 bg-white text-dark-navy font-semibold text-lg appearance-none cursor-pointer focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none transition-all duration-300 shadow-sm hover:border-primary">
                                        <option value="dp">DP (Minimal 10%)</option>
                                        <option value="lunas">Lunas (100%)</option>
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-dark-navy/50">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BANK TRANSFER INFO -->
                    <div id="methodDetails" class="bg-gray-50 rounded-[32px] p-8 border border-gray-100 transition-all duration-300">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-building-columns text-primary text-xl"></i>
                                    <span class="font-black text-dark-navy text-lg">Bank Mandiri (Transfer)</span>
                                </div>
                                <span class="bg-primary/10 text-primary px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">Active</span>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6">
                                <span class="text-gray-500 font-bold">No. Rekening</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl font-black text-primary tracking-wider">1220011966838</span>
                                    <button onclick="copyToClipboard('1220011966838')" class="text-gray-400 hover:text-primary transition-colors">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <span class="text-gray-500 font-bold">Atas Nama</span>
                                <span class="text-xl font-black text-dark-navy">Budi Santoso</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER BUTTONS -->
            <div class="mt-24 pt-12 pb-40 flex flex-row flex-nowrap items-center justify-between gap-4 md:gap-8 border-t border-gray-100">
                <a href="{{ route('booking.detail') }}" 
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl border border-blue-400 bg-white text-primary font-bold text-lg flex items-center justify-center hover:bg-blue-50 transition-all duration-200 active:scale-[0.98]">
                    Kembali
                </a>
                
                <button type="button" id="confirmPaymentBtn" onclick="confirmPayment()"
                    style="background-color: #FFC236;"
                    class="btn-action flex-1 md:flex-none md:w-[280px] h-[55px] rounded-xl text-white font-bold text-lg flex items-center justify-center hover:bg-[#FFD15B] transition-all duration-200 active:scale-[0.98] shadow-lg shadow-yellow-500/20 gap-3">
                    <span>Lanjut</span>
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- LOADING OVERLAY -->
    <div id="loadingOverlayPayment" class="fixed inset-0 z-[200] bg-primary/95 hidden items-center justify-center flex-col text-white backdrop-blur-md">
        <div class="w-24 h-24 border-8 border-white/20 rounded-full flex items-center justify-center mb-8 relative">
            <div class="absolute inset-0 border-8 border-secondary border-t-transparent rounded-full animate-spin"></div>
        </div>
        <h3 class="text-3xl font-black mb-2">Memverifikasi Pembayaran</h3>
        <p class="text-blue-200">Mohon tunggu sebentar...</p>
    </div>

    <script>
        let finalTotal = 0;

        document.addEventListener('DOMContentLoaded', function() {
            let data = null;
            try {
                data = JSON.parse(localStorage.getItem('booking_data'));
            } catch (e) {
                console.error("Error parsing booking data", e);
            }

            if (!data || !data.nama_pemesan || !data.selected_packages || data.category !== 'camping') {
                return;
            }

            const PRICING_CONFIG = {
                pakets: {
                    'Nyaman Camp': { price: 350000, pax: 6, includesTenda: true },
                    'Seru Camp': { price: 185000, pax: 4, includesTenda: true },
                    'Santai Camp': { price: 150000, pax: 4, includesTenda: true },
                    'Bawa Tenda Sendiri': { price: 25000, pax: 0, includesTenda: false }
                },
                fasilitas: {
                    1: { name: 'Peralatan Masak', price: 50000 },
                    2: { name: 'Matras', price: 25000 },
                    3: { name: 'Sleeping Bag', price: 35000 },
                    4: { name: 'Lampu Tenda', price: 10000 },
                    5: { name: 'Meja & Kursi', price: 100000 },
                    6: { name: 'Kompor & Gas', price: 20000 }
                },
                makanan: {
                    101: { name: 'Paket Grill (2-3 Orang)', price: 30000 },
                    102: { name: 'Sarapan Tradisional', price: 16000 }
                }
            };

            const formatIDR = (val) => {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            };

            document.getElementById('display_nama').innerText = data.nama_pemesan;
            document.getElementById('display_paket').innerText = data.selected_packages.map(p => p.name).join(', ');
            document.getElementById('display_tanggal').innerText = data.tanggal_kunjungan;
            
            let jumlahText = `${data.total_pengunjung} Orang`;
            if (parseInt(data.jumlah_tenda) > 0) {
                jumlahText += ` / ${data.jumlah_tenda} Tenda`;
            }
            document.getElementById('display_jumlah').innerText = jumlahText;

            // Re-calculate Total
            let totalCapacity = 0;
            let packagesPrice = 0;
            let hasSewaLahan = false;

            data.selected_packages.forEach(pkg => {
                const config = PRICING_CONFIG.pakets[pkg.name];
                if (config) {
                    if (pkg.name === 'Bawa Tenda Sendiri') {
                        hasSewaLahan = true;
                    } else {
                        packagesPrice += config.price * (pkg.qty || 1);
                        totalCapacity += (config.pax * (pkg.qty || 1));
                    }
                }
            });

            const extraPeople = Math.max(0, parseInt(data.total_pengunjung) - totalCapacity);
            const extraTicketPrice = extraPeople * 25000;
            
            let sewaLahanPrice = 0;
            if (hasSewaLahan) {
                sewaLahanPrice = data.ukuran_tenda === '6+' ? 50000 : 25000;
            }

            let totalHarga = packagesPrice + extraTicketPrice + sewaLahanPrice;

            if (data.fasilitas) {
                Object.entries(data.fasilitas).forEach(([id, qty]) => {
                    if (PRICING_CONFIG.fasilitas[id]) totalHarga += PRICING_CONFIG.fasilitas[id].price * qty;
                });
            }
            if (data.makanan) {
                Object.entries(data.makanan).forEach(([id, qty]) => {
                    if (PRICING_CONFIG.makanan[id]) totalHarga += PRICING_CONFIG.makanan[id].price * qty;
                });
            }

            finalTotal = totalHarga;
            updateDisplayTotal();
        });

        function handleTypeChange() {
            updateDisplayTotal();
        }

        function updateDisplayTotal() {
            const type = document.getElementById('paymentTypeSelect').value;
            const amount = type === 'dp' ? finalTotal * 0.1 : finalTotal;
            document.getElementById('display_total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        function confirmPayment() {
            const btn = document.getElementById('confirmPaymentBtn');
            btn.disabled = true;
            btn.querySelector('span').innerText = 'Memproses...';
            document.getElementById('loadingOverlayPayment').classList.remove('hidden');
            document.getElementById('loadingOverlayPayment').classList.add('flex');
            setTimeout(() => {
                alert('Pesanan Camping Anda Berhasil!');
                window.location.href = "{{ route('status.booking') }}";
            }, 2000);
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('No. Rekening berhasil disalin!');
            });
        }
    </script>
@endsection
