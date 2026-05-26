@extends('layouts.app')

@section('title', 'Booking Paintball - Kalisawah Adventure')

@section('content')
    @php
        // HERO CONFIGURATION (Easy to change)
        $heroImage = asset('images/wargame1.jpg');
        $heroTitle = 'PAINT BALL';
        $heroSubtitle = 'Siapkan Strategi dan Team Terbaikmu!';
    @endphp

    <!-- HERO SECTION -->
    <section class="relative h-[80vh] min-h-[600px] w-full overflow-hidden flex items-center justify-center text-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" onerror="this.src='https://picsum.photos/1920/1080?random=1'" alt="Hero Background" class="w-full h-full object-cover">
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
                    Paintball Adventure
                </h3>
            </div>

            <!-- FORM START -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-black text-dark-navy mb-3">Isi Data Reservasi</h2>
                <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-10">
                @csrf
                
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

                        <!-- Jam Booking -->
                        <div class="space-y-2.5 md:col-span-2">
                            <label for="jam" class="block text-[11px] font-bold text-dark-navy uppercase tracking-[0.1em] mb-1 ml-1">Jam Booking</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full h-[56px] px-6 rounded-xl border border-gray-200 bg-white outline-none focus:border-primary transition-all text-sm font-medium text-dark-navy cursor-pointer">
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
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden p-8">
            <h3 class="text-xl font-black text-dark-navy mb-6">Pilih Paket Paintball</h3>
            <div class="grid grid-cols-1 gap-4">
                <button type="button" onclick="addPackage('Paket 1')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary uppercase">Paket 1 (30 Peluru)</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 110.000 / Orang</span>
                </button>
                <button type="button" onclick="addPackage('Paket 2')" class="p-4 rounded-2xl border-2 border-gray-100 hover:border-primary text-left transition-all group">
                    <span class="block font-black text-dark-navy group-hover:text-primary uppercase">Paket 2 (40 Peluru)</span>
                    <span class="block text-xs text-gray-400 font-bold">Rp 140.000 / Orang</span>
                </button>
            </div>
            <button type="button" onclick="closePackageSelector()" class="mt-8 w-full py-4 text-gray-400 font-bold hover:text-gray-600 transition-colors uppercase tracking-widest text-sm">Tutup</button>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const PACKAGES_CONFIG = {
            'Paket 1': { id: 8, price: 110000 }, // Sesuaikan dengan ID di database
            'Paket 2': { id: 9, price: 140000 }  // Sesuaikan dengan ID di database
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
                selectedPackages.set(packageName, { ...PACKAGES_CONFIG[packageName], qty: 4 }); // Default 4 orang
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
                const newQty = pkg.qty + change;
                if (newQty >= 4) {
                    pkg.qty = newQty;
                }
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
                            <p class="text-sm text-primary font-semibold">${formatRupiah(pkg.price)} / Orang</p>
                        </div>
                        <button type="button" onclick="removePackage('${name}')" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <div class="flex justify-end items-center mt-4">
                        <div class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-gray-200">
                            <button type="button" onclick="updateQuantity('${name}', -1)" class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-all font-bold ${pkg.qty <= 4 ? 'opacity-50 cursor-not-allowed' : ''}">-</button>
                            <input type="number" value="${pkg.qty}" min="4" readonly class="w-10 bg-transparent text-center font-bold text-dark-navy text-sm outline-none">
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
                jumlah_pengunjung: 0, // Dihitung dari paket
                catatan: '', // Paintball tidak ada catatan
                paket: [],
                fasilitas: [] // Paintball tidak ada fasilitas tambahan
            };

            let totalPengunjung = 0;
            selectedPackages.forEach(pkg => {
                payload.paket.push({
                    paket_wisat-id: pkg.id,
                    qty: pkg.qty
                });
                totalPengunjung += pkg.qty;
            });

            payload.jumlah_pengunjung = totalPengunjung;

            if (payload.paket.length === 0) {
                loadingOverlay.classList.add('hidden');
                loadingOverlay.classList.remove('flex');
                alert('Silakan pilih minimal satu paket paintball.');
                return;
            }

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
            addPackage('Paket 1'); // Default load paket 1
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