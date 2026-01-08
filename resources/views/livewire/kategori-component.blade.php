<div>
    {{-- Alert Messages --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #16A085; box-shadow: 0 2px 8px rgba(22, 160, 133, 0.15);">
        <i data-feather="check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #dc2626; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15);">
        <i data-feather="x-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);">
        <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; border-radius: 16px 16px 0 0; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3); padding: 20px 24px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: white; font-weight: 600;">
                        <i data-feather="tag" style="width: 22px; height: 22px;"></i> Mengelola Kategori Buku
                    </h5>
                    <small style="color: rgba(255,255,255,0.9);">Total: {{ $kategori->total() }} kategori</small>
                </div>
                @if($isPustakawan)
                <button class="btn btn-light" wire:click="openForm" style="border-radius: 10px; font-weight: 600; padding: 10px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)';">
                    <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Kategori
                </button>
                @endif
            </div>
        </div>

        <div class="card-body" style="padding: 24px;">
            {{-- Info Box --}}
            <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                <div style="display: flex; align-items: start;">
                    <i data-feather="info" style="width: 20px; height: 20px; color: #1e40af; margin-right: 12px; margin-top: 2px; flex-shrink: 0;"></i>
                    <div style="color: #1e3a8a; font-size: 13px; line-height: 1.6;">
                        <strong style="font-size: 14px;">ℹ️ Perhatian:</strong><br>
                        • Kategori yang masih memiliki <strong>buku</strong> tidak bisa dihapus<br>
                        • Hapus atau pindahkan buku ke kategori lain terlebih dahulu
                    </div>
                </div>
            </div>

            {{-- Modal Form Kategori --}}
            @if($showForm)
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1050; padding: 20px;" wire:click.self="closeForm">
                <div style="background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 600px; width: 100%; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column;">
                    {{-- Header --}}
                    <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 20px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <h5 style="margin: 0; color: white; font-weight: 600; display: flex; align-items: center; font-size: 18px;">
                            <i data-feather="{{ $isEdit ? 'edit' : 'plus' }}" style="width: 22px; height: 22px; margin-right: 10px;"></i>
                            {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                        </h5>
                        <button wire:click="closeForm" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)';" onmouseout="this.style.background='rgba(255,255,255,0.2)';">
                            <i data-feather="x" style="width: 20px; height: 20px;"></i>
                        </button>
                    </div>
                    
                    {{-- Body --}}
                    <div style="padding: 28px; overflow-y: auto; flex: 1;">
                
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">Nama Kategori <span style="color: #ef4444;">*</span></label>
                            <input type="text" class="form-control" wire:model="nama" placeholder="Contoh: Fiksi, Non-Fiksi, Referensi" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            @error('nama')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">Deskripsi <small style="color: #9ca3af;">(Opsional)</small></label>
                            <textarea class="form-control" wire:model="deskripsi" rows="4" placeholder="Deskripsi singkat tentang kategori ini" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;"></textarea>
                            @error('deskripsi')<div style="color: #ef4444; font-size: 12px; margin-top: 6px;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div style="padding: 20px 28px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb;">
                        <button wire:click="closeForm" style="background: #6b7280; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#4b5563'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(107, 114, 128, 0.3)';" onmouseout="this.style.background='#6b7280'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                        </button>
                        @if($isEdit)
                            <button wire:click="update" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i data-feather="save" style="width: 16px; height: 16px;"></i> Update Kategori
                            </button>
                        @else
                            <button wire:click="store" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Kategori
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="input-group" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background: white; border: 1px solid #e5e7eb; border-right: none; padding: 12px 16px;">
                            <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kategori (nama/deskripsi)..." style="border: 1px solid #e5e7eb; border-left: none; padding: 12px 16px; font-size: 15px;">
                </div>
            </div>

            {{-- Compact List View --}}
            <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                @forelse($kategori as $data)
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 18px 24px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb';" onmouseout="this.style.background='white';">
                    <div class="row align-items-center">
                        {{-- Icon & Nama (40%) --}}
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 14px; box-shadow: 0 3px 6px rgba(22, 160, 133, 0.3);">
                                    <i data-feather="tag" style="width: 22px; height: 22px; color: white;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h6 style="font-weight: 700; color: #111827; margin-bottom: 2px; font-size: 15px;">{{ $data->nama }}</h6>
                                    <small style="color: #6b7280; font-size: 13px; display: block; line-height: 1.4;">
                                        {{ Str::limit($data->deskripsi ?? 'Tidak ada deskripsi', 50) }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Stats (35%) --}}
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="text-align: center;">
                                    <div style="font-size: 24px; font-weight: 700; color: #1ABC9C; line-height: 1;">{{ $data->buku_count }}</div>
                                    <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">Jumlah Buku</div>
                                </div>
                                <div style="width: 1px; height: 40px; background: #e5e7eb;"></div>
                                <div>
                                    @if($data->buku_count > 0)
                                    <span style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 2px 4px rgba(22, 160, 133, 0.3);">✅ AKTIF</span>
                                    @else
                                    <span style="background: #f3f4f6; color: #6b7280; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;">⚪ KOSONG</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions (21%) --}}
                        <div class="col-md-3 text-right">
                            @if($isPustakawan)
                            <div class="btn-group" role="group" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="edit({{ $data->id_kategori }})" class="btn btn-sm" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(22, 160, 133, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                </button>
                                
                                @if($data->buku_count == 0)
                                    <button onclick="confirm('Yakin hapus kategori {{ $data->nama }}?') || event.stopImmediatePropagation()"
                                        wire:click="destroy({{ $data->id_kategori }})"
                                        class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; font-weight: 600; padding: 8px 14px; border-radius: 8px; transition: all 0.2s; margin-left: 6px;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(220, 38, 38, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm" disabled style="background: #f3f4f6; color: #9ca3af; border: none; padding: 8px 14px; border-radius: 8px; margin-left: 6px; cursor: not-allowed;" title="Masih ada {{ $data->buku_count }} buku">
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
                    <i data-feather="inbox" style="width: 48px; height: 48px; color: #9ca3af; margin-bottom: 12px;"></i>
                    <p style="color: #6b7280; font-size: 15px; margin: 0;">Tidak ada data kategori</p>
                    @if($isPustakawan)
                    <small style="color: #9ca3af;">Klik tombol "Tambah Kategori" untuk menambahkan kategori baru</small>
                    @endif
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small style="color: #6b7280;">
                    Menampilkan {{ $kategori->firstItem() ?? 0 }} - {{ $kategori->lastItem() ?? 0 }} dari {{ $kategori->total() }} kategori
                </small>
                <nav>
                    {{ $kategori->links() }}
                </nav>
            </div>
        </div>
    </div>

    {{-- Feather Icons Refresh Pattern --}}
    @assets
    <script>
        window.refreshFeatherIcons = function() {
            if (typeof feather !== 'undefined') {
                setTimeout(() => {
                    feather.replace();
                    console.log('✅ Kategori icons refreshed');
                }, 150);
            }
        }
    </script>
    @endassets

    <script data-navigate-once>document.addEventListener('livewire:initialized', () => {
        refreshFeatherIcons();

        // Livewire lifecycle hooks
        Livewire.hook('element.init', () => {
            refreshFeatherIcons();
        });

        Livewire.hook('element.updated', () => {
            refreshFeatherIcons();
        });

        Livewire.hook('morph.updated', () => {
            refreshFeatherIcons();
        });

        Livewire.hook('commit', () => {
            refreshFeatherIcons();
        });

        // MutationObserver sebagai final backup
        const observer = new MutationObserver(() => {
            refreshFeatherIcons();
        });
        observer.observe(document.body, { 
            childList: true, 
            subtree: true 
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    });</script>
</div>
