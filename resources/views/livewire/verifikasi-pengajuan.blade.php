<div>
<style>
    .vp-card { background:#fff; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,.04); overflow:visible; }
    .vp-btn  { background:#f3f4f6; color:#374151; border:none; padding:8px 14px; border-radius:8px;
               font-weight:600; font-size:13px; transition:all .2s; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .vp-btn:hover { background:#e5e7eb; transform:translateY(-1px); }
    .vp-btn-setuju { background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none; padding:8px 16px;
                     border-radius:8px; font-weight:600; font-size:13px; transition:all .2s;
                     display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .vp-btn-setuju:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(16,185,129,.3); color:#fff; }
    .vp-btn-tolak  { background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border:none; padding:8px 16px;
                     border-radius:8px; font-weight:600; font-size:13px; transition:all .2s;
                     display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .vp-btn-tolak:hover  { transform:translateY(-1px); box-shadow:0 4px 12px rgba(239,68,68,.3); color:#fff; }
    .vp-badge-menunggu { background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe;
                         padding:5px 12px; border-radius:8px; font-size:12px; font-weight:700; }
</style>

{{-- Alerts --}}
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show"
     style="border-radius:12px;border-left:4px solid #10b981;background:#f0fdf4;">
    <i data-feather="check-circle" style="width:18px;height:18px;color:#059669;"></i>
    <span style="color:#065f46;font-weight:500;margin-left:8px;">{{ session('success') }}</span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show"
     style="border-radius:12px;border-left:4px solid #ef4444;background:#fef2f2;">
    <i data-feather="x-circle" style="width:18px;height:18px;color:#dc2626;"></i>
    <span style="color:#991b1b;font-weight:500;margin-left:8px;">{{ session('error') }}</span>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

{{-- Main Card --}}
<div class="vp-card">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#3b82f6,#2563eb);padding:24px 28px;border-radius:16px 16px 0 0;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 style="color:#fff;font-weight:700;font-size:20px;margin:0 0 4px;display:flex;align-items:center;gap:10px;">
                    <i data-feather="clipboard" style="width:24px;height:24px;"></i>
                    Verifikasi Pengajuan Peminjaman
                </h5>
                <small style="color:rgba(255,255,255,.9);font-size:14px;">
                    @if($totalMenunggu > 0)
                        <span style="color:#fef3c7;font-weight:700;">{{ $totalMenunggu }} pengajuan</span> menunggu verifikasi Anda
                    @else
                        Tidak ada pengajuan yang menunggu
                    @endif
                </small>
            </div>
        </div>
    </div>

    <div style="padding:28px;">

        {{-- Search --}}
        <div style="margin-bottom:20px;max-width:480px;">
            <div style="position:relative;">
                <i data-feather="search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);
                   width:18px;height:18px;color:#6b7280;pointer-events:none;"></i>
                <input type="text" wire:model.live.debounce.350ms="search"
                       placeholder="Cari kode transaksi atau nama anggota..."
                       style="width:100%;border:2px solid #e5e7eb;border-radius:10px;
                              padding:12px 16px 12px 44px;font-size:14px;
                              box-shadow:0 2px 6px rgba(0,0,0,.05);outline:none;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='#e5e7eb'">
            </div>
        </div>

        {{-- List --}}
        <div class="list-group" style="border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
            @forelse($pengajuan as $data)
            <div class="list-group-item"
                 style="border:none;border-bottom:1px solid #f3f4f6;padding:18px 24px;transition:background .15s;"
                 onmouseover="this.style.background='#f9fafb'"
                 onmouseout="this.style.background='white'">
                <div class="row align-items-center">

                    {{-- Kolom 1: Info Anggota --}}
                    <div class="col-md-4">
                        <div style="display:flex;align-items:center;gap:14px;">
                            <div style="width:44px;height:44px;border-radius:12px;
                                        background:linear-gradient(135deg,#3b82f6,#2563eb);
                                        display:flex;align-items:center;justify-content:center;
                                        color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                                {{ strtoupper(substr($data->anggota->nama_anggota,0,1)) }}
                            </div>
                            <div style="min-width:0;">
                                <div style="font-weight:700;color:#111827;font-size:14px;">
                                    {{ $data->anggota->nama_anggota }}
                                </div>
                                <div style="font-size:12px;color:#6b7280;">
                                    {{ ucfirst($data->anggota->jenis_anggota) }}
                                    @if($data->anggota->nis) · {{ $data->anggota->nis }} @endif
                                </div>
                                <div style="font-size:11px;color:#9ca3af;font-family:monospace;margin-top:2px;">
                                    {{ $data->kode_transaksi }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom 2: Buku --}}
                    <div class="col-md-4">
                        <div style="font-size:13px;color:#374151;line-height:1.7;">
                            @foreach($data->detailPeminjaman->take(3) as $d)
                                <div>📖 {{ $d->eksemplar?->buku?->judul ?? '-' }}</div>
                            @endforeach
                            @if($data->detailPeminjaman->count() > 3)
                                <div style="color:#9ca3af;font-size:11px;">
                                    +{{ $data->detailPeminjaman->count()-3 }} buku lainnya
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom 3: Waktu & Status --}}
                    <div class="col-md-2">
                        <span class="vp-badge-menunggu">⏳ Menunggu</span>
                        <div style="font-size:12px;color:#9ca3af;margin-top:6px;">
                            <i data-feather="clock" style="width:12px;height:12px;"></i>
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Kolom 4: Aksi --}}
                    <div class="col-md-2 text-right">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;"
                             x-data x-init="$nextTick(()=>feather.replace())">
                            <button wire:click="lihatDetail({{ $data->id_peminjaman }})"
                                    class="vp-btn" title="Lihat Detail">
                                <i data-feather="eye" style="width:15px;height:15px;"></i>
                            </button>
                            <button wire:click="setujui({{ $data->id_peminjaman }})"
                                    wire:confirm="Setujui pengajuan {{ $data->kode_transaksi }}?"
                                    class="vp-btn-setuju" title="Setujui">
                                <i data-feather="check" style="width:15px;height:15px;"></i>
                            </button>
                            <button wire:click="bukaTolak({{ $data->id_peminjaman }})"
                                    class="vp-btn-tolak" title="Tolak">
                                <i data-feather="x" style="width:15px;height:15px;"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="list-group-item text-center"
                 style="padding:60px 24px;border:none;background:#f9fafb;">
                <i data-feather="inbox" style="width:52px;height:52px;color:#9ca3af;
                   margin-bottom:14px;display:block;margin-left:auto;margin-right:auto;"></i>
                <p style="color:#6b7280;font-size:15px;margin:0;font-weight:600;">
                    Tidak ada pengajuan yang menunggu verifikasi
                </p>
                <small style="color:#9ca3af;">
                    Pengajuan dari anggota akan muncul di sini
                </small>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($pengajuan->hasPages())
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <small style="color:#6b7280;font-size:13px;">
                Menampilkan {{ $pengajuan->firstItem() }}–{{ $pengajuan->lastItem() }}
                dari {{ $pengajuan->total() }} pengajuan
            </small>
            <nav>{{ $pengajuan->links() }}</nav>
        </div>
        @endif

    </div>
</div>

{{-- ══ MODAL DETAIL ══ --}}
@if($showDetail && $detailPeminjaman)
<div style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1050;
            display:flex;align-items:center;justify-content:center;padding:1rem;"
     wire:click.self="tutupDetail">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:560px;
                max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#3b82f6,#2563eb);padding:20px 24px;
                    border-radius:16px 16px 0 0;display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h5 style="color:#fff;font-weight:700;font-size:17px;margin:0;">
                    <i data-feather="file-text" style="width:20px;height:20px;"></i>
                    Detail Pengajuan
                </h5>
                <p style="color:rgba(255,255,255,.85);font-size:13px;margin:4px 0 0;">
                    {{ $detailPeminjaman->kode_transaksi }}
                </p>
            </div>
            <button wire:click="tutupDetail"
                    style="background:rgba(255,255,255,.2);border:none;color:#fff;
                           width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:18px;">
                &times;
            </button>
        </div>

        <div style="padding:24px;">

            {{-- Data Anggota --}}
            <div style="background:#f9fafb;padding:16px;border-radius:12px;margin-bottom:16px;">
                <h6 style="font-weight:700;color:#374151;font-size:13px;margin-bottom:12px;">
                    <i data-feather="user" style="width:15px;height:15px;"></i> Data Peminjam
                </h6>
                <div class="row" style="font-size:13px;">
                    <div class="col-6 mb-2">
                        <div style="color:#6b7280;font-size:11px;margin-bottom:3px;">Nama</div>
                        <div style="font-weight:700;color:#111827;">{{ $detailPeminjaman->anggota->nama_anggota }}</div>
                    </div>
                    <div class="col-6 mb-2">
                        <div style="color:#6b7280;font-size:11px;margin-bottom:3px;">Jenis</div>
                        <div style="font-weight:600;color:#374151;">{{ ucfirst($detailPeminjaman->anggota->jenis_anggota) }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px;margin-bottom:3px;">NIS / ID</div>
                        <div style="font-weight:600;color:#374151;">{{ $detailPeminjaman->anggota->nis ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px;margin-bottom:3px;">Diajukan</div>
                        <div style="font-weight:600;color:#374151;">
                            {{ $detailPeminjaman->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Buku --}}
            <div style="margin-bottom:20px;">
                <h6 style="font-weight:700;color:#374151;font-size:13px;margin-bottom:12px;">
                    <i data-feather="book-open" style="width:15px;height:15px;"></i>
                    Buku yang Diajukan ({{ $detailPeminjaman->jumlah_peminjaman }})
                </h6>
                <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    @foreach($detailPeminjaman->detailPeminjaman as $detail)
                    <div style="padding:12px 16px;{{ !$loop->last ? 'border-bottom:1px solid #f3f4f6;' : '' }}
                                display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;background:#dbeafe;border-radius:8px;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i data-feather="book" style="width:16px;height:16px;color:#2563eb;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-weight:600;font-size:13px;color:#111827;">
                                {{ $detail->eksemplar?->buku?->judul ?? '-' }}
                            </div>
                            <div style="font-size:12px;color:#6b7280;">
                                Kode: {{ $detail->eksemplar?->kode_eksemplar ?? '-' }}
                                · Rak: {{ $detail->eksemplar?->lokasi_rak ?? '-' }}
                            </div>
                        </div>
                        {{-- Status eksemplar --}}
                        @php $statusEks = $detail->eksemplar?->status_eksemplar; @endphp
                        @if($statusEks === 'tersedia')
                            <span style="background:#d1fae5;color:#065f46;padding:3px 10px;
                                         border-radius:6px;font-size:11px;font-weight:700;">TERSEDIA</span>
                        @else
                            <span style="background:#fef2f2;color:#991b1b;padding:3px 10px;
                                         border-radius:6px;font-size:11px;font-weight:700;">
                                {{ strtoupper($statusEks ?? 'N/A') }}
                            </span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display:flex;gap:10px;">
                <button wire:click="tutupDetail" class="vp-btn" style="flex:1;justify-content:center;padding:11px;">
                    Tutup
                </button>
                <button wire:click="bukaTolak({{ $detailPeminjaman->id_peminjaman }})"
                        class="vp-btn-tolak" style="flex:1;justify-content:center;padding:11px;">
                    <i data-feather="x-circle" style="width:16px;height:16px;"></i> Tolak
                </button>
                <button wire:click="setujui({{ $detailPeminjaman->id_peminjaman }})"
                        wire:confirm="Setujui pengajuan {{ $detailPeminjaman->kode_transaksi }}?"
                        class="vp-btn-setuju" style="flex:1;justify-content:center;padding:11px;">
                    <i data-feather="check-circle" style="width:16px;height:16px;"></i> Setujui
                </button>
            </div>

        </div>
    </div>
</div>
@endif

{{-- ══ MODAL TOLAK ══ --}}
@if($showTolakModal)
<div style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1060;
            display:flex;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:420px;
                box-shadow:0 20px 60px rgba(0,0,0,.25);overflow:hidden;">
        <div style="background:linear-gradient(135deg,#ef4444,#dc2626);padding:20px 24px;
                    border-radius:16px 16px 0 0;">
            <h5 style="color:#fff;font-weight:700;font-size:17px;margin:0;">
                <i data-feather="x-circle" style="width:20px;height:20px;"></i>
                Tolak Pengajuan
            </h5>
            <p style="color:rgba(255,255,255,.85);font-size:13px;margin:4px 0 0;">
                Anggota akan diberitahu via WhatsApp
            </p>
        </div>
        <div style="padding:24px;">
            <label style="font-size:13px;font-weight:700;color:#374151;display:block;margin-bottom:8px;">
                Alasan Penolakan <span style="color:#ef4444;">*</span>
            </label>
            <textarea wire:model="alasanPenolakan" rows="4"
                      placeholder="Contoh: Buku sedang dalam perbaikan, silakan ajukan ulang minggu depan."
                      style="width:100%;border:2px solid #e5e7eb;border-radius:10px;padding:10px 14px;
                             font-size:13px;resize:vertical;outline:none;transition:border-color .15s;"
                      onfocus="this.style.borderColor='#ef4444'"
                      onblur="this.style.borderColor='#e5e7eb'"></textarea>
            @error('alasanPenolakan')
                <div style="color:#dc2626;font-size:12px;margin-top:6px;">{{ $message }}</div>
            @enderror
            <div style="display:flex;gap:10px;margin-top:16px;">
                <button wire:click="tutupTolak" class="vp-btn" style="flex:1;justify-content:center;padding:11px;">
                    Batal
                </button>
                <button wire:click="konfirmasiTolak" class="vp-btn-tolak"
                        style="flex:2;justify-content:center;padding:11px;">
                    <i data-feather="x-circle" style="width:16px;height:16px;"></i>
                    Konfirmasi Tolak
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>
