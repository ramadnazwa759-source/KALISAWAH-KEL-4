<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
</head>
<body>

    <h1>Edit Kategori</h1>

    {{-- Menampilkan error --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Kategori</label><br>
            <input type="text" name="nama_kategori"
                   value="{{ old('nama_kategori', $data->nama_kategori) }}">
        </div>

        <br><br>

        <button type="submit">Update</button>
        <a href="{{ route('kategori.index') }}">Kembali</a>
    </form>

</body>
</html>
