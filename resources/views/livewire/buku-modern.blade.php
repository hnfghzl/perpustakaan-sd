<div>
    <style>
        .buku-card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .buku-header-modern {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 28px;
            color: white;
        }
        .buku-list-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 20px;
            transition: all 0.2s;
        }
        .buku-list-item:hover {
            background: #f9fafb;
        }
        .buku-list-item:last-child {
            border-bottom: none;
        }
        .buku-badge-kategori {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .buku-btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .buku-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }
        .buku-btn-action {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }
        .buku-btn-action:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }
        .buku-btn-delete {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .buku-btn-delete:hover {
            background: #fee2e2;
            color: #ef4444;
            transform: translateY(-1px);
        }
        .buku-form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }
        .buku-form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    {{-- Header --}}
    <div class="buku-header-modern mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 4px;">
                    @if($showEksemplar)
                        Kelola Eksemplar
                    @else
                        Kelola Buku
                    @endif
                </h1>
                <p style="opacity: 0.9; font-size: 14px; margin-bottom: 0;">
                    @if($showEksemplar)
                        Manajemen copy fisik buku perpustakaan
                    @else
                        Manajemen metadata katalog buku
                    @endif
                </p>
            </div>
            <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="{{ $showEksemplar ? 'package' : 'book' }}" style="width: 32px; height: 32px;"></i>
            </div>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="buku-card-modern">
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

            @if($showEksemplar && $selectedBukuId)
                {{-- VIEW EKSEMPLAR --}}
                <div style="background: #dbeafe; padding: 16px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i data-feather="book" style="width: 24px; height: 24px; color: #1e40af; margin-right: 12px;"></i>
                            <div>
                                <strong style="color: #1e3a8a; font-size: 16px;">{{ $selectedBuku->judul }}</strong><br>
                                <small style="color: #1e40af;">No Panggil: <strong>{{ $selectedBuku->no_panggil ?? '-' }}</strong> | Kategori: <strong>{{ $selectedBuku->kategori->nama ?? '-' }}</strong></small>
                            </div>
                        </div>
                        <button wire:click="backToBuku" class="btn" style="background: white; color: #374151; border: 2px solid #e5e7eb; padding: 8px 16px; border-radius: 10px; font-weight: 600;">
                            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
                        </button>
                    </div>
                </div>

                {{-- Search & Filter Eksemplar --}}
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: white; border: 2px solid #e5e7eb; border-right: none; border-radius: 12px 0 0 12px;">
                                    <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                                </span>
                            </div>
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode atau lokasi..." style="border: 2px solid #e5e7eb; border-left: none; border-radius: 0 12px 12px 0; padding: 12px 16px;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="filterStatus" class="form-control" style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px;">
                            <option value="">Semua Status</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-right">
                        @if($isPustakawan)
                        <button wire:click="$toggle('showFormEksemplar')" class="buku-btn-primary">
                            <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Eksemplar
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Form Eksemplar --}}
                @if($showFormEksemplar && $isPustakawan)
                <div style="background: #f9fafb; padding: 24px; border-radius: 12px; margin-bottom: 24px;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 style="font-weight: 600; color: #111827; margin-bottom: 0;">
                            <i data-feather="edit" style="width: 18px; height: 18px;"></i>
                            {{ $id_eksemplar ? 'Edit Eksemplar' : 'Tambah Eksemplar Baru' }}
                        </h6>
                        <button wire:click="resetInputEksemplar" class="btn btn-sm" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 6px 12px;">
                            <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                        </button>
                    </div>

                    <form wire:submit.prevent="{{ $id_eksemplar ? 'updateEksemplar' : 'storeEksemplar' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Lokasi Rak</label>
                                <input type="text" wire:model="lokasi_rak" class="buku-form-control" placeholder="Contoh: A-01">
                                @error('lokasi_rak') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Status</label>
                                <select wire:model="status_eksemplar" class="buku-form-control">
                                    <option value="tersedia">Tersedia</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Harga</label>
                                <input type="number" wire:model="harga" class="buku-form-control" placeholder="75000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Tanggal Diterima</label>
                                <input type="date" wire:model="tgl_diterima" class="buku-form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 13px;">Sumber Perolehan</label>
                                <input type="text" wire:model="sumber_perolehan" class="buku-form-control" placeholder="Pembelian">
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="button" wire:click="resetInputEksemplar" class="btn" style="background: #f3f4f6; color: #374151; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 500; margin-right: 8px;">
                                Batal
                            </button>
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600;">
                                <i data-feather="save" style="width: 16px; height: 16px;"></i>
                                {{ $id_eksemplar ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                {{-- List Eksemplar --}}
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                    @forelse($eksemplar as $eks)
                    <div class="buku-list-item" x-data x-init="$nextTick(() => feather.replace())">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i data-feather="bookmark" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                                    </div>
                                    <div>
                                        <h6 style="font-weight: 700; color: #111827; margin-bottom: 2px; font-size: 14px;">{{ $eks->kode_eksemplar }}</h6>
                                        <p style="font-size: 12px; color: #6b7280; margin-bottom: 0;">
                                            <i data-feather="map-pin" style="width: 12px; height: 12px;"></i> {{ $eks->lokasi_rak ?? 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                @if($eks->status_eksemplar == 'tersedia')
                                <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">Tersedia</span>
                                @elseif($eks->status_eksemplar == 'dipinjam')
                                <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">Dipinjam</span>
                                @elseif($eks->status_eksemplar == 'rusak')
                                <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">Rusak</span>
                                @else
                                <span style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">Hilang</span>
                                @endif
                                @if($eks->harga)
                                <span style="margin-left: 12px; color: #6b7280; font-size: 13px;">Rp {{ number_format($eks->harga, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <div class="col-md-3 text-right">
                                @if($isPustakawan)
                                <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                    <button wire:click="editEksemplar({{ $eks->id_eksemplar }})" class="buku-btn-action">
                                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                    </button>
                                    @if($eks->status_eksemplar !== 'dipinjam')
                                    <button onclick="confirm('Yakin hapus eksemplar ini?') || event.stopImmediatePropagation()" wire:click="deleteEksemplar({{ $eks->id_eksemplar }})" class="buku-btn-delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    @else
                                    <button disabled class="btn btn-sm" style="background: #e5e7eb; color: #9ca3af; border: none; padding: 8px 14px; border-radius: 10px; cursor: not-allowed;">
                                        <i data-feather="lock" style="width: 14px; height: 14px;"></i>
                                    </button>
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
                        <h6 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">Tidak ada eksemplar</h6>
                        <p style="color: #9ca3af; font-size: 14px; margin-bottom: 0;">Tambahkan eksemplar baru untuk buku ini</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $eksemplar->links() }}
                </div>

            @else
                {{-- VIEW BUKU --}}
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div style="width: 56px; height: 56px; background: #dbeafe; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-right: 14px;">
                                <i data-feather="book" style="width: 28px; height: 28px; color: #3b82f6;"></i>
                            </div>
                            <div>
                                <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px; font-weight: 500;">Total Buku</p>
                                <h3 style="font-size: 32px; font-weight: 700; color: #111827; margin-bottom: 0;">{{ $buku->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        @if($isPustakawan)
                        <button data-toggle="modal" data-target="#addBukuModal" wire:click="resetInput" class="buku-btn-primary">
                            <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Buku
                        </button>
                        @endif
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
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Cari judul atau no panggil..." style="border: 2px solid #e5e7eb; border-left: none; border-radius: 0 12px 12px 0; padding: 12px 16px;">
                    </div>
                </div>

                {{-- List Buku --}}
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                    @forelse ($buku as $data)
                    <div class="buku-list-item" x-data x-init="$nextTick(() => feather.replace())">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="d-flex align-items-center">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i data-feather="book-open" style="width: 24px; height: 24px; color: white;"></i>
                                    </div>
                                    <div style="min-width: 0;">
                                        <h6 style="font-weight: 600; color: #111827; margin-bottom: 4px; font-size: 15px;">{{ $data->judul }}</h6>
                                        <p style="font-size: 12px; color: #6b7280; margin-bottom: 0;">
                                            <i data-feather="tag" style="width: 12px; height: 12px;"></i> {{ $data->no_panggil ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <span class="buku-badge-kategori">
                                    <i data-feather="folder" style="width: 11px; height: 11px;"></i> {{ $data->kategori->nama ?? '-' }}
                                </span>
                                <span style="margin-left: 12px; font-size: 13px; color: #6b7280;">
                                    {{ $data->eksemplar_count ?? 0 }} eksemplar
                                </span>
                            </div>
                            <div class="col-md-3 text-right">
                                <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                    <button wire:click="viewEksemplar({{ $data->id_buku }})" class="buku-btn-action">
                                        <i data-feather="package" style="width: 14px; height: 14px;"></i> Eksemplar
                                    </button>
                                    @if($isPustakawan)
                                    <button wire:click="edit({{ $data->id_buku }})" data-toggle="modal" data-target="#editBukuModal" class="buku-btn-action">
                                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    <button onclick="confirm('Yakin hapus buku ini beserta semua eksemplarnya?') || event.stopImmediatePropagation()" wire:click="delete({{ $data->id_buku }})" class="buku-btn-delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="padding: 60px 20px; text-align: center; background: #f9fafb;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <i data-feather="inbox" style="width: 40px; height: 40px; color: #9ca3af;"></i>
                        </div>
                        <h6 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">Tidak ada data buku</h6>
                        <p style="color: #9ca3af; font-size: 14px; margin-bottom: 0;">Gunakan tombol "Tambah Buku" untuk memulai</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $buku->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ==================== MODAL TAMBAH BUKU ==================== --}}
    <div wire:ignore.self class="modal fade" id="addBukuModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 24px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px; margin-bottom: 4px;">
                            <i data-feather="book-open" style="width: 24px; height: 24px;"></i> Tambah Buku Baru + Eksemplar
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 0;">Tambahkan buku beserta copy fisiknya</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 1;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 28px;">
                    <form>
                        {{-- Info Box --}}
                        <div style="background: #dbeafe; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                            <div style="display: flex; align-items: start;">
                                <i data-feather="info" style="width: 20px; height: 20px; color: #1e40af; margin-right: 12px; margin-top: 2px; flex-shrink: 0;"></i>
                                <div style="color: #1e3a8a; font-size: 13px; line-height: 1.6;">
                                    <strong style="font-size: 14px;">💡 Info Otomatis:</strong><br>
                                    • <strong>No Panggil</strong> dibuat otomatis berdasarkan kategori (format DDC)<br>
                                    • <strong>Kode Eksemplar</strong> dibuat otomatis: {ID Buku}-001, {ID Buku}-002, dst.
                                </div>
                            </div>
                        </div>

                        {{-- Section 1: Data Buku --}}
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                                Data Buku
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Judul Buku <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control buku-form-control" wire:model="judul" placeholder="Masukkan judul buku">
                                        @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control buku-form-control" wire:model="kategori_id">
                                            <option value="">-- Pilih --</option>
                                            @foreach($kategori as $kat)
                                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Data Eksemplar --}}
                        <div style="background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #78350f; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="package" style="width: 18px; height: 18px; margin-right: 8px; color: #d97706;"></i>
                                Data Eksemplar (Copy Fisik)
                            </h6>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Jumlah Eksemplar <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control buku-form-control" wire:model="jumlah_eksemplar" min="1" max="50" placeholder="1">
                                        @error('jumlah_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                        <small style="color: #78350f; font-size: 12px;">Berapa copy fisik?</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Lokasi Rak</label>
                                        <input type="text" class="form-control buku-form-control" wire:model="lokasi_rak" placeholder="RAK-A-1">
                                        <small style="color: #78350f; font-size: 12px;">Untuk semua eksemplar</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Harga per Eksemplar</label>
                                        <input type="number" class="form-control buku-form-control" wire:model="harga" placeholder="50000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Info Tambahan --}}
                        <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                            <h6 style="color: #1e3a8a; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 8px; color: #2563eb;"></i>
                                Info Tambahan (Opsional)
                            </h6>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Tanggal Diterima</label>
                                        <input type="date" class="form-control buku-form-control" wire:model="tgl_diterima">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">Sumber Perolehan</label>
                                        <select class="form-control buku-form-control" wire:model="sumber_perolehan">
                                            <option value="">-- Pilih --</option>
                                            <option value="beli">💰 Beli</option>
                                            <option value="hadiah">🎁 Hadiah</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label style="font-weight: 600; color: #374151; font-size: 14px;">No Faktur</label>
                                        <input type="text" class="form-control buku-form-control" wire:model="faktur" placeholder="FKT-001">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                    <button type="button" wire:click="store" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);">
                        <i data-feather="save" style="width: 18px; height: 18px;"></i> Simpan Buku + {{ $jumlah_eksemplar }} Eksemplar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL EDIT BUKU ==================== --}}
    <div wire:ignore.self class="modal fade" id="editBukuModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 24px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px; margin-bottom: 4px;">
                            <i data-feather="edit" style="width: 24px; height: 24px;"></i> Edit Buku
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 0;">Update informasi buku</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 1;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 28px;">
                    <form>
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                                Informasi Buku
                            </h6>

                            <div class="form-group mb-3">
                                <label style="font-weight: 600; color: #374151; font-size: 14px;">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control buku-form-control" wire:model="judul" placeholder="Masukkan judul buku">
                                @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label style="font-weight: 600; color: #374151; font-size: 14px;">No Panggil (DDC)</label>
                                <input type="text" class="form-control buku-form-control" wire:model="no_panggil" placeholder="Contoh: 800.001">
                                @error('no_panggil') <small class="text-danger">{{ $message }}</small> @enderror
                                <small style="color: #6b7280; font-size: 12px;">Dewey Decimal Classification</small>
                            </div>

                            <div class="form-group mb-0">
                                <label style="font-weight: 600; color: #374151; font-size: 14px;">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control buku-form-control" wire:model="kategori_id">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                    <button type="button" wire:click="update" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s;">
                        <i data-feather="save" style="width: 18px; height: 18px;"></i> Update Buku
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
