<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KategoriComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nama, $deskripsi, $id_kategori;
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
        $query = Kategori::withCount('buku'); // Hitung jumlah buku per kategori

        // Filter berdasarkan search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        $kategori = $query->orderBy('nama', 'asc')->paginate(10);

        return view('livewire.kategori-modern', [
            'kategori' => $kategori,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData(['title' => 'Mengelola Kategori']);
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->id_kategori = '';
    }

    public function store()
    {
        // Validasi input
        $this->validate([
            'nama' => 'required|max:100|unique:kategori,nama',
            'deskripsi' => 'nullable|max:500'
        ], [
            'nama.required' => 'Nama kategori harus diisi!',
            'nama.max' => 'Nama kategori maksimal 100 karakter!',
            'nama.unique' => 'Nama kategori sudah ada!',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter!'
        ]);

        try {
            Kategori::create([
                'nama' => $this->nama,
                'deskripsi' => $this->deskripsi
            ]);

            session()->flash('success', 'Kategori berhasil ditambahkan!');
            
            $this->resetInput();
            
            Log::info('Kategori berhasil ditambahkan', ['nama' => $this->nama]);
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kategori', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        
        if ($kategori) {
            $this->id_kategori = $kategori->id_kategori;
            $this->nama = $kategori->nama;
            $this->deskripsi = $kategori->deskripsi;
        }
    }

    public function update()
    {
        // Validasi input
        $this->validate([
            'nama' => 'required|max:100|unique:kategori,nama,' . $this->id_kategori . ',id_kategori',
            'deskripsi' => 'nullable|max:500'
        ], [
            'nama.required' => 'Nama kategori harus diisi!',
            'nama.max' => 'Nama kategori maksimal 100 karakter!',
            'nama.unique' => 'Nama kategori sudah ada!',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter!'
        ]);

        try {
            $kategori = Kategori::find($this->id_kategori);
            
            if ($kategori) {
                $kategori->update([
                    'nama' => $this->nama,
                    'deskripsi' => $this->deskripsi
                ]);

                session()->flash('success', 'Kategori berhasil diupdate!');
                
                $this->resetInput();
                
                Log::info('Kategori berhasil diupdate', ['id' => $this->id_kategori]);
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate kategori', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal mengupdate kategori: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kategori = Kategori::withCount('buku')->find($id);
            
            if ($kategori) {
                // PROTEKSI: Cek apakah kategori masih memiliki buku
                if ($kategori->buku_count > 0) {
                    session()->flash('error', "Tidak bisa hapus kategori '{$kategori->nama}' karena masih memiliki {$kategori->buku_count} buku! Hapus atau pindahkan buku terlebih dahulu.");
                    return;
                }
                
                $kategori->delete();
                DB::commit();
                
                session()->flash('success', 'Kategori berhasil dihapus!');
                
                Log::info('Kategori berhasil dihapus', ['id' => $id]);
            } else {
                session()->flash('error', 'Kategori tidak ditemukan!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Gagal menghapus kategori', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
