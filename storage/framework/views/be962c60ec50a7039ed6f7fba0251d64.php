<div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
        <i data-feather="check-circle" style="width: 18px; height: 18px;"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444;">
        <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i>
        <?php echo e(session('error')); ?>

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="color: #374151; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center;">
                    <i data-feather="settings" style="width: 24px; height: 24px; margin-right: 10px; color: #3b82f6;"></i>
                    Pengaturan Sistem Perpustakaan
                </h4>
                <p style="color: #6b7280; margin: 0; font-size: 14px;">
                    Kelola durasi peminjaman, denda, dan aturan perpustakaan
                </p>
            </div>
        </div>
    </div>

    
    <div style="background: white; padding: 28px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form wire:submit.prevent="simpan">
            <div class="row">
                
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="calendar" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Durasi Peminjaman (Hari)
                        </label>
                        <input type="number" wire:model="pengaturan.durasi_peminjaman_hari" min="1" max="90" 
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Jumlah hari maksimal untuk meminjam buku (1-90 hari)
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.durasi_peminjaman_hari'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="book" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Maksimal Buku per Peminjaman
                        </label>
                        <input type="number" wire:model="pengaturan.max_buku_per_peminjaman" min="1" max="10" 
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Jumlah maksimal buku dalam satu transaksi (1-10 buku)
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.max_buku_per_peminjaman'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="clock" style="width: 18px; height: 18px; margin-right: 8px; color: #3b82f6;"></i>
                            Denda Keterlambatan per Hari
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_per_hari" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda per hari per buku yang terlambat
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.denda_per_hari'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="tool" style="width: 18px; height: 18px; margin-right: 8px; color: #f59e0b;"></i>
                            Denda Buku Rusak
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_rusak" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#f59e0b'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda untuk buku yang dikembalikan rusak
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.denda_rusak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="col-md-6 mb-4">
                    <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; font-size: 14px;">
                            <i data-feather="alert-triangle" style="width: 18px; height: 18px; margin-right: 8px; color: #ef4444;"></i>
                            Denda Buku Hilang
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 600;">Rp</span>
                            <input type="number" wire:model="pengaturan.denda_hilang" min="0" 
                                style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                                onfocus="this.style.borderColor='#ef4444'; this.style.boxShadow='0 0 0 3px rgba(239, 68, 68, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        </div>
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Denda untuk buku yang hilang/tidak dikembalikan
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.denda_hilang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div style="background: #f0f9ff; border: 2px solid #0ea5e9; border-radius: 12px; padding: 24px; margin-top: 32px; margin-bottom: 24px;">
                <h5 style="color: #0c4a6e; font-weight: 700; margin-bottom: 18px; display: flex; align-items: center;">
                    <i data-feather="mail" style="width: 22px; height: 22px; margin-right: 10px; color: #0ea5e9;"></i>
                    Konfigurasi Email SMTP
                </h5>
                <p style="color: #0369a1; font-size: 13px; margin-bottom: 20px;">
                    Setting email untuk notifikasi peminjaman dan pengembalian buku
                </p>

                <div class="row">
                    
                    <div class="col-md-6 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Email Host (SMTP)
                        </label>
                        <input type="text" wire:model="pengaturan.email_host" placeholder="smtp.gmail.com"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Contoh: smtp.gmail.com
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-3 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Port
                        </label>
                        <input type="number" wire:model="pengaturan.email_port"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            465 (SSL) atau 587 (TLS)
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-3 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Enkripsi
                        </label>
                        <select wire:model="pengaturan.email_encryption"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-6 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Email Username
                        </label>
                        <input type="email" wire:model="pengaturan.email_username" placeholder="email@sekolah.com"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Email yang digunakan untuk login SMTP
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-6 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Email Password / App Password
                        </label>
                        <input type="password" wire:model="pengaturan.email_password" placeholder="••••••••••••••••"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Untuk Gmail gunakan App Password
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-6 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Email Pengirim (From Address)
                        </label>
                        <input type="email" wire:model="pengaturan.email_from_address" placeholder="perpus@sekolah.com"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Email yang ditampilkan sebagai pengirim
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="col-md-6 mb-4">
                        <label style="color: #374151; font-weight: 600; margin-bottom: 10px; display: block; font-size: 14px;">
                            Nama Pengirim (From Name)
                        </label>
                        <input type="text" wire:model="pengaturan.email_from_name" placeholder="Perpustakaan Sekolah"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 14px; transition: all 0.2s;" 
                            onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';" 
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                            Nama institusi yang ditampilkan di email
                        </small>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pengaturan.email_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 14px 16px; border-radius: 8px; margin-top: 16px;">
                    <div style="display: flex; align-items: start;">
                        <i data-feather="alert-circle" style="width: 18px; height: 18px; margin-right: 10px; color: #f59e0b; flex-shrink: 0; margin-top: 2px;"></i>
                        <div style="color: #92400e; font-size: 13px; line-height: 1.6;">
                            <strong>Cara membuat App Password Gmail:</strong><br>
                            1. Buka <a href="https://myaccount.google.com/apppasswords" target="_blank" style="color: #0ea5e9; text-decoration: underline;">https://myaccount.google.com/apppasswords</a><br>
                            2. Login dengan akun Gmail sekolah<br>
                            3. Buat App Password baru dengan nama "Perpustakaan"<br>
                            4. Copy 16 karakter password dan paste ke field "Email Password" di atas
                        </div>
                    </div>
                </div>
            </div>

            
            <div style="background: #eff6ff; border: 1px solid #3b82f6; border-radius: 10px; padding: 16px; margin-top: 10px; margin-bottom: 20px;">
                <div style="display: flex; align-items: start;">
                    <i data-feather="info" style="width: 20px; height: 20px; margin-right: 12px; color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
                    <div style="color: #1e40af; font-size: 13px; line-height: 1.6;">
                        <strong>Informasi:</strong> Perubahan pengaturan akan langsung berlaku untuk transaksi peminjaman baru. 
                        Transaksi yang sudah ada tidak akan terpengaruh oleh perubahan ini.
                    </div>
                </div>
            </div>

            
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 10px; border-top: 1px solid #e5e7eb;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPustakawan): ?>
                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i>
                    Simpan Perubahan
                </button>
                <?php else: ?>
                <div style="background: #f3f4f6; color: #6b7280; padding: 12px 20px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="lock" style="width: 16px; height: 16px;"></i>
                    Hanya pustakawan yang dapat mengubah pengaturan
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </form>
    </div>
</div>

    <?php
        $__assetKey = '772112638-0';

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

    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert) {
                $(alert).fadeOut();
            }
        });
    }, 5000);
});</script>
<?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/pengaturan-component.blade.php ENDPATH**/ ?>