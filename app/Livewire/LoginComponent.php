<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email = '';
    public $password = '';

    public function render()
    {
        return view('livewire.login-component')
            ->layout('components.layouts.login');
    }

    public function proses()
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            session()->flash('info', 'Anda sudah login!');
            return redirect()->route('home');
        }

        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();

            // Ambil user yang sedang login
            $user = Auth::user();

            // Tentukan pesan sesuai role
            $roleLabel = match ($user->role) {
                'pustakawan' => 'Pustakawan',
                'kepala' => 'Kepala Sekolah',
                default => ucfirst($user->role)
            };

            session()->flash('success', "Login berhasil! Selamat datang {$user->nama_user} sebagai {$roleLabel}.");
            return redirect()->route('home');
        }

        // Alert untuk password atau email salah
        session()->flash('error', 'Email atau password yang Anda masukkan salah!');
        $this->reset('password');
    }

    public function keluar()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->reset();

        return redirect()->route('login');
    }
}
