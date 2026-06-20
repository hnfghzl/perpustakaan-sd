{{-- Dashboard Modern untuk Pustakawan --}}

{{-- Stat Cards --}}
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #4e73df !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Total Anggota</div>
                        <div class="h4 font-weight-bold text-dark mb-0">{{ $totalAnggota }}</div>
                        <small class="text-muted">Terdaftar</small>
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

{{-- Denda --}}
<div class="row mb-4">
    <div class="col-xl-6 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #f6c23e !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Denda Belum Dibayar</div>
                        <div class="h5 font-weight-bold text-dark mb-0">Rp {{ number_format($totalDendaBelumDibayar, 0, ',', '.') }}</div>
                        <small class="text-muted">{{ $jumlahTransaksiBelumDibayar }} transaksi belum lunas</small>
                    </div>
                    <div style="font-size:2rem; color:#f6c23e;"><i class="fas fa-money-bill-wave"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1cc88a !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted font-weight-bold" style="font-size:0.75rem;">Denda Sudah Dibayar</div>
                        <div class="h5 font-weight-bold text-dark mb-0">Rp {{ number_format($totalDendaSudahDibayar, 0, ',', '.') }}</div>
                        <small class="text-muted">Total terkumpul</small>
                    </div>
                    <div style="font-size:2rem; color:#1cc88a;"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info Aksi Cepat --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bolt mr-2"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('peminjaman') }}" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#eef2ff;">
                                <i class="fas fa-plus-circle fa-2x mb-2" style="color:#4e73df;"></i>
                                <div class="small font-weight-bold text-dark">Peminjaman Baru</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('anggota') }}" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#e6f9f2;">
                                <i class="fas fa-user-plus fa-2x mb-2" style="color:#1cc88a;"></i>
                                <div class="small font-weight-bold text-dark">Tambah Anggota</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('buku') }}" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#e8f8fb;">
                                <i class="fas fa-book-medical fa-2x mb-2" style="color:#36b9cc;"></i>
                                <div class="small font-weight-bold text-dark">Tambah Buku</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('pengembalian') }}" class="text-decoration-none">
                            <div class="p-3 rounded" style="background:#fff8e6;">
                                <i class="fas fa-undo fa-2x mb-2" style="color:#f6c23e;"></i>
                                <div class="small font-weight-bold text-dark">Pengembalian</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
