<div>
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 16px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2); margin-bottom: 16px;">
            <div style="color: white; display: flex; align-items: center; gap: 10px;">
                <i data-feather="clock" style="width: 22px; height: 22px; color: white;"></i>
                @php
                    $totalHistory = $peminjaman->total();
                    $unpaidCount = $peminjaman->where('status_pembayaran', 'belum_dibayar')->where('denda_total', '>', 0)->count();
                @endphp
                <h4 style="margin: 0; font-weight: 600; font-size: 18px;">History Pengembalian 
                    <span style="opacity: 0.85; font-weight: 400; font-size: 14px; margin-left: 8px;">
                        ({{ $totalHistory }} transaksi @if($unpaidCount > 0) • <span style="color: #fef3c7;">{{ $unpaidCount }} belum lunas</span>@endif)
                    </span>
                </h4>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if (session()->has('success'))
        <div class="alert alert-dismissible fade show" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border: none; border-left: 3px solid #10b981; border-radius: 8px; padding: 10px 14px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center;">
                <i data-feather="check-circle" style="width: 16px; height: 16px; color: #065f46; margin-right: 10px;"></i>
                <div style="color: #065f46; flex: 1; font-size: 13px;">{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" style="color: #065f46; opacity: 0.7; padding: 0; margin-left: 10px; font-size: 20px;">&times;</button>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-dismissible fade show" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border: none; border-left: 3px solid #ef4444; border-radius: 8px; padding: 10px 14px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center;">
                <i data-feather="x-circle" style="width: 16px; height: 16px; color: #991b1b; margin-right: 10px;"></i>
                <div style="color: #991b1b; flex: 1; font-size: 13px;">{{ session('error') }}</div>
                <button type="button" class="close" data-dismiss="alert" style="color: #991b1b; opacity: 0.7; padding: 0; margin-left: 10px; font-size: 20px;">&times;</button>
            </div>
        </div>
        @endif

        @if (session()->has('info'))
        <div class="alert alert-dismissible fade show" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: none; border-left: 3px solid #3b82f6; border-radius: 8px; padding: 10px 14px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center;">
                <i data-feather="info" style="width: 16px; height: 16px; color: #1e3a8a; margin-right: 10px;"></i>
                <div style="color: #1e3a8a; flex: 1; font-size: 13px;">{{ session('info') }}</div>
                <button type="button" class="close" data-dismiss="alert" style="color: #1e3a8a; opacity: 0.7; padding: 0; margin-left: 10px; font-size: 20px;">&times;</button>
            </div>
        </div>
        @endif

        {{-- Filter & Search --}}
        <div style="background: white; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 12px;">
            <div class="row">
                <div class="col-md-6">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af;"></i>
                        <input type="text" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." class="form-control" style="width: 100%; padding: 8px 10px 8px 38px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <select wire:model.live="filterPembayaran" class="form-select" style="display: block; width: 100%; height: 38px; padding: 8px 12px; font-size: 14px; font-weight: 600; line-height: 1.5; color: #000 !important; background-color: #ffffff !important; border: 2px solid #ced4da; border-radius: 6px; -webkit-appearance: menulist; -moz-appearance: menulist;">
                        <option value="" selected style="color: #000; font-weight: 600;">-- Pilih Status Pembayaran --</option>
                        <option value="belum_dibayar" style="color: #000;">Belum Lunas</option>
                        <option value="sudah_dibayar" style="color: #000;">Sudah Lunas</option>
                        <option value="tanpa_denda" style="color: #000;">Tanpa Denda</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- History List --}}
        <div class="list-group" style="border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
            @forelse($peminjaman as $index => $data)
            @php
                $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo);
                $tgl_kembali = $data->detailPeminjaman->first()->tgl_kembali ?? null;
                $terlambat_saat_dikembalikan = $tgl_kembali && \Carbon\Carbon::parse($tgl_kembali)->gt($tgl_tempo);
                $has_denda = $data->denda_total > 0;
            @endphp
            <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 12px 16px; transition: all 0.2s; background: {{ $has_denda && $data->status_pembayaran === 'belum_dibayar' ? 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)' : 'white' }};" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                <div class="row align-items-center">
                    {{-- Column 1: Transaction Info (35%) --}}
                    <div class="col-md-4">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="background: linear-gradient(135deg, {{ $has_denda && $data->status_pembayaran === 'belum_dibayar' ? '#f59e0b 0%, #d97706' : '#10b981 0%, #059669' }} 100%); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-feather="{{ $has_denda && $data->status_pembayaran === 'belum_dibayar' ? 'alert-circle' : 'check-circle' }}" style="width: 18px; height: 18px; color: white;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: {{ $has_denda && $data->status_pembayaran === 'belum_dibayar' ? '#d97706' : '#059669' }}; font-size: 13px; margin-bottom: 2px;">{{ $data->kode_transaksi }}</div>
                                <div style="color: #374151; font-size: 13px; font-weight: 500; margin-bottom: 2px;">{{ $data->anggota->nama_anggota }}</div>
                                <div style="font-size: 11px; color: #6b7280;">
                                    <i data-feather="user" style="width: 11px; height: 11px;"></i> {{ $data->user->nama_user }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Column 2: Dates & Books (30%) --}}
                    <div class="col-md-3">
                        <div style="font-size: 11px; color: #6b7280; line-height: 1.6;">
                            <div style="margin-bottom: 3px;">
                                <i data-feather="calendar" style="width: 11px; height: 11px;"></i> Pinjam: {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}
                            </div>
                            <div style="margin-bottom: 3px;">
                                <i data-feather="check" style="width: 11px; height: 11px;"></i> Kembali: {{ $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d/m/Y') : '-' }}
                            </div>
                            <div>
                                <i data-feather="book" style="width: 11px; height: 11px;"></i> <strong>{{ $data->jumlah_peminjaman }}</strong> buku
                            </div>
                        </div>
                    </div>

                    {{-- Column 3: Denda Info (20%) --}}
                    <div class="col-md-3">
                        @if($data->denda_total > 0)
                            <div style="font-size: 11px; line-height: 1.6;">
                                <div style="color: #dc2626; font-weight: 600; margin-bottom: 3px;">
                                    <i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
                                </div>
                                @if($data->status_pembayaran === 'belum_dibayar')
                                    <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600; padding: 3px 8px; border-radius: 6px; font-size: 10px; display: inline-block;">💰 Belum Lunas</span>
                                @else
                                    <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 3px 8px; border-radius: 6px; font-size: 10px; display: inline-block;">✅ Lunas</span>
                                @endif
                            </div>
                        @else
                            <div style="font-size: 11px; color: #059669; font-weight: 600;">
                                <i data-feather="check-circle" style="width: 11px; height: 11px;"></i> Tanpa Denda
                            </div>
                        @endif
                    </div>

                    {{-- Column 4: Actions (15%) --}}
                    <div class="col-md-2">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                            <button wire:click="viewDetail({{ $data->id_peminjaman }})" x-data x-init="$nextTick(() => feather.replace())" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(59, 130, 246, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i data-feather="eye" style="width: 12px; height: 12px;"></i> Detail
                            </button>
                            @if($isPustakawan && $data->denda_total > 0 && $data->status_pembayaran === 'belum_dibayar')
                                <button wire:click="markAsPaid({{ $data->id_peminjaman }})" x-data x-init="$nextTick(() => feather.replace())" onclick="return confirm('Konfirmasi pembayaran denda Rp {{ number_format($data->denda_total, 0, ',', '.') }}?')" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(5, 150, 105, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i data-feather="dollar-sign" style="width: 12px; height: 12px;"></i> Bayar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="padding: 40px 20px; text-align: center; background: white;">
                <i data-feather="inbox" style="width: 48px; height: 48px; color: #d1d5db;"></i>
                <p style="color: #9ca3af; margin: 12px 0 0 0; font-size: 14px;">Tidak ada history pengembalian</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($peminjaman->hasPages())
        <div style="background: white; padding: 10px 16px; border-radius: 8px; margin-top: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center;">
            <div style="color: #6b7280; font-size: 12px;">
                <strong style="color: #374151;">{{ $peminjaman->firstItem() ?? 0 }}</strong> - <strong style="color: #374151;">{{ $peminjaman->lastItem() ?? 0 }}</strong> dari <strong style="color: #374151;">{{ $peminjaman->total() }}</strong>
            </div>
            <nav>
                {{ $peminjaman->links() }}
            </nav>
        </div>
        @endif
    </div>

    {{-- Modal Detail --}}
    @if($showDetail && $detailPeminjaman)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1050; padding: 20px;" wire:click.self="closeDetail">
        <div style="background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 800px; width: 100%; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column;">
            {{-- Header --}}
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h6 style="margin: 0; color: white; font-weight: 600; display: flex; align-items: center; font-size: 16px;">
                    <i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Detail Pengembalian: {{ $detailPeminjaman->kode_transaksi }}
                </h6>
                <button wire:click="closeDetail" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(255,255,255,0.2)';">
                    <i data-feather="x" style="width: 18px; height: 18px;"></i>
                </button>
            </div>

            {{-- Body --}}
            <div style="padding: 20px; overflow-y: auto; flex: 1;">
                {{-- Info Anggota --}}
                <div style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); padding: 14px; border-radius: 8px; margin-bottom: 16px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Nama Anggota</div>
                            <div style="font-weight: 600; color: #1f2937; font-size: 14px;">{{ $detailPeminjaman->anggota->nama_anggota }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Jenis Anggota</div>
                            <div style="font-weight: 600; color: #1f2937; font-size: 14px;">{{ ucfirst($detailPeminjaman->anggota->jenis_anggota) }}</div>
                        </div>
                    </div>
                </div>

                {{-- Info Transaksi --}}
                <div class="row" style="margin-bottom: 16px;">
                    <div class="col-md-4">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Tanggal Pinjam</div>
                        <div style="font-weight: 600; color: #1f2937; font-size: 13px;">{{ \Carbon\Carbon::parse($detailPeminjaman->tgl_pinjam)->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Tanggal Kembali</div>
                        <div style="font-weight: 600; color: #1f2937; font-size: 13px;">
                            @php $tgl_kembali = $detailPeminjaman->detailPeminjaman->first()->tgl_kembali ?? null; @endphp
                            {{ $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Diproses Oleh</div>
                        <div style="font-weight: 600; color: #1f2937; font-size: 13px;">{{ $detailPeminjaman->user->nama_user }}</div>
                    </div>
                </div>

                {{-- Daftar Buku --}}
                <div style="margin-bottom: 16px;">
                    <h6 style="font-weight: 600; color: #1f2937; font-size: 14px; margin-bottom: 10px;">
                        <i data-feather="book-open" style="width: 14px; height: 14px;"></i> Daftar Buku ({{ $detailPeminjaman->jumlah_peminjaman }})
                    </h6>
                    <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                        <table style="width: 100%; font-size: 12px;">
                            <thead style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                                <tr>
                                    <th style="padding: 10px; text-align: left; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb;">Judul Buku</th>
                                    <th style="padding: 10px; text-align: center; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; width: 120px;">Kondisi</th>
                                    <th style="padding: 10px; text-align: right; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; width: 120px;">Denda Item</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailPeminjaman->detailPeminjaman as $detail)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 10px; color: #374151;">
                                        <div style="font-weight: 500;">{{ $detail->eksemplar->buku->judul }}</div>
                                        <div style="font-size: 11px; color: #6b7280;">{{ $detail->eksemplar->kode_eksemplar }}</div>
                                    </td>
                                    <td style="padding: 10px; text-align: center;">
                                        @if($detail->kondisi_kembali === 'baik')
                                            <span style="background: #d1fae5; color: #065f46; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">✅ Baik</span>
                                        @elseif($detail->kondisi_kembali === 'rusak')
                                            <span style="background: #fed7aa; color: #92400e; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">⚠️ Rusak</span>
                                        @elseif($detail->kondisi_kembali === 'hilang')
                                            <span style="background: #fecaca; color: #991b1b; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">❌ Hilang</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; text-align: right; color: {{ $detail->denda_item > 0 ? '#dc2626' : '#6b7280' }}; font-weight: {{ $detail->denda_item > 0 ? '600' : '400' }};">
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
                <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); padding: 14px; border-radius: 8px; border-left: 3px solid #dc2626;">
                    <div style="font-weight: 600; color: #991b1b; font-size: 14px; margin-bottom: 8px;">
                        <i data-feather="alert-circle" style="width: 14px; height: 14px;"></i> Rincian Denda
                    </div>
                    @php
                        $denda_keterlambatan = 0;
                        $denda_kerusakan = 0;
                        
                        // Hitung denda keterlambatan
                        $tgl_tempo = \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo);
                        $tgl_kembali_carbon = $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali) : null;
                        if ($tgl_kembali_carbon && $tgl_kembali_carbon->gt($tgl_tempo)) {
                            $hari_terlambat = $tgl_kembali_carbon->diffInDays($tgl_tempo);
                            $denda_keterlambatan = $hari_terlambat * $detailPeminjaman->jumlah_peminjaman * 1000; // Rp 1.000/hari/buku
                        }
                        
                        // Hitung denda kerusakan/hilang
                        $denda_kerusakan = $detailPeminjaman->detailPeminjaman->sum('denda_item');
                    @endphp
                    <div style="font-size: 12px; color: #991b1b; line-height: 1.8;">
                        @if($denda_keterlambatan > 0)
                        <div style="display: flex; justify-content: space-between;">
                            <span>Denda Keterlambatan ({{ $hari_terlambat }} hari × {{ $detailPeminjaman->jumlah_peminjaman }} buku)</span>
                            <span style="font-weight: 600;">Rp {{ number_format($denda_keterlambatan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($denda_kerusakan > 0)
                        <div style="display: flex; justify-content: space-between;">
                            <span>Denda Kerusakan/Hilang</span>
                            <span style="font-weight: 600;">Rp {{ number_format($denda_kerusakan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; padding-top: 8px; margin-top: 8px; border-top: 1px solid rgba(220, 38, 38, 0.2); font-size: 14px;">
                            <span style="font-weight: 600;">Total Denda</span>
                            <span style="font-weight: 700;">Rp {{ number_format($detailPeminjaman->denda_total, 0, ',', '.') }}</span>
                        </div>
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid rgba(220, 38, 38, 0.2);">
                            <span style="font-weight: 600;">Status Pembayaran:</span> 
                            @if($detailPeminjaman->status_pembayaran === 'belum_dibayar')
                                <span style="background: #dc2626; color: white; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">Belum Lunas</span>
                            @else
                                <span style="background: #10b981; color: white; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">Sudah Lunas</span>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 14px; border-radius: 8px; text-align: center; border-left: 3px solid #10b981;">
                    <div style="font-weight: 600; color: #065f46; font-size: 14px;">
                        <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Tidak Ada Denda
                    </div>
                    <div style="font-size: 12px; color: #065f46; margin-top: 4px;">Buku dikembalikan tepat waktu dan dalam kondisi baik</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Feather Icons Refresh --}}
@assets
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

    Livewire.hook('element.init', () => refreshFeatherIcons());
    Livewire.hook('element.updated', () => refreshFeatherIcons());
    Livewire.hook('morph.updated', () => refreshFeatherIcons());
    Livewire.hook('commit', () => refreshFeatherIcons());

    const observer = new MutationObserver(() => refreshFeatherIcons());
    observer.observe(document.body, { childList: true, subtree: true });
});</script>
