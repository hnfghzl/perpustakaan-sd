<style>
    .stat-card-modern {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        height: 100%;
    }
    .stat-card-modern:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transform: translateY(-4px);
    }
    .stat-icon-modern {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .stat-number {
        font-size: 36px;
        font-weight: 700;
        margin: 8px 0;
        line-height: 1;
    }
    .stat-label-modern {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 12px;
    }
    .stat-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .stat-link:hover {
        color: #374151;
        transform: translateX(4px);
    }
</style>

<div style="background: transparent;">
    
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 32px; border-radius: 16px; box-shadow: 0 10px 40px rgba(59, 130, 246, 0.2); margin-bottom: 24px;">
        <h1 style="font-size: 32px; font-weight: 800; color: white; margin-bottom: 8px; display: flex; align-items: center; gap: 12px;">
            <i data-feather="home" style="width: 36px; height: 36px;"></i>
            Dashboard Perpustakaan
        </h1>
        <p style="font-size: 16px; color: rgba(255,255,255,0.9); margin: 0;">
            Ringkasan data dan statistik perpustakaan SD Muhammadiyah Karangwaru
        </p>
    </div>

    
    <div class="row mb-4">
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                    <i data-feather="users" style="width: 32px; height: 32px; color: #6b7280;"></i>
                </div>
                <div class="stat-label-modern">Total Anggota</div>
                <div class="stat-number" style="color: #111827;"><?php echo e($totalAnggota ?? 0); ?></div>
                <a href="<?php echo e(route('anggota')); ?>" class="stat-link">
                    Lihat Detail <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                    <i data-feather="book" style="width: 32px; height: 32px; color: #6b7280;"></i>
                </div>
                <div class="stat-label-modern">Total Buku</div>
                <div class="stat-number" style="color: #111827;"><?php echo e($totalBuku ?? 0); ?></div>
                <a href="<?php echo e(route('buku')); ?>" class="stat-link">
                    Lihat Detail <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                    <i data-feather="book-open" style="width: 32px; height: 32px; color: #3b82f6;"></i>
                </div>
                <div class="stat-label-modern">Peminjaman Aktif</div>
                <div class="stat-number" style="color: #3b82f6;"><?php echo e($peminjamanAktif ?? 0); ?></div>
                <a href="<?php echo e(route('peminjaman')); ?>" class="stat-link">
                    Lihat Detail <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                    <i data-feather="alert-circle" style="width: 32px; height: 32px; color: #ef4444;"></i>
                </div>
                <div class="stat-label-modern">Buku Terlambat</div>
                <div class="stat-number" style="color: #ef4444;"><?php echo e($bukuTerlambat ?? 0); ?></div>
                <a href="<?php echo e(route('peminjaman')); ?>" class="stat-link">
                    Lihat Detail <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h3 style="font-size: 18px; font-weight: 600; color: #111827; display: flex; align-items: center; gap: 8px;">
                <i data-feather="dollar-sign" style="width: 20px; height: 20px; color: #f59e0b;"></i>
                Statistik Denda
            </h3>
        </div>

        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    <i data-feather="alert-triangle" style="width: 32px; height: 32px; color: #f59e0b;"></i>
                </div>
                <div class="stat-label-modern">Denda Belum Dibayar</div>
                <div class="stat-number" style="color: #f59e0b; font-size: 28px;">Rp <?php echo e(number_format($totalDendaBelumDibayar ?? 0, 0, ',', '.')); ?></div>
                <div style="color: #6b7280; font-size: 13px; margin-top: 8px;">
                    <i data-feather="file-text" style="width: 12px; height: 12px;"></i>
                    <?php echo e($jumlahTransaksiBelumDibayar ?? 0); ?> transaksi
                </div>
                <a href="<?php echo e(route('peminjaman')); ?>" class="stat-link" style="margin-top: 8px;">
                    Lihat Detail <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <i data-feather="check-circle" style="width: 32px; height: 32px; color: #10b981;"></i>
                </div>
                <div class="stat-label-modern">Pendapatan Denda (Lunas)</div>
                <div class="stat-number" style="color: #10b981; font-size: 28px;">Rp <?php echo e(number_format($totalDendaSudahDibayar ?? 0, 0, ',', '.')); ?></div>
                <div style="color: #6b7280; font-size: 13px; margin-top: 8px;">
                    <i data-feather="trending-up" style="width: 12px; height: 12px;"></i>
                    Total yang sudah dibayar
                </div>
                <a href="<?php echo e(route('peminjaman')); ?>" class="stat-link" style="margin-top: 8px;">
                    Lihat Riwayat <i data-feather="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stat-card-modern">
                <div class="stat-icon-modern" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                    <i data-feather="pie-chart" style="width: 32px; height: 32px; color: #6366f1;"></i>
                </div>
                <div class="stat-label-modern">Total Denda Keseluruhan</div>
                <div class="stat-number" style="color: #6366f1; font-size: 28px;">Rp <?php echo e(number_format(($totalDendaBelumDibayar ?? 0) + ($totalDendaSudahDibayar ?? 0), 0, ',', '.')); ?></div>
                <div style="color: #6b7280; font-size: 13px; margin-top: 8px;">
                    <i data-feather="info" style="width: 12px; height: 12px;"></i>
                    Lunas + Belum Dibayar
                </div>
            </div>
        </div>
    </div>

    
    <div class="stat-card-modern mb-4">
        <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
            <i data-feather="zap" style="width: 20px; height: 20px; color: #3b82f6; margin-right: 8px;"></i>
            Aksi Cepat
        </h3>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="<?php echo e(route('peminjaman')); ?>" class="btn btn-block" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 12px; padding: 16px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;">
                    <i data-feather="plus-circle" style="width: 20px; height: 20px;"></i>
                    Peminjaman Baru
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="<?php echo e(route('peminjaman')); ?>" class="btn btn-block" style="background: #f3f4f6; color: #374151; border: none; border-radius: 12px; padding: 16px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;">
                    <i data-feather="rotate-ccw" style="width: 20px; height: 20px;"></i>
                    Pengembalian Buku
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="<?php echo e(route('anggota')); ?>" class="btn btn-block" style="background: #f3f4f6; color: #374151; border: none; border-radius: 12px; padding: 16px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;">
                    <i data-feather="user-plus" style="width: 20px; height: 20px;"></i>
                    Tambah Anggota
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="<?php echo e(route('buku')); ?>" class="btn btn-block" style="background: #f3f4f6; color: #374151; border: none; border-radius: 12px; padding: 16px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;">
                    <i data-feather="book" style="width: 20px; height: 20px;"></i>
                    Tambah Buku
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Refresh Feather Icons
if (typeof feather !== 'undefined') {
    setTimeout(() => {
        feather.replace();
    }, 100);
}

// Hover effects for quick action buttons
document.querySelectorAll('a.btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        if (this.style.background.includes('3b82f6')) {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(59, 130, 246, 0.4)';
        } else {
            this.style.background = '#e5e7eb';
            this.style.transform = 'translateY(-2px)';
        }
    });
    
    btn.addEventListener('mouseleave', function() {
        if (this.style.boxShadow.includes('rgba(59')) {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        } else {
            this.style.background = '#f3f4f6';
            this.style.transform = 'translateY(0)';
        }
    });
});
</script>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/components/layouts/dashboard-pustakawan-modern.blade.php ENDPATH**/ ?>