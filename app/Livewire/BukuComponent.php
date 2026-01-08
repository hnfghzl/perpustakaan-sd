<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Eksemplar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BukuComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properties untuk Buku
    public $judul, $no_panggil, $kategori_id, $id_buku;
    public $search = '';
    
    // Properties untuk Eksemplar (saat tambah buku baru)
    public $jumlah_eksemplar = 1;
    public $lokasi_rak = '';
    public $harga = '';
    public $tgl_diterima;
    public $sumber_perolehan = '';
    public $faktur = '';
    
    // Properties untuk Edit Eksemplar Individual
    public $id_eksemplar, $kode_eksemplar, $tipe_lokasi = 'perpustakaan';
    public $status_eksemplar = 'tersedia';
    public $filterStatus = '';
    
    // View mode
    public $showEksemplar = false;
    public $selectedBukuId = null;
    public $showFormEksemplar = false;

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
        
        // Set default tanggal diterima
        $this->tgl_diterima = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        if ($this->showEksemplar && $this->selectedBukuId) {
            // Tampilkan eksemplar dari buku terpilih
            $query = Eksemplar::with('buku.kategori')
                ->where('id_buku', $this->selectedBukuId);

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('kode_eksemplar', 'like', '%' . $this->search . '%')
                        ->orWhere('lokasi_rak', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->filterStatus) {
                $query->where('status_eksemplar', $this->filterStatus);
            }

            $eksemplar = $query->orderBy('kode_eksemplar', 'asc')->paginate(10);
            $selectedBuku = Buku::with('kategori')->find($this->selectedBukuId);

            return view('livewire.buku-modern', [
                'eksemplar' => $eksemplar,
                'selectedBuku' => $selectedBuku,
                'kategori' => Kategori::orderBy('nama', 'asc')->get(),
                'isPustakawan' => Auth::user()->role === 'pustakawan',
                'isKepala' => Auth::user()->role === 'kepala',
                'showFormEksemplar' => $this->showFormEksemplar
            ])->layoutData(['title' => 'Mengelola Eksemplar Buku']);
        } else {
            // Tampilkan list buku
            $buku = Buku::with(['kategori', 'eksemplar'])
                ->where('judul', 'like', '%' . $this->search . '%')
                ->orWhere('no_panggil', 'like', '%' . $this->search . '%')
                ->orWhereHas('kategori', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $kategori = Kategori::orderBy('nama', 'asc')->get();

            return view('livewire.buku-modern', [
                'buku' => $buku,
                'kategori' => $kategori,
                'isPustakawan' => Auth::user()->role === 'pustakawan',
                'isKepala' => Auth::user()->role === 'kepala'
            ])->layoutData(['title' => 'Mengelola Buku & Eksemplar']);
        }
    }
    
    public function viewEksemplar($bukuId)
    {
        $this->selectedBukuId = $bukuId;
        $this->showEksemplar = true;
        $this->search = '';
        $this->filterStatus = '';
        $this->resetPage();
    }
    
    public function backToBuku()
    {
        $this->showEksemplar = false;
        $this->selectedBukuId = null;
        $this->search = '';
        $this->resetPage();
    }

    public function generateNoPanggil($kategori_id)
    {
        // Mapping kategori ke kode DDC (Dewey Decimal Classification)
        $ddcMap = [
            1 => '800',  // Fiksi
            2 => '000',  // Non-Fiksi
            3 => '000',  // Referensi
            4 => '500',  // Sains
            5 => '200',  // Agama
            6 => '900',  // Sejarah
            7 => '300',  // Sosial
            8 => '600',  // Teknologi
            9 => '400',  // Bahasa
            10 => '700', // Seni
        ];

        // Get kode DDC, default 000 jika kategori tidak ada di map
        $kode_ddc = $ddcMap[$kategori_id] ?? '000';

        // Hitung jumlah buku dengan kategori yang sama
        $count = Buku::where('kategori_id', $kategori_id)->count() + 1;

        // Format: {DDC}.{urutan} → Contoh: 800.001, 500.012
        return $kode_ddc . '.' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function resetInput()
    {
        $this->judul = '';
        $this->no_panggil = '';
        $this->kategori_id = '';
        $this->id_buku = '';
        $this->jumlah_eksemplar = 1;
        $this->lokasi_rak = '';
        $this->harga = '';
        $this->tgl_diterima = Carbon::now()->format('Y-m-d');
        $this->sumber_perolehan = '';
        $this->faktur = '';
    }
    
    public function resetInputEksemplar()
    {
        $this->id_eksemplar = '';
        $this->kode_eksemplar = '';
        $this->lokasi_rak = '';
        $this->tipe_lokasi = 'perpustakaan';
        $this->status_eksemplar = 'tersedia';
        $this->harga = '';
        $this->tgl_diterima = Carbon::now()->format('Y-m-d');
        $this->sumber_perolehan = '';
        $this->faktur = '';
        $this->showFormEksemplar = false;
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'jumlah_eksemplar' => 'required|integer|min:1|max:50',
            'harga' => 'nullable|numeric|min:0',
            'tgl_diterima' => 'nullable|date'
        ], [
            'judul.required' => 'Judul buku harus diisi!',
            'judul.max' => 'Judul buku maksimal 255 karakter!',
            'kategori_id.required' => 'Kategori harus dipilih!',
            'kategori_id.exists' => 'Kategori tidak valid!',
            'jumlah_eksemplar.required' => 'Jumlah eksemplar harus diisi!',
            'jumlah_eksemplar.min' => 'Minimal 1 eksemplar!',
            'jumlah_eksemplar.max' => 'Maksimal 50 eksemplar sekaligus!',
            'harga.numeric' => 'Harga harus berupa angka!',
            'tgl_diterima.date' => 'Format tanggal tidak valid!'
        ]);

        // 1. Auto-generate No Panggil
        $no_panggil = $this->generateNoPanggil($this->kategori_id);

        // 2. Simpan Buku
        $buku = Buku::create([
            'judul' => $this->judul,
            'no_panggil' => $no_panggil,
            'kategori_id' => $this->kategori_id
        ]);

        // 2. Auto-generate Eksemplar sejumlah yang diminta
        for ($i = 1; $i <= $this->jumlah_eksemplar; $i++) {
            Eksemplar::create([
                'id_buku' => $buku->id_buku,
                'kode_eksemplar' => $buku->id_buku . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'lokasi_rak' => $this->lokasi_rak,
                'tipe_lokasi' => 'perpustakaan',
                'status_eksemplar' => 'tersedia',
                'harga' => $this->harga,
                'tgl_diterima' => $this->tgl_diterima ?: Carbon::now()->format('Y-m-d'),
                'sumber_perolehan' => $this->sumber_perolehan,
                'faktur' => $this->faktur
            ]);
        }

        session()->flash('success', "Buku berhasil ditambahkan dengan {$this->jumlah_eksemplar} eksemplar!");
        $this->resetInput();
    }

    public function edit($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            $this->id_buku = $buku->id_buku;
            $this->judul = $buku->judul;
            $this->no_panggil = $buku->no_panggil;
            $this->kategori_id = $buku->kategori_id;
        }
    }

    public function update()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'no_panggil' => 'nullable|string|max:100',
            'kategori_id' => 'required|exists:kategori,id_kategori'
        ], [
            'judul.required' => 'Judul buku harus diisi!',
            'kategori_id.required' => 'Kategori harus dipilih!'
        ]);

        $buku = Buku::find($this->id_buku);

        if ($buku) {
            $buku->update([
                'judul' => $this->judul,
                'no_panggil' => $this->no_panggil,
                'kategori_id' => $this->kategori_id
            ]);

            session()->flash('success', 'Buku berhasil diupdate!');
            $this->resetInput();
        }
    }

    public function delete($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            $buku->delete();
            session()->flash('success', 'Buku berhasil dihapus!');
        } else {
            session()->flash('error', 'Buku tidak ditemukan!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    // ========== EKSEMPLAR METHODS ==========
    
    public function generateKodeEksemplar()
    {
        if ($this->selectedBukuId) {
            $lastEksemplar = Eksemplar::where('id_buku', $this->selectedBukuId)
                ->orderBy('kode_eksemplar', 'desc')
                ->first();

            if ($lastEksemplar) {
                $lastNumber = (int) substr($lastEksemplar->kode_eksemplar, strrpos($lastEksemplar->kode_eksemplar, '-') + 1);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $this->kode_eksemplar = $this->selectedBukuId . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }
    }
    
    public function storeEksemplar()
    {
        $this->validate([
            'kode_eksemplar' => 'required|unique:eksemplar,kode_eksemplar',
            'lokasi_rak' => 'nullable|string|max:100',
            'status_eksemplar' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'harga' => 'nullable|numeric|min:0',
            'tgl_diterima' => 'nullable|date'
        ], [
            'kode_eksemplar.required' => 'Kode eksemplar harus diisi!',
            'kode_eksemplar.unique' => 'Kode eksemplar sudah digunakan!',
            'status_eksemplar.required' => 'Status harus dipilih!',
            'harga.numeric' => 'Harga harus berupa angka!',
            'tgl_diterima.date' => 'Format tanggal tidak valid!'
        ]);

        Eksemplar::create([
            'id_buku' => $this->selectedBukuId,
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
        $this->resetInputEksemplar();
        $this->generateKodeEksemplar();
    }
    
    public function editEksemplar($id)
    {
        $eksemplar = Eksemplar::find($id);

        if ($eksemplar) {
            $this->id_eksemplar = $eksemplar->id_eksemplar;
            $this->kode_eksemplar = $eksemplar->kode_eksemplar;
            $this->lokasi_rak = $eksemplar->lokasi_rak;
            $this->tipe_lokasi = $eksemplar->tipe_lokasi;
            $this->status_eksemplar = $eksemplar->status_eksemplar;
            $this->harga = $eksemplar->harga;
            $this->tgl_diterima = $eksemplar->tgl_diterima;
            $this->sumber_perolehan = $eksemplar->sumber_perolehan;
            $this->faktur = $eksemplar->faktur;
            $this->showFormEksemplar = true;
        }
    }
    
    public function updateEksemplar()
    {
        $this->validate([
            'kode_eksemplar' => 'required|unique:eksemplar,kode_eksemplar,' . $this->id_eksemplar . ',id_eksemplar',
            'lokasi_rak' => 'nullable|string|max:100',
            'status_eksemplar' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'harga' => 'nullable|numeric|min:0',
            'tgl_diterima' => 'nullable|date'
        ]);

        $eksemplar = Eksemplar::find($this->id_eksemplar);

        if ($eksemplar) {
            // Proteksi: jangan biarkan ubah status dari dipinjam ke lain kecuali melalui pengembalian
            if ($eksemplar->status_eksemplar === 'dipinjam' && $this->status_eksemplar !== 'dipinjam') {
                session()->flash('error', 'Eksemplar sedang dipinjam! Kembalikan dulu via menu Pengembalian.');
                return;
            }

            $eksemplar->update([
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
            $this->resetInputEksemplar();
        }
    }
    
    public function deleteEksemplar($id)
    {
        $eksemplar = Eksemplar::find($id);

        if ($eksemplar) {
            // Proteksi: jangan hapus eksemplar yang sedang dipinjam
            if ($eksemplar->status_eksemplar === 'dipinjam') {
                session()->flash('error', 'Tidak bisa menghapus eksemplar yang sedang dipinjam!');
                return;
            }

            $eksemplar->delete();
            session()->flash('success', 'Eksemplar berhasil dihapus!');
        }
    }
}
