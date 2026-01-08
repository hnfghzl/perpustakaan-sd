<div x-data="{ showExportModal: false }">
    <style>
        .history-card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .history-btn-detail {
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

        .history-btn-detail:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .history-btn-delete {
            background: #fee;
            color: #dc2626;
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

        .history-btn-delete:hover {
            background: #fecaca;
            color: #991b1b;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.2);
        }

        .history-badge-aktif {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .history-badge-terlambat {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .history-badge-kembali {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .history-form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .history-form-control:focus {
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

    {{-- Main Card --}}
    <div class="history-card-modern">
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px 16px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: white; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        <i data-feather="archive" style="width: 24px; height: 24px;"></i>
                        History Peminjaman Buku
                    </h5>
                    @php
                        $totalHistory = $peminjaman->total();
                        $activeCount = $peminjaman->where('status_buku', 'dipinjam')->count();
                    @endphp
                    <small style="color: rgba(255,255,255,0.9); font-size: 14px;">
                        Total: {{ $totalHistory }} transaksi
                        @if($activeCount > 0)
                            <span style="color: #fef3c7; font-weight: 600;"> • {{ $activeCount }} masih dipinjam</span>
                        @endif
                    </small>
                </div>
                <button @click="showExportModal = true" class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 13px;">
                    <i data-feather="download" style="width: 16px; height: 16px;"></i> Export Excel
                </button>
            </div>
        </div>

        <div style="padding: 28px;">
            {{-- Filter & Search --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6b7280; z-index: 10;"></i>
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px 12px 44px; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select form-control" wire:model.live="filterStatus" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; font-size: 14px; font-weight: 600; color: #000 !important; background-color: #fff !important; box-shadow: 0 2px 6px rgba(0,0,0,0.05); cursor: pointer;">
                        <option value="" selected style="color: #000; font-weight: 600;">Semua Status</option>
                        <option value="dipinjam" style="color: #000;">Masih Dipinjam (Aktif)</option>
                        <option value="kembali" style="color: #000;">Sudah Dikembalikan</option>
                    </select>
                </div>
            </div>

            {{-- History List --}}
            <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                @forelse($peminjaman as $data)
                @php
                    $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo);
                    $tgl_sekarang = \Carbon\Carbon::now()->startOfDay();
                    $is_aktif = $data->status_buku === 'dipinjam';
                    $terlambat = $is_aktif && $tgl_sekarang->gt($tgl_tempo);
                    $hari_terlambat = $terlambat ? (int)$tgl_tempo->diffInDays($tgl_sekarang) : 0;
                @endphp
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 20px 24px; transition: all 0.2s; {{ $terlambat ? 'background: #fef2f2;' : '' }}" onmouseover="this.style.background='{{ $terlambat ? '#fee2e2' : '#f9fafb' }}';" onmouseout="this.style.background='{{ $terlambat ? '#fef2f2' : 'white' }}';">
                    <div class="row align-items-center">
                        {{-- Column 1: Transaction Info & Anggota (35%) --}}
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="background: linear-gradient(135deg, {{ $is_aktif ? ($terlambat ? '#ef4444 0%, #dc2626' : '#f59e0b 0%, #d97706') : '#10b981 0%, #059669' }} 100%); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 3px 8px rgba({{ $is_aktif ? ($terlambat ? '239, 68, 68' : '245, 158, 11') : '16, 185, 129' }}, 0.25);">
                                    <i data-feather="{{ $is_aktif ? 'book-open' : 'check-circle' }}" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; color: {{ $terlambat ? '#dc2626' : '#111827' }}; font-size: 14px; margin-bottom: 4px;">{{ $data->kode_transaksi }}</div>
                                    <div style="color: #374151; font-size: 14px; font-weight: 600; margin-bottom: 3px;">{{ $data->anggota->nama_anggota }}</div>
                                    <div style="font-size: 12px; color: #6b7280;">
                                        <i data-feather="user" style="width: 12px; height: 12px;"></i> {{ $data->user->nama_user }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Column 2: Dates & Books Info (30%) --}}
                        <div class="col-md-3">
                            <div style="font-size: 13px; color: #6b7280; line-height: 1.8;">
                                <div style="margin-bottom: 4px;">
                                    <i data-feather="calendar" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">Pinjam:</strong> {{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}
                                </div>
                                <div style="margin-bottom: 4px; {{ $terlambat ? 'color: #dc2626; font-weight: 700;' : '' }}">
                                    <i data-feather="clock" style="width: 13px; height: 13px;"></i> 
                                    <strong style="{{ $terlambat ? 'color: #dc2626;' : 'color: #374151;' }}">Tempo:</strong> {{ \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->format('d/m/Y') }}
                                </div>
                                @if($terlambat)
                                <div style="color: #dc2626; font-weight: 700; font-size: 12px;">
                                    <i data-feather="alert-triangle" style="width: 13px; height: 13px;"></i> Terlambat {{ $hari_terlambat }} hari
                                </div>
                                @endif
                                <div style="margin-top: 4px;">
                                    <i data-feather="book" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">{{ $data->jumlah_peminjaman }}</strong> buku
                                </div>
                            </div>
                        </div>

                        {{-- Column 3: Status Badge (20%) --}}
                        <div class="col-md-3">
                            @if($is_aktif)
                                @if($terlambat)
                                    <span class="history-badge-terlambat">TERLAMBAT</span>
                                @else
                                    <span class="history-badge-aktif">DIPINJAM</span>
                                @endif
                            @else
                                <div>
                                    <span class="history-badge-kembali">DIKEMBALIKAN</span>
                                    @if($data->denda_total > 0)
                                    <div style="color: #dc2626; font-size: 12px; font-weight: 700; margin-top: 6px;">
                                        Denda: Rp {{ number_format($data->denda_total, 0, ',', '.') }}
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Column 4: Actions (12%) --}}
                        <div class="col-md-2 text-right">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="cetakStruk({{ $data->id_peminjaman }})" class="history-btn-detail" title="Cetak Struk">
                                    <i data-feather="printer" style="width: 15px; height: 15px;"></i>
                                </button>
                                <button wire:click="viewDetail({{ $data->id_peminjaman }})" class="history-btn-detail" title="Lihat Detail">
                                    <i data-feather="eye" style="width: 15px; height: 15px;"></i>
                                </button>
                                @if($isPustakawan)
                                    @if($data->status_buku === 'kembali')
                                        <button onclick="confirm('Yakin hapus peminjaman {{ $data->kode_transaksi }}?') || event.stopImmediatePropagation()"
                                            wire:click="destroy({{ $data->id_peminjaman }})"
                                            class="history-btn-delete"
                                            title="Hapus Data">
                                            <i data-feather="trash-2" style="width: 15px; height: 15px;"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm" disabled title="Kembalikan buku terlebih dahulu" style="background: #f3f4f6; color: #9ca3af; border: none; padding: 8px 14px; border-radius: 8px; cursor: not-allowed;">
                                            <i data-feather="lock" style="width: 15px; height: 15px;"></i>
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                    <i data-feather="inbox" style="width: 52px; height: 52px; color: #9ca3af; margin-bottom: 14px;"></i>
                    <p style="color: #6b7280; font-size: 15px; margin: 0; font-weight: 600;">Tidak ada history peminjaman</p>
                    <small style="color: #9ca3af; font-size: 13px;">Transaksi yang sudah dibuat akan muncul di sini</small>
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                {{-- Header --}}
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 24px 28px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i data-feather="file-text" style="width: 22px; height: 22px;"></i>
                            Detail Peminjaman
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
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Jatuh Tempo</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;">{{ \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo)->format('d M Y') }}</div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Diproses Oleh</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;">{{ $detailPeminjaman->user->nama_user }}</div>
                            </div>
                        </div>
                        <div style="margin-top: 14px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 6px;">Status Peminjaman</div>
                            @if($detailPeminjaman->status_buku === 'dipinjam')
                                <span class="history-badge-aktif">MASIH DIPINJAM</span>
                            @else
                                <span class="history-badge-kembali">SUDAH DIKEMBALIKAN</span>
                                @if($detailPeminjaman->denda_total > 0)
                                <div style="color: #dc2626; font-size: 13px; font-weight: 700; margin-top: 8px;">
                                    Total Denda: Rp {{ number_format($detailPeminjaman->denda_total, 0, ',', '.') }}
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Daftar Buku --}}
                    <div>
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 12px;">
                            <i data-feather="book-open" style="width: 16px; height: 16px;"></i> Daftar Buku ({{ $detailPeminjaman->jumlah_peminjaman }})
                        </h6>
                        <div style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <table class="table mb-0" style="font-size: 13px;">
                                <thead style="background: #f9fafb;">
                                    <tr>
                                        <th style="padding: 12px; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb;">Kode Eksemplar</th>
                                        <th style="padding: 12px; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb;">Judul Buku</th>
                                        <th style="padding: 12px; text-align: center; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb; width: 120px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailPeminjaman->detailPeminjaman as $detail)
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 12px; color: #6b7280; font-family: monospace; font-size: 12px;">{{ $detail->eksemplar->kode_eksemplar }}</td>
                                        <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $detail->eksemplar->buku->judul }}</td>
                                        <td style="padding: 12px; text-align: center;">
                                            @if($detail->eksemplar->status_eksemplar === 'dipinjam')
                                                <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">DIPINJAM</span>
                                            @else
                                                <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">TERSEDIA</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    console.log('✅ History icons refreshed');
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
        
        // Function untuk print struk dari history
        window.printStrukHistory = function() {
            const strukContent = document.getElementById('strukContentHistory').innerHTML;
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Struk Peminjaman</title>
                    <style>
                        @media print {
                            @page { margin: 15mm; }
                            body { margin: 0; }
                        }
                        body {
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            padding: 20px;
                            max-width: 600px;
                            margin: 0 auto;
                        }
                        * {
                            box-sizing: border-box;
                        }
                    </style>
                </head>
                <body>
                    ${strukContent}
                    <script>
                        setTimeout(function() {
                            window.print();
                            window.onafterprint = function() {
                                window.close();
                            };
                        }, 500);
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
        }
    });</script>

    {{-- Modal Struk Peminjaman --}}
    @if($showStruk && $lastPeminjaman)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;" wire:click="closeStruk">
        <div style="background: white; border-radius: 16px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);" wire:click.stop>
            {{-- Header Modal --}}
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 16px 16px 0 0; position: relative;">
                <button wire:click="closeStruk" style="position: absolute; top: 16px; right: 16px; background: rgba(255, 255, 255, 0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <i data-feather="x" style="width: 20px; height: 20px;"></i>
                </button>
                <h5 style="color: white; margin: 0 0 8px 0; font-weight: 700; font-size: 20px; display: flex; align-items: center;">
                    <i data-feather="file-text" style="width: 24px; height: 24px; margin-right: 10px;"></i>
                    Struk Peminjaman
                </h5>
                <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 13px;">
                    Kode: <strong>{{ $lastPeminjaman->kode_transaksi }}</strong>
                </p>
            </div>

            {{-- Content Struk (untuk print) --}}
            <div id="strukContentHistory" style="padding: 28px;">
                {{-- Header Perpustakaan --}}
                <div style="text-align: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px dashed #e5e7eb;">
                    <h4 style="margin: 0 0 4px 0; font-weight: 700; color: #1f2937; font-size: 18px;">
                        SD Muhammadiyah Karangwaru
                    </h4>
                    <p style="margin: 0; color: #6b7280; font-size: 13px;">
                        Perpustakaan Sekolah
                    </p>
                    <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 12px;">
                        Struk Peminjaman Buku
                    </p>
                </div>

                {{-- Info Transaksi --}}
                <div style="margin-bottom: 24px;">
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="padding: 6px 0; color: #6b7280; width: 140px;">Kode Transaksi</td>
                            <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: {{ $lastPeminjaman->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 0; color: #6b7280;">Tanggal Pinjam</td>
                            <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: {{ \Carbon\Carbon::parse($lastPeminjaman->tgl_pinjam)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 0; color: #6b7280;">Tenggat Kembali</td>
                            <td style="padding: 6px 0; font-weight: 600; color: #dc2626;">: {{ \Carbon\Carbon::parse($lastPeminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 0; color: #6b7280;">Status</td>
                            <td style="padding: 6px 0;">: 
                                @if($lastPeminjaman->status_buku === 'dipinjam')
                                    <span style="background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">Dipinjam</span>
                                @else
                                    <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 0; color: #6b7280;">Petugas</td>
                            <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: {{ $lastPeminjaman->user->nama_user }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Info Anggota --}}
                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 16px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                    <h6 style="margin: 0 0 10px 0; font-weight: 700; color: #1f2937; font-size: 14px; display: flex; align-items: center;">
                        <i data-feather="user" style="width: 16px; height: 16px; margin-right: 8px; color: #3b82f6;"></i>
                        Data Peminjam
                    </h6>
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="padding: 4px 0; color: #6b7280; width: 100px;">Nama</td>
                            <td style="padding: 4px 0; font-weight: 600; color: #1f2937;">: {{ $lastPeminjaman->anggota->nama_anggota }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #6b7280;">Jenis</td>
                            <td style="padding: 4px 0; color: #1f2937;">: {{ ucfirst($lastPeminjaman->anggota->jenis_anggota) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #6b7280;">Institusi</td>
                            <td style="padding: 4px 0; color: #1f2937;">: {{ $lastPeminjaman->anggota->institusi }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Daftar Buku --}}
                <div style="margin-bottom: 24px;">
                    <h6 style="margin: 0 0 12px 0; font-weight: 700; color: #1f2937; font-size: 14px; display: flex; align-items: center;">
                        <i data-feather="book-open" style="width: 16px; height: 16px; margin-right: 8px; color: #3b82f6;"></i>
                        Buku yang Dipinjam ({{ count($lastPeminjaman->detailPeminjaman) }} buku)
                    </h6>
                    @foreach($lastPeminjaman->detailPeminjaman as $index => $detail)
                    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: start; gap: 12px;">
                            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                                {{ $index + 1 }}
                            </div>
                            <div style="flex: 1;">
                                <h6 style="margin: 0 0 6px 0; font-weight: 600; color: #1f2937; font-size: 13px;">
                                    {{ $detail->eksemplar->buku->judul }}
                                </h6>
                                <div style="font-size: 12px; color: #6b7280; line-height: 1.6;">
                                    <div>📖 <strong>Kode Eksemplar:</strong> {{ $detail->eksemplar->kode_eksemplar }}</div>
                                    <div>📚 <strong>No. Panggil:</strong> {{ $detail->eksemplar->buku->no_panggil }}</div>
                                    <div>📍 <strong>Lokasi Rak:</strong> {{ $detail->eksemplar->lokasi_rak }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Informasi Penting --}}
                @if($lastPeminjaman->status_buku === 'dipinjam')
                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 14px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                    <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.6;">
                        <i data-feather="alert-circle" style="width: 14px; height: 14px; margin-right: 6px; display: inline; vertical-align: middle;"></i>
                        <strong>Perhatian:</strong> Harap kembalikan buku tepat waktu sebelum <strong>{{ \Carbon\Carbon::parse($lastPeminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</strong>. 
                        Keterlambatan akan dikenakan denda <strong>Rp 1.000/hari/buku</strong>.
                    </p>
                </div>
                @endif

                {{-- Footer --}}
                <div style="text-align: center; padding-top: 20px; border-top: 2px dashed #e5e7eb;">
                    <p style="margin: 0 0 4px 0; font-size: 12px; color: #6b7280;">
                        Terima kasih telah menggunakan layanan perpustakaan
                    </p>
                    <p style="margin: 0; font-size: 11px; color: #9ca3af;">
                        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="padding: 0 28px 28px 28px; display: flex; gap: 12px;">
                <button onclick="printStrukHistory()" style="flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i data-feather="printer" style="width: 18px; height: 18px;"></i>
                    Cetak Struk
                </button>
                <button wire:click="closeStruk" style="background: #f3f4f6; color: #6b7280; border: none; padding: 14px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Export Excel Modal --}}
    <div x-show="showExportModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 9999;"
         @click.self="showExportModal = false"
         x-cloak>
        
        <div x-show="showExportModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; max-width: 480px; width: 90%; box-shadow: 0 20px 50px rgba(0,0,0,0.3);"
             @click.stop
             x-init="$watch('showExportModal', value => { if(value) setTimeout(() => feather.replace(), 100) })">
            
            {{-- Modal Header --}}
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 20px 24px; border-radius: 16px 16px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: white; font-weight: 700; font-size: 18px; display: flex; align-items: center; gap: 10px;">
                        <i data-feather="download" style="width: 20px; height: 20px;"></i>
                        Export Data Excel
                    </h5>
                    <button @click="showExportModal = false" style="background: rgba(255,255,255,0.2); color: white; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <i data-feather="x" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div style="padding: 24px;">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 20px;">
                    Pilih rentang tanggal untuk export data history peminjaman
                </p>

                <form id="exportForm" method="GET" action="{{ route('history-peminjaman.export') }}">
                    {{-- Hidden inputs untuk search dan status --}}
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="filterStatus" value="{{ $filterStatus }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label style="display: block; color: #374151; font-weight: 600; font-size: 13px; margin-bottom: 8px;">
                                <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Dari Tanggal
                            </label>
                            <input type="date" 
                                   name="filterTglDari" 
                                   wire:model="filterTglDari"
                                   class="form-control" 
                                   style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 14px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="display: block; color: #374151; font-weight: 600; font-size: 13px; margin-bottom: 8px;">
                                <i data-feather="calendar" style="width: 14px; height: 14px;"></i> Sampai Tanggal
                            </label>
                            <input type="date" 
                                   name="filterTglSampai" 
                                   wire:model="filterTglSampai"
                                   class="form-control" 
                                   style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="background: #f9fafb; padding: 14px; border-radius: 10px; margin-top: 16px;">
                        <p style="color: #6b7280; font-size: 12px; margin: 0;">
                            <i data-feather="info" style="width: 14px; height: 14px; color: #3b82f6;"></i>
                            <strong>Info:</strong> Jika tanggal tidak dipilih, semua data akan di-export.
                        </p>
                    </div>

                    {{-- Modal Footer --}}
                    <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" 
                                @click="showExportModal = false" 
                                style="background: #f3f4f6; color: #6b7280; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;">
                            Batal
                        </button>
                        <button type="submit" 
                                style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
                            <i data-feather="download" style="width: 16px; height: 16px;"></i>
                            Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
