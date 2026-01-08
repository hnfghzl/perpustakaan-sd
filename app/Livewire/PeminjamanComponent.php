<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Eksemplar;
use App\Models\Pengaturan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PeminjamanComponent extends Component
{
    public $id_anggota, $tgl_pinjam, $tgl_jatuh_tempo, $id_peminjaman;
    public $selectedEksemplar = [];
    public $searchBuku = ''; // Search untuk memilih buku
    public $searchAnggota = ''; // Search untuk memilih anggota
    public $peminjamanAktifAnggota = 0;
    public $lastPeminjamanId = null; // ID peminjaman terakhir untuk cetak struk
    public $showStruk = false; // Toggle modal struk
    public $pendingEmailPeminjamanId = null; // ID peminjaman yang menunggu email setelah struk ditutup

    public function mount()
    {
        // Hanya pustakawan dan kepala yang bisa akses
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        // Set default tanggal pinjam saja, jatuh tempo diisi manual oleh user
        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = ''; // Kosongkan, user input manual
    }

    public function render()
    {
        // HANYA untuk input peminjaman baru - history pindah ke HistoryPeminjamanComponent
        $anggotaQuery = Anggota::orderBy('nama_anggota', 'asc');
        
        // Filter anggota berdasarkan search
        if ($this->searchAnggota) {
            $anggotaQuery->where(function($q) {
                $q->where('nama_anggota', 'like', '%' . $this->searchAnggota . '%')
                  ->orWhere('jenis_anggota', 'like', '%' . $this->searchAnggota . '%')
                  ->orWhere('institusi', 'like', '%' . $this->searchAnggota . '%');
            });
        }
        
        $anggotaList = $anggotaQuery->get();
        
        // Query eksemplar dengan search
        $eksemplarQuery = Eksemplar::with('buku.kategori')
            ->where('status_eksemplar', 'tersedia');
        
        // Filter berdasarkan search buku
        if ($this->searchBuku) {
            $eksemplarQuery->where(function($q) {
                $q->where('kode_eksemplar', 'like', '%' . $this->searchBuku . '%')
                  ->orWhereHas('buku', function($q2) {
                      $q2->where('judul', 'like', '%' . $this->searchBuku . '%')
                         ->orWhere('no_panggil', 'like', '%' . $this->searchBuku . '%');
                  })
                  ->orWhereHas('buku.kategori', function($q3) {
                      $q3->where('nama', 'like', '%' . $this->searchBuku . '%');
                  });
            });
        }
        
        $eksemplarList = $eksemplarQuery->orderBy('kode_eksemplar', 'asc')->get();

        // Load data peminjaman terakhir untuk struk
        $lastPeminjaman = null;
        if ($this->lastPeminjamanId) {
            $lastPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
                ->find($this->lastPeminjamanId);
        }

        // Ambil durasi dan max buku dari pengaturan
        $durasiPeminjaman = Pengaturan::get('durasi_peminjaman_hari', 7);
        $maxBukuPerPeminjaman = Pengaturan::get('max_buku_per_peminjaman', 3);

        return view('livewire.peminjaman-modern', [
            'anggotaList' => $anggotaList,
            'eksemplarList' => $eksemplarList,
            'lastPeminjaman' => $lastPeminjaman,
            'durasiPeminjaman' => $durasiPeminjaman,
            'maxBukuPerPeminjaman' => $maxBukuPerPeminjaman
        ])->layoutData(['title' => 'Transaksi Peminjaman']);
    }

    public function updatedSelectedEksemplar()
    {
        // Debug: Log setiap kali selectedEksemplar berubah
        Log::info('Selected Eksemplar Updated', [
            'selected' => $this->selectedEksemplar,
            'count' => count($this->selectedEksemplar)
        ]);
    }

    public function updatedIdAnggota()
    {
        // Cek peminjaman aktif saat anggota dipilih
        if ($this->id_anggota) {
            $this->peminjamanAktifAnggota = Peminjaman::where('id_anggota', $this->id_anggota)
                ->where('status_buku', 'dipinjam')
                ->count();
        } else {
            $this->peminjamanAktifAnggota = 0;
        }
    }

    public function resetInput()
    {
        $this->id_anggota = '';
        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = ''; // Kosongkan, user input manual
        $this->selectedEksemplar = [];
        $this->id_peminjaman = '';
        $this->peminjamanAktifAnggota = 0;
        $this->searchAnggota = '';
        // JANGAN reset lastPeminjamanId dan showStruk agar modal struk tetap tampil
    }

    public function cetakStruk($id)
    {
        $this->lastPeminjamanId = $id;
        $this->showStruk = true;
    }

    public function closeStruk()
    {
        Log::info('closeStruk() dipanggil', [
            'pendingEmailPeminjamanId' => $this->pendingEmailPeminjamanId
        ]);
        
        // Kirim email SETELAH user tutup struk (setelah print)
        if ($this->pendingEmailPeminjamanId) {
            $peminjaman = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
                ->find($this->pendingEmailPeminjamanId);
            
            if ($peminjaman && $peminjaman->anggota && $peminjaman->anggota->email) {
                try {
                    // Ambil detail buku yang dipinjam
                    $detailBuku = [];
                    foreach ($peminjaman->detailPeminjaman as $detail) {
                        $detailBuku[] = [
                            'judul' => $detail->eksemplar->buku->judul,
                            'kode_eksemplar' => $detail->eksemplar->kode_eksemplar
                        ];
                    }

                    // Kirim notifikasi email
                    $peminjaman->anggota->notify(new \App\Notifications\PeminjamanBukuNotification($peminjaman, $detailBuku));
                    
                    Log::info('Email notifikasi peminjaman terkirim setelah print struk', [
                        'email' => $peminjaman->anggota->email,
                        'kode_transaksi' => $peminjaman->kode_transaksi
                    ]);
                    
                    // Dispatch event untuk menampilkan alert sukses
                    $this->dispatch('email-sent', email: $peminjaman->anggota->email);
                    
                } catch (\Exception $emailError) {
                    Log::warning('Gagal kirim email notifikasi', [
                        'error' => $emailError->getMessage(),
                        'email' => $peminjaman->anggota->email
                    ]);
                    
                    // Dispatch event untuk menampilkan alert error
                    $this->dispatch('email-failed', error: 'Gagal mengirim email');
                }
            }
            
            // Reset pending email ID
            $this->pendingEmailPeminjamanId = null;
        }
        
        $this->showStruk = false;
        $this->lastPeminjamanId = null;
        
        // Reset input form setelah user tutup struk
        $this->resetInput();
        $this->searchBuku = '';
        $this->searchAnggota = '';
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

        // Ambil max buku dari pengaturan
        $maxBuku = Pengaturan::get('max_buku_per_peminjaman', 3);

        $this->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tgl_pinjam' => 'required|date',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjam',
            'selectedEksemplar' => 'required|array|min:1|max:' . $maxBuku
        ], [
            'id_anggota.required' => 'Anggota harus dipilih!',
            'id_anggota.exists' => 'Anggota tidak valid!',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi!',
            'tgl_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi!',
            'tgl_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal pinjam!',
            'selectedEksemplar.required' => 'Pilih minimal 1 buku!',
            'selectedEksemplar.min' => 'Pilih minimal 1 buku!',
            'selectedEksemplar.max' => 'Maksimal hanya boleh meminjam ' . $maxBuku . ' buku!'
        ]);

        // VALIDASI 0: Cek durasi maksimal peminjaman (dari pengaturan database)
        $maxDurasi = Pengaturan::get('durasi_peminjaman_hari', 7);
        $tglPinjam = Carbon::parse($this->tgl_pinjam);
        $tglJatuhTempo = Carbon::parse($this->tgl_jatuh_tempo);
        $selisihHari = $tglPinjam->diffInDays($tglJatuhTempo);

        if ($selisihHari > $maxDurasi) {
            session()->flash('error', 'Peminjaman hanya diperbolehkan maksimal ' . $maxDurasi . ' hari. Tanggal jatuh tempo yang Anda pilih melampaui batas tersebut.');
            return;
        }

        // VALIDASI 1: Cek apakah anggota masih memiliki peminjaman aktif
        $peminjamanAktif = Peminjaman::where('id_anggota', $this->id_anggota)
            ->where('status_buku', 'dipinjam')
            ->count();

        if ($peminjamanAktif > 0) {
            $anggota = Anggota::find($this->id_anggota);
            session()->flash('error', "Anggota {$anggota->nama_anggota} masih memiliki {$peminjamanAktif} peminjaman aktif yang belum dikembalikan! Kembalikan buku terlebih dahulu di menu Pengembalian sebelum melakukan peminjaman baru.");
            return;
        }

        // VALIDASI 2: Cek apakah ada buku yang sama (id_buku duplikat)
        $eksemplarData = Eksemplar::whereIn('id_eksemplar', $selectedEksemplar)->get();
        $bukuIds = $eksemplarData->pluck('id_buku')->toArray();
        
        if (count($bukuIds) !== count(array_unique($bukuIds))) {
            session()->flash('error', 'Tidak boleh meminjam eksemplar dari buku yang sama! Pilih buku yang berbeda.');
            return;
        }

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

            // Simpan ID peminjaman untuk kirim email SETELAH user tutup struk
            $this->pendingEmailPeminjamanId = $peminjaman->id_peminjaman;

            // Tutup modal Bootstrap dulu
            $this->dispatch('close-modal');
            
            // Set ID peminjaman dan tampilkan struk LANGSUNG
            $this->lastPeminjamanId = $peminjaman->id_peminjaman;
            $this->showStruk = true;
            
            // Dispatch event untuk refresh icons
            $this->dispatch('refresh-icons');
            
            // Flash message success
            session()->flash('success', 'Peminjaman berhasil dicatat! Kode: ' . $peminjaman->kode_transaksi);
            
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
                // PROTEKSI: Tidak boleh hapus peminjaman yang masih aktif (status_buku = 'dipinjam')
                if ($peminjaman->status_buku == 'dipinjam') {
                    session()->flash('error', 'Tidak bisa hapus peminjaman yang masih aktif! Lakukan pengembalian terlebih dahulu di menu Pengembalian.');
                    return;
                }

                // Hanya bisa hapus peminjaman dengan status 'kembali' (sudah dikembalikan)
                $peminjaman->delete();
                DB::commit();
                session()->flash('success', 'Peminjaman berhasil dihapus!');
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
        Log::info('viewDetail called', ['id' => $id]);
        
        $this->detailPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->find($id);
        
        Log::info('Detail loaded', [
            'found' => $this->detailPeminjaman ? 'yes' : 'no',
            'kode' => $this->detailPeminjaman->kode_transaksi ?? 'null'
        ]);
        
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailPeminjaman = null;
        
        // Dispatch event to refresh feather icons
        $this->dispatch('refresh-icons');
        $this->dispatch('modal-closed'); // Event tambahan
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
