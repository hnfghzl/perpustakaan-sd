<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eksemplar extends Model
{
    use HasFactory;

    protected $table = 'eksemplar';
    protected $primaryKey = 'id_eksemplar';
    protected $fillable = [
        'id_buku',
        'kode_eksemplar',
        'lokasi_rak',
        'tipe_lokasi',
        'status_eksemplar',
        'harga',
        'tgl_diterima',
        'sumber_perolehan',
        'faktur'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_eksemplar', 'id_eksemplar');
    }
}
