<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kalisawah Adventure</title>

  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f4f6f8;
      color: #333;
    }

     /* CONTAINER (INI KUNCI BIAR TIDAK FULL KE SAMPING) */
    .container {
      max-width: 420px;
      margin: auto;
    }

    /* HERO */
    .hero {
      background: url('{{ asset("images/camp1.jpg") }}') center/cover no-repeat;
      height: 500px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 20px;
    }

    .hero-content {
      max-width: 700px;
    }

    .hero h1 {
      font-size: 30px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 14px;
      line-height: 1.6;
    }

    /* SECTION */
    .section {
      padding: 25px 20px;
    }

    h2 {
      font-size: 18px;
      margin-bottom: 10px;
      font-weight: 600;
    }

    h3 {
      font-size: 15px;
      margin: 10px 0;
      font-weight: 500;
    }

    /* GRID IMAGE */
    .grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 15px;
    }

    .img-box {
      height: 140px;
      border-radius: 18px;
      background-size: cover;
      background-position: center;
    }

    /* PACKAGE CARD */
    .package {
      background: white;
      border-radius: 18px;
      padding: 18px;
      margin-top: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .package-title {
      font-weight: 600;
      margin-bottom: 10px;
    }

    .flex {
      display: flex;
      justify-content: space-between;
      gap: 15px;
    }

    .col {
      width: 50%;
      font-size: 13px;
    }

    ul {
      padding-left: 18px;
      margin-top: 5px;
    }

    li {
      margin-bottom: 3px;
    }

    .note {
      color: red;
      font-size: 12px;
      margin-top: 5px;
    }

    .bottom {
      margin-top: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: #1e73ff;
      font-weight: 600;
      font-size: 13px;
    }

    .btn {
      background: #ffd400;
      border: none;
      padding: 10px 18px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
    }

    /* FOOTER */
    .footer {
      margin-top: 30px;
      background: #4da3c7;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 12px;
    }

  </style>
</head>
<body>

  <!-- HERO -->
  <div class="hero">
    <div class="hero-content">
      <h1>Layanan Camping Kalisawah Adventure</h1>
      <p>Kalisawah Adventure pengalaman camping alami di alam terbuka dengan suasana asri dan private, dikelilingi persawahan, hutan pinus, dan sungai.</p>
    </div>
  </div>

  <!-- AREA CAMPING -->
  <div class="section">
    <h2>Area Camping</h2>

   <h3 style="text-align: center;">Area Camping Hutan Pinus</h3>
    <div class="grid">
      <div class="img-box" style="background-image:url('{{ asset('images/camphutan.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/camppinus.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/camppagi.jpg') }}')"></div>
      <div class="img-box" style="background-image:url('{{ asset('images/camp.jpg') }}')"></div>
    </div>

<h3 style="text-align: center;">Area Camping Villa – Persawahan</h3>
    <div class="grid">
  <div class="img-box" style="background-image:url('{{ asset('images/campvila.jpg') }}')"></div>
  <div class="img-box" style="background-image:url('{{ asset('images/vilacamp.jpg') }}')"></div>
</div>
  </div>

  <!-- PAKET -->
  <div class="package">

  <div class="package-title">PAKET – CAMP 1</div>

  <div class="package-inner"> <!-- 🔥 WAJIB ADA -->

    <div class="flex">
      <div class="col">
        <b>Terdiri:</b>
        <ul>
          <li>Tenda kapasitas 4 orang</li>
          <li>2 matras tebal</li>
        </ul>
        <div class="note">Tambahan orang dikenakan tiket 25rb/orang</div>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Mushola</li>
          <li>Kamar mandi</li>
          <li>Api unggun</li>
          <li>Free wifi</li>
          <li>Parkir</li>
        </ul>
      </div>
    </div>

    <div class="bottom">
      <div class="price">Rp. 185.000,- /tenda/malam</div>
      <button class="btn">Pesan Paket</button>
    </div>

  </div> <!-- 🔥 PENUTUP -->
</div>

<div class="package">

  <!-- 🔥 JUDUL PINDAH KE SINI -->
  <div class="package-title">PAKET – CAMP 2</div>

  <div class="package-inner">

    <div class="flex">
      <div class="col">
        <b>Terdiri:</b>
        <ul>
          <li>Tenda kapasitas 4 orang</li>
          <li>2 matras biasa</li>
        </ul>
        <div class="note">Tambahan orang dikenakan tiket 25rb/orang</div>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Mushola</li>
          <li>Kamar mandi</li>
          <li>Api unggun</li>
          <li>Free wifi</li>
          <li>Parkir</li>
        </ul>
      </div>
    </div>

    <div class="bottom">
      <div class="price">Rp. 150.000,- /tenda/malam</div>
      <button class="btn">Pesan Paket</button>
    </div>

  </div>
</div>

    <!-- CAMPING SCHOOL -->
<div class="package">

  <div class="package-title">Camping School – LDKS – Pramuka – Mahasiswa</div>

  <div class="package-inner">

    <div class="flex">
      <div class="col">
        <b>Terdiri:</b>
        <ul>
          <li>Minimal 20 orang</li>
          <li>Sewa tenda 50 rb/malam, kapasitas tenda untuk 4 anak.</li>
        </ul>

        <div class="note">
          <b>Catatan:</b><br>
          Tambahan orang dikenakan tiket 25 rb/orang/anak
        </div>
      </div>

      <div class="col">
        <b>Fasilitas:</b>
        <ul>
          <li>Mushola</li>
          <li>Kamar Mandi (20 Unit)</li>
          <li>Api Unggun</li>
          <li>Panggung Pentas untuk Acara</li>
          <li>Aula</li>
          <li>Dapur Umum</li>
          <li>Free Wifi</li>
          <li>Free Parkir</li>
          <li>Listrik</li>
          <li>Penjaga yang siap melayani kamu</li>
        </ul>
      </div>
    </div>

    <div class="bottom">
      <div class="price">Rp. 15 rb/siswa/malam</div>
      <button class="btn">Pesan Paket</button>
    </div>

  </div>

</div>

<!-- FASILITAS LAIN -->
<div class="package">

  <div class="package-title">FASILITAS LAIN-LAIN:</div>

  <div class="package-inner">

    <div class="flex">
      <div class="col">
        <b>Terdiri:</b>
        <ul>
          <li>Peralatan Masak Piknik 1 Set Rp. 50.000,-/set:
            <ul>
              <li>1 Kompor</li>
              <li>1 Set Barbeque Pan</li>
              <li>1 Set Peralatan Makan</li>
            </ul>
          </li>
          <li>Kayu Api Unggun, Rp. 25.000,-/ikat</li>
          <li>Tabung gas portable, Rp.35.000,-/tabung</li>
          <li>Sleeping bag Rp.10.000,-</li>
          <li>Sound System 100.000,-/3 jam</li>
          <li>Matras tebal 20 rb/malam.</li>
        </ul>
      </div>

      <div class="col">
        <b>Paket Makan:</b>
        <ul>
          <li>Paket Prasmanan (Rp. 25.000 – Rp.35.000)/Porsi</li>
          <li>Paket Nasi Kotak (Rp. 16.000,-/Porsi)</li>
          <li>Menu Makanan ala Menu Desa</li>
        </ul>
      </div>
    </div>

    <div class="bottom">
      <div></div>
      <button class="btn">Pesan Paket</button>
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

</body>
</html>