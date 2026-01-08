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

    
    <div class="anggota-card-modern">
        <div style="padding: 24px;">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border: none; background: #d1fae5; color: #065f46;">
                <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border: none; background: #fee2e2; color: #991b1b;">
                <i data-feather="alert-circle" style="width: 16px; height: 16px;"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div style="width: 56px; height: 56px; background: #dbeafe; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-right: 14px;">
                            <i data-feather="users" style="width: 28px; height: 28px; color: #3b82f6;"></i>
                        </div>
                        <div>
                            <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px; font-weight: 500;">Total Anggota</p>
                            <h3 style="font-size: 32px; font-weight: 700; color: #111827; margin-bottom: 0;"><?php echo e($anggota->total()); ?></h3>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6 text-right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                        <button data-toggle="modal" data-target="#addAnggotaModal" wire:click="resetInput" class="anggota-btn-primary">
                            <i data-feather="user-plus" style="width: 18px; height: 18px;"></i> Tambah Anggota
                        </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>            
            <div class="mb-4">
                <div class="input-group" style="max-width: 500px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background: white; border: 2px solid #e5e7eb; border-right: none; border-radius: 12px 0 0 12px;">
                            <i data-feather="search" style="width: 18px; height: 18px; color: #6b7280;"></i>
                        </span>
                    </div>
                    <input type="text" wire:model.live="search" class="form-control anggota-search-modern" placeholder="Cari nama, jenis, atau institusi..." style="border-left: none;">
                </div>
            </div>

            
            <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="anggota-list-item" x-data x-init="$nextTick(() => feather.replace())">
                    <div class="row align-items-center">
                        
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="anggota-avatar mr-3">
                                    <span style="font-size: 18px; color: white; font-weight: 700;">
                                        <?php echo e(strtoupper(substr($data->nama_anggota, 0, 1))); ?>

                                    </span>
                                </div>
                                <div style="min-width: 0;">
                                    <h6 style="font-weight: 600; color: #111827; margin-bottom: 4px; font-size: 15px;">
                                        <?php echo e($data->nama_anggota); ?>

                                    </h6>
                                    <div class="d-flex align-items-center" style="gap: 8px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->jenis_anggota === 'guru'): ?>
                                        <span class="anggota-badge-guru">
                                            <i data-feather="briefcase" style="width: 11px; height: 11px;"></i> Guru
                                        </span>
                                        <?php else: ?>
                                        <span class="anggota-badge-siswa">
                                            <i data-feather="book-open" style="width: 11px; height: 11px;"></i> Siswa
                                        </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span style="font-size: 12px; color: #6b7280;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->jenis_kelamin === 'laki-laki'): ?>
                                            <i data-feather="user" style="width: 12px; height: 12px; color: #3b82f6;"></i>
                                            <?php else: ?>
                                            <i data-feather="user" style="width: 12px; height: 12px; color: #ec4899;"></i>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-5 d-none d-md-block">
                            <div class="row">
                                <div class="col-6">
                                    <p style="font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 2px;">LAHIR</p>
                                    <p style="font-size: 13px; color: #374151; font-weight: 500; margin-bottom: 0;">
                                        <?php echo e($data->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->format('d/m/Y') : '-'); ?>

                                    </p>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: 11px; color: #9ca3af; font-weight: 600; margin-bottom: 2px;">MEMBER SEJAK</p>
                                    <p style="font-size: 13px; color: #374151; font-weight: 500; margin-bottom: 0;">
                                        <?php echo e($data->anggota_sejak ? \Carbon\Carbon::parse($data->anggota_sejak)->format('d/m/Y') : '-'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-3 text-right">
                            <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                                <button wire:click="edit(<?php echo e($data->id_anggota); ?>)" data-toggle="modal" data-target="#editAnggotaModal" class="anggota-btn-action">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Edit
                                </button>
                                <button onclick="confirm('Yakin hapus anggota ini?') || event.stopImmediatePropagation()" wire:click="confirmDelete(<?php echo e($data->id_anggota); ?>)" class="anggota-btn-delete">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="padding: 60px 20px; text-align: center; background: #f9fafb;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                        <i data-feather="inbox" style="width: 40px; height: 40px; color: #9ca3af;"></i>
                    </div>
                    <h6 style="color: #6b7280; font-weight: 600; margin-bottom: 8px;">Tidak ada data anggota</h6>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 0;">Gunakan tombol "Tambah Anggota" untuk memulai</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="mt-4">
                <?php echo e($anggota->links()); ?>

            </div>
        </div>
    </div>

    
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
                        
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="user" style="width: 16px; height: 16px; color: #3b82f6;"></i> Data Pribadi
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="anggota-form-control" wire:model="nama_anggota" placeholder="Contoh: Ahmad Hidayat">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama_anggota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="anggota-form-control" wire:model="email" placeholder="email@example.com">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Anggota <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_anggota">
                                        <option value="">Pilih Jenis</option>
                                        <option value="guru">Guru</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jenis_anggota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_kelamin">
                                        <option value="">Pilih</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Tanggal Lahir</label>
                                    <input type="date" class="anggota-form-control" wire:model="tgl_lahir">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tgl_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Institusi</label>
                                    <input type="text" class="anggota-form-control" wire:model="institusi" placeholder="SD Muhammadiyah Karangwaru">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['institusi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Alamat</label>
                                    <input type="text" class="anggota-form-control" wire:model="alamat" placeholder="Alamat lengkap">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        
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
                        
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; font-size: 14px;">
                                <i data-feather="user" style="width: 16px; height: 16px; color: #3b82f6;"></i> Data Pribadi
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="anggota-form-control" wire:model="nama_anggota" placeholder="Nama lengkap">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama_anggota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="anggota-form-group">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="anggota-form-control" wire:model="email" placeholder="email@example.com">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Anggota <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_anggota">
                                        <option value="">Pilih Jenis</option>
                                        <option value="guru">Guru</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jenis_anggota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="anggota-form-group">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="anggota-form-control" wire:model="jenis_kelamin">
                                        <option value="">Pilih</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger mt-1 d-block"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

    
        <?php
        $__assetKey = '1466241182-0';

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

        Livewire.hook('element.init', () => refreshFeatherIcons());
        Livewire.hook('element.updated', () => refreshFeatherIcons());
        Livewire.hook('morph.updated', () => refreshFeatherIcons());
        Livewire.hook('commit', () => refreshFeatherIcons());

        // Delete confirmation handler
        window.addEventListener('confirm-delete-anggota', event => {
            if (confirm('Yakin ingin menghapus anggota ini?')) {
                Livewire.dispatch('deleteAnggota', { id: event.detail.id });
            }
        });

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
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/anggota-modern.blade.php ENDPATH**/ ?>