<?php

namespace App\Livewire;

use App\Models\Eksemplar;
use App\Models\Buku;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EksemplarComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id_buku, $kode_eksemplar, $lokasi_rak, $tipe_lokasi = 'perpustakaan';
    public $status_eksemplar = 'tersedia', $harga, $tgl_diterima;
    public $sumber_perolehan, $faktur, $id_eksemplar;
    public $search = '';
    public $filterBuku = '';
    public $filterStatus = '';

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        // Set default tanggal diterima ke hari ini
        $this->tgl_diterima = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $query = Eksemplar::with('buku.kategori');

        // Filter berdasarkan search (kode eksemplar atau lokasi rak)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_eksemplar', 'like', '%' . $this->search . '%')
                    ->orWhere('lokasi_rak', 'like', '%' . $this->search . '%')
                    ->orWhereHas('buku', function ($q2) {
                        $q2->where('judul', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter berdasarkan buku
        if ($this->filterBuku) {
            $query->where('id_buku', $this->filterBuku);
        }

        // Filter berdasarkan status
        if ($this->filterStatus) {
            $query->where('status_eksemplar', $this->filterStatus);
        }

        $eksemplar = $query->orderBy('created_at', 'desc')->paginate(10);
        $bukuList = Buku::orderBy('judul', 'asc')->get();

        return view('livewire.eksemplar-component', [
            'eksemplar' => $eksemplar,
            'bukuList' => $bukuList,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData(['title' => 'Mengelola Eksemplar Buku']);
    }

    public function resetInput()
    {
        $this->id_buku = '';
        $this->kode_eksemplar = '';
        $this->lokasi_rak = '';
        $this->tipe_lokasi = 'perpustakaan';
        $this->status_eksemplar = 'tersedia';
        $this->harga = '';
        $this->tgl_diterima = Carbon::now()->format('Y-m-d');
        $this->sumber_perolehan = '';
        $this->faktur = '';
        $this->id_eksemplar = '';
    }

    public function generateKodeEksemplar()
    {
        if ($this->id_buku) {
            // Cari eksemplar terakhir untuk buku ini
            $lastEksemplar = Eksemplar::where('id_buku', $this->id_buku)
                ->orderBy('kode_eksemplar', 'desc')
                ->first();

            if ($lastEksemplar) {
                // Ambil nomor urut terakhir dan tambah 1
                $parts = explode('-', $lastEksemplar->kode_eksemplar);
                $nextNumber = intval($parts[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            // Format: ID_BUKU-NOMOR (contoh: 1-001)
            $this->kode_eksemplar = $this->id_buku . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
    }

    public function store()
    {
        $this->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'kode_eksemplar' => 'required|unique:eksemplar,kode_eksemplar',
            'lokasi_rak' => 'nullable|string|max:100',
            'tipe_lokasi' => 'nullable|string|max:100',
            'status_eksemplar' => 'required|in:tersedia,hilang,rusak',
            'harga' => 'nullable|numeric|min:0',
            'tgl_diterima' => 'nullable|date',
            'sumber_perolehan' => 'nullable|in:beli,hadiah',
            'faktur' => 'nullable|string|max:100'
        ], [
            'id_buku.required' => 'Buku harus dipilih!',
            'id_buku.exists' => 'Buku tidak valid!',
            'kode_eksemplar.required' => 'Kode eksemplar harus diisi!',
            'kode_eksemplar.unique' => 'Kode eksemplar sudah digunakan!',
            'status_eksemplar.required' => 'Status eksemplar harus dipilih!',
            'status_eksemplar.in' => 'Status tidak valid! Status "Dipinjam" dikelola otomatis oleh sistem.'
        ]);

        Eksemplar::create([
            'id_buku' => $this->id_buku,
            'kode_eksemplar' => $this->kode_eksemplar,
            'lokasi_rak' => $this->lokasi_rak,
            'tipe_lokasi' => $this->tipe_lokasi,
            'status_eksemplar' => $this->status_eksemplar,
            'harga' => $this->harga,
            'tgl_diterima' => $this->tgl_diterima,
            'sumber_perolehan' => $this->sumber_perolehan,
            'faktur' => $this->faktur
        ]);

        session()->flash('success', 'Eksemplar berhasil ditambahkan!');
        $this->resetInput();
    }

    public function edit($id)
    {
        $eksemplar = Eksemplar::find($id);

        if ($eksemplar) {
            $this->id_eksemplar = $eksemplar->id_eksemplar;
            $this->id_buku = $eksemplar->id_buku;
            $this->kode_eksemplar = $eksemplar->kode_eksemplar;
            $this->lokasi_rak = $eksemplar->lokasi_rak;
            $this->tipe_lokasi = $eksemplar->tipe_lokasi;
            $this->status_eksemplar = $eksemplar->status_eksemplar;
            $this->harga = $eksemplar->harga;
            $this->tgl_diterima = $eksemplar->tgl_diterima;
            $this->sumber_perolehan = $eksemplar->sumber_perolehan;
            $this->faktur = $eksemplar->faktur;
        }
    }

    public function update()
    {
        $eksemplar = Eksemplar::find($this->id_eksemplar);

        // Cek apakah user mencoba mengubah status 'dipinjam' menjadi status lain
        if ($eksemplar && $eksemplar->status_eksemplar === 'dipinjam' && $this->status_eksemplar !== 'dipinjam') {
            session()->flash('error', 'Buku sedang dipinjam! Status tidak dapat diubah. Kembalikan buku terlebih dahulu melalui menu Peminjaman.');
            return;
        }

        $this->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'kode_eksemplar' => 'required|unique:eksemplar,kode_eksemplar,' . $this->id_eksemplar . ',id_eksemplar',
            'lokasi_rak' => 'nullable|string|max:100',
            'status_eksemplar' => 'required|in:tersedia,hilang,rusak',
            'harga' => 'nullable|numeric|min:0'
        ], [
            'status_eksemplar.in' => 'Status tidak valid! Status "Dipinjam" dikelola otomatis oleh sistem.'
        ]);

        if ($eksemplar) {
            $eksemplar->update([
                'id_buku' => $this->id_buku,
                'kode_eksemplar' => $this->kode_eksemplar,
                'lokasi_rak' => $this->lokasi_rak,
                'tipe_lokasi' => $this->tipe_lokasi,
                'status_eksemplar' => $this->status_eksemplar,
                'harga' => $this->harga,
                'tgl_diterima' => $this->tgl_diterima,
                'sumber_perolehan' => $this->sumber_perolehan,
                'faktur' => $this->faktur
            ]);

            session()->flash('success', 'Eksemplar berhasil diupdate!');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        $eksemplar = Eksemplar::find($id);

        if ($eksemplar) {
            // Cek apakah eksemplar sedang dipinjam
            if ($eksemplar->status_eksemplar === 'dipinjam') {
                session()->flash('error', 'Eksemplar sedang dipinjam dan tidak dapat dihapus! Kembalikan buku terlebih dahulu.');
                return;
            }

            $eksemplar->delete();
            session()->flash('success', 'Eksemplar berhasil dihapus!');
        } else {
            session()->flash('error', 'Eksemplar tidak ditemukan!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterBuku()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
}
