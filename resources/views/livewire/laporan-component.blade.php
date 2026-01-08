<div>
    {{-- Header with Gradient --}}
    <div class="mb-4" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 40px rgba(26, 188, 156, 0.3);">
        <h1 style="font-size: 2.5rem; font-weight: 800; color: white; margin-bottom: 0.75rem; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i data-feather="bar-chart-2" style="width: 40px; height: 40px; vertical-align: middle;"></i>
            Laporan Manajerial
        </h1>
        <p style="font-size: 1.125rem; color: rgba(255,255,255,0.9); margin: 0;">Data analisis dan pelaporan untuk monitoring perpustakaan</p>
    </div>

    {{-- Date Range Filter with Modern Design --}}
    <div class="card mb-4 border-0" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
        <div class="card-body p-4">
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #64748b; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Tanggal Mulai
                    </label>
                    <input type="date" wire:model="startDate" class="form-control" style="border-radius: 0.75rem; border: 2px solid #e5e7eb; padding: 0.75rem 1rem; font-size: 1rem; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #64748b; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Tanggal Akhir
                    </label>
                    <input type="date" wire:model="endDate" class="form-control" style="border-radius: 0.75rem; border: 2px solid #e5e7eb; padding: 0.75rem 1rem; font-size: 1rem; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div class="col-md-4">
                    <button wire:click="updateDateRange" class="btn w-100" style="border-radius: 0.75rem; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; color: white; padding: 0.75rem 1.5rem; font-weight: 600; box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(26, 188, 156, 0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(26, 188, 156, 0.4)';">
                        <i data-feather="filter" style="width: 18px; height: 18px;"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Flash Messages with Modern Design --}}
    @if (session()->has('success'))
        <div class="alert alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 1rem; color: white; padding: 1rem 1.5rem; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); margin-bottom: 1.5rem;">
            <i data-feather="check-circle" style="width: 24px; height: 24px; vertical-align: middle;"></i>
            <strong style="margin-left: 0.5rem; font-size: 1.125rem;">{{ session('success') }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Modern Tab Navigation --}}
    <div class="card mb-4 border-0" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
        <div class="card-body p-3">
            <ul class="nav nav-pills" role="tablist" style="gap: 0.5rem; display: flex; flex-wrap: nowrap;">
                <li class="nav-item" role="presentation" style="flex: 1;">
                    <a class="nav-link active text-center w-100" id="peminjaman-tab" data-toggle="pill" href="#peminjaman" role="tab" style="border-radius: 1rem; padding: 1rem; font-weight: 600; transition: all 0.3s; border: 2px solid transparent;">
                        <i data-feather="book-open" style="width: 20px; height: 20px; margin-bottom: 0.25rem; display: block; margin-left: auto; margin-right: auto;"></i>
                        <div style="font-size: 0.875rem;">Peminjaman</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="flex: 1;">
                    <a class="nav-link text-center w-100" id="anggota-tab" data-toggle="pill" href="#anggota" role="tab" style="border-radius: 1rem; padding: 1rem; font-weight: 600; transition: all 0.3s; border: 2px solid transparent;">
                        <i data-feather="users" style="width: 20px; height: 20px; margin-bottom: 0.25rem; display: block; margin-left: auto; margin-right: auto;"></i>
                        <div style="font-size: 0.875rem;">Keanggotaan</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="flex: 1;">
                    <a class="nav-link text-center w-100" id="inventaris-tab" data-toggle="pill" href="#inventaris" role="tab" style="border-radius: 1rem; padding: 1rem; font-weight: 600; transition: all 0.3s; border: 2px solid transparent;">
                        <i data-feather="package" style="width: 20px; height: 20px; margin-bottom: 0.25rem; display: block; margin-left: auto; margin-right: auto;"></i>
                        <div style="font-size: 0.875rem;">Inventaris</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation" style="flex: 1;">
                    <a class="nav-link text-center w-100" id="analisis-tab" data-toggle="pill" href="#analisis" role="tab" style="border-radius: 1rem; padding: 1rem; font-weight: 600; transition: all 0.3s; border: 2px solid transparent;">
                        <i data-feather="trending-up" style="width: 20px; height: 20px; margin-bottom: 0.25rem; display: block; margin-left: auto; margin-right: auto;"></i>
                        <div style="font-size: 0.875rem;">Analisis</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="tab-content" style="background: white;">
        {{-- TAB 1: LAPORAN PEMINJAMAN --}}
        <div class="tab-pane fade show active" id="peminjaman" role="tabpanel" style="background: white; padding: 1rem;">
            {{-- Summary Cards - Minimalist Design --}}
            <div class="row g-2 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="book-open" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $laporanPeminjaman['totalPeminjaman'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Peminjaman</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Dalam periode terpilih</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="alert-circle" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $laporanPeminjaman['peminjamanTerlambat'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Peminjaman Terlambat</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">{{ $laporanPeminjaman['persenTerlambat'] }}% dari total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="check-circle" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ 100 - $laporanPeminjaman['persenTerlambat'] }}%</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Tingkat Ketepatan</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Pengembalian tepat waktu</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHART SECTION --}}
            <div class="row g-4 mb-4">
                {{-- Chart 1: Tren Peminjaman (Line Chart) --}}
                <div class="col-md-6">
                    <div class="card border-0" style="border-radius: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                        <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                            <h6 class="mb-0 fw-bold" style="color: white; font-size: 1rem;">
                                <i data-feather="activity" style="width: 20px; height: 20px;"></i>
                                Tren Peminjaman 6 Bulan
                            </h6>
                        </div>
                        <div class="card-body p-3" style="min-height: 300px;">
                            <canvas id="trenPeminjamanChart" style="width: 100%; height: 280px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 2: Top 10 Buku (Bar Chart) --}}
                <div class="col-md-6">
                    <div class="card border-0" style="border-radius: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                        <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                            <h6 class="mb-0 fw-bold" style="color: white; font-size: 1rem;">
                                <i data-feather="star" style="width: 20px; height: 20px;"></i>
                                Top 10 Buku Terpopuler
                            </h6>
                        </div>
                        <div class="card-body p-3" style="min-height: 300px;">
                            <canvas id="bukuTerpopulerChart" style="width: 100%; height: 280px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 2: STATISTIK KEANGGOTAAN --}}
        <div class="tab-pane fade" id="anggota" role="tabpanel" style="background: white; padding: 1rem;">
            {{-- Summary Cards - Minimalist Design --}}
            <div class="row g-2 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="users" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $statistikAnggota['totalAnggota'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Anggota</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Guru + Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="user-check" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $statistikAnggota['anggotaAktif'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Anggota Aktif</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Pernah pinjam</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="briefcase" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $statistikAnggota['totalGuru'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Guru</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Anggota guru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="book" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $statistikAnggota['totalSiswa'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Siswa</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Anggota siswa</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top 5 Anggota Paling Aktif --}}
            <div class="card border-0" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="award" style="width: 24px; height: 24px;"></i>
                        Top 5 Anggota Paling Aktif
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="border-radius: 0;">
                            <thead style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                                <tr style="color: white;">
                                    <th style="width: 80px; padding: 1rem; font-weight: 600; border: none;">
                                        <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700;">NO</div>
                                    </th>
                                    <th style="padding: 1rem; font-weight: 600; border: none;">Nama Anggota</th>
                                    <th style="padding: 1rem; font-weight: 600; border: none; width: 150px;">Jenis</th>
                                    <th class="text-center" style="width: 150px; padding: 1rem; font-weight: 600; border: none;">Total Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($statistikAnggota['topAnggota'] as $index => $anggota)
                                    <tr style="transition: all 0.3s;">
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">{{ $index + 1 }}</div>
                                        </td>
                                        <td style="padding: 1rem; font-weight: 600; color: #1e293b; vertical-align: middle;">{{ $anggota['nama'] }}</td>
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <span style="padding: 0.5rem 1rem; border-radius: 0.75rem; font-weight: 600; font-size: 0.875rem; background: linear-gradient(135deg, {{ $anggota['jenis'] == 'guru' ? '#1ABC9C 0%, #16A085 100%' : '#16A085 0%, #1ABC9C 100%' }}); color: white; display: inline-block;">
                                                {{ ucfirst($anggota['jenis']) }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle;">
                                            <span style="padding: 0.5rem 1rem; border-radius: 0.75rem; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; font-weight: 700; font-size: 1rem; display: inline-block;">{{ $anggota['total_pinjam'] }}x</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5" style="color: #94a3b8;">
                                            <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem;"></i>
                                            <p style="margin: 0; font-size: 1rem;">Tidak ada data aktivitas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3: MANAJEMEN INVENTARIS --}}
        <div class="tab-pane fade" id="inventaris" role="tabpanel" style="background: white; padding: 1rem;">
            {{-- Summary Cards - Minimalist Design --}}
            <div class="row g-2 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="book" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $inventarisKoleksi['totalJudulBuku'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Judul Buku</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Metadata buku</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #1ABC9C;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="layers" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #1ABC9C; margin: 0;">{{ $inventarisKoleksi['totalEksemplar'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Eksemplar</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">Copy fisik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #ef4444;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="tool" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #ef4444; margin: 0;">{{ $inventarisKoleksi['eksemplarRusak'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Buku Rusak</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">{{ $inventarisKoleksi['persenRusak'] }}% dari total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100" style="border-radius: 1rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #6b7280;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)';">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="alert-circle" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <h2 style="font-size: 2rem; font-weight: 700; color: #6b7280; margin: 0;">{{ $inventarisKoleksi['eksemplarHilang'] }}</h2>
                            </div>
                            <h6 style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px;">Buku Hilang</h6>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">{{ $inventarisKoleksi['persenHilang'] }}% dari total</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VISUALISASI DATA: Status Eksemplar & Kategori Buku --}}
            <div class="row g-4 mb-4">
                {{-- Chart 3: Status Eksemplar (Doughnut) --}}
                <div class="col-md-6">
                    <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 1.25rem;">
                            <h5 class="mb-0" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                                <i data-feather="pie-chart" style="width: 20px; height: 20px;"></i>
                                Status Eksemplar
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <canvas id="statusEksemplarChart" style="max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 4: Kategori Buku (Pie) --}}
                <div class="col-md-6">
                    <div class="card border-0 h-100" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 1.25rem;">
                            <h5 class="mb-0" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                                <i data-feather="layers" style="width: 20px; height: 20px;"></i>
                                Distribusi Kategori
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <canvas id="kategoriChart" style="max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Distribusi Koleksi Per Kategori --}}
            <div class="card border-0" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="layers" style="width: 24px; height: 24px;"></i>
                        Distribusi Koleksi Per Kategori
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="border-radius: 0;">
                            <thead style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                                <tr style="color: white;">
                                    <th style="width: 80px; padding: 1rem; font-weight: 600; border: none;">
                                        <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700;">NO</div>
                                    </th>
                                    <th style="padding: 1rem; font-weight: 600; border: none;">Kategori</th>
                                    <th class="text-center" style="width: 200px; padding: 1rem; font-weight: 600; border: none;">Jumlah Buku</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventarisKoleksi['koleksiPerKategori'] as $index => $kategori)
                                    <tr style="transition: all 0.3s;">
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">{{ $index + 1 }}</div>
                                        </td>
                                        <td style="padding: 1rem; font-weight: 600; color: #1e293b; vertical-align: middle;">{{ $kategori['nama_kategori'] }}</td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle;">
                                            <span style="padding: 0.5rem 1rem; border-radius: 0.75rem; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; font-weight: 700; font-size: 1rem; display: inline-block;">{{ $kategori['jumlah_buku'] }} buku</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5" style="color: #94a3b8;">
                                            <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem;"></i>
                                            <p style="margin: 0; font-size: 1rem;">Tidak ada data kategori</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 4: ANALISIS KEBUTUHAN --}}
        <div class="tab-pane fade" id="analisis" role="tabpanel" style="background: white; padding: 1rem;">
            {{-- Rekomendasi Pembelian --}}
            @if($analisisKebutuhan['rekomendasi']->count() > 0)
                <div class="alert border-0 shadow-sm mb-4" role="alert" style="border-radius: 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.5rem;">
                    <h5 style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-weight: 600;">
                        <i data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
                        Rekomendasi Pembelian
                    </h5>
                    <p class="mb-2" style="font-size: 1rem; opacity: 0.95;">Kategori berikut memiliki <strong>demand tinggi</strong> namun <strong>koleksi terbatas</strong>. Disarankan untuk menambah koleksi:</p>
                    <ul class="mb-0" style="font-size: 0.95rem; opacity: 0.9;">
                        @foreach ($analisisKebutuhan['rekomendasi'] as $item)
                            <li style="margin-bottom: 0.5rem;"><strong>{{ $item['nama_kategori'] }}</strong> - Hanya {{ $item['jumlah_koleksi'] }} buku, {{ $item['total_peminjaman'] }} peminjaman</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert border-0 shadow-sm mb-4" role="alert" style="border-radius: 1.5rem; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 1.125rem; font-weight: 600;">
                        <i data-feather="check-circle" style="width: 28px; height: 28px;"></i>
                        <span><strong>Koleksi Optimal!</strong> Tidak ada kategori yang memerlukan penambahan mendesak.</span>
                    </div>
                </div>
            @endif

            {{-- Analisis Per Kategori --}}
            <div class="card border-0" style="border-radius: 1.5rem; background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="bar-chart" style="width: 24px; height: 24px;"></i>
                        Analisis Demand vs Koleksi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="border-radius: 0;">
                            <thead style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                                <tr style="color: white;">
                                    <th style="width: 80px; padding: 1rem; font-weight: 600; border: none;">
                                        <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700;">NO</div>
                                    </th>
                                    <th style="padding: 1rem; font-weight: 600; border: none;">Kategori</th>
                                    <th class="text-center" style="width: 120px; padding: 1rem; font-weight: 600; border: none;">Koleksi</th>
                                    <th class="text-center" style="width: 130px; padding: 1rem; font-weight: 600; border: none;">Peminjaman</th>
                                    <th class="text-center" style="width: 150px; padding: 1rem; font-weight: 600; border: none;">Rata² per Buku</th>
                                    <th class="text-center" style="width: 150px; padding: 1rem; font-weight: 600; border: none;">Level Demand</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analisisKebutuhan['analisisKategori'] as $index => $item)
                                    <tr style="transition: all 0.3s;">
                                        <td style="padding: 1rem; vertical-align: middle;">
                                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">{{ $index + 1 }}</div>
                                        </td>
                                        <td style="padding: 1rem; font-weight: 600; color: #1e293b; vertical-align: middle;">{{ $item['nama_kategori'] }}</td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle; font-weight: 600; color: #475569;">{{ $item['jumlah_koleksi'] }}</td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle; font-weight: 600; color: #475569;">{{ $item['total_peminjaman'] }}</td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle; font-weight: 600; color: #475569;">{{ $item['avg_pinjam_per_buku'] }}</td>
                                        <td class="text-center" style="padding: 1rem; vertical-align: middle;">
                                            <span style="padding: 0.5rem 1rem; border-radius: 0.75rem; font-weight: 600; font-size: 0.875rem; display: inline-block; background: linear-gradient(135deg, 
                                                @if($item['demand_level'] == 'Tinggi') #ef4444 0%, #dc2626 100%
                                                @elseif($item['demand_level'] == 'Sedang') #f59e0b 0%, #d97706 100%
                                                @else #6b7280 0%, #4b5563 100%
                                                @endif); color: white;">
                                                {{ $item['demand_level'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js for Tren Peminjaman --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Refresh Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Tren Peminjaman Chart
        const trenCtx = document.getElementById('trenPeminjamanChart');
        if (trenCtx) {
            const trenData = {!! json_encode($laporanPeminjaman['trenPeminjaman']) !!};
            
            new Chart(trenCtx, {
                type: 'line',
                data: {
                    labels: trenData.map(item => item.bulan),
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: trenData.map(item => item.total),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        // Refresh icons when tab changes
        document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(button => {
            button.addEventListener('shown.bs.tab', function() {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });
        });
    });

    // Livewire hooks for icon refresh
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('element.init', () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    }

    // Add smooth scroll behavior
    document.querySelectorAll('a[data-bs-toggle="pill"]').forEach(link => {
        link.addEventListener('shown.bs.tab', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Animate cards on load
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
</script>

<style>
    /* Tab Pills Navigation */
    .nav-pills .nav-link {
        color: #64748b;
        background: transparent;
    }
    .nav-pills .nav-link:hover {
        background: #f3f4f6;
        color: #64748b;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
        }    /* Modern Table Styles */
    .modern-table tbody tr:last-child {
        border-bottom: none !important;
    }

    /* Smooth Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        animation: slideInUp 0.5s ease forwards;
    }

    /* Card Hover Effects */
    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Badge Modern Style */
    .badge {
        transition: all 0.3s;
    }

    .badge:hover {
        transform: scale(1.1);
    }

    /* Input Focus Effects */
    input[type="date"]:focus {
        outline: none;
    }

    /* Scrollbar Styling */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #16A085 0%, #1ABC9C 100%);
    }
    </style>

    {{-- Load Chart.js & Custom Chart Script --}}
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/laporan-charts.js') }}"></script>
    
    <script>
        window.refreshFeatherIcons = function() {
            if (typeof feather !== 'undefined') {
                setTimeout(() => {
                    feather.replace();
                }, 150);
            }
        }
    </script>
    @endassets

    <script data-navigate-once>document.addEventListener('livewire:initialized', () => {
        refreshFeatherIcons();
        
        // Livewire lifecycle hooks
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('element.init', () => refreshFeatherIcons());
        }
        
        // CHART DATA FROM SERVER (SAFE JSON ENCODING)
        const chartData = {
            trend: {
                labels: @json($trendLabels ?? []),
                data: @json($trendData ?? [])
            },
            buku: {
                labels: @json($bukuLabels ?? []),
                data: @json($bukuData ?? [])
            },
            status: {
                labels: @json($statusEksemplarLabels ?? []),
                data: @json($statusEksemplarData ?? [])
            },
            kategori: {
                labels: @json($kategoriLabels ?? []),
                data: @json($kategoriData ?? [])
            }
        };
        
        // INITIALIZE CHARTS IMMEDIATELY (Livewire already loaded DOM)
        if (typeof initLaporanCharts === 'function') {
            initLaporanCharts(chartData);
        }
        
        // Feather Icons Refresh with Livewire
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('element.updated', () => refreshFeatherIcons());
            Livewire.hook('morph.updated', () => refreshFeatherIcons());
            Livewire.hook('commit', () => refreshFeatherIcons());
        }
        
        // MutationObserver sebagai final backup
        const observer = new MutationObserver(() => refreshFeatherIcons());
        observer.observe(document.body, { childList: true, subtree: true });
        
        // Refresh saat tab berubah
        document.querySelectorAll('a[data-toggle="pill"]').forEach(link => {
            link.addEventListener('shown.bs.tab', function() {
                refreshFeatherIcons();
            });
        });
    });</script>
</div>
