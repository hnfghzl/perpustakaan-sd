<div>
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 16px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(26, 188, 156, 0.2); margin-bottom: 16px;">
            <div style="color: white; display: flex; align-items: center; gap: 10px;">
                <i data-feather="rotate-ccw" style="width: 22px; height: 22px; color: white;"></i>
                @php
                    $activeCount = $peminjaman->where('status_buku', 'dipinjam')->count();
                    $unpaidCount = $peminjaman->where('status_buku', 'kembali')->where('status_pembayaran', 'belum_dibayar')->count();
                @endphp
                <h4 style="margin: 0; font-weight: 600; font-size: 18px;">Pengembalian Buku 
                    <span style="opacity: 0.85; font-weight: 400; font-size: 14px; margin-left: 8px;">
                        ({{ $activeCount }} aktif @if($unpaidCount > 0) • <span style="color: #fef3c7;">{{ $unpaidCount }} belum lunas</span>@endif)
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

        {{-- Info Denda --}}
        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 10px 14px; border-radius: 8px; margin-bottom: 12px; border-left: 3px solid #3b82f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #1e3a8a; font-size: 12px;">
                <i data-feather="info" style="width: 14px; height: 14px; color: #1e40af;"></i>
                <strong>Tarif:</strong> Terlambat Rp {{ number_format($tarif_denda_per_hari, 0, ',', '.') }}/hari/buku • Rusak Rp {{ number_format($tarif_denda_rusak, 0, ',', '.') }} • Hilang Rp {{ number_format($tarif_denda_hilang, 0, ',', '.') }}
            </div>
        </div>

        {{-- Filter & Search --}}
        <div style="background: white; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 12px;">
            <div class="row">
                <div class="col-md-6">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af;"></i>
                        <input type="text" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." style="width: 100%; padding: 8px 10px 8px 38px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 2px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="position: relative;">
                        <i data-feather="filter" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af;"></i>
                        <select wire:model.live="filterTerlambat" style="width: 100%; padding: 8px 10px 8px 38px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px; transition: all 0.2s; appearance: none; background: white url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 12 12%22%3E%3Cpath fill=%22%239ca3af%22 d=%22M6 9L1 4h10z%22/%3E%3C/svg%3E') no-repeat right 12px center;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 2px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <option value="">Status: Semua Peminjaman Aktif</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="belum_terlambat">Belum Terlambat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Compact List View --}}
        <div class="list-group" style="border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
            @forelse($peminjaman as $index => $data)
            @php
                $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->startOfDay();
                $tgl_sekarang = \Carbon\Carbon::now()->startOfDay();
                $terlambat = $tgl_sekarang->gt($tgl_tempo);
                $hari_terlambat = $terlambat ? (int)$tgl_tempo->diffInDays($tgl_sekarang) : 0;
            @endphp
            <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 12px 16px; transition: all 0.2s; background: {{ $terlambat ? 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)' : 'white' }};" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                <div class="row align-items-center">
                    {{-- Column 1: Transaction Info (40%) --}}
                    <div class="col-md-5">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="background: linear-gradient(135deg, {{ $terlambat ? '#ef4444 0%, #dc2626' : '#1ABC9C 0%, #16A085' }} 100%); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-feather="{{ $terlambat ? 'alert-circle' : 'file-text' }}" style="width: 18px; height: 18px; color: white;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: {{ $terlambat ? '#dc2626' : '#1ABC9C' }}; font-size: 13px; margin-bottom: 2px;">{{ $data->kode_transaksi }}</div>
                                <div style="color: #374151; font-size: 13px; font-weight: 500; margin-bottom: 2px;">{{ $data->anggota->nama_anggota }}</div>
                                <div style="font-size: 11px; color: #6b7280;">
                                    <i data-feather="user" style="width: 11px; height: 11px;"></i> {{ $data->user->nama_user }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Column 2: Dates & Books (35%) --}}
                    <div class="col-md-4">
                        <div style="font-size: 11px; color: {{ $terlambat && $data->status_buku === 'dipinjam' ? '#991b1b' : '#6b7280' }}; line-height: 1.6;">
                            <div style="margin-bottom: 3px;">
                                <i data-feather="calendar" style="width: 11px; height: 11px;"></i> {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->format('d/m/Y') }}
                            </div>
                            @if($terlambat && $data->status_buku === 'dipinjam')
                            <div style="color: #dc2626; font-weight: 600; margin-bottom: 3px;">
                                <i data-feather="alert-triangle" style="width: 11px; height: 11px;"></i> Terlambat {{ $hari_terlambat }} hari
                            </div>
                            @endif
                            @if($data->status_buku === 'kembali' && $data->denda_total > 0)
                            <div style="color: #dc2626; font-weight: 600; margin-bottom: 3px;">
                                <i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
                            </div>
                            @endif
                            <div>
                                <i data-feather="book" style="width: 11px; height: 11px;"></i> <strong>{{ $data->jumlah_peminjaman }}</strong> buku
                            </div>
                        </div>
                    </div>

                    {{-- Column 3: Status & Actions (25%) --}}
                    <div class="col-md-3">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                            <div style="flex-shrink: 0;">
                                <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 11px; display: inline-block;">📚 Dipinjam</span>
                            </div>
                            @if($isPustakawan)
                                <button wire:click="openReturnForm({{ $data->id_peminjaman }})" x-data x-init="$nextTick(() => feather.replace())" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; transition: all 0.2s; cursor: pointer; white-space: nowrap;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(22, 160, 133, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i data-feather="check-circle" style="width: 13px; height: 13px;"></i> Kembalikan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="padding: 40px 20px; text-align: center; background: white;">
                <i data-feather="inbox" style="width: 48px; height: 48px; color: #d1d5db;"></i>
                <p style="color: #9ca3af; margin: 12px 0 0 0; font-size: 14px;">Tidak ada peminjaman aktif</p>
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

    {{-- Modal Proses Pengembalian --}}
    @if($showReturnForm && $selectedPeminjaman)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1050; padding: 20px;" wire:click.self="closeReturnForm">
        <div style="background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 900px; width: 100%; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column;">
            {{-- Header --}}
            <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h6 style="margin: 0; color: white; font-weight: 600; display: flex; align-items: center; font-size: 16px;">
                    <i data-feather="rotate-ccw" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Proses Pengembalian Buku
                </h6>
                <button wire:click="closeReturnForm" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(255,255,255,0.2)';">
                    <i data-feather="x" style="width: 18px; height: 18px;"></i>
                </button>
            </div>

            {{-- Body --}}
            <div style="padding: 20px; overflow-y: auto; flex: 1;">
                {{-- Info Peminjaman --}}
                <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 14px 16px; border-radius: 10px; margin-bottom: 16px; border-left: 3px solid #1ABC9C;">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 8px;">
                            <div style="font-size: 11px; color: #065f46; font-weight: 600; margin-bottom: 3px;">Kode Transaksi</div>
                            <div style="font-size: 13px; color: #065f46; font-weight: 700;">{{ $selectedPeminjaman->kode_transaksi }}</div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 8px;">
                            <div style="font-size: 11px; color: #065f46; font-weight: 600; margin-bottom: 3px;">Anggota</div>
                            <div style="font-size: 13px; color: #065f46; font-weight: 600;">
                                {{ $selectedPeminjaman->anggota->nama_anggota }} 
                                <span style="background: #1ABC9C; color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">{{ ucfirst($selectedPeminjaman->anggota->jenis_anggota) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="font-size: 11px; color: #065f46; font-weight: 600; margin-bottom: 3px;">Tgl Pinjam</div>
                            <div style="font-size: 12px; color: #065f46;">{{ \Carbon\Carbon::parse($selectedPeminjaman->tgl_pinjam)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="font-size: 11px; color: #065f46; font-weight: 600; margin-bottom: 3px;">Jatuh Tempo • Petugas</div>
                            <div style="font-size: 12px; color: #065f46;">{{ \Carbon\Carbon::parse($selectedPeminjaman->tgl_jatuh_tempo)->format('d/m/Y') }} • {{ $selectedPeminjaman->user->nama_user }}</div>
                        </div>
                    </div>
                </div>

                {{-- Tanggal Kembali --}}
                <div style="margin-bottom: 16px;">
                    <label style="color: #374151; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">
                        Tanggal Kembali <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="date" wire:model.live="tgl_kembali" max="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 13px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 2px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    @error('tgl_kembali')<div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>@enderror
                </div>

                {{-- Daftar Buku --}}
                <h6 style="color: #374151; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; font-size: 14px;">
                    <i data-feather="book" style="width: 16px; height: 16px; margin-right: 8px; color: #1ABC9C;"></i>
                    Daftar Buku yang Dikembalikan
                </h6>
                <div style="margin-bottom: 16px;">
                    @foreach($selectedPeminjaman->detailPeminjaman as $index => $detail)
                    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-bottom: 10px;">
                        <div class="row align-items-center">
                            <div class="col-md-1" style="text-align: center;">
                                <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 12px; margin: 0 auto;">{{ $index + 1 }}</div>
                            </div>
                            <div class="col-md-5">
                                <div style="font-weight: 600; color: #1ABC9C; font-size: 12px; margin-bottom: 2px;">{{ $detail->eksemplar->kode_eksemplar }}</div>
                                <div style="font-weight: 600; color: #374151; font-size: 13px; margin-bottom: 2px;">{{ $detail->eksemplar->buku->judul }}</div>
                                <div style="font-size: 11px; color: #6b7280;">{{ $detail->eksemplar->buku->no_panggil }}</div>
                            </div>
                            <div class="col-md-3">
                                <select wire:model.live="detailItems.{{ $detail->id_detail }}.kondisi_kembali" style="width: 100%; padding: 6px 10px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 12px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C';" onblur="this.style.borderColor='#e5e7eb';">
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="col-md-3" style="text-align: right;">
                                @if($detailItems[$detail->id_detail]['kondisi_kembali'] !== 'baik')
                                <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 11px; display: inline-block;">
                                    Rp {{ number_format($detailItems[$detail->id_detail]['denda_item'], 0, ',', '.') }}
                                </span>
                                @else
                                <span style="color: #9ca3af; font-size: 12px;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Ringkasan Denda --}}
                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 14px 16px; border-radius: 10px; border-left: 3px solid #f59e0b;">
                    <h6 style="color: #78350f; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                        <i data-feather="alert-circle" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                        Ringkasan Denda
                    </h6>
                    @php
                        $tgl_tempo = \Carbon\Carbon::parse($selectedPeminjaman->tgl_jatuh_tempo)->startOfDay();
                        $tgl_kembali_carbon = \Carbon\Carbon::parse($tgl_kembali)->startOfDay();
                        $hari = $tgl_kembali_carbon->gt($tgl_tempo) ? (int)$tgl_tempo->diffInDays($tgl_kembali_carbon) : 0;
                    @endphp
                    <div style="background: rgba(255,255,255,0.7); padding: 10px 12px; border-radius: 8px; margin-bottom: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <div style="color: #78350f; font-size: 12px; font-weight: 600;">Denda Keterlambatan:</div>
                            <div style="font-size: 11px; color: #92400e;">
                                @if($hari > 0)
                                    {{ $hari }} hari × {{ $selectedPeminjaman->jumlah_peminjaman }} buku × Rp {{ number_format($tarif_denda_per_hari, 0, ',', '.') }}
                                @else
                                    Tidak terlambat
                                @endif
                            </div>
                            <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                                Rp {{ number_format($denda_keterlambatan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.7); padding: 10px 12px; border-radius: 8px; margin-bottom: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: #78350f; font-size: 12px; font-weight: 600;">Denda Kerusakan/Kehilangan:</div>
                            <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                                Rp {{ number_format($denda_kerusakan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 12px 14px; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: white; font-size: 14px; font-weight: 700;">Total Denda:</div>
                            <div style="color: white; font-size: 16px; font-weight: 700;">
                                Rp {{ number_format($total_denda, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div style="padding: 14px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 10px; background: #f9fafb;">
                <button wire:click="closeReturnForm" style="background: #6b7280; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563';" onmouseout="this.style.background='#6b7280';">
                    <i data-feather="x" style="width: 14px; height: 14px;"></i> Batal
                </button>
                <button wire:click="prosesKembalikan" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Proses Pengembalian
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- SCRIPT FEATHER ICONS --}}
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
