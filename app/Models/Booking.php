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
        'tanggal_kunjungan',
        'jam',
        'jumlah_pengunjung',
        'jumlah_tiket_tambahan',
        'harga_tiket_tambahan',
        'subtotal_tiket_tambahan',
        'catatan',
        'total_harga',
        'status_booking',
        'status_pembayaran',
        'tanggal_reschedule',
        'alasan_reschedule',
        'jumlah_reschedule'
    ];

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function fasilitas()
    {
        return $this->hasMany(BookingFasilitas::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}