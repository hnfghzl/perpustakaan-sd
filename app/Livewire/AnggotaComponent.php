<?php

namespace App\Livewire;

use App\Models\Anggota;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class AnggotaComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama_anggota, $email, $jenis_anggota, $tgl_lahir, $anggota_sejak;
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
        $anggota = Anggota::where('nama_anggota', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_anggota', 'like', '%' . $this->search . '%')
            ->orWhere('institusi', 'like', '%' . $this->search . '%')
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

    public function store()
    {
        $this->validate([
            'nama_anggota' => 'required',
            'email' => 'required|email|unique:anggota,email',
            'jenis_anggota' => 'required|in:guru,siswa',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir' => 'nullable|date',
            'institusi' => 'nullable|string'
        ], [
            'nama_anggota.required' => 'Nama anggota harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'jenis_anggota.required' => 'Jenis anggota harus dipilih!',
            'jenis_anggota.in' => 'Jenis anggota tidak valid!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid!'
        ]);

        Anggota::create([
            'nama_anggota' => $this->nama_anggota,
            'email' => $this->email,
            'jenis_anggota' => $this->jenis_anggota,
            'tgl_lahir' => $this->tgl_lahir,
            'anggota_sejak' => $this->anggota_sejak ?? now(),
            'tgl_registrasi' => $this->tgl_registrasi ?? now(),
            'berlaku_hingga' => $this->berlaku_hingga ?? now()->addYears(5),
            'institusi' => $this->institusi ?? 'SD MUHAMMADIYAH KARANGWARU',
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat
        ]);

        session()->flash('success', 'Anggota berhasil ditambahkan!');
        $this->resetInput();
    }
    public function edit($id)
    {
        $anggota = Anggota::find($id);

        if ($anggota) {
            $this->id_anggota = $anggota->id_anggota;
            $this->nama_anggota = $anggota->nama_anggota;
            $this->email = $anggota->email;
            $this->jenis_anggota = $anggota->jenis_anggota;
            $this->tgl_lahir = $anggota->tgl_lahir;
            $this->anggota_sejak = $anggota->anggota_sejak;
            $this->tgl_registrasi = $anggota->tgl_registrasi;
            $this->berlaku_hingga = $anggota->berlaku_hingga;
            $this->institusi = $anggota->institusi;
            $this->jenis_kelamin = $anggota->jenis_kelamin;
            $this->alamat = $anggota->alamat;
        }
    }

    public function update()
    {
        $this->validate([
            'nama_anggota' => 'required',
            'email' => 'required|email|unique:anggota,email,'.$this->id_anggota.',id_anggota',
            'jenis_anggota' => 'required|in:guru,siswa',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir' => 'nullable|date',
            'institusi' => 'nullable|string'
        ], [
            'nama_anggota.required' => 'Nama anggota harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'jenis_anggota.required' => 'Jenis anggota harus dipilih!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!'
        ]);

        $anggota = Anggota::find($this->id_anggota);

        if ($anggota) {
            $anggota->update([
                'nama_anggota' => $this->nama_anggota,
                'email' => $this->email,
                'jenis_anggota' => $this->jenis_anggota,
                'tgl_lahir' => $this->tgl_lahir,
                'anggota_sejak' => $this->anggota_sejak,
                'tgl_registrasi' => $this->tgl_registrasi,
                'berlaku_hingga' => $this->berlaku_hingga,
                'institusi' => $this->institusi,
                'jenis_kelamin' => $this->jenis_kelamin,
                'alamat' => $this->alamat
            ]);

            session()->flash('success', 'Anggota berhasil diupdate!');
            $this->resetInput();
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete-anggota', ['id' => $id]);
    }

    #[On('deleteAnggota')]
    public function deleteNow($id)
    {
        $anggota = Anggota::find($id);

        if ($anggota) {
            $anggota->delete();
            session()->flash('success', 'Anggota berhasil dihapus!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
