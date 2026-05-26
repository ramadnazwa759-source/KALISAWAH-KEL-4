@extends('layouts.app')

@section('title', 'Booking Gathering - Kalisawah Adventure')

@section('content')
    @php
        $paketName = request('paket', 'Paket Gathering');
        $is1Day = in_array(strtolower($paketName), ['kalisawah explorer', 'kalisawah challenge', 'kalisawah action']);
        $is2D1N = in_array(strtolower($paketName), ['kalisawah ultimate', 'kalisawah bonding', 'kalisawah kebersamaan']);
        
        $heroImage = asset('images/outbond.jpg'); // Adjust as needed
        $heroTitle = strtoupper($paketName);
        
        if ($is1Day) {
            $heroTopText = '1 Day Adventure';
        } elseif ($is2D1N) {
            $heroTopText = '2D1N Gathering';
        } else {
            $heroTopText = 'Gathering & Team Building';
        }

        if (strtolower($paketName) == 'kalisawah explorer' || strtolower($paketName) == 'kalisawah ultimate') {
            $heroSubtitle = '“Pengalaman lengkap untuk event corporate premium”';
        } elseif (strtolower($paketName) == 'kalisawah challenge') {
            $heroSubtitle = '“Pilihan terbaik untuk membangun kebersamaan tim secara efektif”';
        } elseif (strtolower($paketName) == 'kalisawah bonding') {
            $heroSubtitle = '“Pilihan terbaik untuk membangun kekompakan tim secara efektif”';
        } elseif (strtolower($paketName) == 'kalisawah action' || strtolower($paketName) == 'kalisawah kebersamaan') {
            $heroSubtitle = '“Paket hemat dengan pengalaman tetap maksimal”';
        } else {
            $heroSubtitle = 'Pesan Paket Gathering & Team Building Anda Sekarang!';
        }
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-[80vh] min-h-[600px] w-full overflow-hidden flex items-center justify-center text-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Gathering Kalisawah" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px]"></div>
        </div>

        <div class="relative z-10 px-6 max-w-5xl mx-auto pt-20">
            <h3 class="text-secondary text-xl md:text-3xl font-black mb-2 tracking-widest uppercase drop-shadow-lg">{{ $heroTopText }}</h3>
            <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight uppercase tracking-tight drop-shadow-2xl">
                {{ $heroTitle }}
            </h1>
            <p class="text-gray-200 text-lg md:text-xl font-medium max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
                {{ $heroSubtitle }}
            </p>
        </div>
    </section>

    <!-- CONTENT SECTION -->
    <section class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <div class="mb-12">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest bg-white px-8 py-4 rounded-2xl shadow-sm border border-gray-100 inline-block">
                    Gathering Package
                </h3>
            </div>

            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                <input type="hidden" id="paket_hidden" value="{{ $paketName }}">
                <input type="hidden" id="harga_hidden" value="{{ request('harga', 0) }}">
                
                <div class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2.5">
                            <label for="nama_pemesan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nama Pemesan</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Masukkan nama Anda" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                        <div class="space-y-2.5">
                            <label for="no_hp" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Nomor HP</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2.5">
                            <label for="tanggal_kunjungan" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Tanggal Booking</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
                        </div>
                        <div class="space-y-2.5">
                            <label for="jam" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jam</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy">
                        </div>
                    </div>

                    <!-- Jumlah Peserta Section -->
                    <div class="space-y-2.5">
                        <label for="jumlah_peserta" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jumlah Peserta (Min. 20 Pax)</label>
                        <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="20" min="20" required onchange="renderSelectedPackages()"
                            class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy placeholder:text-gray-400">
                    </div>

                    <!-- Paket Terpilih Section -->
                    <div class="space-y-6 pt-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] ml-1">Ringkasan Pesanan</h4>
                            <button type="button" onclick="openPackageSelector()" class="text-[11px] font-bold text-primary hover:text-hover-primary transition-colors flex items-center gap-2 mr-1 active:scale-95">
                                <i class="fa-solid fa-plus-circle text-[10px]"></i> TAMBAH PAKET
                            </button>
                        </div>
                        
                        <div id="selected_packages_container" class="space-y-4">
                            <!-- JS populated -->
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

    <!-- PACKAGE SELECTOR MODAL -->
    <div id="packageModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closePackageSelector()"></div>
        <div class="relative w-full max-w-5xl max-h-[90vh] overflow-y-auto bg-white rounded-[32px] shadow-2xl p-8 md:p-12 z-10 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-black text-dark-navy uppercase tracking-wider">Tambah Paket Gathering</h3>
                <button type="button" onclick="closePackageSelector()" class="text-gray-400 hover:text-gray-600 transition-colors text-2xl active:scale-95"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div id="package_modal_options" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- JS dynamically populates this based on category -->
            </div>
            <button type="button" onclick="closePackageSelector()" class="mt-8 w-full py-4 text-gray-400 font-bold hover:text-gray-600 transition-colors uppercase tracking-widest text-sm active:scale-95">Batal</button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const PACKAGES_CONFIG = {
            'Kalisawah Explorer':    { id: 12, price: 520000, category: '1day' },
            'Kalisawah Challenge':   { id: 13, price: 360000, category: '1day' },
            'Kalisawah Action':      { id: 14, price: 290000, category: '1day' },
            'Kalisawah Ultimate':    { id: 15, price: 685000, category: '2d1n' },
            'Kalisawah Bonding':     { id: 16, price: 445000, category: '2d1n' },
            'Kalisawah Kebersamaan': { id: 17, price: 320000, category: '2d1n' }
        };

        const bookingForm = document.getElementById('bookingForm');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const selectedPackagesContainer = document.getElementById('selected_packages_container');
        const jumlahPesertaInput = document.getElementById('jumlah_peserta');
        
        let selectedPackages = new Map();
        let activeCategory = '1day';

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        function openPackageSelector() {
            // Fungsi ini bisa dikembangkan lebih lanjut jika diperlukan
            alert('Fungsi tambah paket lain sedang dalam pengembangan. Silakan pilih satu paket utama terlebih dahulu.');
        }

        function addPackage(packageName) {
            if (PACKAGES_CONFIG[packageName]) {
                const config = PACKAGES_CONFIG[packageName];
                // Hanya izinkan satu paket yang dipilih untuk gathering
                selectedPackages.clear();
                selectedPackages.set(packageName, { ...config });
                activeCategory = config.category;
            }
            renderSelectedPackages();
        }

        function removePackage(packageName) {
            selectedPackages.delete(packageName);
            renderSelectedPackages();
        }

        function renderSelectedPackages() {
            const jumlahPeserta = parseInt(jumlahPesertaInput.value) || 20;

            if (selectedPackages.size === 0) {
                selectedPackagesContainer.innerHTML = `
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-[2rem]">
                        <p class="text-sm text-gray-400 italic font-medium mb-4">Belum ada paket dipilih</p>
                    </div>
                `;
                return;
            }

            selectedPackagesContainer.innerHTML = Array.from(selectedPackages.entries()).map(([name, pkg]) => `
                <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-200 flex items-center justify-between gap-4 shadow-sm">
                    <div class="flex-1">
                        <span class="block font-bold text-dark-navy text-lg uppercase tracking-wide">${name}</span>
                        <span class="block text-xs text-gray-400 font-bold mt-1">${formatRupiah(pkg.price)} / Orang</span>
                    </div>
                    <div class="text-right">
                        <span class="block font-bold text-primary text-xl">${formatRupiah(pkg.price * jumlahPeserta)}</span>
                        <span class="block text-xs text-gray-400 font-medium">${jumlahPeserta} Peserta</span>
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
            const jumlahPeserta = parseInt(data.jumlah_peserta) || 0;

            if (selectedPackages.size === 0) {
                loadingOverlay.classList.add('hidden');
                alert('Silakan pilih paket gathering terlebih dahulu.');
                return;
            }
            
            if (jumlahPeserta < 20) {
                loadingOverlay.classList.add('hidden');
                alert('Jumlah peserta minimal adalah 20 orang.');
                return;
            }

            const payload = {
                nama_pemesan: data.nama_pemesan,
                no_hp: data.no_hp,
                tanggal_kunjungan: data.tanggal_kunjungan,
                jam: data.jam,
                jumlah_pengunjung: jumlahPeserta,
                catatan: '', // Gathering tidak ada catatan spesifik di form ini
                paket: [],
                fasilitas: []
            };

            selectedPackages.forEach(pkg => {
                payload.paket.push({
                    paket_wisata_id: pkg.id,
                    qty: jumlahPeserta // Untuk gathering, qty adalah jumlah peserta
                });
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

                if (!response.ok) {
                    let errorMessage = result.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join('\n');
                    }
                    alert(`Error: ${errorMessage}`);
                    return;
                }

                alert('Booking berhasil! Kode Booking: ' + result.data.kode_booking);
                window.location.href = `/tracking?kode_booking=${result.data.kode_booking}`;

            } catch (error) {
                loadingOverlay.classList.add('hidden');
                console.error('Submission error:', error);
                alert('Terjadi kesalahan saat mengirim data. Periksa koneksi Anda.');
            }
        });

        jumlahPesertaInput.addEventListener('input', renderSelectedPackages);

        document.addEventListener('DOMContentLoaded', function() {
            const initialPackageName = document.getElementById('paket_hidden').value;
            if (initialPackageName && PACKAGES_CONFIG[initialPackageName]) {
                addPackage(initialPackageName);
            } else {
                renderSelectedPackages();
            }
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