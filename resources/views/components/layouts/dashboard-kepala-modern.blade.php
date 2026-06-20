{{-- Dashboard Modern untuk Kepala Sekolah --}}

{{-- Stat Cards Row 1 --}}
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #4e73df !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Total Anggota</div>
                        <div class="h4 font-weight-bold text-dark mb-0">{{ $totalAnggota }}</div>
                        <small class="text-muted">Guru: {{ $totalGuru }} | Siswa: {{ $totalSiswa }}</small>
                    </div>
                    <div style="font-size:2rem; color:#4e73df;"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1cc88a !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Total Buku</div>
                        <div class="h4 font-weight-bold text-dark mb-0">{{ $totalBuku }}</div>
                        <small class="text-muted">Koleksi perpustakaan</small>
                    </div>
                    <div style="font-size:2rem; color:#1cc88a;"><i class="fas fa-book"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #36b9cc !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Peminjaman Aktif</div>
                        <div class="h4 font-weight-bold text-dark mb-0">{{ $peminjamanAktif }}</div>
                        <small class="text-muted">Sedang dipinjam</small>
                    </div>
                    <div style="font-size:2rem; color:#36b9cc;"><i class="fas fa-book-open"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #e74a3b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Buku Terlambat</div>
                        <div class="h4 font-weight-bold text-dark mb-0">{{ $bukuTerlambat }}</div>
                        <small class="text-muted">Melewati jatuh tempo</small>
                    </div>
                    <div style="font-size:2rem; color:#e74a3b;"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stat Cards Row 2 - Denda --}}
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #f6c23e !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Denda Belum Dibayar</div>
                        <div class="h5 font-weight-bold text-dark mb-0">Rp {{ number_format($totalDendaBelumDibayar, 0, ',', '.') }}</div>
                        <small class="text-muted">{{ $jumlahTransaksiBelumDibayar }} transaksi</small>
                    </div>
                    <div style="font-size:2rem; color:#f6c23e;"><i class="fas fa-money-bill-wave"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1cc88a !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Pendapatan Denda</div>
                        <div class="h5 font-weight-bold text-dark mb-0">Rp {{ number_format($totalDendaSudahDibayar, 0, ',', '.') }}</div>
                        <small class="text-muted">Sudah dibayar</small>
                    </div>
                    <div style="font-size:2rem; color:#1cc88a;"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #858796 !important;">
            <div class="card-body">
                <div class="text-uppercase text-muted font-weight-bold mb-2" style="font-size:0.75rem;">Status Eksemplar</div>
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-circle text-success"></i> Tersedia: <strong>{{ $eksemplarTersedia }}</strong></span>
                    <span><i class="fas fa-circle text-primary"></i> Dipinjam: <strong>{{ $eksemplarDipinjam }}</strong></span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span><i class="fas fa-circle text-warning"></i> Rusak: <strong>{{ $eksemplarRusak }}</strong></span>
                    <span><i class="fas fa-circle text-danger"></i> Hilang: <strong>{{ $eksemplarHilang }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik --}}
<div class="row mb-4">
    {{-- Grafik Peminjaman Per Bulan --}}
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peminjaman 6 Bulan Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height:280px;">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Donut Eksemplar --}}
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Eksemplar Buku</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-2 pb-2" style="height:220px; position:relative;">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-3 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Tersedia</span>
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Dipinjam</span>
                    <span class="mr-2"><i class="fas fa-circle text-warning"></i> Rusak</span>
                    <span><i class="fas fa-circle text-danger"></i> Hilang</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top 5 Kategori Buku --}}
@if($topKategori && $topKategori->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top 5 Kategori Buku Terpopuler</h6>
            </div>
            <div class="card-body">
                @foreach($topKategori as $kategori)
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="font-weight-bold small">{{ $kategori->nama_kategori ?? $kategori->nama ?? 'Kategori' }}</span>
                        <span class="small text-muted">{{ $kategori->buku_count }} buku</span>
                    </div>
                    @php
                        $maxCount = $topKategori->max('buku_count');
                        $percent = $maxCount > 0 ? round(($kategori->buku_count / $maxCount) * 100) : 0;
                    @endphp
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar bg-primary" style="width: {{ $percent }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

{{-- Script Grafik --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grafik Peminjaman Per Bulan
    var ctx1 = document.getElementById('myAreaChart');
    if (ctx1) {
        var bulanLabels = {!! $bulanLabels !!};
        var peminjamanData = {!! $peminjamanPerBulan !!};
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Peminjaman',
                    data: peminjamanData,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78,115,223,0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }

    // Grafik Donut Status Eksemplar
    var ctx2 = document.getElementById('myPieChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'],
                datasets: [{
                    data: [{{ $eksemplarTersedia }}, {{ $eksemplarDipinjam }}, {{ $eksemplarRusak }}, {{ $eksemplarHilang }}],
                    backgroundColor: ['#1cc88a', '#4e73df', '#f6c23e', '#e74a3b'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '70%'
            }
        });
    }
});
</script>
