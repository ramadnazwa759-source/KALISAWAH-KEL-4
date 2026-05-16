<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFasilitas extends Model
{
    use HasFactory;

    protected $table = 'booking_fasilitas';

    protected $fillable = [
        'booking_id',
        'fasilitas_id',
        'qty',
        'harga',
        'subtotal'
    ];

    // relasi ke booking
    public function booking()
    {
        return $this->belongsTo(
            Booking::class,
            'booking_id'
        );
    }

    // relasi ke fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(
            Fasilitas::class,
            'fasilitas_id'
        );
    }
}