<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';
    protected $fillable = [
        'nama_user', 'bergabung_sejak', 'tgl_registrasi',
        'berlaku_hingga', 'role', 'email', 'password', 'foto_profil'
    ];

    public function logAktivitas() {
        return $this->hasMany(LogAktivitas::class, 'id_user');
    }

    public function peminjaman() {
        return $this->hasMany(Peminjaman::class, 'id_user');
    }
}
