<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Anggota extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $fillable = [
        'nama_anggota', 'email', 'jenis_anggota', 'tgl_lahir',
        'anggota_sejak', 'tgl_registrasi', 'berlaku_hingga',
        'institusi', 'jenis_kelamin', 'alamat'
    ];

    public function peminjaman() {
        return $this->hasMany(Peminjaman::class, 'id_anggota');
    }
}
