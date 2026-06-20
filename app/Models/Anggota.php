<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $fillable = [
        'nis', 'nama_anggota', 'email', 'no_hp', 'jenis_anggota', 'tgl_lahir',
        'anggota_sejak', 'tgl_registrasi', 'berlaku_hingga',
        'institusi', 'jenis_kelamin', 'alamat', 'password', 'remember_token'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota');
    }
}
