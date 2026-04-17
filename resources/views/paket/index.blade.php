{{-- resources/views/paket/index.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Daftar Paket Wisata</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('paket.create') }}" class="btn btn-primary mb-3">Tambah Paket Wisata</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Paket</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Kapasitas</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_paket }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td>{{ $p->kapasitas }}</td>
                    <td>{{ $p->durasi }}</td>
                    <td>
                        @if($p->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('paket.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('paket.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus paket ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada paket wisata</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
