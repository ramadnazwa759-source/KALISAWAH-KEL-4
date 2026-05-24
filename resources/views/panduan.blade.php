@extends('layouts.app')

@section('title', 'Panduan Booking - Kalisawah Adventure')

@section('content')
<section class="pt-32 md:pt-40 pb-24 px-6 md:px-20 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto">
        
        <!-- BREADCRUMB -->
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-gray-600">Panduan Booking</span>
        </nav>

        <!-- HEADER -->
        <header class="border-b-4 border-primary pb-6 mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-dark-navy uppercase tracking-tight">
                Panduan Booking Kalisawah Adventure
            </h1>
            <p class="text-gray-500 mt-2 font-medium">Prosedur Operasional Standar Pemesanan Paket Wisata</p>
        </header>

        <!-- SOP CONTENT -->
        <div class="space-y-10 text-dark-navy leading-relaxed">
            
            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">1.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Pilih Paket Adventure</h3>
                    <p class="text-gray-600">
                        Jelajahi berbagai paket wisata kami (Rafting, Camping, Outbound, dll). Klik <strong class="text-dark-navy italic">“Detail Paket”</strong> untuk melihat informasi lengkap mengenai harga, durasi, serta fasilitas yang didapatkan.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">2.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Isi Form Booking</h3>
                    <p class="text-gray-600">
                        Masukkan data diri Anda secara lengkap (Nama, Nomor HP/WhatsApp, Tanggal Kunjungan) dan tentukan paket yang diinginkan. Pastikan seluruh data telah sesuai sebelum melanjutkan ke tahap konfirmasi.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">3.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Konfirmasi Booking</h3>
                    <p class="text-gray-600">
                        Sistem akan memproses dan menyimpan data reservasi Anda secara otomatis. Setelah konfirmasi, Anda akan diarahkan ke halaman status pemesanan dengan status awal <span class="font-bold text-yellow-600 italic">"Pending"</span>.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">4.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Verifikasi Admin</h3>
                    <p class="text-gray-600">
                        Tim admin akan melakukan validasi data dan pengecekan ketersediaan jadwal pada tanggal yang dipilih. Status pesanan akan diperbarui menjadi <span class="font-bold text-green-600 italic">"Confirmed"</span> jika telah disetujui.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">5.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Kode Booking Dibuat</h3>
                    <p class="text-gray-600">
                        Apabila reservasi telah disetujui, sistem secara otomatis akan menerbitkan <strong class="text-dark-navy">Kode Booking Unik</strong> sebagai bukti reservasi resmi Anda di Kalisawah Adventure.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">6.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Cek Status Booking</h3>
                    <p class="text-gray-600">
                        Pengguna dapat memantau perkembangan status reservasi melalui menu <strong class="text-dark-navy italic">“Cek Status”</strong> yang akan menampilkan rincian paket, tanggal pelaksanaan, serta kode booking yang telah diterbitkan.
                    </p>
                </div>
            </div>

            <div class="flex gap-6">
                <span class="text-2xl font-bold text-primary shrink-0">7.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Selesai / Check-in</h3>
                    <p class="text-gray-600">
                        Pada hari pelaksanaan kegiatan, Anda cukup menunjukkan <strong class="text-dark-navy">Kode Booking</strong> kepada petugas di lokasi untuk keperluan proses validasi akhir dan check-in peserta.
                    </p>
                </div>
            </div>

            <div class="flex gap-6 pb-12 border-b border-gray-100">
                <span class="text-2xl font-bold text-primary shrink-0">8.</span>
                <div>
                    <h3 class="text-xl font-bold mb-2">Fitur Cari Booking</h3>
                    <p class="text-gray-600">
                        Jika Anda kehilangan kode booking, gunakan fitur <strong class="text-dark-navy italic">“Cari Booking”</strong> di halaman utama dengan memasukkan Nama Lengkap atau Nomor HP yang terdaftar untuk melihat riwayat status pesanan.
                    </p>
                </div>
            </div>

        </div>

        <!-- NAVIGATION FOOTER -->
        <div class="mt-12 flex justify-start">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg border-2 border-primary text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all duration-200 active:scale-95 uppercase tracking-wider">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Home
            </a>
        </div>

    </div>
</section>
@endsection
