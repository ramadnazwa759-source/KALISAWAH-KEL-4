<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Paket</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_paket }}</td>
        <td>{{ $item->harga }}</td>

        <td>
            {{-- EDIT --}}
            <a href="{{ route('paket.edit', $item->id) }}">Edit</a>

            {{-- DELETE --}}
            <form action="{{ route('paket.destroy', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')

                <button type="submit" onclick="return confirm('Yakin hapus data ini?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
