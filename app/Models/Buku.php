<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    protected $fillable = ['judul', 'no_panggil', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function eksemplar()
    {
        return $this->hasMany(Eksemplar::class, 'id_buku');
    }
}
