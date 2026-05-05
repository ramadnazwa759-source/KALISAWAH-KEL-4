<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingFasilitas extends Model
{
    protected $table = 'booking_fasilitas';

    protected $fillable = [
        'id_booking',
        'id_fasilitas',
        'jumlah'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }
}
