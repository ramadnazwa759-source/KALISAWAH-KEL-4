public function index()
{
    // 1. pemasukan hari ini
    $pemasukan = Transaksi::whereDate('created_at', today())
        ->sum('total');

    // 2. pengeluaran hari ini
    $pengeluaran = Pengeluaran::whereDate('created_at', today())
        ->sum('jumlah');

    // 3. booking hari ini
    $booking = Booking::whereDate('created_at', today())
        ->count();

    // 4. pengunjung hari ini
    $pengunjung = Booking::whereDate('created_at', today())
        ->distinct('nama_pemesan')
        ->count();

    // 5. inventaris kondisi baik
    $inventaris = Inventaris::where('kondisi', 'baik')->count();

    return response()->json([
        'success' => true,
        'data' => [
            'pemasukan_hari_ini' => $pemasukan,
            'pengeluaran_hari_ini' => $pengeluaran,
            'booking_hari_ini' => $booking,
            'pengunjung_hari_ini' => $pengunjung,
            'inventaris_baik' => $inventaris,
        ]
    ]);
}