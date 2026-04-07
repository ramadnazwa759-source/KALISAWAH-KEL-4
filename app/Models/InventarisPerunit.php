<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarisPerunit extends Model
{
    protected $table = 'inventaris_perunit';

    protected $fillable = [
        'id_jenis',
        'kode_unit',
        'tanggal_beli',
        'harga_beli',
        'kondisi_unit'
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisInventaris::class, 'id_jenis');
    }
}
