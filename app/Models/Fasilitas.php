<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $primaryKey = 'id'; // WAJIB SESUAI DB

    public $timestamps = false;

    protected $fillable = [
        'nama_fasilitas',
        'keterangan',
        'harga_satuan',
        'kategori'
    ];
}
