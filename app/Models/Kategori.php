<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama', 'deskripsi'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'id_kategori');
    }
}
