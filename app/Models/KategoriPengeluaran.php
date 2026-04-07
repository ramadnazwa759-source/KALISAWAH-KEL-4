<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    protected $table = 'kategori_pengeluaran';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    public function pengeluaran()
    {
        return $this->hasMany(PengeluaranOperasional::class, 'id_kategori');
    }
}
