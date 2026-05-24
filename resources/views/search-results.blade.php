@extends('layouts.app')

@section('title', 'Hasil Pencarian Booking - Kalisawah Adventure')

@section('content')
    <!-- HEADER SECTION (Text Only) -->
    <section class="pt-36 md:pt-44 pb-16 px-6 bg-white border-b border-gray-100 text-center">
        <div class="max-w-[850px] mx-auto space-y-4 mb-4">
            <h1 class="text-3xl md:text-5xl font-black text-dark-navy uppercase tracking-widest leading-tight">Hasil Pencarian Booking</h1>
            <div class="w-16 h-1.5 bg-secondary mx-auto rounded-full"></div>
        </div>
    </section>

    <!-- RESULTS SECTION -->
    <section class="py-20 px-6 bg-[#F8FAFC]">
        <div class="max-w-[1000px] mx-auto">
            
            <div id="results-container">
                <!-- Loading State -->
                <div id="loading" class="text-center py-20">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                    <p class="mt-4 text-gray-500 font-bold uppercase tracking-widest text-sm">Mencari data...</p>
                </div>

                <!-- Not Found State -->
                <div id="not-found" class="hidden text-center py-20 px-6">
                    <div class="text-gray-200 text-8xl mb-8">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </div>
                    <h2 class="text-3xl font-black text-dark-navy mb-4">Data Tidak Ditemukan</h2>
                    <p class="text-gray-500 mb-10 max-w-md mx-auto font-medium text-lg leading-relaxed">
                        Maaf, kami tidak dapat menemukan data reservasi dengan informasi tersebut. Periksa kembali nomor HP, nama, dan tanggal booking Anda.
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-primary text-white px-12 py-4 rounded-xl font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:bg-hover-primary transition-all active:scale-[0.95]">
                        <i class="fa-solid fa-rotate-left"></i> Kembali Ke Beranda
                    </a>
                </div>

                <!-- Results List -->
                <div id="found-list" class="hidden">
                    <!-- Table will be injected here -->
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const phone = urlParams.get('phone');
            const date = urlParams.get('date');
            const name = urlParams.get('name');

            // Normalisasi function
            const normalizePhone = (num) => {
                if (!num) return '';
                let cleaned = num.toString().replace(/\D/g, '').trim(); 
                // Handle format 62 -> 0
                if (cleaned.startsWith('62')) {
                    cleaned = '0' + cleaned.substring(2);
                }
                
                // Jika tidak diawali 0, tambahkan 0 di depan
                if (cleaned.length > 0 && !cleaned.startsWith('0')) {
                    cleaned = '0' + cleaned;
                }
                return cleaned;
            };

            const normalizedPhoneInput = normalizePhone(phone);
            const normalizedNameInput = name ? name.trim().toLowerCase() : '';
            const normalizedDateInput = date ? date.trim() : '';

            setTimeout(() => {
                const loadingEl = document.getElementById('loading');
                if (loadingEl) loadingEl.classList.add('hidden');
                
                const bookingData = localStorage.getItem('booking_data');
                
                if (bookingData) {
                    const data = JSON.parse(bookingData);
                    
                    // Normalisasi data dari storage
                    const normalizedPhoneStorage = normalizePhone(data.no_hp);
                    const normalizedNameStorage = data.nama_pemesan ? data.nama_pemesan.trim().toLowerCase() : '';
                    const normalizedDateStorage = data.tanggal_kunjungan ? data.tanggal_kunjungan.trim() : '';

                    // Match logic
                    const isMatchPhone = normalizedPhoneInput && normalizedPhoneStorage === normalizedPhoneInput;
                    const isMatchName = normalizedNameInput && normalizedNameStorage.includes(normalizedNameInput);
                    const isMatchDate = normalizedDateInput && normalizedDateStorage === normalizedDateInput;

                    if (isMatchPhone || isMatchName || isMatchDate) {
                        renderResults(data);
                    } else {
                        showNotFound();
                    }
                } else {
                    showNotFound();
                }
            }, 1000);
        });

        function renderResults(data) {
            const container = document.getElementById('found-list');
            container.classList.remove('hidden');

            const formatIDR = (val) => 'Rp ' + new Intl.NumberFormat('id-ID').format(val);

            // Derived/Mocked values to match reference UI requirements
            const bookingCode = data.kode_booking || 'KLS-BYQ' + Math.floor(1000 + Math.random() * 9000);
            const pengunjung = parseInt(data.total_pengunjung) || 0;
            const tambahan = Math.max(0, pengunjung - 5); 
            
            // Assume total from data or use a representative mock for UI
            const finalTotal = data.total_harga || 70000;
            const originalTotal = finalTotal + (finalTotal * 0.15); // +15% for line-through mock

            const tableHtml = `
                <div class="bg-white rounded-[32px] shadow-sm overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">NO</th>
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">KODE BOOKING</th>
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">PEMESAN</th>
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">TANGGAL & JAM</th>
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">PENGUNJUNG</th>
                                    <th class="px-6 py-5 text-[11px] font-medium text-gray-400 uppercase tracking-widest whitespace-nowrap">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                                    <td class="px-6 py-8 text-sm font-bold text-gray-400 group-hover:text-dark-navy transition-colors">01</td>
                                    <td class="px-6 py-8">
                                        <span class="bg-blue-50 text-blue-600 rounded-full px-4 py-1.5 font-bold text-xs uppercase tracking-wider">
                                            ${bookingCode}
                                        </span>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex flex-col">
                                            <span class="text-dark-navy font-bold text-[15px]">${data.nama_pemesan || '-'}</span>
                                            <span class="text-gray-400 text-[11px] mt-1 font-medium italic">${data.no_hp || '-'}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2 text-gray-500">
                                                <i class="fa-regular fa-calendar-days text-[12px] text-gray-400 group-hover:text-primary transition-colors"></i>
                                                <span class="text-xs font-bold">${formatDate(data.tanggal_kunjungan)}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-gray-500">
                                                <i class="fa-regular fa-clock text-[12px] text-gray-400 group-hover:text-primary transition-colors"></i>
                                                <span class="text-xs font-bold">${data.jam || '08:00'} WIB</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex items-center gap-3">
                                            <span class="text-dark-navy font-black text-sm">${pengunjung} Orang</span>
                                            ${tambahan > 0 ? `
                                                <span class="bg-pink-100 text-pink-500 rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-tighter">
                                                    +${tambahan} Tambahan
                                                </span>
                                            ` : ''}
                                        </div>
                                    </td>
                                    <td class="px-6 py-8">
                                        <div class="flex flex-col items-start">
                                            <span class="text-gray-400 text-[10px] line-through font-bold mb-1">${formatIDR(originalTotal)}</span>
                                            <span class="text-green-500 font-black text-xl tracking-tight">${formatIDR(finalTotal)}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOOTER BACK BUTTON -->
                <div class="mt-12 flex justify-center">
                    <a href="javascript:history.back()" 
                        class="h-[55px] px-12 rounded-2xl border-2 border-gray-100 bg-white text-gray-400 font-black text-xs flex items-center justify-center hover:bg-gray-50 hover:text-dark-navy hover:border-gray-200 transition-all active:scale-[0.95] shadow-sm uppercase tracking-[0.2em] gap-3">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            `;
            
            container.innerHTML = tableHtml;
        }

        function showNotFound() {
            document.getElementById('not-found').classList.remove('hidden');
        }

        function formatDate(dateStr) {
            if(!dateStr) return '-';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateStr).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection
