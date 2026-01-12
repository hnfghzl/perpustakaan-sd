<style>
    .user-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .user-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
    }
    .btn-modern {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<div style="background: transparent;" x-data="{ formOpen: @entangle('showForm') }">
    {{-- Header --}}
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 32px; border-radius: 16px; box-shadow: 0 10px 40px rgba(59, 130, 246, 0.2); margin-bottom: 24px;">
        <h1 style="font-size: 32px; font-weight: 800; color: white; margin-bottom: 8px; display: flex; align-items: center; gap: 12px;">
            <i data-feather="users" style="width: 36px; height: 36px;"></i>
            @if($isKepala)
            Kelola User
            @else
            Profil Saya
            @endif
        </h1>
        <p style="font-size: 16px; color: rgba(255,255,255,0.9); margin: 0;">
            @if($isKepala)
            Manajemen user dan role perpustakaan
            @else
            Informasi akun dan pengaturan profil
            @endif
        </p>
    </div>

    {{-- Alerts --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #10b981;">
        <i data-feather="check-circle" style="width: 18px; height: 18px;"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border-left: 4px solid #ef4444;">
        <i data-feather="alert-circle" style="width: 18px; height: 18px;"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if($isKepala)
    {{-- KEPALA SEKOLAH VIEW: Table List --}}
    <div class="user-card">
        {{-- Action Bar --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 style="font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 4px;">
                    <i data-feather="list" style="width: 22px; height: 22px; color: #3b82f6;"></i> Daftar User
                </h3>
                <p style="color: #6b7280; font-size: 14px; margin: 0;">Total {{ $user->total() }} pengguna terdaftar</p>
            </div>
            <button 
                @click="formOpen = !formOpen; $wire.call('toggleForm')"
                class="btn btn-modern" 
                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; cursor: pointer;">
                <i data-feather="user-plus" style="width: 18px; height: 18px;"></i> Tambah User
            </button>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <th style="border: none; padding: 16px; font-weight: 600; color: #374151; width: 5%;">No</th>
                        <th style="border: none; padding: 16px; font-weight: 600; color: #374151; width: 35%;">Nama</th>
                        <th style="border: none; padding: 16px; font-weight: 600; color: #374151; width: 30%;">Email</th>
                        <th style="border: none; padding: 16px; font-weight: 600; color: #374151; width: 15%;">Role</th>
                        <th style="border: none; padding: 16px; font-weight: 600; color: #374151; text-align: center; width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user as $index => $data)
                    @php
                    $isCurrentUser = $data->id_user == $currentUserId;
                    $canDelete = !$isCurrentUser;
                    @endphp
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 16px; vertical-align: middle;">{{ $user->firstItem() + $index }}</td>
                        <td style="padding: 16px; vertical-align: middle;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    {{ strtoupper(substr($data->nama_user, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #111827; font-size: 15px;">{{ $data->nama_user }}</div>
                                    @if($isCurrentUser)
                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; background: #dbeafe; color: #3b82f6;">
                                        <i data-feather="star" style="width: 10px; height: 10px;"></i> Anda
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px; vertical-align: middle; color: #6b7280;">{{ $data->email }}</td>
                        <td style="padding: 16px; vertical-align: middle;">
                            @if($data->role === 'kepala')
                            <span style="display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #fee2e2; color: #ef4444;">
                                <i data-feather="shield" style="width: 12px; height: 12px;"></i> Kepala
                            </span>
                            @else
                            <span style="display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #dbeafe; color: #3b82f6;">
                                <i data-feather="book-open" style="width: 12px; height: 12px;"></i> Pustakawan
                            </span>
                            @endif
                        </td>
                        <td style="padding: 16px; vertical-align: middle; text-align: center;">
                            <div class="d-flex justify-content-center gap-2" style="gap: 8px;">
                                <button wire:click="edit({{ $data->id_user }})" 
                                    class="btn btn-sm" 
                                    style="background: #f3f4f6; color: #374151; border: none; border-radius: 8px; padding: 8px 12px; font-weight: 500; transition: all 0.2s;"
                                    onmouseover="this.style.background='#e5e7eb'; this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.background='#f3f4f6'; this.style.transform='translateY(0)'"
                                    title="Edit">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                </button>
                                @if($canDelete)
                                <button wire:click="confirmDelete({{ $data->id_user }})" 
                                    class="btn btn-sm" 
                                    style="background: #f3f4f6; color: #374151; border: none; border-radius: 8px; padding: 8px 12px; font-weight: 500; transition: all 0.2s;"
                                    onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'; this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.background='#f3f4f6'; this.style.color='#374151'; this.style.transform='translateY(0)'"
                                    title="Hapus">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                                @else
                                <button 
                                    class="btn btn-sm" 
                                    style="background: #f9fafb; color: #9ca3af; border: none; border-radius: 8px; padding: 8px 12px; cursor: not-allowed;"
                                    disabled 
                                    title="Tidak bisa hapus akun sendiri">
                                    <i data-feather="lock" style="width: 14px; height: 14px;"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #9ca3af;">
                            <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 12px;"></i>
                            <p style="margin: 0;">Belum ada data user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $user->links() }}
        </div>
    </div>

    {{-- Modal Popup untuk Tambah/Edit --}}
    <div x-show="formOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 9999;"
         @click.self="formOpen = false; $wire.call('toggleForm')"
         x-init="$watch('formOpen', value => { if(value) setTimeout(() => feather.replace(), 100) })">
        
        <div x-show="formOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             style="background: white; border-radius: 16px; max-width: 480px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
             @click.stop>
            
            {{-- Modal Header --}}
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 16px 16px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 20px; font-weight: 600; color: white; margin: 0;">
                    <i data-feather="user-plus" style="width: 22px; height: 22px;"></i> 
                    {{ $updateData ? 'Edit User' : 'Tambah User Baru' }}
                </h3>
                <button type="button" @click="formOpen = false; $wire.call('toggleForm')" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i data-feather="x" style="width: 20px; height: 20px;"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div style="padding: 32px;">
                <form wire:submit.prevent="{{ $updateData ? 'update' : 'store' }}">
                    
                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                            <i data-feather="user" style="width: 14px; height: 14px;"></i> Nama Lengkap *
                        </label>
                        <input type="text" wire:model="nama_user" class="form-control" placeholder="Masukkan nama lengkap" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">
                        @error('nama_user') <small class="text-danger d-block mt-1"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                            <i data-feather="mail" style="width: 14px; height: 14px;"></i> Email *
                        </label>
                        <input type="email" wire:model="email" class="form-control" placeholder="contoh@perpus.com" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">
                        @error('email') <small class="text-danger d-block mt-1"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                            <i data-feather="lock" style="width: 14px; height: 14px;"></i> Password {{ $updateData ? '' : '*' }}
                        </label>
                        <input type="password" wire:model="password" class="form-control" placeholder="{{ $updateData ? 'Kosongkan jika tidak diubah' : 'Minimal 6 karakter' }}" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">
                        @error('password') <small class="text-danger d-block mt-1"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label style="color: #374151; font-weight: 600; font-size: 14px; margin-bottom: 8px; display: block;">
                            <i data-feather="shield" style="width: 14px; height: 14px;"></i> Role *
                        </label>
                        <select wire:model="role" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">
                            <option value="">Pilih Role</option>
                            <option value="kepala">Kepala Sekolah</option>
                            <option value="pustakawan">Pustakawan</option>
                        </select>
                        @error('role') <small class="text-danger d-block mt-1"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2 mt-4 pt-3" style="gap: 12px; border-top: 1px solid #e5e7eb;">
                        <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; flex: 1; padding: 12px 24px; font-size: 15px;">
                            <i data-feather="check" style="width: 18px; height: 18px;"></i> {{ $updateData ? 'Update' : 'Simpan' }}
                        </button>
                        <button type="button" @click="formOpen = false; $wire.call('toggleForm')" class="btn btn-modern" style="background: #f3f4f6; color: #6b7280; padding: 12px 24px; font-size: 15px;">
                            <i data-feather="x" style="width: 18px; height: 18px;"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @else
    {{-- PUSTAKAWAN VIEW: Profile Card --}}
    <div class="row">
        @foreach ($user as $data)
        @php $isCurrentUser = $data->id_user == $currentUserId; @endphp

        @if($isCurrentUser)
        <div class="col-md-6 mx-auto">
            <div class="user-card">
                {{-- Profile Header --}}
                <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 12px; margin-bottom: 20px;">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle" style="width: 72px; height: 72px; font-size: 28px; background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.3); margin-right: 16px;">
                            {{ strtoupper(substr($data->nama_user, 0, 1)) }}
                        </div>
                        <div>
                            <h3 style="color: white; font-weight: 700; font-size: 24px; margin-bottom: 4px;">{{ $data->nama_user }}</h3>
                            @if($data->role === 'pustakawan')
                            <span style="display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(255,255,255,0.2); color: white;">
                                <i data-feather="book-open" style="width: 12px; height: 12px;"></i> Pustakawan
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Profile Info --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center" style="padding: 16px; background: #f9fafb; border-radius: 12px;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <i data-feather="mail" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Email</p>
                            <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $data->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <button wire:click="edit({{ $data->id_user }})" class="btn btn-modern btn-block" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                    <i data-feather="edit-2" style="width: 18px; height: 18px;"></i> Ganti Password
                </button>
            </div>
        </div>

        {{-- Edit Form --}}
        @if($showForm && $updateData)
        <div class="col-md-6 mx-auto mt-4">
            <div class="user-card">
                <h3 style="font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 20px;">
                    <i data-feather="lock" style="width: 22px; height: 22px; color: #3b82f6;"></i> Ganti Password
                </h3>

                <form wire:submit.prevent="update">
                    <div class="mb-3">
                        <label style="color: #6b7280; font-weight: 600; font-size: 13px; margin-bottom: 8px;">Password Baru *</label>
                        <input type="password" wire:model="password" class="form-control" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px;" placeholder="Minimal 6 karakter">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex gap-2" style="gap: 12px;">
                        <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                            <i data-feather="save" style="width: 18px; height: 18px;"></i> Update Password
                        </button>
                        <button type="button" wire:click="resetInput" class="btn btn-modern" style="background: #f3f4f6; color: #6b7280;">
                            <i data-feather="x" style="width: 18px; height: 18px;"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        @endif
        @endforeach
    </div>
    @endif
</div>

{{-- ====================== SCRIPT KONFIRMASI HAPUS ====================== --}}
<script>
    // Event listener untuk konfirmasi delete
    document.addEventListener('livewire:initialized', () => {
        // Listen to confirm-delete event
        Livewire.on('confirm-delete', (data) => {
            if (confirm('⚠️ Yakin ingin menghapus user ini?\n\nData yang dihapus tidak dapat dikembalikan!')) {
                Livewire.dispatch('deleteUser', { id: data[0].id });
            }
        });
    });
</script>

{{-- Feather Icons Refresh Pattern --}}
@assets
<script>
    window.refreshFeatherIcons = function() {
        if (typeof feather !== 'undefined') {
            setTimeout(() => {
                feather.replace();
            }, 150);
        }
    }
</script>
@endassets

<script data-navigate-once>
    document.addEventListener('livewire:initialized', () => {
        refreshFeatherIcons();
        
        // Livewire hooks for icon refresh
        Livewire.hook('element.init', () => refreshFeatherIcons());
        Livewire.hook('element.updated', () => refreshFeatherIcons());
        Livewire.hook('morph.updated', () => refreshFeatherIcons());
        Livewire.hook('commit', () => refreshFeatherIcons());
        
        // MutationObserver as backup
        const observer = new MutationObserver(() => refreshFeatherIcons());
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>

