<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Eksemplar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PeminjamanComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id_anggota, $tgl_pinjam, $tgl_jatuh_tempo, $id_peminjaman;
    public $selectedEksemplar = [];
    public $search = '';
    public $filterStatus = '';
    public $showForm = false;
    public $showDetail = false;
    public $detailPeminjaman;  // <-- Tambah ini

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        // Set default tanggal
        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = Carbon::now()->addDays(7)->format('Y-m-d'); // 7 hari dari sekarang
    }

    public function render()
    {
        $query = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku']);

        // Filter berdasarkan search (kode transaksi atau nama anggota)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('anggota', function ($q2) {
                        $q2->where('nama_anggota', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter berdasarkan status
        if ($this->filterStatus) {
            $query->where('status_buku', $this->filterStatus);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);

        $anggotaList = Anggota::orderBy('nama_anggota', 'asc')->get();
        $eksemplarList = Eksemplar::with('buku')
            ->where('status_eksemplar', 'tersedia')
            ->get();

        return view('livewire.peminjaman-component', [
            'peminjaman' => $peminjaman,
            'anggotaList' => $anggotaList,
            'eksemplarList' => $eksemplarList,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData(['title' => 'Mengelola Peminjaman']);
    }

    public function updatedSelectedEksemplar()
    {
        // Debug: Log setiap kali selectedEksemplar berubah
        Log::info('Selected Eksemplar Updated', [
            'selected' => $this->selectedEksemplar,
            'count' => count($this->selectedEksemplar)
        ]);
    }

    public function resetInput()
    {
        $this->id_anggota = '';
        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = Carbon::now()->addDays(7)->format('Y-m-d');
        $this->selectedEksemplar = [];
        $this->id_peminjaman = '';
    }

    public function generateKodeTransaksi()
    {
        // Format: PJM-YYYYMMDD-XXXX
        $date = date('Ymd');
        $lastPeminjaman = Peminjaman::where('kode_transaksi', 'like', 'PJM-' . $date . '%')
            ->orderBy('kode_transaksi', 'desc')
            ->first();

        if ($lastPeminjaman) {
            $lastNumber = intval(substr($lastPeminjaman->kode_transaksi, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PJM-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        // Debug: Log data yang akan disimpan
        Log::info('Store Peminjaman', [
            'id_anggota' => $this->id_anggota,
            'tgl_pinjam' => $this->tgl_pinjam,
            'tgl_jatuh_tempo' => $this->tgl_jatuh_tempo,
            'selectedEksemplar' => $this->selectedEksemplar
        ]);

        // Convert selectedEksemplar values to integers
        $selectedEksemplar = array_map('intval', $this->selectedEksemplar);

        $this->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tgl_pinjam' => 'required|date',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam',
            'selectedEksemplar' => 'required|array|min:1'
        ], [
            'id_anggota.required' => 'Anggota harus dipilih!',
            'id_anggota.exists' => 'Anggota tidak valid!',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi!',
            'tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
            'tgl_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal pinjam!',
            'selectedEksemplar.required' => 'Pilih minimal 1 buku!',
            'selectedEksemplar.min' => 'Pilih minimal 1 buku!'
        ]);

        DB::beginTransaction();
        try {
            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'id_user' => Auth::id(),
                'id_anggota' => $this->id_anggota,
                'tgl_pinjam' => $this->tgl_pinjam,
                'tgl_jatuh_tempo' => $this->tgl_jatuh_tempo,
                'denda_total' => 0,
                'jumlah_peminjaman' => count($selectedEksemplar),
                'status_buku' => 'dipinjam',
                'kode_transaksi' => $this->generateKodeTransaksi()
            ]);

            // Buat detail peminjaman dan update status eksemplar
            foreach ($selectedEksemplar as $id_eksemplar) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_eksemplar' => $id_eksemplar,
                    'tgl_kembali' => null,
                    'kondisi_kembali' => 'baik',
                    'denda_item' => 0
                ]);

                // Update status eksemplar menjadi dipinjam
                Eksemplar::where('id_eksemplar', $id_eksemplar)
                    ->update(['status_eksemplar' => 'dipinjam']);
            }

            DB::commit();
            
            Log::info('Peminjaman berhasil disimpan', [
                'kode_transaksi' => $peminjaman->kode_transaksi,
                'id_peminjaman' => $peminjaman->id_peminjaman
            ]);
            
            session()->flash('success', 'Peminjaman berhasil dicatat! Kode: ' . $peminjaman->kode_transaksi);
            $this->resetInput();
            $this->showForm = false;  // Tutup form otomatis
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Gagal menyimpan peminjaman', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Gagal mencatat peminjaman: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);

            if ($peminjaman) {
                // Kembalikan status eksemplar menjadi tersedia HANYA jika peminjaman masih aktif (dipinjam)
                if ($peminjaman->status_buku == 'dipinjam') {
                    foreach ($peminjaman->detailPeminjaman as $detail) {
                        Eksemplar::where('id_eksemplar', $detail->id_eksemplar)
                            ->update(['status_eksemplar' => 'tersedia']);
                    }
                }

                $peminjaman->delete();
                DB::commit();
                session()->flash('success', 'Peminjaman berhasil dihapus dan status eksemplar dikembalikan!');
            } else {
                session()->flash('error', 'Peminjaman tidak ditemukan!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menghapus peminjaman: ' . $e->getMessage());
        }
    }

    public function returnBook($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);

            if ($peminjaman && $peminjaman->status_buku == 'dipinjam') {
                // Update status peminjaman
                $peminjaman->status_buku = 'kembali';
                $peminjaman->save();

                // Kembalikan status eksemplar menjadi tersedia
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    // Update detail peminjaman
                    $detail->tgl_kembali = now();
                    $detail->kondisi_kembali = 'baik';
                    $detail->save();

                    // Update status eksemplar
                    Eksemplar::where('id_eksemplar', $detail->id_eksemplar)
                        ->update(['status_eksemplar' => 'tersedia']);
                }

                DB::commit();
                session()->flash('success', 'Buku berhasil dikembalikan!');
            } else {
                session()->flash('error', 'Peminjaman tidak valid atau sudah dikembalikan!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }
    public function viewDetail($id)
    {
        $this->detailPeminjaman = Peminjaman::with(["anggota", "user", "detailPeminjaman.eksemplar.buku"])->find($id);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailPeminjaman = null;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
}
