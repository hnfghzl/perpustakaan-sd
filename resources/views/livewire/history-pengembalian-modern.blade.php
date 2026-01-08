<div>
    <style>
        .pengembalian-card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .pengembalian-btn-detail {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pengembalian-btn-detail:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .pengembalian-btn-bayar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pengembalian-btn-bayar:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .pengembalian-badge-lunas {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .pengembalian-badge-belum {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .pengembalian-form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .pengembalian-form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    {{-- Alert Messages --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #10b981; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15); background: #f0fdf4; border-color: #86efac;">
        <i data-feather="check-circle" style="width: 18px; height: 18px; color: #059669;"></i>
        <span style="color: #065f46; font-weight: 500; margin-left: 8px;">{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="color: #059669;">&times;</button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #ef4444; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15); background: #fef2f2; border-color: #fca5a5;">
        <i data-feather="x-circle" style="width: 18px; height: 18px; color: #dc2626;"></i>
        <span style="color: #991b1b; font-weight: 500; margin-left: 8px;">{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="color: #dc2626;">&times;</button>
    </div>
    @endif

    @if (session()->has('info'))
    <div class="alert alert-info alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #3b82f6; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15); background: #eff6ff; border-color: #93c5fd;">
        <i data-feather="info" style="width: 18px; height: 18px; color: #2563eb;"></i>
        <span style="color: #1e3a8a; font-weight: 500; margin-left: 8px;">{{ session('info') }}</span>
        <button type="button" class="close" data-dismiss="alert" style="color: #2563eb;">&times;</button>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="pengembalian-card-modern">
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px 16px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: white; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        <i data-feather="clock" style="width: 24px; height: 24px;"></i>
                        History Pengembalian Buku
                    </h5>
                    @php
                        $totalHistory = $peminjaman->total();
                        $unpaidCount = $peminjaman->where('status_pembayaran', 'belum_dibayar')->where('denda_total', '>', 0)->count();
                    @endphp
                    <small style="color: rgba(255,255,255,0.9); font-size: 14px;">
                        Total: {{ $totalHistory }} transaksi
                        @if($unpaidCount > 0)
                            <span style="color: #fef3c7; font-weight: 600;"> • {{ $unpaidCount }} belum lunas</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <div style="padding: 28px;">
            {{-- Filter & Search --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6b7280; z-index: 10; pointer-events: none;"></i>
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px 12px 44px; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select form-control" wire:model.live="filterPembayaran" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; font-size: 14px; font-weight: 600; color: #000 !important; background-color: #fff !important; box-shadow: 0 2px 6px rgba(0,0,0,0.05); cursor: pointer;">
                        <option value="" selected style="color: #000; font-weight: 600;">Semua Pembayaran</option>
                        <option value="belum_dibayar" style="color: #000;">Belum Lunas</option>
                        <option value="sudah_dibayar" style="color: #000;">Sudah Lunas</option>
                        <option value="tanpa_denda" style="color: #000;">Tanpa Denda</option>
                    </select>
                </div>
            </div>

            {{-- History List --}}
            <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                @forelse($peminjaman as $data)
                @php
                    $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo);
                    $tgl_kembali = $data->detailPeminjaman->first()->tgl_kembali ?? null;
                    $has_denda = $data->denda_total > 0;
                    $belum_lunas = $has_denda && $data->status_pembayaran === 'belum_dibayar';
                @endphp
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 20px 24px; transition: all 0.2s; {{ $belum_lunas ? 'background: #fef3c7;' : '' }}" onmouseover="this.style.background='{{ $belum_lunas ? '#fde68a' : '#f9fafb' }}';" onmouseout="this.style.background='{{ $belum_lunas ? '#fef3c7' : 'white' }}';">
                    <div class="row align-items-center">
                        {{-- Column 1: Transaction Info (35%) --}}
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="background: linear-gradient(135deg, {{ $belum_lunas ? '#f59e0b 0%, #d97706' : '#10b981 0%, #059669' }} 100%); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 3px 8px rgba({{ $belum_lunas ? '245, 158, 11' : '16, 185, 129' }}, 0.25);">
                                    <i data-feather="{{ $belum_lunas ? 'alert-circle' : 'check-circle' }}" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; color: {{ $belum_lunas ? '#d97706' : '#059669' }}; font-size: 14px; margin-bottom: 4px;">{{ $data->kode_transaksi }}</div>
                                    <div style="color: #374151; font-size: 14px; font-weight: 600; margin-bottom: 3px;">{{ $data->anggota->nama_anggota }}</div>
                                    <div style="font-size: 12px; color: #6b7280;">
                                        <i data-feather="user" style="width: 12px; height: 12px;"></i> {{ $data->user->nama_user }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Column 2: Dates & Books (25%) --}}
                        <div class="col-md-3">
                            <div style="font-size: 13px; color: #6b7280; line-height: 1.8;">
                                <div style="margin-bottom: 4px;">
                                    <i data-feather="calendar" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">Pinjam:</strong> {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}
                                </div>
                                <div style="margin-bottom: 4px;">
                                    <i data-feather="check" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">Kembali:</strong> {{ $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d/m/Y') : '-' }}
                                </div>
                                <div>
                                    <i data-feather="book" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">{{ $data->jumlah_peminjaman }}</strong> buku
                                </div>
                            </div>
                        </div>

                        {{-- Column 3: Denda Info (23%) --}}
                        <div class="col-md-3">
                            @if($has_denda)
                                <div style="font-size: 13px; line-height: 1.8;">
                                    <div style="color: #dc2626; font-weight: 700; margin-bottom: 6px;">
                                        <i data-feather="alert-circle" style="width: 13px; height: 13px;"></i> Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
                                    </div>
                                    @if($data->status_pembayaran === 'belum_dibayar')
                                        <span class="pengembalian-badge-belum">BELUM LUNAS</span>
                                    @else
                                        <span class="pengembalian-badge-lunas">LUNAS</span>
                                    @endif
                                </div>
                            @else
                                <div style="font-size: 13px; color: #059669; font-weight: 700;">
                                    <i data-feather="check-circle" style="width: 13px; height: 13px;"></i> Tanpa Denda
                                </div>
                            @endif
                        </div>

                        {{-- Column 4: Actions (14%) --}}
                        <div class="col-md-2 text-right">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="viewDetail({{ $data->id_peminjaman }})" class="pengembalian-btn-detail">
                                    <i data-feather="eye" style="width: 15px; height: 15px;"></i> Detail
                                </button>
                                @if($isPustakawan && $belum_lunas)
                                    <button onclick="confirm('Konfirmasi pembayaran denda Rp {{ number_format($data->denda_total, 0, ',', '.') }}?') || event.stopImmediatePropagation()"
                                        wire:click="markAsPaid({{ $data->id_peminjaman }})"
                                        class="pengembalian-btn-bayar">
                                        <i data-feather="dollar-sign" style="width: 15px; height: 15px;"></i> Bayar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                    <i data-feather="inbox" style="width: 52px; height: 52px; color: #9ca3af; margin-bottom: 14px;"></i>
                    <p style="color: #6b7280; font-size: 15px; margin: 0; font-weight: 600;">Tidak ada history pengembalian</p>
                    <small style="color: #9ca3af; font-size: 13px;">Transaksi yang sudah dikembalikan akan muncul di sini</small>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small style="color: #6b7280; font-size: 13px;">
                    Menampilkan {{ $peminjaman->firstItem() ?? 0 }} - {{ $peminjaman->lastItem() ?? 0 }} dari {{ $peminjaman->total() }} transaksi
                </small>
                <nav>
                    {{ $peminjaman->links() }}
                </nav>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    @if($showDetail && $detailPeminjaman)
    <div wire:ignore.self class="modal fade show" id="detailModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" wire:click.self="closeDetail">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                {{-- Header --}}
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 24px 28px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i data-feather="file-text" style="width: 22px; height: 22px;"></i>
                            Detail Pengembalian
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0 0;">{{ $detailPeminjaman->kode_transaksi }}</p>
                    </div>
                    <button type="button" wire:click="closeDetail" class="close text-white" aria-label="Close" style="font-size: 28px; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body" style="padding: 28px;">
                    {{-- Info Anggota - Gray Section --}}
                    <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 14px;">
                            <i data-feather="user" style="width: 16px; height: 16px;"></i> Data Anggota
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Nama Anggota</div>
                                <div style="font-weight: 700; color: #111827; font-size: 14px;">{{ $detailPeminjaman->anggota->nama_anggota }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Jenis Anggota</div>
                                <div style="font-weight: 700; color: #111827; font-size: 14px;">{{ ucfirst($detailPeminjaman->anggota->jenis_anggota) }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Transaksi - Blue Section --}}
                    <div style="background: #dbeafe; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 14px;">
                            <i data-feather="calendar" style="width: 16px; height: 16px;"></i> Info Transaksi
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Tanggal Pinjam</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;">{{ \Carbon\Carbon::parse($detailPeminjaman->tgl_pinjam)->format('d M Y') }}</div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Tanggal Kembali</div>
                                @php $tgl_kembali = $detailPeminjaman->detailPeminjaman->first()->tgl_kembali ?? null; @endphp
                                <div style="font-weight: 700; color: #111827; font-size: 13px;">{{ $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d M Y') : '-' }}</div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Diproses Oleh</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;">{{ $detailPeminjaman->user->nama_user }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Buku --}}
                    <div style="margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 12px;">
                            <i data-feather="book-open" style="width: 16px; height: 16px;"></i> Daftar Buku ({{ $detailPeminjaman->jumlah_peminjaman }})
                        </h6>
                        <div style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <table class="table mb-0" style="font-size: 13px;">
                                <thead style="background: #f9fafb;">
                                    <tr>
                                        <th style="padding: 12px; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb;">Judul Buku</th>
                                        <th style="padding: 12px; text-align: center; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb; width: 120px;">Kondisi</th>
                                        <th style="padding: 12px; text-align: right; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb; width: 130px;">Denda Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailPeminjaman->detailPeminjaman as $detail)
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 12px; color: #374151; font-weight: 600;">
                                            <div>{{ $detail->eksemplar->buku->judul }}</div>
                                            <div style="font-size: 11px; color: #6b7280; font-family: monospace;">{{ $detail->eksemplar->kode_eksemplar }}</div>
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            @if($detail->kondisi_kembali === 'baik')
                                                <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">BAIK</span>
                                            @elseif($detail->kondisi_kembali === 'rusak')
                                                <span style="background: #fed7aa; color: #92400e; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">RUSAK</span>
                                            @elseif($detail->kondisi_kembali === 'hilang')
                                                <span style="background: #fecaca; color: #991b1b; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">HILANG</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px; text-align: right; color: {{ $detail->denda_item > 0 ? '#dc2626' : '#6b7280' }}; font-weight: {{ $detail->denda_item > 0 ? '700' : '400' }};">
                                            Rp {{ number_format($detail->denda_item, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Summary Denda --}}
                    @if($detailPeminjaman->denda_total > 0)
                    <div style="background: #fee2e2; padding: 20px; border-radius: 12px; border-left: 4px solid #dc2626;">
                        <h6 style="font-weight: 700; color: #991b1b; font-size: 14px; margin-bottom: 12px;">
                            <i data-feather="alert-circle" style="width: 16px; height: 16px;"></i> Rincian Denda
                        </h6>
                        @php
                            $denda_keterlambatan = 0;
                            $denda_kerusakan = 0;
                            
                            $tgl_tempo = \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo);
                            $tgl_kembali_carbon = $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali) : null;
                            if ($tgl_kembali_carbon && $tgl_kembali_carbon->gt($tgl_tempo)) {
                                $hari_terlambat = $tgl_kembali_carbon->diffInDays($tgl_tempo);
                                $denda_keterlambatan = $hari_terlambat * $detailPeminjaman->jumlah_peminjaman * 1000;
                            }
                            
                            $denda_kerusakan = $detailPeminjaman->detailPeminjaman->sum('denda_item');
                        @endphp
                        <div style="font-size: 13px; color: #991b1b; line-height: 2;">
                            @if($denda_keterlambatan > 0)
                            <div style="display: flex; justify-content: space-between;">
                                <span>Denda Keterlambatan ({{ $hari_terlambat }} hari × {{ $detailPeminjaman->jumlah_peminjaman }} buku)</span>
                                <span style="font-weight: 700;">Rp {{ number_format($denda_keterlambatan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($denda_kerusakan > 0)
                            <div style="display: flex; justify-content: space-between;">
                                <span>Denda Kerusakan/Hilang</span>
                                <span style="font-weight: 700;">Rp {{ number_format($denda_kerusakan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div style="display: flex; justify-content: space-between; padding-top: 12px; margin-top: 12px; border-top: 2px solid rgba(220, 38, 38, 0.3); font-size: 15px;">
                                <span style="font-weight: 700;">Total Denda</span>
                                <span style="font-weight: 800;">Rp {{ number_format($detailPeminjaman->denda_total, 0, ',', '.') }}</span>
                            </div>
                            <div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid rgba(220, 38, 38, 0.3);">
                                <span style="font-weight: 700;">Status Pembayaran:</span> 
                                @if($detailPeminjaman->status_pembayaran === 'belum_dibayar')
                                    <span class="pengembalian-badge-belum">BELUM LUNAS</span>
                                @else
                                    <span class="pengembalian-badge-lunas">LUNAS</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div style="background: #d1fae5; padding: 20px; border-radius: 12px; text-align: center; border-left: 4px solid #10b981;">
                        <h6 style="font-weight: 700; color: #065f46; font-size: 14px; margin-bottom: 6px;">
                            <i data-feather="check-circle" style="width: 16px; height: 16px;"></i> Tidak Ada Denda
                        </h6>
                        <div style="font-size: 13px; color: #065f46;">Buku dikembalikan tepat waktu dan dalam kondisi baik</div>
                    </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="modal-footer" style="background: #f9fafb; border: none; padding: 20px 28px; border-radius: 0 0 16px 16px;">
                    <button type="button" wire:click="closeDetail" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 14px;">
                        <i data-feather="x" style="width: 16px; height: 16px;"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Feather Icons Refresh Pattern --}}
    @assets
    <script>
        window.refreshFeatherIcons = function() {
            if (typeof feather !== 'undefined') {
                setTimeout(() => {
                    feather.replace();
                    console.log('✅ Pengembalian icons refreshed');
                }, 150);
            }
        }
    </script>
    @endassets

    <script data-navigate-once>document.addEventListener('livewire:initialized', () => {
        refreshFeatherIcons();

        // Livewire lifecycle hooks
        Livewire.hook('element.init', () => refreshFeatherIcons());
        Livewire.hook('element.updated', () => refreshFeatherIcons());
        Livewire.hook('morph.updated', () => refreshFeatherIcons());
        Livewire.hook('commit', () => refreshFeatherIcons());

        // MutationObserver sebagai final backup
        const observer = new MutationObserver(() => refreshFeatherIcons());
        observer.observe(document.body, { childList: true, subtree: true });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    });</script>
</div>
