@extends('layouts.app')

@section('title', 'Layanan Camping - Kalisawah Adventure')

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

    <!-- CONTENT SECTION (Full-width vertical flow, no main card) -->
    <section class="py-24 px-6 bg-[#F8FAFC]">
        <div class="max-w-[850px] mx-auto">
            
            <!-- PACKAGE TITLE -->
            <div class="mb-12">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest bg-white px-8 py-4 rounded-2xl shadow-sm border border-gray-100 inline-block">
                    {{ request('paket') ? 'Paket ' . request('paket') : 'Pilih Paket Camp' }}
                </h3>
            </div>

            <!-- FORM START -->
            <div class="mb-16 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-dark-navy mb-4">Isi Data Reservasi</h2>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full"></div>
            </div>

            <form id="bookingForm" method="GET" onsubmit="return false;" class="space-y-16">
                @csrf
                <input type="hidden" id="paket_hidden" value="{{ request('paket', 'Pilih Paket Camp') }}">
                
                <!-- 1. CORE DATA SECTION -->
                <div class="space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div class="space-y-3">
                            <label for="nama_pemesan" class="block text-sm font-black text-gray-400 uppercase tracking-widest">Name</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Enter your name" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:border-secondary focus:bg-white focus:ring-0 outline-none transition-all text-dark-navy font-bold">
                        </div>

                        <!-- Whatsapp -->
                        <div class="space-y-3">
                            <label for="no_hp" class="block text-sm font-black text-gray-400 uppercase tracking-widest">Whatsapp</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Enter your number" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:border-secondary focus:bg-white focus:ring-0 outline-none transition-all text-dark-navy font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Tanggal -->
                        <div class="space-y-3">
                            <label for="tanggal_kunjungan" class="block text-sm font-black text-gray-400 uppercase tracking-widest">Tanggal</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:border-secondary focus:bg-white focus:ring-0 outline-none transition-all text-dark-navy font-bold text-lg">
                        </div>

                        <!-- Jam -->
                        <div class="space-y-3">
                            <label for="jam" class="block text-sm font-black text-gray-400 uppercase tracking-widest">Jam</label>
                            <input type="time" id="jam" name="jam" required 
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 focus:border-secondary focus:bg-white focus:ring-0 outline-none transition-all text-dark-navy font-bold text-lg">
                        </div>
                    </div>

                    <!-- Jumlah Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-blue-50/30 rounded-3xl border border-blue-50">
                        <div class="flex items-center justify-between gap-4">
                            <label for="jumlah_orang" class="text-sm font-black text-primary uppercase tracking-widest">Jumlah Orang</label>
                            <input type="number" id="jumlah_orang" name="jumlah_orang" min="1" value="1" 
                                class="w-24 px-4 py-3 rounded-xl border-2 border-primary/10 text-center font-black text-primary focus:border-primary outline-none bg-white">
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <label for="jumlah_tenda" class="text-sm font-black text-primary uppercase tracking-widest">Jumlah Tenda</label>
                            <input type="number" id="jumlah_tenda" name="jumlah_tenda" min="0" value="0" 
                                class="w-24 px-4 py-3 rounded-xl border-2 border-primary/10 text-center font-black text-primary focus:border-primary outline-none bg-white">
                        </div>

                        <!-- DYNAMIC FIELD: Ukuran Tenda (Only for Bawa Tenda Sendiri) -->
                        <div id="ukuran_tenda_container" class="hidden flex flex-col md:flex-row items-center justify-between gap-4 pt-6 border-t border-primary/10 col-span-1 md:col-span-2">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-tent text-primary"></i>
                                <label for="ukuran_tenda" class="text-sm font-black text-primary uppercase tracking-widest">Ukuran Tenda</label>
                            </div>
                            <select id="ukuran_tenda" name="ukuran_tenda" 
                                class="w-full md:w-64 px-4 py-3 rounded-xl border-2 border-primary/10 font-black text-primary focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                                <option value="3-4">Tenda Kapasitas 3–4 Orang</option>
                                <option value="6+">Tenda Kapasitas 6+ Orang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. TAMBAH FASILITAS SECTION -->
                <div class="space-y-10">
                    <div class="text-center">
                        <h3 class="text-2xl md:text-3xl font-black text-dark-navy uppercase tracking-wide">Tambah Fasilitas</h3>
                        <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @php
                            $fasilitas = [
                                ['id' => 1, 'name' => 'Peralatan masak piknik 1 set', 'price' => 'Rp.50.000.-/set', 'desc' => '• 1 Kompor<br>• 1 Set Barbeque Pan<br>• 1 Set Peralatan Makan'],
                                ['id' => 2, 'name' => 'Kayu Api Unggun', 'price' => 'Rp.25.000,-/ikat'],
                                ['id' => 3, 'name' => 'Tabung gas portable', 'price' => 'Rp.35.000,-/tabung'],
                                ['id' => 4, 'name' => 'Sleeping bag', 'price' => 'Rp.10.000,-'],
                                ['id' => 5, 'name' => 'Sound System', 'price' => 'Rp.100.000,-/3 jam'],
                                ['id' => 6, 'name' => 'Matras tebal', 'price' => 'Rp.20.000 /malam']
                            ];
                        @endphp

                        @foreach($fasilitas as $item)
                        <div class="group bg-white rounded-3xl border border-gray-100 p-6 md:p-8 hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                        <h4 class="font-black text-dark-navy text-xl leading-tight">{{ $item['name'] }}</h4>
                                    </div>
                                    <p class="text-primary font-bold text-sm mb-4">{{ $item['price'] }}</p>
                                    @if(isset($item['desc']))
                                    <div class="bg-gray-50/80 rounded-2xl p-5 border-l-4 border-secondary/30">
                                        <p class="text-gray-500 text-sm font-medium leading-relaxed italic">{!! $item['desc'] !!}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-2xl border border-gray-100 self-end md:self-center">
                                    <button type="button" onclick="decrement('fasilitas_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">-</button>
                                    <input type="number" id="fasilitas_{{ $item['id'] }}" name="fasilitas[{{ $item['id'] }}]" value="0" min="0" readonly
                                        class="w-14 bg-transparent text-center font-black text-dark-navy text-xl outline-none">
                                    <button type="button" onclick="increment('fasilitas_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">+</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. PAKET MAKANAN SECTION -->
                <div class="space-y-10">
                    <div class="text-center">
                        <h3 class="text-2xl md:text-3xl font-black text-dark-navy uppercase tracking-wide">Paket makanan</h3>
                        <div class="w-16 h-1 bg-secondary mx-auto mt-4 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        @php
                            $makanan = [
                                ['id' => 101, 'name' => 'Paket Prasmanan', 'price' => '(Rp.25.000 - Rp.35.000) /Porsi'],
                                ['id' => 102, 'name' => 'Paket Nasi Kotak', 'price' => '(Rp.16.000,-)/Porsi']
                            ];
                        @endphp

                        @foreach($makanan as $item)
                        <div class="group bg-white rounded-3xl border border-gray-100 p-6 md:p-8 hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                        <h4 class="font-black text-dark-navy text-xl leading-tight">{{ $item['name'] }}</h4>
                                    </div>
                                    <p class="text-primary font-bold text-sm">{{ $item['price'] }}</p>
                                </div>
                                <div class="flex items-center gap-4 bg-gray-50 p-2 rounded-2xl border border-gray-100 self-end md:self-center">
                                    <button type="button" onclick="decrement('makanan_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">-</button>
                                    <input type="number" id="makanan_{{ $item['id'] }}" name="makanan[{{ $item['id'] }}]" value="0" min="0" readonly
                                        class="w-14 bg-transparent text-center font-black text-dark-navy text-xl outline-none">
                                    <button type="button" onclick="increment('makanan_{{ $item['id'] }}')" 
                                        class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-secondary hover:text-white transition-all active:scale-90 font-bold text-xl shadow-sm">+</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 p-6 bg-blue-50/50 rounded-2xl border-l-4 border-primary italic">
                        <p class="font-bold text-primary">Menu Makanan Ala Menu Desa</p>
                    </div>
                </div>

                <!-- FOOTER BUTTONS -->
                <div class="mt-40 pt-20 border-t-2 border-gray-100 flex flex-col md:flex-row items-center justify-between gap-8">
                    <a href="{{ route('camping') }}" 
                        class="w-full md:w-auto h-[55px] px-12 rounded-full border border-gray-200 bg-white text-gray-500 font-bold text-lg flex items-center justify-center hover:bg-gray-50 transition-all duration-100 ease-in-out active:scale-[0.95] active:shadow-none active:brightness-95 shadow-sm">
                        Kembali
                    </a>
                    <button type="submit" id="submitBtn"
                        style="background-color: #FFC236;"
                        class="w-full md:w-auto h-[55px] px-16 rounded-full text-white font-bold text-lg flex items-center justify-center hover:opacity-90 transition-all duration-100 ease-in-out active:scale-[0.95] active:shadow-none active:brightness-95 shadow-lg shadow-yellow-500/20 disabled:opacity-50">
                        Lanjut
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
        function increment(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value) + 1;
        }

        function decrement(id) {
            const input = document.getElementById(id);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const paket = document.getElementById('paket_hidden').value;
            const ukuranTendaContainer = document.getElementById('ukuran_tenda_container');

            if (paket === 'Bawa Tenda Sendiri') {
                ukuranTendaContainer.classList.remove('hidden');
                ukuranTendaContainer.classList.add('flex');
            } else {
                ukuranTendaContainer.classList.add('hidden');
                ukuranTendaContainer.classList.remove('flex');
            }
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop actual form submission

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = 'Memproses...';

            document.getElementById('loadingOverlay').classList.remove('hidden');
            document.getElementById('loadingOverlay').classList.add('flex');

            // Collect Data
            const formData = {
                nama_pemesan: document.getElementById('nama_pemesan').value,
                no_hp: document.getElementById('no_hp').value,
                tanggal_kunjungan: document.getElementById('tanggal_kunjungan').value,
                jam: document.getElementById('jam').value,
                jumlah_orang: document.getElementById('jumlah_orang').value,
                jumlah_tenda: document.getElementById('jumlah_tenda').value,
                ukuran_tenda: document.getElementById('ukuran_tenda').value,
                paket: document.getElementById('paket_hidden').value,
                fasilitas: {},
                makanan: {}
            };

            // Collect Dynamic Items
            document.querySelectorAll('input[name^="fasilitas"]').forEach(input => {
                const id = input.id.split('_')[1];
                if(input.value > 0) formData.fasilitas[id] = input.value;
            });
            document.querySelectorAll('input[name^="makanan"]').forEach(input => {
                const id = input.id.split('_')[1];
                if(input.value > 0) formData.makanan[id] = input.value;
            });

            // Save to localStorage
            localStorage.setItem('booking_data', JSON.stringify(formData));

            // Redirect
            setTimeout(() => {
                window.location.href = "{{ route('booking.detail') }}";
            }, 800);
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
