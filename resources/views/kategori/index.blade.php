<!-- resources/views/kategori/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kategori Paket</title>
</head>
<body>
    <h1>Daftar Kategori Paket</h1>

    @if($data->isEmpty())
        <p>Tidak ada data</p>
    @else
        <ul>
            @foreach($data as $kategori)
                <li>{{ $kategori->nama_kategori }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
