<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [

        'booking_id',

        'metode_pembayaran',

        'jenis_pembayaran',

        'jumlah_bayar',

        'bukti_pembayaran',

        'status_verifikasi'
    ];

    // RELASI KE BOOKING
    public function booking()
    {
        return $this->belongsTo(
            Booking::class,
            'booking_id'
        );
    }
}