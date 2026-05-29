<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    protected $fillable = [

        'booking_id',

        'sumber_pemasukan',

        'keterangan',

        'jumlah_uang',

        'tanggal_pemasukan',

        'dicatat_oleh'
    ];

    // ======================================================
    // RELASI KE BOOKING
    // nullable karena pemasukan bisa manual
    // ======================================================
    public function booking()
    {
        return $this->belongsTo(
            Booking::class,
            'booking_id'
        );
    }
}