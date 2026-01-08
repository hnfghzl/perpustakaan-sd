<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Eksemplar;
use App\Models\Pengaturan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PengembalianComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterTerlambat = '';
    public $showReturnForm = false;
    public $selectedPeminjaman = null;
    
    // Data untuk proses pengembalian
    public $id_peminjaman;
    public $tgl_kembali;
    public $detailItems = []; // Array untuk kondisi setiap eksemplar
    public $selectedEksemplar = []; // Array id_detail eksemplar yang dicentang untuk dikembalikan
    public $total_denda = 0;
    public $denda_keterlambatan = 0;
    public $denda_kerusakan = 0;

    // Tarif denda (dari database pengaturan)
    public $tarif_denda_per_hari = 1000; // Default Rp 1.000 per hari
    public $tarif_denda_rusak = 50000;   // Default Rp 50.000 untuk buku rusak
    public $tarif_denda_hilang = 100000; // Default Rp 100.000 untuk buku hilang

    public function mount()
    {
        // Hanya pustakawan yang bisa proses pengembalian
        if (!in_array(Auth::user()->role, ['pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        // Load tarif denda dari database pengaturan
        $this->tarif_denda_per_hari = Pengaturan::get('denda_per_hari', 1000);
        $this->tarif_denda_rusak = Pengaturan::get('denda_rusak', 50000);
        $this->tarif_denda_hilang = Pengaturan::get('denda_hilang', 100000);

        $this->tgl_kembali = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        // HANYA tampilkan peminjaman AKTIF (dipinjam) untuk proses pengembalian
        $query = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->where('status_buku', 'dipinjam'); // History pindah ke HistoryPengembalianComponent

        // Filter berdasarkan search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('anggota', function ($q2) {
                        $q2->where('nama_anggota', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter terlambat (hanya untuk peminjaman aktif)
        if ($this->filterTerlambat === 'terlambat') {
            $query->where('tgl_jatuh_tempo', '<', Carbon::now());
        } elseif ($this->filterTerlambat === 'belum_terlambat') {
            $query->where('tgl_jatuh_tempo', '>=', Carbon::now());
        }

        $peminjaman = $query->orderBy('tgl_pinjam', 'desc')->paginate(10);

        return view('livewire.pengembalian-modern', [
            'peminjaman' => $peminjaman,
            'isPustakawan' => Auth::user()->role === 'pustakawan'
        ])->layoutData(['title' => 'Pengembalian Buku']);
    }

    public function openReturnForm($id)
    {
        Log::info('openReturnForm called', ['id' => $id]);
        
        $this->selectedPeminjaman = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
            ->find($id);
        
        if (!$this->selectedPeminjaman) {
            session()->flash('error', 'Data peminjaman tidak ditemukan!');
            return;
        }

        $this->id_peminjaman = $id;
        $this->tgl_kembali = Carbon::now()->format('Y-m-d');
        
        // Initialize detail items untuk setiap eksemplar
        $this->detailItems = [];
        $this->selectedEksemplar = [];
        foreach ($this->selectedPeminjaman->detailPeminjaman as $detail) {
            // Hanya tampilkan eksemplar yang belum dikembalikan (tgl_kembali masih null)
            if (!$detail->tgl_kembali) {
                $this->detailItems[$detail->id_detail] = [
                    'kondisi_kembali' => 'baik',
                    'denda_item' => 0
                ];
                // Default: semua eksemplar dicentang
                $this->selectedEksemplar[] = $detail->id_detail;
            }
        }

        // Hitung denda keterlambatan
        $this->hitungDenda();
        
        $this->showReturnForm = true;
    }

    public function closeReturnForm()
    {
        $this->showReturnForm = false;
        $this->selectedPeminjaman = null;
        $this->detailItems = [];
        $this->selectedEksemplar = [];
        $this->total_denda = 0;
        $this->denda_keterlambatan = 0;
        $this->denda_kerusakan = 0;
        $this->dispatch('refresh-icons');
    }

    public function hitungDenda()
    {
        if (!$this->selectedPeminjaman) {
            return;
        }

        $this->denda_keterlambatan = 0;
        $this->denda_kerusakan = 0;

        // Hitung denda keterlambatan HANYA untuk eksemplar yang dicentang
        $tgl_jatuh_tempo = Carbon::parse($this->selectedPeminjaman->tgl_jatuh_tempo)->startOfDay();
        $tgl_kembali = Carbon::parse($this->tgl_kembali)->startOfDay();
        
        if ($tgl_kembali->gt($tgl_jatuh_tempo)) {
            $hari_terlambat = (int) $tgl_jatuh_tempo->diffInDays($tgl_kembali);
            $jumlah_buku_dikembalikan = count($this->selectedEksemplar); // Hanya yang dicentang
            $this->denda_keterlambatan = $hari_terlambat * $jumlah_buku_dikembalikan * $this->tarif_denda_per_hari;
        }

        // Hitung denda kerusakan/kehilangan HANYA untuk yang dicentang
        foreach ($this->detailItems as $id_detail => $item) {
            // Skip jika tidak dicentang
            if (!in_array($id_detail, $this->selectedEksemplar)) {
                $this->detailItems[$id_detail]['denda_item'] = 0;
                continue;
            }
            
            if ($item['kondisi_kembali'] === 'rusak') {
                $this->detailItems[$id_detail]['denda_item'] = $this->tarif_denda_rusak;
                $this->denda_kerusakan += $this->tarif_denda_rusak;
            } elseif ($item['kondisi_kembali'] === 'hilang') {
                $this->detailItems[$id_detail]['denda_item'] = $this->tarif_denda_hilang;
                $this->denda_kerusakan += $this->tarif_denda_hilang;
            } else {
                $this->detailItems[$id_detail]['denda_item'] = 0;
            }
        }

        $this->total_denda = $this->denda_keterlambatan + $this->denda_kerusakan;
    }

    public function updatedDetailItems()
    {
        $this->hitungDenda();
    }

    public function updatedTglKembali()
    {
        $this->hitungDenda();
    }

    public function updatedSelectedEksemplar()
    {
        $this->hitungDenda();
    }

    public function prosesKembalikan()
    {
        // Validasi
        $this->validate([
            'tgl_kembali' => 'required|date',
        ], [
            'tgl_kembali.required' => 'Tanggal kembali harus diisi!',
            'tgl_kembali.date' => 'Format tanggal tidak valid!',
        ]);

        // Validasi: minimal 1 buku harus dicentang
        if (empty($this->selectedEksemplar)) {
            session()->flash('error', 'Pilih minimal 1 buku yang akan dikembalikan!');
            return;
        }

        DB::beginTransaction();
        try {
            Log::info('Proses Pengembalian', [
                'id_peminjaman' => $this->id_peminjaman,
                'tgl_kembali' => $this->tgl_kembali,
                'jumlah_dikembalikan' => count($this->selectedEksemplar)
            ]);

            // Update detail peminjaman HANYA untuk yang dicentang
            foreach ($this->selectedEksemplar as $id_detail) {
                $detail = DetailPeminjaman::find($id_detail);
                $item = $this->detailItems[$id_detail];
                
                if ($detail) {
                    $detail->update([
                        'tgl_kembali' => $this->tgl_kembali,
                        'kondisi_kembali' => $item['kondisi_kembali'],
                        'denda_item' => $item['denda_item']
                    ]);

                    // Update status eksemplar
                    $eksemplar = Eksemplar::find($detail->id_eksemplar);
                    if ($eksemplar) {
                        if ($item['kondisi_kembali'] === 'baik') {
                            $eksemplar->status_eksemplar = 'tersedia';
                        } elseif ($item['kondisi_kembali'] === 'rusak') {
                            $eksemplar->status_eksemplar = 'rusak';
                        } elseif ($item['kondisi_kembali'] === 'hilang') {
                            $eksemplar->status_eksemplar = 'hilang';
                        }
                        $eksemplar->save();
                    }
                }
            }

            // Cek apakah semua buku sudah dikembalikan
            $peminjaman = Peminjaman::with('detailPeminjaman')->find($this->id_peminjaman);
            $totalBuku = $peminjaman->detailPeminjaman->count();
            $bukuDikembalikan = $peminjaman->detailPeminjaman->whereNotNull('tgl_kembali')->count();
            
            // Update status peminjaman
            if ($bukuDikembalikan >= $totalBuku) {
                // Semua buku sudah dikembalikan
                $peminjaman->status_buku = 'kembali';
            } else {
                // Masih ada buku yang belum dikembalikan
                $peminjaman->status_buku = 'dipinjam';
            }
            
            // Simpan breakdown denda (akumulatif jika pengembalian bertahap)
            $peminjaman->denda_keterlambatan = ($peminjaman->denda_keterlambatan ?? 0) + $this->denda_keterlambatan;
            $peminjaman->denda_kerusakan = ($peminjaman->denda_kerusakan ?? 0) + $this->denda_kerusakan;
            $peminjaman->denda_total = $peminjaman->denda_keterlambatan + $peminjaman->denda_kerusakan;
            
            // Set status pembayaran
            if ($peminjaman->denda_total > 0) {
                $peminjaman->status_pembayaran = 'belum_dibayar';
                $peminjaman->tgl_pembayaran = null;
            } else {
                // Jika tidak ada denda, set langsung sebagai lunas
                $peminjaman->status_pembayaran = 'sudah_dibayar';
                $peminjaman->tgl_pembayaran = Carbon::now();
            }
            
            $peminjaman->save();

            DB::commit();
            
            // Catat aktivitas ke log
            $anggota = $peminjaman->anggota;
            $jumlahDikembalikan = count($this->selectedEksemplar);
            LogAktivitas::create([
                'id_user' => Auth::id(),
                'aktivitas' => 'Pengembalian buku dari ' . $anggota->nama_anggota . ' (' . $jumlahDikembalikan . ' buku)',
                'waktu' => Carbon::now()
            ]);
            
            Log::info('Pengembalian berhasil', [
                'kode' => $peminjaman->kode_transaksi,
                'total_denda' => $this->total_denda
            ]);

            // Kirim notifikasi email pengembalian jika anggota punya email
            $anggota = $peminjaman->anggota;
            if ($anggota && $anggota->email) {
                try {
                    // Ambil detail buku yang dikembalikan dengan kondisi
                    $detailBuku = [];
                    foreach ($this->detailItems as $id_detail => $item) {
                        $detail = DetailPeminjaman::with('eksemplar.buku')->find($id_detail);
                        if ($detail) {
                            $detailBuku[] = [
                                'judul' => $detail->eksemplar->buku->judul,
                                'kode_eksemplar' => $detail->eksemplar->kode_eksemplar,
                                'kondisi_kembali' => $item['kondisi_kembali'],
                                'denda_item' => $item['denda_item']
                            ];
                        }
                    }

                    // Kirim notifikasi
                    $anggota->notify(new \App\Notifications\PengembalianBukuNotification(
                        $peminjaman, 
                        $detailBuku, 
                        $this->denda_keterlambatan, 
                        $this->denda_kerusakan, 
                        $this->total_denda, 
                        $this->tgl_kembali
                    ));
                    
                    Log::info('Email notifikasi pengembalian terkirim', [
                        'email' => $anggota->email,
                        'kode_transaksi' => $peminjaman->kode_transaksi
                    ]);
                } catch (\Exception $emailError) {
                    // Jangan gagalkan transaksi jika email error
                    Log::warning('Gagal kirim email notifikasi pengembalian', [
                        'error' => $emailError->getMessage(),
                        'email' => $anggota->email
                    ]);
                }
            }

            session()->flash('success', 'Pengembalian berhasil dicatat! Total denda: Rp ' . number_format($this->total_denda, 0, ',', '.') . ($anggota && $anggota->email ? ' (Notifikasi email terkirim ke ' . $anggota->email . ')' : ''));
            
            $this->closeReturnForm();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal proses pengembalian', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTerlambat()
    {
        $this->resetPage();
    }

    public function updatingFilterPembayaran()
    {
        $this->resetPage();
    }

    public function markAsPaid($id)
    {
        try {
            $peminjaman = Peminjaman::find($id);
            
            if (!$peminjaman) {
                session()->flash('error', 'Data peminjaman tidak ditemukan!');
                return;
            }

            if ($peminjaman->status_pembayaran === 'sudah_dibayar') {
                session()->flash('info', 'Denda sudah ditandai lunas sebelumnya.');
                return;
            }

            $peminjaman->status_pembayaran = 'sudah_dibayar';
            $peminjaman->tgl_pembayaran = Carbon::now();
            $peminjaman->save();

            Log::info('Denda ditandai lunas', [
                'kode' => $peminjaman->kode_transaksi,
                'total_denda' => $peminjaman->denda_total
            ]);

            session()->flash('success', 'Denda berhasil ditandai sudah dibayar!');
            
        } catch (\Exception $e) {
            Log::error('Gagal tandai denda lunas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Gagal menandai pembayaran: ' . $e->getMessage());
        }
    }
}
