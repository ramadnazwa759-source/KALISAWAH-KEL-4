<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPaket extends Model
{
    public $timestamps = false;
    // Nama tabel
    protected $table = 'kategori_paket';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'gambar'
    ];

    // Relasi (1 kategori punya banyak paket wisata)
    public function paketWisata()
    {
        return $this->hasMany(PaketWisata::class, 'kategori_paket_id');
    }
}

