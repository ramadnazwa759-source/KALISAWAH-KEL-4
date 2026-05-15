<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketFasilitas extends Model
{
    protected $table = 'paket_fasilitas';

      public $timestamps = false; // 

    protected $fillable = [
        'id_paket',
        'id_fasilitas',
        'jumlah',
        'keterangan'
    ];

    // Relasi ke PaketWisata
    public function paket()
    {
        return $this->belongsTo(PaketWisata::class, 'id_paket');
    }

    // Relasi ke Fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }
}