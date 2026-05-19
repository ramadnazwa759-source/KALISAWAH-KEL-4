<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $table = 'booking_items';

    protected $fillable = [
        'booking_id',
        'paket_wisata_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function paket()
    {
        return $this->belongsTo(PaketWisata::class, 'paket_wisata_id');
    }
}