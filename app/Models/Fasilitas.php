<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'nama_fasilitas',
        'keterangan',
        'harga_satuan',
        'kategori'
    ];

    public function paket()
    {
        return $this->belongsToMany(PaketWisata::class, 'paket_fasilitas', 'id_fasilitas', 'id_paket');
    }
}
