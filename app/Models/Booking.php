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

        'diskon_manual',

        'total_harga_final',

        'status_booking',

        'status_pembayaran',

        'tanggal_reschedule',

        'alasan_reschedule',

        'jumlah_reschedule'
    ];

    // RELASI BOOKING ITEM
    public function bookingItem()
    {
        return $this->hasMany(
            BookingItem::class,
            'booking_id'
        );
    }

    // RELASI BOOKING FASILITAS
    public function bookingFasilitas()
    {
        return $this->hasMany(
            BookingFasilitas::class,
            'booking_id'
        );
    }

    // RELASI PEMBAYARAN
    public function pembayaran()
    {
        return $this->hasMany(
            Pembayaran::class,
            'booking_id'
        );
    }
}