<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPaket extends Model
{
    protected $table = 'kategori_paket';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori', 'deskripsi', 'gambar'];

    public function paket()
    {
        return $this->hasMany(PaketWisata::class, 'id_kategori');
    }
}
