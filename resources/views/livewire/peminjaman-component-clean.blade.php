<div>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i data-feather="file-text"></i> Mengelola Peminjaman Buku
            </h3>
            <button class="btn btn-primary" wire:click="$toggle('showForm')">
                <i data-feather="plus"></i> Tambah Peminjaman
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

        @if($showForm)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Tambah Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Anggota <span class="text-danger">*</span></label>
                    <select class="form-control" wire:model="id_anggota">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggotaList as $a)
                        <option value="{{ $a->id_anggota }}">{{ $a->nama_anggota }} ({{ $a->jenis_anggota == 'guru' ? 'Guru' : 'Siswa' }})</option>
                        @endforeach
                    </select>
                    @error('id_anggota')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" wire:model="tgl_pinjam">
                            @error('tgl_pinjam')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" wire:model="tgl_jatuh_tempo">
                            @error('tgl_jatuh_tempo')<small class="text-danger d-block">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>

                @error('selectedEksemplar')
                <div class="alert alert-warning alert-dismissible fade show">
                    <i data-feather="alert-circle"></i> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @enderror

                <div class="form-group">
                    <label>Pilih Buku <span class="text-danger">*</span></label>
                    <div style="border:1px solid #dee2e6;padding:10px;max-height:250px;overflow-y:auto;border-radius:4px;background:#f8f9fa">
                        @if($eksemplarList->count() > 0)
                            @foreach($eksemplarList as $e)
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" wire:model="selectedEksemplar" value="{{ $e->id_eksemplar }}" id="e{{ $e->id_eksemplar }}">
                                <label class="form-check-label" for="e{{ $e->id_eksemplar }}">
                                    <strong>{{ $e->kode_eksemplar }}</strong> - {{ $e->buku->judul_buku }}
                                    <br><small class="text-muted">Lokasi: {{ $e->lokasi_rak ?? '-' }} | Status: <span class="badge bg-success">{{ ucfirst($e->status_eksemplar) }}</span></small>
                                </label>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center mb-0"><i data-feather="info"></i> Tidak ada buku yang tersedia untuk dipinjam</p>
                        @endif
                    </div>
                    <small class="text-muted d-block mt-2">Dipilih: <strong>{{ count($selectedEksemplar ?? []) }}</strong> buku | Tersedia: <strong>{{ $eksemplarList->count() }}</strong> eksemplar</small>
                </div>

                <div class="d-flex justify-content-end">
                    <button wire:click="$toggle('showForm')" class="btn btn-secondary mr-2">
                        <i data-feather="x"></i> Batal
                    </button>
                    <button wire:click="store" class="btn btn-primary">
                        <i data-feather="save"></i> Simpan Peminjaman
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Filter & Search --}}
                <div class="row mb-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" wire:model.live="search" placeholder="🔍 Cari kode transaksi atau nama anggota...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" wire:model.live="filterStatus">
                            <option value="">-- Semua Status --</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="kembali">Kembali</option>
                            <option value="hilang">Hilang</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <table class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th style="width: 5%">No</th>
                            <th style="width: 12%">Kode Transaksi</th>
                            <th style="width: 18%">Anggota</th>
                            <th style="width: 10%">Tgl Pinjam</th>
                            <th style="width: 10%">Jatuh Tempo</th>
                            <th style="width: 8%">Jumlah</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 12%">Petugas</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $index => $data)
                        <tr>
                            <td class="text-center">{{ $peminjaman->firstItem() + $index }}</td>
                            <td><strong>{{ $data->kode_transaksi }}</strong></td>
                            <td>{{ $data->anggota->nama_anggota }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $data->jumlah_peminjaman }}</td>
                            <td class="text-center">
                                @if($data->status_buku == 'dipinjam')
                                <span class="badge bg-warning">Dipinjam</span>
                                @elseif($data->status_buku == 'kembali')
                                <span class="badge bg-success">Kembali</span>
                                @elseif($data->status_buku == 'hilang')
                                <span class="badge bg-dark">Hilang</span>
                                @else
                                <span class="badge bg-danger">Rusak</span>
                                @endif
                            </td>
                            <td>{{ $data->user->nama_user }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-info">
                                        <i data-feather="eye" style="width: 14px; height: 14px;"></i> Lihat
                                    </button>
                                    @if($data->status_buku == 'dipinjam')
                                    <button onclick="confirm('Yakin ingin kembalikan buku ini?') || event.stopImmediatePropagation()"
                                        wire:click="returnBook({{ $data->id_peminjaman }})"
                                        class="btn btn-sm btn-success">
                                        <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Kembalikan
                                    </button>
                                    @endif
                                    <button onclick="confirm('Yakin ingin menghapus peminjaman ini?') || event.stopImmediatePropagation()"
                                        wire:click="destroy({{ $data->id_peminjaman }})"
                                        class="btn btn-sm btn-danger">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i data-feather="inbox" style="width: 40px; height: 40px;"></i>
                                <p class="mt-2 mb-0">Tidak ada data peminjaman</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan {{ $peminjaman->firstItem() ?? 0 }} - {{ $peminjaman->lastItem() ?? 0 }} dari {{ $peminjaman->total() }} data
                    </div>
                    <nav>
                        {{ $peminjaman->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => feather.replace());
document.addEventListener('livewire:navigated', () => feather.replace());
</script>
</div>