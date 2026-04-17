<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'kode_booking',
        'nama_pemesan',
        'no_hp',
        'id_paket',
        'tanggal_kunjungan',
        'jam',
        'jumlah_orang',
        'jumlah_tenda',
        'catatan',
        'status_booking'
    ];

    public function paket()
    {
        return $this->belongsTo(PaketWisata::class, 'id_paket', 'id_paket');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_booking', 'id_booking');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'booking_fasilitas', 'id_booking', 'id_fasilitas')
                    ->withPivot('jumlah');
    }
}
