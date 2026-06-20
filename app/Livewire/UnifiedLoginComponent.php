<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UnifiedLoginComponent extends Component
{
    public $identifier = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function proses()
    {
        $this->validate([
            'identifier' => 'required',
            'password' => 'required|min:6',
        ], [
            'identifier.required' => 'Email, ID Anggota, atau NIS harus diisi!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal 6 karakter!',
        ]);

        // Try login sebagai User (staff/pustakawan/kepala)
        if (Auth::attempt(['email' => $this->identifier, 'password' => $this->password], $this->remember)) {
            return redirect()->intended(route('home'));
        }

        // Try login sebagai Anggota (siswa/guru) - gunakan NIS atau email
        if (Auth::guard('anggota')->attempt(['nis' => $this->identifier, 'password' => $this->password], $this->remember) ||
            Auth::guard('anggota')->attempt(['email' => $this->identifier, 'password' => $this->password], $this->remember)) {
            return redirect()->intended(route('anggota.portal'));
        }

        session()->flash('error', 'Email/ID Anggota/NIS atau Password salah!');
        $this->password = '';
    }

    public function keluar()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.unified-login')->layout('components.layouts.login');
    }
}

