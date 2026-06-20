<?php

namespace App\Livewire;

use App\Models\Anggota;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Carbon\Carbon;

class AnggotaComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama_anggota, $email, $no_hp, $nis, $jenis_anggota, $tgl_lahir, $anggota_sejak;
    public $tgl_registrasi, $berlaku_hingga, $institusi, $jenis_kelamin, $alamat;
    public $id_anggota;
    public $search = '';

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
    }

    public function render()
    {
        $anggota = Anggota::where(function($q) {
                $q->where('nama_anggota', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_anggota', 'like', '%' . $this->search . '%')
                  ->orWhere('institusi', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $x['title'] = 'Mengelola Anggota';

        return view('livewire.anggota-modern', [
            'anggota' => $anggota,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData($x);
    }

    public function resetInput()
    {
        $this->nama_anggota = '';
        $this->email = '';
        $this->no_hp = '';
        $this->nis = '';
        $this->jenis_anggota = '';
        $this->tgl_lahir = '';
        $this->anggota_sejak = '';
        $this->tgl_registrasi = '';
        $this->berlaku_hingga = '';
        $this->institusi = '';
        $this->jenis_kelamin = '';
        $this->alamat = '';
        $this->id_anggota = '';
    }

    /**
     * Auto-generate password dari tanggal lahir (format DDMMYYYY)
     */
    private function generatePasswordDariTglLahir(?string $tgl_lahir): ?string
    {
        if (!$tgl_lahir) return null;
        return Hash::make(Carbon::parse($tgl_lahir)->format('dmY'));
    }

    public function store()
    {
        try {
            $this->validate([
                'nama_anggota' => 'required',
                'email'        => 'required|email|unique:anggota,email',
                'nis'          => 'nullable|unique:anggota,nis',
                'jenis_anggota'=> 'required|in:guru,siswa',
                'jenis_kelamin'=> 'required|in:laki-laki,perempuan',
                'tgl_lahir'    => 'nullable|date',
                'institusi'    => 'nullable|string'
            ], [
                'nama_anggota.required' => 'Nama anggota harus diisi!',
                'email.required'        => 'Email harus diisi!',
                'email.email'           => 'Format email tidak valid!',
                'email.unique'          => 'Email sudah terdaftar!',
                'nis.unique'            => 'NIS sudah terdaftar!',
                'jenis_anggota.required'=> 'Jenis anggota harus dipilih!',
                'jenis_anggota.in'      => 'Jenis anggota tidak valid!',
                'jenis_kelamin.required'=> 'Jenis kelamin harus dipilih!',
                'jenis_kelamin.in'      => 'Jenis kelamin tidak valid!'
            ]);

            Anggota::create([
                'nama_anggota' => $this->nama_anggota,
                'email'        => $this->email,
                'no_hp'        => $this->no_hp ?: null,
                'nis'          => $this->nis ?: null,
                'jenis_anggota'=> $this->jenis_anggota,
                'tgl_lahir'    => $this->tgl_lahir ?: null,
                'anggota_sejak'=> $this->anggota_sejak ?: now(),
                'tgl_registrasi'=> $this->tgl_registrasi ?: now(),
                'berlaku_hingga'=> $this->berlaku_hingga ?: now()->addYears(5),
                'institusi'    => $this->institusi ?: 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin'=> $this->jenis_kelamin,
                'alamat'       => $this->alamat ?: null,
                'password'     => $this->generatePasswordDariTglLahir($this->tgl_lahir),
            ]);

            session()->flash('success', 'Anggota berhasil ditambahkan! Password default: tanggal lahir (DDMMYYYY).');
            $this->resetInput();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan anggota: ' . $e->getMessage());
            \Log::error('Error store anggota: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $anggota = Anggota::find($id);

        if ($anggota) {
            $this->id_anggota    = $anggota->id_anggota;
            $this->nama_anggota  = $anggota->nama_anggota;
            $this->email         = $anggota->email;
            $this->no_hp         = $anggota->no_hp;
            $this->nis           = $anggota->nis;
            $this->jenis_anggota = $anggota->jenis_anggota;
            $this->tgl_lahir     = $anggota->tgl_lahir;
            $this->anggota_sejak = $anggota->anggota_sejak;
            $this->tgl_registrasi= $anggota->tgl_registrasi;
            $this->berlaku_hingga= $anggota->berlaku_hingga;
            $this->institusi     = $anggota->institusi;
            $this->jenis_kelamin = $anggota->jenis_kelamin;
            $this->alamat        = $anggota->alamat;
        }
    }

    public function update()
    {
        $this->validate([
            'nama_anggota' => 'required',
            'email'        => 'required|email|unique:anggota,email,'.$this->id_anggota.',id_anggota',
            'nis'          => 'nullable|unique:anggota,nis,'.$this->id_anggota.',id_anggota',
            'jenis_anggota'=> 'required|in:guru,siswa',
            'jenis_kelamin'=> 'required|in:laki-laki,perempuan',
            'tgl_lahir'    => 'nullable|date',
            'institusi'    => 'nullable|string'
        ], [
            'nama_anggota.required' => 'Nama anggota harus diisi!',
            'email.required'        => 'Email harus diisi!',
            'email.email'           => 'Format email tidak valid!',
            'email.unique'          => 'Email sudah terdaftar!',
            'nis.unique'            => 'NIS sudah terdaftar!',
            'jenis_anggota.required'=> 'Jenis anggota harus dipilih!',
            'jenis_kelamin.required'=> 'Jenis kelamin harus dipilih!'
        ]);

        $anggota = Anggota::find($this->id_anggota);

        if ($anggota) {
            $updateData = [
                'nama_anggota' => $this->nama_anggota,
                'email'        => $this->email,
                'no_hp'        => $this->no_hp ?: null,
                'nis'          => $this->nis ?: null,
                'jenis_anggota'=> $this->jenis_anggota,
                'tgl_lahir'    => $this->tgl_lahir ?: null,
                'anggota_sejak'=> $this->anggota_sejak ?: null,
                'tgl_registrasi'=> $this->tgl_registrasi ?: null,
                'berlaku_hingga'=> $this->berlaku_hingga ?: null,
                'institusi'    => $this->institusi ?: null,
                'jenis_kelamin'=> $this->jenis_kelamin,
                'alamat'       => $this->alamat ?: null,
            ];

            // Update password jika tanggal lahir berubah dan password belum pernah diset
            if ($this->tgl_lahir && empty($anggota->password)) {
                $updateData['password'] = $this->generatePasswordDariTglLahir($this->tgl_lahir);
            }

            $anggota->update($updateData);

            session()->flash('success', 'Data anggota berhasil diupdate!');
            $this->resetInput();
        }
    }

    /**
     * Reset password anggota ke tanggal lahir (DDMMYYYY)
     */
    public function resetPassword($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            session()->flash('error', 'Anggota tidak ditemukan!');
            return;
        }

        if (!$anggota->tgl_lahir) {
            session()->flash('error', 'Anggota ' . $anggota->nama_anggota . ' tidak memiliki tanggal lahir. Harap isi tanggal lahir terlebih dahulu.');
            return;
        }

        $defaultPassword = Carbon::parse($anggota->tgl_lahir)->format('dmY');
        $anggota->update(['password' => Hash::make($defaultPassword)]);

        session()->flash('success', 'Password anggota ' . $anggota->nama_anggota . ' berhasil direset ke tanggal lahir (' . $defaultPassword . ').');
    }

    public function deleteNow($id)
    {
        try {
            $anggota = Anggota::find($id);

            if ($anggota) {
                $anggota->delete();
                session()->flash('success', 'Anggota berhasil dihapus!');
            } else {
                session()->flash('error', 'Anggota tidak ditemukan!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus anggota: ' . $e->getMessage());
            \Log::error('Error delete anggota: ' . $e->getMessage() . ' | ID: ' . $id);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
