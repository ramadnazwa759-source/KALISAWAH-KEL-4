<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'isi_berita',
        'foto',
        'tanggal'
    ];

    public function getSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->judul);
    }
}
