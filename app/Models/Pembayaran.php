<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_booking',
        'metode',
        'bukti_pembayaran_dp',
        'tanggal_dp',
        'total_harga_awal',
        'id_diskon',
        'total_harga_akhir',
        'bukti_pelunasan',
        'status',
        'tanggal_pelunasan'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_diskon');
    }
}
