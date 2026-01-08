<div>
<style>
    .peminjaman-card-modern {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .peminjaman-btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .peminjaman-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    .peminjaman-book-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .peminjaman-book-item:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .peminjaman-book-item.selected {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-color: #3b82f6;
    }
    
    .peminjaman-book-item.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .peminjaman-book-item.disabled:hover {
        border-color: #e5e7eb;
        transform: none;
        box-shadow: none;
    }
</style>

<div style="padding: 28px;">
    
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px 28px; border-radius: 16px; margin-bottom: 28px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
        <h4 style="color: white; margin: 0; font-weight: 700; font-size: 22px; display: flex; align-items: center;">
            <i data-feather="book-open" style="width: 28px; height: 28px; margin-right: 12px;"></i>
            Transaksi Peminjaman Buku
        </h4>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 8px 0 0 40px; font-size: 14px;">
            Catat peminjaman buku oleh anggota perpustakaan
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

    
    <div class="peminjaman-card-modern" style="margin-bottom: 24px;">
        <div style="padding: 20px 24px;">
            <div style="display: flex; align-items: start;">
                <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 12px; border-radius: 12px; margin-right: 16px;">
                    <i data-feather="info" style="width: 24px; height: 24px; color: #1e40af;"></i>
                </div>
                <div style="flex: 1;">
                    <h6 style="color: #1e40af; font-weight: 600; margin: 0 0 12px 0; font-size: 15px;">Aturan Peminjaman</h6>
                    <ul style="color: #374151; font-size: 13px; line-height: 1.8; margin: 0; padding-left: 20px;">
                        <li>Anggota dengan <strong>peminjaman aktif</strong> tidak bisa meminjam lagi sampai buku dikembalikan</li>
                        <li>Maksimal <strong><?php echo e($maxBukuPerPeminjaman); ?> buku berbeda</strong> per transaksi (tidak boleh meminjam eksemplar dari judul yang sama)</li>
                        <li>Durasi peminjaman <strong>maksimal <?php echo e($durasiPeminjaman); ?> hari</strong></li>
                        <li>Lihat semua history peminjaman di menu <strong>Master Data → History Peminjaman</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
    <div style="margin-bottom: 24px;">
        <button class="peminjaman-btn-primary" data-toggle="modal" data-target="#addPeminjamanModal">
            <i data-feather="plus-circle" style="width: 18px; height: 18px;"></i>
            Buat Peminjaman Baru
        </button>
    </div>

    
    <div class="peminjaman-card-modern">
        <div style="padding: 40px 24px; text-align: center;">
            <i data-feather="inbox" style="width: 64px; height: 64px; color: #9ca3af; margin-bottom: 16px;"></i>
            <p style="color: #6b7280; font-size: 14px; margin: 0;">
                Klik tombol <strong>"Buat Peminjaman Baru"</strong> untuk mencatat peminjaman buku
            </p>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="addPeminjamanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);">
            
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; padding: 20px 28px;">
                <h5 style="color: white; font-weight: 600; margin: 0; display: flex; align-items: center;">
                    <i data-feather="plus-circle" style="width: 22px; height: 22px; margin-right: 10px;"></i>
                    Buat Peminjaman Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="this.blur()" style="opacity: 1;">
                    <span aria-hidden="true" style="font-size: 32px;">&times;</span>
                </button>
            </div>

            
            <div class="modal-body" style="padding: 28px; background: #f9fafb;">
                <div class="row">
                    
                    <div class="col-md-5">
                        
                        <div style="background: #f3f4f6; padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #374151; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; font-size: 16px;">
                                <i data-feather="user" style="width: 20px; height: 20px; margin-right: 8px; color: #6b7280;"></i>
                                Data Peminjam
                            </h6>
                            
                            
                            <div style="position: relative; margin-bottom: 12px;">
                                <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af; z-index: 10;"></i>
                                <input type="text" 
                                    wire:model.live="searchAnggota" 
                                    placeholder="Cari nama anggota, jenis (guru/siswa), atau institusi..." 
                                    style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05);" 
                                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.05)';">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchAnggota): ?>
                            <div style="font-size: 13px; color: #6b7280; margin-bottom: 12px; padding-left: 4px;">
                                <i data-feather="info" style="width: 13px; height: 13px;"></i>
                                Ditemukan <strong style="color: #3b82f6;"><?php echo e($anggotaList->count()); ?></strong> anggota dari pencarian "<?php echo e($searchAnggota); ?>"
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <div style="margin-bottom: 16px;">
                                <label style="color: #374151; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                    Pilih Anggota <span style="color: #ef4444;">*</span>
                                </label>
                                <select wire:model.live="id_anggota" style="width: 100%; padding: 12px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 15px; transition: all 0.2s; background: white; max-height: 200px;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                    <option value="">-- Pilih Anggota --</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($anggotaList->count() > 0): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $anggotaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($a->id_anggota); ?>"><?php echo e($a->nama_anggota); ?> (<?php echo e($a->jenis_anggota == 'guru' ? 'Guru' : 'Siswa'); ?>)<?php echo e($a->institusi ? ' - ' . $a->institusi : ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <option disabled>Tidak ada anggota ditemukan</option>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['id_anggota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($peminjamanAktifAnggota > 0): ?>
                            <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); padding: 14px 16px; border-radius: 10px; border-left: 4px solid #ef4444; margin-bottom: 16px;">
                                <div style="display: flex; align-items: start;">
                                    <i data-feather="alert-triangle" style="width: 18px; height: 18px; color: #991b1b; margin-right: 10px; flex-shrink: 0; margin-top: 2px;"></i>
                                    <div style="color: #991b1b; font-size: 12px; line-height: 1.6;">
                                        <strong>PERINGATAN!</strong> Anggota ini masih memiliki <strong><?php echo e($peminjamanAktifAnggota); ?> peminjaman aktif</strong> yang belum dikembalikan!
                                        <br>Kembalikan buku terlebih dahulu di menu <strong>Pengembalian</strong>.
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 20px; border-radius: 12px; margin-bottom: 16px;">
                            <h6 style="color: #1e40af; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; font-size: 16px;">
                                <i data-feather="calendar" style="width: 20px; height: 20px; margin-right: 8px; color: #2563eb;"></i>
                                Jadwal Peminjaman
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #1e40af; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                        Tgl Pinjam <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="date" wire:model="tgl_pinjam" style="width: 100%; padding: 12px 16px; border: 2px solid #60a5fa; border-radius: 8px; font-size: 15px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#60a5fa'; this.style.boxShadow='none';">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tgl_pinjam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="col-md-6" style="margin-bottom: 16px;">
                                    <label style="color: #1e40af; font-weight: 600; font-size: 15px; margin-bottom: 8px; display: block;">
                                        Jatuh Tempo <span style="color: #ef4444;">*</span>
                                    </label>
                                    <input type="date" wire:model="tgl_jatuh_tempo" style="width: 100%; padding: 12px 16px; border: 2px solid #60a5fa; border-radius: 8px; font-size: 15px; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#60a5fa'; this.style.boxShadow='none';">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tgl_jatuh_tempo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444; font-size: 12px; margin-top: 6px;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div style="background: rgba(255,255,255,0.7); padding: 12px; border-radius: 8px; font-size: 14px; color: #1e40af;">
                                <i data-feather="info" style="width: 16px; height: 16px;"></i>
                                <strong>Info:</strong> Durasi peminjaman dapat diatur di menu Pengaturan oleh pustakawan
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedEksemplar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); padding: 12px 16px; border-radius: 10px; border-left: 4px solid #f59e0b; margin-bottom: 16px;">
                            <div style="display: flex; align-items: center;">
                                <i data-feather="alert-circle" style="width: 16px; height: 16px; color: #92400e; margin-right: 8px;"></i>
                                <span style="color: #92400e; font-size: 13px;"><?php echo e($message); ?></span>
                            </div>
                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 16px 20px; border-radius: 12px;">
                            <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center;">
                                    <i data-feather="info" style="width: 18px; height: 18px; color: #92400e; margin-right: 8px;"></i>
                                    <span style="color: #78350f; font-weight: 600; font-size: 15px;">Dipilih:</span>
                                </div>
                                <span style="background: linear-gradient(135deg, <?php echo e(count($selectedEksemplar ?? []) >= 3 ? '#ef4444 0%, #dc2626' : '#3b82f6 0%, #2563eb'); ?> 100%); color: white; font-weight: 600; padding: 6px 14px; border-radius: 6px; font-size: 15px;">
                                    <?php echo e(count($selectedEksemplar ?? [])); ?>/3 buku
                                </span>
                            </div>
                            <div style="color: #78350f; font-size: 14px; line-height: 1.7;">
                                <div style="margin-bottom: 4px;">
                                    <strong>Tersedia:</strong> <?php echo e($eksemplarList->count()); ?> eksemplar
                                </div>
                                <div style="color: #991b1b; font-weight: 600; margin-top: 8px; padding: 8px; background: rgba(254, 226, 226, 0.5); border-radius: 6px; font-size: 14px;">
                                    PENTING: Maksimal 3 buku, harus beda judul!
                                </div>
    </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showStruk && $lastPeminjaman): ?>
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 99999;" wire:click="closeStruk">
    <div style="background: white; border-radius: 16px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);" @click.stop>
        
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 16px 16px 0 0; position: relative;">
            <button wire:click="closeStruk" style="position: absolute; top: 16px; right: 16px; background: rgba(255, 255, 255, 0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                <i data-feather="x" style="width: 20px; height: 20px;"></i>
            </button>
            <h5 style="color: white; margin: 0 0 8px 0; font-weight: 700; font-size: 20px; display: flex; align-items: center;">
                <i data-feather="file-text" style="width: 24px; height: 24px; margin-right: 10px;"></i>
                Struk Peminjaman
            </h5>
            <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 13px;">
                Kode: <strong><?php echo e($lastPeminjaman->kode_transaksi); ?></strong>
            </p>
        </div>

        
        <div id="strukContent" style="padding: 28px;">
            
            <div style="text-align: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px dashed #e5e7eb;">
                <h4 style="margin: 0 0 4px 0; font-weight: 700; color: #1f2937; font-size: 18px;">
                    SD Muhammadiyah Karangwaru
                </h4>
                <p style="margin: 0; color: #6b7280; font-size: 13px;">
                    Perpustakaan Sekolah
                </p>
                <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 12px;">
                    Struk Peminjaman Buku
                </p>
            </div>

            
            <div style="margin-bottom: 24px;">
                <table style="width: 100%; font-size: 13px;">
                    <tr>
                        <td style="padding: 6px 0; color: #6b7280; width: 140px;">Kode Transaksi</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: <?php echo e($lastPeminjaman->kode_transaksi); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #6b7280;">Tanggal Pinjam</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: <?php echo e(\Carbon\Carbon::parse($lastPeminjaman->tgl_pinjam)->translatedFormat('d F Y')); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #6b7280;">Tenggat Kembali</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #dc2626;">: <?php echo e(\Carbon\Carbon::parse($lastPeminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y')); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #6b7280;">Petugas</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #1f2937;">: <?php echo e($lastPeminjaman->user->nama_user); ?></td>
                    </tr>
                </table>
            </div>

            
            <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 16px; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                <h6 style="margin: 0 0 10px 0; font-weight: 700; color: #1f2937; font-size: 14px; display: flex; align-items: center;">
                    <i data-feather="user" style="width: 16px; height: 16px; margin-right: 8px; color: #3b82f6;"></i>
                    Data Peminjam
                </h6>
                <table style="width: 100%; font-size: 13px;">
                    <tr>
                        <td style="padding: 4px 0; color: #6b7280; width: 100px;">Nama</td>
                        <td style="padding: 4px 0; font-weight: 600; color: #1f2937;">: <?php echo e($lastPeminjaman->anggota->nama_anggota); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #6b7280;">Jenis</td>
                        <td style="padding: 4px 0; color: #1f2937;">: <?php echo e(ucfirst($lastPeminjaman->anggota->jenis_anggota)); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #6b7280;">Institusi</td>
                        <td style="padding: 4px 0; color: #1f2937;">: <?php echo e($lastPeminjaman->anggota->institusi); ?></td>
                    </tr>
                </table>
            </div>

            
            <div style="margin-bottom: 24px;">
                <h6 style="margin: 0 0 12px 0; font-weight: 700; color: #1f2937; font-size: 14px; display: flex; align-items: center;">
                    <i data-feather="book-open" style="width: 16px; height: 16px; margin-right: 8px; color: #3b82f6;"></i>
                    Buku yang Dipinjam (<?php echo e(count($lastPeminjaman->detailPeminjaman)); ?> buku)
                </h6>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $lastPeminjaman->detailPeminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; margin-bottom: 10px;">
                    <div style="display: flex; align-items: start; gap: 12px;">
                        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                            <?php echo e($index + 1); ?>

                        </div>
                        <div style="flex: 1;">
                            <h6 style="margin: 0 0 6px 0; font-weight: 600; color: #1f2937; font-size: 13px;">
                                <?php echo e($detail->eksemplar->buku->judul); ?>

                            </h6>
                            <div style="font-size: 12px; color: #6b7280; line-height: 1.6;">
                                <div>📖 <strong>Kode Eksemplar:</strong> <?php echo e($detail->eksemplar->kode_eksemplar); ?></div>
                                <div>📚 <strong>No. Panggil:</strong> <?php echo e($detail->eksemplar->buku->no_panggil); ?></div>
                                <div>📍 <strong>Lokasi Rak:</strong> <?php echo e($detail->eksemplar->lokasi_rak); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 14px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.6;">
                    <i data-feather="alert-circle" style="width: 14px; height: 14px; margin-right: 6px; display: inline; vertical-align: middle;"></i>
                    <strong>Perhatian:</strong> Harap kembalikan buku tepat waktu sebelum <strong><?php echo e(\Carbon\Carbon::parse($lastPeminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y')); ?></strong>. 
                    Keterlambatan akan dikenakan denda <strong>Rp 1.000/hari/buku</strong>.
                </p>
            </div>

            
            <div style="text-align: center; padding-top: 20px; border-top: 2px dashed #e5e7eb;">
                <p style="margin: 0 0 4px 0; font-size: 12px; color: #6b7280;">
                    Terima kasih telah menggunakan layanan perpustakaan
                </p>
                <p style="margin: 0; font-size: 11px; color: #9ca3af;">
                    Dicetak pada: <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y, H:i')); ?> WIB
                </p>
            </div>
        </div>

        
        <div style="padding: 0 28px 28px 28px; display: flex; gap: 12px;">
            <button onclick="printStruk()" style="flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i data-feather="printer" style="width: 18px; height: 18px;"></i>
                Cetak Struk
            </button>
            <button wire:click="closeStruk" style="background: #f3f4f6; color: #6b7280; border: none; padding: 14px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;">
                Tutup
            </button>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>                    
                    <div class="col-md-7">
                        <h6 style="color: #374151; font-weight: 600; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; font-size: 16px;">
                            <span style="display: flex; align-items: center;">
                                <i data-feather="book" style="width: 20px; height: 20px; margin-right: 8px; color: #3b82f6;"></i>
                                Pilih Buku <span style="color: #ef4444; margin-left: 4px;">*</span>
                            </span>
                            <span style="font-size: 14px; color: #6b7280; font-weight: 400;">
                                <span style="color: #3b82f6; font-weight: 600;"><?php echo e(count($selectedEksemplar)); ?></span>/3 dipilih
                            </span>
                        </h6>
                        
                        
                        <div style="position: relative; margin-bottom: 12px;">
                            <i data-feather="search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #9ca3af; z-index: 10;"></i>
                            <input type="text" 
                                wire:model.live="searchBuku" 
                                placeholder="Cari judul, kategori, nomor panggil, atau kode eksemplar..." 
                                style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.05);" 
                                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';" 
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.05)';">
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchBuku): ?>
                        <div style="font-size: 14px; color: #6b7280; margin-bottom: 12px; padding-left: 4px;">
                            <i data-feather="info" style="width: 14px; height: 14px;"></i>
                            Ditemukan <strong style="color: #3b82f6;"><?php echo e($eksemplarList->count()); ?></strong> buku dari pencarian "<?php echo e($searchBuku); ?>"
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <div style="border: 2px solid #e5e7eb; padding: 12px; max-height: 450px; overflow-y: auto; border-radius: 12px; background: white;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eksemplarList->count() > 0): ?>
                                <?php
                                    // Ambil id_buku dari eksemplar yang sudah dipilih
                                    $selectedBukuIds = [];
                                    foreach($selectedEksemplar ?? [] as $id_eks) {
                                        $eks = $eksemplarList->firstWhere('id_eksemplar', $id_eks);
                                        if($eks) {
                                            $selectedBukuIds[] = $eks->id_buku;
                                        }
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $eksemplarList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Cek apakah buku ini sudah dipilih (id_buku duplikat)
                                    $isChecked = in_array($e->id_eksemplar, $selectedEksemplar ?? []);
                                    $bukuSudahDipilih = in_array($e->id_buku, $selectedBukuIds) && !$isChecked;
                                    $sudahMax = count($selectedEksemplar ?? []) >= 3 && !$isChecked;
                                    $isDisabled = $bukuSudahDipilih || $sudahMax;
                                ?>
                                <div class="peminjaman-book-item <?php echo e($isChecked ? 'selected' : ''); ?> <?php echo e($isDisabled && !$isChecked ? 'disabled' : ''); ?>">
                                    <div style="display: flex; align-items: start;">
                                        <div style="flex-shrink: 0; margin-right: 12px; margin-top: 2px;">
                                            <input type="checkbox" 
                                                wire:model.live="selectedEksemplar" 
                                                value="<?php echo e($e->id_eksemplar); ?>" 
                                                id="e<?php echo e($e->id_eksemplar); ?>"
                                                <?php echo e($isDisabled && !$isChecked ? 'disabled' : ''); ?>

                                                style="width: 18px; height: 18px; cursor: <?php echo e($isDisabled && !$isChecked ? 'not-allowed' : 'pointer'); ?>; accent-color: #3b82f6;">
                                        </div>
                                        <label for="e<?php echo e($e->id_eksemplar); ?>" style="flex: 1; cursor: <?php echo e($isDisabled && !$isChecked ? 'not-allowed' : 'pointer'); ?>;">
                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                                <span style="font-weight: 600; color: <?php echo e($isChecked ? '#1e40af' : '#3b82f6'); ?>; font-size: 15px;"><?php echo e($e->kode_eksemplar); ?></span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bukuSudahDipilih): ?>
                                                    <span style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 600;">Buku sudah dipilih</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div style="color: <?php echo e($isChecked ? '#1e40af' : '#374151'); ?>; font-size: 15px; font-weight: 600; margin-bottom: 6px;"><?php echo e($e->buku->judul); ?></div>
                                            <div style="display: flex; align-items: center; gap: 12px; font-size: 13px; color: <?php echo e($isChecked ? '#2563eb' : '#6b7280'); ?>;">
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="tag" style="width: 13px; height: 13px; margin-right: 4px;"></i>
                                                    <?php echo e($e->buku->no_panggil ?? '-'); ?>

                                                </span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($e->buku->kategori): ?>
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="folder" style="width: 13px; height: 13px; margin-right: 4px;"></i>
                                                    <?php echo e($e->buku->kategori->nama); ?>

                                                </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <span style="display: flex; align-items: center;">
                                                    <i data-feather="map-pin" style="width: 13px; height: 13px; margin-right: 4px;"></i>
                                                    <?php echo e($e->lokasi_rak ?? 'Tidak ada lokasi'); ?>

                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <div style="text-align: center; padding: 60px 20px;">
                                    <i data-feather="<?php echo e($searchBuku ? 'search' : 'inbox'); ?>" style="width: 56px; height: 56px; color: #9ca3af;"></i>
                                    <p style="color: #6b7280; margin: 16px 0 0 0; font-size: 15px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchBuku): ?>
                                            Tidak ada buku yang cocok dengan pencarian "<?php echo e($searchBuku); ?>"
                                        <?php else: ?>
                                            Tidak ada buku yang tersedia untuk dipinjam
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        
            
            <div class="modal-footer" style="background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 28px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="this.blur()" style="padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px;">
                    <i data-feather="x" style="width: 16px; height: 16px;"></i> Batal
                </button>
                <button wire:click="store" 
                        <?php echo e($peminjamanAktifAnggota > 0 ? 'disabled' : ''); ?>

                        title="<?php echo e($peminjamanAktifAnggota > 0 ? 'Anggota masih memiliki peminjaman aktif' : ''); ?>" 
                        class="btn" 
                        onclick="this.blur()"
                        style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none; <?php echo e($peminjamanAktifAnggota > 0 ? 'opacity: 0.5; cursor: not-allowed;' : ''); ?>">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i> Simpan Peminjaman
                </button>
            </div>
        </div>
    </div>
</div>


<script>
// Define print function globally IMMEDIATELY - BEFORE any modal loads
if (typeof window.printStruk === 'undefined') {
    window.printStruk = function() {
        var strukContent = document.getElementById('strukContent');
        if (!strukContent) {
            console.error('strukContent element not found');
            return;
        }
        
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        var html = '<!DOCTYPE html><html><head><title>Struk Peminjaman</title><style>';
        html += 'body { font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; }';
        html += '* { box-sizing: border-box; }';
        html += '</style></head><body>' + strukContent.innerHTML + '</body></html>';
        
        printWindow.document.write(html);
        printWindow.document.close();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }, 500);
    };
}
</script>

<?php $__env->startPush('scripts'); ?>
<script>
if (typeof window.peminjamanScriptLoaded === 'undefined') {
    window.peminjamanScriptLoaded = true;
    
    let featherRefreshTimeout;
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            clearTimeout(featherRefreshTimeout);
            featherRefreshTimeout = setTimeout(function() {
                feather.replace();
            }, 100);
        }
    };
    
    document.addEventListener('livewire:init', function() {
        refreshFeatherIcons();
        
        Livewire.hook('commit', function() {
            refreshFeatherIcons();
        });
        
        Livewire.on('close-modal', function() {
            if (typeof $ !== 'undefined') {
                // Hilangkan focus dari element aktif sebelum tutup modal
                if (document.activeElement) {
                    document.activeElement.blur();
                }
                
                // Tutup modal
                $('#addPeminjamanModal').modal('hide');
                
                // Aggressively cleanup setelah 500ms
                setTimeout(function() {
                    $('.modal').modal('hide');
                    $('.modal-backdrop').fadeOut(300, function() {
                        $(this).remove();
                    });
                    $('body').removeClass('modal-open').css('padding-right', '').css('overflow', '');
                }, 500);
            }
        });
        
        Livewire.on('refresh-icons', function() {
            setTimeout(function() {
                refreshFeatherIcons();
            }, 600); // Delay lebih lama untuk memastikan DOM ter-update
        });
        
        Livewire.on('email-sent', function(event) {
            const email = event.email || event[0].email;
            
            // Buat alert sukses
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 350px; border-radius: 12px; border-left: 4px solid #10b981; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center;">
                        <i data-feather="mail" style="width: 20px; height: 20px; margin-right: 10px; color: #10b981;"></i>
                        <div>
                            <strong>Email Terkirim!</strong><br>
                            <span style="font-size: 13px;">Notifikasi dikirim ke ${email}</span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" style="margin-left: 10px;">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            
            $('body').append(alertHtml);
            refreshFeatherIcons();
            
            // Auto hide setelah 5 detik
            setTimeout(function() {
                $('.alert-success').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        });
        
        Livewire.on('email-failed', function(event) {
            const error = event.error || event[0].error;
            
            // Buat alert error
            const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 350px; border-radius: 12px; border-left: 4px solid #ef4444; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="display: flex; align-items: center;">
                        <i data-feather="alert-circle" style="width: 20px; height: 20px; margin-right: 10px; color: #ef4444;"></i>
                        <div>
                            <strong>Email Gagal Dikirim!</strong><br>
                            <span style="font-size: 13px;">${error}</span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" style="margin-left: 10px;">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            
            $('body').append(alertHtml);
            refreshFeatherIcons();
            
            // Auto hide setelah 5 detik
            setTimeout(function() {
                $('.alert-danger').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        refreshFeatherIcons();
    });
}
</script>
<?php $__env->stopPush(); ?>

</div><?php /**PATH D:\Belajar\laragon\www\iscp\Projek_Perpus\resources\views/livewire/peminjaman-modern.blade.php ENDPATH**/ ?>