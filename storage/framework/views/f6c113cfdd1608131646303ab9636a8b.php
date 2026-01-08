
<div style="padding: 0;">
    
    <div class="mb-4">
        <h1 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Dashboard Perpustakaan</h1>
        <p style="font-size: 1.125rem; color: #6b7280;">Selamat datang di PERPUS SD MUHAMMADIYAH KARANG WARU</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isKepala): ?>
        
        <?php echo $__env->make('components.layouts.dashboard-kepala-modern', [
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
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        
        <?php echo $__env->make('components.layouts.dashboard-pustakawan-modern', [
            'totalAnggota' => $totalAnggota,
            'totalBuku' => $totalBuku,
            'peminjamanAktif' => $peminjamanAktif,
            'bukuTerlambat' => $bukuTerlambat,
            'totalDendaBelumDibayar' => $totalDendaBelumDibayar,
            'totalDendaSudahDibayar' => $totalDendaSudahDibayar,
            'jumlahTransaksiBelumDibayar' => $jumlahTransaksiBelumDibayar
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/home-component.blade.php ENDPATH**/ ?>