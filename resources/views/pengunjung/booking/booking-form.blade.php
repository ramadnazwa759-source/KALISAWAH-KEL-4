<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Booking Camping</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Map custom brand colors agar senada dengan layout utama Kalisawah */
        :root {
            --color-primary: #0f172a;    /* Slate 900 / Dark Navy */
            --color-secondary: #d97706;  /* Amber 600 / Orange Accent */
            --color-success: #0d9488;    /* Teal 600 / Nature Green Element */
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

    <div class="relative bg-slate-950 h-[30vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1600');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-50"></div>
        <div class="relative z-10 text-center px-4">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase bg-slate-900/80 px-3 py-1 rounded-full">Kalisawah Adventure</span>
            <h1 class="text-3xl md:text-4xl font-black text-white mt-3 tracking-tight">Form Reservasi Camping</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 pb-28 -mt-10 relative z-20">
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('booking.camping.store') }}" method="POST" id="mainBookingForm">
            @csrf

            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xs border border-slate-100 mb-6">
                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-900">1. Pilihan Paket Wisata</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Anda bisa menambahkan kuantitas / memilih lebih dari satu paket</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($paketCamping as $paket)
                    <div class="border border-slate-200 rounded-xl p-5 hover:border-amber-500 transition relative flex flex-col justify-between bg-white" id="card_paket_{{ $paket->id }}">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-slate-800 text-base uppercase">{{ $paket->nama_paket }}</h3>
                                <span class="text-xl text-amber-600">⛺</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">👥 Kapasitas: <span id="cap_value_{{ $paket->id }}">{{ $paket->kapasitas }}</span> orang</p>
                            <p class="text-lg font-black text-amber-600 mt-3" data-harga="{{ $paket->harga }}" id="price_paket_{{ $paket->id }}">
                                Rp{{ number_format($paket->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-4 pt-3 border-t border-slate-100">
                            <input type="hidden" name="paket[{{ $paket->id }}][selected]" id="input_selected_{{ $paket->id }}" value="0">
                            <input type="hidden" name="paket[{{ $paket->id }}][qty]" id="input_qty_{{ $paket->id }}" value="0">

                            <button type="button" onclick="adjustPaket('{{ $paket->id }}', -1)" class="w-8 h-8 rounded bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold transition flex items-center justify-center text-sm">-</button>
                            <span id="display_qty_{{ $paket->id }}" class="text-sm font-bold w-6 text-center text-slate-800">0</span>
                            <button type="button" onclick="adjustPaket('{{ $paket->id }}', 1)" class="w-8 h-8 rounded bg-amber-600 text-white hover:bg-amber-700 font-bold transition flex items-center justify-center text-sm">+</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xs border border-slate-100 mb-6">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">2. Data Pemesan & Pengunjung</h2>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" required placeholder="Nama lengkap Anda" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No HP</label>
                            <input type="tel" name="no_hp" required placeholder="Contoh: 081234567xxx" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-amber-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jam</label>
                            <input type="time" name="jam" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-amber-700 uppercase mb-1">Jumlah Pengunjung</label>
                            <input type="number" name="jumlah_pengunjung" id="jumlah_pengunjung" value="1" min="1" required oninput="calculatePricing()" class="w-full px-3 py-2 text-sm rounded-lg border border-amber-300 bg-amber-50/20 font-bold focus:outline-none focus:border-amber-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan tambahan (opsional)..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-amber-500 transition"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xs border border-slate-100 mb-6">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">3. Fasilitas Tambahan (Sewa)</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Item opsional pendukung kenyamanan camping Anda</p>
                </div>

                <div class="space-y-3">
                    @foreach($fasilitasSewa as $fasilitas)
                    <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl hover:bg-slate-50 transition">
                        <div class="flex-1 min-w-0 pr-4">
                            <h4 class="font-bold text-slate-800 text-sm">{{ $fasilitas->nama_fasilitas }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Sisa Stok: {{ $fasilitas->stok }} unit &middot; <span class="text-amber-600 font-semibold">Rp{{ number_format($fasilitas->harga, 0, ',', '.') }}</span></p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="fasilitas[{{ $fasilitas->id }}][qty]" id="input_fasilitas_qty_{{ $fasilitas->id }}" value="0">

                            <button type="button" onclick="adjustFasilitas('{{ $fasilitas->id }}', -1, {{ $fasilitas->stok }})" class="w-7 h-7 rounded bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold transition flex items-center justify-center text-xs">-</button>
                            <span id="display_fasilitas_qty_{{ $fasilitas->id }}" class="text-xs font-bold w-5 text-center text-slate-700" data-harga="{{ $fasilitas->harga }}">0</span>
                            <button type="button" onclick="adjustFasilitas('{{ $fasilitas->id }}', 1, {{ $fasilitas->stok }})" class="w-7 h-7 rounded bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold transition flex items-center justify-center text-xs">+</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 shadow-xl z-50 py-4 px-4">
                <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Estimasi Total Biaya</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-amber-600" id="grand_total_label">Rp0</span>
                            <span class="text-xs hidden" id="extra_ticket_badge"></span>
                        </div>
                        <span class="text-[11px] text-slate-400 block" id="summary_capacity_text">Total Kuota Kapasitas: 0 Orang</span>
                    </div>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-6 py-3 rounded-lg text-sm transition text-center shadow-md">
                        Simpan Booking
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function adjustPaket(id, change) {
            const qtyInput = document.getElementById('input_qty_' + id);
            const selectedInput = document.getElementById('input_selected_' + id);
            const displayQty = document.getElementById('display_qty_' + id);
            const card = document.getElementById('card_paket_' + id);

            if (!qtyInput || !displayQty || !card) return;

            let currentQty = parseInt(qtyInput.value) || 0;
            currentQty += change;
            if (currentQty < 0) currentQty = 0;

            qtyInput.value = currentQty;
            displayQty.innerText = currentQty;

            if (currentQty > 0) {
                selectedInput.value = "1";
                card.classList.replace('border-slate-200', 'border-amber-500');
                card.classList.add('bg-amber-50/10');
            } else {
                selectedInput.value = "0";
                card.classList.replace('border-amber-500', 'border-slate-200');
                card.classList.remove('bg-amber-50/10');
            }
            calculatePricing();
        }

        function adjustFasilitas(id, change, maxStok) {
            const inputQty = document.getElementById('input_fasilitas_qty_' + id);
            const displayQty = document.getElementById('display_fasilitas_qty_' + id);

            if (!inputQty || !displayQty) return;

            let currentQty = parseInt(inputQty.value) || 0;
            currentQty += change;

            if (currentQty < 0) currentQty = 0;
            if (currentQty > maxStok) {
                alert('Stok tidak cukup!');
                currentQty = maxStok;
            }

            inputQty.value = currentQty;
            displayQty.innerText = currentQty;
            calculatePricing();
        }

        function calculatePricing() {
            let totalPaketHarga = 0;
            let totalKapasitasMax = 0;
            let totalFasilitasHarga = 0;

            @foreach($paketCamping as $p)
                if (document.getElementById('input_qty_{{ $p->id }}')) {
                    const pQty = parseInt(document.getElementById('input_qty_{{ $p->id }}').value) || 0;
                    const pHarga = parseFloat(document.getElementById('price_paket_{{ $p->id }}').getAttribute('data-harga')) || 0;
                    const pCap = parseInt(document.getElementById('cap_value_{{ $p->id }}').innerText) || 0;

                    totalPaketHarga += (pQty * pHarga);
                    totalKapasitasMax += (pQty * pCap);
                }
            @endforeach

            @foreach($fasilitasSewa as $f)
                if (document.getElementById('input_fasilitas_qty_{{ $f->id }}')) {
                    const fQty = parseInt(document.getElementById('input_fasilitas_qty_{{ $f->id }}').value) || 0;
                    const fHarga = parseFloat(document.getElementById('display_fasilitas_qty_{{ $f->id }}').getAttribute('data-harga')) || 0;

                    totalFasilitasHarga += (fQty * fHarga);
                }
            @endforeach

            const pengunjungInput = parseInt(document.getElementById('jumlah_pengunjung').value) || 1;
            let biayaTiketTambahan = 0;
            let qtyTiketTambahan = 0;
            const badgeExtra = document.getElementById('extra_ticket_badge');

            if (pengunjungInput > totalKapasitasMax && totalKapasitasMax > 0) {
                qtyTiketTambahan = pengunjungInput - totalKapasitasMax;
                biayaTiketTambahan = qtyTiketTambahan * 25000; 
                
                badgeExtra.innerText = `(+${qtyTiketTambahan} Orang Ekstra)`;
                badgeExtra.classList.remove('hidden');
                badgeExtra.classList.add('inline-block', 'bg-amber-100', 'text-amber-700', 'px-2', 'py-0.5', 'rounded', 'font-bold');
            } else {
                badgeExtra.classList.add('hidden');
            }

            const grandTotal = totalPaketHarga + totalFasilitasHarga + biayaTiketTambahan;
            document.getElementById('grand_total_label').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('summary_capacity_text').innerText = `Total Kuota Kapasitas: ${totalKapasitasMax} Orang`;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const initPaketId = urlParams.get('init_paket');
            
            if (initPaketId) {
                adjustPaket(initPaketId, 1);
            } else {
                calculatePricing();
            }
        });
    </script>
</body>
</html>