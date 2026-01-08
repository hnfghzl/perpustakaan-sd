<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Eksemplar;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeComponent extends Component
{
    public function render()
    {
        // Hitung total anggota
        $totalAnggota = Anggota::count();
        $totalGuru = Anggota::where('jenis_anggota', 'guru')->count();
        $totalSiswa = Anggota::where('jenis_anggota', 'siswa')->count();

        // Hitung total buku
        $totalBuku = Buku::count() ?? 0;

        // Hitung peminjaman aktif dari eksemplar yang statusnya dipinjam
        $peminjamanAktif = Eksemplar::where('status_eksemplar', 'dipinjam')->count() ?? 0;

        // Hitung buku yang sudah lewat waktu (terlambat) 
        // Ambil dari peminjaman yang masih aktif (status_buku = dipinjam) dan melewati jatuh tempo
        $bukuTerlambat = Peminjaman::where('status_buku', 'dipinjam')
            ->where('tgl_jatuh_tempo', '<', Carbon::now())
            ->count() ?? 0;

        // Hitung total user admin
        $totalAdmin = User::count();

        // STATISTIK DENDA
        // Total denda yang belum dibayar
        $totalDendaBelumDibayar = Peminjaman::where('status_pembayaran', 'belum_dibayar')
            ->selectRaw('SUM(denda_keterlambatan + denda_kerusakan) as total')
            ->value('total') ?? 0;

        // Total denda yang sudah dibayar (pendapatan)
        $totalDendaSudahDibayar = Peminjaman::where('status_pembayaran', 'sudah_dibayar')
            ->selectRaw('SUM(denda_keterlambatan + denda_kerusakan) as total')
            ->value('total') ?? 0;

        // Jumlah transaksi dengan denda belum dibayar
        $jumlahTransaksiBelumDibayar = Peminjaman::where('status_pembayaran', 'belum_dibayar')
            ->whereRaw('(denda_keterlambatan + denda_kerusakan) > 0')
            ->count() ?? 0;

        // Data untuk grafik - Statistik peminjaman per bulan (6 bulan terakhir)
        $peminjamanPerBulan = [];
        $bulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            $peminjamanPerBulan[] = Peminjaman::whereYear('tgl_pinjam', $bulan->year)
                ->whereMonth('tgl_pinjam', $bulan->month)
                ->count();
        }

        // Data untuk grafik - Status eksemplar
        $eksemplarTersedia = Eksemplar::where('status_eksemplar', 'tersedia')->count();
        $eksemplarDipinjam = Eksemplar::where('status_eksemplar', 'dipinjam')->count();
        $eksemplarRusak = Eksemplar::where('status_eksemplar', 'rusak')->count();
        $eksemplarHilang = Eksemplar::where('status_eksemplar', 'hilang')->count();

        // Data untuk grafik - Top 5 kategori buku terpopuler
        $topKategori = \App\Models\Kategori::withCount('buku')
            ->orderBy('buku_count', 'desc')
            ->take(5)
            ->get();

        $x['title'] = "Dashboard Perpustakaan";
        $x['totalAnggota'] = $totalAnggota;
        $x['totalGuru'] = $totalGuru;
        $x['totalSiswa'] = $totalSiswa;
        $x['totalBuku'] = $totalBuku;
        $x['peminjamanAktif'] = $peminjamanAktif;
        $x['bukuTerlambat'] = $bukuTerlambat;
        $x['totalAdmin'] = $totalAdmin;
        
        // Data denda
        $x['totalDendaBelumDibayar'] = $totalDendaBelumDibayar;
        $x['totalDendaSudahDibayar'] = $totalDendaSudahDibayar;
        $x['jumlahTransaksiBelumDibayar'] = $jumlahTransaksiBelumDibayar;
        
        // Data grafik
        $x['bulanLabels'] = json_encode($bulanLabels);
        $x['peminjamanPerBulan'] = json_encode($peminjamanPerBulan);
        $x['eksemplarTersedia'] = $eksemplarTersedia;
        $x['eksemplarDipinjam'] = $eksemplarDipinjam;
        $x['eksemplarRusak'] = $eksemplarRusak;
        $x['eksemplarHilang'] = $eksemplarHilang;
        $x['topKategori'] = $topKategori;
        
        // Role checking
        $x['isKepala'] = auth()->user()->role === 'kepala';
        $x['isPustakawan'] = auth()->user()->role === 'pustakawan';

        return view('livewire.home-component', $x)->layoutData($x);
    }
}
