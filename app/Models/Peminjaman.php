<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Anggota;
use App\Models\DetailPeminjaman;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_user',
        'id_anggota',
        'tgl_pinjam',
        'tgl_jatuh_tempo',
        'denda_total',
        'denda_keterlambatan',
        'denda_kerusakan',
        'status_pembayaran',
        'tgl_pembayaran',
        'jumlah_peminjaman',
        'status_buku',
        'kode_transaksi'
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}
