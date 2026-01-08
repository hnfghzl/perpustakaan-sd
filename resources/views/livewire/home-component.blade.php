{{-- Dashboard Container --}}
<div style="padding: 0;">
    {{-- Header Section --}}
    <div class="mb-4">
        <h1 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Dashboard Perpustakaan</h1>
        <p style="font-size: 1.125rem; color: #6b7280;">Selamat datang di PERPUS SD MUHAMMADIYAH KARANG WARU</p>
    </div>

    @if($isKepala)
        {{-- Dashboard Modern untuk Kepala Sekolah --}}
        @include('components.layouts.dashboard-kepala-modern', [
            'totalAnggota' => $totalAnggota,
            'totalGuru' => $totalGuru,
            'totalSiswa' => $totalSiswa,
            'totalBuku' => $totalBuku,
            'peminjamanAktif' => $peminjamanAktif,
            'bukuTerlambat' => $bukuTerlambat,
            'bulanLabels' => $bulanLabels,
            'peminjamanPerBulan' => $peminjamanPerBulan,
            'eksemplarTersedia' => $eksemplarTersedia,
            'eksemplarDipinjam' => $eksemplarDipinjam,
            'eksemplarRusak' => $eksemplarRusak,
            'eksemplarHilang' => $eksemplarHilang,
            'topKategori' => $topKategori,
            'totalDendaBelumDibayar' => $totalDendaBelumDibayar,
            'totalDendaSudahDibayar' => $totalDendaSudahDibayar,
            'jumlahTransaksiBelumDibayar' => $jumlahTransaksiBelumDibayar
        ])
    @else
        {{-- Dashboard Modern untuk Pustakawan --}}
        @include('components.layouts.dashboard-pustakawan-modern', [
            'totalAnggota' => $totalAnggota,
            'totalBuku' => $totalBuku,
            'peminjamanAktif' => $peminjamanAktif,
            'bukuTerlambat' => $bukuTerlambat,
            'totalDendaBelumDibayar' => $totalDendaBelumDibayar,
            'totalDendaSudahDibayar' => $totalDendaSudahDibayar,
            'jumlahTransaksiBelumDibayar' => $jumlahTransaksiBelumDibayar
        ])
    @endif
</div>
