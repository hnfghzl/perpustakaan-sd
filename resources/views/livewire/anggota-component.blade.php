<div>
    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
            <h5 class="mb-0" style="color: white; font-weight: 600;">Mengelola Anggota Perpustakaan</h5>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            {{-- Header Actions --}}
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <i data-feather="users" style="width: 24px; height: 24px; color: white;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0" style="font-weight: 600; color: #111827;">Total Anggota</h6>
                                <p class="mb-0" style="font-size: 24px; font-weight: 700; color: #1ABC9C;">{{ $anggota->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 12px; padding: 12px 28px; box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.3)';" data-toggle="modal" data-target="#addAnggotaModal">
                            <i data-feather="user-plus" style="width: 18px; height: 18px;"></i> Tambah Anggota Baru
                        </button>
                    </div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="input-group" style="max-width: 500px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background: white; border: 2px solid #e5e7eb; border-right: none; border-radius: 12px 0 0 12px;">
                            <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                        </span>
                    </div>
                    <input type="text"
                        class="form-control"
                        wire:model.live="search"
                        placeholder="Cari nama, jenis, atau institusi..."
                        style="border: 2px solid #e5e7eb; border-left: none; border-radius: 0 12px 12px 0; padding: 12px 16px; font-size: 14px;">
                </div>
            </div>

            {{-- Anggota List Compact --}}
            <div class="list-group" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                @forelse ($anggota as $data)
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #e5e7eb; padding: 16px 20px; transition: all 0.2s; background: white;" onmouseover="this.style.background='#f9fafb';" onmouseout="this.style.background='white';">
                    <div class="row align-items-center">
                        {{-- Avatar & Name (Col 1) --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                {{-- Avatar --}}
                                <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                    <span style="font-size: 16px; color: white; font-weight: 700;">
                                        {{ strtoupper(substr($data->nama_anggota, 0, 1)) }}
                                    </span>
                                </div>
                                
                                <div style="min-width: 0;">
                                    <h6 class="mb-1" style="color: #111827; font-weight: 600; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $data->nama_anggota }}
                                    </h6>
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        @if($data->jenis_anggota === 'guru')
                                        <span class="badge" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; font-weight: 500; padding: 2px 8px; border-radius: 10px; font-size: 10px;">
                                            <i data-feather="briefcase" style="width: 10px; height: 10px;"></i> Guru
                                        </span>
                                        @else
                                        <span class="badge" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; font-weight: 500; padding: 2px 8px; border-radius: 10px; font-size: 10px;">
                                            <i data-feather="graduation-cap" style="width: 10px; height: 10px;"></i> Siswa
                                        </span>
                                        @endif
                                        
                                        @if($data->jenis_kelamin === 'laki-laki')
                                        <span style="color: #3b82f6; font-size: 11px;">
                                            <i data-feather="user" style="width: 11px; height: 11px;"></i> L
                                        </span>
                                        @else
                                        <span style="color: #ec4899; font-size: 11px;">
                                            <i data-feather="user" style="width: 11px; height: 11px;"></i> P
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Info Details (Col 2) --}}
                        <div class="col-md-5 d-none d-md-block">
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-0" style="font-size: 10px; color: #9ca3af; font-weight: 600; text-transform: uppercase;">Lahir</p>
                                    <p class="mb-1" style="color: #374151; font-size: 12px; font-weight: 500;">
                                        {{ $data->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0" style="font-size: 10px; color: #9ca3af; font-weight: 600; text-transform: uppercase;">Member Since</p>
                                    <p class="mb-1" style="color: #374151; font-size: 12px; font-weight: 500;">
                                        {{ $data->anggota_sejak ? \Carbon\Carbon::parse($data->anggota_sejak)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div style="margin-top: 4px;">
                                <p class="mb-0" style="font-size: 10px; color: #f59e0b; font-weight: 600;">
                                    <i data-feather="clock" style="width: 10px; height: 10px;"></i> Valid: {{ $data->berlaku_hingga ? \Carbon\Carbon::parse($data->berlaku_hingga)->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- Actions (Col 3) --}}
                        <div class="col-md-3 text-right">
                            <div class="d-flex justify-content-end align-items-center" style="gap: 6px;" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="edit({{ $data->id_anggota }})"
                                    class="btn btn-sm"
                                    style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 8px; padding: 6px 12px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(22, 160, 133, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                    data-toggle="modal"
                                    data-target="#editAnggotaModal">
                                    <i data-feather="edit-2" style="width: 13px; height: 13px;"></i>
                                    <span class="d-none d-lg-inline"> Edit</span>
                                </button>

                                <button wire:click="confirmDelete({{ $data->id_anggota }})"
                                    class="btn btn-sm"
                                    style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; font-weight: 500; border-radius: 8px; padding: 6px 12px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(220, 38, 38, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i data-feather="trash-2" style="width: 13px; height: 13px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item" style="border: none; padding: 60px 20px; text-align: center; background: #f9fafb;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                        <i data-feather="inbox" style="width: 40px; height: 40px; color: #9ca3af;"></i>
                    </div>
                    <h6 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">Tidak ada data anggota</h6>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 0;">Tambahkan anggota baru untuk memulai</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $anggota->links() }}
            </div>
        </div>

        {{-- ==================== MODAL TAMBAH ANGGOTA ==================== --}}
        <div wire:ignore.self class="modal fade" id="addAnggotaModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
                        <div>
                            <h5 class="modal-title mb-1" style="color: white; font-weight: 600; font-size: 20px;">
                                <i data-feather="user-plus" style="width: 20px; height: 20px;"></i> Tambah Anggota Baru
                            </h5>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 13px;">Daftarkan anggota perpustakaan baru</p>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
                    </div>

                    <div class="modal-body" style="padding: 28px;">
                        <form>
                            {{-- Section 1: Personal Info --}}
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                    <i data-feather="user" style="width: 16px; height: 16px;"></i> Data Pribadi
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" wire:model="nama_anggota" placeholder="Contoh: Ahmad Hidayat" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 14px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                        @error('nama_anggota') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> {{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" wire:model="email" placeholder="contoh@email.com" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 14px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                        @error('email') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> {{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">
                                            Jenis Anggota <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" wire:model="jenis_anggota" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 14px; font-size: 14px; color: #374151; background-color: white;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                            <option value="" style="color: #9ca3af;">-- Pilih --</option>
                                            <option value="guru" style="color: #374151;">Guru</option>
                                            <option value="siswa" style="color: #374151;">Siswa</option>
                                        </select>
                                        @error('jenis_anggota') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> {{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">
                                            Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" wire:model="jenis_kelamin" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 14px; font-size: 14px; color: #374151; background-color: white;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                            <option value="" style="color: #9ca3af;">-- Pilih --</option>
                                            <option value="laki-laki" style="color: #374151;">Laki-laki</option>
                                            <option value="perempuan" style="color: #374151;">Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> {{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Tanggal Lahir</label>
                                        <input type="date" class="form-control" wire:model="tgl_lahir" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 10px 14px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                        @error('tgl_lahir') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 11px; height: 11px;"></i> {{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Membership Info --}}
                            <div style="background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                                <h6 style="color: #92400e; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                    <i data-feather="credit-card" style="width: 16px; height: 16px;"></i> Keanggotaan
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label style="font-weight: 600; color: #92400e; margin-bottom: 8px; font-size: 13px;">Anggota Sejak</label>
                                        <input type="date" class="form-control" wire:model="anggota_sejak" style="border-radius: 10px; border: 2px solid #fbbf24; padding: 10px 14px; font-size: 14px; background: white;" onfocus="this.style.borderColor='#f59e0b';" onblur="this.style.borderColor='#fbbf24';">
                                        <small style="color: #92400e; font-size: 11px; margin-top: 4px; display: block;">
                                            <i data-feather="info" style="width: 10px; height: 10px;"></i> Kosongkan untuk hari ini
                                        </small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label style="font-weight: 600; color: #92400e; margin-bottom: 8px; font-size: 13px;">Berlaku Hingga</label>
                                        <input type="date" class="form-control" wire:model="berlaku_hingga" style="border-radius: 10px; border: 2px solid #fbbf24; padding: 10px 14px; font-size: 14px; background: white;" onfocus="this.style.borderColor='#f59e0b';" onblur="this.style.borderColor='#fbbf24';">
                                        <small style="color: #92400e; font-size: 11px; margin-top: 4px; display: block;">
                                            <i data-feather="info" style="width: 10px; height: 10px;"></i> Kosongkan untuk 5 tahun ke depan
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 3: Additional Info --}}
                            <div style="background: #eff6ff; padding: 20px; border-radius: 12px; border-left: 4px solid #3b82f6;">
                                <h6 style="color: #1e40af; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                    <i data-feather="map-pin" style="width: 16px; height: 16px;"></i> Informasi Tambahan
                                </h6>
                                
                                <div class="mb-3">
                                    <label style="font-weight: 600; color: #1e40af; margin-bottom: 8px; font-size: 13px;">Institusi</label>
                                    <input type="text" class="form-control" wire:model="institusi" placeholder="SD MUHAMMADIYAH KARANG WARU" style="border-radius: 10px; border: 2px solid #93c5fd; padding: 10px 14px; font-size: 14px; background: white;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#93c5fd';">
                                    <small style="color: #1e40af; font-size: 11px; margin-top: 4px; display: block;">
                                        <i data-feather="info" style="width: 10px; height: 10px;"></i> Kosongkan untuk institusi default
                                    </small>
                                </div>

                                <div>
                                    <label style="font-weight: 600; color: #1e40af; margin-bottom: 8px; font-size: 13px;">Alamat</label>
                                    <textarea class="form-control" wire:model="alamat" rows="3" placeholder="Masukkan alamat lengkap" style="border-radius: 10px; border: 2px solid #93c5fd; padding: 10px 14px; font-size: 14px; background: white;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#93c5fd';"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="border: none; padding: 20px 28px; background: #f9fafb;">
                        <button type="button" class="btn" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; font-weight: 500; border-radius: 10px; padding: 10px 24px;" data-dismiss="modal">
                            <i data-feather="x" style="width: 14px; height: 14px;"></i> Batal
                        </button>
                        <button type="button" wire:click="store" class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 10px; padding: 10px 24px; box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);" data-dismiss="modal">
                            <i data-feather="save" style="width: 14px; height: 14px;"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== MODAL EDIT ANGGOTA ==================== --}}
        <div wire:ignore.self class="modal fade" id="editAnggotaModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none;">
                        <h5 class="modal-title" style="color: white; font-weight: 600;">Edit Anggota</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" wire:model="nama_anggota">
                                        @error('nama_anggota') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" wire:model="email" placeholder="contoh@email.com">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Anggota <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="jenis_anggota">
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="guru">Guru</option>
                                            <option value="siswa">Siswa</option>
                                        </select>
                                        @error('jenis_anggota') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="jenis_kelamin">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" wire:model="tgl_lahir">
                                        @error('tgl_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Anggota Sejak</label>
                                        <input type="date" class="form-control" wire:model="anggota_sejak">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Berlaku Hingga</label>
                                        <input type="date" class="form-control" wire:model="berlaku_hingga">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Institusi</label>
                                <input type="text" class="form-control" wire:model="institusi">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" wire:model="alamat" rows="3"></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" wire:click="update" class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500;" data-dismiss="modal">
                            <i data-feather="save"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ====================== SCRIPT KONFIRMASI HAPUS ====================== --}}
<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('confirm-delete-anggota', (data) => {
            const id = data[0].id;
            if (confirm('Yakin ingin menghapus anggota ini? Data tidak bisa dikembalikan!')) {
                Livewire.dispatch('deleteAnggota', { id: id });
            }
        });
    });

    // Re-initialize feather icons after Livewire updates
    document.addEventListener('livewire:navigated', () => {
        feather.replace();
    });

    // Initialize feather icons on load
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();
    });
</script>

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