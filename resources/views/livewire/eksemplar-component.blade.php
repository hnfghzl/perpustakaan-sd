<div>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i data-feather="package"></i> Mengelola Eksemplar Buku
            </h3>
            <button class="btn" data-toggle="modal" data-target="#addEksemplarModal" wire:click="resetInput" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i data-feather="plus"></i> Tambah Eksemplar
            </button>
        </div>

        {{-- Alert Messages --}}
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i data-feather="check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i data-feather="x-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Filter & Search --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" wire:model.live="search" placeholder="🔍 Cari kode, lokasi, atau judul buku...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" wire:model.live="filterBuku">
                            <option value="">-- Semua Buku --</option>
                            @foreach($bukuList as $buku)
                            <option value="{{ $buku->id_buku }}">{{ $buku->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" wire:model.live="filterStatus">
                            <option value="">-- Semua Status --</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <table class="table table-hover table-bordered">
                    <thead style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%);">
                        <tr class="text-center" style="color: white;">
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Kode Eksemplar</th>
                            <th style="width: 25%">Judul Buku</th>
                            <th style="width: 12%">Lokasi Rak</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Harga</th>
                            <th style="width: 10%">Tgl Diterima</th>
                            <th style="width: 13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eksemplar as $index => $data)
                        <tr>
                            <td class="text-center">{{ $eksemplar->firstItem() + $index }}</td>
                            <td><strong>{{ $data->kode_eksemplar }}</strong></td>
                            <td>
                                {{ $data->buku->judul }}
                                <br><small class="text-muted">{{ $data->buku->no_panggil }}</small>
                            </td>
                            <td>{{ $data->lokasi_rak ?? '-' }}</td>
                            <td class="text-center">
                                @if($data->status_eksemplar == 'tersedia')
                                <span class="badge" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; font-weight: 500;">Tersedia</span>
                                @elseif($data->status_eksemplar == 'dipinjam')
                                <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 500;">Dipinjam</span>
                                @elseif($data->status_eksemplar == 'rusak')
                                <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 500;">Rusak</span>
                                @else
                                <span class="badge" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; font-weight: 500;">Hilang</span>
                                @endif
                            </td>
                            <td class="text-right">{{ $data->harga ? 'Rp ' . number_format($data->harga, 0, ',', '.') : '-' }}</td>
                            <td class="text-center">{{ $data->tgl_diterima ? \Carbon\Carbon::parse($data->tgl_diterima)->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" x-data x-init="$nextTick(() => feather.replace())">
                                    <button wire:click="edit({{ $data->id_eksemplar }})"
                                        class="btn btn-sm"
                                        data-toggle="modal"
                                        data-target="#editEksemplarModal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                    </button>
                                    <button onclick="confirm('Yakin ingin menghapus eksemplar ini?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $data->id_eksemplar }})"
                                        class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(220, 38, 38, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i data-feather="inbox"></i> Tidak ada data eksemplar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $eksemplar->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH EKSEMPLAR --}}
        <div wire:ignore.self class="modal fade" id="addEksemplarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
                        <h5 class="modal-title" style="color: white; font-weight: 600;">Tambah Eksemplar Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Buku <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model.live="id_buku" wire:change="generateKodeEksemplar">
                                            <option value="">-- Pilih Buku --</option>
                                            @foreach($bukuList as $buku)
                                            <option value="{{ $buku->id_buku }}">{{ $buku->judul }} ({{ $buku->no_panggil }})</option>
                                            @endforeach
                                        </select>
                                        @error('id_buku') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Eksemplar <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" wire:model="kode_eksemplar" placeholder="Auto generate">
                                        @error('kode_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi Rak</label>
                                        <input type="text" class="form-control" wire:model="lokasi_rak" placeholder="Contoh: RAK-A-1">
                                        @error('lokasi_rak') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipe Lokasi</label>
                                        <input type="text" class="form-control" wire:model="tipe_lokasi" placeholder="perpustakaan">
                                        @error('tipe_lokasi') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="status_eksemplar">
                                            <option value="tersedia">Tersedia</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>
                                        <small class="form-text text-muted">
                                            <i data-feather="info" style="width: 12px; height: 12px;"></i>
                                            Status "Dipinjam" akan otomatis berubah melalui sistem peminjaman
                                        </small>
                                        @error('status_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga (Rp)</label>
                                        <input type="number" class="form-control" wire:model="harga" placeholder="50000">
                                        @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <input type="date" class="form-control" wire:model="tgl_diterima">
                                        @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sumber Perolehan</label>
                                        <select class="form-control" wire:model="sumber_perolehan">
                                            <option value="">-- Pilih --</option>
                                            <option value="beli">Beli</option>
                                            <option value="hadiah">Hadiah</option>
                                        </select>
                                        @error('sumber_perolehan') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No Faktur</label>
                                        <input type="text" class="form-control" wire:model="faktur" placeholder="FKT-20250114-001">
                                        @error('faktur') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" wire:click="store" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i data-feather="save"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT EKSEMPLAR --}}
        <div wire:ignore.self class="modal fade" id="editEksemplarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
                        <h5 class="modal-title" style="color: white; font-weight: 600;">Edit Eksemplar</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Buku <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="id_buku">
                                            <option value="">-- Pilih Buku --</option>
                                            @foreach($bukuList as $buku)
                                            <option value="{{ $buku->id_buku }}">{{ $buku->judul }} ({{ $buku->no_panggil }})</option>
                                            @endforeach
                                        </select>
                                        @error('id_buku') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Eksemplar <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" wire:model="kode_eksemplar">
                                        @error('kode_eksemplar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi Rak</label>
                                        <input type="text" class="form-control" wire:model="lokasi_rak">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipe Lokasi</label>
                                        <input type="text" class="form-control" wire:model="tipe_lokasi">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select class="form-control" wire:model="status_eksemplar">
                                            <option value="tersedia">Tersedia</option>
                                            <option value="dipinjam" disabled>Dipinjam (Otomatis dari Peminjaman)</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>
                                        <small class="form-text text-muted">
                                            <i data-feather="info" style="width: 12px; height: 12px;"></i>
                                            Status "Dipinjam" dikelola otomatis oleh sistem
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga (Rp)</label>
                                        <input type="number" class="form-control" wire:model="harga">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <input type="date" class="form-control" wire:model="tgl_diterima">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sumber Perolehan</label>
                                        <select class="form-control" wire:model="sumber_perolehan">
                                            <option value="">-- Pilih --</option>
                                            <option value="beli">Beli</option>
                                            <option value="hadiah">Hadiah</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No Faktur</label>
                                        <input type="text" class="form-control" wire:model="faktur">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" wire:click="update" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i data-feather="save"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPT FEATHER ICONS --}}
@assets
<script>
    // Global function untuk refresh feather icons
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
    // Initialize on load
    refreshFeatherIcons();
    
    // Livewire 3 lifecycle hooks
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
    
    // MutationObserver sebagai backup terakhir
    const observer = new MutationObserver((mutations) => {
        refreshFeatherIcons();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});</script>