@extends('layouts.app')

@section('title', 'Paket Camping - Kalisawah Adventure Banyuwangi')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden">
        <img src="{{ asset('images/camping.jpg') }}" alt="Camping Seru" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center px-6 md:px-20 lg:px-32 max-w-7xl mx-auto mt-10 md:mt-0">
            <div class="max-w-2xl">
                <h1 class="text-primary text-4xl md:text-6xl lg:text-7xl font-bold mb-2">Camping Seru</h1>
                <h2 class="font-script text-secondary text-4xl md:text-5xl lg:text-6xl mb-6">Bernapas Bersama Alam</h2>
                <p class="text-white text-lg md:text-xl font-normal mb-10 max-w-lg leading-relaxed">
                    Nikmati malam bertabur bintang di area camping eksklusif Kalisawah Adventure. Dikelilingi udara segar, pepohonan rindang, dan gemericik sungai yang menenangkan.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#paket-camping" class="bg-primary text-white px-8 py-4 rounded-lg font-bold hover:bg-hover-primary transition-all transform hover:-translate-y-1 shadow-lg">
                        Lihat Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PILIHAN PAKET CAMPING -->
    <section id="paket-camping" class="py-24 px-6 md:px-20 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-dark-navy">Pilih Paket <span class="text-secondary">Seru Kamu</span></h2>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-center max-w-5xl mx-auto">
            @forelse($pakets as $paket)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 flex flex-col hover:shadow-2xl transition-all hover:-translate-y-2">
                <div class="relative h-56 overflow-hidden shrink-0">
                    <img src="{{ $paket->gambar ? asset('storage/' . $paket->gambar) : asset('images/camp1.jpg') }}" alt="{{ $paket->nama }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-primary text-xl font-bold mb-2 leading-tight text-center uppercase">{{ $paket->nama }}</h3>
                    <p class="text-gray-500 text-sm text-center mb-6 leading-relaxed">{{ $paket->deskripsi }}</p>
                    
                    @if($paket->fasilitas && $paket->fasilitas->isNotEmpty())
                    <div class="space-y-4 mb-6 flex-grow">
                        <div>
                            <h4 class="font-bold text-dark-navy text-sm mb-2"><i class="fa-solid fa-box-open text-secondary mr-2"></i>Fasilitas</h4>
                            <ul class="text-gray-500 text-sm list-disc pl-5 space-y-1">
                                @foreach($paket->fasilitas as $fas)
                                    <li>
                                        {{ $fas->nama_fasilitas }} 
                                        @if($fas->pivot->jumlah)
                                            (x{{ $fas->pivot->jumlah }})
                                        @endif
                                        @if($fas->pivot->keterangan)
                                            - {{ $fas->pivot->keterangan }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-gray-100 mt-auto text-center">
                        <span class="text-dark-navy font-bold text-xl">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span> 
                        @if($paket->kapasitas)
                            <span class="text-gray-400 text-xs">/ Tenda / {{ $paket->kapasitas }} Orang</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-soft-blue text-primary text-2xl mb-4">
                    <i class="fa-solid fa-tent"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-navy mb-1">Belum Ada Paket Camping</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Silakan tambahkan data paket camping melalui panel admin atau database.</p>
            </div>
            @endforelse
        </div>
        
        <!-- MAIN BOOKING BUTTON -->
        <div class="mt-16 flex flex-col items-center text-center border-t border-gray-100 pt-10">
            <button id="bookingBtn" onclick="toggleBookingModal()" class="inline-block bg-secondary text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-secondary/90 transition-all transform hover:-translate-y-1">
                Booking Sekarang <i class="fa-solid fa-chevron-right ml-1 text-sm"></i>
            </button>
            <p class="mt-4 text-sm font-medium opacity-80 text-gray-500">Klik tombol di atas untuk melanjutkan pemesanan.</p>
        </div>
    </section>

    <!-- FASILITAS LAIN-LAIN -->
    <section class="py-16 px-6 md:px-20 bg-light-gray">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-dark-navy">Fasilitas Lain-Lain</h2>
                <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-mosque"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Mushola</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-bath"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Kamar mandi</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Tempat api unggun</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Aula</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-plug"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Listrik</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wifi"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Free WiFi</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-square-parking"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Free parkir</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Resto</span>
                </div>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-soft-blue text-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="font-bold text-dark-navy text-sm text-center">Penjaga 24 jam</span>
                </div>
            </div>
            
            <p class="text-center text-gray-500 text-sm mt-8">Fasilitas di atas tersedia untuk semua pengunjung / pemesan paket camping.</p>

            <!-- KETENTUAN -->
            <div class="mt-16 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm text-left max-w-3xl mx-auto">
                <h3 class="text-xl font-bold text-dark-navy mb-4 border-b pb-3 border-gray-100"><i class="fa-solid fa-circle-exclamation text-secondary mr-2"></i>Ketentuan</h3>
                <ul class="text-gray-600 text-sm list-disc pl-5 space-y-2">
                    <li>Harga paket adalah harga per malam dan sudah termasuk tiket masuk wisata.</li>
                    <li>Umur 4 tahun ke atas dikenakan tiket camp.</li>
                    <li>Apabila jumlah peserta melebihi kapasitas, dikenakan biaya tambahan <strong>Rp 25.000/orang</strong>.</li>
                    <li>Tamu camping yang berpasangan dalam satu tenda <strong>harus suami istri</strong>.</li>
                </ul>
            </div>
        </div>
    </section>

    <style>
        /* Specificity boost to override Bootstrap */
        #bookingModal .paket-label {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            transition: all 0.2s ease !important;
            border-width: 1px !important;
        }
        #bookingModal .paket-check {
            position: absolute !important;
            top: 12px !important;
            right: 12px !important;
            display: none; /* Controlled by JS */
            z-index: 20 !important;
        }
        #bookingModal .paket-check.active-check {
            display: flex !important;
        }
        body.modal-open {
            overflow: hidden !important;
        }
    </style>

    <!-- MODAL POPUP -->
    <div id="bookingModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="toggleBookingModal()"></div>
        
        <!-- Modal Panel -->
        <div id="bookingModalPanel" class="relative w-full max-w-[440px] bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0 text-left flex flex-col pointer-events-auto">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center text-blue-600">
                    <i class="fa-solid fa-clipboard-list mr-3 text-lg"></i>
                    <h3 class="text-sm font-bold uppercase tracking-wider" id="modal-title">Pilih Paket Camping</h3>
                </div>
                <button type="button" onclick="toggleBookingModal()" class="text-gray-400 hover:text-gray-600 transition-all hover:rotate-90 focus:outline-none p-1">
                    <span class="sr-only">Tutup</span>
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="bg-white px-10 py-10">
                <form id="selectPaketForm" class="space-y-4">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Pilih salah satu paket:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($pakets as $index => $paket)
                        <label class="paket-label relative flex items-center h-20 cursor-pointer rounded-2xl border border-gray-200 bg-white px-5 shadow-sm hover:border-green-500 transition-all duration-150 active:scale-[0.97] active:shadow-inner">
                            <input type="radio" name="paket_camping" value="{{ $paket->nama }}" class="sr-only peer" {{ $index === 0 ? 'required' : '' }}>
                            <div class="flex flex-col">
                                <span class="text-base font-bold text-dark-navy uppercase tracking-tight">{{ $paket->nama }}</span>
                                <span class="text-sm font-semibold text-blue-600 mt-0.5">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="paket-check absolute right-3 top-3 hidden items-center justify-center w-6 h-6 rounded-full bg-green-500 text-white shadow-md z-10">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                        </label>
                        @empty
                        <div class="col-span-full text-center py-6 text-gray-500 text-sm">
                            Tidak ada paket camping yang tersedia saat ini.
                        </div>
                        @endforelse
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex justify-end items-center space-x-3">
                <button type="button" onclick="toggleBookingModal()" class="text-sm font-bold text-gray-400 hover:text-gray-600 hover:bg-gray-100 px-5 py-2.5 rounded-xl transition-all active:scale-[0.95] active:bg-gray-200">
                    Batal
                </button>
                <button type="button" onclick="submitModalSelection()" class="bg-secondary text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-secondary/20 hover:bg-secondary/90 transition-all active:scale-95 active:shadow-sm text-sm">
                    Booking Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Script for Modal & Validation -->
    <script>
        const modal = document.getElementById('bookingModal');
        let isModalOpen = false;

        function toggleBookingModal() {
            const panel = document.getElementById('bookingModalPanel');
            const body = document.body;
            if (isModalOpen) {
                panel.classList.remove('scale-100', 'opacity-100');
                panel.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    body.classList.remove('modal-open');
                }, 200); 
                isModalOpen = false;
            } else {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                body.classList.add('modal-open');
                setTimeout(() => {
                    panel.classList.remove('scale-95', 'opacity-0');
                    panel.classList.add('scale-100', 'opacity-100');
                }, 10);
                isModalOpen = true;
            }
        }

        function submitModalSelection() {
            const form = document.getElementById('selectPaketForm');
            const selected = form.querySelector('input[name="paket_camping"]:checked');
            
            if (!selected) {
                alert('Silakan pilih salah satu paket terlebih dahulu.');
                return;
            }

            // Arahkan ke halaman booking
            const packageName = encodeURIComponent(selected.value);
            window.location.href = "{{ route('booking.create') }}?paket=" + packageName;
        }

        // Script untuk memastikan efek visual saat card ditekan selalu berfungsi 
        // meskipun recompile CSS sedang mati (tanpa Vite)
        document.addEventListener("DOMContentLoaded", function() {
            const radioButtons = document.querySelectorAll('input[name="paket_camping"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Reset semua gaya card ke default
                    document.querySelectorAll('.paket-label').forEach(label => {
                        label.style.setProperty('background-color', '#ffffff', 'important');
                        label.style.setProperty('border-color', '#e5e7eb', 'important');
                        label.style.setProperty('box-shadow', '0 1px 2px 0 rgba(0, 0, 0, 0.05)', 'important');
                        const check = label.querySelector('.paket-check');
                        if(check) {
                            check.classList.remove('active-check');
                        }
                    });
                    
                    // Beri efek hijau cerah & centang pada card yang baru saja dipilih
                    if(this.checked) {
                        const label = this.closest('.paket-label');
                        label.style.setProperty('background-color', '#f0fdf4', 'important');
                        label.style.setProperty('border-color', '#16a34a', 'important');
                        label.style.setProperty('box-shadow', '0 0 0 2px #16a34a', 'important');
                        const check = label.querySelector('.paket-check');
                        if(check) {
                            check.classList.add('active-check');
                        }
                    }
                });
            });
        });
    </script>
@endsection
