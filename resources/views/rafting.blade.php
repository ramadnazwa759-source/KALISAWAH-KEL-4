<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Rafting Songgon</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

* {
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

body {
  background:#f3f5f7;
}

/* HERO */
.hero {
  height:520px;
  background:url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
  position:relative;
}

.hero::after {
  content:'';
  position:absolute;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.45);
}

.hero-content {
  position:absolute;
  z-index:2;
  color:white;
  bottom:60px;
  left:80px;
  max-width:700px;
}

.hero h1 {
  font-size:42px;
  font-weight:700;
}

.hero p {
  font-size:14px;
  margin-top:10px;
}

/* SECTION */
.section {
  padding:50px 80px;
}

.section h2 {
  font-size:22px;
  margin-bottom:20px;
}

/* GRID */
.grid {
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:25px;
}

.img-box {
  height:200px;
  border-radius:25px;
  background-size:cover;
  background-position:center;
}

/* CARD */
.card {
  background:white;
  border-radius:20px;
  padding:25px;
  margin-bottom:30px;
  box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.card-title {
  font-weight:600;
  margin-bottom:15px;
}

.flex {
  display:flex;
  justify-content:space-between;
  gap:30px;
}

.col {
  width:50%;
  font-size:14px;
  color:#555;
}

ul {
  margin-top:10px;
  padding-left:18px;
}

li {
  margin-bottom:6px;
}

/* PRICE */
.price-blue {
  color:#1e73ff;
  font-weight:600;
}

.price-red {
  color:red;
  font-size:13px;
}

/* BUTTON */
.btn {
  background:#ffd400;
  border:none;
  padding:12px 25px;
  border-radius:25px;
  font-weight:600;
  cursor:pointer;
}

/* BOTTOM */
.bottom {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:20px;
}

/* FOOTER */
.footer {
  background:#5bb3d4;
  color:white;
  margin-top:60px;
}

.footer-container {
  display:flex;
  justify-content:space-between;
  padding:40px 80px;
}

.footer-bottom {
  text-align:center;
  background:#3fa0c7;
  padding:10px;
  font-size:13px;
}


</style>
</head>

<body>

<!-- HERO -->
<div class="hero">
  <div class="hero-content">
    <h1>Jelajahi Jeram Sungai Badeng Songgon</h1>
    <p>
      Kalisawah Adventure berlokasi di Desa Sumberbulu, Kecamatan Songgon, Banyuwangi, menawarkan layanan rafting dengan jalur finish terpanjang di kelasnya.
      Suasana nyaman di tengah persawahan dan hutan pinus membuat tempat ini cocok untuk bersantai bersama keluarga sambil menikmati hidangan dari Resto Kalisawah
    </p>
  </div>
</div>

<!-- AREA RAFTING (FIXED) -->
<div class="section">
  <h2>Area Rafting</h2>

    <div class="grid">
      <div class="img-box" style="background-image:url('{{ asset('images/raft1.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/raft2.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/raft3.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/rafting4.jpg') }}')"></div>
    </div>
  </div>
 </div>

<!-- AREA -->
<div class="section">
  <h2>Paket Rafting</h2>

  <!-- ADVENTURE -->
  <div class="card">
    <div class="card-title">PAKET RAFTING ADVENTURE</div>

    <div class="flex">
      <div class="col">
        <p>Jarak + 4 Km dengan jarak tempuh sekitar 2 Jam.</p>

        <p class="price-red">Wisatawan Lokal</p>
        <p><span class="price-blue">Rp. 165.000</span>/orang (minimal 3 orang)</p>

        <p class="price-red">Wisatawan Asing</p>
        <p><span class="price-blue">Rp. 200.000</span>/orang (minimal 2 orang)</p>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Peralatan Rafting (Helm, Safety Jacket, Sepatu)</li>
          <li>Team Rescue</li>
          <li>Team Skipper</li>
          <li>Transport lokal menuju start</li>
          <li>Makan 1x + Snack 1x</li>
          <li>Locker</li>
          <li>Kamar Mandi (20 Unit)</li>
          <li>Mushola</li>
          <li>Resto</li>
          <li>Parkir Bus, Mobil, Motor</li>
        </ul>

        <div class="bottom">
          <div></div>
          <button class="btn">Pesan Paket</button>
        </div>
      </div>
    </div>
  </div>

  <!-- WONDERFUL -->
  <div class="card">
    <div class="card-title">PAKET RAFTING WONDERFUL</div>

    <div class="flex">
      <div class="col">
        <p>Jarak + 3,5 Km dengan jarak tempuh sekitar 1,5 Jam.</p>
        <p><span class="price-blue">Rp. 135.000</span>/pax (minimal 3 orang)</p>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Peralatan Rafting (Helm, Safety Jacket, Sepatu)</li>
          <li>Team Rescue</li>
          <li>Team Skipper</li>
          <li>Transport lokal menuju start</li>
          <li>Makan 1x</li>
          <li>Locker</li>
          <li>Kamar Mandi (20 Unit)</li>
          <li>Mushola</li>
          <li>Resto</li>
          <li>Bus, Mobil, Motor</li>
        </ul>

        <div class="bottom">
          <div></div>
          <button class="btn">Pesan Paket</button>
        </div>
      </div>
    </div>
  </div>

  <!-- LONG TRIP -->
  <div class="card">
    <div class="card-title">PAKET RAFTING LONG TRIP</div>

    <div class="flex">
      <div class="col">
        <p>Jarak + 6 Km dengan jarak tempuh sekitar 3,5 Jam.</p>

        <p class="price-red">Wisatawan Lokal</p>
        <p><span class="price-blue">Rp. 325.000</span>/pax (minimal 3 orang)</p>

        <p class="price-red">Wisatawan Asing</p>
        <p><span class="price-blue">Rp. 375.000</span>/pax (minimal 3 orang)</p>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Peralatan Rafting (Helm, Safety Jacket, Sepatu)</li>
          <li>Team Rescue</li>
          <li>Team Skipper</li>
          <li>Transport lokal menuju start</li>
          <li>Makan 1x + Snack 1x + Air Mineral</li>
          <li>Locker</li>
          <li>Kamar Mandi (20 Unit)</li>
          <li>Mushola</li>
          <li>Resto</li>
          <li>Bus, Mobil, Motor</li>
        </ul>

        <div class="bottom">
          <div></div>
          <button class="btn">Pesan Paket</button>
        </div>
      </div>
    </div>
  </div>

  <!-- SCHOOL -->
  <div class="card">
    <div class="card-title">PAKET RAFTING SCHOOL</div>

    <div class="flex">
      <div class="col">
        <p>Jarak + 3,5 Km dengan jarak tempuh sekitar 1 Jam.</p>
        <p>Cocok untuk siswa setelah kegiatan camping/outbound.</p>

        <p><span class="price-blue">Rp. 110.000</span>/siswa (minimal 3 orang)</p>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Peralatan Rafting (Helm, Safety Jacket, Sepatu)</li>
          <li>Team Rescue</li>
          <li>Team Skipper</li>
          <li>Transport lokal menuju start</li>
          <li>Locker</li>
          <li>Kamar Mandi (20 Unit)</li>
          <li>Mushola</li>
          <li>Resto</li>
          <li>Bus, Mobil, Motor</li>
        </ul>

        <div class="bottom">
          <div></div>
          <button class="btn">Pesan Paket</button>
        </div>
      </div>
    </div>
  </div>

</div>

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

  </div>

  <div class="footer-bottom">
    © 2026 Kalisawah Banyuwangi
  </div>

</footer>
</div>

</body>
</html>