@extends('layouts.app')

@section('title', 'Pembayaran - Kalisawah Adventure')

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
                Selesaikan pembayaran Anda untuk mengonfirmasi pesanan petualangan Anda.
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
                            <span class="text-gray-500 font-bold">Paket Pilihan</span>
                            <span id="display_paket" class="text-primary font-black">-</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Tanggal</span>
                            <span id="display_tanggal" class="text-dark-navy font-black">-</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-500 font-bold">Jumlah</span>
                            <span id="display_jumlah" class="text-dark-navy font-black">-</span>
                        </div>
                        
                        <div class="pt-8 border-t-2 border-gray-100 mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-2xl font-black text-dark-navy uppercase tracking-tighter">Total yang Harus Dibayar</span>
                            <span class="text-4xl font-black text-primary drop-shadow-sm" id="display_total">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- 2. METODE PEMBAYARAN -->
                <div class="pt-16 border-t-2 border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-8 mb-12">
                        <div>
                            <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest flex items-center gap-3 mb-2">
                                <span class="w-2 h-8 bg-primary rounded-full"></span>
                                Metode Pembayaran
                            </h3>
                            <p class="text-gray-400 font-medium text-sm ml-5">(Transfer bank, QRIS, cash)</p>
                        </div>

                        <div class="relative w-full md:w-[400px]">
                            <!-- CUSTOM UI LAYER -->
                            <div class="w-full h-[95px] md:h-[85px] px-8 md:px-6 rounded-[28px] md:rounded-3xl border-2 border-blue-100 bg-gray-50 flex items-center justify-between shadow-sm group hover:border-primary hover:bg-white hover:shadow-md transition-all duration-300 cursor-pointer">
                                <div class="flex-1">
                                    <p class="text-[11px] md:text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-1.5 md:mb-1">Metode Pembayaran</p>
                                    <p id="selectedMethodText" class="text-dark-navy font-black text-xl md:text-lg leading-tight">-- Pilih --</p>
                                </div>
                                <div class="w-12 h-12 md:w-10 md:h-10 bg-white rounded-2xl md:rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                                    <i class="fa-solid fa-chevron-down text-sm"></i>
                                </div>
                            </div>
                            
                            <!-- TRANSPARENT NATIVE SELECT -->
                            <select id="paymentMethodSelect" onchange="handleMethodChange()" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <option value="" disabled selected>-- Pilih --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS (Otomatis)</option>
                                <option value="cash">Tunai / Cash (Di Lokasi)</option>
                            </select>
                        </div>
                    </div>

                    <!-- DYNAMIC DETAILS AREA -->
                    <div id="methodDetails" class="bg-gray-50 rounded-[32px] p-8 border border-gray-100 min-h-[200px] flex flex-col justify-center transition-all duration-300">
                            <!-- Transfer Bank Details (Hidden) -->
                            <div id="detail_transfer" class="method-detail hidden space-y-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <i class="fa-solid fa-building-columns text-primary text-xl"></i>
                                    <span class="font-black text-dark-navy text-lg">Bank Mandiri</span>
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
                                    <span class="text-xl font-black text-dark-navy">Budi Santtoso</span>
                                </div>
                            </div>

                            <!-- QRIS Details (Hidden) -->
                            <div id="detail_qris" class="method-detail hidden flex flex-col items-center text-center space-y-6 py-4">
                                <div class="w-48 h-48 bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=KALISAWAH-ADVENTURE" alt="QRIS" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h4 class="text-xl font-black text-dark-navy">Scan QRIS</h4>
                                    <p class="text-gray-400 font-medium mb-4">Bisa pakai GoPay, OVO, Dana, atau Mobile Banking.</p>
                                    
                                    <!-- QRIS GUIDE TOGGLE -->
                                    <button type="button" onclick="toggleQrisGuide()" class="inline-flex items-center gap-2 text-primary font-bold text-sm bg-blue-50 px-6 py-3 rounded-full hover:bg-blue-100 transition-all border border-blue-100">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span>Lihat Cara Pembayaran</span>
                                        <i id="qrisGuideIcon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300"></i>
                                    </button>
                                </div>

                                <!-- QRIS GUIDE CONTENT (EXPANDABLE) -->
                                <div id="qrisGuideContent" class="hidden w-full text-left bg-white border border-blue-50 rounded-[32px] p-8 space-y-6 shadow-sm animate-fadeIn">
                                    <h5 class="font-black text-dark-navy uppercase tracking-widest text-xs flex items-center gap-3">
                                        <span class="w-1.5 h-4 bg-primary rounded-full"></span>
                                        Langkah Pembayaran:
                                    </h5>
                                    
                                    <div class="space-y-4">
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">1</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Screenshot barcode QRIS yang ditampilkan di halaman ini</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">2</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Masuk ke aplikasi m-banking masing-masing</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">3</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Pilih menu Scan Code QRIS</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">4</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Buka galeri dan pilih screenshot QR</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">5</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Pastikan nominal sesuai tagihan</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-blue-50 text-primary text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">6</div>
                                            <p class="text-gray-500 text-sm font-medium leading-relaxed">Lakukan pembayaran sesuai nominal</p>
                                        </div>
                                        <div class="flex gap-4 items-start">
                                            <div class="w-6 h-6 bg-green-50 text-green-600 text-[10px] font-black rounded-full flex items-center justify-center shrink-0 mt-0.5 border border-green-100"><i class="fa-solid fa-check"></i></div>
                                            <p class="text-gray-500 text-sm font-bold leading-relaxed">Pembayaran selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cash Details (Hidden) -->
                            <div id="detail_cash" class="method-detail hidden text-center space-y-4 py-8">
                                <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <h4 class="text-xl font-black text-dark-navy">Bayar Tunai di Lokasi</h4>
                                <p class="text-gray-400 font-medium max-w-md mx-auto">Lakukan pembayaran DP 10% dilokasi, pesanan anda akan dikonfirmasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER BUTTONS -->
            <div class="mt-24 pt-12 border-t-2 border-gray-200 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <a href="{{ route('booking.detail') }}" 
                        class="btn-action w-full md:w-auto h-[55px] px-8 rounded-full border border-gray-200 bg-white text-gray-400 font-bold text-lg flex items-center justify-center hover:bg-gray-50 transition-all duration-100 ease-in-out active:scale-[0.95] shadow-sm uppercase tracking-widest">
                        Kembali
                    </a>
                </div>
                
                <button type="button" id="confirmPaymentBtn" onclick="confirmPayment()"
                    style="background-color: #FFC236;"
                    class="btn-action w-full md:w-auto h-[60px] px-12 md:px-16 rounded-full text-white font-black text-xl flex items-center justify-center hover:opacity-90 transition-all duration-100 ease-in-out active:scale-[0.95] shadow-xl shadow-yellow-500/20 uppercase tracking-[0.1em] gap-3">
                    <span>Lanjut</span>
                    <i class="fa-solid fa-arrow-right"></i>
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

    <style>
        .btn-action:active {
            transform: scale(0.95);
        }
        .method-detail, .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Dropdown fix to override potential Bootstrap/Global styles */
        #paymentMethodSelect {
            background-color: #ffffff !important;
            opacity: 1 !important;
            color: #0F172A !important; /* dark-navy */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        #paymentMethodSelect option {
            background-color: #ffffff !important;
            color: #0F172A !important;
            padding: 15px !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = JSON.parse(localStorage.getItem('booking_data'));

            if (!data) {
                window.location.href = "{{ route('booking.create') }}";
                return;
            }

            // Prices Data
            const PRICING = {
                pakets: {
                    'Nyaman Camp': 350000,
                    'Seru Camp': 185000,
                    'Santai Camp': 150000,
                    'Bawa Tenda Sendiri': 25000
                },
                fasilitas: {
                    1: { price: 50000 },
                    2: { price: 25000 },
                    3: { price: 35000 },
                    4: { price: 10000 },
                    5: { price: 100000 },
                    6: { price: 20000 }
                },
                makanan: {
                    101: { price: 30000 },
                    102: { price: 16000 }
                }
            };

            const formatIDR = (val) => {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            };

            // Map Data
            document.getElementById('display_nama').innerText = data.nama_pemesan;
            document.getElementById('display_paket').innerText = data.paket;
            document.getElementById('display_tanggal').innerText = data.tanggal_kunjungan;
            
            // Format Jumlah Display
            let jumlahText = `${data.jumlah_orang} Orang`;
            if (data.jumlah_tenda > 0) {
                jumlahText += ` / ${data.jumlah_tenda} Tenda`;
            }
            document.getElementById('display_jumlah').innerText = jumlahText;

            // Re-calculate Total
            let totalHarga = 0;
            let paketBasePrice = PRICING.pakets[data.paket] || 0;
            if (data.paket === 'Bawa Tenda Sendiri') {
                const totalTiket = 25000 * parseInt(data.jumlah_orang);
                const sewaLahan = data.ukuran_tenda === '6+' ? 50000 : 25000;
                paketBasePrice = totalTiket + sewaLahan;
            } else {
                const tendaCount = Math.max(1, parseInt(data.jumlah_tenda));
                paketBasePrice = paketBasePrice * tendaCount;
            }
            totalHarga += paketBasePrice;

            Object.entries(data.fasilitas).forEach(([id, qty]) => {
                totalHarga += PRICING.fasilitas[id].price * qty;
            });
            Object.entries(data.makanan).forEach(([id, qty]) => {
                totalHarga += PRICING.makanan[id].price * qty;
            });

            document.getElementById('display_total').innerText = formatIDR(totalHarga);
        });

        function handleMethodChange() {
            const select = document.getElementById('paymentMethodSelect');
            const selectedValue = select.value;
            const selectedText = select.options[select.selectedIndex].text;
            
            // Update UI Text
            document.getElementById('selectedMethodText').innerText = selectedText;
            
            const details = document.querySelectorAll('.method-detail');
            
            // Hide all
            details.forEach(detail => detail.classList.add('hidden'));
            
            // Show selected
            const target = document.getElementById(`detail_${selectedValue}`);
            if (target) {
                target.classList.remove('hidden');
            }
        }

        function confirmPayment() {
            const btn = document.getElementById('confirmPaymentBtn');
            const method = document.getElementById('paymentMethodSelect').value;
            
            if (!method) {
                alert('Silakan pilih metode pembayaran terlebih dahulu.');
                return;
            }

            btn.disabled = true;
            btn.querySelector('span').innerText = 'Memproses...';
            
            document.getElementById('loadingOverlayPayment').classList.remove('hidden');
            document.getElementById('loadingOverlayPayment').classList.add('flex');

            setTimeout(() => {
                let msg = 'Pesanan Anda sedang diproses!';
                if (method === 'cash') {
                    msg = 'Pesanan Berhasil! Silakan lakukan pembayaran DP di lokasi.';
                }
                alert(msg);
                // In a real app, we might keep the data for the status page
                // But for this flow, let's just redirect
                window.location.href = "{{ route('status.booking') }}";
            }, 2000);
        }

        function toggleQrisGuide() {
            const content = document.getElementById('qrisGuideContent');
            const icon = document.getElementById('qrisGuideIcon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('No. Rekening berhasil disalin!');
            });
        }
    </script>
@endsection
