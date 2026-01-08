<div>
    <style>
        .pengembalian-card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .pengembalian-btn-detail {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pengembalian-btn-detail:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .pengembalian-btn-bayar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pengembalian-btn-bayar:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .pengembalian-badge-lunas {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .pengembalian-badge-belum {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .pengembalian-form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .pengembalian-form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #10b981; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15); background: #f0fdf4; border-color: #86efac;">
        <i data-feather="check-circle" style="width: 18px; height: 18px; color: #059669;"></i>
        <span style="color: #065f46; font-weight: 500; margin-left: 8px;"><?php echo e(session('success')); ?></span>
        <button type="button" class="close" data-dismiss="alert" style="color: #059669;">&times;</button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #ef4444; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15); background: #fef2f2; border-color: #fca5a5;">
        <i data-feather="x-circle" style="width: 18px; height: 18px; color: #dc2626;"></i>
        <span style="color: #991b1b; font-weight: 500; margin-left: 8px;"><?php echo e(session('error')); ?></span>
        <button type="button" class="close" data-dismiss="alert" style="color: #dc2626;">&times;</button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('info')): ?>
    <div class="alert alert-info alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #3b82f6; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15); background: #eff6ff; border-color: #93c5fd;">
        <i data-feather="info" style="width: 18px; height: 18px; color: #2563eb;"></i>
        <span style="color: #1e3a8a; font-weight: 500; margin-left: 8px;"><?php echo e(session('info')); ?></span>
        <button type="button" class="close" data-dismiss="alert" style="color: #2563eb;">&times;</button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="pengembalian-card-modern">
        
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px 16px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: white; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        <i data-feather="clock" style="width: 24px; height: 24px;"></i>
                        History Pengembalian Buku
                    </h5>
                    <?php
                        $totalHistory = $peminjaman->total();
                        $unpaidCount = $peminjaman->where('status_pembayaran', 'belum_dibayar')->where('denda_total', '>', 0)->count();
                    ?>
                    <small style="color: rgba(255,255,255,0.9); font-size: 14px;">
                        Total: <?php echo e($totalHistory); ?> transaksi
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unpaidCount > 0): ?>
                            <span style="color: #fef3c7; font-weight: 600;"> • <?php echo e($unpaidCount); ?> belum lunas</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </small>
                </div>
            </div>
        </div>

        <div style="padding: 28px;">
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div style="position: relative;">
                        <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6b7280; z-index: 10; pointer-events: none;"></i>
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kode transaksi atau nama anggota..." style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px 12px 44px; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select form-control" wire:model.live="filterPembayaran" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; font-size: 14px; font-weight: 600; color: #000 !important; background-color: #fff !important; box-shadow: 0 2px 6px rgba(0,0,0,0.05); cursor: pointer;">
                        <option value="" selected style="color: #000; font-weight: 600;">Semua Pembayaran</option>
                        <option value="belum_dibayar" style="color: #000;">Belum Lunas</option>
                        <option value="sudah_dibayar" style="color: #000;">Sudah Lunas</option>
                        <option value="tanpa_denda" style="color: #000;">Tanpa Denda</option>
                    </select>
                </div>
            </div>

            
            <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $tgl_tempo = \Carbon\Carbon::parse($data->tgl_jatuh_tempo);
                    $tgl_kembali = $data->detailPeminjaman->first()->tgl_kembali ?? null;
                    $has_denda = $data->denda_total > 0;
                    $belum_lunas = $has_denda && $data->status_pembayaran === 'belum_dibayar';
                ?>
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 20px 24px; transition: all 0.2s; <?php echo e($belum_lunas ? 'background: #fef3c7;' : ''); ?>" onmouseover="this.style.background='<?php echo e($belum_lunas ? '#fde68a' : '#f9fafb'); ?>';" onmouseout="this.style.background='<?php echo e($belum_lunas ? '#fef3c7' : 'white'); ?>';">
                    <div class="row align-items-center">
                        
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="background: linear-gradient(135deg, <?php echo e($belum_lunas ? '#f59e0b 0%, #d97706' : '#10b981 0%, #059669'); ?> 100%); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 3px 8px rgba(<?php echo e($belum_lunas ? '245, 158, 11' : '16, 185, 129'); ?>, 0.25);">
                                    <i data-feather="<?php echo e($belum_lunas ? 'alert-circle' : 'check-circle'); ?>" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; color: <?php echo e($belum_lunas ? '#d97706' : '#059669'); ?>; font-size: 14px; margin-bottom: 4px;"><?php echo e($data->kode_transaksi); ?></div>
                                    <div style="color: #374151; font-size: 14px; font-weight: 600; margin-bottom: 3px;"><?php echo e($data->anggota->nama_anggota); ?></div>
                                    <div style="font-size: 12px; color: #6b7280;">
                                        <i data-feather="user" style="width: 12px; height: 12px;"></i> <?php echo e($data->user->nama_user); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-3">
                            <div style="font-size: 13px; color: #6b7280; line-height: 1.8;">
                                <div style="margin-bottom: 4px;">
                                    <i data-feather="calendar" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">Pinjam:</strong> <?php echo e(\Carbon\Carbon::parse($data->tgl_pinjam)->format('d/m/Y')); ?>

                                </div>
                                <div style="margin-bottom: 4px;">
                                    <i data-feather="check" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;">Kembali:</strong> <?php echo e($tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d/m/Y') : '-'); ?>

                                </div>
                                <div>
                                    <i data-feather="book" style="width: 13px; height: 13px;"></i> 
                                    <strong style="color: #374151;"><?php echo e($data->jumlah_peminjaman); ?></strong> buku
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_denda): ?>
                                <div style="font-size: 13px; line-height: 1.8;">
                                    <div style="color: #dc2626; font-weight: 700; margin-bottom: 6px;">
                                        <i data-feather="alert-circle" style="width: 13px; height: 13px;"></i> Denda: Rp <?php echo e(number_format($data->denda_total, 0, ',', '.')); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->status_pembayaran === 'belum_dibayar'): ?>
                                        <span class="pengembalian-badge-belum">BELUM LUNAS</span>
                                    <?php else: ?>
                                        <span class="pengembalian-badge-lunas">LUNAS</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div style="font-size: 13px; color: #059669; font-weight: 700;">
                                    <i data-feather="check-circle" style="width: 13px; height: 13px;"></i> Tanpa Denda
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="col-md-2 text-right">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="viewDetail(<?php echo e($data->id_peminjaman); ?>)" class="pengembalian-btn-detail">
                                    <i data-feather="eye" style="width: 15px; height: 15px;"></i> Detail
                                </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan && $belum_lunas): ?>
                                    <button onclick="confirm('Konfirmasi pembayaran denda Rp <?php echo e(number_format($data->denda_total, 0, ',', '.')); ?>?') || event.stopImmediatePropagation()"
                                        wire:click="markAsPaid(<?php echo e($data->id_peminjaman); ?>)"
                                        class="pengembalian-btn-bayar">
                                        <i data-feather="dollar-sign" style="width: 15px; height: 15px;"></i> Bayar
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                    <i data-feather="inbox" style="width: 52px; height: 52px; color: #9ca3af; margin-bottom: 14px;"></i>
                    <p style="color: #6b7280; font-size: 15px; margin: 0; font-weight: 600;">Tidak ada history pengembalian</p>
                    <small style="color: #9ca3af; font-size: 13px;">Transaksi yang sudah dikembalikan akan muncul di sini</small>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small style="color: #6b7280; font-size: 13px;">
                    Menampilkan <?php echo e($peminjaman->firstItem() ?? 0); ?> - <?php echo e($peminjaman->lastItem() ?? 0); ?> dari <?php echo e($peminjaman->total()); ?> transaksi
                </small>
                <nav>
                    <?php echo e($peminjaman->links()); ?>

                </nav>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDetail && $detailPeminjaman): ?>
    <div wire:ignore.self class="modal fade show" id="detailModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" wire:click.self="closeDetail">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 24px 28px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i data-feather="file-text" style="width: 22px; height: 22px;"></i>
                            Detail Pengembalian
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0 0;"><?php echo e($detailPeminjaman->kode_transaksi); ?></p>
                    </div>
                    <button type="button" wire:click="closeDetail" class="close text-white" aria-label="Close" style="font-size: 28px; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                
                <div class="modal-body" style="padding: 28px;">
                    
                    <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 14px;">
                            <i data-feather="user" style="width: 16px; height: 16px;"></i> Data Anggota
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Nama Anggota</div>
                                <div style="font-weight: 700; color: #111827; font-size: 14px;"><?php echo e($detailPeminjaman->anggota->nama_anggota); ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Jenis Anggota</div>
                                <div style="font-weight: 700; color: #111827; font-size: 14px;"><?php echo e(ucfirst($detailPeminjaman->anggota->jenis_anggota)); ?></div>
                            </div>
                        </div>
                    </div>

                    
                    <div style="background: #dbeafe; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 14px;">
                            <i data-feather="calendar" style="width: 16px; height: 16px;"></i> Info Transaksi
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Tanggal Pinjam</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;"><?php echo e(\Carbon\Carbon::parse($detailPeminjaman->tgl_pinjam)->format('d M Y')); ?></div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Tanggal Kembali</div>
                                <?php $tgl_kembali = $detailPeminjaman->detailPeminjaman->first()->tgl_kembali ?? null; ?>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;"><?php echo e($tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali)->format('d M Y') : '-'); ?></div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Diproses Oleh</div>
                                <div style="font-weight: 700; color: #111827; font-size: 13px;"><?php echo e($detailPeminjaman->user->nama_user); ?></div>
                            </div>
                        </div>
                    </div>

                    
                    <div style="margin-bottom: 20px;">
                        <h6 style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 12px;">
                            <i data-feather="book-open" style="width: 16px; height: 16px;"></i> Daftar Buku (<?php echo e($detailPeminjaman->jumlah_peminjaman); ?>)
                        </h6>
                        <div style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                            <table class="table mb-0" style="font-size: 13px;">
                                <thead style="background: #f9fafb;">
                                    <tr>
                                        <th style="padding: 12px; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb;">Judul Buku</th>
                                        <th style="padding: 12px; text-align: center; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb; width: 120px;">Kondisi</th>
                                        <th style="padding: 12px; text-align: right; font-weight: 700; color: #4b5563; border-bottom: 2px solid #e5e7eb; width: 130px;">Denda Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $detailPeminjaman->detailPeminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 12px; color: #374151; font-weight: 600;">
                                            <div><?php echo e($detail->eksemplar->buku->judul); ?></div>
                                            <div style="font-size: 11px; color: #6b7280; font-family: monospace;"><?php echo e($detail->eksemplar->kode_eksemplar); ?></div>
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->kondisi_kembali === 'baik'): ?>
                                                <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">BAIK</span>
                                            <?php elseif($detail->kondisi_kembali === 'rusak'): ?>
                                                <span style="background: #fed7aa; color: #92400e; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">RUSAK</span>
                                            <?php elseif($detail->kondisi_kembali === 'hilang'): ?>
                                                <span style="background: #fecaca; color: #991b1b; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700;">HILANG</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td style="padding: 12px; text-align: right; color: <?php echo e($detail->denda_item > 0 ? '#dc2626' : '#6b7280'); ?>; font-weight: <?php echo e($detail->denda_item > 0 ? '700' : '400'); ?>;">
                                            Rp <?php echo e(number_format($detail->denda_item, 0, ',', '.')); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detailPeminjaman->denda_total > 0): ?>
                    <div style="background: #fee2e2; padding: 20px; border-radius: 12px; border-left: 4px solid #dc2626;">
                        <h6 style="font-weight: 700; color: #991b1b; font-size: 14px; margin-bottom: 12px;">
                            <i data-feather="alert-circle" style="width: 16px; height: 16px;"></i> Rincian Denda
                        </h6>
                        <?php
                            $denda_keterlambatan = 0;
                            $denda_kerusakan = 0;
                            
                            $tgl_tempo = \Carbon\Carbon::parse($detailPeminjaman->tgl_jatuh_tempo);
                            $tgl_kembali_carbon = $tgl_kembali ? \Carbon\Carbon::parse($tgl_kembali) : null;
                            if ($tgl_kembali_carbon && $tgl_kembali_carbon->gt($tgl_tempo)) {
                                $hari_terlambat = $tgl_kembali_carbon->diffInDays($tgl_tempo);
                                $denda_keterlambatan = $hari_terlambat * $detailPeminjaman->jumlah_peminjaman * 1000;
                            }
                            
                            $denda_kerusakan = $detailPeminjaman->detailPeminjaman->sum('denda_item');
                        ?>
                        <div style="font-size: 13px; color: #991b1b; line-height: 2;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($denda_keterlambatan > 0): ?>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Denda Keterlambatan (<?php echo e($hari_terlambat); ?> hari × <?php echo e($detailPeminjaman->jumlah_peminjaman); ?> buku)</span>
                                <span style="font-weight: 700;">Rp <?php echo e(number_format($denda_keterlambatan, 0, ',', '.')); ?></span>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($denda_kerusakan > 0): ?>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Denda Kerusakan/Hilang</span>
                                <span style="font-weight: 700;">Rp <?php echo e(number_format($denda_kerusakan, 0, ',', '.')); ?></span>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div style="display: flex; justify-content: space-between; padding-top: 12px; margin-top: 12px; border-top: 2px solid rgba(220, 38, 38, 0.3); font-size: 15px;">
                                <span style="font-weight: 700;">Total Denda</span>
                                <span style="font-weight: 800;">Rp <?php echo e(number_format($detailPeminjaman->denda_total, 0, ',', '.')); ?></span>
                            </div>
                            <div style="margin-top: 12px; padding-top: 12px; border-top: 2px solid rgba(220, 38, 38, 0.3);">
                                <span style="font-weight: 700;">Status Pembayaran:</span> 
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detailPeminjaman->status_pembayaran === 'belum_dibayar'): ?>
                                    <span class="pengembalian-badge-belum">BELUM LUNAS</span>
                                <?php else: ?>
                                    <span class="pengembalian-badge-lunas">LUNAS</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div style="background: #d1fae5; padding: 20px; border-radius: 12px; text-align: center; border-left: 4px solid #10b981;">
                        <h6 style="font-weight: 700; color: #065f46; font-size: 14px; margin-bottom: 6px;">
                            <i data-feather="check-circle" style="width: 16px; height: 16px;"></i> Tidak Ada Denda
                        </h6>
                        <div style="font-size: 13px; color: #065f46;">Buku dikembalikan tepat waktu dan dalam kondisi baik</div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="modal-footer" style="background: #f9fafb; border: none; padding: 20px 28px; border-radius: 0 0 16px 16px;">
                    <button type="button" wire:click="closeDetail" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 14px;">
                        <i data-feather="x" style="width: 16px; height: 16px;"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
        <?php
        $__assetKey = '1595723824-0';

        ob_start();
    ?>
    <script>
        window.refreshFeatherIcons = function() {
            if (typeof feather !== 'undefined') {
                setTimeout(() => {
                    feather.replace();
                    console.log('✅ Pengembalian icons refreshed');
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

        // Livewire lifecycle hooks
        Livewire.hook('element.init', () => refreshFeatherIcons());
        Livewire.hook('element.updated', () => refreshFeatherIcons());
        Livewire.hook('morph.updated', () => refreshFeatherIcons());
        Livewire.hook('commit', () => refreshFeatherIcons());

        // MutationObserver sebagai final backup
        const observer = new MutationObserver(() => refreshFeatherIcons());
        observer.observe(document.body, { childList: true, subtree: true });

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
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/history-pengembalian-modern.blade.php ENDPATH**/ ?>