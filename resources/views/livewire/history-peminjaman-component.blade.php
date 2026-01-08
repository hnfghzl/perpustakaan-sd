<div>
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 16px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(139, 92, 246, 0.2); margin-bottom: 16px;">
            <div style="color: white; display: flex; align-items: center; gap: 10px;">
                <i data-feather="archive" style="width: 22px; height: 22px; color: white;"></i>
                @php
                    $totalHistory = $peminjaman->total();
                    $activeCount = $peminjaman->where('status_buku', 'dipinjam')->count();
                    $returnedCount = $peminjaman->where('status_buku', 'kembali')->count();
                @endphp
                <h4 style="margin: 0; font-weight: 600; font-size: 18px;">History Peminjaman 
                    <span style="opacity: 0.85; font-weight: 400; font-size: 14px; margin-left: 8px;">
                        ({{ $totalHistory }} transaksi @if($activeCount > 0) • <span style="color: #fef3c7;">{{ $activeCount }} aktif</span>@endif)
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
                    <select wire:model.live="filterStatus" class="form-select" style="display: block; width: 100%; height: 38px; padding: 8px 12px; font-size: 14px; font-weight: 600; line-height: 1.5; color: #000 !important; background-color: #ffffff !important; border: 2px solid #ced4da; border-radius: 6px; -webkit-appearance: menulist; -moz-appearance: menulist;">
                        <option value="" selected style="color: #000; font-weight: 600;">-- Pilih Status --</option>
                        <option value="dipinjam" style="color: #000;">Masih Dipinjam</option>
                        <option value="kembali" style="color: #000;">Sudah Dikembalikan</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- History List --}}
        <div class="list-group" style="border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
            @forelse($peminjaman as $index => $data)
            @php
                $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo);
                $tgl_sekarang = \Carbon\Carbon::now()->startOfDay();
                $is_aktif = $data->status_buku === 'dipinjam';
                $terlambat = $is_aktif && $tgl_sekarang->gt($tgl_tempo);
                $hari_terlambat = $terlambat ? (int)$tgl_tempo->diffInDays($tgl_sekarang) : 0;
            @endphp
            <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 12px 16px; transition: all 0.2s; background: {{ $terlambat ? 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)' : 'white' }};">
                <div class="row align-items-center">
                    {{-- Column 1: Transaction Info (30%) --}}
                    <div class="col-md-4">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="background: linear-gradient(135deg, {{ $is_aktif ? ($terlambat ? '#ef4444 0%, #dc2626' : '#f59e0b 0%, #d97706') : '#10b981 0%, #059669' }} 100%); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-feather="{{ $is_aktif ? 'book-open' : 'check-circle' }}" style="width: 18px; height: 18px; color: white;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: {{ $is_aktif ? ($terlambat ? '#dc2626' : '#d97706') : '#059669' }}; font-size: 13px; margin-bottom: 2px;">{{ $data->kode_transaksi }}</div>
                                <div style="color: #374151; font-size: 13px; font-weight: 500; margin-bottom: 2px;">{{ $data->anggota->nama_anggota }}</div>
                                <div style="font-size: 11px; color: #6b7280;">
                                    <i data-feather="user" style="width: 11px; height: 11px;"></i> {{ $data->user->nama_user }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Column 2: Dates & Books (25%) --}}
                    <div class="col-md-3">
                        <div style="font-size: 11px; color: #6b7280; line-height: 1.6;">
                            <div style="margin-bottom: 3px;">
                                <i data-feather="calendar" style="width: 11px; height: 11px;"></i> {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}
                            </div>
                            <div style="margin-bottom: 3px; {{ $terlambat ? 'color: #dc2626; font-weight: 600;' : '' }}">
                                <i data-feather="clock" style="width: 11px; height: 11px;"></i> Tempo: {{ \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->format('d/m/Y') }}
                            </div>
                            @if($terlambat)
                            <div style="color: #dc2626; font-weight: 600;">
                                <i data-feather="alert-triangle" style="width: 11px; height: 11px;"></i> Terlambat {{ $hari_terlambat }} hari
                            </div>
                            @endif
                            <div>
                                <i data-feather="book" style="width: 11px; height: 11px;"></i> <strong>{{ $data->jumlah_peminjaman }}</strong> buku
                            </div>
                        </div>
                    </div>

                    {{-- Column 3: Status (20%) --}}
                    <div class="col-md-3">
                        @if($is_aktif)
                            @if($terlambat)
                                <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600; padding: 5px 12px; border-radius: 6px; font-size: 11px; display: inline-block;">⚠️ Terlambat</span>
                            @else
                                <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 5px 12px; border-radius: 6px; font-size: 11px; display: inline-block;">📚 Dipinjam</span>
                            @endif
                        @else
                            <div style="font-size: 11px; line-height: 1.6;">
                                <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 11px; display: inline-block; margin-bottom: 4px;">✅ Dikembalikan</span>
                                @if($data->denda_total > 0)
                                <div style="color: #dc2626; font-size: 11px; font-weight: 600;">
                                    Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Column 4: Actions (22%) --}}
                    <div class="col-md-2">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                            <button wire:click="viewDetail({{ $data->id_peminjaman }})" class="btn btn-sm" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px;">
                                <i data-feather="eye" style="width: 12px; height: 12px;"></i> Detail
                            </button>
                            @if($isPustakawan)
                                @if($data->status_buku === 'kembali')
                                    <button wire:click="destroy({{ $data->id_peminjaman }})" wire:confirm="Yakin hapus peminjaman {{ $data->kode_transaksi }}?" class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px;">
                                        <i data-feather="trash-2" style="width: 12px; height: 12px;"></i> Hapus
                                    </button>
                                @else
                                    <button class="btn-secondary" disabled title="Kembalikan buku terlebih dahulu" style="background: #9ca3af; color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px; cursor: not-allowed; opacity: 0.6;">
                                        <i data-feather="lock" style="width: 12px; height: 12px;"></i> Terkunci
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="padding: 40px 20px; text-align: center; background: white;">
                <i data-feather="inbox" style="width: 48px; height: 48px; color: #d1d5db;"></i>
                <p style="color: #9ca3af; margin: 12px 0 0 0; font-size: 14px;">Tidak ada history peminjaman</p>
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
            <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h6 style="margin: 0; color: white; font-weight: 600; display: flex; align-items: center; font-size: 16px;">
                    <i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Detail Peminjaman: {{ $detailPeminjaman->kode_transaksi }}
                </h6>
                <button wire:click="closeDetail" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
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
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Jatuh Tempo</div>
                        <div style="font-weight: 600; color: #1f2937; font-size: 13px;">{{ \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo)->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Diproses Oleh</div>
                        <div style="font-weight: 600; color: #1f2937; font-size: 13px;">{{ $detailPeminjaman->user->nama_user }}</div>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div style="margin-bottom: 16px;">
                    @if($detailPeminjaman->status_buku === 'dipinjam')
                        <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 6px 14px; border-radius: 8px; font-size: 12px; display: inline-block;">
                            📚 Masih Dipinjam
                        </span>
                    @else
                        <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 6px 14px; border-radius: 8px; font-size: 12px; display: inline-block;">
                            ✅ Sudah Dikembalikan
                        </span>
                    @endif
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
                                    <th style="padding: 10px; text-align: left; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb;">Kode</th>
                                    <th style="padding: 10px; text-align: left; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb;">Judul Buku</th>
                                    <th style="padding: 10px; text-align: center; font-weight: 600; color: #4b5563; border-bottom: 1px solid #e5e7eb; width: 100px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailPeminjaman->detailPeminjaman as $detail)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 10px; color: #6b7280; font-family: monospace; font-size: 11px;">{{ $detail->eksemplar->kode_eksemplar }}</td>
                                    <td style="padding: 10px; color: #374151; font-weight: 500;">{{ $detail->eksemplar->buku->judul }}</td>
                                    <td style="padding: 10px; text-align: center;">
                                        @if($detail->eksemplar->status_eksemplar === 'dipinjam')
                                            <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">📚 Dipinjam</span>
                                        @else
                                            <span style="background: #d1fae5; color: #065f46; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">✅ Tersedia</span>
                                        @endif
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
    @endif
</div>

@assets
<script>
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            setTimeout(function() {
                feather.replace();
            }, 150);
        }
    };
</script>
@endassets

@script
<script>
    refreshFeatherIcons();

    Livewire.hook('element.init', function() { refreshFeatherIcons(); });
    Livewire.hook('element.updated', function() { refreshFeatherIcons(); });
    Livewire.hook('morph.updated', function() { refreshFeatherIcons(); });
    Livewire.hook('commit', function() { refreshFeatherIcons(); });

    const observer = new MutationObserver(function() { refreshFeatherIcons(); });
    observer.observe(document.body, { childList: true, subtree: true });
</script>
@endscript
