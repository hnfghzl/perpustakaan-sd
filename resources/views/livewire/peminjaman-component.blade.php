<div>
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 20px 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(26, 188, 156, 0.2); margin-bottom: 16px; text-align: center;">
            <div style="color: white;">
                <i data-feather="plus-circle" style="width: 48px; height: 48px; color: white; margin-bottom: 12px;"></i>
                <h4 style="margin: 0 0 8px 0; font-weight: 600; font-size: 20px;">Input Peminjaman Buku</h4>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">Klik tombol di bawah untuk menambahkan transaksi peminjaman baru</p>
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

        {{-- Info Box: Business Rules --}}
        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 14px 18px; border-radius: 8px; margin-bottom: 16px; border-left: 3px solid #3b82f6;">
            <div style="display: flex; align-items: start;">
                <i data-feather="info" style="width: 18px; height: 18px; color: #1e40af; margin-right: 12px; flex-shrink: 0; margin-top: 2px;"></i>
                <div style="flex: 1;">
                    <strong style="color: #1e3a8a; font-size: 14px; display: block; margin-bottom: 6px;">Aturan Peminjaman:</strong>
                    <div style="color: #1e3a8a; font-size: 13px; line-height: 1.8;">
                        • Anggota dengan peminjaman aktif tidak bisa pinjam lagi<br>
                        • Maksimal 3 buku berbeda per transaksi<br>
                        • Lihat semua history di <strong>Master Data → History Peminjaman</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Button --}}
        @if($isPustakawan)
        <div style="text-align: center; padding: 40px 20px;">
            <button wire:click="openForm" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(26, 188, 156, 0.3); transition: all 0.3s; cursor: pointer; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(26, 188, 156, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(26, 188, 156, 0.3)';">
                <i data-feather="plus" style="width: 20px; height: 20px;"></i>
                Buat Peminjaman Baru
            </button>
            <p style="color: #6b7280; font-size: 13px; margin-top: 12px;">Untuk melihat history transaksi, buka <strong>Master Data → History Peminjaman</strong></p>
        </div>
        @else
        <div style="text-align: center; padding: 40px 20px;">
            <div style="background: #f3f4f6; padding: 24px; border-radius: 12px; display: inline-block;">
                <i data-feather="lock" style="width: 48px; height: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                <p style="color: #6b7280; font-size: 14px; margin: 0;">Hanya pustakawan yang dapat membuat peminjaman baru</p>
            </div>
        </div>
        @endif

        {{-- Modal Form Peminjaman --}}
        @if($showForm)
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1050; padding: 20px;" wire:click.self="closeForm">
            <div style="background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 1200px; width: 100%; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column;">
                {{-- Header --}}
                <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 20px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <h5 style="margin: 0; color: white; font-weight: 600; display: flex; align-items: center; font-size: 18px;">
                        <i data-feather="plus" style="width: 22px; height: 22px; margin-right: 10px;"></i>
                        Form Tambah Peminjaman
                    </h5>
                    <button wire:click="closeForm" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(255,255,255,0.2)';">
                        <i data-feather="x" style="width: 20px; height: 20px;"></i>
                    </button>
                </div>
                
                {{-- Body --}}
                <div style="padding: 28px; overflow-y: auto; flex: 1;">
                    <div class="row">
                    {{-- Kolom Kiri: Info Peminjaman --}}
                    <div class="col-md-5">
                        {{-- Section 1: Data Peminjam (Gray) --}}
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="user" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                Data Peminjam
                            </h6>
                            
                            <div style="margin-bottom: 16px;">
                                <label style="color: #374151; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">
                                    Anggota <span style="color: #ef4444;">*</span>
                                </label>
                                <select wire:model.live="id_anggota" style="width: 100%; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($anggotaList as $a)
                                    <option value="{{ $a->id_anggota }}">{{ $a->nama_anggota }} ({{ $a->jenis_anggota == 'guru' ? 'Guru' : 'Siswa' }})</option>
                                    @endforeach
                                </select>
                                @error('id_anggota')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                            </div>
                            
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

                        {{-- Section 2: Jadwal Peminjaman (Yellow) --}}
                        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #78350f; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="calendar" style="width: 18px; height: 18px; margin-right: 8px; color: #d97706;"></i>
                                Jadwal Peminjaman
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #78350f; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">
                                        Tgl Pinjam <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="date" wire:model="tgl_pinjam" style="width: 100%; padding: 10px 14px; border: 2px solid #fbbf24; border-radius: 8px; font-size: 14px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#fbbf24'; this.style.boxShadow='none';">
                                    @error('tgl_pinjam')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #78350f; font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">
                                        Jatuh Tempo <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="date" wire:model="tgl_jatuh_tempo" style="width: 100%; padding: 10px 14px; border: 2px solid #fbbf24; border-radius: 8px; font-size: 14px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#fbbf24'; this.style.boxShadow='none';">
                                    @error('tgl_jatuh_tempo')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div style="background: rgba(255,255,255,0.7); padding: 12px; border-radius: 8px; font-size: 12px; color: #78350f;">
                                <i data-feather="info" style="width: 14px; height: 14px;"></i>
                                <strong>Info:</strong> Tentukan tanggal jatuh tempo sesuai kebijakan perpustakaan
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

                        {{-- Section 3: Info Pilihan (Blue) --}}
                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center;">
                                    <i data-feather="info" style="width: 16px; height: 16px; color: #1e40af; margin-right: 8px;"></i>
                                    <span style="color: #1e3a8a; font-weight: 600; font-size: 13px;">Dipilih:</span>
                                </div>
                                <span style="background: linear-gradient(135deg, {{ count($selectedEksemplar ?? []) >= 3 ? '#ef4444 0%, #dc2626' : '#1ABC9C 0%, #16A085' }} 100%); color: white; font-weight: 600; padding: 4px 12px; border-radius: 6px; font-size: 13px;">
                                    {{ count($selectedEksemplar ?? []) }}/3 buku
                                </span>
                            </div>
                            <div style="color: #1e3a8a; font-size: 12px; line-height: 1.7;">
                                <div style="margin-bottom: 4px;">
                                    <strong>Tersedia:</strong> {{ $eksemplarList->count() }} eksemplar
                                </div>
                                <div style="color: #991b1b; font-weight: 600; margin-top: 8px; padding: 8px; background: rgba(254, 226, 226, 0.5); border-radius: 6px;">
                                    ⚠️ Maks 3 buku, harus beda judul!
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Kolom Kanan: Pilih Buku --}}
                    <div class="col-md-7">
                        <h6 style="color: #374151; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="display: flex; align-items: center;">
                                <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                Pilih Buku <span style="color: #ef4444; margin-left: 4px;">*</span>
                            </span>
                            <span style="font-size: 12px; color: #6b7280; font-weight: 400;">
                                <span style="color: #1ABC9C; font-weight: 600;">{{ count($selectedEksemplar) }}</span>/3 dipilih
                            </span>
                        </h6>
                        
                        {{-- Search Box untuk Filter Buku --}}
                        <div style="position: relative; margin-bottom: 8px;">
                            <i data-feather="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #9ca3af;"></i>
                            <input type="text" 
                                wire:model.live="searchBuku" 
                                placeholder="Cari judul, kategori, nomor panggil, atau kode eksemplar..." 
                                style="width: 100%; padding: 8px 10px 8px 38px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 12px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 2px rgba(26, 188, 156, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        @if($searchBuku)
                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 8px; padding-left: 4px;">
                            <i data-feather="info" style="width: 11px; height: 11px;"></i>
                            Ditemukan <strong style="color: #1ABC9C;">{{ $eksemplarList->count() }}</strong> buku dari pencarian "{{ $searchBuku }}"
                        </div>
                        @endif
                        
                        <div style="border: 2px solid #e5e7eb; padding: 12px; max-height: 380px; overflow-y: auto; border-radius: 12px; background: #f9fafb;">
                            @if($eksemplarList->count() > 0)
                                @php
                                    // Ambil id_buku dari eksemplar yang sudah dipilih
                                    $selectedBukuIds = [];
                                    foreach($selectedEksemplar ?? [] as $id_eks) {
                                        $eks = $eksemplarList->firstWhere('id_eksemplar', $id_eks);
                                        if($eks) {
                                            $selectedBukuIds[] = $eks->id_buku;
                                        }
                                    }
                                @endphp
                                @foreach($eksemplarList as $e)
                                @php
                                    // Cek apakah buku ini sudah dipilih (id_buku duplikat)
                                    $isChecked = in_array($e->id_eksemplar, $selectedEksemplar ?? []);
                                    $bukuSudahDipilih = in_array($e->id_buku, $selectedBukuIds) && !$isChecked;
                                    $sudahMax = count($selectedEksemplar ?? []) >= 3 && !$isChecked;
                                    $isDisabled = $bukuSudahDipilih || $sudahMax;
                                @endphp
                                <div style="background: {{ $isChecked ? 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)' : 'white' }}; border: 2px solid {{ $isChecked ? '#10b981' : '#e5e7eb' }}; border-radius: 10px; padding: 14px 16px; margin-bottom: 10px; cursor: {{ $isDisabled && !$isChecked ? 'not-allowed' : 'pointer' }}; opacity: {{ $isDisabled && !$isChecked ? '0.5' : '1' }}; transition: all 0.2s;" {{ !$isDisabled || $isChecked ? "onmouseover=\"this.style.borderColor='" . ($isChecked ? '#059669' : '#1ABC9C') . "'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';\" onmouseout=\"this.style.borderColor='" . ($isChecked ? '#10b981' : '#e5e7eb') . "'; this.style.transform='translateY(0)'; this.style.boxShadow='none';\"" : '' }}>
                                    <div style="display: flex; align-items: start;">
                                        <div style="flex-shrink: 0; margin-right: 12px; margin-top: 2px;">
                                            <input type="checkbox" 
                                                wire:model.live="selectedEksemplar" 
                                                value="{{ $e->id_eksemplar }}" 
                                                id="e{{ $e->id_eksemplar }}"
                                                {{ $isDisabled && !$isChecked ? 'disabled' : '' }}
                                                style="width: 18px; height: 18px; cursor: {{ $isDisabled && !$isChecked ? 'not-allowed' : 'pointer' }}; accent-color: #1ABC9C;">
                                        </div>
                                        <label for="e{{ $e->id_eksemplar }}" style="flex: 1; cursor: {{ $isDisabled && !$isChecked ? 'not-allowed' : 'pointer' }};">
                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                                <span style="font-weight: 600; color: {{ $isChecked ? '#065f46' : '#1ABC9C' }}; font-size: 13px;">{{ $e->kode_eksemplar }}</span>
                                                @if($bukuSudahDipilih)
                                                    <span style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; font-size: 11px; padding: 3px 8px; border-radius: 6px; font-weight: 600;">Buku sudah dipilih</span>
                                                @endif
                                            </div>
                                            <div style="color: {{ $isChecked ? '#065f46' : '#374151' }}; font-size: 14px; font-weight: 600; margin-bottom: 6px;">{{ $e->buku->judul }}</div>
                                            <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: {{ $isChecked ? '#047857' : '#6b7280' }};">
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="tag" style="width: 11px; height: 11px; margin-right: 4px;"></i>
                                                    {{ $e->buku->no_panggil ?? '-' }}
                                                </span>
                                                @if($e->buku->kategori)
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="folder" style="width: 11px; height: 11px; margin-right: 4px;"></i>
                                                    {{ $e->buku->kategori->nama }}
                                                </span>
                                                @endif
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="map-pin" style="width: 11px; height: 11px; margin-right: 4px;"></i>
                                                    {{ $e->lokasi_rak ?? 'Tidak ada lokasi' }}
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div style="text-align: center; padding: 40px 20px;">
                                    <i data-feather="{{ $searchBuku ? 'search' : 'inbox' }}" style="width: 48px; height: 48px; color: #9ca3af;"></i>
                                    <p style="color: #6b7280; margin: 12px 0 0 0; font-size: 14px;">
                                        @if($searchBuku)
                                            Tidak ada buku yang cocok dengan pencarian "{{ $searchBuku }}"
                                        @else
                                            Tidak ada buku yang tersedia untuk dipinjam
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
            
                {{-- Footer --}}
                <div style="padding: 20px 28px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb;">
                    <button wire:click="closeForm" style="background: #6b7280; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#4b5563'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(107, 114, 128, 0.3)';" onmouseout="this.style.background='#6b7280'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                    </button>
                    <button wire:click="store" 
                            {{ $peminjamanAktifAnggota > 0 ? 'disabled' : '' }}
                            title="{{ $peminjamanAktifAnggota > 0 ? 'Anggota masih memiliki peminjaman aktif' : '' }}" 
                            style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; transition: all 0.3s; cursor: pointer; {{ $peminjamanAktifAnggota > 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}" 
                            {{ $peminjamanAktifAnggota == 0 ? "onmouseover=\"this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';\" onmouseout=\"this.style.transform='translateY(0)'; this.style.boxShadow='none';\"" : '' }}>
                        <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Peminjaman
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@assets
<script>
    // Global function untuk refresh feather icons
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            setTimeout(() => {
                feather.replace();
            }, 150); // Delay lebih lama
        }
    }
</script>
@endassets

<script data-navigate-once>document.addEventListener('livewire:initialized', () => {
    // Initialize on load
    refreshFeatherIcons();
    
    // Livewire 3 lifecycle hooks - SEMUA HOOK
    Livewire.hook('element.init', ({ component, el }) => {
        refreshFeatherIcons();
    });
    
    Livewire.hook('element.updated', ({ component, el }) => {
        refreshFeatherIcons();
    });
    
    Livewire.hook('morph.updated', ({ el, component }) => {
        refreshFeatherIcons();
    });
    
    Livewire.hook('commit', ({ component, respond }) => {
        refreshFeatherIcons();
    });
    
    Livewire.hook('commit.pooling', () => {
        refreshFeatherIcons();
    });
    
    // Custom events
    Livewire.on('refresh-icons', () => {
        refreshFeatherIcons();
    });
    
    Livewire.on('modal-closed', () => {
        refreshFeatherIcons();
    });
    
    // MutationObserver sebagai backup terakhir
    const observer = new MutationObserver((mutations) => {
        refreshFeatherIcons();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});</script>
