@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 pt-32 md:pt-40 pb-32">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">
                {{ isset($booking) ? 'Ubah Reservasi' : 'Reservasi Camping' }}
            </h1>
            <p class="text-slate-500 mt-2 text-base">
                Silakan tentukan jadwal kedatangan, pilih paket wisata terbaik, serta atur fasilitas tambahan sesuai kebutuhan liburan Anda.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 rounded-2xl p-5 mb-8 flex items-start gap-4 border border-red-100">
                <div class="bg-red-100 p-2 rounded-full text-red-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-700 mb-1">Terjadi Kesalahan</h3>
                    <ul class="space-y-1 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ isset($booking) ? route('pengunjung.booking.update', $booking->id) : route('pengunjung.booking.booking-store') }}" method="POST" id="form-reservasi">
            @csrf
            @if(isset($booking)) @method('PUT') @endif

            <div id="hidden-inputs"></div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 sm:p-10 mb-8">
                <div class="mb-8 pb-4 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800">Data Pemesan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan', $booking->nama_pemesan ?? '') }}" 
                            class="w-full h-14 px-5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" placeholder="Masukkan nama pemesan" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $booking->no_hp ?? '') }}" 
                            class="w-full h-14 px-5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Check-In</label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_checkin" value="{{ old('tanggal_kunjungan', $booking->tanggal_kunjungan ?? '') }}" 
                            class="w-full h-14 px-5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jam</label>
                        <input type="time" name="jam" value="{{ old('jam', isset($booking) ? \Carbon\Carbon::parse($booking->jam)->format('H:i') : '') }}" 
                            class="w-full h-14 px-5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Durasi (Malam)</label>
                        <input type="number" name="jumlah_hari" id="lama_menginap" min="1" value="{{ old('jumlah_hari', $booking->jumlah_malam ?? 1) }}" 
                            class="w-full h-14 px-5 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-500 transition-all outline-none font-bold" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Orang</label>
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-2xl h-14 px-2">
                            <button type="button" id="btn-kurang-p" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                            </button>
                            <input type="number" name="jumlah_pengunjung" id="jumlah_pengunjung" value="{{ old('jumlah_pengunjung', $booking->jumlah_pengunjung ?? 1) }}" class="w-12 text-center bg-transparent border-none focus:ring-0 font-bold text-slate-700" readonly>
                            <button type="button" id="btn-tambah-p" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-slate-50 rounded-xl p-5 flex items-start gap-3 border border-slate-200">
                    <div class="text-slate-400 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Jika jumlah pengunjung melebihi total kapasitas paket yang dipilih, akan dikenakan biaya tiket tambahan sebesar <span class="font-bold text-slate-800">Rp 25.000 / orang</span>.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 sm:p-10">
                <div id="container-tab" class="flex overflow-x-auto hide-scrollbar gap-3 mb-8 pb-2 border-b border-slate-100"></div>
                <div id="container-konten-hari"></div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-4 justify-center mt-12 mb-24 items-center">
                <a href="{{ route('landing-page.home') }}" class="px-8 py-4 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold transition w-full sm:w-auto text-center">Kembali</a>
                <button type="submit" class="px-12 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold transition w-full sm:w-auto shadow-lg shadow-blue-600/20">
                    {{ isset($booking) ? 'Simpan Perubahan' : 'Lanjutkan Reservasi' }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal ... (konten modal tetap sama) --}}
<div id="modal-pilih-paket" class="fixed inset-0 z-[999] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" id="modal-backdrop"></div>
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 relative z-20">
        <div class="bg-white w-full max-w-3xl rounded-[2.5rem] shadow-2xl flex flex-col max-h-[85vh] relative" id="modal-content">
            <div class="flex justify-between items-center p-8 border-b border-slate-100 bg-white rounded-t-[2.5rem] shrink-0 sticky top-0 z-10">
                <h3 class="font-bold text-2xl text-slate-800">Pilih Paket</h3>
                <button type="button" id="btn-close-modal" class="w-11 h-11 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-8 bg-slate-50 rounded-b-[2.5rem] overflow-y-auto flex-1">
                @if($paket->isEmpty())
                    <p class="text-center text-slate-500">Tidak ada paket tersedia.</p>
                @else
                    @foreach($paket->groupBy(function($item) { return $item->kategoriPaket->nama_kategori ?? ($item->kategori->nama_kategori ?? 'Umum'); }) as $namaKategori => $kumpulanPaket)
                        <div class="mb-10 last:mb-0">
                            <h4 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-4">{{ $namaKategori }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($kumpulanPaket as $p)
                                    <div class="item-paket-modal border-2 border-slate-200/60 bg-white rounded-3xl p-6 hover:border-blue-500 hover:bg-blue-50/20 cursor-pointer transition-all group" data-id="{{ $p->id }}" data-nama="{{ $p->nama_paket }}" data-harga="{{ $p->harga }}" data-kapasitas="{{ $p->kapasitas ?? 0 }}">
                                        <h5 class="font-bold text-slate-800 mb-3 group-hover:text-blue-600 text-lg transition">{{ $p->nama_paket }}</h5>
                                        <div class="flex items-center justify-between mt-4 border-t border-slate-100 pt-3">
                                            <div>
                                                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Harga</p>
                                                <p class="text-base font-black text-blue-600">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Kapasitas</p>
                                                <p class="text-sm font-bold text-slate-600">{{ $p->kapasitas ?? 0 }} Org</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; transition: 0.2s; }
    input[type="date"]::-webkit-calendar-picker-indicator:hover,
    input[type="time"]::-webkit-calendar-picker-indicator:hover { opacity: 1; }
    input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>

<script>
    let statePackages = {};
    let stateFasilitas = {};
    let targetHariAktif = 0;
    let activeFasCategory = {};
    const allFasilitas = @json($fasilitas);

    @if(isset($booking))
        @foreach($booking->items as $item)
            @php $hariIdx = (int) $item->hari; @endphp
            if (!statePackages[{{ $hariIdx }}]) statePackages[{{ $hariIdx }}] = [];
            statePackages[{{ $hariIdx }}].push({ id: {{ $item->paket_wisata_id }}, nama: "{!! addslashes(optional($item->paketWisata)->nama_paket ?? 'Paket Terpilih') !!}", qty: {{ (int) $item->qty }}, harga: {{ optional($item->paketWisata)->harga ?? 0 }}, kapasitas: "{{ optional($item->paketWisata)->kapasitas ?? 0 }}" });
        @endforeach
        @foreach($booking->fasilitas as $f)
            @php $hariIdxFas = isset($f->hari) ? (int) $f->hari : 0; @endphp
            if (!stateFasilitas[{{ $hariIdxFas }}]) stateFasilitas[{{ $hariIdxFas }}] = {};
            stateFasilitas[{{ $hariIdxFas }}][{{ $f->fasilitas_id }}] = {{ (int) $f->qty }};
        @endforeach
    @endif

    function renderTabs() {
        const jmlMalam = parseInt(document.getElementById('lama_menginap').value) || 1;
        const tanggalCheckin = document.getElementById('tanggal_checkin').value;
        const containerTab = document.getElementById('container-tab');
        const containerKonten = document.getElementById('container-konten-hari');
        const hiddenInputs = document.getElementById('hidden-inputs');

        containerTab.innerHTML = '';
        containerKonten.innerHTML = '';
        if (targetHariAktif >= jmlMalam) targetHariAktif = 0;

        for (let i = 0; i < jmlMalam; i++) {
            let labelTgl = '';
            if (tanggalCheckin) {
                let d = new Date(tanggalCheckin);
                d.setDate(d.getDate() + i);
                labelTgl = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            }
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `px-6 py-4 rounded-2xl flex flex-col items-center min-w-[120px] transition-all border-2 shrink-0 ${i === targetHariAktif ? 'border-blue-600 bg-blue-50 text-blue-600 shadow-sm' : 'border-slate-100 bg-white text-slate-400 hover:border-slate-200'}`;
            btn.innerHTML = `<span class="text-[10px] font-black uppercase tracking-tighter">HARI ${i + 1}</span><span class="text-sm font-bold">${labelTgl}</span>`;
            btn.onclick = () => { targetHariAktif = i; renderTabs(); };
            containerTab.appendChild(btn);
        }

        let html = `<div class="mt-4">
            <div class="flex justify-between items-center mb-6 gap-4">
                <h3 class="font-bold text-slate-800 text-lg">Paket Malam ${targetHariAktif + 1}</h3>
                <button type="button" onclick="bukaModal(${targetHariAktif})" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-all shadow-md active:scale-95 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Paket
                </button>
            </div>`;

        if (statePackages[targetHariAktif]?.length > 0) {
            statePackages[targetHariAktif].forEach((p, idx) => {
                html += `<div class="bg-white border border-slate-200 rounded-3xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 shadow-sm">
                    <div class="flex-1">
                        <p class="font-bold text-slate-800 text-base mb-2.5">${p.nama}</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-xl">Rp ${Number(p.harga).toLocaleString('id-ID')}</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl">Kapasitas: ${p.kapasitas} Org</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-4 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
                        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 p-1 rounded-2xl">
                            <button type="button" onclick="ubahQtyPaket(${targetHariAktif}, ${idx}, -1)" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition active:scale-95">-</button>
                            <span class="font-bold text-slate-700 w-8 text-center text-sm">${p.qty}</span>
                            <button type="button" onclick="ubahQtyPaket(${targetHariAktif}, ${idx}, 1)" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition active:scale-95">+</button>
                        </div>
                        <button type="button" onclick="hapusPaket(${targetHariAktif}, ${idx})" class="px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 font-bold text-xs transition duration-200 active:scale-95">Hapus</button>
                    </div>
                </div>`;
            });
        } else {
            html += `<div class="p-6 border-2 border-dashed border-slate-100 rounded-2xl text-center text-slate-400 text-sm mb-8">Belum ada paket</div>`;
        }

        // --- INI BAGIAN KODE ANDA YANG SUDAH TERINTEGRASI ---
        let groupedFas = {};
        allFasilitas.forEach(f => {
            let cat = f.kategori_fasilitas?.nama_kategori || f.kategori?.nama_kategori || 'Lainnya';
            if (!groupedFas[cat]) groupedFas[cat] = [];
            groupedFas[cat].push(f);
        });
        let cats = Object.keys(groupedFas);
        html += `
        <div class="mt-10 pt-8 border-t border-slate-100">
            <div class="flex items-center justify-between mb-6 gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Fasilitas Tambahan</h3>
                    <p class="text-sm text-slate-400 mt-1">Pilih fasilitas berdasarkan kategori</p>
                </div>
            </div>`;
        if (cats.length > 0) {
            let curIdx = activeFasCategory[targetHariAktif] || 0;
            if (curIdx >= cats.length) curIdx = 0;
            html += `<div class="flex gap-3 overflow-x-auto hide-scrollbar mb-7 pb-1">`;
            cats.forEach((c, idx) => {
                html += `
                    <button type="button" onclick="changeFasCat(${targetHariAktif}, ${idx})" class="px-5 h-11 rounded-2xl text-sm font-bold border transition-all shrink-0 ${idx === curIdx ? 'bg-slate-800 border-slate-800 text-white shadow-md' : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300 hover:bg-slate-50'}">
                        ${c}
                    </button>`;
            });
            html += `</div><div class="grid grid-cols-1 md:grid-cols-2 gap-4">`;
            groupedFas[cats[curIdx]].forEach(f => {
                let qty = stateFasilitas[targetHariAktif]?.[f.id] || 0;
                html += `
                    <div class="rounded-3xl border p-5 flex items-center justify-between gap-4 transition-all ${qty > 0 ? 'bg-blue-50 border-blue-200' : 'bg-white border-slate-200 hover:border-slate-300'}">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm leading-relaxed">${f.nama_fasilitas}</p>
                            <p class="text-xs text-slate-500 mt-1">Rp ${Number(f.harga).toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="ubahQtyFas(${targetHariAktif}, ${f.id}, -1)" class="w-11 h-11 rounded-2xl flex items-center justify-center bg-white border border-slate-200 text-slate-700 font-bold text-lg hover:bg-slate-50 transition active:scale-95">-</button>
                            <span class="w-8 text-center font-bold text-sm text-slate-700">${qty}</span>
                            <button type="button" onclick="ubahQtyFas(${targetHariAktif}, ${f.id}, 1)" class="w-11 h-11 rounded-2xl flex items-center justify-center bg-white border border-slate-200 text-slate-700 font-bold text-lg hover:bg-slate-50 transition active:scale-95">+</button>
                        </div>
                    </div>`;
            });
            html += `</div>`;
        } else {
            html += `<p class="text-slate-400 text-sm">Tidak ada fasilitas tersedia.</p>`;
        }
        html += `</div></div>`;
        // --- SELESAI BAGIAN KODE ANDA ---

        containerKonten.innerHTML = html;
        let hiddenHtml = '';
        for (let h in statePackages) {
            statePackages[h].forEach(p => {
                hiddenHtml += `<input type="hidden" name="paket[${h}][]" value="${p.id}">`;
                hiddenHtml += `<input type="hidden" name="paket_qty[${h}][${p.id}]" value="${p.qty}">`;
            });
        }
        let aggregatedFas = {};
        for (let h in stateFasilitas) {
            for (let fId in stateFasilitas[h]) {
                if (!aggregatedFas[fId]) aggregatedFas[fId] = 0;
                aggregatedFas[fId] += stateFasilitas[h][fId];
            }
        }
        for (let fId in aggregatedFas) {
            if (aggregatedFas[fId] > 0) hiddenHtml += `<input type="hidden" name="fasilitas[${fId}]" value="${aggregatedFas[fId]}">`;
        }
        hiddenInputs.innerHTML = hiddenHtml;
    }

    window.changeFasCat = (h, i) => { activeFasCategory[h] = i; renderTabs(); };
    window.ubahQtyFas = (h, id, v) => { if(!stateFasilitas[h]) stateFasilitas[h] = {}; stateFasilitas[h][id] = Math.max(0, (stateFasilitas[h][id] || 0) + v); renderTabs(); };
    window.ubahQtyPaket = (h, i, v) => { statePackages[h][i].qty = Math.max(1, statePackages[h][i].qty + v); renderTabs(); };
    window.hapusPaket = (h, i) => { statePackages[h].splice(i, 1); renderTabs(); };
    window.bukaModal = (h) => { targetHariAktif = h; document.getElementById('modal-pilih-paket').classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
    window.tutupModal = () => { document.getElementById('modal-pilih-paket').classList.add('hidden'); document.body.style.overflow = ''; };
    document.getElementById('btn-close-modal').onclick = tutupModal;

    document.querySelectorAll('.item-paket-modal').forEach(el => {
        el.onclick = () => {
            if(!statePackages[targetHariAktif]) statePackages[targetHariAktif] = [];
            statePackages[targetHariAktif].push({ id: el.dataset.id, nama: el.dataset.nama, qty: 1, harga: el.dataset.harga, kapasitas: el.dataset.kapasitas });
            tutupModal(); renderTabs();
        };
    });

    document.getElementById('btn-tambah-p').onclick = () => { document.getElementById('jumlah_pengunjung').value++; };
    document.getElementById('btn-kurang-p').onclick = () => { let i = document.getElementById('jumlah_pengunjung'); if(i.value > 1) i.value--; };
    document.getElementById('tanggal_checkin').onchange = renderTabs;
    document.getElementById('lama_menginap').oninput = renderTabs;

    renderTabs();
</script>
@endsection