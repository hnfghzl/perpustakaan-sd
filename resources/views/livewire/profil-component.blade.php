<div>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i data-feather="user"></i> Profil Saya
                    </h3>
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

                <div class="row">
                    {{-- Card Profil --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center py-4">
                                <div class="mb-3 position-relative d-inline-block">
                                    @if($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                             alt="{{ $user->nama_user }}" 
                                             class="rounded-circle" 
                                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #1ABC9C;">
                                        
                                        {{-- Tombol Hapus Foto (floating) --}}
                                        <button wire:click="hapusFoto" 
                                                onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                                class="btn btn-sm rounded-circle position-absolute"
                                                style="bottom: 0; right: -10px; width: 35px; height: 35px; padding: 0; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; transition: all 0.3s;"
                                                title="Hapus Foto" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(220, 38, 38, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                                            <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    @else
                                        <div class="avatar-circle mx-auto" style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); display: flex; align-items: center; justify-content: center;">
                                            <span style="font-size: 48px; color: white; font-weight: bold;">
                                                {{ strtoupper(substr($user->nama_user, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="mb-1">{{ $user->nama_user }}</h5>
                                <p class="text-muted mb-2">
                                    @if($user->role === 'pustakawan')
                                        <span class="badge" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; font-weight: 500;">Pustakawan</span>
                                    @elseif($user->role === 'kepala')
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 500;">Kepala Sekolah</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span>
                                    @endif
                                </p>
                                <p class="mb-3"><i data-feather="mail" style="width: 14px; height: 14px;"></i> {{ $user->email }}</p>
                                <hr>
                                <small class="text-muted">
                                    <i data-feather="calendar" style="width: 12px; height: 12px;"></i> 
                                    Bergabung: {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                </small>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="card shadow-sm border-left-info">
                            <div class="card-body">
                                <h6 class="text-info"><i data-feather="info"></i> Informasi</h6>
                                <small class="text-muted">
                                    <ul class="mb-0 pl-3">
                                        <li>Anda dapat mengubah nama dan email</li>
                                        <li>Password minimal 6 karakter</li>
                                        <li>Gunakan password yang kuat</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Form Edit Profil --}}
                    <div class="col-md-8">
                        {{-- Card Data Profil --}}
                        <div class="card shadow-sm mb-4">
                            <div class="card-header py-3" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
                                <h6 class="mb-0" style="color: white; font-weight: 600;"><i data-feather="edit" style="width: 16px; height: 16px;"></i> Edit Profil</h6>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="updateProfil">
                                    {{-- Upload Foto Profil --}}
                                    <div class="form-group">
                                        <label><strong>Foto Profil</strong></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fotoProfil" wire:model="foto_profil" accept="image/*">
                                            <label class="custom-file-label" for="fotoProfil">
                                                @if($foto_profil)
                                                    {{ $foto_profil->getClientOriginalName() }}
                                                @else
                                                    Pilih foto...
                                                @endif
                                            </label>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i data-feather="info" style="width: 12px; height: 12px;"></i> 
                                            Format: JPG, PNG, JPEG. Maksimal 2MB
                                        </small>
                                        @error('foto_profil')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                        
                                        {{-- Preview Foto --}}
                                        @if($foto_profil)
                                            <div class="mt-3 text-center">
                                                <img src="{{ $foto_profil->temporaryUrl() }}" 
                                                     alt="Preview" 
                                                     class="img-thumbnail rounded-circle" 
                                                     style="width: 100px; height: 100px; object-fit: cover;">
                                                <p class="text-muted mt-2"><small>Preview foto baru</small></p>
                                            </div>
                                        @endif
                                        
                                        {{-- Loading Indicator --}}
                                        <div wire:loading wire:target="foto_profil" class="mt-2">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <small class="text-primary ml-2">Uploading foto...</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Nama Lengkap</strong> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" wire:model="nama_user" placeholder="Masukkan nama lengkap">
                                        @error('nama_user')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Email</strong> <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" wire:model="email" placeholder="email@example.com">
                                        @error('email')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Role</strong></label>
                                        <input type="text" class="form-control" value="{{ $role === 'pustakawan' ? 'Pustakawan' : 'Kepala Sekolah' }}" disabled>
                                        <small class="text-muted">Role tidak bisa diubah</small>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                            <i data-feather="save" style="width: 14px; height: 14px;"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Card Ganti Password --}}
                        <div class="card shadow-sm">
                            <div class="card-header py-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; box-shadow: 0 4px 6px rgba(217, 119, 6, 0.3);">
                                <h6 class="mb-0" style="color: white; font-weight: 600;"><i data-feather="lock" style="width: 16px; height: 16px;"></i> Keamanan Akun</h6>
                            </div>
                            <div class="card-body">
                                @if(!$showPasswordForm)
                                    <p class="mb-3">
                                        <i data-feather="shield" style="width: 16px; height: 16px;"></i> 
                                        Lindungi akun Anda dengan password yang kuat
                                    </p>
                                    <button wire:click="$toggle('showPasswordForm')" class="btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(217, 119, 6, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i data-feather="key" style="width: 14px; height: 14px;"></i> Ganti Password
                                    </button>
                                @else
                                    <form wire:submit.prevent="updatePassword">
                                        <div class="form-group">
                                            <label><strong>Password Lama</strong> <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" wire:model="current_password" placeholder="Masukkan password lama">
                                            @error('current_password')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Password Baru</strong> <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" wire:model="new_password" placeholder="Minimal 6 karakter">
                                            @error('new_password')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Konfirmasi Password Baru</strong> <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" wire:model="new_password_confirmation" placeholder="Ulangi password baru">
                                            @error('new_password_confirmation')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="button" wire:click="cancelPasswordChange" class="btn btn-secondary mr-2">
                                                <i data-feather="x" style="width: 14px; height: 14px;"></i> Batal
                                            </button>
                                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(217, 119, 6, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                                <i data-feather="check" style="width: 14px; height: 14px;"></i> Update Password
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
                    console.log('✅ Profil icons refreshed');
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

        // Update custom file input label when file selected
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fotoProfil');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || 'Pilih foto...';
                    const label = document.querySelector('label[for="fotoProfil"]');
                    if (label) {
                        label.textContent = fileName;
                    }
                });
            }
        });
    });</script>
</div>
