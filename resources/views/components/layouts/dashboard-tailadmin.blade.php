{{-- Dashboard TailAdmin untuk Role Kepala Sekolah --}}
<div>
    {{-- Metric Cards Group --}}
    <div class="row" style="margin-bottom: 1.5rem;">
        {{-- Card 1: Total Anggota --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955Z" fill=""/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Anggota</span>
                    <h4 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalAnggota) }}
                    </h4>
                    <p class="mt-1 text-xs text-gray-500">Guru: {{ $totalGuru ?? 0 }} | Siswa: {{ $totalSiswa ?? 0 }}</p>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-blue-50 py-1 px-2.5 text-xs font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <i data-feather="users" style="width: 12px; height: 12px;"></i>
                </span>
            </div>
        </div>

        {{-- Card 2: Total Buku --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30">
                <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Buku</span>
                    <h4 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalBuku) }}
                    </h4>
                    <p class="mt-1 text-xs text-gray-500">Judul Buku</p>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-green-50 py-1 px-2.5 text-xs font-medium text-green-600 dark:bg-green-500/15 dark:text-green-400">
                    <i data-feather="book-open" style="width: 12px; height: 12px;"></i>
                </span>
            </div>
        </div>

        {{-- Card 3: Peminjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-100 dark:bg-yellow-900/30">
                <svg class="fill-yellow-600 dark:fill-yellow-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Peminjaman Aktif</span>
                    <h4 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($peminjamanAktif) }}
                    </h4>
                    <p class="mt-1 text-xs text-gray-500">Buku Dipinjam</p>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-yellow-50 py-1 px-2.5 text-xs font-medium text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">
                    <i data-feather="clock" style="width: 12px; height: 12px;"></i>
                </span>
            </div>
        </div>

        {{-- Card 4: Buku Terlambat --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 dark:bg-red-900/30">
                <svg class="fill-red-600 dark:fill-red-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Buku Terlambat</span>
                    <h4 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($bukuTerlambat) }}
                    </h4>
                    <p class="mt-1 text-xs text-gray-500">Transaksi</p>
                </div>
                <span class="flex items-center gap-1 rounded-full bg-red-50 py-1 px-2.5 text-xs font-medium text-red-600 dark:bg-red-500/15 dark:text-red-400">
                    <i data-feather="alert-triangle" style="width: 12px; height: 12px;"></i>
                </span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2">
        {{-- Chart: Statistik Peminjaman 6 Bulan Terakhir --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 pb-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Statistik Peminjaman (6 Bulan Terakhir)
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tren peminjaman buku per bulan</p>
            </div>
            <div class="max-w-full overflow-x-auto">
                <div style="min-height: 300px;">
                    <canvas id="peminjamanChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Chart: Status Eksemplar --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 pb-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Status Eksemplar Buku
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Distribusi kondisi buku perpustakaan</p>
            </div>
            <div class="max-w-full overflow-x-auto">
                <div style="min-height: 300px;" class="flex items-center justify-center">
                    <canvas id="statusEksemplarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Denda Statistics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6">
        {{-- Denda Belum Dibayar --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 dark:bg-red-900/30">
                    <svg class="fill-red-600 dark:fill-red-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Denda Belum Dibayar</span>
                <h4 class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">
                    Rp {{ number_format($totalDendaBelumDibayar, 0, ',', '.') }}
                </h4>
                <p class="mt-1 text-xs text-gray-500">{{ $jumlahTransaksiBelumDibayar ?? 0 }} transaksi</p>
            </div>
        </div>

        {{-- Denda Sudah Dibayar --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30">
                    <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Pendapatan Denda</span>
                <h4 class="mt-2 text-2xl font-bold text-green-600 dark:text-green-400">
                    Rp {{ number_format($totalDendaSudahDibayar, 0, ',', '.') }}
                </h4>
                <p class="mt-1 text-xs text-gray-500">Total terbayar</p>
            </div>
        </div>

        {{-- Total Denda Keseluruhan --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                    <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Denda</span>
                <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                    Rp {{ number_format($totalDendaBelumDibayar + $totalDendaSudahDibayar, 0, ',', '.') }}
                </h4>
                <p class="mt-1 text-xs text-gray-500">Keseluruhan</p>
            </div>
        </div>
    </div>

    {{-- Top Kategori Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 pt-5 sm:px-6 sm:pt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Top 5 Kategori Buku Terpopuler
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Berdasarkan jumlah judul buku</p>
        </div>
        <div class="p-5 sm:p-6">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800">
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800 dark:text-white/90">
                                <span class="flex items-center gap-2">
                                    <i data-feather="hash" style="width: 16px; height: 16px;"></i>
                                    Ranking
                                </span>
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800 dark:text-white/90">
                                <span class="flex items-center gap-2">
                                    <i data-feather="tag" style="width: 16px; height: 16px;"></i>
                                    Kategori
                                </span>
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800 dark:text-white/90">
                                <span class="flex items-center gap-2">
                                    <i data-feather="book" style="width: 16px; height: 16px;"></i>
                                    Jumlah Buku
                                </span>
                            </th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-800 dark:text-white/90">
                                <span class="flex items-center gap-2">
                                    <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i>
                                    Progress
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxBuku = $topKategori->max('buku_count') ?? 1; @endphp
                        @foreach($topKategori as $index => $kategori)
                        <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400' : 
                                       ($index === 1 ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' : 
                                       ($index === 2 ? 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400' : 
                                       'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400')) }} 
                                    font-bold text-sm">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-medium text-gray-800 dark:text-white/90">{{ $kategori->nama }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                                    <i data-feather="book-open" style="width: 14px; height: 14px;"></i>
                                    {{ $kategori->buku_count }} judul
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full dark:bg-gray-700 overflow-hidden">
                                        @php $percentage = ($kategori->buku_count / $maxBuku) * 100; @endphp
                                        <div class="h-full {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-500' : ($index === 2 ? 'bg-orange-500' : 'bg-blue-500')) }} rounded-full transition-all duration-500" 
                                             style="width: {{ $percentage }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 min-w-[45px]">
                                        {{ number_format($percentage, 1) }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js Scripts --}}
@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    // Peminjaman Chart (Line Chart)
    const peminjamanCtx = document.getElementById('peminjamanChart');
    if (peminjamanCtx) {
        const bulanLabels = {!! $bulanLabels !!};
        const peminjamanData = {!! $peminjamanPerBulan !!};
        
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
                    pointRadius: 5,
                    pointHoverRadius: 7
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
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Status Eksemplar Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusEksemplarChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'],
                datasets: [{
                    data: [
                        {{ $eksemplarTersedia }},
                        {{ $eksemplarDipinjam }},
                        {{ $eksemplarRusak }},
                        {{ $eksemplarHilang }}
                    ],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',  // Green
                        'rgba(234, 179, 8, 0.8)',   // Yellow
                        'rgba(239, 68, 68, 0.8)',   // Red
                        'rgba(107, 114, 128, 0.8)'  // Gray
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(239, 68, 68)',
                        'rgb(107, 114, 128)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 13 },
                            usePointStyle: true,
                            pointStyle: 'circle'
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
</script>
@endscript
