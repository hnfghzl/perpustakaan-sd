<div>
    <style>
        .anggota-card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .anggota-card-modern:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .anggota-header-modern {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 28px;
            color: white;
        }
        .anggota-search-modern {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .anggota-search-modern:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .anggota-list-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 20px;
            transition: all 0.2s;
        }
        .anggota-list-item:hover {
            background: #f9fafb;
        }
        .anggota-list-item:last-child {
            border-bottom: none;
        }
        .anggota-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .anggota-badge-guru {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .anggota-badge-siswa {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .anggota-btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .anggota-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }
        .anggota-btn-action {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }
        .anggota-btn-action:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }
        .anggota-btn-delete {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }
        .anggota-btn-delete:hover {
            background: #fee2e2;
            color: #ef4444;
            transform: translateY(-1px);
        }
        .anggota-form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 13px;
            display: block;
        }
        .anggota-form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }
        .anggota-form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .anggota-modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 24px;
            border: none;
        }
    </style>

    {{-- Header --}}
    <div class="anggota-header-modern mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 4px;">Kelola Anggota</h1>
                <p style="opacity: 0.9; font-size: 14px; margin-bottom: 0;">Manajemen data anggota perpustakaan</p>
            </div>
            <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="users" style="width: 32px; height: 32px;"></i>
            </div>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="anggota-card-modern">
        <div style="padding: 24px;">
            {{-- Alert Messages --}}
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border: none; background: #d1fae5; color: #065f46;">
                <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border: none; background: #fee2e2; color: #991b1b;">
                <i data-feather="alert-circle" style="width: 16px; height: 16px;"></i>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            {{-- Stats & Add Button --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div style="width: 56px; height: 56px; background: #dbeafe; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-right: 14px;">
                            <i data-feather="users" style="width: 28px; height: 28px; color: #3b82f6;"></i>
                        </div>
                        <div>
                            <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px; font-weight: 500;">Total Anggota</p>
                            <h3 style="font-size: 32px; font-weight: 700; color: #111827; margin-bottom: 0;">{{ $anggota->total() }}</h3>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6 text-right">
                        @if($isPustakawan)
                        <button data-toggle="modal" data-target="#addAnggotaModal" wire:click="resetInput" class="anggota-btn-primary">
                            <i data-feather="user-plus" style="width: 18px; height: 18px;"></i> Tambah Anggota
                        </button>
                        @endif
                    </div>
                </div>            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="input-group" style="max-width: 500px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background: white; border: 2px solid #e5e7eb; border-right: none; border-radius: 12px 0 0 12px;">
                            <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                        </span>
                    </div>
                    <input type="text" wire:model.live="search" class="form-control anggota-search-modern" placeholder="Cari nama, NIS/ID anggota, jenis, atau institusi..." style="border-left: none;">
                </div>
            </div>

            {{-- Anggota List --}}
            <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                @forelse ($anggota as $data)
                <div class="anggota-list-item" x-data x-init="$nextTick(() => feather.replace())">
                    <div class="row align-items-center">
                        {{-- Avatar & Name --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="anggota-avatar mr-3">
                                    <span style="font-size: 18px; color: white; font-weight: 700;">
                                        {{ strtoupper(substr($data->nama_anggota, 0, 1)) }}
                                    </span>
                                </div>
                                <div style="min-width: 0;">
                                    <h6 style="font-weight: 600; color: #111827; margin-bottom: 4px; font-size: 15px;">
                                        {{ $data->nama_anggota }}
                                    </h6>
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        @if($data->jenis_anggota === 'guru')
                                        <span class="anggota-badge-guru">
                                            <i data-feather="briefcase" style="width: 11px; height: 11px;"></i> Guru
                                        </span>
                                        @else
                                        <span class="anggota-badge-siswa">
                                            <i data-feather="book-open" style="width: 11px; height: 11px;"></i> Siswa
                                        </span>
                                        @endif
                                        <span style="font-size: 12px; color: #6b7280;">
                                            @if($data->jenis_kelamin === 'laki-laki')
                                            <i data-feather="user" style="width: 12px; height: 12px; color: #3b82f6;"></i>
                                            @else
                                            <i data-feather="user" style="width: 12px; height: 12px; color: #ec4899;"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Info Details --}}
                        <div class="col-md-5 d-none d-md-block">
                            <div class="row">
                                <div class="col-6">
                                    <p style="font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 2px;">LAHIR</p>
                                    <p style="font-size: 13px; color: #374151; font-weight: 500; margin-bottom: 0;">
                                        {{ $data->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 2px;">MEMBER SEJAK</p>
                                    <p style="font-size: 13px; color: #374151; font-weight: 500; margin-bottom: 0;">
                                        {{ $data->anggota_sejak ? \Carbon\Carbon::parse($data->anggota_sejak)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="col-md-3 text-right">
                            <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                {{-- Cetak Kartu Anggota - selalu tampil --}}
                                <a href="{{ route('cetakKartuAnggota', $data->id_anggota) }}"
                                   target="_blank"
                                   title="Cetak Kartu Anggota"
                                   class="anggota-btn-action"
                                   style="display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                                    <i data-feather="credit-card" style="width: 14px; height: 14px; color: #059669;"></i> Kartu
                                </a>
                                @if($isPustakawan)
                                <button wire:click="edit({{ $data->id_anggota }})" data-toggle="modal" data-target="#editAnggotaModal" class="anggota-btn-action">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                </button>
                                <button
                                    wire:click="resetPassword({{ $data->id_anggota }})"
                                    wire:confirm="Reset password {{ $data->nama_anggota }} ke tanggal lahir?"
                                    title="Reset Password ke Tanggal Lahir"
                                    style="background:#fff3cd;color:#856404;border:none;padding:8px 12px;border-radius:10px;font-weight:500;font-size:12px;transition:all .2s;cursor:pointer;"
                                >
                                    <i data-feather="key" style="width: 13px; height: 13px;"></i>
                                </button>
                                <button wire:click="deleteNow({{ $data->id_anggota }})" wire:confirm="⚠️ Yakin ingin menghapus anggota '{{ $data->nama_anggota }}'? Data yang dihapus tidak dapat dikembalikan!" class="anggota-btn-delete">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                                @endif
                            </div>
                            {{-- Indikator status password --}}
                            @if($isPustakawan)
                            <div class="mt-1 text-right">
                                @if($data->password)
                                    <span style="font-size:.68rem;color:#065f46;background:#d1fae5;padding:.1rem .4rem;border-radius:4px;">🔑 Aktif</span>
                                @else
                                    <span style="font-size:.68rem;color:#92400e;background:#fef3c7;padding:.1rem .4rem;border-radius:4px;">⚠ Belum ada password</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding: 60px 20px; text-align: center; background: #f9fafb;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                        <i data-feather="inbox" style="width: 40px; height: 40px; color: #9ca3af;"></i>
                    </div>
                    <h6 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">Tidak ada data anggota</h6>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 0;">Gunakan tombol "Tambah Anggota" untuk memulai</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $anggota->links() }}
            </div>
        </div>
    </div>

    {{-- ==================== MODAL TAMBAH ANGGOTA ==================== --}}
    <div wire:ignore.self class="modal fade" id="addAnggotaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 24px;">
                    <div>
                        <h5 class="modal-title mb-1" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="user-plus" style="width: 20px; height: 20px;"></i> Tambah Anggota Baru
                        </h5>
                        <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 13px;">Daftarkan anggota perpustakaan baru</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 28px;">
                    <form>
                        {{-- Section 1: Data Pribadi --}}
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="user" style="width: 16px; height: 16px; color: #3b82f6;"></i> Data Pribadi
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="anggota-form-control" wire:model="nama_anggota" placeholder="Contoh: Ahmad Hidayat">
                                    @error('nama_anggota') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">NIS / ID Anggota</label>
                                    <input type="text" class="anggota-form-control" wire:model="nis" placeholder="264154-1-001">
                                    @error('nis') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                    <small class="text-muted d-block mt-1" style="font-size:.7rem; line-height:1.4;">
                                        <strong>YY</strong>-4154-<strong>K</strong>-<strong>UUU</strong><br>
                                        YY=tahun masuk &middot; K=kelas &middot; UUU=no urut
                                    </small>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="anggota-form-control" wire:model="email" placeholder="email@example.com">
                                    @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">No. WhatsApp</label>
                                    <div style="position:relative;">
                                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#6b7280;">+62</span>
                                        <input type="text" class="anggota-form-control" wire:model="no_hp" placeholder="8123456789" style="padding-left:40px;">
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size:.7rem;">Untuk notifikasi WA. Awalan 0 tidak perlu diisi.</small>
                                    @error('no_hp') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Anggota <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_anggota">
                                        <option value="">Pilih Jenis</option>
                                        <option value="guru">Guru</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                    @error('jenis_anggota') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_kelamin">
                                        <option value="">Pilih</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Tanggal Lahir</label>
                                    <input type="date" class="anggota-form-control" wire:model="tgl_lahir">
                                    @error('tgl_lahir') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Institusi</label>
                                    <input type="text" class="anggota-form-control" wire:model="institusi" placeholder="SD Muhammadiyah Karangwaru">
                                    @error('institusi') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Alamat</label>
                                    <input type="text" class="anggota-form-control" wire:model="alamat" placeholder="Alamat lengkap">
                                    @error('alamat') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Info Keanggotaan --}}
                        <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                            <h6 style="color: #1e3a8a; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="calendar" style="width: 16px; height: 16px; color: #2563eb;"></i> Info Keanggotaan (Opsional)
                            </h6>

                            <div class="row">
                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Anggota Sejak</label>
                                    <input type="date" class="anggota-form-control" wire:model="anggota_sejak">
                                </div>

                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Tgl Registrasi</label>
                                    <input type="date" class="anggota-form-control" wire:model="tgl_registrasi">
                                </div>

                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Berlaku Hingga</label>
                                    <input type="date" class="anggota-form-control" wire:model="berlaku_hingga">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                    <button type="button" wire:click="store" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s;">
                        <i data-feather="save" style="width: 18px; height: 18px;"></i> Simpan Anggota
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL EDIT ANGGOTA ==================== --}}
    <div wire:ignore.self class="modal fade" id="editAnggotaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 24px;">
                    <div>
                        <h5 class="modal-title mb-1" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="edit" style="width: 20px; height: 20px;"></i> Edit Anggota
                        </h5>
                        <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 13px;">Update informasi anggota</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 28px;">
                    <form>
                        {{-- Section 1: Data Pribadi --}}
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="user" style="width: 16px; height: 16px; color: #3b82f6;"></i> Data Pribadi
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="anggota-form-control" wire:model="nama_anggota" placeholder="Nama lengkap">
                                    @error('nama_anggota') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">NIS / ID Anggota</label>
                                    <input type="text" class="anggota-form-control" wire:model="nis" placeholder="264154-1-001">
                                    @error('nis') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                    <small class="text-muted d-block mt-1" style="font-size:.7rem; line-height:1.4;">
                                        <strong>YY</strong>-4154-<strong>K</strong>-<strong>UUU</strong><br>
                                        YY=tahun masuk &middot; K=kelas &middot; UUU=no urut
                                    </small>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="anggota-form-control" wire:model="email" placeholder="email@example.com">
                                    @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="anggota-form-group">No. WhatsApp</label>
                                    <div style="position:relative;">
                                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;color:#6b7280;">+62</span>
                                        <input type="text" class="anggota-form-control" wire:model="no_hp" placeholder="8123456789" style="padding-left:40px;">
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size:.7rem;">Untuk notifikasi WA. Awalan 0 tidak perlu diisi.</small>
                                    @error('no_hp') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Anggota <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_anggota">
                                        <option value="">Pilih Jenis</option>
                                        <option value="guru">Guru</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                    @error('jenis_anggota') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_kelamin">
                                        <option value="">Pilih</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Tanggal Lahir</label>
                                    <input type="date" class="anggota-form-control" wire:model="tgl_lahir">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Institusi</label>
                                    <input type="text" class="anggota-form-control" wire:model="institusi" placeholder="Institusi">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Alamat</label>
                                    <input type="text" class="anggota-form-control" wire:model="alamat" placeholder="Alamat">
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Info Keanggotaan --}}
                        <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                            <h6 style="color: #1e3a8a; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="calendar" style="width: 16px; height: 16px; color: #2563eb;"></i> Info Keanggotaan
                            </h6>

                            <div class="row">
                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Anggota Sejak</label>
                                    <input type="date" class="anggota-form-control" wire:model="anggota_sejak">
                                </div>

                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Tgl Registrasi</label>
                                    <input type="date" class="anggota-form-control" wire:model="tgl_registrasi">
                                </div>

                                <div class="col-md-4 mb-0">
                                    <label class="anggota-form-group">Berlaku Hingga</label>
                                    <input type="date" class="anggota-form-control" wire:model="berlaku_hingga">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                    <button type="button" wire:click="update" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s;">
                        <i data-feather="save" style="width: 18px; height: 18px;"></i> Update Anggota
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Feather Icons Refresh --}}
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

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    });</script>
</div>
