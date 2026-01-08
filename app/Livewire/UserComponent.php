<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class UserComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama_user, $email, $password, $role, $id_user, $old_password;
    public $showPassword = false;
    public $showOldPassword = false;
    public $showForm = false;

    public function mount()
    {
        // Redirect jika bukan kepala atau pustakawan
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
    }

    public function render()
    {
        $data = [
            'user' => User::paginate(10),
            'isKepala' => Auth::user()->role === 'kepala',
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'currentUserId' => Auth::id(),
            'updateData' => !empty($this->id_user)
        ];

        return view('livewire.user-modern', $data);
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        
        // Reset form saat buka
        if ($this->showForm) {
            $this->resetInput();
        }
    }

    public function resetInput()
    {
        $this->nama_user = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->old_password = '';
        $this->id_user = '';
        $this->showPassword = false;
        $this->showForm = false;
        $this->showOldPassword = false;
    }

    public function store()
    {
        // Hanya kepala yang bisa tambah user
        if (Auth::user()->role !== 'kepala') {
            session()->flash('error', 'Anda tidak memiliki izin untuk menambah user!');
            return;
        }

        $this->validate([
            'nama_user' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:kepala,pustakawan'
        ], [
            'nama_user.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'role.required' => 'Role harus dipilih!',
            'role.in' => 'Role tidak valid!'
        ]);

        User::create([
            'nama_user'       => $this->nama_user,
            'email'           => $this->email,
            'password'        => Hash::make($this->password),
            'role'            => $this->role,
            'tgl_registrasi'  => now(),
            'bergabung_sejak' => now(),
            'berlaku_hingga'  => now()->addYears(5),
        ]);

        session()->flash('success', 'Berhasil menambah user baru!');
        $this->resetInput();
    }

    public function edit($id)
    {
        $user = User::find($id);

        // Pustakawan hanya bisa edit dirinya sendiri
        if (Auth::user()->role === 'pustakawan' && Auth::id() !== $user->id_user) {
            session()->flash('error', 'Anda hanya bisa mengedit akun Anda sendiri!');
            return;
        }

        $this->id_user = $user->id_user ?? $user->id;
        $this->nama_user = $user->nama_user;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->old_password = '';
        $this->showPassword = false;
        $this->showOldPassword = false;
        $this->showForm = true;
    }

    public function update()
    {
        $user = User::find($this->id_user);

        // Pustakawan hanya bisa edit dirinya sendiri
        if (Auth::user()->role === 'pustakawan' && Auth::id() !== $user->id_user) {
            session()->flash('error', 'Anda hanya bisa mengedit akun Anda sendiri!');
            return;
        }

        $rules = [
            'nama_user' => 'required',
            'email' => 'required|email'
        ];

        $messages = [
            'nama_user.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!'
        ];

        // Jika password diisi, validasi
        if (!empty($this->password)) {
            $rules['password'] = 'min:6';
            $messages['password.min'] = 'Password minimal 6 karakter!';
        }

        $this->validate($rules, $messages);

        // Jika pustakawan ganti password, harus input password lama
        if (Auth::user()->role === 'pustakawan' && $this->password != "") {
            $this->validate([
                'old_password' => 'required',
                'password' => 'min:6|different:old_password'
            ], [
                'old_password.required' => 'Password lama harus diisi!',
                'password.min' => 'Password baru minimal 6 karakter!',
                'password.different' => 'Password baru harus berbeda dengan password lama!'
            ]);

            // Verifikasi password lama
            if (!Hash::check($this->old_password, $user->password)) {
                session()->flash('error', 'Password lama tidak sesuai!');
                return;
            }
        }

        if ($this->password == "") {
            $user->update([
                'nama_user' => $this->nama_user,
                'email'     => $this->email
            ]);
        } else {
            $this->validate(['password' => 'min:6']);

            $user->update([
                'nama_user' => $this->nama_user,
                'email'     => $this->email,
                'password'  => Hash::make($this->password)
            ]);
        }

        session()->flash('success', 'Berhasil update profil!');
        $this->resetInput();
    }

    //---------------------------------------------
    //  KONFIRMASI HAPUS - LIVEWIRE V3
    //---------------------------------------------
    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', ['id' => $id]);
    }

    #[On('deleteUser')]
    public function deleteNow($id)
    {
        // Hanya kepala yang bisa hapus user
        if (Auth::user()->role !== 'kepala') {
            session()->flash('error', 'Anda tidak memiliki izin untuk menghapus user!');
            return;
        }

        $user = User::find($id);

        if ($user) {
            // Tidak bisa hapus diri sendiri
            if ($user->id_user === Auth::id()) {
                session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
                return;
            }

            $user->delete();
            session()->flash('success', 'User berhasil dihapus!');
        }
    }
}
