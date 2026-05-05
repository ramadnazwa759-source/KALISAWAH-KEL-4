<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

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

    // RELASI KE PAKET WISATA
    public function paket()
    {
        return $this->belongsTo(PaketWisata::class, 'id_paket', 'id');
    }

    // RELASI KE PEMBAYARAN
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_booking', 'id');
    }

    // RELASI KE FASILITAS (MANY TO MANY)
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'booking_fasilitas',
            'id_booking',
            'id_fasilitas'
        )->withPivot('jumlah');
    }
}