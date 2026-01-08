{{-- Laporan Manajerial Modern --}}
<style>
    /* Remove all dark borders/shadows */
    * {
        outline: none !important;
    }
    
    .report-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .report-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        margin-bottom: 15px;
        height: 100%;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin: 6px 0;
        line-height: 1;
    }
    .stat-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 4px;
    }
    .tab-modern {
        background: white;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        margin-bottom: 20px;
        border: none !important;
    }
    .nav-pills .nav-link {
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s;
        color: #6b7280;
        border: none !important;
    }
    .nav-pills .nav-link:hover {
        background: #f3f4f6;
        color: #111827;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    /* Remove Bootstrap default borders */
    .tab-content {
        border: none !important;
        background: transparent !important;
    }
    .tab-pane {
        border: none !important;
        background: transparent !important;
    }
    .row {
        border: none !important;
    }
    .col-lg-4, .col-lg-3 {
        border: none !important;
    }
    
    /* Ensure no dark backgrounds */
    .container-fluid, .container {
        background: transparent !important;
    }
</style>

<div style="background: transparent;">
    {{-- Header --}}
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 32px; border-radius: 16px; box-shadow: 0 10px 40px rgba(59, 130, 246, 0.2); margin-bottom: 24px;">
        <h1 style="font-size: 32px; font-weight: 800; color: white; margin-bottom: 8px; display: flex; align-items: center; gap: 12px;">
            <i data-feather="bar-chart-2" style="width: 36px; height: 36px;"></i>
            Laporan Manajerial
        </h1>
        <p style="font-size: 16px; color: rgba(255,255,255,0.9); margin: 0;">
            Data analisis dan pelaporan untuk monitoring perpustakaan
        </p>
    </div>

    {{-- Date Filter --}}
    <div class="report-card">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label class="form-label" style="color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Tanggal Mulai
                </label>
                <input type="date" wire:model="startDate" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px; font-size: 14px;">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Tanggal Akhir
                </label>
                <input type="date" wire:model="endDate" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px; font-size: 14px;">
            </div>
            <div class="col-md-4">
                <button wire:click="updateDateRange" class="btn btn-block" style="border-radius: 10px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; color: white; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                    <i data-feather="filter" style="width: 18px; height: 18px;"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tab-modern">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item mr-2">
                <a class="nav-link active" id="peminjaman-tab" data-toggle="pill" href="#peminjaman" role="tab">
                    <i data-feather="book-open" style="width: 18px; height: 18px; margin-right: 6px;"></i>
                    Peminjaman
                </a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" id="anggota-tab" data-toggle="pill" href="#anggota" role="tab">
                    <i data-feather="users" style="width: 18px; height: 18px; margin-right: 6px;"></i>
                    Keanggotaan
                </a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" id="inventaris-tab" data-toggle="pill" href="#inventaris" role="tab">
                    <i data-feather="package" style="width: 18px; height: 18px; margin-right: 6px;"></i>
                    Inventaris
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="analisis-tab" data-toggle="pill" href="#analisis" role="tab">
                    <i data-feather="trending-up" style="width: 18px; height: 18px; margin-right: 6px;"></i>
                    Analisis
                </a>
            </li>
        </ul>
    </div>

    {{-- Tab Content --}}
    <div class="tab-content">
        {{-- TAB 1: PEMINJAMAN --}}
        <div class="tab-pane fade show active" id="peminjaman" role="tabpanel">
            {{-- Stats Cards --}}
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                            <i data-feather="book-open" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                        </div>
                        <div class="stat-label">Total Peminjaman</div>
                        <div class="stat-value" style="color: #3b82f6;">{{ $laporanPeminjaman['totalPeminjaman'] ?? 0 }}</div>
                        <p style="color: #9ca3af; font-size: 12px; margin: 0;">Transaksi dalam periode</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                            <i data-feather="alert-triangle" style="width: 24px; height: 24px; color: #ef4444;"></i>
                        </div>
                        <div class="stat-label">Peminjaman Terlambat</div>
                        <div class="stat-value" style="color: #ef4444;">{{ $laporanPeminjaman['peminjamanTerlambat'] ?? 0 }}</div>
                        <p style="color: #9ca3af; font-size: 12px; margin: 0;">{{ $laporanPeminjaman['persenTerlambat'] ?? 0 }}% dari total</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i data-feather="check-circle" style="width: 24px; height: 24px; color: #10b981;"></i>
                        </div>
                        <div class="stat-label">Tingkat Ketepatan</div>
                        <div class="stat-value" style="color: #10b981;">{{ 100 - ($laporanPeminjaman['persenTerlambat'] ?? 0) }}%</div>
                        <p style="color: #9ca3af; font-size: 12px; margin: 0;">Pengembalian tepat waktu</p>
                    </div>
                </div>
            </div>

            {{-- Chart Tren Peminjaman --}}
            <div class="report-card">
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
                    <i data-feather="trending-up" style="width: 20px; height: 20px; color: #3b82f6; margin-right: 8px;"></i>
                    Tren Peminjaman
                </h3>
                <div style="position: relative; height: 320px;">
                    <canvas id="trenPeminjamanChart"></canvas>
                </div>
            </div>

            {{-- Top Borrowers --}}
            <div class="report-card">
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
                    <i data-feather="award" style="width: 20px; height: 20px; color: #f59e0b; margin-right: 8px;"></i>
                    Top 10 Peminjam Aktif
                </h3>
                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead style="background: #f9fafb;">
                            <tr>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Ranking</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Nama</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Jenis</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Total Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($statistikAnggota['topAnggota'] ?? []) as $index => $peminjam)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; font-weight: 700; font-size: 14px;
                                        {{ $index === 0 ? 'background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #f59e0b;' : 
                                           ($index === 1 ? 'background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); color: #6b7280;' : 
                                           ($index === 2 ? 'background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); color: #ea580c;' : 
                                           'background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #3b82f6;')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 12px; font-weight: 600; color: #111827;">{{ $peminjam['nama'] ?? 'N/A' }}</td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
                                        {{ ($peminjam['jenis'] ?? '') === 'guru' ? 'background: #dbeafe; color: #3b82f6;' : 'background: #d1fae5; color: #10b981;' }}">
                                        {{ ucfirst($peminjam['jenis'] ?? 'N/A') }}
                                    </span>
                                </td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; background: #f3f4f6; color: #374151; font-weight: 600; font-size: 13px;">
                                        <i data-feather="book" style="width: 14px; height: 14px;"></i>
                                        {{ $peminjam['total_pinjam'] ?? 0 }} kali
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #9ca3af;">Belum ada data peminjam aktif dalam periode ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 2: KEANGGOTAAN --}}
        <div class="tab-pane fade" id="anggota" role="tabpanel">
            <div class="row">
                <div class="col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                            <i data-feather="users" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                        </div>
                        <div class="stat-label">Total Anggota</div>
                        <div class="stat-value" style="color: #3b82f6;">{{ $statistikAnggota['totalAnggota'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <i data-feather="briefcase" style="width: 24px; height: 24px; color: #f59e0b;"></i>
                        </div>
                        <div class="stat-label">Guru</div>
                        <div class="stat-value" style="color: #f59e0b;">{{ $statistikAnggota['totalGuru'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i data-feather="user" style="width: 24px; height: 24px; color: #10b981;"></i>
                        </div>
                        <div class="stat-label">Siswa</div>
                        <div class="stat-value" style="color: #10b981;">{{ $statistikAnggota['totalSiswa'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);">
                            <i data-feather="activity" style="width: 24px; height: 24px; color: #ec4899;"></i>
                        </div>
                        <div class="stat-label">Anggota Aktif</div>
                        <div class="stat-value" style="color: #ec4899;">{{ $statistikAnggota['anggotaAktif'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="report-card mt-4">
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
                    <i data-feather="pie-chart" style="width: 20px; height: 20px; color: #3b82f6; margin-right: 8px;"></i>
                    Distribusi Keanggotaan
                </h3>
                <div style="position: relative; height: 320px;">
                    <canvas id="distribusiAnggotaChart"></canvas>
                </div>
            </div>
        </div>

        {{-- TAB 3: INVENTARIS --}}
        <div class="tab-pane fade" id="inventaris" role="tabpanel">
            <div class="row">
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                            <i data-feather="book" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                        </div>
                        <div class="stat-label">Total Judul Buku</div>
                        <div class="stat-value" style="color: #3b82f6;">{{ $inventarisKoleksi['totalJudulBuku'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i data-feather="layers" style="width: 24px; height: 24px; color: #10b981;"></i>
                        </div>
                        <div class="stat-label">Total Eksemplar</div>
                        <div class="stat-value" style="color: #10b981;">{{ $inventarisKoleksi['totalEksemplar'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <i data-feather="tag" style="width: 24px; height: 24px; color: #f59e0b;"></i>
                        </div>
                        <div class="stat-label">Kategori</div>
                        <div class="stat-value" style="color: #f59e0b;">{{ $inventarisKoleksi['totalKategori'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="report-card mt-4">
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
                    <i data-feather="bar-chart" style="width: 20px; height: 20px; color: #3b82f6; margin-right: 8px;"></i>
                    Status Eksemplar
                </h3>
                <div style="position: relative; height: 320px;">
                    <canvas id="statusEksemplarChart"></canvas>
                </div>
            </div>
        </div>

        {{-- TAB 4: ANALISIS --}}
        <div class="tab-pane fade" id="analisis" role="tabpanel">
            <div class="report-card">
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">
                    <i data-feather="star" style="width: 20px; height: 20px; color: #f59e0b; margin-right: 8px;"></i>
                    Top 10 Buku Terpopuler
                </h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #f9fafb;">
                            <tr>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Rank</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Judul</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Pengarang</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Penerbit</th>
                                <th style="border: none; padding: 12px; font-weight: 600; color: #374151;">Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($laporanPeminjaman['bukuTerpopuler'] ?? []) as $index => $buku)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; font-weight: 700; font-size: 14px;
                                        {{ $index < 3 ? 'background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #f59e0b;' : 
                                           'background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #3b82f6;' }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 12px; font-weight: 600; color: #111827;">{{ $buku['judul'] ?? 'N/A' }}</td>
                                <td style="padding: 12px; color: #6b7280;">{{ $buku['pengarang'] ?? 'N/A' }}</td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #f3f4f6; color: #374151;">
                                        {{ $buku['penerbit'] ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #3b82f6; font-weight: 600; font-size: 13px;">
                                        <i data-feather="trending-up" style="width: 14px; height: 14px;"></i>
                                        {{ $buku['total_pinjam'] ?? 0 }}x
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #9ca3af;">Belum ada data buku terpopuler</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initLaporanCharts, 300);
});

function initLaporanCharts() {
    console.log('Initializing laporan charts...');
    
    if (typeof Chart === 'undefined') {
        console.error('Chart.js tidak ter-load!');
        return;
    }

    // Chart 1: Tren Peminjaman
    const trenCtx = document.getElementById('trenPeminjamanChart');
    if (trenCtx) {
        const trenData = @json($laporanPeminjaman['trenPeminjaman'] ?? []);
        const labels = trenData.map(item => item.bulan);
        const values = trenData.map(item => item.total);
        
        new Chart(trenCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: values,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Chart 2: Distribusi Anggota
    const anggotaCtx = document.getElementById('distribusiAnggotaChart');
    if (anggotaCtx) {
        new Chart(anggotaCtx, {
            type: 'pie',
            data: {
                labels: ['Guru', 'Siswa'],
                datasets: [{
                    data: [
                        {{ $statistikAnggota['totalGuru'] ?? 0 }},
                        {{ $statistikAnggota['totalSiswa'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(16, 185, 129, 0.8)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Chart 3: Status Eksemplar
    const statusCtx = document.getElementById('statusEksemplarChart');
    if (statusCtx) {
        const statusData = @json($inventarisKoleksi['distribusiStatus'] ?? []);
        
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: statusData.map(item => item.status),
                datasets: [{
                    label: 'Jumlah',
                    data: statusData.map(item => item.jumlah),
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(107, 114, 128, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
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
