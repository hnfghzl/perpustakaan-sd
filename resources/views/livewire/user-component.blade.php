<div>
  <div class="card">
    <div class="card-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; box-shadow: 0 4px 6px rgba(22, 160, 133, 0.3);">
      <h5 class="mb-0" style="color: white; font-weight: 600;">
        @if($isKepala)
        Kelola User
        @else
        Profil Saya
        @endif
      </h5>
    </div>

    <div class="card-body">
      @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      @endif

      @if (session()->has('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      @endif

      {{-- KEPALA: Tabel List Sederhana --}}
      @if($isKepala)
      <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-0"><i data-feather="users" style="width: 16px; height: 16px;"></i> Total {{ $user->total() }} User</h6>
        </div>
        <button class="btn btn-sm btn-success" wire:click="$toggle('showForm')">
          <i data-feather="user-plus" style="width: 14px; height: 14px;"></i> Tambah User
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead style="background-color: #f8f9fa;">
            <tr>
              <th style="width: 5%;">NO</th>
              <th style="width: 30%;">Nama</th>
              <th style="width: 30%;">Email</th>
              <th style="width: 15%;">Role</th>
              <th style="width: 20%;" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($user as $index => $data)
            @php
            $isCurrentUser = $data->id_user == $currentUserId;
            $canDelete = !$isCurrentUser;
            @endphp
            <tr>
              <td>{{ $user->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #1ABC9C, #16A085); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; margin-right: 10px;">
                    {{ strtoupper(substr($data->nama_user, 0, 1)) }}
                  </div>
                  <div>
                    {{ $data->nama_user }}
                    @if($isCurrentUser)
                    <span class="badge badge-info badge-sm ml-1">Anda</span>
                    @endif
                  </div>
                </div>
              </td>
              <td>{{ $data->email }}</td>
              <td>
                @if($data->role === 'kepala')
                <span class="badge badge-danger">
                  <i data-feather="shield" style="width: 12px; height: 12px;"></i> Kepala
                </span>
                @else
                <span class="badge badge-primary">
                  <i data-feather="book-open" style="width: 12px; height: 12px;"></i> Pustakawan
                </span>
                @endif
              </td>
              <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                  <button wire:click="edit({{ $data->id_user }})" class="btn btn-warning" data-toggle="modal" data-target="#editpage" title="Edit">
                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                  </button>
                  @if($canDelete)
                  <button wire:click="confirmDelete({{ $data->id_user }})" class="btn btn-danger" title="Hapus">
                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                  </button>
                  @else
                  <button class="btn btn-secondary" disabled title="Tidak bisa hapus akun sendiri">
                    <i data-feather="lock" style="width: 14px; height: 14px;"></i>
                  </button>
                  @endif
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-3">
        {{ $user->links() }}
      </div>

      @else
      {{-- PUSTAKAWAN: Card untuk profil sendiri --}}
      <div class="row">
        @foreach ($user as $data)
        @php
        $isCurrentUser = $data->id_user == $currentUserId;
        @endphp

        @if($isCurrentUser)
        <div class="col-md-6 mb-4">
          <div class="card h-100" style="border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s; overflow: hidden;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
            
            {{-- Card Header with Gradient --}}
            <div style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); padding: 16px 24px; position: relative;">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  {{-- Avatar Circle --}}
                  <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; margin-right: 16px; border: 3px solid rgba(255,255,255,0.3);">
                    <span style="font-size: 24px; color: white; font-weight: 700;">
                      {{ strtoupper(substr($data->nama_user, 0, 1)) }}
                    </span>
                  </div>
                  
                  <div>
                    <h6 class="mb-1" style="color: white; font-weight: 600; font-size: 18px;">
                      {{ $data->nama_user }}
                    </h6>
                    @if($isCurrentUser)
                    <span class="badge" style="background: rgba(255,255,255,0.25); color: white; font-weight: 500; padding: 4px 12px; border-radius: 20px; font-size: 11px;">
                      <i data-feather="star" style="width: 12px; height: 12px;"></i> Anda
                    </span>
                    @endif
                  </div>
                </div>
                
                {{-- Role Badge --}}
                @if($data->role === 'kepala')
                <span class="badge" style="background: rgba(239, 68, 68, 0.9); color: white; font-weight: 600; padding: 8px 16px; border-radius: 20px; font-size: 12px;">
                  <i data-feather="shield" style="width: 14px; height: 14px;"></i> Kepala
                </span>
                @elseif($data->role === 'pustakawan')
                <span class="badge" style="background: rgba(255,255,255,0.25); color: white; font-weight: 600; padding: 8px 16px; border-radius: 20px; font-size: 12px;">
                  <i data-feather="book-open" style="width: 14px; height: 14px;"></i> Pustakawan
                </span>
                @else
                <span class="badge" style="background: rgba(107, 114, 128, 0.9); color: white; font-weight: 500; padding: 8px 16px; border-radius: 20px;">
                  {{ ucfirst($data->role) }}
                </span>
                @endif
              </div>
            </div>

            {{-- Card Body --}}
            <div class="card-body" style="padding: 24px;">
              {{-- Email Info --}}
              <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                  <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                    <i data-feather="mail" style="width: 18px; height: 18px; color: #6b7280;"></i>
                  </div>
                  <div>
                    <p class="mb-0" style="font-size: 11px; color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Email</p>
                    <p class="mb-0" style="color: #374151; font-weight: 500; font-size: 14px;">{{ $data->email }}</p>
                  </div>
                </div>
              </div>

              {{-- Action Buttons --}}
              <div class="d-flex gap-2" style="gap: 8px;">
                <button wire:click="edit({{ $data->id_user }})"
                  class="btn flex-grow-1"
                  style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 10px; padding: 10px 16px; transition: all 0.3s;"
                  onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(22, 160, 133, 0.3)';"
                  onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                  data-toggle="modal" data-target="#editpage">
                  <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Ganti Password
                </button>
              </div>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      @endif
    </div>

    {{-- ==================== FORM TAMBAH (CONDITIONAL) ==================== --}}
    @if($showForm)
    <div class="card mt-3" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

          <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
            <div>
              <h5 class="mb-1" style="color: white; font-weight: 600; font-size: 20px;">
                <i data-feather="user-plus" style="width: 20px; height: 20px;"></i> Tambah User Baru
              </h5>
              <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 13px;">Tambahkan akun pustakawan atau kepala sekolah</p>
            </div>
            <button class="btn btn-light btn-sm" wire:click="$toggle('showForm')" style="border-radius: 8px;">
              <i data-feather="x" style="width: 16px; height: 16px;"></i> Tutup
            </button>
          </div>

          <div class="card-body" style="padding: 32px;">
            <form>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="user" style="width: 14px; height: 14px;"></i> Nama Lengkap
                </label>
                <input type="text" class="form-control" wire:model="nama_user" placeholder="Contoh: John Doe" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                @error('nama_user') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="mail" style="width: 14px; height: 14px;"></i> Email
                </label>
                <input type="email" class="form-control" wire:model="email" placeholder="Contoh: user@perpus.com" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                @error('email') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="lock" style="width: 14px; height: 14px;"></i> Password
                </label>
                <div class="input-group">
                  <input type="{{ $showPassword ? 'text' : 'password' }}"
                    class="form-control"
                    wire:model="password"
                    placeholder="Minimal 8 karakter"
                    style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">

                  <button type="button"
                    class="btn"
                    style="background: #f3f4f6; border: 2px solid #e5e7eb; border-left: none; border-radius: 0 10px 10px 0; padding: 12px 20px;"
                    wire:click="$toggle('showPassword')">
                    <i data-feather="{{ $showPassword ? 'eye-off' : 'eye' }}" style="width: 16px; height: 16px; color: #6b7280;"></i>
                  </button>
                </div>
                @error('password') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

              <div class="form-group">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="shield" style="width: 14px; height: 14px;"></i> Role
                </label>
                <select class="form-control" wire:model="role" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.3s; color: #374151; background-color: white; appearance: auto;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                  <option value="" style="color: #9ca3af;">-- Pilih Role --</option>
                  <option value="pustakawan" style="color: #374151;">Pustakawan</option>
                  <option value="kepala" style="color: #374151;">Kepala Sekolah</option>
                </select>
                @error('role') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

            </form>
          </div>

          <div class="card-footer d-flex justify-content-end gap-2" style="border: none; padding: 20px 32px; background: #f9fafb;">
            <button class="btn" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; font-weight: 500; border-radius: 10px; padding: 10px 24px;" wire:click="$toggle('showForm')">
              <i data-feather="x" style="width: 14px; height: 14px;"></i> Batal
            </button>
            <button wire:click="store" class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 10px; padding: 10px 24px; box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);">
              <i data-feather="check" style="width: 14px; height: 14px;"></i> Simpan
            </button>
          </div>

        </div>
    @endif

    {{-- ==================== MODAL EDIT ==================== --}}
    <div wire:ignore.self class="modal fade" id="editpage">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">

          <div class="modal-header" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); border: none; padding: 24px;">
            <div>
              <h5 class="modal-title mb-1" style="color: white; font-weight: 600; font-size: 20px;">
                <i data-feather="edit-2" style="width: 20px; height: 20px;"></i>
                @if($isPustakawan)
                Edit Profil & Ganti Password
                @else
                Edit User
                @endif
              </h5>
              <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 13px;">Perbarui informasi akun</p>
            </div>
            <button class="close text-white" data-dismiss="modal" style="opacity: 1;">&times;</button>
          </div>

          <div class="modal-body" style="padding: 32px;">
            <form>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="user" style="width: 14px; height: 14px;"></i> Nama Lengkap
                </label>
                <input type="text" class="form-control" wire:model="nama" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                @error('nama') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="mail" style="width: 14px; height: 14px;"></i> Email
                </label>
                <input type="email" class="form-control" wire:model="email" style="border-radius: 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px; transition: all 0.3s;" onfocus="this.style.borderColor='#1ABC9C'; this.style.boxShadow='0 0 0 3px rgba(26, 188, 156, 0.1)';" onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                @error('email') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>

              @if($isPustakawan)
              <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p class="mb-0" style="color: #92400e; font-size: 13px; font-weight: 500;">
                  <i data-feather="alert-triangle" style="width: 14px; height: 14px;"></i> 
                  Untuk mengubah password, masukkan password lama terlebih dahulu
                </p>
              </div>

              <div class="form-group mb-4">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="key" style="width: 14px; height: 14px;"></i> Password Lama <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <input type="{{ $showOldPassword ? 'text' : 'password' }}"
                    class="form-control"
                    wire:model="old_password"
                    placeholder="Masukkan password lama"
                    style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">

                  <button type="button"
                    class="btn"
                    style="background: #f3f4f6; border: 2px solid #e5e7eb; border-left: none; border-radius: 0 10px 10px 0; padding: 12px 20px;"
                    wire:click="$toggle('showOldPassword')">
                    <i data-feather="{{ $showOldPassword ? 'eye-off' : 'eye' }}" style="width: 16px; height: 16px; color: #6b7280;"></i>
                  </button>
                </div>
                @error('old_password') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
              </div>
              @endif

              <div class="form-group mb-3">
                <label style="font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                  <i data-feather="lock" style="width: 14px; height: 14px;"></i>
                  @if($isPustakawan)
                  Password Baru (Opsional)
                  @else
                  Password (Opsional)
                  @endif
                </label>
                <div class="input-group">
                  <input type="{{ $showPassword ? 'text' : 'password' }}"
                    class="form-control"
                    wire:model="password"
                    placeholder="Kosongkan jika tidak ingin mengubah"
                    style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; padding: 12px 16px; font-size: 14px;">

                  <button type="button"
                    class="btn"
                    style="background: #f3f4f6; border: 2px solid #e5e7eb; border-left: none; border-radius: 0 10px 10px 0; padding: 12px 20px;"
                    wire:click="$toggle('showPassword')">
                    <i data-feather="{{ $showPassword ? 'eye-off' : 'eye' }}" style="width: 16px; height: 16px; color: #6b7280;"></i>
                  </button>
                </div>
                @error('password') <small class="text-danger mt-1 d-block"><i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> {{ $message }}</small> @enderror
                @if($isPustakawan)
                <small class="text-muted mt-1 d-block" style="font-size: 12px;">
                  <i data-feather="info" style="width: 12px; height: 12px;"></i> Password baru harus berbeda dengan password lama
                </small>
                @endif
              </div>

            </form>
          </div>

          <div class="modal-footer" style="border: none; padding: 20px 32px; background: #f9fafb;">
            <button class="btn" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; font-weight: 500; border-radius: 10px; padding: 10px 24px;" data-dismiss="modal">
              <i data-feather="x" style="width: 14px; height: 14px;"></i> Batal
            </button>
            <button wire:click="update" class="btn" style="background: linear-gradient(135deg, #1ABC9C 0%, #16A085 100%); color: white; border: none; font-weight: 500; border-radius: 10px; padding: 10px 24px; box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);" data-dismiss="modal">
              <i data-feather="save" style="width: 14px; height: 14px;"></i> Update
            </button>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

{{-- ====================== SCRIPT KONFIRMASI HAPUS ====================== --}}
<script>
  document.addEventListener('livewire:confirm-delete', function(e) {
    if (confirm('Yakin ingin menghapus user ini?')) {
      Livewire.dispatch('deleteUser', {
        id: e.detail.id
      });
    }
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
        Livewire.hook('element.init', () => refreshFeatherIcons());
        Livewire.hook('element.updated', () => refreshFeatherIcons());
        Livewire.hook('morph.updated', () => refreshFeatherIcons());
        Livewire.hook('commit', () => refreshFeatherIcons());
        
        const observer = new MutationObserver(() => refreshFeatherIcons());
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>