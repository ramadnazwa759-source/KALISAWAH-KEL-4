<!DOCTYPE html>
<html>
<head>
    <title>Edit Fasilitas</title>
</head>
<body>

<h2>Edit Fasilitas</h2>

<form action="/fasilitas/{{ $data->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama</label><br>
    <input type="text" name="nama_fasilitas" value="{{ $data->nama_fasilitas }}"><br><br>

    <label>Keterangan</label><br>
    <textarea name="keterangan">{{ $data->keterangan }}</textarea><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga_satuan" value="{{ $data->harga_satuan }}"><br><br>

    <label>Kategori</label><br>
    <input type="text" name="kategori" value="{{ $data->kategori }}"><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="/fasilitas">Kembali</a>

</body>
</html>
