<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfilComponent extends Component
{
    use WithFileUploads;

    public $nama_user, $email, $role;
    public $foto_profil;
    public $current_password, $new_password, $new_password_confirmation;
    public $showPasswordForm = false;

    public function mount()
    {
        // Load data user yang sedang login
        $user = Auth::user();
        $this->nama_user = $user->nama_user;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function render()
    {
        return view('livewire.profil-modern', [
            'user' => Auth::user()
        ])->layoutData(['title' => 'Profil Saya']);
    }

    public function updateProfil()
    {
        // Validasi input
        $this->validate([
            'nama_user' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',id_user',
            'foto_profil' => 'nullable|image|max:2048'
        ], [
            'nama_user.required' => 'Nama harus diisi!',
            'nama_user.max' => 'Nama maksimal 255 karakter!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan oleh user lain!',
            'foto_profil.image' => 'File harus berupa gambar!',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB!'
        ]);

        try {
            $user = User::find(Auth::id());
            
            $dataUpdate = [
                'nama_user' => $this->nama_user,
                'email' => $this->email
            ];

            // Handle upload foto profil
            if ($this->foto_profil) {
                // Hapus foto lama jika ada
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }

                // Simpan foto baru
                $filename = 'profil_' . Auth::id() . '_' . time() . '.' . $this->foto_profil->extension();
                $path = $this->foto_profil->storeAs('foto_profil', $filename, 'public');
                $dataUpdate['foto_profil'] = $path;
            }
            
            $user->update($dataUpdate);

            session()->flash('success', 'Profil berhasil diupdate!');
            
            // Reset foto_profil input
            $this->foto_profil = null;
            
            Log::info('User berhasil update profil', ['id' => Auth::id()]);
        } catch (\Exception $e) {
            Log::error('Gagal update profil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal mengupdate profil: ' . $e->getMessage());
        }
    }

    public function updatePassword()
    {
        // Validasi input
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required'
        ], [
            'current_password.required' => 'Password lama harus diisi!',
            'new_password.required' => 'Password baru harus diisi!',
            'new_password.min' => 'Password baru minimal 6 karakter!',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok!',
            'new_password_confirmation.required' => 'Konfirmasi password harus diisi!'
        ]);

        try {
            $user = User::find(Auth::id());
            
            // Cek apakah password lama benar
            if (!Hash::check($this->current_password, $user->password)) {
                session()->flash('error', 'Password lama tidak sesuai!');
                return;
            }

            // Update password
            $user->update([
                'password' => Hash::make($this->new_password)
            ]);

            // Reset form password
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
            $this->showPasswordForm = false;

            session()->flash('success', 'Password berhasil diubah!');
            
            Log::info('User berhasil mengubah password', ['id' => Auth::id()]);
        } catch (\Exception $e) {
            Log::error('Gagal mengubah password', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }

    public function cancelPasswordChange()
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->showPasswordForm = false;
    }

    public function hapusFoto()
    {
        try {
            $user = User::find(Auth::id());
            
            // Hapus file foto dari storage
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Update database
            $user->update(['foto_profil' => null]);

            session()->flash('success', 'Foto profil berhasil dihapus!');
            
            Log::info('User berhasil hapus foto profil', ['id' => Auth::id()]);
        } catch (\Exception $e) {
            Log::error('Gagal hapus foto profil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal menghapus foto profil: ' . $e->getMessage());
        }
    }
}
