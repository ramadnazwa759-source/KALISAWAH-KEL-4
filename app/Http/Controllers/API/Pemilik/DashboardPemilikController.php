use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Inventaris;
use Illuminate\Support\Carbon;

public function index()
{
    $today = Carbon::today();

    // =========================
    // PEMASUKAN HARI INI
    // =========================
    $pemasukan = Transaksi::whereDate('created_at', $today)
        ->sum('total');

    // =========================
    // PENGELUARAN HARI INI
    // =========================
    $pengeluaran = Pengeluaran::whereDate('created_at', $today)
        ->sum('jumlah');

    // =========================
    // BOOKING HARI INI
    // =========================
    $booking = Booking::whereDate('created_at', $today)
        ->count();

    // =========================
    // PENGUNJUNG HARI INI
    // =========================
    $pengunjung = Booking::whereDate('created_at', $today)
        ->distinct('nama_pemesan')
        ->count();

    // =========================
    // INVENTARIS BAIK
    // =========================
    $inventaris = Inventaris::where('kondisi', 'baik')
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