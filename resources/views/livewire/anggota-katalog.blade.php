<div>
<style>
/* ── Toast ── */
@keyframes toastIn { from{opacity:0;transform:translateX(-50%) translateY(-14px)} to{opacity:1;transform:translateX(-50%) translateY(0)} }

/* ── Hero Banner ── */
.ak-hero {
    background: linear-gradient(135deg,#2563eb 0%,#3b82f6 50%,#60a5fa 100%);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    color: #fff;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}
.ak-hero::after {
    content:'';
    position:absolute;right:-40px;top:-40px;
    width:160px;height:160px;
    background:rgba(255,255,255,.07);
    border-radius:50%;
}
.ak-hero::before {
    content:'';
    position:absolute;right:40px;bottom:-50px;
    width:120px;height:120px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
}

/* ── Stat Cards ── */
.ak-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:.75rem; margin-bottom:1.25rem; }
.ak-stat {
    background:#fff;
    border-radius:12px;
    border:1px solid #e5e7eb;
    padding:1rem 1.1rem;
    display:flex;align-items:center;gap:.85rem;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
    transition:box-shadow .15s;
}
.ak-stat:hover { box-shadow:0 4px 12px rgba(59,130,246,.1); }
.ak-stat-icon {
    width:44px;height:44px;
    border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.1rem;
    flex-shrink:0;
}
.ak-stat-num { font-size:1.45rem;font-weight:800;line-height:1; color:#0f172a; }
.ak-stat-lbl { font-size:.7rem;color:#94a3b8;font-weight:500;margin-top:.15rem; }

/* ── Search & Filter bar ── */
.ak-toolbar {
    display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;
    background:#fff;border-radius:12px;
    border:1px solid #e5e7eb;
    padding:.85rem 1rem;
    margin-bottom:1.25rem;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
}
.ak-search {
    flex:1;min-width:180px;position:relative;
}
.ak-search input {
    width:100%;border:2px solid #e5e7eb;border-radius:9px;
    padding:.55rem 1rem .55rem 2.3rem;
    font-size:.875rem;outline:none;
    transition:border-color .15s,box-shadow .15s;
    color:#334155;background:#f9fafb;
}
.ak-search input:focus { border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1);background:#fff; }
.ak-search .si { position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.8rem; }
.ak-select {
    border:2px solid #e5e7eb;border-radius:9px;
    padding:.53rem .9rem;font-size:.875rem;
    color:#475569;background:#f9fafb;
    outline:none;cursor:pointer;
    transition:border-color .15s;
    min-width:150px;
}
.ak-select:focus { border-color:#3b82f6;background:#fff; }
.ak-count-pill {
    background:#eff6ff;color:#2563eb;
    border:1px solid #bfdbfe;
    border-radius:20px;padding:.25rem .85rem;
    font-size:.75rem;font-weight:700;white-space:nowrap;
    margin-left:auto;
}
</style>

<style>
/* ── Book Cards ── */
.ak-books { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:1rem; margin-bottom:1.25rem; }
.ak-book {
    background:#fff;border-radius:14px;
    border:2px solid #e5e7eb;
    overflow:hidden;display:flex;flex-direction:column;
    transition:all .2s;cursor:pointer;position:relative;
}
.ak-book:hover { border-color:#93c5fd;box-shadow:0 8px 24px rgba(59,130,246,.12);transform:translateY(-2px); }
.ak-book.selected { border-color:#2563eb;box-shadow:0 8px 24px rgba(37,99,235,.2); }
.ak-book-cover {
    height:110px;display:flex;align-items:center;justify-content:center;
    font-size:2rem;position:relative;
}
.ak-check-badge {
    position:absolute;top:8px;right:8px;
    width:22px;height:22px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border-radius:50%;display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:.6rem;
    box-shadow:0 2px 8px rgba(37,99,235,.4);
}
.ak-book-body { padding:.75rem .8rem;flex:1;display:flex;flex-direction:column;gap:.3rem; }
.ak-book-title { font-weight:700;font-size:.82rem;color:#0f172a;line-height:1.35;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.ak-book-cat { font-size:.68rem;color:#64748b; }
.ak-book-call { font-size:.68rem;color:#94a3b8;font-family:monospace; }
.ak-book-footer { padding:.6rem .8rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:.4rem; }
.ak-badge-ok { background:#dbeafe;color:#1e40af;font-size:.65rem;font-weight:700;padding:.18rem .55rem;border-radius:4px; }
.ak-badge-no { background:#fef2f2;color:#991b1b;font-size:.65rem;font-weight:700;padding:.18rem .55rem;border-radius:4px; }
.ak-btn-pick {
    font-size:.7rem;font-weight:700;border:none;border-radius:6px;
    padding:.28rem .7rem;cursor:pointer;transition:all .15s;white-space:nowrap;
}
.ak-btn-pick.add { background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff; }
.ak-btn-pick.add:hover { box-shadow:0 3px 10px rgba(59,130,246,.35); }
.ak-btn-pick.rem { background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe; }
.ak-btn-pick.dis { background:#f8fafc;color:#cbd5e1;cursor:not-allowed; }

/* Cover color palette per index */
.cov-0 { background:linear-gradient(135deg,#dbeafe,#bfdbfe); }
.cov-1 { background:linear-gradient(135deg,#d1fae5,#a7f3d0); }
.cov-2 { background:linear-gradient(135deg,#fce7f3,#fbcfe8); }
.cov-3 { background:linear-gradient(135deg,#fef3c7,#fde68a); }
.cov-4 { background:linear-gradient(135deg,#ede9fe,#ddd6fe); }
.cov-5 { background:linear-gradient(135deg,#ffedd5,#fed7aa); }

/* ── Floating Cart Bar ── */
.ak-cart {
    position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%);
    background:linear-gradient(135deg,#1e40af,#2563eb);
    color:#fff;border-radius:50px;
    padding:.7rem 1.5rem;
    display:flex;align-items:center;gap:1rem;
    box-shadow:0 8px 28px rgba(37,99,235,.45);
    z-index:500;
    animation:cartIn .25s ease;
    min-width:300px;max-width:90vw;
}
@keyframes cartIn { from{opacity:0;transform:translateX(-50%) translateY(16px)} to{opacity:1;transform:translateX(-50%) translateY(0)} }
.ak-cart-info { flex:1; }
.ak-cart-num { font-size:1rem;font-weight:800;line-height:1; }
.ak-cart-sub { font-size:.7rem;opacity:.8;margin-top:.1rem; }
.ak-cart-btn {
    background:#fff;color:#2563eb;
    border:none;border-radius:30px;
    padding:.5rem 1.25rem;
    font-weight:700;font-size:.83rem;
    cursor:pointer;transition:all .15s;white-space:nowrap;
}
.ak-cart-btn:hover { box-shadow:0 3px 12px rgba(0,0,0,.15); }
.ak-cart-cancel {
    background:rgba(255,255,255,.18);color:#fff;
    border:1px solid rgba(255,255,255,.3);
    border-radius:30px;padding:.5rem .9rem;
    font-size:.75rem;font-weight:600;cursor:pointer;
    white-space:nowrap;
}

/* ── Riwayat Cards ── */
.ak-riwayat { display:flex;flex-direction:column;gap:.75rem; }
.ak-rw-card {
    background:#fff;border-radius:14px;
    border:1px solid #e5e7eb;
    padding:1rem 1.25rem;
    display:flex;align-items:flex-start;gap:1rem;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
    transition:box-shadow .15s;
}
.ak-rw-card:hover { box-shadow:0 4px 14px rgba(0,0,0,.08); }
.ak-rw-icon {
    width:42px;height:42px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    font-size:.95rem;flex-shrink:0;
}
.ak-rw-body { flex:1;min-width:0; }
.ak-rw-kode { font-size:.72rem;color:#64748b;font-family:monospace;margin-bottom:.2rem; }
.ak-rw-books { font-size:.8rem;color:#475569;margin-top:.4rem;line-height:1.6; }
.ak-rw-dates { font-size:.72rem;color:#94a3b8;margin-top:.35rem; }
.ak-rw-badge { display:inline-block;padding:.25rem .75rem;border-radius:20px;font-size:.7rem;font-weight:700; }
.rw-aktif     { background:#fef3c7;color:#92400e; }
.rw-terlambat { background:#fef2f2;color:#991b1b; }
.rw-kembali   { background:#dbeafe;color:#1e40af; }
.rw-menunggu  { background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe; }
.rw-ditolak   { background:#fef2f2;color:#991b1b;border:1px solid #fecaca; }

/* ── Empty State ── */
.ak-empty { text-align:center;padding:3rem 1rem; }
.ak-empty-icon { font-size:3rem;margin-bottom:.75rem;display:block; }
.ak-empty-text { color:#94a3b8;font-size:.9rem; }

@media (max-width:575px) {
    .ak-stats { grid-template-columns:repeat(3,1fr); gap:.5rem; }
    .ak-stat { padding:.7rem .75rem;gap:.5rem; }
    .ak-stat-icon { width:34px;height:34px;font-size:.85rem; }
    .ak-stat-num { font-size:1.15rem; }
    .ak-books { grid-template-columns:repeat(2,1fr);gap:.65rem; }
    .ak-book-cover { height:88px; }
    .ak-toolbar { flex-direction:column;align-items:stretch;gap:.5rem; }
    .ak-select { min-width:unset; }
    .ak-count-pill { margin-left:0; }
}
</style>

{{-- Toast --}}
@if($alertPesan)
<div id="ak-toast" style="position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:2000;
    background:#1e293b;color:#fff;border-radius:12px;padding:.7rem 1.2rem .7rem 1rem;
    display:flex;align-items:center;gap:.75rem;box-shadow:0 8px 28px rgba(0,0,0,.25);
    min-width:240px;max-width:90vw;animation:toastIn .25s ease;">
    <div style="width:30px;height:30px;border-radius:8px;background:{{ $alertTipe==='success' ? '#10b981' : '#ef4444' }};
        display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.8rem;">
        <i class="fas fa-{{ $alertTipe==='success' ? 'check' : 'exclamation' }}"></i>
    </div>
    <div style="flex:1;font-size:.85rem;font-weight:500;">{{ $alertPesan }}</div>
    <button onclick="document.getElementById('ak-toast').style.display='none'"
        style="background:none;border:none;color:rgba(255,255,255,.5);cursor:pointer;font-size:.9rem;padding:0 .2rem;">
        &times;
    </button>
</div>
@endif

{{-- ══ HERO BANNER ══ --}}
<div class="ak-hero">
    <div style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:.85rem;margin-bottom:.6rem;">
            <div style="width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:12px;
                display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">
                {{ strtoupper(substr($anggota->nama_anggota,0,1)) }}
            </div>
            <div>
                <div style="font-weight:700;font-size:1rem;line-height:1.2;">{{ $anggota->nama_anggota }}</div>
                <div style="font-size:.75rem;opacity:.8;margin-top:.1rem;">
                    {{ ucfirst($anggota->jenis_anggota) }}
                    @if($anggota->nis) · NIS {{ $anggota->nis }} @endif
                </div>
            </div>
            @if($anggota->berlaku_hingga)
            <div style="margin-left:auto;text-align:right;font-size:.72rem;opacity:.85;">
                Aktif s/d<br>
                <strong style="font-size:.8rem;">{{ \Carbon\Carbon::parse($anggota->berlaku_hingga)->format('d M Y') }}</strong>
            </div>
            @endif
        </div>
        <div style="font-size:.78rem;opacity:.75;">
            <i class="fas fa-map-marker-alt" style="margin-right:.3rem;"></i>{{ $anggota->institusi ?? 'SD Muhammadiyah Karangwaru' }}
        </div>
    </div>
</div>

{{-- ══ STAT CARDS ══ --}}
<div class="ak-stats">
    <div class="ak-stat">
        <div class="ak-stat-icon" style="background:#dbeafe;color:#2563eb;">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="ak-stat-num">{{ $totalBuku }}</div>
            <div class="ak-stat-lbl">Koleksi Buku</div>
        </div>
    </div>
    <div class="ak-stat">
        <div class="ak-stat-icon" style="background:{{ $peminjamanAktif>0 ? '#fef3c7' : '#d1fae5' }};color:{{ $peminjamanAktif>0 ? '#d97706' : '#059669' }};">
            <i class="fas fa-{{ $peminjamanAktif>0 ? 'clock' : 'check-circle' }}"></i>
        </div>
        <div>
            <div class="ak-stat-num" style="color:{{ $peminjamanAktif>0 ? '#d97706' : '#0f172a' }};">{{ $peminjamanAktif }}</div>
            <div class="ak-stat-lbl">Dipinjam</div>
        </div>
    </div>
    <div class="ak-stat">
        <div class="ak-stat-icon" style="background:#ede9fe;color:#7c3aed;">
            <i class="fas fa-history"></i>
        </div>
        <div>
            <div class="ak-stat-num">{{ $riwayatPeminjaman->total() }}</div>
            <div class="ak-stat-lbl">Riwayat</div>
        </div>
    </div>
</div>

@if($pengajuanMenunggu > 0)
<div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:.85rem 1.1rem;
    margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;font-size:.84rem;color:#1e40af;">
    <i class="fas fa-clock" style="flex-shrink:0;font-size:1rem;"></i>
    <div>
        <strong>Pengajuan sedang menunggu verifikasi.</strong><br>
        <span style="font-size:.78rem;opacity:.85;">Pustakawan sedang memproses pengajuan Anda. Anda tidak dapat mengajukan peminjaman baru sampai pengajuan ini disetujui atau ditolak.</span>
    </div>
</div>
@elseif($peminjamanAktif > 0)
<div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:.85rem 1.1rem;
    margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;font-size:.84rem;color:#92400e;">
    <i class="fas fa-exclamation-triangle" style="flex-shrink:0;font-size:1rem;"></i>
    <span>Anda masih memiliki <strong>{{ $peminjamanAktif }} buku dipinjam</strong>. Kembalikan dulu untuk meminjam buku baru.</span>
</div>
@endif

{{-- ══════ TAB: KATALOG ══════ --}}
@if($activeTab === 'katalog')

{{-- Toolbar --}}
<div class="ak-toolbar">
    <div class="ak-search">
        <span class="si"><i class="fas fa-search"></i></span>
        <input type="text" wire:model.live.debounce.350ms="search"
               placeholder="Cari judul, pengarang, penerbit, atau tahun...">
    </div>
    <select class="ak-select" wire:model.live="filterKategori">
        <option value="">Semua Kategori</option>
        @foreach($kategoriList as $kat)
            <option value="{{ $kat->id_kategori }}">{{ $kat->nama }}</option>
        @endforeach
    </select>
    <span class="ak-count-pill">
        <i class="fas fa-book-open" style="margin-right:.3rem;"></i>
        {{ $katalogBuku->total() }} buku
    </span>
</div>

{{-- Book Grid --}}
@if($katalogBuku->isEmpty())
<div class="ak-empty">
    <span class="ak-empty-icon">📚</span>
    <p class="ak-empty-text">Tidak ada buku yang ditemukan.</p>
</div>
@else
<div class="ak-books">
    @foreach($katalogBuku as $i => $buku)
    @php
        $eksemplarTersedia = $buku->eksemplar->where('status_eksemplar','tersedia')->first();
        $idEks   = $eksemplarTersedia?->id_eksemplar;
        $isSel   = $idEks && in_array($idEks, $selectedEksemplar);
        $stok    = $buku->eksemplar->where('status_eksemplar','tersedia')->count();
        $stokTampil = $isSel ? $stok - 1 : $stok;
        $covClass = 'cov-'.($i % 6);
        $covIcon  = ['📖','📘','📗','📙','📕','📓'][$i % 6];
    @endphp
    <div class="ak-book {{ $isSel ? 'selected' : '' }}">
        {{-- Cover --}}
        <div class="ak-book-cover {{ $covClass }}">
            <span style="font-size:2rem;">{{ $covIcon }}</span>
            @if($isSel)
            <div class="ak-check-badge"><i class="fas fa-check"></i></div>
            @endif
        </div>
        {{-- Body --}}
        <div class="ak-book-body">
            <div class="ak-book-title" title="{{ $buku->judul }}">{{ $buku->judul }}</div>
            <div class="ak-book-cat">
                <i class="fas fa-tag" style="font-size:.6rem;margin-right:.25rem;"></i>
                {{ $buku->kategori->nama ?? '-' }}
            </div>
            <div style="font-size:.68rem;color:#64748b;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;" title="Pengarang: {{ $buku->pengarang }}">
                <i class="fas fa-user-edit" style="font-size:.6rem;margin-right:.25rem;"></i>
                {{ $buku->pengarang ?: '-' }}
            </div>
            <div style="font-size:.68rem;color:#94a3b8;">
                <i class="fas fa-calendar-alt" style="font-size:.6rem;margin-right:.25rem;"></i>
                {{ $buku->tahun_terbit ?: '-' }}
            </div>
            <div class="ak-book-call">{{ $buku->no_panggil }}</div>
        </div>
        {{-- Footer --}}
        <div class="ak-book-footer">
            @if($stokTampil > 0)
                <span class="ak-badge-ok">{{ $stokTampil }} tersedia</span>
            @else
                <span class="ak-badge-no">Habis</span>
            @endif

            @if($peminjamanAktif > 0 || $pengajuanMenunggu > 0)
                <button class="ak-btn-pick dis" disabled>
                    {{ $pengajuanMenunggu > 0 ? 'Menunggu' : 'Dipinjam' }}
                </button>
            @elseif($isSel)
                <button class="ak-btn-pick rem" wire:click="toggleEksemplar({{ $idEks }})">
                    Batal
                </button>
            @elseif($idEks && $stok > 0 && count($selectedEksemplar) < 3)
                <button class="ak-btn-pick add" wire:click="toggleEksemplar({{ $idEks }})">
                    + Pilih
                </button>
            @else
                <button class="ak-btn-pick dis" disabled>
                    {{ !$idEks || $stok === 0 ? 'Habis' : 'Maks' }}
                </button>
            @endif
        </div>
    </div>
    @endforeach
</div>

@if($katalogBuku->hasPages())
<div class="d-flex justify-content-center mt-2 mb-4">
    {{ $katalogBuku->links('pagination::bootstrap-4') }}
</div>
@endif
@endif

{{-- Floating Cart Bar --}}
@if(!empty($selectedEksemplar))
<div class="ak-cart">
    <div class="ak-cart-info">
        <div class="ak-cart-num">{{ count($selectedEksemplar) }} buku dipilih</div>
        <div class="ak-cart-sub">Maks. 3 buku per peminjaman</div>
    </div>
    <button class="ak-cart-cancel" wire:click="$set('selectedEksemplar',[])">Batal</button>
    <button class="ak-cart-btn" wire:click="konfirmasi">
        <i class="fas fa-arrow-right" style="margin-right:.3rem;"></i> Ajukan
    </button>
</div>
@endif

@endif {{-- end katalog --}}

{{-- ══════ TAB: RIWAYAT ══════ --}}
@if($activeTab === 'riwayat')

<div style="margin-bottom:1rem;">
    <h6 style="font-weight:700;color:#0f172a;font-size:1rem;margin:0;">Riwayat Peminjaman</h6>
    <p style="font-size:.78rem;color:#94a3b8;margin:.2rem 0 0;">{{ $riwayatPeminjaman->total() }} transaksi tercatat</p>
</div>

@if($riwayatPeminjaman->isEmpty())
<div class="ak-empty">
    <span class="ak-empty-icon">📋</span>
    <p class="ak-empty-text">Belum ada riwayat peminjaman.</p>
</div>
@else
<div class="ak-riwayat">
    @foreach($riwayatPeminjaman as $pinjam)
    @php
        $isLate = $pinjam->status_buku === 'dipinjam' && \Carbon\Carbon::parse($pinjam->tgl_jatuh_tempo)->isPast();
        $isDone = $pinjam->status_buku === 'kembali';
        $isMenunggu = $pinjam->status_buku === 'menunggu';
        $isDitolak  = $pinjam->status_buku === 'ditolak';

        $iconBg  = $isMenunggu ? '#eff6ff'
                 : ($isDitolak  ? '#fef2f2'
                 : ($isLate     ? '#fef2f2'
                 : ($isDone     ? '#dbeafe' : '#fef3c7')));
        $iconClr = $isMenunggu ? '#2563eb'
                 : ($isDitolak  ? '#ef4444'
                 : ($isLate     ? '#ef4444'
                 : ($isDone     ? '#2563eb' : '#d97706')));
        $icon    = $isMenunggu ? 'fa-clock'
                 : ($isDitolak  ? 'fa-times-circle'
                 : ($isLate     ? 'fa-exclamation'
                 : ($isDone     ? 'fa-check' : 'fa-clock')));

        $badgeCls = $isMenunggu ? 'rw-menunggu'
                  : ($isDitolak  ? 'rw-ditolak'
                  : ($isLate     ? 'rw-terlambat'
                  : ($isDone     ? 'rw-kembali' : 'rw-aktif')));
        $badgeTxt = $isMenunggu ? 'Menunggu Verifikasi'
                  : ($isDitolak  ? 'Ditolak'
                  : ($isLate     ? 'Terlambat'
                  : ($isDone     ? 'Dikembalikan' : 'Dipinjam')));

        $tglKembali = $pinjam->detailPeminjaman->first()?->tgl_kembali;
    @endphp
    <div class="ak-rw-card">
        <div class="ak-rw-icon" style="background:{{ $iconBg }};color:{{ $iconClr }};">
            <i class="fas {{ $icon }}"></i>
        </div>
        <div class="ak-rw-body">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;flex-wrap:wrap;">
                <div>
                    <div class="ak-rw-kode">{{ $pinjam->kode_transaksi }}</div>
                    <div style="font-weight:700;font-size:.875rem;color:#0f172a;">
                        {{ $pinjam->jumlah_peminjaman }} buku
                    </div>
                </div>
                <span class="ak-rw-badge {{ $badgeCls }}">{{ $badgeTxt }}</span>
            </div>
            <div class="ak-rw-books">
                @foreach($pinjam->detailPeminjaman->take(3) as $d)
                    <div>📖 {{ $d->eksemplar?->buku?->judul ?? '-' }}</div>
                @endforeach
                @if($pinjam->detailPeminjaman->count() > 3)
                    <div style="color:#94a3b8;font-size:.72rem;">+{{ $pinjam->detailPeminjaman->count()-3 }} buku lainnya</div>
                @endif
            </div>
            <div class="ak-rw-dates">
                @if($isMenunggu)
                    <i class="fas fa-clock" style="margin-right:.3rem;color:#2563eb;"></i>
                    Diajukan: <strong>{{ \Carbon\Carbon::parse($pinjam->created_at)->format('d M Y, H:i') }}</strong>
                @elseif($isDitolak)
                    <i class="fas fa-calendar" style="margin-right:.3rem;"></i>
                    Diajukan: <strong>{{ \Carbon\Carbon::parse($pinjam->created_at)->format('d M Y') }}</strong>
                    @if($pinjam->alasan_penolakan)
                        <div style="margin-top:.3rem;color:#991b1b;font-size:.72rem;">
                            <i class="fas fa-comment-alt" style="margin-right:.25rem;"></i>
                            Alasan: <em>{{ $pinjam->alasan_penolakan }}</em>
                        </div>
                    @endif
                @else
                    <i class="fas fa-calendar" style="margin-right:.3rem;"></i>
                    Pinjam: <strong>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</strong>
                    &nbsp;·&nbsp;
                    Tempo: <strong style="color:{{ $isLate ? '#ef4444' : 'inherit' }};">{{ \Carbon\Carbon::parse($pinjam->tgl_jatuh_tempo)->format('d M Y') }}</strong>
                    @if($tglKembali)
                        &nbsp;·&nbsp;
                        Kembali: <strong>{{ \Carbon\Carbon::parse($tglKembali)->format('d M Y') }}</strong>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($riwayatPeminjaman->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $riwayatPeminjaman->links('pagination::bootstrap-4') }}
</div>
@endif
@endif
@endif {{-- end riwayat --}}

{{-- ══════ MODAL KONFIRMASI PENGAJUAN ══════ --}}
@if($showKonfirmasiModal)
<div style="position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:1050;display:flex;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(2px);">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:420px;box-shadow:0 8px 32px rgba(0,0,0,.18);overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:.75rem;">
            <div style="width:38px;height:38px;background:#dbeafe;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-paper-plane" style="color:#2563eb;font-size:.95rem;"></i>
            </div>
            <div>
                <div style="font-weight:700;font-size:.95rem;color:#0f172a;">Konfirmasi Pengajuan</div>
                <div style="font-size:.76rem;color:#64748b;margin-top:.1rem;">Pengajuan akan dikirim ke pustakawan untuk diverifikasi</div>
            </div>
        </div>
        <div style="padding:1.25rem 1.5rem;">
            @php $eksemplarDipilih = \App\Models\Eksemplar::with('buku')->whereIn('id_eksemplar', $selectedEksemplar)->get(); @endphp
            <div style="font-size:.73rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.6rem;">
                Buku yang Diajukan ({{ count($selectedEksemplar) }})
            </div>
            <div style="border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:1rem;">
                @foreach($eksemplarDipilih as $eks)
                <div style="display:flex;align-items:center;gap:.7rem;padding:.7rem .9rem;{{ !$loop->last ? 'border-bottom:1px solid #f1f5f9;' : '' }}">
                    <div style="width:32px;height:32px;background:#f8fafc;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid #e2e8f0;">
                        <i class="fas fa-book" style="font-size:.7rem;color:#94a3b8;"></i>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-weight:600;font-size:.85rem;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $eks->buku->judul }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">{{ $eks->kode_eksemplar }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="display:flex;align-items:flex-start;gap:.6rem;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:.7rem .9rem;margin-bottom:1.25rem;">
                <i class="fas fa-info-circle" style="color:#2563eb;margin-top:.1rem;font-size:.85rem;flex-shrink:0;"></i>
                <div style="font-size:.78rem;color:#1e40af;line-height:1.5;">
                    Pengajuan akan menunggu persetujuan pustakawan. Buku baru bisa diambil setelah pengajuan disetujui.
                </div>
            </div>
            <div style="display:flex;gap:.65rem;">
                <button wire:click="batalKonfirmasi"
                    style="flex:1;background:#f8fafc;color:#475569;border:1.5px solid #e2e8f0;border-radius:9px;padding:.7rem;font-weight:600;font-size:.84rem;cursor:pointer;">
                    Batal
                </button>
                <button wire:click="ajukanPeminjaman" wire:loading.attr="disabled"
                    style="flex:2;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;border-radius:9px;padding:.7rem;font-weight:700;font-size:.84rem;cursor:pointer;">
                    <span wire:loading.remove wire:target="ajukanPeminjaman">
                        <i class="fas fa-paper-plane" style="margin-right:.35rem;"></i> Kirim Pengajuan
                    </span>
                    <span wire:loading wire:target="ajukanPeminjaman">
                        <i class="fas fa-spinner fa-spin" style="margin-right:.35rem;"></i> Mengirim...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══════ MODAL BUKTI PENGAJUAN ══════ --}}
@if($showBuktiModal && $lastPeminjaman)
<div style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1050;display:flex;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
    <div style="background:#fff;border-radius:20px;max-width:460px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.25);overflow:hidden;">
        <div style="background:linear-gradient(135deg,#2563eb,#1d4ed8);padding:1.5rem;text-align:center;color:#fff;">
            <div style="font-size:2.5rem;margin-bottom:.5rem;">⏳</div>
            <h5 style="font-weight:700;margin:0 0 .25rem;">Pengajuan Terkirim!</h5>
            <p style="font-size:.8rem;opacity:.85;margin:0;">Menunggu verifikasi dari pustakawan</p>
        </div>
        <div style="padding:1.5rem;">
            <div style="background:#eff6ff;border-radius:12px;padding:1rem;margin-bottom:1rem;text-align:center;border:1px solid #bfdbfe;">
                <div style="font-size:.75rem;color:#1e40af;font-weight:600;letter-spacing:.08em;margin-bottom:.3rem;">KODE PENGAJUAN</div>
                <div style="font-size:1.2rem;font-weight:800;color:#2563eb;letter-spacing:.05em;">{{ $lastPeminjaman->kode_transaksi }}</div>
            </div>
            <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:10px;padding:.85rem 1rem;margin-bottom:1rem;font-size:.82rem;color:#92400e;display:flex;align-items:flex-start;gap:.6rem;">
                <i class="fas fa-clock" style="flex-shrink:0;margin-top:.1rem;"></i>
                <span>Pustakawan akan memverifikasi pengajuan Anda. Cek tab <strong>Riwayat Peminjaman</strong> untuk melihat status terbaru.</span>
            </div>
            <div style="margin-bottom:1rem;">
                <div style="font-weight:700;font-size:.85rem;color:#374151;margin-bottom:.6rem;">Buku yang Diajukan:</div>
                @foreach($lastPeminjaman->detailPeminjaman as $detail)
                <div style="display:flex;align-items:center;gap:.6rem;padding:.5rem;background:#f8fafc;border-radius:8px;margin-bottom:.4rem;border:1px solid #e2e8f0;">
                    <span>📖</span>
                    <div>
                        <div style="font-weight:600;font-size:.82rem;">{{ $detail->eksemplar->buku->judul ?? '-' }}</div>
                        <div style="font-size:.72rem;color:#6b7280;">{{ $detail->eksemplar->kode_eksemplar }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <button wire:click="tutupBukti"
                style="width:100%;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;border-radius:10px;padding:.85rem;font-weight:700;font-size:.9rem;cursor:pointer;">
                Mengerti, Tutup
            </button>
        </div>
    </div>
</div>
@endif

</div>