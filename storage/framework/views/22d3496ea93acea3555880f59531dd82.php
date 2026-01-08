
<style>
    .metric-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    .metric-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .metric-value {
        font-size: 32px;
        font-weight: 700;
        margin: 8px 0;
        line-height: 1;
    }
    .metric-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .metric-sublabel {
        color: #9ca3af;
        font-size: 12px;
    }
    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }
    .chart-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
    }
    .table-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
    }
    .rank-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
    .progress-bar-custom {
        height: 8px;
        border-radius: 10px;
        background: #e5e7eb;
        overflow: hidden;
        flex: 1;
    }
    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }
</style>

<div>
    
    <div class="row">
        
        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                    <i data-feather="users" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                </div>
                <div class="metric-label">Total Anggota</div>
                <div class="metric-value" style="color: #3b82f6;"><?php echo e(number_format($totalAnggota)); ?></div>
                <div class="metric-sublabel">Guru: <?php echo e($totalGuru ?? 0); ?> | Siswa: <?php echo e($totalSiswa ?? 0); ?></div>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <i data-feather="book-open" style="width: 24px; height: 24px; color: #10b981;"></i>
                </div>
                <div class="metric-label">Total Buku</div>
                <div class="metric-value" style="color: #10b981;"><?php echo e(number_format($totalBuku)); ?></div>
                <div class="metric-sublabel">Judul Buku</div>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    <i data-feather="clock" style="width: 24px; height: 24px; color: #f59e0b;"></i>
                </div>
                <div class="metric-label">Peminjaman Aktif</div>
                <div class="metric-value" style="color: #f59e0b;"><?php echo e(number_format($peminjamanAktif)); ?></div>
                <div class="metric-sublabel">Buku Dipinjam</div>
            </div>
        </div>

        
        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                    <i data-feather="alert-triangle" style="width: 24px; height: 24px; color: #ef4444;"></i>
                </div>
                <div class="metric-label">Buku Terlambat</div>
                <div class="metric-value" style="color: #ef4444;"><?php echo e(number_format($bukuTerlambat)); ?></div>
                <div class="metric-sublabel">Transaksi</div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        <div class="col-lg-8">
            <div class="chart-container">
                <div class="chart-title">
                    <i data-feather="trending-up" style="width: 20px; height: 20px; color: #3b82f6; margin-right: 8px;"></i>
                    Statistik Peminjaman (6 Bulan Terakhir)
                </div>
                <div class="chart-subtitle">Tren peminjaman buku per bulan</div>
                <div style="position: relative; height: 320px;">
                    <canvas id="peminjamanChart"></canvas>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i data-feather="pie-chart" style="width: 20px; height: 20px; color: #10b981; margin-right: 8px;"></i>
                    Status Eksemplar
                </div>
                <div class="chart-subtitle">Distribusi kondisi buku</div>
                <div style="position: relative; height: 320px; display: flex; align-items: center; justify-content: center;">
                    <canvas id="statusEksemplarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        <div class="col-lg-4">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                    <i data-feather="dollar-sign" style="width: 24px; height: 24px; color: #ef4444;"></i>
                </div>
                <div class="metric-label">Denda Belum Dibayar</div>
                <div class="metric-value" style="color: #ef4444; font-size: 24px;">
                    Rp <?php echo e(number_format($totalDendaBelumDibayar, 0, ',', '.')); ?>

                </div>
                <div class="metric-sublabel"><?php echo e($jumlahTransaksiBelumDibayar ?? 0); ?> transaksi belum lunas</div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <i data-feather="check-circle" style="width: 24px; height: 24px; color: #10b981;"></i>
                </div>
                <div class="metric-label">Pendapatan Denda</div>
                <div class="metric-value" style="color: #10b981; font-size: 24px;">
                    Rp <?php echo e(number_format($totalDendaSudahDibayar, 0, ',', '.')); ?>

                </div>
                <div class="metric-sublabel">Total terbayar</div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="metric-card">
                <div class="metric-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                    <i data-feather="credit-card" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                </div>
                <div class="metric-label">Total Denda</div>
                <div class="metric-value" style="color: #3b82f6; font-size: 24px;">
                    Rp <?php echo e(number_format($totalDendaBelumDibayar + $totalDendaSudahDibayar, 0, ',', '.')); ?>

                </div>
                <div class="metric-sublabel">Keseluruhan</div>
            </div>
        </div>
    </div>

    
    <div class="table-container">
        <div class="chart-title">
            <i data-feather="award" style="width: 20px; height: 20px; color: #f59e0b; margin-right: 8px;"></i>
            Top 5 Kategori Buku Terpopuler
        </div>
        <div class="chart-subtitle">Berdasarkan jumlah judul buku</div>
        
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 16px; font-weight: 600; color: #374151; border: none;">
                            <i data-feather="hash" style="width: 16px; height: 16px;"></i> Ranking
                        </th>
                        <th style="padding: 16px; font-weight: 600; color: #374151; border: none;">
                            <i data-feather="tag" style="width: 16px; height: 16px;"></i> Kategori
                        </th>
                        <th style="padding: 16px; font-weight: 600; color: #374151; border: none;">
                            <i data-feather="book" style="width: 16px; height: 16px;"></i> Jumlah Buku
                        </th>
                        <th style="padding: 16px; font-weight: 600; color: #374151; border: none;">
                            <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i> Progress
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $maxBuku = $topKategori->max('buku_count') ?? 1; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 16px; vertical-align: middle;">
                            <span class="rank-badge" style="
                                <?php echo e($index === 0 ? 'background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #f59e0b;' : 
                                   ($index === 1 ? 'background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); color: #6b7280;' : 
                                   ($index === 2 ? 'background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); color: #ea580c;' : 
                                   'background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #3b82f6;'))); ?>

                            ">
                                <?php echo e($index + 1); ?>

                            </span>
                        </td>
                        <td style="padding: 16px; vertical-align: middle;">
                            <span style="font-weight: 600; color: #111827; font-size: 14px;"><?php echo e($kategori->nama); ?></span>
                        </td>
                        <td style="padding: 16px; vertical-align: middle;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #3b82f6; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 13px;">
                                <i data-feather="book-open" style="width: 14px; height: 14px;"></i>
                                <?php echo e($kategori->buku_count); ?> judul
                            </span>
                        </td>
                        <td style="padding: 16px; vertical-align: middle;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <?php $percentage = ($kategori->buku_count / $maxBuku) * 100; ?>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="
                                        width: <?php echo e($percentage); ?>%; 
                                        background: <?php echo e($index === 0 ? 'linear-gradient(90deg, #f59e0b 0%, #d97706 100%)' : 
                                                       ($index === 1 ? 'linear-gradient(90deg, #6b7280 0%, #4b5563 100%)' : 
                                                       ($index === 2 ? 'linear-gradient(90deg, #ea580c 0%, #c2410c 100%)' : 
                                                       'linear-gradient(90deg, #3b82f6 0%, #2563eb 100%)'))); ?>;
                                    "></div>
                                </div>
                                <span style="font-weight: 600; color: #6b7280; font-size: 13px; min-width: 50px; text-align: right;">
                                    <?php echo e(number_format($percentage, 1)); ?>%
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tunggu sebentar untuk memastikan DOM siap
    setTimeout(initCharts, 300);
});

function initCharts() {
    console.log('Initializing charts...');
    
    // Peminjaman Chart (Line Chart)
    const peminjamanCtx = document.getElementById('peminjamanChart');
    if (peminjamanCtx) {
        const bulanLabels = <?php echo $bulanLabels; ?>;
        const peminjamanData = <?php echo $peminjamanPerBulan; ?>;
        
        console.log('Bulan Labels:', bulanLabels);
        console.log('Peminjaman Data:', peminjamanData);
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js tidak ter-load!');
            return;
        }
        
        new Chart(peminjamanCtx, {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: peminjamanData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 },
                            color: '#6b7280'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 },
                            color: '#6b7280'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }

    // Status Eksemplar Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusEksemplarChart');
    if (statusCtx) {
        console.log('Creating Status Eksemplar chart...');
        console.log('Tersedia:', <?php echo e($eksemplarTersedia); ?>);
        console.log('Dipinjam:', <?php echo e($eksemplarDipinjam); ?>);
        console.log('Rusak:', <?php echo e($eksemplarRusak); ?>);
        console.log('Hilang:', <?php echo e($eksemplarHilang); ?>);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'],
                datasets: [{
                    data: [
                        <?php echo e($eksemplarTersedia); ?>,
                        <?php echo e($eksemplarDipinjam); ?>,
                        <?php echo e($eksemplarRusak); ?>,
                        <?php echo e($eksemplarHilang); ?>

                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green
                        'rgba(245, 158, 11, 0.8)',  // Yellow
                        'rgba(239, 68, 68, 0.8)',   // Red
                        'rgba(107, 114, 128, 0.8)'  // Gray
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(107, 114, 128)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            font: { size: 13 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#374151'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Refresh Feather Icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}
</script>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/components/layouts/dashboard-kepala-modern.blade.php ENDPATH**/ ?>