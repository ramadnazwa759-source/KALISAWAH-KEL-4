use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\PengeluaranOperasional;
use App\Models\InventarisGunung;
use Illuminate\Support\Carbon;

public function index()
{
    $today = Carbon::today();

    $pemasukan = Pembayaran::whereDate('tanggal_pembayaran', $today)
        ->where('status_verifikasi', 'valid')
        ->sum('nominal_pembayaran');

    $pengeluaran = PengeluaranOperasional::whereDate('tanggal_pengeluaran', $today)
        ->sum('jumlah_pengeluaran');

    $booking = Booking::whereDate('tanggal_mulai', $today)
        ->count();

    $pengunjung = Booking::whereDate('tanggal_mulai', $today)
        ->sum('jumlah_pengunjung');

    $inventaris = InventarisGunung::where('kondisi_unit', 'baik')
        ->count();

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