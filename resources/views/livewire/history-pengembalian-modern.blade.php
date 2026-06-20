<div style="overflow: visible !important;">
<style>
    .hpeng-card {
        background: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s;
        overflow: visible !important;
    }
    .hpeng-btn {
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
        cursor: pointer;
    }
    .hpeng-btn:hover {
        background: #e5e7eb;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .hpeng-btn-bayar {
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
        cursor: pointer;
    }
    .hpeng-btn-bayar:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(16,185,129,0.3);
        color: white;
    }
    .hpeng-badge-lunas {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    .hpeng-badge-belum {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    .hpeng-badge-nodenda {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    .hpeng-card, .hpeng-card > div, .row, .col-md-6 { overflow: visible !important; }
    .dropdown { position: relative; }
    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        transform: translateY(4px) !important;
        z-index: 9999 !important;
        margin: 0 !important;
    }
    .dropdown-menu.show { display: block; animation: hpengSlide .2s ease-out; }
    .dropdown-item:hover { background: #f3f4f6 !important; color: #111827 !important; }
    .dropdown-item.active { background: linear-gradient(135deg,#3b82f6 0%,#2563eb 100%) !important; color: white !important; }
    @keyframes hpengSlide { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(4px); } }
</style>

{{-- Alert Messages --}}
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;border-left:4px solid #10b981;background:#f0fdf4;">
    <i data-feather="check-circle" style="width:18px;height:18px;color:#059669;"></i>
    <span style="color:#065f46;font-weight:500;margin-left:8px;">{{ session('success') }}</span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" style="border-radius:12px;border-left:4px solid #ef4444;background:#fef2f2;">
    <i data-feather="x-circle" style="width:18px;height:18px;color:#dc2626;"></i>
    <span style="color:#991b1b;font-weight:500;margin-left:8px;">{{ session('error') }}</span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

{{-- Main Card --}}
<div class="hpeng-card">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);padding:24px 28px;border-radius:16px 16px 0 0;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1" style="color:white;font-weight:700;font-size:20px;display:flex;align-items:center;gap:10px;">
                    <i data-feather="rotate-ccw" style="width:24px;height:24px;"></i>
                    History Pengembalian Buku
                </h5>
                @php
                    $totalHistory  = $peminjaman->total();
                    $unpaidCount   = $peminjaman->where('status_pembayaran','belum_dibayar')->where('denda_total','>',0)->count();
                @endphp
                <small style="color:rgba(255,255,255,.9);font-size:14px;">
                    Total: {{ $totalHistory }} transaksi
                    @if($unpaidCount > 0)
                        <span style="color:#fef3c7;font-weight:600;"> • {{ $unpaidCount }} belum lunas</span>
                    @endif
                </small>
            </div>
        </div>
    </div>

    <div style="padding:28px;overflow:visible !important;">

        {{-- Filter & Search --}}
        <div class="row mb-4" style="overflow:visible !important;">
            <div class="col-md-6 mb-3 mb-md-0">
                <div style="position:relative;">
                    <i data-feather="search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#6b7280;z-index:10;pointer-events:none;"></i>
                    <input type="text" class="form-control" wire:model.live="search"
                           placeholder="Cari kode transaksi atau nama anggota..."
                           style="border:2px solid #e5e7eb;border-radius:10px;padding:12px 16px 12px 44px;font-size:14px;box-shadow:0 2px 6px rgba(0,0,0,.05);">
                </div>
            </div>
            <div class="col-md-6" style="overflow:visible !important;">
                <div class="dropdown" style="width:100%;overflow:visible !important;">
                    <button class="btn btn-white dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                            type="button" id="pembayaranFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="border:2px solid #e5e7eb;border-radius:10px;padding:12px 16px;font-size:14px;font-weight:600;color:#000 !important;background-color:#fff !important;box-shadow:0 2px 6px rgba(0,0,0,.05);cursor:pointer;">
                        <span>
                            @if($filterPembayaran === '') Semua Status
                            @elseif($filterPembayaran === 'belum_dibayar') Belum Lunas
                            @elseif($filterPembayaran === 'sudah_dibayar') Sudah Lunas
                            @else Tanpa Denda
                            @endif
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100 shadow-sm" aria-labelledby="pembayaranFilter"
                        style="border:2px solid #e5e7eb;border-radius:10px;padding:8px;margin-top:4px;z-index:9999 !important;">
                        <li><a class="dropdown-item {{ $filterPembayaran==='' ? 'active' : '' }}" href="#"
                               wire:click.prevent="$set('filterPembayaran','')"
                               style="border-radius:8px;padding:10px 14px;font-size:14px;font-weight:600;color:#000;margin-bottom:4px;">Semua Status</a></li>
                        <li><a class="dropdown-item {{ $filterPembayaran==='belum_dibayar' ? 'active' : '' }}" href="#"
                               wire:click.prevent="$set('filterPembayaran','belum_dibayar')"
                               style="border-radius:8px;padding:10px 14px;font-size:14px;color:#000;margin-bottom:4px;">Belum Lunas</a></li>
                        <li><a class="dropdown-item {{ $filterPembayaran==='sudah_dibayar' ? 'active' : '' }}" href="#"
                               wire:click.prevent="$set('filterPembayaran','sudah_dibayar')"
                               style="border-radius:8px;padding:10px 14px;font-size:14px;color:#000;margin-bottom:4px;">Sudah Lunas</a></li>
                        <li><a class="dropdown-item {{ $filterPembayaran==='tanpa_denda' ? 'active' : '' }}" href="#"
                               wire:click.prevent="$set('filterPembayaran','tanpa_denda')"
                               style="border-radius:8px;padding:10px 14px;font-size:14px;color:#000;">Tanpa Denda</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- List --}}
        <div class="list-group" style="border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
            @forelse($peminjaman as $data)
            @php
                $tgl_kembali  = $data->detailPeminjaman->first()->tgl_kembali ?? null;
                $has_denda    = $data->denda_total > 0;
                $belum_lunas  = $has_denda && $data->status_pembayaran === 'belum_dibayar';
            @endphp
            <div class="list-group-item"
                 style="border:none;border-bottom:1px solid #f3f4f6;padding:20px 24px;transition:all .2s;{{ $belum_lunas ? 'background:#fef3c7;' : '' }}"
                 onmouseover="this.style.background='{{ $belum_lunas ? '#fde68a' : '#f9fafb' }}'"
                 onmouseout="this.style.background='{{ $belum_lunas ? '#fef3c7' : 'white' }}'">
                <div class="row align-items-center">

                    {{-- Kolom 1: Info Transaksi --}}
                    <div class="col-md-4">
                        <div style="display:flex;align-items:center;gap:14px;">
                            <div style="background:linear-gradient(135deg,{{ $belum_lunas ? '#f59e0b 0%,#d97706' : '#10b981 0%,#059669' }} 100%);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 8px rgba({{ $belum_lunas ? '245,158,11' : '16,185,129' }},.25);">
                                <i data-feather="{{ $belum_lunas ? 'alert-circle' : 'check-circle' }}" style="width:24px;height:24px;color:white;"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:700;color:{{ $belum_lunas ? '#d97706' : '#111827' }};font-size:14px;margin-bottom:4px;">{{ $data->kode_transaksi }}</div>
                                <div style="color:#374151;font-size:14px;font-weight:600;margin-bottom:3px;">{{ $data->anggota->nama_anggota }}</div>
                                <div style="font-size:12px;color:#6b7280;">
                                    <i data-feather="user" style="width:12px;height:12px;"></i>
                                    {{ optional($data->user)->nama_user ?? '(user dihapus)' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom 2: Tanggal & Buku --}}
                    <div class="col-md-3">
                        <div style="font-size:13px;color:#6b7280;line-height:1.9;">
                            <div>
                                <i data-feather="calendar" style="width:13px;height:13px;"></i>
                                <strong style="color:#374151;">Pinjam:</strong>
                                {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}
                            </div>
                            <div>
                                <i data-feather="check" style="width:13px;height:13px;"></i>
                                <strong style="color:#374151;">Kembali:</strong>
                                {{ $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d/m/Y') : '-' }}
                            </div>
                            <div>
                                <i data-feather="book" style="width:13px;height:13px;"></i>
                                <strong style="color:#374151;">{{ $data->jumlah_peminjaman }}</strong> buku
                            </div>
                        </div>
                    </div>

                    {{-- Kolom 3: Status Denda --}}
                    <div class="col-md-3">
                        @if($has_denda)
                            <div style="font-size:13px;line-height:1.9;">
                                <div style="color:#dc2626;font-weight:700;margin-bottom:6px;">
                                    <i data-feather="alert-circle" style="width:13px;height:13px;"></i>
                                    Denda: Rp {{ number_format($data->denda_total,0,',','.') }}
                                </div>
                                @if($belum_lunas)
                                    <span class="hpeng-badge-belum">BELUM LUNAS</span>
                                @else
                                    <span class="hpeng-badge-lunas">LUNAS</span>
                                @endif
                            </div>
                        @else
                            <span class="hpeng-badge-nodenda">
                                <i data-feather="check-circle" style="width:13px;height:13px;display:inline;vertical-align:middle;"></i>
                                Tanpa Denda
                            </span>
                        @endif
                    </div>

                    {{-- Kolom 4: Aksi --}}
                    <div class="col-md-2 text-right">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;" x-data x-init="$nextTick(()=>feather.replace())">
                            <button wire:click="viewDetail({{ $data->id_peminjaman }})" class="hpeng-btn" title="Lihat Detail">
                                <i data-feather="eye" style="width:15px;height:15px;"></i>
                            </button>
                            @if($isPustakawan && $belum_lunas)
                            <button wire:click="markAsPaid({{ $data->id_peminjaman }})"
                                    wire:confirm="Konfirmasi pembayaran denda Rp {{ number_format($data->denda_total,0,',','.') }}?"
                                    class="hpeng-btn-bayar" title="Tandai Lunas">
                                <i data-feather="dollar-sign" style="width:15px;height:15px;"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="list-group-item text-center" style="padding:60px 24px;border:none;background:#f9fafb;">
                <i data-feather="inbox" style="width:52px;height:52px;color:#9ca3af;margin-bottom:14px;display:block;margin-left:auto;margin-right:auto;"></i>
                <p style="color:#6b7280;font-size:15px;margin:0;font-weight:600;">Tidak ada history pengembalian</p>
                <small style="color:#9ca3af;font-size:13px;">Transaksi yang sudah dikembalikan akan muncul di sini</small>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <small style="color:#6b7280;font-size:13px;">
                Menampilkan {{ $peminjaman->firstItem() ?? 0 }}–{{ $peminjaman->lastItem() ?? 0 }} dari {{ $peminjaman->total() }} transaksi
            </small>
            <nav>{{ $peminjaman->links() }}</nav>
        </div>

    </div>
</div>

{{-- Modal Detail --}}
@if($showDetail && $detailPeminjaman)
@php
    $tgl_kembali_detail = $detailPeminjaman->detailPeminjaman->first()->tgl_kembali ?? null;
    $tgl_tempo_detail   = \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo);
    $tgl_kembali_carbon = $tgl_kembali_detail ? \Carbon\Carbon::parse($tgl_kembali_detail) : null;
    $hari_terlambat     = ($tgl_kembali_carbon && $tgl_kembali_carbon->gt($tgl_tempo_detail))
                            ? (int)$tgl_kembali_carbon->diffInDays($tgl_tempo_detail) : 0;
    $denda_keterlambatan = $hari_terlambat > 0
                            ? $hari_terlambat * $detailPeminjaman->jumlah_peminjaman * 1000 : 0;
    $denda_kerusakan    = $detailPeminjaman->detailPeminjaman->sum('denda_item');
@endphp
<div class="modal fade show" tabindex="-1" style="display:block;background:rgba(0,0,0,.5);"
     wire:click.self="closeDetail">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.2);">

            {{-- Header --}}
            <div class="modal-header" style="background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border:none;border-radius:16px 16px 0 0;padding:24px 28px;">
                <div>
                    <h5 class="modal-title" style="color:white;font-weight:700;font-size:18px;margin:0;display:flex;align-items:center;gap:10px;">
                        <i data-feather="file-text" style="width:22px;height:22px;"></i> Detail Pengembalian
                    </h5>
                    <p style="color:rgba(255,255,255,.9);font-size:13px;margin:6px 0 0 0;">{{ $detailPeminjaman->kode_transaksi }}</p>
                </div>
                <button type="button" wire:click="closeDetail" class="close text-white" style="font-size:28px;opacity:.9;">&times;</button>
            </div>

            {{-- Body --}}
            <div class="modal-body" style="padding:28px;">

                {{-- Data Anggota --}}
                <div style="background:#f9fafb;padding:20px;border-radius:12px;margin-bottom:20px;">
                    <h6 style="font-weight:700;color:#374151;font-size:14px;margin-bottom:14px;">
                        <i data-feather="user" style="width:16px;height:16px;"></i> Data Anggota
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Nama Anggota</div>
                            <div style="font-weight:700;color:#111827;font-size:14px;">{{ $detailPeminjaman->anggota->nama_anggota }}</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Jenis Anggota</div>
                            <div style="font-weight:700;color:#111827;font-size:14px;">{{ ucfirst($detailPeminjaman->anggota->jenis_anggota) }}</div>
                        </div>
                    </div>
                </div>

                {{-- Info Transaksi --}}
                <div style="background:#dbeafe;padding:20px;border-radius:12px;margin-bottom:20px;">
                    <h6 style="font-weight:700;color:#374151;font-size:14px;margin-bottom:14px;">
                        <i data-feather="calendar" style="width:16px;height:16px;"></i> Info Transaksi
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Tanggal Pinjam</div>
                            <div style="font-weight:700;color:#111827;font-size:13px;">{{ \Carbon\Carbon::parse($detailPeminjaman->tgl_pinjam)->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Tanggal Kembali</div>
                            <div style="font-weight:700;color:#111827;font-size:13px;">{{ $tgl_kembali_detail ? \Carbon\Carbon::parse($tgl_kembali_detail)->format('d M Y') : '-' }}</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Diproses Oleh</div>
                            <div style="font-weight:700;color:#111827;font-size:13px;">{{ optional($detailPeminjaman->user)->nama_user ?? '(user dihapus)' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Buku --}}
                <div style="margin-bottom:20px;">
                    <h6 style="font-weight:700;color:#374151;font-size:14px;margin-bottom:12px;">
                        <i data-feather="book-open" style="width:16px;height:16px;"></i>
                        Daftar Buku ({{ $detailPeminjaman->jumlah_peminjaman }})
                    </h6>
                    <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                        <table class="table mb-0" style="font-size:13px;">
                            <thead style="background:#f9fafb;">
                                <tr>
                                    <th style="padding:12px;font-weight:700;color:#4b5563;border-bottom:2px solid #e5e7eb;">Judul Buku</th>
                                    <th style="padding:12px;text-align:center;font-weight:700;color:#4b5563;border-bottom:2px solid #e5e7eb;width:110px;">Kondisi</th>
                                    <th style="padding:12px;text-align:right;font-weight:700;color:#4b5563;border-bottom:2px solid #e5e7eb;width:130px;">Denda Item</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailPeminjaman->detailPeminjaman as $detail)
                                <tr style="border-bottom:1px solid #f3f4f6;">
                                    <td style="padding:12px;color:#374151;font-weight:600;">
                                        <div>{{ $detail->eksemplar->buku->judul }}</div>
                                        <div style="font-size:11px;color:#6b7280;font-family:monospace;">{{ $detail->eksemplar->kode_eksemplar }}</div>
                                    </td>
                                    <td style="padding:12px;text-align:center;">
                                        @if($detail->kondisi_kembali === 'rusak')
                                            <span style="background:#fed7aa;color:#92400e;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:700;">RUSAK</span>
                                        @elseif($detail->kondisi_kembali === 'hilang')
                                            <span style="background:#fecaca;color:#991b1b;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:700;">HILANG</span>
                                        @else
                                            <span style="background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:700;">BAIK</span>
                                        @endif
                                    </td>
                                    <td style="padding:12px;text-align:right;color:{{ $detail->denda_item > 0 ? '#dc2626' : '#6b7280' }};font-weight:{{ $detail->denda_item > 0 ? '700' : '400' }};">
                                        Rp {{ number_format($detail->denda_item,0,',','.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Rincian Denda --}}
                @if($detailPeminjaman->denda_total > 0)
                <div style="background:#fee2e2;padding:20px;border-radius:12px;border-left:4px solid #dc2626;">
                    <h6 style="font-weight:700;color:#991b1b;font-size:14px;margin-bottom:12px;">
                        <i data-feather="alert-circle" style="width:16px;height:16px;"></i> Rincian Denda
                    </h6>
                    <div style="font-size:13px;color:#991b1b;line-height:2;">
                        @if($denda_keterlambatan > 0)
                        <div style="display:flex;justify-content:space-between;">
                            <span>Denda Keterlambatan ({{ $hari_terlambat }} hari × {{ $detailPeminjaman->jumlah_peminjaman }} buku)</span>
                            <span style="font-weight:700;">Rp {{ number_format($denda_keterlambatan,0,',','.') }}</span>
                        </div>
                        @endif
                        @if($denda_kerusakan > 0)
                        <div style="display:flex;justify-content:space-between;">
                            <span>Denda Kerusakan / Hilang</span>
                            <span style="font-weight:700;">Rp {{ number_format($denda_kerusakan,0,',','.') }}</span>
                        </div>
                        @endif
                        <div style="display:flex;justify-content:space-between;padding-top:12px;margin-top:8px;border-top:2px solid rgba(220,38,38,.3);font-size:15px;">
                            <span style="font-weight:700;">Total Denda</span>
                            <span style="font-weight:700;">Rp {{ number_format($detailPeminjaman->denda_total,0,',','.') }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($detailPeminjaman->status_pembayaran === 'belum_dibayar')
                            <span class="hpeng-badge-belum">BELUM LUNAS</span>
                        @else
                            <span class="hpeng-badge-lunas">SUDAH LUNAS</span>
                        @endif
                    </div>
                </div>
                @else
                <div style="background:#f0fdf4;padding:16px 20px;border-radius:12px;border-left:4px solid #10b981;">
                    <span style="color:#065f46;font-weight:600;font-size:14px;">
                        <i data-feather="check-circle" style="width:16px;height:16px;vertical-align:middle;"></i>
                        Tidak ada denda pada transaksi ini
                    </span>
                </div>
                @endif

            </div>

            <div class="modal-footer" style="border-top:1px solid #e5e7eb;padding:16px 28px;background:#f9fafb;border-radius:0 0 16px 16px;">
                <button type="button" wire:click="closeDetail" class="hpeng-btn" style="padding:10px 24px;">
                    Tutup
                </button>
                @if($isPustakawan && $detailPeminjaman->denda_total > 0 && $detailPeminjaman->status_pembayaran === 'belum_dibayar')
                <button wire:click="markAsPaid({{ $detailPeminjaman->id_peminjaman }})"
                        wire:confirm="Konfirmasi pembayaran denda Rp {{ number_format($detailPeminjaman->denda_total,0,',','.') }}?"
                        class="hpeng-btn-bayar" style="padding:10px 24px;">
                    <i data-feather="dollar-sign" style="width:16px;height:16px;"></i> Tandai Lunas
                </button>
                @endif
            </div>

        </div>
    </div>
</div>
@endif

</div>
