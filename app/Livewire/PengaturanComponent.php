<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengaturanComponent extends Component
{
    public $pengaturan = [];

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['pustakawan', 'kepala'])) {
            return redirect()->route('home');
        }

        // Load semua pengaturan
        $settings = Pengaturan::all();
        foreach ($settings as $setting) {
            $this->pengaturan[$setting->key] = $setting->value;
        }
    }

    public function simpan()
    {
        // Validasi
        $this->validate([
            'pengaturan.durasi_peminjaman_hari' => 'required|integer|min:1|max:90',
            'pengaturan.denda_per_hari' => 'required|integer|min:0',
            'pengaturan.denda_rusak' => 'required|integer|min:0',
            'pengaturan.denda_hilang' => 'required|integer|min:0',
            'pengaturan.max_buku_per_peminjaman' => 'required|integer|min:1|max:10',
            'pengaturan.email_host' => 'required|string',
            'pengaturan.email_port' => 'required|integer',
            'pengaturan.email_encryption' => 'required|in:ssl,tls',
            'pengaturan.email_username' => 'required|email',
            'pengaturan.email_password' => 'required|string',
            'pengaturan.email_from_address' => 'required|email',
            'pengaturan.email_from_name' => 'required|string',
        ], [
            'pengaturan.durasi_peminjaman_hari.required' => 'Durasi peminjaman harus diisi!',
            'pengaturan.durasi_peminjaman_hari.min' => 'Durasi minimal 1 hari!',
            'pengaturan.durasi_peminjaman_hari.max' => 'Durasi maksimal 90 hari!',
            'pengaturan.denda_per_hari.required' => 'Denda per hari harus diisi!',
            'pengaturan.denda_rusak.required' => 'Denda rusak harus diisi!',
            'pengaturan.denda_hilang.required' => 'Denda hilang harus diisi!',
            'pengaturan.max_buku_per_peminjaman.required' => 'Maksimal buku harus diisi!',
            'pengaturan.max_buku_per_peminjaman.min' => 'Minimal 1 buku!',
            'pengaturan.max_buku_per_peminjaman.max' => 'Maksimal 10 buku!',
            'pengaturan.email_host.required' => 'Email host harus diisi!',
            'pengaturan.email_port.required' => 'Email port harus diisi!',
            'pengaturan.email_encryption.required' => 'Enkripsi email harus dipilih!',
            'pengaturan.email_username.required' => 'Email username harus diisi!',
            'pengaturan.email_username.email' => 'Format email tidak valid!',
            'pengaturan.email_password.required' => 'Email password harus diisi!',
            'pengaturan.email_from_address.required' => 'Email pengirim harus diisi!',
            'pengaturan.email_from_address.email' => 'Format email pengirim tidak valid!',
            'pengaturan.email_from_name.required' => 'Nama pengirim harus diisi!',
        ]);

        try {
            foreach ($this->pengaturan as $key => $value) {
                Pengaturan::set($key, $value);
            }

            // Update .env file dengan konfigurasi email baru
            $this->updateEnvFile();

            Log::info('Pengaturan diubah', ['user' => Auth::user()->nama_user, 'data' => $this->pengaturan]);
            session()->flash('success', 'Pengaturan berhasil disimpan! Email sudah dikonfigurasi ulang.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pengaturan', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    private function updateEnvFile()
    {
        $envPath = base_path('.env');
        
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            
            // Update email configuration in .env
            $updates = [
                'MAIL_HOST' => $this->pengaturan['email_host'] ?? 'smtp.gmail.com',
                'MAIL_PORT' => $this->pengaturan['email_port'] ?? '465',
                'MAIL_ENCRYPTION' => $this->pengaturan['email_encryption'] ?? 'ssl',
                'MAIL_USERNAME' => $this->pengaturan['email_username'] ?? '',
                'MAIL_PASSWORD' => $this->pengaturan['email_password'] ?? '',
                'MAIL_FROM_ADDRESS' => $this->pengaturan['email_from_address'] ?? '',
                'MAIL_FROM_NAME' => '"' . ($this->pengaturan['email_from_name'] ?? 'Perpustakaan') . '"',
            ];
            
            foreach ($updates as $key => $value) {
                // Pattern untuk mencari key di .env
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";
                
                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    // Jika key tidak ada, tambahkan di akhir
                    $envContent .= "\n{$replacement}";
                }
            }
            
            file_put_contents($envPath, $envContent);
            
            // Clear config cache agar perubahan langsung apply
            \Artisan::call('config:clear');
        }
    }

    public function render()
    {
        $data = Pengaturan::all();
        
        return view('livewire.pengaturan-component', [
            'data' => $data,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData(['title' => 'Pengaturan Sistem']);
    }
}
