<div>
    {{-- Flash Messages --}}
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
        <i data-feather="check-circle" style="width: 18px; height: 18px;"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
        <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i>
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    {{-- Header --}}
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="color: #374151; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center;">
                    <i data-feather="settings" style="width: 24px; height: 24px; margin-right: 10px; color: #3b82f6;"></i>
                    Pengaturan Sistem Perpustakaan
                </h4>
                <p style="color: #6b7280; margin: 0; font-size: 14px;">
                    Kelola durasi peminjaman, denda, dan aturan perpustakaan
                </p>
            </div>
        </div>
    </div>

    {{-- Form Pengaturan --}}
    <div style="background: white; padding: 28px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form wire:submit.prevent="simpan">
            <div class="row">
                {{-- Durasi Peminjaman --}}
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="calendar" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Durasi Peminjaman (Hari)
                        </label>
                        <input type="number" wire:model="pengaturan.durasi_peminjaman_hari" min="1" max="90" 
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Jumlah hari maksimal untuk meminjam buku (1-90 hari)
                        </small>
                        @error('pengaturan.durasi_peminjaman_hari')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Max Buku per Peminjaman --}}
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Maksimal Buku per Peminjaman
                        </label>
                        <input type="number" wire:model="pengaturan.max_buku_per_peminjaman" min="1" max="10" 
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Jumlah maksimal buku dalam satu transaksi (1-10 buku)
                        </small>
                        @error('pengaturan.max_buku_per_peminjaman')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Denda per Hari --}}
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="clock" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Denda Keterlambatan per Hari
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_per_hari" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda per hari per buku yang terlambat
                        </small>
                        @error('pengaturan.denda_per_hari')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Denda Rusak --}}
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="tool" style="width: 18px; height: 18px; margin-right: 8px; color: #f59e0b;"></i>
                            Denda Buku Rusak
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_rusak" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda untuk buku yang dikembalikan rusak
                        </small>
                        @error('pengaturan.denda_rusak')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Denda Hilang --}}
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="alert-triangle" style="width: 18px; height: 18px; margin-right: 8px; color: #ef4444;"></i>
                            Denda Buku Hilang
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_hilang" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#ef4444'; this.style.boxShadow='0 0 0 3px rgba(239, 68, 68, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda untuk buku yang hilang/tidak dikembalikan
                        </small>
                        @error('pengaturan.denda_hilang')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ======== IDENTITAS SEKOLAH (untuk Kartu Anggota) ======== --}}
            <div style="background: #f0f9ff; border: 2px solid #0284c7; border-radius: 12px; padding: 24px; margin-top: 32px; margin-bottom: 24px;">
                <h5 style="color: #075985; font-weight: 700; margin-bottom: 6px; display: flex; align-items: center;">
                    <i data-feather="credit-card" style="width: 22px; height: 22px; margin-right: 10px; color: #0284c7;"></i>
                    Identitas Sekolah (Kartu Anggota)
                </h5>
                <p style="color: #0369a1; font-size: 13px; margin-bottom: 20px;">
                    Data berikut tampil di kartu anggota perpustakaan saat dicetak.
                </p>
                <div class="row">
                    {{-- Nama Sekolah --}}
                    <div class="col-md-12 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">Nama Sekolah</label>
                        <input type="text" wire:model="pengaturan.nama_sekolah" placeholder="Contoh: SD MUHAMMADIYAH KARANGWARU"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    {{-- Alamat Sekolah --}}
                    <div class="col-md-8 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">Alamat Sekolah</label>
                        <input type="text" wire:model="pengaturan.alamat_sekolah" placeholder="Contoh: Jl. Karangwaru Lor No. 1"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    {{-- Telepon Sekolah --}}
                    <div class="col-md-4 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">Telepon Sekolah</label>
                        <input type="text" wire:model="pengaturan.telp_sekolah" placeholder="Contoh: (0274) 123456"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    {{-- Kota --}}
                    <div class="col-md-4 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">Kota</label>
                        <input type="text" wire:model="pengaturan.kota_sekolah" placeholder="Contoh: Yogyakarta"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    {{-- Nama Kepala Sekolah --}}
                    <div class="col-md-5 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">Nama Kepala Sekolah</label>
                        <input type="text" wire:model="pengaturan.nama_kepala_sekolah" placeholder="Contoh: Budi Santoso, S.Pd."
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                    {{-- NIP Kepala --}}
                    <div class="col-md-3 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 8px; display: block; font-size: 14px;">NIP Kepala Sekolah</label>
                        <input type="text" wire:model="pengaturan.nip_kepala_sekolah" placeholder="Kosongkan jika tidak ada"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#0284c7'; this.style.boxShadow='0 0 0 3px rgba(2,132,199,0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    </div>
                </div>
            </div>

            {{-- WhatsApp (Fonnte) Configuration Section --}}
            <div style="background: #f0fdf4; border: 2px solid #16a34a; border-radius: 12px; padding: 24px; margin-top: 32px; margin-bottom: 24px;">
                <h5 style="color: #14532d; font-weight: 700; margin-bottom: 18px; display: flex; align-items: center;">
                    <i data-feather="message-circle" style="width: 22px; height: 22px; margin-right: 10px; color: #16a34a;"></i>
                    Konfigurasi Notifikasi WhatsApp (Fonnte)
                </h5>
                <p style="color: #166534; font-size: 13px; margin-bottom: 20px;">
                    Masukkan token Fonnte untuk mengirim notifikasi WA otomatis ke anggota saat peminjaman &amp; pengembalian buku.
                </p>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Token Fonnte
                        </label>
                        <input type="password" wire:model="pengaturan.fonnte_token" placeholder="Paste token Fonnte di sini..."
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s; font-family: monospace;"
                            onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 3px rgba(22, 163, 74, 0.1)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Dapatkan token di <strong>fonnte.com</strong> &rarr; Login &rarr; <strong>Devices</strong> &rarr; Tambah Device &rarr; Scan QR &rarr; Copy Token.
                        </small>
                        @error('pengaturan.fonnte_token')
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Panduan Fonnte --}}
                <div style="background: #dcfce7; border-left: 4px solid #16a34a; padding: 14px 16px; border-radius: 8px; margin-top: 8px;">
                    <div style="display: flex; align-items: start;">
                        <i data-feather="info" style="width: 18px; height: 18px; margin-right: 10px; color: #16a34a; flex-shrink: 0; margin-top: 2px;"></i>
                        <div style="color: #14532d; font-size: 13px; line-height: 1.7;">
                            <strong>Cara setup Fonnte:</strong><br>
                            1. Daftar/login ke <a href="https://fonnte.com" target="_blank" style="color: #16a34a; text-decoration: underline;">fonnte.com</a><br>
                            2. Di menu <strong>Devices</strong>, klik <strong>Add Device</strong><br>
                            3. Scan QR Code dengan WhatsApp HP yang akan menjadi pengirim<br>
                            4. Setelah terhubung, copy <strong>Token</strong> device lalu paste di field di atas<br>
                            5. Pastikan nomor HP anggota sudah diisi di data anggota
                        </div>
                    </div>
                </div>

                {{-- Status Token --}}
                @if(!empty($pengaturan['fonnte_token'] ?? ''))
                <div style="margin-top: 12px; padding: 10px 14px; background: #bbf7d0; border-radius: 8px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="check-circle" style="width: 16px; height: 16px; color: #16a34a;"></i>
                    <span style="color: #14532d; font-size: 13px; font-weight: 600;">Token Fonnte sudah dikonfigurasi.</span>
                </div>
                @else
                <div style="margin-top: 12px; padding: 10px 14px; background: #fef9c3; border-radius: 8px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="alert-circle" style="width: 16px; height: 16px; color: #ca8a04;"></i>
                    <span style="color: #854d0e; font-size: 13px;">Token belum dikonfigurasi. Notifikasi WA tidak akan terkirim.</span>
                </div>
                @endif
            </div>

            {{-- Info Box --}}
            <div style="background: #eff6ff; border: 1px solid #3b82f6; border-radius: 10px; padding: 16px; margin-top: 10px; margin-bottom: 20px;">
                <div style="display: flex; align-items: start;">
                    <i data-feather="info" style="width: 20px; height: 20px; margin-right: 12px; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
                    <div style="color: #1e40af; font-size: 13px; line-height: 1.6;">
                        <strong>Informasi:</strong> Perubahan pengaturan akan langsung berlaku untuk transaksi peminjaman baru. 
                        Transaksi yang sudah ada tidak akan terpengaruh oleh perubahan ini.
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 10px; border-top: 1px solid #e5e7eb;">
                @if($isPustakawan)
                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan Perubahan
                </button>
                @else
                <div style="background: #f3f4f6; color: #6b7280; padding: 12px 20px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="lock" style="width: 16px; height: 16px;"></i>
                    Hanya pustakawan yang dapat mengubah pengaturan
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

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
    
    Livewire.hook('commit', ({ component, respond }) => {
        refreshFeatherIcons();
    });
    
    const observer = new MutationObserver((mutations) => {
        refreshFeatherIcons();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert) {
                $(alert).fadeOut();
            }
        });
    }, 5000);
});</script>
