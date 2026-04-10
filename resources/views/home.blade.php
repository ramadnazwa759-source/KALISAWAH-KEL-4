    @extends('layouts.app')

    @section('content')

    <!-- HERO SECTION -->

    <section class="hero">

    <div class="hero-text">
    <h1>Selamat Datang di<br>Kalisawah Adventure</h1>

    <p>
    Kalisawah Adventure adalah Wisata berbasis alam pedesaan, edukasi dan petualangan, 
    melayani paket Rafting, Camping, Outbond, Paintball, Villa & Resto, dengan pemandangan area persawah, hutan pinus, sungai badeng dan gunung Raung.
    Berlokasi di Desa Sumberbulu Kecamatan Songgon Kabupaten Banyuwangi
    </p>

    </div>

    </section>


   <!-- GALERI -->
<section class="galeri">

  <div class="galeri-wrapper">

    <!-- KIRI (TEXT) -->
    <div class="galeri-text">
      <h2>Galeri Aktivitas Kalisawah</h2>
      <p>
        Selamat Datang di dunia petualangan alam pedesaan,
        cara menikmati alam dengan sederhana..!
      </p>

      <div class="slider-btn">
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
      </div>
    </div>

    <!-- KANAN (CARD) -->
    <div class="galeri-container">

      <div class="galeri-item">
        <img src="{{ asset('images/camping.jpg') }}">
        <span>Camping</span>
      </div>

      <div class="galeri-item">
        <img src="{{ asset('images/rafting.jpg') }}">
        <span>Rafting</span>
      </div>

      <div class="galeri-item">
        <img src="{{ asset('images/outbond.jpg') }}">
        <span>Outbound</span>
      </div>

      <div class="galeri-item">
        <img src="{{ asset('images/paintbal.jpg') }}">
        <span>Paintball</span>
      </div>

    </div>

  </div>

</section>


    <!-- SEARCH BOOKING -->
<div class="search-box">
    <i class="fa fa-search"></i>
    <input type="text" placeholder="Cari Riwayat Booking Anda Disini ..">
</div>



    <!-- PILIHAN PAKET -->

    <section class="paket">

    <h2>PILIHAN PAKET</h2>

    <div class="paket-container">

    <div class="paket-card">
    <img src="{{ asset('images/paketRafting.jpg') }}">
    <h3>Paket Rafting</h3>

    <div class="paket-bottom">
        <p>
       Camping menikmati suasana alam persawahan dan hutan pinus Songgon,
       di pinggir sungai Badeng, menikmati malam dengan Api Unggun
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

    <div class="paket-card">
    <img src="{{ asset('images/paketCamping.jpg') }}">
    <h3>Paket Camping</h3>

    <div class="paket-bottom">
        <p>
        Menikmati keindahan alam dengan suasana yang tenang dan nyaman,
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

        <div class="paket-card">
    <img src="{{ asset('images/outbond.jpg') }}">
    <h3>Paket Outbound</h3>

    <div class="paket-bottom">
        <p>
        Membangun Team Work menjadi lebih solid dan produktif,
        dipandu fasilitator profesional & berpengalaman
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

      <div class="paket-card">
    <img src="{{ asset('images/paketPaintball.jpg') }}">
    <h3>Paket Paintball</h3>

    <div class="paket-bottom">
        <p>
        Permainan Seru yang akan memacu memacu adrenalin,
        sangat cocok untuk yang suka permainan adrenalin dan kompetisi
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

    <div class="paket-card">
    <img src="{{ asset('images/vila.jpg') }}">
    <h3>Paket Villa</h3>

    <div class="paket-bottom">
        <p>
        Villa dengan pemandangan hamparan sawah, gunung, hutan pinus,
        suara sungai dan udara yang bersih, Kapasita 4 Orang
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

        <div class="paket-card">
    <img src="{{ asset('images/resto.jpg') }}">
    <h3>Paket Resto</h3>

    <div class="paket-bottom">
        <p>
        Resto Kalisawah menyajikan menu-menu tradisional makanan,
        minuman dan camilan ala kampung. Menyediakan Paket Rapat
        </p>
        <button>Lihat Paket</button>
    </div>
    </div>

    </div>

    </section>



   <!-- KABAR -->
<section class="kabar">

  <h2>KABAR KALISAWAH</h2>

  <div class="kabar-container">

    <!-- CARD 1 -->
    <div class="kabar-card">
      <img src="{{ asset('images/kabar1.jpg') }}">
      <div class="kabar-text">
        <h3>Serunya Employee Gathering BTN Banuwangi di Kalisawah Adventure</h3>
        <p>Dari awal keberangkatan, keceriaan sudah terasa.
            Semua karyawan BTN Banyuwangi berkumpul dengan semangat, siap menyambut petualang
            di Kalisawah Adventure. Sepanjang perjalanan, obrolan seru, canda tawa, dan lagu lagu hits mnemani mereka.
        </p>
      </div>
    </div>

    <!-- CARD 2 (DIBALIK) -->
    <div class="kabar-card reverse">
      <img src="{{ asset('images/kabar2.jpg') }}">
      <div class="kabar-text">
        <h3>Rafting di Songgon Banyuwangi: Pengalaman Seru Bersama Kalisawah Adventure</h3>
        <p>Kalisawah Adventure di Songgon, Banyuwangi, menawarkan rafting seru di Sungai Badeng dengan pemandangan alam indah dan layanan aman,
        cocok bagi pecinta petualangan yang ingin merasakan pengalaman tak terlupakan.</p>
      </div>
    </div>
<!-- BUTTON -->
<div class="kabar-btn">
  <button>Lihat Berita Lainnya</button>
</div>
  </div>

</section>



    <!-- LOKASI -->

    <section class="lokasi">

    <h2>LOKASI</h2>

    <iframe
    src="https://maps.google.com/maps?q=banyuwangi&t=&z=13&ie=UTF8&iwloc=&output=embed">
    </iframe>

    </section>

    <!-- HAPUS REGISTER (opsional) -->

<!-- FOOTER -->
<footer class="footer">

  <div class="footer-container">

    <div class="footer-col">
      <h3>KALISAWAH – Wisata Alam & Edukasi</h3>
      <p>
        Nikmati keindahan alam persawahan yang asri dengan suasana
        pedesaan yang menenangkan.
        Kalisawah hadir sebagai destinasi wisata keluarga yang menawarkan
        pengalaman rekreasi, edukasi, dan spot foto estetik di tengah alam Banyuwangi.
      </p>
    </div>

    <div class="footer-col">
      <h4>Media Sosial</h4>
      <p>Instagram : @kalisawah_official</p>
      <p>Facebook : Kalisawah Banyuwangi</p>
      <p>TikTok : @kalisawah.id</p>
      <p>YouTube : Kalisawah Official</p>
    </div>

    <div class="footer-col">
      <h4>Media Sosial</h4>
      <p>Instagram : @kalisawah_official</p>
      <p>Facebook : Kalisawah Banyuwangi</p>
      <p>TikTok : @kalisawah.id</p>
      <p>YouTube : Kalisawah Official</p>
    </div>

  </div>

  <div class="footer-bottom">
    © 2026 Kalisawah Banyuwangi
  </div>

</footer>

    @endsection