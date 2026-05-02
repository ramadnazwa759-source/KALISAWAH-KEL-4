<!DOCTYPE html>
<html>
<head>
    <title>Tambah Fasilitas</title>
</head>
<body>

<h2>Tambah Fasilitas</h2>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/fasilitas" method="POST">
    @csrf

    <label>Nama Fasilitas</label><br>
    <input type="text" name="nama_fasilitas"><br><br>

    <label>Keterangan</label><br>
    <textarea name="keterangan"></textarea><br><br>

    <label>Harga Satuan</label><br>
    <input type="number" name="harga_satuan" step="0.01"><br><br>

    <label>Kategori</label><br>
    <input type="text" name="kategori"><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="/fasilitas">Kembali</a>

</body>
</html>
