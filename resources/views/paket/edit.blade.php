<h1>Edit Paket Wisata</h1>

<form action="{{ route('paket.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Paket:</label><br>
    <input type="text" name="nama_paket" value="{{ $data->nama_paket }}" required><br><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" value="{{ $data->harga }}" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" required>{{ $data->deskripsi }}</textarea><br><br>

    <label>Kapasitas:</label><br>
    <input type="number" name="kapasitas" value="{{ $data->kapasitas }}" required><br><br>

    <label>Durasi:</label><br>
    <input type="text" name="durasi" value="{{ $data->durasi }}" required><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ $data->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select><br><br>

    <label>Kategori Paket:</label><br>
    <select name="kategori_paket_id" required>
        @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ $data->kategori_paket_id == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Update</button>
    <a href="{{ route('paket.index') }}">Batal</a>
</form>
