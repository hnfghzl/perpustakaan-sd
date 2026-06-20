<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota Perpustakaan – {{ $anggota->nama_anggota }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #d0d0d0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 28px 16px;
        }

        /* ─── TOOLBAR ─────────────────────────────────── */
        .toolbar {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
        }
        .btn {
            padding: 9px 22px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: .15s;
        }
        .btn-print { background:#1565c0; color:#fff; box-shadow:0 2px 8px rgba(21,101,192,.35); }
        .btn-print:hover { background:#0d47a1; }
        .btn-back  { background:#546e7a; color:#fff; }
        .btn-back:hover  { background:#37474f; }

        /* ─── WRAPPER ABU-ABU ─────────────────────────── */
        .wrapper {
            background: #c0c0c0;
            border-radius: 12px;
            padding: 24px 32px 28px;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
        }
        .wrap-label {
            text-align: center;
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #555;
            font-weight: 700;
            margin-bottom: 12px;
        }

        /* ─── KARTU UTAMA ─────────────────────────────── */
        .kartu {
            width: 540px;
            border-radius: 10px;
            border: 1.5px solid var(--kartu-border, #9cbe9e);
            overflow: hidden;
            position: relative;
            background: var(--kartu-bg,
                radial-gradient(ellipse at 80% 90%, rgba(144,200,147,.55) 0%, transparent 55%),
                linear-gradient(160deg, #eef7ef 0%, #f3faf4 40%, #e6f3e8 100%));
            box-shadow: 0 4px 18px rgba(0,0,0,.14), inset 0 0 60px rgba(255,255,255,.45);
        }

        /* ─── HEADER ──────────────────────────────────── */
        .k-header {
            background: #fff;
            border-bottom: 4px solid var(--kartu-aksen, #1a237e);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        /* Label kelas di pojok kanan atas */
        .kelas-badge {
            position: absolute;
            top: 8px;
            right: 56px;
            background: var(--kartu-aksen, #1a237e);
            color: #fff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .5px;
            padding: 3px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            z-index: 2;
        }

        .logo-circle-sm {
            width: 68px; height: 68px;
            border-radius: 50%;
            border: 2.5px solid #333;
            background: #f4f4f4;
            overflow: hidden;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-circle-sm img { width:100%; height:100%; object-fit:cover; }

        .h-mid { flex: 1; text-align: center; }
        .h-judul {
            font-size: 14px;
            font-weight: 900;
            color: var(--kartu-aksen, #1a237e);
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .h-sekolah {
            font-size: 12.5px;
            font-weight: 800;
            color: #222;
            margin-top: 3px;
            text-transform: uppercase;
            line-height: 1.3;
        }
        .h-alamat {
            font-size: 8px;
            color: #555;
            margin-top: 4px;
            line-height: 1.55;
        }

        /* ─── BODY ────────────────────────────────────── */
        .k-body {
            padding: 16px 18px 8px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }

        /* Foto */
        .foto-wrap {
            width: 95px; height: 124px;
            border: 2px solid #555;
            background: #c0392b;
            flex-shrink: 0;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }
        .foto-wrap img { width:100%; height:100%; object-fit:cover; }

        /* Info rows */
        .info-wrap { flex: 1; padding-top: 6px; }
        .irow {
            display: flex;
            align-items: flex-start;
            margin-bottom: 11px;
            font-size: 12.5px;
            color: #111;
            line-height: 1.4;
        }
        .il  { width: 90px; flex-shrink: 0; }
        .is  { width: 14px; flex-shrink: 0; text-align: center; }
        .iv  { flex: 1; }

        /* ─── FOOTER ──────────────────────────────────── */
        .k-footer {
            padding: 4px 18px 16px;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .f-kota-jabatan {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .f-kota {
            font-size: 9px;
            color: #222;
            white-space: nowrap;
        }
        .f-jabatan {
            font-size: 9.5px;
            font-weight: 700;
            color: #222;
        }
        .f-space { height: 38px; }

        .f-stempel {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
        }

        .f-ttd {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .f-ttd-space { height: 38px; }
        .f-garis {
            width: 120px;
            border-top: 1px solid #333;
        }
        .f-nama {
            font-size: 9.5px;
            font-weight: 700;
            color: #111;
            text-align: center;
            white-space: nowrap;
        }
        .f-nip {
            font-size: 8px;
            color: #444;
            text-align: center;
        }

        /* ─── PRINT ───────────────────────────────────── */
        @page {
            size: 85.6mm 54mm landscape;
            margin: 0;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                width: 85.6mm;
                height: 54mm;
                margin: 0;
                padding: 0;
                background: #fff;
                display: block;
                overflow: hidden;
            }

            .toolbar    { display: none !important; }
            .wrap-label { display: none !important; }

            .wrapper {
                background: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
                border-radius: 0 !important;
                margin: 0 !important;
                width: 85.6mm;
            }

            .kartu {
                width: 85.6mm !important;
                height: 54mm !important;
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            .k-header  { padding: 5px 8px !important; }
            .logo-circle-sm { width: 46px !important; height: 46px !important; }
            .h-judul   { font-size: 10px !important; }
            .h-sekolah { font-size: 9px !important;  margin-top: 1px !important; }
            .h-alamat  { font-size: 6px !important;  margin-top: 2px !important; }

            .k-body    { padding: 6px 8px 2px !important; gap: 8px !important; }
            .foto-wrap { width: 60px !important; height: 76px !important; }
            .info-wrap { padding-top: 2px !important; }
            .irow      { font-size: 8.5px !important; margin-bottom: 4px !important; }
            .il        { width: 58px !important; }

            .k-footer  { padding: 2px 8px 6px !important; gap: 6px !important; }
            .f-kota    { font-size: 6.5px !important; }
            .f-jabatan { font-size: 6.5px !important; }
            .f-space   { height: 16px !important; }
            .f-stempel { width: 56px !important; height: 56px !important; }
            .f-stempel svg { width: 56px !important; height: 56px !important; }
            .f-ttd-space { height: 16px !important; }
            .f-garis   { width: 80px !important; }
            .f-nama    { font-size: 7px !important; }
            .f-nip     { font-size: 6px !important; }
        }
    </style>
</head>
<body>

<!-- TOOLBAR -->
<div class="toolbar">
    <button class="btn btn-print" onclick="window.print()">🖨️ Cetak Kartu</button>
    <button class="btn btn-back"  onclick="window.history.back()">← Kembali</button>
</div>

<div class="wrapper">
    <div class="wrap-label">Pratinjau — Kartu Anggota Perpustakaan</div>

    @php
        $kelas = $anggota->kelas ?? null;

        [$bgGrad, $borderColor, $aksenColor, $kelasLabel] = match((string)$kelas) {
            '1' => [
                'radial-gradient(ellipse at 80% 90%, rgba(252,165,165,.5) 0%, transparent 55%), linear-gradient(160deg, #fff0f0 0%, #fff5f5 40%, #ffe4e4 100%)',
                '#fca5a5', '#dc2626', 'KELAS 1'
            ],
            '2' => [
                'radial-gradient(ellipse at 80% 90%, rgba(253,186,116,.5) 0%, transparent 55%), linear-gradient(160deg, #fff7ed 0%, #fff8f1 40%, #ffedd5 100%)',
                '#fdba74', '#ea580c', 'KELAS 2'
            ],
            '3' => [
                'radial-gradient(ellipse at 80% 90%, rgba(253,224,71,.5) 0%, transparent 55%), linear-gradient(160deg, #fefce8 0%, #fefdf4 40%, #fef08a 100%)',
                '#fde047', '#ca8a04', 'KELAS 3'
            ],
            '4' => [
                'radial-gradient(ellipse at 80% 90%, rgba(134,239,172,.5) 0%, transparent 55%), linear-gradient(160deg, #f0fdf4 0%, #f3faf4 40%, #dcfce7 100%)',
                '#86efac', '#16a34a', 'KELAS 4'
            ],
            '5' => [
                'radial-gradient(ellipse at 80% 90%, rgba(147,197,253,.5) 0%, transparent 55%), linear-gradient(160deg, #eff6ff 0%, #f0f7ff 40%, #dbeafe 100%)',
                '#93c5fd', '#2563eb', 'KELAS 5'
            ],
            '6' => [
                'radial-gradient(ellipse at 80% 90%, rgba(196,181,253,.5) 0%, transparent 55%), linear-gradient(160deg, #f5f3ff 0%, #f7f5ff 40%, #ede9fe 100%)',
                '#c4b5fd', '#7c3aed', 'KELAS 6'
            ],
            default => [
                'radial-gradient(ellipse at 80% 90%, rgba(144,200,147,.55) 0%, transparent 55%), linear-gradient(160deg, #eef7ef 0%, #f3faf4 40%, #e6f3e8 100%)',
                '#9cbe9e', '#1a237e', 'ANGGOTA'
            ],
        };
    @endphp

    <div class="kartu" style="--kartu-bg: {{ $bgGrad }}; --kartu-border: {{ $borderColor }}; --kartu-aksen: {{ $aksenColor }};">

        <!-- ═══ HEADER ═══ -->
        <div class="k-header">

            <!-- Teks Tengah -->
            <div class="h-mid">
                @php
                    $namaSekolah   = \App\Models\Pengaturan::get('nama_sekolah',   'SD MUHAMMADIYAH KARANGWARU');
                    $alamatSekolah = \App\Models\Pengaturan::get('alamat_sekolah', 'Jl. Karangwaru Lor No. 1, Yogyakarta');
                    $telpSekolah   = \App\Models\Pengaturan::get('telp_sekolah',   '(0274) 000000');
                @endphp
                <div class="h-judul">Kartu Anggota Perpustakaan</div>
                <div class="h-sekolah">{{ $namaSekolah }}</div>
                <div class="h-alamat">{{ $alamatSekolah }}<br>Telp. {{ $telpSekolah }}</div>
            </div>

            <!-- Logo Kanan -->
            <div class="logo-circle-sm">
                @php $logoKanan = \App\Models\Pengaturan::get('logo_sekolah'); @endphp
                @if($logoKanan)
                    <img src="{{ asset('storage/'.$logoKanan) }}" alt="Logo Sekolah">
                @else
                    <img src="{{ asset('asset/Logo.png') }}" alt="Logo SD Muhammadiyah Karangwaru">
                @endif
            </div>

        </div><!-- /k-header -->

        <!-- ═══ BODY ═══ -->
        <div class="k-body">

            <!-- Foto -->
            <div class="foto-wrap">
                @if($anggota->foto_profil)
                    <img src="{{ asset('storage/'.$anggota->foto_profil) }}" alt="Foto">
                @else
                    FOTO
                @endif
            </div>

            <!-- Info -->
            <div class="info-wrap">
                <div class="irow">
                    <span class="il">No. Anggota</span>
                    <span class="is">:</span>
                    <span class="iv">{{ $anggota->nis ?? str_pad($anggota->id_anggota, 10, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="irow">
                    <span class="il">Nama</span>
                    <span class="is">:</span>
                    <span class="iv">{{ $anggota->nama_anggota }}</span>
                </div>
                <div class="irow">
                    <span class="il">No. Induk</span>
                    <span class="is">:</span>
                    <span class="iv">{{ $anggota->nis ?? '-' }}</span>
                </div>
                @if($anggota->kelas ?? null)
                <div class="irow">
                    <span class="il">Kelas</span>
                    <span class="is">:</span>
                    <span class="iv">{{ $anggota->kelas }}</span>
                </div>
                @endif
            </div>

        </div><!-- /k-body -->

        <!-- ═══ FOOTER ═══ -->
        @php
            $kotaSekolah = \App\Models\Pengaturan::get('kota_sekolah',       'Yogyakarta');
            $namaKepala  = \App\Models\Pengaturan::get('nama_kepala_sekolah', 'Kepala Sekolah');
            $nipKepala   = \App\Models\Pengaturan::get('nip_kepala_sekolah',  '');
            $stmplLabel  = strtoupper(\App\Models\Pengaturan::get('nama_sekolah', 'SD MUHAMMADIYAH'));
        @endphp

        <div class="k-footer">

            <!-- Kolom kota + jabatan + ruang TTD -->
            <div class="f-kota-jabatan">
                <div class="f-kota">{{ $kotaSekolah }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="f-jabatan">Kepala Sekolah,</div>
                <div class="f-space"></div>
            </div>

            <!-- Stempel bulat SVG -->
            <div class="f-stempel">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                     width="90" height="90" style="opacity:.7;">
                    <defs>
                        <path id="stmp-top" d="M 12,50 A 38,38 0 0,1 88,50"/>
                        <path id="stmp-bot" d="M 88,50 A 38,38 0 0,1 12,50"/>
                    </defs>
                    <circle cx="50" cy="50" r="47" fill="none" stroke="#1a237e" stroke-width="2.5"/>
                    <circle cx="50" cy="50" r="35" fill="none" stroke="#1a237e" stroke-width="1.5"/>
                    <text font-size="8" font-family="Arial" font-weight="bold" fill="#1a237e" letter-spacing="0.8">
                        <textPath href="#stmp-top" startOffset="5%">{{ $stmplLabel }}</textPath>
                    </text>
                    <text font-size="7.5" font-family="Arial" fill="#1a237e" letter-spacing="0.5">
                        <textPath href="#stmp-bot" startOffset="8%">PERPUSTAKAAN SEKOLAH</textPath>
                    </text>
                    <text x="50" y="45" text-anchor="middle" font-size="22" fill="#1a237e">📚</text>
                    <text x="50" y="60" text-anchor="middle" font-size="7" font-weight="bold"
                          font-family="Arial" fill="#1a237e">PERPUSTAKAAN</text>
                </svg>
            </div>

            <!-- Kolom TTD: ruang + garis + nama + NIP -->
            <div class="f-ttd">
                <div class="f-ttd-space"></div>
                <div class="f-garis"></div>
                <div class="f-nama">{{ $namaKepala }}</div>
                @if($nipKepala)
                    <div class="f-nip">NIP. {{ $nipKepala }}</div>
                @endif
            </div>

        </div><!-- /k-footer -->

    </div><!-- /kartu -->
</div><!-- /wrapper -->

</body>
</html>
