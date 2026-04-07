<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'id_kategori',
        'nama_paket',
        'deskripsi',
        'harga',
        'kapasitas',
        'durasi',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPaket::class, 'id_kategori');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_paket');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'paket_fasilitas', 'id_paket', 'id_fasilitas')
                    ->withPivot('jumlah', 'keterangan');
    }
}
