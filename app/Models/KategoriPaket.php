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

    public function getNamaAttribute()
    {
        return $this->nama_kategori;
    }

    public function getSlugAttribute()
    {
        $nama = strtolower($this->nama_kategori);
        if (str_contains($nama, 'camping')) {
            return route('camping');
        } elseif (str_contains($nama, 'rafting')) {
            return route('rafting');
        } elseif (str_contains($nama, 'outbound')) {
            return route('outbound');
        } elseif (str_contains($nama, 'paintball')) {
            return url('/paintball');
        } elseif (str_contains($nama, 'gathering')) {
            return route('gathering');
        } elseif (str_contains($nama, 'jeep')) {
            return url('/jeeptour');
        }
        return '#';
    }

    public function getLinkAttribute()
    {
        return $this->slug;
    }
}

