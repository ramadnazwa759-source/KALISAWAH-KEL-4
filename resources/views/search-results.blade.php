@extends('layouts.app')

@section('title', 'Hasil Pencarian Booking - Kalisawah Adventure')

@section('content')
    <!-- NAVBAR SPACER -->
    <div class="h-20 md:h-24"></div>

    <!-- HEADER SECTION (Text Only) -->
    <section class="pt-12 pb-16 px-6 bg-white border-b border-gray-100 text-center">
        <div class="max-w-[850px] mx-auto">
            <h1 class="text-3xl md:text-5xl font-black text-dark-navy uppercase tracking-widest leading-tight">Hasil Pencarian Booking</h1>
            <div class="w-16 h-1.5 bg-secondary mx-auto rounded-full mt-6"></div>
        </div>
    </section>

    <!-- RESULTS SECTION -->
    <section class="py-20 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
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
                <div id="found-list" class="hidden space-y-12">
                    <!-- Cards will be injected here -->
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
                // Handle format +62 -> 0 (sudah tercover oleh \D di atas)
                
                // Jika tidak diawali 0, tambahkan 0 di depan (misal: 812... -> 0812...)
                if (cleaned.length > 0 && !cleaned.startsWith('0')) {
                    cleaned = '0' + cleaned;
                }
                return cleaned;
            };

            const normalizedPhoneInput = normalizePhone(phone);
            const normalizedNameInput = name ? name.trim().toLowerCase() : '';
            const normalizedDateInput = date ? date.trim() : '';

            setTimeout(() => {
                document.getElementById('loading').classList.add('hidden');
                
                const bookingData = localStorage.getItem('booking_data');
                
                if (bookingData) {
                    const data = JSON.parse(bookingData);
                    
                    // Normalisasi data dari storage
                    const normalizedPhoneStorage = normalizePhone(data.no_hp);
                    const normalizedNameStorage = data.nama_pemesan ? data.nama_pemesan.trim().toLowerCase() : '';
                    const normalizedDateStorage = data.tanggal_kunjungan ? data.tanggal_kunjungan.trim() : '';

                    // Match logic (Minimal salah satu cocok)
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
            
            // Format IDR
            const formatIDR = (val) => 'Rp ' + new Intl.NumberFormat('id-ID').format(val);

            // Replicate the exact card style from status-booking
            const cardHtml = `
                <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 border border-gray-100 space-y-12">
                    <!-- STATUS BADGE -->
                    <div class="flex flex-col items-center text-center space-y-6">
                        <div class="inline-flex items-center gap-3 px-8 py-3 bg-yellow-50 text-yellow-600 rounded-full border border-yellow-100">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></span>
                            <span class="text-xl font-black uppercase tracking-widest">Menunggu</span>
                        </div>
                        
                        <div class="max-w-md">
                            <p class="text-gray-500 font-medium text-lg">
                                Booking Anda ditemukan. Harap segera lakukan pembayaran jika status masih menunggu.
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- BOOKING DETAILS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Paket</label>
                            <p class="text-xl font-black text-primary">${data.paket || 'Paket Adventure'}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Pemesan</label>
                            <p class="text-xl font-black text-dark-navy">${data.nama_pemesan || '-'}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nomor HP</label>
                            <p class="text-xl font-black text-dark-navy">${data.no_hp || '-'}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Booking</label>
                            <p class="text-xl font-black text-dark-navy">${formatDate(data.tanggal_kunjungan)}</p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- ACTION BUTTONS -->
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4 pt-4">
                        <a href="javascript:history.back()" 
                            class="w-full md:w-auto h-[55px] px-16 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 font-bold text-lg flex items-center justify-center hover:bg-gray-200 transition-all active:scale-[0.95] shadow-sm uppercase tracking-widest gap-3">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            `;
            
            container.innerHTML = cardHtml;
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
