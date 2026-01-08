<div>
    <style>
        .kategori-card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .kategori-btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 11px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .kategori-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .kategori-btn-action {
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

        .kategori-btn-action:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .kategori-btn-delete {
            background: #fee;
            color: #dc2626;
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

        .kategori-btn-delete:hover {
            background: #fecaca;
            color: #991b1b;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.2);
        }

        .kategori-badge-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .kategori-badge-empty {
            background: #f3f4f6;
            color: #6b7280;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .kategori-form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .kategori-form-control:focus {
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

    
    <div class="kategori-card-modern">
        
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px 16px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: white; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        <i data-feather="tag" style="width: 24px; height: 24px;"></i>
                        Mengelola Kategori Buku
                    </h5>
                    <small style="color: rgba(255,255,255,0.9); font-size: 14px;">Total: <?php echo e($kategori->total()); ?> kategori</small>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                <button data-toggle="modal" data-target="#addKategoriModal" wire:click="resetInput" class="kategori-btn-primary" style="background: white; color: #2563eb;">
                    <i data-feather="plus" style="width: 18px; height: 18px;"></i> Tambah Kategori
                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div style="padding: 28px;">
            
            <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 18px 22px; border-radius: 12px; margin-bottom: 28px; border-left: 4px solid #3b82f6;">
                <div style="display: flex; align-items: start;">
                    <i data-feather="info" style="width: 20px; height: 20px; color: #1e40af; margin-right: 14px; margin-top: 2px; flex-shrink: 0;"></i>
                    <div style="color: #1e3a8a; font-size: 13px; line-height: 1.7;">
                        <strong style="font-size: 14px; font-weight: 700;">ℹ️ Perhatian:</strong><br>
                        • Kategori yang masih memiliki <strong>buku</strong> tidak bisa dihapus<br>
                        • Hapus atau pindahkan buku ke kategori lain terlebih dahulu
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                <div style="position: relative;">
                    <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6b7280; z-index: 10;"></i>
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Cari kategori (nama/deskripsi)..." style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px 12px 44px; font-size: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                </div>
            </div>

            
            <div class="list-group" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="list-group-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 20px 24px; transition: all 0.2s;" onmouseover="this.style.background='#f9fafb';" onmouseout="this.style.background='white';">
                    <div class="row align-items-center">
                        
                        <div class="col-md-5">
                            <div class="d-flex align-items-center">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 16px; box-shadow: 0 3px 8px rgba(59, 130, 246, 0.25);">
                                    <i data-feather="tag" style="width: 24px; height: 24px; color: white;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h6 style="font-weight: 700; color: #111827; margin-bottom: 4px; font-size: 15px;"><?php echo e($data->nama); ?></h6>
                                    <small style="color: #6b7280; font-size: 13px; display: block; line-height: 1.5;">
                                        <?php echo e(Str::limit($data->deskripsi ?? 'Tidak ada deskripsi', 50)); ?>

                                    </small>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 18px;">
                                <div style="text-align: center;">
                                    <div style="font-size: 26px; font-weight: 800; color: #3b82f6; line-height: 1;"><?php echo e($data->buku_count); ?></div>
                                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px; font-weight: 600;">Jumlah Buku</div>
                                </div>
                                <div style="width: 1px; height: 44px; background: #e5e7eb;"></div>
                                <div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->buku_count > 0): ?>
                                    <span class="kategori-badge-active">AKTIF</span>
                                    <?php else: ?>
                                    <span class="kategori-badge-empty">KOSONG</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-3 text-right">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                            <div class="btn-group" role="group" x-data x-init="$nextTick(() => feather.replace())">
                                <button wire:click="edit(<?php echo e($data->id_kategori); ?>)" data-toggle="modal" data-target="#editKategoriModal" class="kategori-btn-action">
                                    <i data-feather="edit-2" style="width: 15px; height: 15px;"></i> Edit
                                </button>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->buku_count == 0): ?>
                                    <button onclick="confirm('Yakin hapus kategori <?php echo e($data->nama); ?>?') || event.stopImmediatePropagation()"
                                        wire:click="destroy(<?php echo e($data->id_kategori); ?>)"
                                        class="kategori-btn-delete" style="margin-left: 8px;">
                                        <i data-feather="trash-2" style="width: 15px; height: 15px;"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm" disabled style="background: #f3f4f6; color: #9ca3af; border: none; padding: 8px 14px; border-radius: 8px; margin-left: 8px; cursor: not-allowed;" title="Masih ada <?php echo e($data->buku_count); ?> buku">
                                        <i data-feather="lock" style="width: 15px; height: 15px;"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="list-group-item text-center" style="padding: 60px 24px; border: none; background: #f9fafb;">
                    <i data-feather="inbox" style="width: 52px; height: 52px; color: #9ca3af; margin-bottom: 14px;"></i>
                    <p style="color: #6b7280; font-size: 15px; margin: 0; font-weight: 600;">Tidak ada data kategori</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                    <small style="color: #9ca3af; font-size: 13px;">Klik tombol "Tambah Kategori" untuk menambahkan kategori baru</small>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small style="color: #6b7280; font-size: 13px;">
                    Menampilkan <?php echo e($kategori->firstItem() ?? 0); ?> - <?php echo e($kategori->lastItem() ?? 0); ?> dari <?php echo e($kategori->total()); ?> kategori
                </small>
                <nav>
                    <?php echo e($kategori->links()); ?>

                </nav>
            </div>
        </div>
    </div>

    
    <div wire:ignore.self class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 24px 28px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i data-feather="plus-circle" style="width: 22px; height: 22px;"></i>
                            Tambah Kategori Baru
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0 0;">Isi form di bawah untuk menambahkan kategori buku</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 28px; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                
                <div class="modal-body" style="padding: 28px;">
                    
                    <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
                                Nama Kategori <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" class="form-control kategori-form-control" wire:model="nama" placeholder="Contoh: Fiksi, Non-Fiksi, Referensi, Sains">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 500;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                        <div class="form-group mb-0">
                            <label style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
                                Deskripsi <small style="color: #6b7280; font-weight: 400;">(Opsional)</small>
                            </label>
                            <textarea class="form-control kategori-form-control" wire:model="deskripsi" rows="4" placeholder="Deskripsi singkat tentang kategori ini..." style="resize: vertical;"></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 500;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="modal-footer" style="background: #f9fafb; border: none; padding: 20px 28px; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 14px;">
                        <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                    </button>
                    <button type="button" wire:click="store" data-dismiss="modal" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 10px; padding: 10px 24px; font-weight: 600; font-size: 14px; border: none;">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div wire:ignore.self class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 24px 28px;">
                    <div>
                        <h5 class="modal-title" style="color: white; font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <i data-feather="edit-2" style="width: 22px; height: 22px;"></i>
                            Edit Kategori
                        </h5>
                        <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 6px 0 0 0;">Perbarui informasi kategori buku</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 28px; opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                
                <div class="modal-body" style="padding: 28px;">
                    
                    <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
                                Nama Kategori <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" class="form-control kategori-form-control" wire:model="nama" placeholder="Contoh: Fiksi, Non-Fiksi, Referensi, Sains">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 500;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div style="background: #dbeafe; padding: 20px; border-radius: 12px;">
                        <div class="form-group mb-0">
                            <label style="font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
                                Deskripsi <small style="color: #6b7280; font-weight: 400;">(Opsional)</small>
                            </label>
                            <textarea class="form-control kategori-form-control" wire:model="deskripsi" rows="4" placeholder="Deskripsi singkat tentang kategori ini..." style="resize: vertical;"></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px; font-weight: 500;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="modal-footer" style="background: #f9fafb; border: none; padding: 20px 28px; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 14px;">
                        <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                    </button>
                    <button type="button" wire:click="update" data-dismiss="modal" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 10px; padding: 10px 24px; font-weight: 600; font-size: 14px; border: none;">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i> Update Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>

    
        <?php
        $__assetKey = '820387558-0';

        ob_start();
    ?>
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
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/kategori-modern.blade.php ENDPATH**/ ?>