
@section('content')
<div class="container">
    <h2>Hapus Fasilitas</h2>

    <p>Yakin ingin menghapus data ini?</p>

    <ul>
        <li>Nama: {{ $data->nama_fasilitas }}</li>
        <li>Kategori: {{ $data->kategori }}</li>
    </ul>

    <form action="/fasilitas/{{ $data->id_fasilitas }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Ya, Hapus</button>
        <a href="/fasilitas">Batal</a>
    </form>
</div>
@endsection
