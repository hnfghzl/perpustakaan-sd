<div>
<style>
    .pengembalian-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .pengembalian-list-item {
        border-bottom: 1px solid #f3f4f6;
        padding: 16px 20px;
        transition: all 0.2s;
    }
    
    .pengembalian-list-item:hover {
        background: #f9fafb;
    }
    
    .pengembalian-list-item.terlambat {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }
    
    .pengembalian-list-item.terlambat:hover {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    }
    
    .pengembalian-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .pengembalian-badge.dipinjam {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .pengembalian-btn-action {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    
    .pengembalian-btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
</style>

<div style="padding: 28px;">
    
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px; margin-bottom: 28px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
        <h4 style="color: white; margin: 0; font-weight: 700; font-size: 22px; display: flex; align-items: center;">
            <i data-feather="rotate-ccw" style="width: 28px; height: 28px; margin-right: 12px;"></i>
            Pengembalian Buku
        </h4>
        <?php
            $activeCount = $peminjaman->where('status_buku', 'dipinjam')->count();
            $overdueCount = $peminjaman->where('status_buku', 'dipinjam')->filter(function($p) {
                return \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->lt(\Carbon\Carbon::now());
            })->count();
        ?>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 8px 0 0 40px; font-size: 14px;">
            <?php echo e($activeCount); ?> peminjaman aktif
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overdueCount > 0): ?>
                <span style="color: #fef3c7; font-weight: 600;"> • <?php echo e($overdueCount); ?> terlambat</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i data-feather="check-circle" style="width: 20px; height: 20px; color: #065f46; margin-right: 12px;"></i>
                <span style="color: #065f46; font-weight: 600; font-size: 14px;"><?php echo e(session('success')); ?></span>
            </div>
            <button x-on:click="show = false" style="background: none; border: none; color: #065f46; cursor: pointer; padding: 4px;">
                <i data-feather="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i data-feather="alert-circle" style="width: 20px; height: 20px; color: #991b1b; margin-right: 12px;"></i>
                <span style="color: #991b1b; font-weight: 600; font-size: 14px;"><?php echo e(session('error')); ?></span>
            </div>
            <button x-on:click="show = false" style="background: none; border: none; color: #991b1b; cursor: pointer; padding: 4px;">
                <i data-feather="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="pengembalian-card-modern" style="margin-bottom: 24px;">
        <div style="padding: 20px 24px;">
            <div style="display: flex; align-items: start;">
                <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 12px; border-radius: 12px; margin-right: 16px;">
                    <i data-feather="info" style="width: 24px; height: 24px; color: #1e40af;"></i>
                </div>
                <div style="flex: 1;">
                    <h6 style="color: #1e40af; font-weight: 600; margin: 0 0 8px 0; font-size: 15px;">Informasi Tarif Denda</h6>
                    <div style="color: #374151; font-size: 13px; line-height: 1.8;">
                        <strong>Keterlambatan:</strong> Rp <?php echo e(number_format($tarif_denda_per_hari, 0, ',', '.')); ?>/hari/buku •
                        <strong>Rusak:</strong> Rp <?php echo e(number_format($tarif_denda_rusak, 0, ',', '.')); ?> •
                        <strong>Hilang:</strong> Rp <?php echo e(number_format($tarif_denda_hilang, 0, ',', '.')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="pengembalian-card-modern" style="margin-bottom: 24px;">
        <div style="padding: 20px 24px;">
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 12px;">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; z-index: 10;"></i>
                        <input type="text" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05);" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.05)';">
                    </div>
                </div>
                <div class="col-md-6" style="margin-bottom: 12px;">
                    <div style="position: relative;">
                        <i data-feather="filter" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; z-index: 10; pointer-events: none;"></i>
                        <select wire:model.live="filterTerlambat" style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05); cursor: pointer;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.05)';">
                            <option value="" style="background: white; color: #374151;">Semua Peminjaman Aktif</option>
                            <option value="terlambat" style="background: white; color: #374151;">Terlambat</option>
                            <option value="belum_terlambat" style="background: white; color: #374151;">Belum Terlambat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="pengembalian-card-modern">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo)->startOfDay();
            $tgl_sekarang = \Carbon\Carbon::now()->startOfDay();
            $terlambat = $tgl_sekarang->gt($tgl_tempo);
            $hari_terlambat = $terlambat ? (int)$tgl_tempo->diffInDays($tgl_sekarang) : 0;
        ?>
        <div class="pengembalian-list-item <?php echo e($terlambat ? 'terlambat' : ''); ?>">
            <div class="row align-items-center">
                
                <div class="col-md-5">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="background: linear-gradient(135deg, <?php echo e($terlambat ? '#ef4444 0%, #dc2626' : '#3b82f6 0%, #2563eb'); ?> 100%); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="<?php echo e($terlambat ? 'alert-circle' : 'file-text'); ?>" style="width: 22px; height: 22px; color: white;"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 600; color: <?php echo e($terlambat ? '#dc2626' : '#3b82f6'); ?>; font-size: 14px; margin-bottom: 4px;"><?php echo e($data->kode_transaksi); ?></div>
                            <div style="color: #374151; font-size: 14px; font-weight: 600; margin-bottom: 4px;"><?php echo e($data->anggota->nama_anggota); ?></div>
                            <div style="font-size: 12px; color: #6b7280;">
                                <i data-feather="user" style="width: 12px; height: 12px;"></i> <?php echo e($data->user->nama_user); ?>

                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div style="font-size: 12px; color: <?php echo e($terlambat ? '#991b1b' : '#6b7280'); ?>; line-height: 1.8;">
                        <div style="margin-bottom: 4px;">
                            <i data-feather="calendar" style="width: 12px; height: 12px;"></i> 
                            <?php echo e(\Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y')); ?> - 
                            <?php echo e(\Carbon\Carbon::parse($data->tgl_jatuh_tempo)->format('d/m/Y')); ?>

                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($terlambat): ?>
                        <div style="color: #dc2626; font-weight: 600; margin-bottom: 4px;">
                            <i data-feather="alert-triangle" style="width: 12px; height: 12px;"></i> 
                            Terlambat <?php echo e($hari_terlambat); ?> hari
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div>
                            <i data-feather="book" style="width: 12px; height: 12px;"></i> 
                            <strong><?php echo e($data->jumlah_peminjaman); ?></strong> buku
                        </div>
                    </div>
                </div>

                
                <div class="col-md-3">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                        <span class="pengembalian-badge dipinjam">
                            <i data-feather="book-open" style="width: 12px; height: 12px;"></i>
                            DIPINJAM
                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                        <button class="pengembalian-btn-action" data-toggle="modal" data-target="#returnModal<?php echo e($data->id_peminjaman); ?>" wire:click="openReturnForm(<?php echo e($data->id_peminjaman); ?>)">
                            <i data-feather="check-circle" style="width: 14px; height: 14px;"></i>
                            Kembalikan
                        </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="padding: 60px 20px; text-align: center;">
            <i data-feather="inbox" style="width: 64px; height: 64px; color: #9ca3af;"></i>
            <p style="color: #6b7280; margin: 16px 0 0 0; font-size: 14px;">Tidak ada peminjaman aktif</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($peminjaman->hasPages()): ?>
    <div class="pengembalian-card-modern" style="margin-top: 20px;">
        <div style="padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div style="color: #6b7280; font-size: 13px;">
                Menampilkan <strong style="color: #374151;"><?php echo e($peminjaman->firstItem() ?? 0); ?></strong> - 
                <strong style="color: #374151;"><?php echo e($peminjaman->lastItem() ?? 0); ?></strong> dari 
                <strong style="color: #374151;"><?php echo e($peminjaman->total()); ?></strong> peminjaman
            </div>
            <nav>
                <?php echo e($peminjaman->links()); ?>

            </nav>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showReturnForm && $selectedPeminjaman): ?>
<div wire:ignore.self class="modal fade show" id="returnModal<?php echo e($selectedPeminjaman->id_peminjaman); ?>" tabindex="-1" role="dialog" style="display: block; background: rgba(0,0,0,0.5);" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);">
            
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 20px 28px;">
                <h5 style="color: white; font-weight: 600; margin: 0; display: flex; align-items: center;">
                    <i data-feather="rotate-ccw" style="width: 22px; height: 22px; margin-right: 10px;"></i>
                    Proses Pengembalian Buku
                </h5>
                <button type="button" class="close text-white" wire:click="closeReturnForm" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true" style="font-size: 32px;">&times;</span>
                </button>
            </div>

            
            <div class="modal-body" style="padding: 28px; background: #f9fafb;">
                
                <div style="background: #f3f4f6; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                    <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center;">
                        <i data-feather="info" style="width: 18px; height: 18px; margin-right: 8px; color: #6b7280;"></i>
                        Informasi Peminjaman
                    </h6>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Kode Transaksi</div>
                            <div style="font-size: 14px; color: #374151; font-weight: 600;"><?php echo e($selectedPeminjaman->kode_transaksi); ?></div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Anggota</div>
                            <div style="font-size: 14px; color: #374151; font-weight: 600;">
                                <?php echo e($selectedPeminjaman->anggota->nama_anggota); ?>

                                <span style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; font-size: 10px; padding: 2px 8px; border-radius: 4px; margin-left: 6px;"><?php echo e(strtoupper($selectedPeminjaman->anggota->jenis_anggota)); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Tanggal Pinjam</div>
                            <div style="font-size: 13px; color: #374151;"><?php echo e(\Carbon\Carbon::parse($selectedPeminjaman->tgl_pinjam)->format('d/m/Y')); ?></div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Jatuh Tempo</div>
                            <div style="font-size: 13px; color: #374151;"><?php echo e(\Carbon\Carbon::parse($selectedPeminjaman->tgl_jatuh_tempo)->format('d/m/Y')); ?></div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Petugas Peminjaman</div>
                            <div style="font-size: 13px; color: #374151;"><?php echo e($selectedPeminjaman->user->nama_user); ?></div>
                        </div>
                    </div>
                </div>

                
                <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                    <h6 style="color: #1e40af; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center;">
                        <i data-feather="calendar" style="width: 18px; height: 18px; margin-right: 8px; color: #2563eb;"></i>
                        Tanggal Pengembalian
                    </h6>
                    <input type="date" wire:model.live="tgl_kembali" max="<?php echo e(date('Y-m-d')); ?>" style="width: 100%; padding: 12px 16px; border: 2px solid #60a5fa; border-radius: 10px; font-size: 14px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#60a5fa'; this.style.boxShadow='none';">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tgl_kembali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php
                    $belumDikembalikan = $selectedPeminjaman->detailPeminjaman->filter(fn($d) => !$d->tgl_kembali);
                    $totalBelumKembali = $belumDikembalikan->count();
                ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h6 style="color: #374151; font-weight: 600; margin: 0; display: flex; align-items: center; font-size: 15px;">
                        <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                        Daftar Buku yang Dikembalikan (<span id="selectedCount"><?php echo e(count($selectedEksemplar)); ?></span>/<?php echo e($totalBelumKembali); ?>)
                    </h6>
                    <div>
                        <button type="button" wire:click="$set('selectedEksemplar', <?php echo e($belumDikembalikan->pluck('id_detail')->toJson()); ?>)" style="background: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; margin-right: 6px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                            <i data-feather="check-square" style="width: 14px; height: 14px; margin-right: 4px;"></i>
                            Pilih Semua
                        </button>
                        <button type="button" wire:click="$set('selectedEksemplar', [])" style="background: #6b7280; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            <i data-feather="square" style="width: 14px; height: 14px; margin-right: 4px;"></i>
                            Batal Pilih
                        </button>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <?php $displayIndex = 0; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $selectedPeminjaman->detailPeminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$detail->tgl_kembali): ?>
                            <?php 
                                $displayIndex++;
                                $isChecked = in_array($detail->id_detail, $selectedEksemplar);
                            ?>
                            <div style="background: white; border: 2px solid <?php echo e($isChecked ? '#3b82f6' : '#e5e7eb'); ?>; border-radius: 10px; padding: 16px; margin-bottom: 12px; transition: all 0.3s;">
                                <div class="row align-items-center">
                                    <div class="col-md-1" style="text-align: center;">
                                        <input type="checkbox" wire:model.live="selectedEksemplar" value="<?php echo e($detail->id_detail); ?>" style="width: 20px; height: 20px; cursor: pointer; accent-color: #3b82f6;">
                                    </div>
                                    <div class="col-md-1" style="text-align: center;">
                                        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 13px; margin: 0 auto;"><?php echo e($displayIndex); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="font-weight: 600; color: #3b82f6; font-size: 13px; margin-bottom: 4px;"><?php echo e($detail->eksemplar->kode_eksemplar); ?></div>
                                        <div style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 4px;"><?php echo e($detail->eksemplar->buku->judul); ?></div>
                                        <div style="font-size: 12px; color: #6b7280;"><?php echo e($detail->eksemplar->buku->no_panggil); ?></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label style="color: #6b7280; font-size: 11px; margin-bottom: 6px; display: block; font-weight: 600;">Kondisi Buku</label>
                                        <select wire:model.live="detailItems.<?php echo e($detail->id_detail); ?>.kondisi_kembali" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 13px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='#e5e7eb';">
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detailItems[$detail->id_detail]['kondisi_kembali'] !== 'baik'): ?>
                                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 4px;">Denda Item</div>
                                        <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600; padding: 6px 12px; border-radius: 8px; font-size: 13px; display: inline-block;">
                                            Rp <?php echo e(number_format($detailItems[$detail->id_detail]['denda_item'], 0, ',', '.')); ?>

                                        </span>
                                        <?php else: ?>
                                        <div style="font-size: 11px; color: #6b7280; margin-bottom: 4px;">Denda Item</div>
                                        <span style="color: #9ca3af; font-size: 13px;">-</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 20px; border-radius: 12px;">
                    <h6 style="color: #374151; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; font-size: 15px;">
                        <i data-feather="alert-circle" style="width: 18px; height: 18px; margin-right: 8px; color: #6b7280;"></i>
                        Ringkasan Denda
                    </h6>
                    <?php
                        $tgl_tempo = \Carbon\Carbon::parse($selectedPeminjaman->tgl_jatuh_tempo)->startOfDay();
                        $tgl_kembali_carbon = \Carbon\Carbon::parse($tgl_kembali)->startOfDay();
                        $hari = $tgl_kembali_carbon->gt($tgl_tempo) ? (int)$tgl_tempo->diffInDays($tgl_kembali_carbon) : 0;
                    ?>
                    <div style="background: white; padding: 14px 16px; border-radius: 10px; margin-bottom: 10px; border: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="color: #374151; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Denda Keterlambatan</div>
                                <div style="font-size: 11px; color: #6b7280;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hari > 0): ?>
                                        <?php echo e($hari); ?> hari × <?php echo e(count($selectedEksemplar)); ?> buku dipilih × Rp <?php echo e(number_format($tarif_denda_per_hari, 0, ',', '.')); ?>

                                    <?php else: ?>
                                        Tidak terlambat
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <span style="color: #374151; font-weight: 600; padding: 6px 14px; border-radius: 8px; font-size: 14px; background: #f3f4f6;">
                                Rp <?php echo e(number_format($denda_keterlambatan, 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>
                    <div style="background: white; padding: 14px 16px; border-radius: 10px; margin-bottom: 12px; border: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: #374151; font-size: 13px; font-weight: 600;">Denda Kerusakan/Kehilangan</div>
                            <span style="color: #374151; font-weight: 600; padding: 6px 14px; border-radius: 8px; font-size: 14px; background: #f3f4f6;">
                                Rp <?php echo e(number_format($denda_kerusakan, 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>
                    <div style="background: #374151; padding: 16px 18px; border-radius: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: white; font-size: 16px; font-weight: 700;">Total Denda</div>
                            <div style="color: white; font-size: 18px; font-weight: 700;">
                                Rp <?php echo e(number_format($total_denda, 0, ',', '.')); ?>

                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedEksemplar) === 0): ?>
                <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 2px solid #ef4444; padding: 16px; border-radius: 10px; margin-top: 16px;">
                    <div style="display: flex; align-items: center;">
                        <i data-feather="alert-triangle" style="width: 20px; height: 20px; margin-right: 10px; color: #dc2626;"></i>
                        <div>
                            <div style="color: #991b1b; font-weight: 600; font-size: 14px; margin-bottom: 2px;">Tidak Ada Buku yang Dipilih</div>
                            <div style="color: #b91c1c; font-size: 12px;">Silakan pilih minimal 1 buku untuk dikembalikan dengan mencentang checkbox di samping kiri.</div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="modal-footer" style="background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 28px;">
                <button type="button" class="btn btn-secondary" wire:click="closeReturnForm" style="padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px;">
                    <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                </button>
                <button wire:click="prosesKembalikan" type="button" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none;">
                    <i data-feather="check-circle" style="width: 16px; height: 16px;"></i> Proses Pengembalian
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php
        $__assetKey = '3831716293-0';

        ob_start();
    ?>
<script>
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            setTimeout(() => {
                feather.replace();
            }, 150);
        }
    }
</script>
    <?php
        $__output = ob_get_clean();

        // If the asset has already been loaded anywhere during this request, skip it...
        if (in_array($__assetKey, \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys)) {
            // Skip it...
        } else {
            \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys[] = $__assetKey;

            // Check if we're in a Livewire component or not and store the asset accordingly...
            if (isset($this)) {
                \Livewire\store($this)->push('assets', $__output, $__assetKey);
            } else {
                \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$nonLivewireAssets[$__assetKey] = $__output;
            }
        }
    ?>

<script data-navigate-once>document.addEventListener('livewire:initialized', () => {
    refreshFeatherIcons();
    
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
    
    const observer = new MutationObserver((mutations) => {
        refreshFeatherIcons();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});</script>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/pengembalian-modern.blade.php ENDPATH**/ ?>