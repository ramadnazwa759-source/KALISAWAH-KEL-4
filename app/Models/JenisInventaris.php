<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisInventaris extends Model
{
    protected $table = 'jenis_inventaris';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kategori',
        'keterangan'
    ];

    public function units()
    {
        return $this->belongsTo(JenisInventaris::class, 'id_jenis', 'id');
    }
}