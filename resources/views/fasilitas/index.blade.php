<!DOCTYPE html>
<html>
<head>
    <title>Data Fasilitas</title>
</head>
<body>

<h2>Data Fasilitas</h2>

<a href="/fasilitas/create">+ Tambah</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Fasilitas</th>
        <th>Keterangan</th>
        <th>Harga Satuan</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>

    @forelse($data as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->nama_fasilitas }}</td>
        <td>{{ $item->keterangan }}</td>
        <td>{{ $item->harga_satuan }}</td>
        <td>{{ $item->kategori }}</td>

        <td>
            <!-- EDIT -->
            <a href="/fasilitas/{{ $item->id }}/edit">Edit</a>


            <!-- DELETE -->
            <form action="/fasilitas/{{ $item->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus data?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>

    @empty
    <tr>
        <td colspan="6" align="center">Data kosong</td>
    </tr>
    @endforelse

</table>

</body>
</html>
