<div>
<style>
    .profil-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .profil-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }
    
    .profil-avatar-letter {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        color: white;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .profil-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .profil-badge.pustakawan {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .profil-badge.kepala {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }
</style>

<div style="padding: 28px;">
    
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px; margin-bottom: 28px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
        <h4 style="color: white; margin: 0; font-weight: 700; font-size: 22px; display: flex; align-items: center;">
            <i data-feather="user" style="width: 28px; height: 28px; margin-right: 12px;"></i>
            Profil Saya
        </h4>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 8px 0 0 40px; font-size: 14px;">
            Kelola informasi pribadi dan keamanan akun Anda
        </p>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #10b981;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i data-feather="check-circle" style="width: 20px; height: 20px; color: #065f46; margin-right: 12px;"></i>
                <span style="color: #065f46; font-weight: 600; font-size: 14px;"><?php echo e(session('success')); ?></span>
            </div>
            <button @click="show = false" style="background: none; border: none; color: #065f46; cursor: pointer; padding: 4px;">
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
            <button @click="show = false" style="background: none; border: none; color: #991b1b; cursor: pointer; padding: 4px;">
                <i data-feather="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="row">
        
        <div class="col-md-4">
            
            <div class="profil-card" style="margin-bottom: 24px;">
                <div style="padding: 32px 24px; text-align: center;">
                    
                    <div style="margin-bottom: 20px; position: relative; display: inline-block;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->foto_profil): ?>
                            <img src="<?php echo e(asset('storage/' . $user->foto_profil)); ?>" 
                                 alt="<?php echo e($user->nama_user); ?>" 
                                 class="profil-avatar">
                            
                            
                            <button wire:click="hapusFoto" 
                                    onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                    style="position: absolute; bottom: 5px; right: -5px; width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: 2px solid white; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                                    title="Hapus Foto"
                                    onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(220, 38, 38, 0.4)';" 
                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                                <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                            </button>
                        <?php else: ?>
                            <div class="profil-avatar-letter">
                                <?php echo e(strtoupper(substr($user->nama_user, 0, 1))); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <h5 style="color: #374151; font-weight: 700; margin-bottom: 8px; font-size: 20px;"><?php echo e($user->nama_user); ?></h5>
                    <div style="margin-bottom: 16px;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->role === 'pustakawan'): ?>
                            <span class="profil-badge pustakawan">
                                <i data-feather="user-check" style="width: 14px; height: 14px;"></i>
                                Pustakawan
                            </span>
                        <?php elseif($user->role === 'kepala'): ?>
                            <span class="profil-badge kepala">
                                <i data-feather="award" style="width: 14px; height: 14px;"></i>
                                Kepala Sekolah
                            </span>
                        <?php else: ?>
                            <span class="profil-badge" style="background: #6b7280; color: white;"><?php echo e(ucfirst($user->role)); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div style="display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 14px; margin-bottom: 16px;">
                        <i data-feather="mail" style="width: 16px; height: 16px; margin-right: 8px;"></i>
                        <span><?php echo e($user->email); ?></span>
                    </div>

                    
                    <div style="height: 1px; background: #e5e7eb; margin: 20px 0;"></div>

                    
                    <div style="display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 13px;">
                        <i data-feather="calendar" style="width: 14px; height: 14px; margin-right: 6px;"></i>
                        <span>Bergabung <?php echo e(\Carbon\Carbon::parse($user->created_at)->format('d M Y')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="profil-card">
                <div style="padding: 20px 24px;">
                    <div style="display: flex; align-items: start;">
                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 12px; border-radius: 12px; margin-right: 16px;">
                            <i data-feather="info" style="width: 22px; height: 22px; color: #1e40af;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h6 style="color: #1e40af; font-weight: 600; margin: 0 0 12px 0; font-size: 15px;">Panduan Profil</h6>
                            <ul style="color: #374151; font-size: 13px; line-height: 1.8; margin: 0; padding-left: 20px;">
                                <li>Anda dapat mengubah nama dan email</li>
                                <li>Password minimal 6 karakter</li>
                                <li>Gunakan password yang kuat</li>
                                <li>Foto maksimal 2MB (JPG, PNG)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            
            <div class="profil-card" style="margin-bottom: 24px;">
                <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 18px 24px; border-bottom: 1px solid #e5e7eb;">
                    <h6 style="color: white; font-weight: 600; margin: 0; display: flex; align-items: center; font-size: 16px;">
                        <i data-feather="edit" style="width: 18px; height: 18px; margin-right: 10px;"></i>
                        Edit Profil
                    </h6>
                </div>
                <div style="padding: 28px;">
                    <form wire:submit.prevent="updateProfil">
                        
                        <div style="margin-bottom: 24px;">
                            <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                Foto Profil
                            </label>
                            <div style="position: relative;">
                                <input type="file" id="fotoProfil" wire:model="foto_profil" accept="image/*" style="display: none;">
                                <label for="fotoProfil" style="display: flex; align-items: center; padding: 12px 16px; border: 2px dashed #d1d5db; border-radius: 10px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#3b82f6'; this.style.background='#f0f9ff';" onmouseout="this.style.borderColor='#d1d5db'; this.style.background='white';">
                                    <i data-feather="upload" style="width: 18px; height: 18px; color: #6b7280; margin-right: 10px;"></i>
                                    <span style="color: #6b7280; font-size: 14px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($foto_profil): ?>
                                            <?php echo e($foto_profil->getClientOriginalName()); ?>

                                        <?php else: ?>
                                            Pilih foto profil...
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </label>
                            </div>
                            <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                                <i data-feather="info" style="width: 12px; height: 12px;"></i>
                                Format: JPG, PNG, JPEG. Maksimal 2MB
                            </small>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['foto_profil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($foto_profil): ?>
                            <div style="margin-top: 16px; text-align: center;">
                                <img src="<?php echo e($foto_profil->temporaryUrl()); ?>" 
                                     alt="Preview" 
                                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #3b82f6; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);">
                                <p style="color: #6b7280; font-size: 12px; margin-top: 8px;">Preview foto baru</p>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            
                            <div wire:loading wire:target="foto_profil" style="margin-top: 12px;">
                                <div style="display: flex; align-items: center; color: #3b82f6; font-size: 13px;">
                                    <div class="spinner-border spinner-border-sm" role="status" style="margin-right: 8px;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <span>Uploading foto...</span>
                                </div>
                            </div>
                        </div>

                        
                        <div style="margin-bottom: 20px;">
                            <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                Nama Lengkap <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" wire:model="nama_user" placeholder="Masukkan nama lengkap" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div style="margin-bottom: 20px;">
                            <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                Email <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" wire:model="email" placeholder="email@example.com" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div style="margin-bottom: 24px;">
                            <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                Role
                            </label>
                            <input type="text" value="<?php echo e($role === 'pustakawan' ? 'Pustakawan' : 'Kepala Sekolah'); ?>" disabled style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; background: #f9fafb; color: #6b7280;">
                            <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">Role tidak bisa diubah</small>
                        </div>

                        
                        <div style="display: flex; justify-content: flex-end;">
                            <button type="submit" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(37, 99, 235, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i data-feather="save" style="width: 16px; height: 16px;"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="profil-card">
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 18px 24px; border-bottom: 1px solid #e5e7eb;">
                    <h6 style="color: white; font-weight: 600; margin: 0; display: flex; align-items: center; font-size: 16px;">
                        <i data-feather="lock" style="width: 18px; height: 18px; margin-right: 10px;"></i>
                        Keamanan Akun
                    </h6>
                </div>
                <div style="padding: 28px;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showPasswordForm): ?>
                        <div style="display: flex; align-items: start; margin-bottom: 20px;">
                            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 12px; border-radius: 12px; margin-right: 16px;">
                                <i data-feather="shield" style="width: 22px; height: 22px; color: #92400e;"></i>
                            </div>
                            <div>
                                <h6 style="color: #78350f; font-weight: 600; margin: 0 0 8px 0; font-size: 15px;">Lindungi Akun Anda</h6>
                                <p style="color: #6b7280; font-size: 13px; margin: 0; line-height: 1.6;">Gunakan password yang kuat dan unik untuk menjaga keamanan akun perpustakaan Anda.</p>
                            </div>
                        </div>
                        <button wire:click="$toggle('showPasswordForm')" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(217, 119, 6, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i data-feather="key" style="width: 16px; height: 16px;"></i>
                            Ganti Password
                        </button>
                    <?php else: ?>
                        <form wire:submit.prevent="updatePassword">
                            <div style="margin-bottom: 20px;">
                                <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                    Password Lama <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="password" wire:model="current_password" placeholder="Masukkan password lama" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                    Password Baru <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="password" wire:model="new_password" placeholder="Minimal 6 karakter" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div style="margin-bottom: 24px;">
                                <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                                    Konfirmasi Password Baru <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="password" wire:model="new_password_confirmation" placeholder="Ulangi password baru" style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                <button type="button" wire:click="cancelPasswordChange" style="background: #6b7280; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#4b5563';" onmouseout="this.style.background='#6b7280';">
                                    <i data-feather="x" style="width: 16px; height: 16px;"></i>
                                    Batal
                                </button>
                                <button type="submit" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(217, 119, 6, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i data-feather="check" style="width: 16px; height: 16px;"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
        $__assetKey = '883460574-0';

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
</div>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/profil-modern.blade.php ENDPATH**/ ?>