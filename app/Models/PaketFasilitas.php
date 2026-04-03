<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketFasilitas extends Model
{
    protected $table = 'paket_fasilitas';
    protected $primaryKey = 'id_pf';

    protected $fillable = [
        'id_paket',
        'id_fasilitas',
        'jumlah',
        'keterangan'
    ];
}
