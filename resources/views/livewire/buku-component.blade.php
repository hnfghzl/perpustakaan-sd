<div>
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i data-feather="check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i data-feather="x-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if($showEksemplar && $selectedBukuId)
        {{-- VIEW EKSEMPLAR --}}
        <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);">
            <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; border-radius: 16px 16px 0 0; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3); padding: 20px 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: white; font-weight: 600;">
                            <i data-feather="package" style="width: 22px; height: 22px;"></i> Mengelola Eksemplar
                        </h5>
                        <small style="color: rgba(255,255,255,0.9);">{{ $selectedBuku->judul ?? '' }}</small>
                    </div>
                    <button wire:click="backToBuku" class="btn btn-light btn-sm" style="border-radius: 8px; font-weight: 600; padding: 8px 16px;">
                        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
                    </button>
                </div>
            </div>

            <div class="card-body" style="padding: 24px;">
                {{-- Info Buku --}}
                <div style="background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #00897b;">
                    <div class="d-flex align-items-center">
                        <i data-feather="book" style="width: 24px; height: 24px; color: #00695c; margin-right: 12px;"></i>
                        <div>
                            <strong style="color: #004d40; font-size: 16px;">{{ $selectedBuku->judul }}</strong><br>
                            <small style="color: #00695c;">No Panggil: <strong>{{ $selectedBuku->no_panggil ?? '-' }}</strong> | Kategori: <strong>{{ $selectedBuku->kategori->nama ?? '-' }}</strong></small>
                        </div>
                    </div>
                </div>

                {{-- Filter & Search --}}
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="input-group" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: white; border: 1px solid #e5e7eb; border-right: none; padding: 10px 14px;">
                                    <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kode eksemplar atau lokasi..." style="border: 1px solid #e5e7eb; border-left: none; padding: 10px 14px;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" wire:model.live="filterStatus" style="border-radius: 10px; padding: 10px 14px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                            <option value="">Semua Status</option>
                            <option value="tersedia">✅ Tersedia</option>
                            <option value="dipinjam">🟡 Dipinjam</option>
                            <option value="rusak">🔴 Rusak</option>
                            <option value="hilang">⚫ Hilang</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-right">
                        @if($isPustakawan)
                        <button class="btn" data-toggle="modal" data-target="#addEksemplarModal" wire:click="resetInputEksemplar" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 10px 20px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
                            <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Eksemplar
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Compact List View Eksemplar --}}
                <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                    @forelse($eksemplar as $index => $eks)
                    <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 18px 24px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb';" onmouseout="this.style.background='white';">
                        <div class="row align-items-center">
                            {{-- Kode & Lokasi (35%) --}}
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 14px; box-shadow: 0 3px 6px rgba(22, 160, 133, 0.3);">
                                        <i data-feather="bookmark" style="width: 20px; height: 20px; color: white;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #111827; font-size: 14px; margin-bottom: 2px;">{{ $eks->kode_eksemplar }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">
                                            <i data-feather="map-pin" style="width: 12px; height: 12px;"></i> {{ $eks->lokasi_rak ?? 'Belum ditentukan' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status & Info (38%) --}}
                            <div class="col-md-4">
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    @if($eks->status_eksemplar == 'tersedia')
                                    <span style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 4px rgba(22, 160, 133, 0.3);">✅ TERSEDIA</span>
                                    @elseif($eks->status_eksemplar == 'dipinjam')
                                    <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 4px rgba(217, 119, 6, 0.3);">🟡 DIPINJAM</span>
                                    @elseif($eks->status_eksemplar == 'rusak')
                                    <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);">🔴 RUSAK</span>
                                    @else
                                    <span style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 4px rgba(75, 85, 99, 0.3);">⚫ HILANG</span>
                                    @endif
                                    
                                    <div style="border-left: 2px solid #e5e7eb; padding-left: 12px;">
                                        <div style="font-size: 12px; color: #6b7280;">Harga</div>
                                        <div style="font-weight: 700; color: #374151; font-size: 14px;">{{ $eks->harga ? 'Rp ' . number_format($eks->harga, 0, ',', '.') : '-' }}</div>
                                    </div>
                                    
                                    <div style="border-left: 2px solid #e5e7eb; padding-left: 12px;">
                                        <div style="font-size: 12px; color: #6b7280;">Diterima</div>
                                        <div style="font-weight: 600; color: #374151; font-size: 13px;">{{ $eks->tgl_diterima ? \Carbon\Carbon::parse($eks->tgl_diterima)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions (22%) --}}
                            <div class="col-md-4 text-right">
                                @if($isPustakawan)
                                <div class="btn-group" role="group" x-data x-init="$nextTick(() => feather.replace())">
                                    <button wire:click="editEksemplar({{ $eks->id_eksemplar }})" class="btn btn-sm" data-toggle="modal" data-target="#editEksemplarModal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(22, 160, 133, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                    </button>
                                    @if($eks->status_eksemplar !== 'dipinjam')
                                    <button onclick="confirm('Yakin hapus eksemplar ini?') || event.stopImmediatePropagation()" wire:click="deleteEksemplar({{ $eks->id_eksemplar }})" class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s; margin-left: 6px;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(220, 38, 38, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm" disabled style="background: #f3f4f6; color: #9ca3af; border: none; padding: 8px 14px; border-radius: 8px; margin-left: 6px; cursor: not-allowed;" title="Tidak bisa dihapus saat dipinjam">
                                        <i data-feather="lock" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                        <i data-feather="package" style="width: 48px; height: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                        <p style="color: #6b7280; font-size: 15px; margin: 0;">Belum ada eksemplar untuk buku ini</p>
                        @if($isPustakawan)
                        <small style="color: #9ca3af;">Klik tombol "Tambah Eksemplar" untuk menambahkan copy fisik</small>
                        @endif
                    </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $eksemplar->links() }}
                </div>
            </div>
        </div>
    @else
        {{-- VIEW BUKU --}}
        <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);">
            <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; border-radius: 16px 16px 0 0; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3); padding: 20px 24px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: white; font-weight: 600;">
                            <i data-feather="book" style="width: 22px; height: 22px;"></i> Mengelola Buku & Eksemplar
                        </h5>
                        <small style="color: rgba(255,255,255,0.9);">Total: {{ $buku->total() }} buku</small>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 24px;">
                {{-- Search Bar --}}
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="input-group" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: white; border: 1px solid #e5e7eb; border-right: none; padding: 12px 16px;">
                                    <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Cari buku (judul, no panggil, kategori)..." style="border: 1px solid #e5e7eb; border-left: none; padding: 12px 16px; font-size: 15px;">
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        @if($isPustakawan)
                        <button class="btn btn-lg" data-toggle="modal" data-target="#addBukuModal" wire:click="resetInput" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 12px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
                            <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Buku
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Compact List View --}}
                <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                    @forelse ($buku as $data)
                    <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 20px 24px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb';" onmouseout="this.style.background='white';">
                        <div class="row align-items-center">
                            {{-- Book Info (50%) --}}
                            <div class="col-md-5">
                                <div class="d-flex align-items-start">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 16px; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
                                        <i data-feather="book-open" style="width: 24px; height: 24px; color: white;"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <h6 style="font-weight: 600; color: #111827; margin-bottom: 4px; font-size: 15px; line-height: 1.4;">{{ $data->judul }}</h6>
                                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px;">
                                            <span style="background: #e0f2f1; color: #00897b; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">{{ $data->no_panggil ?? '-' }}</span>
                                            <span style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">{{ $data->kategori->nama ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Stock Info (28%) --}}
                            <div class="col-md-3">
                                <div style="display: flex; gap: 16px;">
                                    <div style="text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: #1ABC9C; line-height: 1;">{{ $data->eksemplar->count() }}</div>
                                        <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">Total</div>
                                    </div>
                                    <div style="width: 1px; background: #e5e7eb;"></div>
                                    <div style="text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: #16A085; line-height: 1;">{{ $data->eksemplar->where('status_eksemplar', 'tersedia')->count() }}</div>
                                        <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">Tersedia</div>
                                    </div>
                                    <div style="width: 1px; background: #e5e7eb;"></div>
                                    <div style="text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: #f59e0b; line-height: 1;">{{ $data->eksemplar->where('status_eksemplar', 'dipinjam')->count() }}</div>
                                        <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">Dipinjam</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions (22%) --}}
                            <div class="col-md-4 text-right">
                                <div class="btn-group" role="group" x-data x-init="$nextTick(() => feather.replace())">
                                    <button wire:click="viewEksemplar({{ $data->id_buku }})" class="btn btn-sm" style="background: #e0f2f1; color: #00897b; border: none; font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; font-size: 13px;" onmouseover="this.style.background='#b2dfdb'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#e0f2f1'; this.style.transform='translateY(0)';">
                                        <i data-feather="package" style="width: 14px; height: 14px;"></i> Eksemplar
                                    </button>
                                    @if($isPustakawan)
                                    <button wire:click="edit({{ $data->id_buku }})" class="btn btn-sm" data-toggle="modal" data-target="#editBukuModal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s; margin-left: 6px;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(22, 160, 133, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    <button onclick="confirm('Yakin hapus buku ini beserta semua eksemplarnya?') || event.stopImmediatePropagation()" wire:click="delete({{ $data->id_buku }})" class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s; margin-left: 6px;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(220, 38, 38, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                        <i data-feather="inbox" style="width: 48px; height: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                        <p style="color: #6b7280; font-size: 15px; margin: 0;">Tidak ada data buku</p>
                        @if($isPustakawan)
                        <small style="color: #9ca3af;">Klik tombol "Tambah Buku" untuk menambahkan buku baru</small>
                        @endif
                    </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $buku->links() }}
                </div>
            </div>
        </div>
    @endif

        {{-- ==================== MODAL TAMBAH BUKU ==================== --}}
        <div wire:ignore.self class="modal fade" id="addBukuModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="book-open" style="width: 24px; height: 24px;"></i> Tambah Buku Baru + Eksemplar
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 0.9;">&times;</button>
                    </div>

                    <div class="modal-body" style="padding: 28px;">
                        <form>
                            {{-- Info Box --}}
                            <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
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
                                    <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                    Data Buku
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Judul Buku <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" wire:model="judul" placeholder="Masukkan judul buku" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model="kategori_id" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="">-- Pilih Kategori --</option>
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
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Jumlah Eksemplar <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" wire:model="jumlah_eksemplar" min="1" max="50" placeholder="1" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('jumlah_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                            <small style="color: #78350f; font-size: 12px;"><i data-feather="help-circle" style="width: 12px; height: 12px;"></i> Berapa copy fisik buku ini?</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Lokasi Rak</label>
                                            <input type="text" class="form-control" wire:model="lokasi_rak" placeholder="RAK-A-1" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('lokasi_rak') <small class="text-danger">{{ $message }}</small> @enderror
                                            <small style="color: #78350f; font-size: 12px;"><i data-feather="map-pin" style="width: 12px; height: 12px;"></i> Untuk semua eksemplar</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Harga per Eksemplar (Rp)</label>
                                            <input type="number" class="form-control" wire:model="harga" placeholder="50000" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
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
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Tanggal Diterima</label>
                                            <input type="date" class="form-control" wire:model="tgl_diterima" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Sumber Perolehan</label>
                                            <select class="form-control" wire:model="sumber_perolehan" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="">-- Pilih --</option>
                                                <option value="beli">💰 Beli</option>
                                                <option value="hadiah">🎁 Hadiah</option>
                                            </select>
                                            @error('sumber_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">No Faktur</label>
                                            <input type="text" class="form-control" wire:model="faktur" placeholder="FKT-20250114-001" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('faktur') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                        <button type="button" wire:click="store" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
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
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="edit" style="width: 24px; height: 24px;"></i> Edit Buku
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 0.9;">&times;</button>
                    </div>

                    <div class="modal-body" style="padding: 28px;">
                        <form>
                            {{-- Section: Data Buku --}}
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                                <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                    Informasi Buku
                                </h6>

                                <div class="form-group">
                                    <label style="font-weight: 600; color: #374151; font-size: 14px;">Judul Buku <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" wire:model="judul" placeholder="Masukkan judul buku" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                    @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label style="font-weight: 600; color: #374151; font-size: 14px;">No Panggil (DDC)</label>
                                    <input type="text" class="form-control" wire:model="no_panggil" placeholder="Contoh: 800.001" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                    @error('no_panggil') <small class="text-danger">{{ $message }}</small> @enderror
                                    <small style="color: #6b7280; font-size: 12px;"><i data-feather="info" style="width: 12px; height: 12px;"></i> Dewey Decimal Classification</small>
                                </div>

                                <div class="form-group">
                                    <label style="font-weight: 600; color: #374151; font-size: 14px;">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control" wire:model="kategori_id" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
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
                        <button type="button" wire:click="update" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
                            <i data-feather="save" style="width: 18px; height: 18px;"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== MODAL TAMBAH EKSEMPLAR ==================== --}}
        <div wire:ignore.self class="modal fade" id="addEksemplarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="plus-circle" style="width: 24px; height: 24px;"></i> Tambah Eksemplar Baru
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 0.9;">&times;</button>
                    </div>

                    <div class="modal-body" style="padding: 28px;">
                        <form>
                            {{-- Section 1: Identitas Eksemplar --}}
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="tag" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                    Identitas Eksemplar
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Kode Eksemplar <span class="text-danger">*</span></label>
                                            <div class="input-group" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                                                <input type="text" class="form-control" wire:model="kode_eksemplar" placeholder="Auto generate" style="border: 1px solid #d1d5db; border-right: none; padding: 10px 14px;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn" wire:click="generateKodeEksemplar" style="background: #1ABC9C; color: white; border: 1px solid #1ABC9C; padding: 0 16px;">
                                                        <i data-feather="refresh-cw" style="width: 16px; height: 16px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('kode_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Lokasi Rak</label>
                                            <input type="text" class="form-control" wire:model="lokasi_rak" placeholder="RAK-A-1" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('lokasi_rak') <small class="text-danger">{{ $message }}</small> @enderror
                                            <small style="color: #6b7280; font-size: 12px;"><i data-feather="map-pin" style="width: 12px; height: 12px;"></i> Dimana buku ini disimpan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Status & Harga --}}
                            <div style="background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <h6 style="color: #78350f; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="dollar-sign" style="width: 18px; height: 18px; margin-right: 8px; color: #d97706;"></i>
                                    Status & Harga
                                </h6>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Status <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model="status_eksemplar" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="tersedia">✅ Tersedia</option>
                                                <option value="rusak">🔴 Rusak</option>
                                                <option value="hilang">⚫ Hilang</option>
                                            </select>
                                            @error('status_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Harga (Rp)</label>
                                            <input type="number" class="form-control" wire:model="harga" placeholder="50000" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Tanggal Diterima</label>
                                            <input type="date" class="form-control" wire:model="tgl_diterima" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 3: Dokumen --}}
                            <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                                <h6 style="color: #1e3a8a; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 8px; color: #2563eb;"></i>
                                    Dokumen (Opsional)
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Sumber Perolehan</label>
                                            <select class="form-control" wire:model="sumber_perolehan" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="">-- Pilih --</option>
                                                <option value="beli">💰 Beli</option>
                                                <option value="hadiah">🎁 Hadiah</option>
                                            </select>
                                            @error('sumber_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">No Faktur</label>
                                            <input type="text" class="form-control" wire:model="faktur" placeholder="FKT-20250114-001" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('faktur') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                        <button type="button" wire:click="storeEksemplar" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
                            <i data-feather="save" style="width: 18px; height: 18px;"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== MODAL EDIT EKSEMPLAR ==================== --}}
        <div wire:ignore.self class="modal fade" id="editEksemplarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 20px;">
                            <i data-feather="edit" style="width: 24px; height: 24px;"></i> Edit Eksemplar
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" style="font-size: 32px; opacity: 0.9;">&times;</button>
                    </div>

                    <div class="modal-body" style="padding: 28px;">
                        <form>
                            {{-- Section 1: Identitas Eksemplar --}}
                            <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="tag" style="width: 18px; height: 18px; margin-right: 8px; color: #1ABC9C;"></i>
                                    Identitas Eksemplar
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Kode Eksemplar <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" wire:model="kode_eksemplar" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                            @error('kode_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Lokasi Rak</label>
                                            <input type="text" class="form-control" wire:model="lokasi_rak" placeholder="RAK-A-1" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('lokasi_rak') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Status & Harga --}}
                            <div style="background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <h6 style="color: #78350f; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="dollar-sign" style="width: 18px; height: 18px; margin-right: 8px; color: #d97706;"></i>
                                    Status & Harga
                                </h6>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Status <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model="status_eksemplar" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="tersedia">✅ Tersedia</option>
                                                <option value="dipinjam" disabled>🟡 Dipinjam (Otomatis via Transaksi)</option>
                                                <option value="rusak">🔴 Rusak</option>
                                                <option value="hilang">⚫ Hilang</option>
                                            </select>
                                            @error('status_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                            <small style="color: #78350f; font-size: 12px;"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> Status 'Dipinjam' diatur otomatis</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Harga (Rp)</label>
                                            <input type="number" class="form-control" wire:model="harga" placeholder="50000" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Tanggal Diterima</label>
                                            <input type="date" class="form-control" wire:model="tgl_diterima" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 3: Dokumen --}}
                            <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                                <h6 style="color: #1e3a8a; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                                    <i data-feather="file-text" style="width: 18px; height: 18px; margin-right: 8px; color: #2563eb;"></i>
                                    Dokumen (Opsional)
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Sumber Perolehan</label>
                                            <select class="form-control" wire:model="sumber_perolehan" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px; color: #374151; background-color: white; appearance: auto;">
                                                <option value="">-- Pilih --</option>
                                                <option value="beli">💰 Beli</option>
                                                <option value="hadiah">🎁 Hadiah</option>
                                            </select>
                                            @error('sumber_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-weight: 600; color: #374151; font-size: 14px;">No Faktur</label>
                                            <input type="text" class="form-control" wire:model="faktur" placeholder="FKT-20250114-001" style="border-radius: 10px; border: 1px solid #d1d5db; padding: 10px 14px;">
                                            @error('faktur') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 28px; background: #f9fafb;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 24px;">Batal</button>
                        <button type="button" wire:click="updateEksemplar" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.3s; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.25);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(22, 160, 133, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(22, 160, 133, 0.25)';">
                            <i data-feather="save" style="width: 18px; height: 18px;"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ====================== SCRIPT FEATHER ICONS ====================== --}}
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