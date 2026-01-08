<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';
    protected $fillable = [
        'id_peminjaman', 'id_eksemplar', 'tgl_kembali', 'kondisi_kembali', 'denda_item'
    ];

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function eksemplar() {
        return $this->belongsTo(Eksemplar::class, 'id_eksemplar');
    }
}
