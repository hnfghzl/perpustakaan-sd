<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HistoryPengembalianComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterPembayaran = '';
    public $showDetail = false;
    public $detailPeminjaman = null;

    public function mount()
    {
        // Akses untuk pustakawan dan kepala (read-only untuk kepala)
        if (!in_array(Auth::user()->role, ['pustakawan', 'kepala'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPembayaran()
    {
        $this->resetPage();
    }

    public function render()
    {
        // HANYA tampilkan peminjaman yang SUDAH DIKEMBALIKAN
        $query = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->where('status_buku', 'kembali');

        // Filter berdasarkan search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('anggota', function ($q2) {
                        $q2->where('nama_anggota', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter pembayaran
        if ($this->filterPembayaran === 'belum_dibayar') {
            $query->where('status_pembayaran', 'belum_dibayar')
                  ->where('denda_total', '>', 0); // Hanya yang punya denda
        } elseif ($this->filterPembayaran === 'sudah_dibayar') {
            $query->where('status_pembayaran', 'sudah_dibayar');
        } elseif ($this->filterPembayaran === 'tanpa_denda') {
            $query->where('denda_total', 0); // Tidak ada denda sama sekali
        }

        $peminjaman = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('livewire.history-pengembalian-modern', [
            'peminjaman' => $peminjaman,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala'
        ])->layoutData(['title' => 'History Pengembalian']);
    }

    public function viewDetail($id)
    {
        $this->detailPeminjaman = Peminjaman::with([
            'anggota', 
            'user', 
            'detailPeminjaman.eksemplar.buku'
        ])->find($id);
        
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailPeminjaman = null;
    }

    public function markAsPaid($id)
    {
        if (Auth::user()->role !== 'pustakawan') {
            session()->flash('error', 'Anda tidak memiliki akses untuk aksi ini!');
            return;
        }

        try {
            $peminjaman = Peminjaman::find($id);
            
            if (!$peminjaman) {
                session()->flash('error', 'Data peminjaman tidak ditemukan!');
                return;
            }

            if ($peminjaman->denda_total == 0) {
                session()->flash('info', 'Tidak ada denda untuk transaksi ini!');
                return;
            }

            if ($peminjaman->status_pembayaran === 'sudah_dibayar') {
                session()->flash('info', 'Denda sudah dibayar sebelumnya!');
                return;
            }

            $peminjaman->status_pembayaran = 'sudah_dibayar';
            $peminjaman->save();

            Log::info('Pembayaran denda dikonfirmasi', [
                'kode_transaksi' => $peminjaman->kode_transaksi,
                'denda_total' => $peminjaman->denda_total,
                'user' => Auth::user()->nama_user
            ]);

            session()->flash('success', 'Pembayaran denda berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            Log::error('Error markAsPaid', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage());
        }
    }
}
