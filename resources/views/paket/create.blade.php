<!DOCTYPE html>
<html>
<head>
    <title>Tambah Paket Wisata</title>
</head>
<body>

    <h1>Tambah Paket Wisata</h1>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('paket.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama Paket</label><br>
            <input type="text" name="nama_paket" value="{{ old('nama_paket') }}">
        </div>

        <br>

        <div>
            <label>Kategori</label><br>
            <select name="kategori_paket_id"required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>
        </div>

        <br>

        <div>
            <label>Harga</label><br>
            <input type="number" name="harga" value="{{ old('harga') }}">
        </div>

        <br>

        <div>
            <label>Kapasitas</label><br>
            <input type="number" name="kapasitas" value="{{ old('kapasitas') }}">
        </div>

        <br>

        <div>
            <label>Durasi</label><br>
            <input type="text" name="durasi" placeholder="Contoh: 3 Hari 2 Malam" value="{{ old('durasi') }}">
        </div>

        <br>

        <div>
            <label>Status</label><br>
            <select name="status">
                <option value="tersedia">Tersedia</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
            </select>
        </div>

        <br><br>

        <button type="submit">Simpan</button>
        <a href="{{ route('paket.index') }}">Kembali</a>

    </form>

</body>
</html>
