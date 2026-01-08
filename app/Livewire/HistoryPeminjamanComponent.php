<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HistoryPeminjamanComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterStatus = '';
    public $filterTglDari = '';
    public $filterTglSampai = '';
    public $showDetail = false;
    public $detailPeminjaman = null;
    public $showStruk = false;
    public $lastPeminjamanId = null;

    public function mount()
    {
        // Akses untuk pustakawan dan kepala
        if (!in_array(Auth::user()->role, ['pustakawan', 'kepala'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
    }

    public function exportExcel()
    {
        $search = request('search', '');
        $filterStatus = request('filterStatus', '');
        $filterTglDari = request('filterTglDari', '');
        $filterTglSampai = request('filterTglSampai', '');
        
        $query = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku']);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                  ->orWhereHas('anggota', function($q2) use ($search) {
                      $q2->where('nama_anggota', 'like', '%' . $search . '%');
                  });
            });
        }
        
        if ($filterStatus) {
            $query->where('status_buku', $filterStatus);
        }
        
        if ($filterTglDari) {
            $query->whereDate('tgl_pinjam', '>=', $filterTglDari);
        }
        
        if ($filterTglSampai) {
            $query->whereDate('tgl_pinjam', '<=', $filterTglSampai);
        }
        
        $data = $query->orderBy('tgl_pinjam', 'desc')->get();
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // BOM untuk UTF-8 agar Excel bisa baca karakter Indonesia
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, [
                'No',
                'Kode Transaksi',
                'Nama Anggota',
                'Jenis Anggota',
                'Tgl Pinjam',
                'Tgl Jatuh Tempo',
                'Jumlah Buku',
                'Status',
                'Petugas',
                'Buku Dipinjam'
            ], ';');
            
            // Data
            $no = 1;
            foreach ($data as $item) {
                $bukuList = $item->detailPeminjaman->map(function($detail) {
                    return $detail->eksemplar->buku->judul . ' (' . $detail->eksemplar->kode_eksemplar . ')';
                })->implode(', ');
                
                fputcsv($file, [
                    $no++,
                    $item->kode_transaksi,
                    $item->anggota->nama_anggota,
                    ucfirst($item->anggota->jenis_anggota),
                    "'" . Carbon::parse($item->tgl_pinjam)->format('d-m-Y'),
                    "'" . Carbon::parse($item->tgl_jatuh_tempo)->format('d-m-Y'),
                    $item->jumlah_peminjaman,
                    $item->status_buku === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan',
                    $item->user->nama_user,
                    $bukuList
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'History_Peminjaman_' . date('Ymd_His') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterTglDari()
    {
        $this->resetPage();
    }

    public function updatingFilterTglSampai()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Tampilkan SEMUA transaksi peminjaman (aktif & selesai)
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
        if ($this->filterStatus === 'dipinjam') {
            $query->where('status_buku', 'dipinjam');
        } elseif ($this->filterStatus === 'kembali') {
            $query->where('status_buku', 'kembali');
        }

        // Filter berdasarkan tanggal
        if ($this->filterTglDari) {
            $query->whereDate('tgl_pinjam', '>=', $this->filterTglDari);
        }

        if ($this->filterTglSampai) {
            $query->whereDate('tgl_pinjam', '<=', $this->filterTglSampai);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(15);

        // Load data peminjaman terakhir untuk struk
        $lastPeminjaman = null;
        if ($this->lastPeminjamanId) {
            $lastPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
                ->find($this->lastPeminjamanId);
        }

        return view('livewire.history-peminjaman-modern', [
            'peminjaman' => $peminjaman,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
            'isKepala' => Auth::user()->role === 'kepala',
            'lastPeminjaman' => $lastPeminjaman
        ])->layoutData(['title' => 'History Peminjaman']);
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

    public function cetakStruk($id)
    {
        $this->lastPeminjamanId = $id;
        $this->showStruk = true;
    }

    public function closeStruk()
    {
        $this->showStruk = false;
        $this->lastPeminjamanId = null;
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'pustakawan') {
            session()->flash('error', 'Anda tidak memiliki akses untuk menghapus data!');
            return;
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);

            if ($peminjaman) {
                // PROTEKSI: Block deletion for active loans
                if ($peminjaman->status_buku == 'dipinjam') {
                    session()->flash('error', 'Tidak bisa hapus peminjaman yang masih aktif! Lakukan pengembalian terlebih dahulu di menu Pengembalian.');
                    return;
                }

                // Delete detail peminjaman dulu
                $peminjaman->detailPeminjaman()->delete();
                
                // Delete peminjaman
                $peminjaman->delete();

                DB::commit();

                Log::info('Peminjaman dihapus', [
                    'kode_transaksi' => $peminjaman->kode_transaksi,
                    'user' => Auth::user()->nama_user
                ]);

                session()->flash('success', 'Data peminjaman berhasil dihapus!');
            } else {
                session()->flash('error', 'Data peminjaman tidak ditemukan!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error destroy peminjaman', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
