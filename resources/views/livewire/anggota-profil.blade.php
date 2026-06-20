<div>
    <style>
        .profil-anggota-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .profil-anggota-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 28px;
            color: white;
        }
        .profil-anggota-avatar {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            border: 3px solid rgba(255,255,255,.5);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 700; color: white;
            flex-shrink: 0;
        }
        .profil-info-row {
            display: flex;
            padding: 14px 24px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }
        .profil-info-row:last-child { border-bottom: none; }
        .profil-info-label { width: 160px; flex-shrink: 0; color: #6b7280; font-weight: 500; }
        .profil-info-value { color: #111827; font-weight: 600; }
    </style>

    {{-- Alert --}}
    @if($alertPesan)
    <div class="alert alert-{{ $alertTipe === 'success' ? 'success' : 'danger' }} alert-dismissible fade show"
         style="border-radius:12px;border-left:4px solid {{ $alertTipe === 'success' ? '#10b981' : '#ef4444' }};">
        {{ $alertPesan }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if($anggota)
    <div class="profil-anggota-card mb-4">
        {{-- Header --}}
        <div class="profil-anggota-header">
            <div class="d-flex align-items-center" style="gap:20px;">
                <div class="profil-anggota-avatar">
                    {{ strtoupper(substr($anggota->nama_anggota, 0, 1)) }}
                </div>
                <div>
                    <h4 style="margin:0 0 4px;font-weight:700;font-size:22px;">{{ $anggota->nama_anggota }}</h4>
                    <span style="background:rgba(255,255,255,.2);padding:4px 12px;border-radius:20px;font-size:13px;font-weight:600;">
                        {{ ucfirst($anggota->jenis_anggota) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="profil-info-row">
            <span class="profil-info-label">NIS / ID Anggota</span>
            <span class="profil-info-value">{{ $anggota->nis ?? '-' }}</span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Email</span>
            <span class="profil-info-value">{{ $anggota->email ?? '-' }}</span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">No. WhatsApp</span>
            <span class="profil-info-value">{{ $anggota->no_hp ? '+62'.$anggota->no_hp : '-' }}</span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Jenis Kelamin</span>
            <span class="profil-info-value">{{ $anggota->jenis_kelamin ? ucfirst($anggota->jenis_kelamin) : '-' }}</span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Tanggal Lahir</span>
            <span class="profil-info-value">
                {{ $anggota->tgl_lahir ? \Carbon\Carbon::parse($anggota->tgl_lahir)->translatedFormat('d F Y') : '-' }}
            </span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Institusi</span>
            <span class="profil-info-value">{{ $anggota->institusi ?? '-' }}</span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Anggota Sejak</span>
            <span class="profil-info-value">
                {{ $anggota->anggota_sejak ? \Carbon\Carbon::parse($anggota->anggota_sejak)->translatedFormat('d F Y') : '-' }}
            </span>
        </div>
        <div class="profil-info-row">
            <span class="profil-info-label">Berlaku Hingga</span>
            <span class="profil-info-value">
                {{ $anggota->berlaku_hingga ? \Carbon\Carbon::parse($anggota->berlaku_hingga)->translatedFormat('d F Y') : '-' }}
            </span>
        </div>
    </div>

    <div style="background:#fff3cd;border-left:4px solid #f59e0b;border-radius:12px;padding:14px 18px;font-size:13px;color:#92400e;">
        <i data-feather="info" style="width:15px;height:15px;vertical-align:middle;margin-right:6px;"></i>
        Untuk mengubah data profil atau password, hubungi pustakawan.
    </div>
    @else
    <div class="text-center" style="padding:60px;">
        <i data-feather="user-x" style="width:52px;height:52px;color:#9ca3af;"></i>
        <p style="color:#6b7280;margin-top:16px;">Data anggota tidak ditemukan.</p>
    </div>
    @endif
</div>
