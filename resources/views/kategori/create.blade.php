<h1>Tambah Kategori</h1>

<form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Nama Kategori</label><br>
        <input type="text" name="nama_kategori">
    </div>

    <br>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi"></textarea>
    </div>

    <br>

    <div>
        <label>Gambar</label><br>
        <input type="file" name="gambar">
    </div>

    <br><br>

    <button type="submit">Simpan</button>
</form>
