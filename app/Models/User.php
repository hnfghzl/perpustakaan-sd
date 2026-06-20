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

    /**
     * Accessor agar auth()->user()->name bekerja (kompatibel dengan Laravel Auth)
     */
    public function getNameAttribute(): string
    {
        return $this->nama_user ?? '';
    }

    public function logAktivitas() {
        return $this->hasMany(LogAktivitas::class, 'id_user');
    }

    public function peminjaman() {
        return $this->hasMany(Peminjaman::class, 'id_user');
    }
}
