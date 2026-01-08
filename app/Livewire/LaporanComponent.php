<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Eksemplar;
use App\Models\Kategori;
use Carbon\Carbon;

class LaporanComponent extends Component
{
    public $startDate;
    public $endDate;
    public $activeTab = 'peminjaman'; // Default tab

    public function mount()
    {
        // RBAC: Kepala & Pustakawan can access (for monitoring)
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            return redirect()->route('home')->with('error', 'Akses ditolak! Halaman ini hanya untuk Kepala Sekolah dan Pustakawan.');
        }

        // Default date range: 6 bulan terakhir
        $this->startDate = Carbon::now()->subMonths(6)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        // 1. LAPORAN PEMINJAMAN & PENGEMBALIAN
        $laporanPeminjaman = $this->getLaporanPeminjaman();

        // 2. STATISTIK KEANGGOTAAN
        $statistikAnggota = $this->getStatistikAnggota();

        // 3. MANAJEMEN INVENTARIS/KOLEKSI
        $inventarisKoleksi = $this->getInventarisKoleksi();

        // 4. ANALISIS KEBUTUHAN KOLEKSI
        $analisisKebutuhan = $this->getAnalisisKebutuhan();

        // DATA UNTUK CHART
        // Chart 1: Tren Peminjaman (Line Chart)
        $trendLabels = collect($laporanPeminjaman['trenPeminjaman'])->pluck('bulan')->toArray();
        $trendData = collect($laporanPeminjaman['trenPeminjaman'])->pluck('total')->toArray();

        // Chart 2: Top 10 Buku Terpopuler (Bar Chart)
        $bukuLabels = collect($laporanPeminjaman['bukuTerpopuler'])->pluck('judul')->map(function($judul) {
            return strlen($judul) > 30 ? substr($judul, 0, 30) . '...' : $judul;
        })->toArray();
        $bukuData = collect($laporanPeminjaman['bukuTerpopuler'])->pluck('total_pinjam')->toArray();

        // Chart 3: Status Eksemplar (Doughnut Chart)
        $statusEksemplarLabels = ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'];
        $statusEksemplarData = [
            $inventarisKoleksi['eksemplarTersedia'],
            $inventarisKoleksi['eksemplarDipinjam'],
            $inventarisKoleksi['eksemplarRusak'],
            $inventarisKoleksi['eksemplarHilang']
        ];

        // Chart 4: Kategori Buku (Pie Chart)
        $kategoriLabels = collect($inventarisKoleksi['koleksiPerKategori'])->pluck('nama_kategori')->toArray();
        $kategoriData = collect($inventarisKoleksi['koleksiPerKategori'])->pluck('jumlah_buku')->toArray();

        return view('livewire.laporan-modern', [
            'laporanPeminjaman' => $laporanPeminjaman,
            'statistikAnggota' => $statistikAnggota,
            'inventarisKoleksi' => $inventarisKoleksi,
            'analisisKebutuhan' => $analisisKebutuhan,
            // Chart data - pass raw arrays
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
            'bukuLabels' => $bukuLabels,
            'bukuData' => $bukuData,
            'statusEksemplarLabels' => $statusEksemplarLabels,
            'statusEksemplarData' => $statusEksemplarData,
            'kategoriLabels' => $kategoriLabels,
            'kategoriData' => $kategoriData
        ])->layoutData(['title' => 'Laporan Manajerial']);
    }

    /**
     * 1. LAPORAN PEMINJAMAN & PENGEMBALIAN
     * - Buku terpopuler (paling sering dipinjam)
     * - Tingkat keterlambatan
     * - Tren peminjaman per bulan
     */
    private function getLaporanPeminjaman()
    {
        // Buku Terpopuler (Top 10)        
        $bukuTerpopuler = DetailPeminjaman::select('eksemplar.id_buku', DB::raw('COUNT(*) as total_pinjam'))
            ->join('eksemplar', 'detail_peminjaman.id_eksemplar', '=', 'eksemplar.id_eksemplar')
            ->join('peminjaman', 'detail_peminjaman.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->whereBetween('peminjaman.tgl_pinjam', [$this->startDate, $this->endDate])
            ->groupBy('eksemplar.id_buku')
            ->orderByDesc('total_pinjam')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $buku = Buku::find($item->id_buku);
                return [
                    'judul' => $buku->judul ?? 'N/A',
                    'pengarang' => $buku->pengarang ?? 'N/A',
                    'penerbit' => $buku->penerbit ?? 'N/A',
                    'total_pinjam' => $item->total_pinjam
                ];
            });

        // Tingkat Keterlambatan
        $totalPeminjaman = Peminjaman::whereBetween('tgl_pinjam', [$this->startDate, $this->endDate])->count();
        $peminjamanTerlambat = Peminjaman::whereBetween('tgl_pinjam', [$this->startDate, $this->endDate])
            ->where('status_buku', 'kembali')
            ->whereHas('detailPeminjaman', function($q) {
                $q->whereRaw('peminjaman.tgl_jatuh_tempo < detail_peminjaman.tgl_kembali');
            })
            ->count();
        $persenTerlambat = $totalPeminjaman > 0 ? round(($peminjamanTerlambat / $totalPeminjaman) * 100, 2) : 0;

        // Tren Peminjaman (6 bulan terakhir)
        $trenPeminjaman = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $count = Peminjaman::whereYear('tgl_pinjam', $bulan->year)
                ->whereMonth('tgl_pinjam', $bulan->month)
                ->count();
            $trenPeminjaman[] = [
                'bulan' => $bulan->translatedFormat('M Y'),
                'total' => $count
            ];
        }

        return [
            'bukuTerpopuler' => $bukuTerpopuler,
            'totalPeminjaman' => $totalPeminjaman,
            'peminjamanTerlambat' => $peminjamanTerlambat,
            'persenTerlambat' => $persenTerlambat,
            'trenPeminjaman' => $trenPeminjaman
        ];
    }

    /**
     * 2. STATISTIK KEANGGOTAAN
     * - Total anggota (guru, siswa)
     * - Aktivitas keanggotaan (anggota aktif)
     * - Pendaftaran anggota baru
     */
    private function getStatistikAnggota()
    {
        $totalAnggota = Anggota::count();
        $totalGuru = Anggota::where('jenis_anggota', 'guru')->count();
        $totalSiswa = Anggota::where('jenis_anggota', 'siswa')->count();

        // Anggota Aktif (pernah pinjam dalam periode)
        $anggotaAktif = Peminjaman::whereBetween('tgl_pinjam', [$this->startDate, $this->endDate])
            ->distinct('id_anggota')
            ->count('id_anggota');

        // Pendaftaran Anggota Baru (dalam periode)
        $anggotaBaru = Anggota::whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        // Top 5 Anggota Paling Aktif (paling banyak pinjam)
        $topAnggota = Peminjaman::select('id_anggota', DB::raw('COUNT(*) as total_pinjam'))
            ->whereBetween('tgl_pinjam', [$this->startDate, $this->endDate])
            ->groupBy('id_anggota')
            ->orderByDesc('total_pinjam')
            ->limit(5)
            ->with('anggota')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->anggota->nama_anggota ?? 'N/A',
                    'jenis' => $item->anggota->jenis_anggota ?? 'N/A',
                    'total_pinjam' => $item->total_pinjam
                ];
            });

        return [
            'totalAnggota' => $totalAnggota,
            'totalGuru' => $totalGuru,
            'totalSiswa' => $totalSiswa,
            'anggotaAktif' => $anggotaAktif,
            'anggotaBaru' => $anggotaBaru,
            'topAnggota' => $topAnggota
        ];
    }

    /**
     * 3. MANAJEMEN INVENTARIS/KOLEKSI
     * - Total koleksi buku (metadata + eksemplar)
     * - Penambahan koleksi baru
     * - Buku rusak/hilang
     */
    private function getInventarisKoleksi()
    {
        $totalJudulBuku = Buku::count();
        $totalEksemplar = Eksemplar::count();

        // Penambahan Buku Baru (dalam periode)
        $bukuBaru = Buku::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $eksemplarBaru = Eksemplar::whereBetween('created_at', [$this->startDate, $this->endDate])->count();

        // Status Eksemplar
        $eksemplarTersedia = Eksemplar::where('status_eksemplar', 'tersedia')->count();
        $eksemplarDipinjam = Eksemplar::where('status_eksemplar', 'dipinjam')->count();
        $eksemplarRusak = Eksemplar::where('status_eksemplar', 'rusak')->count();
        $eksemplarHilang = Eksemplar::where('status_eksemplar', 'hilang')->count();

        // Persentase kondisi
        $persenTersedia = $totalEksemplar > 0 ? round(($eksemplarTersedia / $totalEksemplar) * 100, 2) : 0;
        $persenRusak = $totalEksemplar > 0 ? round(($eksemplarRusak / $totalEksemplar) * 100, 2) : 0;
        $persenHilang = $totalEksemplar > 0 ? round(($eksemplarHilang / $totalEksemplar) * 100, 2) : 0;

        // Koleksi per Kategori
        $koleksiPerKategori = Kategori::withCount('buku')
            ->orderByDesc('buku_count')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_kategori' => $item->nama,
                    'jumlah_buku' => $item->buku_count
                ];
            });

        $totalKategori = Kategori::count();

        // Distribusi Status untuk Chart
        $distribusiStatus = [
            ['status' => 'Tersedia', 'jumlah' => $eksemplarTersedia],
            ['status' => 'Dipinjam', 'jumlah' => $eksemplarDipinjam],
            ['status' => 'Rusak', 'jumlah' => $eksemplarRusak],
            ['status' => 'Hilang', 'jumlah' => $eksemplarHilang]
        ];

        return [
            'totalJudulBuku' => $totalJudulBuku,
            'totalEksemplar' => $totalEksemplar,
            'totalKategori' => $totalKategori,
            'bukuBaru' => $bukuBaru,
            'eksemplarBaru' => $eksemplarBaru,
            'eksemplarTersedia' => $eksemplarTersedia,
            'eksemplarDipinjam' => $eksemplarDipinjam,
            'eksemplarRusak' => $eksemplarRusak,
            'eksemplarHilang' => $eksemplarHilang,
            'persenTersedia' => $persenTersedia,
            'persenRusak' => $persenRusak,
            'persenHilang' => $persenHilang,
            'koleksiPerKategori' => $koleksiPerKategori,
            'distribusiStatus' => $distribusiStatus
        ];
    }

    /**
     * 4. ANALISIS KEBUTUHAN KOLEKSI
     * - Kategori dengan demand tinggi tapi koleksi sedikit
     * - Rekomendasi pembelian berdasarkan tren
     */
    private function getAnalisisKebutuhan()
    {
        // Kategori dengan rasio demand vs koleksi
        $analisisKategori = Kategori::select('kategori.*')
            ->withCount('buku')
            ->get()
            ->map(function ($kategori) {
                // Hitung jumlah peminjaman per kategori
                $totalPinjam = DetailPeminjaman::join('eksemplar', 'detail_peminjaman.id_eksemplar', '=', 'eksemplar.id_eksemplar')
                    ->join('buku', 'eksemplar.id_buku', '=', 'buku.id_buku')
                    ->join('peminjaman', 'detail_peminjaman.id_peminjaman', '=', 'peminjaman.id_peminjaman')
                    ->where('buku.kategori_id', $kategori->id_kategori)
                    ->whereBetween('peminjaman.tgl_pinjam', [$this->startDate, $this->endDate])
                    ->count();

                $avgPinjamPerBuku = $kategori->buku_count > 0 ? round($totalPinjam / $kategori->buku_count, 2) : 0;

                return [
                    'nama_kategori' => $kategori->nama,
                    'jumlah_koleksi' => $kategori->buku_count,
                    'total_peminjaman' => $totalPinjam,
                    'avg_pinjam_per_buku' => $avgPinjamPerBuku,
                    'demand_level' => $avgPinjamPerBuku >= 5 ? 'Tinggi' : ($avgPinjamPerBuku >= 2 ? 'Sedang' : 'Rendah')
                ];
            })
            ->sortByDesc('avg_pinjam_per_buku');

        // Rekomendasi Pembelian (kategori dengan demand tinggi tapi koleksi sedikit)
        $rekomendasi = $analisisKategori->filter(function ($item) {
            return $item['demand_level'] == 'Tinggi' && $item['jumlah_koleksi'] < 10;
        })->values();

        return [
            'analisisKategori' => $analisisKategori,
            'rekomendasi' => $rekomendasi
        ];
    }

    public function updateDateRange()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate'
        ], [
            'startDate.required' => 'Tanggal mulai harus diisi!',
            'endDate.required' => 'Tanggal akhir harus diisi!',
            'endDate.after_or_equal' => 'Tanggal akhir harus setelah tanggal mulai!'
        ]);

        session()->flash('success', 'Filter tanggal berhasil diupdate!');
    }
}
