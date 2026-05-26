@extends('layouts.app')

@section('title', 'Booking Jeep Tour - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION
        $heroImage = asset('images/outbond.jpg'); // Same as jeeptour page for consistency
        $heroTitle = 'ADVENTURE JEEP';
        $heroSubtitle = '“Nikmati perjalanan adventure menyusuri alam Songgon bersama Jeep Kalisawah.”';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-[80vh] min-h-[600px] w-full overflow-hidden flex items-center justify-center text-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" alt="Hero Background" class="w-full h-full object-cover">
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
                    Jeep Tour Package
                </h3>
            </div>

            <!-- FORM START -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                <input type="hidden" id="paket_hidden" value="Adventure JEEP">
                
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
                            <h4 class="text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] ml-1">Paket Dipilih</h4>
                        </div>
                        
                        <div id="selected_packages_container" class="space-y-4">
                            <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-200 flex items-center justify-between gap-4 shadow-sm group hover:shadow-md transition-all duration-300">
                                <div class="flex-1">
                                    <span class="block font-bold text-dark-navy text-lg uppercase tracking-wide group-hover:text-primary transition-colors">Adventure JEEP</span>
                                    <span class="block text-xs text-gray-400 font-bold mt-1">Rp 275.000 / Orang (Min 5 Orang)</span>
                                </div>
                                <div class="flex items-center gap-3 bg-gray-50/50 p-2 rounded-2xl border border-gray-100">
                                    <button type="button" onclick="updatePackageQty(-1)" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">-</button>
                                    <span id="qty_display" class="w-10 text-center font-black text-primary text-lg">5</span>
                                    <button type="button" onclick="updatePackageQty(1)" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RINGKASAN PESANAN -->
                    <div class="space-y-6 pt-12 border-t border-gray-100">
                        <h3 class="text-xl font-black text-dark-navy uppercase tracking-widest mb-6 flex items-center gap-3">
                            <span class="w-2 h-8 bg-primary rounded-full"></span>
                            Ringkasan Pesanan
                        </h3>
                        <div class="bg-white rounded-3xl border border-gray-200 p-8 space-y-4">
                            <div class="flex justify-between items-center text-sm font-bold text-gray-500 uppercase tracking-widest">
                                <span>Total Biaya</span>
                                <span id="total_price_display" class="text-primary text-2xl font-black">Rp 1.375.000</span>
                            </div>
                        </div>
                    </div>
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
    <script>
        const PACKAGE_ID = 11; // Sesuaikan dengan ID paket "Adventure JEEP" di database
        const MIN_QTY = 5;
        const PRICE_PER_PERSON = 275000;
        let currentQty = MIN_QTY;

        const bookingForm = document.getElementById('bookingForm');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const qtyDisplay = document.getElementById('qty_display');
        const totalPriceDisplay = document.getElementById('total_price_display');

        function updatePackageQty(delta) {
            currentQty = Math.max(MIN_QTY, currentQty + delta);
            qtyDisplay.innerText = currentQty;
            updateTotalPrice();
        }

        function updateTotalPrice() {
            const total = currentQty * PRICE_PER_PERSON;
            const formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
            totalPriceDisplay.innerText = formattedTotal;
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
                jumlah_pengunjung: currentQty,
                catatan: '', // Jeep Tour tidak ada catatan
                paket: [
                    {
                        paket_wisata_id: PACKAGE_ID,
                        qty: currentQty
                    }
                ],
                fasilitas: [] // Jeep Tour tidak ada fasilitas tambahan
            };

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

        // Initialize display
        updateTotalPrice();
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