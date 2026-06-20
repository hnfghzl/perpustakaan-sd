<div>
<style>
    [x-cloak] { display: none !important; }

    .peminjaman-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .peminjaman-btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .peminjaman-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    .peminjaman-book-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .peminjaman-book-item:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .peminjaman-book-item.selected {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-color: #3b82f6;
    }
    
    .peminjaman-book-item.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .peminjaman-book-item.disabled:hover {
        border-color: #e5e7eb;
        transform: none;
        box-shadow: none;
    }
</style>

<div style="padding: 28px;">
    {{-- Header --}}
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px; margin-bottom: 28px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
        <h4 style="color: white; margin: 0; font-weight: 700; font-size: 22px; display: flex; align-items: center;">
            <i data-feather="book-open" style="width: 28px; height: 28px; margin-right: 12px;"></i>
            Transaksi Peminjaman Buku
        </h4>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 8px 0 0 40px; font-size: 14px;">
            Catat peminjaman buku oleh anggota perpustakaan
        </p>
    </div>

    {{-- Alert Messages --}}
    @if(session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 15000)" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i data-feather="check-circle" style="width: 20px; height: 20px; color: #065f46; margin-right: 12px;"></i>
                <span style="color: #065f46; font-weight: 600; font-size: 14px;">{{ session('success') }}</span>
            </div>
            <button x-on:click="show = false" style="background: none; border: none; color: #065f46; cursor: pointer; padding: 4px;">
                <i data-feather="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 15000)" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i data-feather="alert-circle" style="width: 20px; height: 20px; color: #991b1b; margin-right: 12px;"></i>
                <span style="color: #991b1b; font-weight: 600; font-size: 14px;">{{ session('error') }}</span>
            </div>
            <button x-on:click="show = false" style="background: none; border: none; color: #991b1b; cursor: pointer; padding: 4px;">
                <i data-feather="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- Info Box: Aturan Peminjaman --}}
    <div class="peminjaman-card-modern" style="margin-bottom: 24px;">
        <div style="padding: 20px 24px;">
            <div style="display: flex; align-items: start;">
                <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 12px; border-radius: 12px; margin-right: 16px;">
                    <i data-feather="info" style="width: 24px; height: 24px; color: #1e40af;"></i>
                </div>
                <div style="flex: 1;">
                    <h6 style="color: #1e40af; font-weight: 600; margin: 0 0 12px 0; font-size: 15px;">Aturan Peminjaman</h6>
                    <ul style="color: #374151; font-size: 13px; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>Anggota dengan <strong>peminjaman aktif</strong> tidak bisa meminjam lagi sampai buku dikembalikan</li>
                        <li>Maksimal <strong>{{ $maxBukuPerPeminjaman }} buku berbeda</strong> per transaksi (tidak boleh meminjam eksemplar dari judul yang sama)</li>
                        <li>Durasi peminjaman <strong>maksimal {{ $durasiPeminjaman }} hari</strong></li>
                        <li>Lihat semua history peminjaman di menu <strong>Master Data → History Peminjaman</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Button: Buat Peminjaman Baru --}}
    <div style="margin-bottom: 24px;">
        <button class="peminjaman-btn-primary" data-toggle="modal" data-target="#addPeminjamanModal">
            <i data-feather="plus-circle" style="width: 18px; height: 18px;"></i>
            Buat Peminjaman Baru
        </button>
    </div>

    {{-- List Peminjaman (empty state for now) --}}
    <div class="peminjaman-card-modern">
        <div style="padding: 40px 24px; text-align: center;">
            <i data-feather="inbox" style="width: 64px; height: 64px; color: #9ca3af; margin-bottom: 16px;"></i>
            <p style="color: #6b7280; font-size: 14px; margin: 0;">
                Klik tombol <strong>"Buat Peminjaman Baru"</strong> untuk mencatat peminjaman buku
            </p>
        </div>
    </div>
</div>

{{-- Modal: Add Peminjaman --}}
<div wire:ignore.self class="modal fade" id="addPeminjamanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);">
            {{-- Modal Header --}}
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 20px 28px;">
                <h5 style="color: white; font-weight: 600; margin: 0; display: flex; align-items: center;">
                    <i data-feather="plus-circle" style="width: 22px; height: 22px; margin-right: 10px;"></i>
                    Buat Peminjaman Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="this.blur()" style="opacity: 1;">
                    <span aria-hidden="true" style="font-size: 32px;">&times;</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body" style="padding: 28px; background: #f9fafb;">
                <div class="row">
                    {{-- Kolom Kiri: Data Peminjam & Tanggal --}}
                    <div class="col-md-5">
                        {{-- Section 1: Data Peminjam (Gray) --}}
                        <div style="background: #f3f4f6; padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; font-size: 16px;">
                                <i data-feather="user" style="width: 20px; height: 20px; margin-right: 8px; color: #6b7280;"></i>
                                Data Peminjam
                            </h6>
                            
                            {{-- Search Box untuk Filter Anggota --}}
                            <div style="position: relative; margin-bottom: 12px;">
                                <label style="color: #374151; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                    Cari & Pilih Anggota <span style="color: #ef4444;">*</span>
                                </label>
                                <div style="position: relative;">
                                    <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; z-index: 10;"></i>
                                    <input type="text" 
                                        wire:model.live.debounce.400ms="searchAnggota" 
                                        placeholder="Ketik nama atau NIS..." 
                                        {{ $selectedAnggotaData ? 'readonly' : '' }}
                                        style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid {{ $selectedAnggotaData ? '#3b82f6' : '#e5e7eb' }}; border-radius: 8px; font-size: 15px; transition: all 0.2s; background: {{ $selectedAnggotaData ? '#eff6ff' : 'white' }};" 
                                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                        onblur="this.style.borderColor='{{ $selectedAnggotaData ? '#3b82f6' : '#e5e7eb' }}';">
                                    
                                    @if($selectedAnggotaData)
                                    <button wire:click="deselectAnggota" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: #ef4444; color: white; border: none; border-radius: 4px; padding: 4px 8px; font-size: 11px; cursor: pointer; font-weight: 600;">
                                        Ganti
                                    </button>
                                    @endif
                                </div>

                                {{-- Dropdown Hasil Pencarian Anggota --}}
                                @if($showAnggotaResults && $anggotaList->count() > 0)
                                <div style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 2px solid #3b82f6; border-radius: 8px; margin-top: 4px; z-index: 1000; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-height: 250px; overflow-y: auto;">
                                    @foreach($anggotaList as $a)
                                    <div wire:click="selectAnggota({{ $a->id_anggota }})" 
                                         style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #f3f4f6; transition: background 0.2s;"
                                         onmouseover="this.style.background='#f0f9ff'"
                                         onmouseout="this.style.background='white'">
                                        <div style="font-weight: 600; color: #1f2937; font-size: 14px;">{{ $a->nama_anggota }}</div>
                                        <div style="font-size: 12px; color: #6b7280;">
                                            {{ $a->nis ? 'NIS: '.$a->nis : '' }} · {{ ucfirst($a->jenis_anggota) }} · {{ $a->institusi ?? '-' }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @elseif($showAnggotaResults && $searchAnggota)
                                <div style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 2px solid #e5e7eb; border-radius: 8px; margin-top: 4px; z-index: 1000; padding: 16px; text-align: center; color: #6b7280; font-size: 13px;">
                                    Anggota tidak ditemukan.
                                </div>
                                @endif
                            </div>

                            {{-- Info Anggota Terpilih --}}
                            @if($selectedAnggotaData)
                            <div style="background: white; border: 1px solid #3b82f6; border-radius: 10px; padding: 14px; margin-bottom: 16px; border-left: 4px solid #3b82f6;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="background: #eff6ff; color: #3b82f6; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i data-feather="user" style="width: 20px; height: 20px;"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; color: #1e40af; font-size: 14px;">{{ $selectedAnggotaData->nama_anggota }}</div>
                                        <div style="font-size: 12px; color: #64748b;">{{ ucfirst($selectedAnggotaData->jenis_anggota) }} · {{ $selectedAnggotaData->institusi ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <input type="hidden" wire:model="id_anggota">
                            @error('id_anggota')<div style="color: #ef4444; font-size: 12px; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</div>@enderror
                            
                            {{-- Warning jika anggota memiliki peminjaman aktif --}}
                            @if($peminjamanAktifAnggota > 0)
                            <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); padding: 14px 16px; border-radius: 10px; border-left: 4px solid #ef4444; margin-bottom: 16px;">
                                <div style="display: flex; align-items: start;">
                                    <i data-feather="alert-triangle" style="width: 18px; height: 18px; color: #991b1b; margin-right: 10px; flex-shrink: 0; margin-top: 2px;"></i>
                                    <div style="color: #991b1b; font-size: 12px; line-height: 1.6;">
                                        <strong>PERINGATAN!</strong> Anggota ini masih memiliki <strong>{{ $peminjamanAktifAnggota }} peminjaman aktif</strong> yang belum dikembalikan!
                                        <br>Kembalikan buku terlebih dahulu di menu <strong>Pengembalian</strong>.
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Section 2: Jadwal Peminjaman (Blue) --}}
                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #1e40af; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; font-size: 16px;">
                                <i data-feather="calendar" style="width: 20px; height: 20px; margin-right: 8px; color: #2563eb;"></i>
                                Jadwal Peminjaman
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #1e40af; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                        Tgl Pinjam <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="date" wire:model="tgl_pinjam" style="width: 100%; padding: 12px 16px; border: 2px solid #60a5fa; border-radius: 8px; font-size: 15px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#60a5fa'; this.style.boxShadow='none';">
                                    @error('tgl_pinjam')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #1e40af; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                        Jatuh Tempo
                                    </label>
                                    <div style="width: 100%; padding: 12px 16px; border: 2px solid #60a5fa; border-radius: 8px; font-size: 15px; background: #f0f9ff; color: #1e40af; font-weight: 600;">
                                        {{ $tgl_jatuh_tempo ? \Carbon\Carbon::parse($tgl_jatuh_tempo)->translatedFormat('d F Y') : '-' }}
                                    </div>
                                </div>
                            </div>

                            <div style="background: rgba(255,255,255,0.7); padding: 12px; border-radius: 8px; font-size: 14px; color: #1e40af;">
                                <i data-feather="info" style="width: 16px; height: 16px;"></i>
                                <strong>Info:</strong> Jatuh tempo otomatis dihitung berdasarkan durasi {{ $durasiPeminjaman }} hari dari pengaturan
                            </div>
                        </div>

                        @error('selectedEksemplar')
                        <div style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); padding: 12px 16px; border-radius: 10px; border-left: 4px solid #f59e0b; margin-bottom: 16px;">
                            <div style="display: flex; align-items: center;">
                                <i data-feather="alert-circle" style="width: 16px; height: 16px; color: #92400e; margin-right: 8px;"></i>
                                <span style="color: #92400e; font-size: 13px;">{{ $message }}</span>
                            </div>
                        </div>
                        @enderror

                        {{-- Section 3: Info Pilihan (Yellow) --}}
                        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 16px 20px; border-radius: 12px;">
                            <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center;">
                                    <i data-feather="info" style="width: 18px; height: 18px; color: #92400e; margin-right: 8px;"></i>
                                    <span style="color: #78350f; font-weight: 600; font-size: 15px;">Dipilih:</span>
                                </div>
                                <span style="background: linear-gradient(135deg, {{ count($selectedEksemplar ?? []) >= 3 ? '#ef4444 0%, #dc2626' : '#3b82f6 0%, #2563eb' }} 100%); color: white; font-weight: 600; padding: 6px 14px; border-radius: 6px; font-size: 15px;">
                                    {{ count($selectedEksemplar ?? []) }}/3 buku
                                </span>
                            </div>
                            <div style="color: #78350f; font-size: 14px; line-height: 1.7;">
                                <div style="margin-bottom: 4px;">
                                    <strong>Tersedia:</strong> {{ $eksemplarList->count() }}{{ $eksemplarList->count() >= 100 ? '+' : '' }} eksemplar
                                </div>
                                @if($eksemplarList->count() >= 100)
                                <div style="font-size: 12px; color: #b45309; margin-bottom: 4px;">
                                    <i data-feather="help-circle" style="width: 12px; height: 12px;"></i> Menampilkan 100 hasil pertama. Gunakan pencarian untuk menemukan buku spesifik.
                                </div>
                                @endif
                                <div style="color: #991b1b; font-weight: 600; margin-top: 8px; padding: 8px; background: rgba(254, 226, 226, 0.5); border-radius: 6px; font-size: 14px;">
                                    PENTING: Maksimal 3 buku, harus beda judul!
                                </div>
                            </div>
                        </div>
                    </div>{{-- /col-md-5 --}}

                    {{-- Kolom Kanan: Pilih Buku --}}
                    @php
                        $bukuMapData = $eksemplarList->pluck('id_buku', 'id_eksemplar')->toArray();
                    @endphp
                    <div class="col-md-7">
                        <h6 style="color: #374151; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; font-size: 16px;">
                            <span style="display: flex; align-items: center;">
                                <i data-feather="book" style="width: 20px; height: 20px; margin-right: 8px; color: #3b82f6;"></i>
                                Pilih Buku <span style="color: #ef4444; margin-left: 4px;">*</span>
                            </span>
                            <span style="font-size: 14px; color: #6b7280; font-weight: 400;">
                                <span id="bukuSelectedCount" style="color: #3b82f6; font-weight: 600;">0</span>/{{ $maxBukuPerPeminjaman }} dipilih
                            </span>
                        </h6>
                        
                        {{-- Search Box untuk Filter Buku --}}
                        <div style="position: relative; margin-bottom: 12px; opacity: {{ $id_anggota ? '1' : '0.6' }}; pointer-events: {{ $id_anggota ? 'auto' : 'none' }};">
                            <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #9ca3af; z-index: 10;"></i>
                            <input type="text" 
                                wire:model.live.debounce.400ms="searchBuku" 
                                placeholder="{{ $id_anggota ? 'Cari judul, kategori, nomor panggil, atau kode eksemplar...' : 'Pilih anggota terlebih dahulu...' }}" 
                                {{ $id_anggota ? '' : 'disabled' }}
                                style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05);" 
                                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.05)';">
                        </div>

                        @if($id_anggota && $searchBuku)
                        <div style="font-size: 14px; color: #6b7280; margin-bottom: 12px; padding-left: 4px;">
                            <i data-feather="info" style="width: 14px; height: 14px;"></i>
                            Ditemukan <strong style="color: #3b82f6;">{{ $eksemplarList->count() }}</strong> buku dari pencarian "{{ $searchBuku }}"
                        </div>
                        @endif
                        
                        {{-- Daftar buku -- dikelola JavaScript murni --}}
                        <div style="border: 2px solid #e5e7eb; padding: 12px; max-height: 450px; overflow-y: auto; border-radius: 12px; background: white; position: relative;">
                            @if(!$id_anggota)
                                <div style="position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 50; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; backdrop-filter: blur(1px);">
                                    <div style="background: #fef3c7; color: #92400e; padding: 12px; border-radius: 50%; margin-bottom: 12px;">
                                        <i data-feather="user-check" style="width: 28px; height: 28px;"></i>
                                    </div>
                                    <h6 style="font-weight: 700; color: #92400e; margin-bottom: 4px;">Pilih Anggota Dulu</h6>
                                    <p style="font-size: 13px; color: #b45309; margin: 0;">Silakan cari dan pilih anggota di sebelah kiri untuk melihat daftar buku tersedia.</p>
                                </div>
                            @endif
                            
                            @if($eksemplarList->count() > 0)
                                @foreach($eksemplarList as $e)
                                @php
                                    $idEks   = $e->id_eksemplar;
                                    $idBuku  = $e->id_buku;
                                @endphp
                                <div class="peminjaman-book-item" 
                                     id="buku-item-{{ $idEks }}"
                                     data-id-eks="{{ $idEks }}" 
                                     data-id-buku="{{ $idBuku }}"
                                     onclick="window.toggleBuku({{ $idEks }}, {{ $idBuku }}, this)">
                                    <div style="display:flex;align-items:start;pointer-events:none;">
                                        <div style="flex-shrink:0;margin-right:12px;margin-top:2px;">
                                            <input type="checkbox"
                                                id="cb-eks-{{ $idEks }}"
                                                style="width:18px;height:18px;accent-color:#3b82f6;pointer-events:none;"
                                                tabindex="-1"
                                                readonly>
                                        </div>
                                        <div style="flex:1;">
                                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                                <span style="font-weight:600;font-size:14px;color:#3b82f6;">{{ $e->kode_eksemplar }}</span>
                                            </div>
                                            <div style="font-size:14px;font-weight:600;color:#374151;margin-bottom:4px;">{{ $e->buku->judul }}</div>
                                            <div style="font-size:12px;color:#9ca3af;">
                                                {{ $e->buku->no_panggil ?? '-' }}
                                                @if($e->buku->kategori) · {{ $e->buku->kategori->nama }} @endif
                                                @if($e->lokasi_rak) · {{ $e->lokasi_rak }} @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div style="text-align: center; padding: 60px 20px;">
                                    <i data-feather="{{ $searchBuku ? 'search' : 'inbox' }}" style="width: 56px; height: 56px; color: #9ca3af;"></i>
                                    <p style="color: #6b7280; margin: 16px 0 0 0; font-size: 15px;">
                                        @if($searchBuku)
                                            Tidak ada buku yang cocok dengan pencarian "{{ $searchBuku }}"
                                        @else
                                            Tidak ada buku yang tersedia untuk dipinjam
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>{{-- /col-md-7 --}}
                </div>{{-- /row --}}
            </div>{{-- /modal-body --}}
        
            {{-- Modal Footer --}}
            <div class="modal-footer" style="background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 28px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="this.blur()" style="padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px;">
                    <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                </button>
                <button
                        onclick="
                            console.log('🚀 Simpan peminjaman diklik...');
                            var selected = (window._selectedBukuIds || []).slice();
                            console.log('📦 Buku terpilih:', selected, 'jumlah:', selected.length);
                            
                            if (selected.length === 0) {
                                alert('Pilih minimal 1 buku terlebih dahulu!');
                                return;
                            }
                            
                            var wireEl = this.closest('[wire\\:id]');
                            if (wireEl) {
                                var wireId = wireEl.getAttribute('wire:id');
                                var component = Livewire.find(wireId);
                                if (component) {
                                    console.log('📡 Mengirim ke server...', selected);
                                    component.call('store', selected).then(function(result) {
                                        console.log('✅ Respon diterima:', result);
                                    }).catch(function(error) {
                                        console.error('❌ ERROR:', error);
                                        alert('Terjadi kesalahan: ' + error);
                                    });
                                } else {
                                    alert('Error: Komponen tidak ditemukan. Refresh halaman.');
                                }
                            } else {
                                alert('Error: Element Livewire tidak ditemukan. Refresh halaman.');
                            }
                        "
                        wire:loading.attr="disabled"
                        wire:target="store"
                        {{ $peminjamanAktifAnggota > 0 ? 'disabled' : '' }}
                        title="{{ $peminjamanAktifAnggota > 0 ? 'Anggota masih memiliki peminjaman aktif' : '' }}" 
                        class="btn" 
                        id="btnSimpanPeminjaman"
                        style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none; {{ $peminjamanAktifAnggota > 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                    
                    <span wire:loading.remove wire:target="store">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Peminjaman
                    </span>
                    
                    <span wire:loading wire:target="store">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memproses...
                    </span>
                </button>
            </div>
        </div>{{-- /modal-content --}}
    </div>{{-- /modal-dialog --}}
</div>{{-- /modal --}}

{{-- Modal Kartu Peminjaman Buku Perpustakaan --}}
@if($showStruk && $lastPeminjaman)
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 99999;" wire:click="closeStruk">
    <div style="background: white; border-radius: 16px; width: 90%; max-width: 850px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);" @click.stop>
        {{-- Header Modal --}}
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 16px 16px 0 0; position: relative;">
            <button wire:click="closeStruk" style="position: absolute; top: 16px; right: 16px; background: rgba(255, 255, 255, 0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 22px; line-height: 1; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                &times;
            </button>
            <h5 style="color: white; margin: 0 0 8px 0; font-weight: 700; font-size: 20px; display: flex; align-items: center;">
                <i data-feather="file-text" style="width: 24px; height: 24px; margin-right: 10px;"></i>
                Kartu Peminjaman Buku Perpustakaan
            </h5>
            <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 13px;">
                Kode: <strong>{{ $lastPeminjaman->kode_transaksi }}</strong>
            </p>
        </div>

        {{-- Content Kartu (untuk print) --}}
        <div id="strukContent" style="padding: 40px;">
            {{-- Header Kartu --}}
            <div style="text-align: center; margin-bottom: 30px; border: 3px solid #000; padding: 20px;">
                <h2 style="margin: 0 0 10px 0; font-weight: 700; color: #000; font-size: 20px; letter-spacing: 1px;">
                    KARTU PEMINJAMAN BUKU PERPUSTAKAAN
                </h2>
                <h3 style="margin: 0; font-weight: 700; color: #000; font-size: 18px;">
                    SD MUHAMMADIYAH KARANGWARU
                </h3>
            </div>

            {{-- Info Peminjam --}}
            <div style="margin-bottom: 25px; font-size: 14px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #000; width: 120px; font-weight: 600;">Nama</td>
                        <td style="padding: 8px 0; color: #000;">: {{ $lastPeminjaman->anggota->nama_anggota }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #000; font-weight: 600;">Kelas</td>
                        <td style="padding: 8px 0; color: #000;">: {{ $lastPeminjaman->anggota->institusi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #000; font-weight: 600;">NIS</td>
                        <td style="padding: 8px 0; color: #000;">: {{ $lastPeminjaman->anggota->nis ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Tabel Peminjaman --}}
            <table style="width: 100%; border-collapse: collapse; border: 2px solid #000; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px; width: 40px;">No</th>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px;">Judul Buku</th>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px; width: 120px;">No. Buku</th>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px; width: 100px;">Tgl<br>Pinjam</th>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px; width: 90px;">Paraf<br>Petugas</th>
                        <th style="border: 2px solid #000; padding: 10px; text-align: center; background: #f3f4f6; font-weight: 700; font-size: 13px; width: 100px;">Tgl<br>Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Peminjaman Aktual --}}
                    @foreach($lastPeminjaman->detailPeminjaman as $index => $detail)
                    <tr>
                        <td style="border: 2px solid #000; padding: 10px; text-align: center; font-size: 13px;">{{ $index + 1 }}</td>
                        <td style="border: 2px solid #000; padding: 10px; font-size: 12px;">{{ $detail->eksemplar->buku->judul }}</td>
                        <td style="border: 2px solid #000; padding: 10px; text-align: center; font-size: 12px;">{{ $detail->eksemplar->kode_eksemplar }}</td>
                        <td style="border: 2px solid #000; padding: 10px; text-align: center; font-size: 11px;">{{ \Carbon\Carbon::parse($lastPeminjaman->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                        <td style="border: 2px solid #000; padding: 10px; text-align: center; font-size: 11px; color: #dc2626; font-weight: 600;">{{ \Carbon\Carbon::parse($lastPeminjaman->tgl_jatuh_tempo)->format('d/m/Y') }}</td
                    </tr>
                    @endforeach
                    
                    {{-- Baris Kosong untuk pengisian manual selanjutnya --}}
                    @for($i = count($lastPeminjaman->detailPeminjaman); $i < 10; $i++)
                    <tr>
                        <td style="border: 2px solid #000; padding: 10px; text-align: center; font-size: 13px; height: 40px;">{{ $i + 1 }}</td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                        <td style="border: 2px solid #000; padding: 10px;"></td>
                    </tr>
                    @endfor
                </tbody>
            </table>

            {{-- Footer Info --}}
            <div style="font-size: 11px; color: #6b7280; margin-top: 20px; text-align: center; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB | Petugas: {{ $lastPeminjaman->user->nama_user }}
            </div>
        </div>

        {{-- Action Buttons --}}
        <div style="padding: 0 28px 28px 28px; display: flex; gap: 12px;">
            {{-- Tombol Cetak Kartu --}}
            <button onclick="window.printStruk()"
                    style="flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(37,99,235,.3);"
                    onmouseover="this.style.background='linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'">
                <i data-feather="printer" style="width: 18px; height: 18px;"></i>
                Cetak Kartu Peminjaman
            </button>
            <button wire:click="closeStruk" style="background: #f3f4f6; color: #6b7280; border: none; padding: 14px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;">
                Tutup
            </button>
        </div>
    </div>
</div>
@endif

{{-- Inline Script: Load BEFORE modal rendering --}}
<script>
// Global state — bertahan saat Livewire morph DOM
if (typeof window._selectedBukuIds === 'undefined') window._selectedBukuIds = [];
if (typeof window._bukuMapGlobal   === 'undefined') window._bukuMapGlobal   = {};

// Global toggle function untuk item buku — dipanggil dari onclick
// Menggunakan window globals agar tidak tergantung Alpine lifecycle
window.toggleBuku = function(idEks, idBuku, el) {
    idEks  = Number(idEks);
    idBuku = Number(idBuku);

    if (!window._selectedBukuIds) window._selectedBukuIds = [];
    if (!window._bukuMapGlobal)   window._bukuMapGlobal   = {};

    window._bukuMapGlobal[idEks] = idBuku;

    var picker   = window._bukuPickerInstance;
    var maxBuku  = picker ? picker.maxBuku : 3;
    var idx      = window._selectedBukuIds.indexOf(idEks);
    var isSelected = idx > -1;

    // Cek apakah disabled (buku sama / sudah max)
    if (!isSelected) {
        if (window._selectedBukuIds.length >= maxBuku) return;
        var selectedBukuIds = window._selectedBukuIds.map(function(id) {
            return Number(window._bukuMapGlobal[id]);
        }).filter(Boolean);
        if (selectedBukuIds.indexOf(idBuku) > -1) return;
    }

    // Toggle
    if (isSelected) {
        window._selectedBukuIds.splice(idx, 1);
    } else {
        window._selectedBukuIds.push(idEks);
    }

    // Invalidate cache
    if (picker) picker._cachedBukuIds = null;

    // Update DOM langsung — tidak perlu Alpine re-render
    var allItems = document.querySelectorAll('.peminjaman-book-item[data-id-eks]');
    allItems.forEach(function(item) {
        var eid = Number(item.getAttribute('data-id-eks'));
        var bid = Number(item.getAttribute('data-id-buku'));

        var isSel  = window._selectedBukuIds.indexOf(eid) > -1;
        var selBukuIds = window._selectedBukuIds.map(function(id) {
            return Number(window._bukuMapGlobal[id]);
        }).filter(Boolean);
        var isDis  = !isSel && (
            window._selectedBukuIds.length >= maxBuku ||
            selBukuIds.indexOf(bid) > -1
        );

        item.classList.toggle('selected',  isSel);
        item.classList.toggle('disabled',  isDis);

        var cb = document.getElementById('cb-eks-' + eid);
        if (cb) cb.checked = isSel;

        var badge = item.querySelector('.badge-buku-sama');
        if (badge) badge.style.display = (selBukuIds.indexOf(bid) > -1 && !isSel) ? 'inline' : 'none';
    });

    // Update counter
    var counter = document.getElementById('bukuSelectedCount');
    if (counter) counter.textContent = window._selectedBukuIds.length;
};

// Alpine.js component for buku picker
function bukuPicker(initialSelected, maxBuku, initialBukuMap) {
    return {
        maxBuku: maxBuku,

        get selected() {
            return window._selectedBukuIds;
        },
        set selected(val) {
            window._selectedBukuIds = val;
        },

        get bukuMap() {
            return window._bukuMapGlobal;
        },
        set bukuMap(val) {
            window._bukuMapGlobal = val;
        },

        _cachedBukuIds: null,

        init() {
            // Merge bukuMap baru dari server (data eksemplar terbaru)
            var newMap = initialBukuMap || {};
            for (var key in newMap) {
                if (newMap.hasOwnProperty(key)) {
                    window._bukuMapGlobal[key] = newMap[key];
                }
            }

            // Simpan reference
            window._bukuPickerInstance = this;

            // Listen untuk reset event (saat modal dibuka ulang)
            if (!window._bukuPickerResetBound) {
                window._bukuPickerResetBound = true;
                window.addEventListener('reset-buku-picker', function() {
                    window._selectedBukuIds = [];
                    window._bukuMapGlobal = {};
                    if (window._bukuPickerInstance) {
                        window._bukuPickerInstance._cachedBukuIds = null;
                    }
                });
            }
        },

        toggle(idEks, idBuku) {
            idEks  = Number(idEks);
            idBuku = Number(idBuku);
            window._bukuMapGlobal[idEks] = idBuku;

            const idx = window._selectedBukuIds.indexOf(idEks);
            if (idx > -1) {
                window._selectedBukuIds.splice(idx, 1);
            } else {
                if (!this.isDisabled(idEks, idBuku)) {
                    window._selectedBukuIds.push(idEks);
                }
            }
            this._cachedBukuIds = null;
        },

        isDisabled(idEks, idBuku) {
            idEks  = Number(idEks);
            idBuku = Number(idBuku);
            if (window._selectedBukuIds.includes(idEks)) return false;
            if (window._selectedBukuIds.length >= this.maxBuku) return true;
            return this.selectedBukuIds().includes(idBuku);
        },

        selectedBukuIds() {
            if (this._cachedBukuIds !== null) return this._cachedBukuIds;
            this._cachedBukuIds = window._selectedBukuIds
                .map(function(id) { return Number(window._bukuMapGlobal[id]); })
                .filter(Boolean);
            return this._cachedBukuIds;
        },

        getSelected() {
            return window._selectedBukuIds;
        },
    };
}

// Define print function globally IMMEDIATELY - BEFORE any modal loads
if (typeof window.printStruk === 'undefined') {
    window.printStruk = function() {
        var strukContent = document.getElementById('strukContent');
        if (!strukContent) {
            console.error('strukContent element not found');
            return;
        }
        
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        var html = '<!DOCTYPE html><html><head><title>Slip Pinjaman Perpustakaan</title><style>';
        html += 'body { font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; }';
        html += '* { box-sizing: border-box; }';
        html += 'img { max-width: 100%; }';
        html += '</style></head><body>' + strukContent.innerHTML + '</body></html>';
        
        printWindow.document.write(html);
        printWindow.document.close();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }, 800);
    };
}
</script>

@push('scripts')
<script>
if (typeof window.peminjamanScriptLoaded === 'undefined') {
    window.peminjamanScriptLoaded = true;
    
    let featherRefreshTimeout;
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            clearTimeout(featherRefreshTimeout);
            featherRefreshTimeout = setTimeout(function() {
                feather.replace();
            }, 100);
        }
    };
    
    document.addEventListener('livewire:init', function() {
        refreshFeatherIcons();
        
        Livewire.hook('morph.updated', (el, component) => {
            refreshFeatherIcons();
        });

        Livewire.hook('commit', function() {
            refreshFeatherIcons();
        });
        
        Livewire.on('close-modal', function() {
            if (typeof $ !== 'undefined') {
                console.log('🚪 Menutup modal dan reset state...');
                
                // Reset state sebelum tutup modal
                window._selectedBukuIds = [];
                window._bukuMapGlobal = {};
                if (window._bukuPickerInstance) {
                    window._bukuPickerInstance._cachedBukuIds = null;
                }
                
                // Hilangkan focus dari element aktif sebelum tutup modal
                if (document.activeElement) {
                    document.activeElement.blur();
                }
                
                // Tutup modal
                $('#addPeminjamanModal').modal('hide');
                
                // Aggressively cleanup setelah 500ms
                setTimeout(function() {
                    $('.modal').modal('hide');
                    $('.modal-backdrop').fadeOut(300, function() {
                        $(this).remove();
                    });
                    $('body').removeClass('modal-open').css('padding-right', '').css('overflow', '');
                }, 500);
            }
        });
        
        // Reset Alpine buku picker saat modal dibuka kembali
        $('#addPeminjamanModal').on('show.bs.modal', function() {
            console.log('🔄 Modal dibuka, reset pilihan buku...');
            
            // Tunggu sebentar untuk memastikan DOM sudah siap
            setTimeout(function() {
                // Reset state global
                window._selectedBukuIds = [];
                window._bukuMapGlobal = {};
                
                // Reset cache
                if (window._bukuPickerInstance) {
                    window._bukuPickerInstance._cachedBukuIds = null;
                }
                
                // Reset tampilan DOM
                document.querySelectorAll('.peminjaman-book-item').forEach(function(item) {
                    item.classList.remove('selected', 'disabled');
                    var eid = item.getAttribute('data-id-eks');
                    var cb = document.getElementById('cb-eks-' + eid);
                    if (cb) cb.checked = false;
                });
                
                // Reset counter
                var counter = document.getElementById('bukuSelectedCount');
                if (counter) counter.textContent = '0';
                
                // Dispatch event agar Alpine reset pilihan buku
                window.dispatchEvent(new CustomEvent('reset-buku-picker'));
                
                console.log('✅ Reset selesai. State buku:', window._selectedBukuIds);
            }, 100);
        });
        
        // Reset juga saat modal ditutup untuk cleanup
        $('#addPeminjamanModal').on('hidden.bs.modal', function() {
            console.log('🔄 Modal ditutup, cleanup pilihan buku...');
            
            // Reset state global
            window._selectedBukuIds = [];
            window._bukuMapGlobal = {};
            
            // Reset cache
            if (window._bukuPickerInstance) {
                window._bukuPickerInstance._cachedBukuIds = null;
            }
            
            console.log('✅ Cleanup selesai.');
        });
        
        Livewire.on('refresh-icons', function() {
            setTimeout(function() {
                refreshFeatherIcons();
            }, 600); // Delay lebih lama untuk memastikan DOM ter-update
        });

        Livewire.on('debug-error', function(event) {
            const msg = event.message || event[0].message;
            console.error('🔴 [DEBUG ERROR DARI SERVER]:', msg);
        });
        
        Livewire.on('email-sent', function(event) {
            const email = event.email || event[0].email;
            
            // Buat alert sukses
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 350px; border-radius: 12px; border-left: 4px solid #10b981; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center;">
                        <i data-feather="mail" style="width: 20px; height: 20px; margin-right: 10px; color: #10b981;"></i>
                        <div>
                            <strong>Email Terkirim!</strong><br>
                            <span style="font-size: 13px;">Notifikasi dikirim ke ${email}</span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" style="margin-left: 10px;">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            
            $('body').append(alertHtml);
            refreshFeatherIcons();
            
            // Auto hide setelah 5 detik
            setTimeout(function() {
                $('.alert-success').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 15000);
        });
        
        Livewire.on('email-failed', function(event) {
            const error = event.error || event[0].error;
            
            // Buat alert error
            const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 350px; border-radius: 12px; border-left: 4px solid #ef4444; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center;">
                        <i data-feather="alert-circle" style="width: 20px; height: 20px; margin-right: 10px; color: #ef4444;"></i>
                        <div>
                            <strong>Email Gagal Dikirim!</strong><br>
                            <span style="font-size: 13px;">${error}</span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" style="margin-left: 10px;">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            
            $('body').append(alertHtml);
            refreshFeatherIcons();
            
            // Auto hide setelah 5 detik
            setTimeout(function() {
                $('.alert-danger').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 15000);
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        refreshFeatherIcons();
    });
}
</script>
@endpush

</div>