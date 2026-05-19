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
