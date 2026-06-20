<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Eksemplar;
use App\Models\Pengaturan;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PeminjamanComponent extends Component
{
    public $id_anggota, $tgl_pinjam, $tgl_jatuh_tempo, $id_peminjaman;
    public $selectedEksemplar = [];
    public $searchBuku = '';
    public $searchAnggota = '';
    public $selectedAnggotaData = null; // Tambah properti untuk menyimpan data anggota terpilih
    public $showAnggotaResults = false; // Tambah flag untuk kontrol tampilan hasil pencarian
    public $peminjamanAktifAnggota = 0;
    public $lastPeminjamanId = null;
    public $showStruk = false;
    public $pendingWaPeminjamanId = null;
    public $pendingKodeTransaksi = null;

    // Cache pengaturan agar tidak query ulang tiap render
    protected ?int $cachedDurasi = null;
    protected ?int $cachedMaxBuku = null;

    protected function getDurasi(): int
    {
        if ($this->cachedDurasi === null) {
            $this->cachedDurasi = (int) Cache::remember('pengaturan_durasi_peminjaman', 300, fn() =>
                Pengaturan::get('durasi_peminjaman_hari', 7)
            );
        }
        return $this->cachedDurasi;
    }

    protected function getMaxBuku(): int
    {
        if ($this->cachedMaxBuku === null) {
            $this->cachedMaxBuku = (int) Cache::remember('pengaturan_max_buku', 300, fn() =>
                Pengaturan::get('max_buku_per_peminjaman', 3)
            );
        }
        return $this->cachedMaxBuku;
    }

    public function mount()
    {
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = Carbon::now()->addDays($this->getDurasi())->format('Y-m-d');
    }

    public function render()
    {
        // Query anggota — hanya jika ada pencarian
        $anggotaList = collect();
        if ($this->searchAnggota && !$this->selectedAnggotaData) {
            $search = $this->searchAnggota;
            $anggotaList = Anggota::select('id_anggota', 'nama_anggota', 'nis', 'jenis_anggota', 'institusi')
                ->where(function($q) use ($search) {
                    $q->where('nama_anggota', 'like', '%' . $search . '%')
                      ->orWhere('nis', 'like', '%' . $search . '%')
                      ->orWhere('jenis_anggota', 'like', '%' . $search . '%')
                      ->orWhere('institusi', 'like', '%' . $search . '%');
                })
                ->orderBy('nama_anggota', 'asc')
                ->limit(10)
                ->get();
            $this->showAnggotaResults = true;
        } else {
            $this->showAnggotaResults = false;
        }

        $eksemplarList = $this->eksemplarListComputed;

        // Load struk hanya jika sedang ditampilkan
        $lastPeminjaman = null;
        if ($this->showStruk && $this->lastPeminjamanId) {
            $lastPeminjaman = Peminjaman::with([
                'anggota:id_anggota,nama_anggota,jenis_anggota,institusi,nis',
                'user:id_user,nama_user',
                'detailPeminjaman.eksemplar:id_eksemplar,kode_eksemplar,lokasi_rak,id_buku',
                'detailPeminjaman.eksemplar.buku:id_buku,judul,no_panggil',
            ])->find($this->lastPeminjamanId);
        }

        return view('livewire.peminjaman-modern', [
            'anggotaList'         => $anggotaList,
            'eksemplarList'       => $eksemplarList,
            'lastPeminjaman'      => $lastPeminjaman,
            'durasiPeminjaman'    => $this->getDurasi(),
            'maxBukuPerPeminjaman' => $this->getMaxBuku(),
        ])->layoutData(['title' => 'Transaksi Peminjaman']);
    }

    public function updatedSelectedEksemplar()
    {
        // Tidak perlu log debug di production - dihapus untuk performa
    }

    #[Computed(cache: true, seconds: 0)]
    public function eksemplarListComputed()
    {
        if (!$this->id_anggota) {
            return collect();
        }

        $query = Eksemplar::select(
                'eksemplar.id_eksemplar',
                'eksemplar.kode_eksemplar',
                'eksemplar.lokasi_rak',
                'eksemplar.id_buku'
            )
            ->join('buku', 'eksemplar.id_buku', '=', 'buku.id_buku')
            ->leftJoin('kategori', 'buku.kategori_id', '=', 'kategori.id_kategori')
            ->where('eksemplar.status_eksemplar', 'tersedia')
            ->with([
                'buku:id_buku,judul,no_panggil,kategori_id',
                'buku.kategori:id_kategori,nama',
            ]);

        if ($this->searchBuku) {
            $search = $this->searchBuku;
            $query->where(function($q) use ($search) {
                $q->where('eksemplar.kode_eksemplar', 'like', '%' . $search . '%')
                  ->orWhere('buku.judul', 'like', '%' . $search . '%')
                  ->orWhere('buku.pengarang', 'like', '%' . $search . '%')
                  ->orWhere('buku.penerbit', 'like', '%' . $search . '%')
                  ->orWhere('buku.tahun_terbit', 'like', '%' . $search . '%')
                  ->orWhere('buku.no_panggil', 'like', '%' . $search . '%')
                  ->orWhere('kategori.nama', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('eksemplar.id_eksemplar', 'desc')
            ->limit(50)
            ->get();
    }

    public function updatedIdAnggota()
    {
        if ($this->id_anggota) {
            $this->peminjamanAktifAnggota = Peminjaman::where('id_anggota', $this->id_anggota)
                ->where('status_buku', 'dipinjam')
                ->count();
        } else {
            $this->peminjamanAktifAnggota = 0;
        }
    }

    public function updatedTglPinjam()
    {
        if ($this->tgl_pinjam) {
            $this->tgl_jatuh_tempo = Carbon::parse($this->tgl_pinjam)
                ->addDays($this->getDurasi())
                ->format('Y-m-d');
        }
    }

    public function selectAnggota($id)
    {
        $this->selectedAnggotaData = Anggota::find($id);
        if ($this->selectedAnggotaData) {
            $this->id_anggota = $this->selectedAnggotaData->id_anggota;
            $this->searchAnggota = $this->selectedAnggotaData->nama_anggota;
            $this->peminjamanAktifAnggota = Peminjaman::where('id_anggota', $this->id_anggota)
                ->where('status_buku', 'dipinjam')
                ->count();
        }
        $this->showAnggotaResults = false;
        $this->dispatch('refresh-icons');
    }

    public function deselectAnggota()
    {
        $this->selectedAnggotaData = null;
        $this->id_anggota = '';
        $this->searchAnggota = '';
        $this->peminjamanAktifAnggota = 0;
        $this->showAnggotaResults = false;
        $this->dispatch('refresh-icons'); // Pastikan icon refresh
    }

    public function resetInput()
    {
        $this->id_anggota = '';
        $this->tgl_pinjam = Carbon::now()->format('Y-m-d');
        $this->tgl_jatuh_tempo = Carbon::now()->addDays($this->getDurasi())->format('Y-m-d');
        $this->selectedEksemplar = [];
        $this->id_peminjaman = '';
        $this->peminjamanAktifAnggota = 0;
        $this->searchAnggota = '';
        $this->selectedAnggotaData = null; // Reset data anggota
        $this->dispatch('refresh-icons'); // Pastikan icon refresh
    }

    public function cetakStruk($id)
    {
        $this->lastPeminjamanId = $id;
        $this->showStruk = true;
    }

    public function closeStruk()
    {
        // Kirim WA SETELAH user tutup struk (setelah print)
        if ($this->pendingWaPeminjamanId) {
            $peminjaman = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
                ->find($this->pendingWaPeminjamanId);
            
            if ($peminjaman && $peminjaman->anggota && $peminjaman->anggota->no_hp) {
                try {
                    $detailBuku = [];
                    foreach ($peminjaman->detailPeminjaman as $detail) {
                        $detailBuku[] = [
                            'judul'          => $detail->eksemplar->buku->judul,
                            'kode_eksemplar' => $detail->eksemplar->kode_eksemplar
                        ];
                    }
                    $notif = new \App\Notifications\PeminjamanBukuNotification($peminjaman, $detailBuku);
                    $notif->sendWhatsapp($peminjaman->anggota);
                    $this->dispatch('wa-sent', no_hp: $peminjaman->anggota->no_hp);
                } catch (\Exception $waError) {
                    Log::warning('Gagal kirim WA notifikasi peminjaman', ['error' => $waError->getMessage()]);
                }
            }
            $this->pendingWaPeminjamanId = null;
        }
        
        if ($this->pendingKodeTransaksi) {
            session()->flash('success', 'Peminjaman berhasil dicatat! Kode: ' . $this->pendingKodeTransaksi);
            $this->pendingKodeTransaksi = null;
        }
        
        $this->showStruk = false;
        $this->lastPeminjamanId = null;
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

    public function store($items = [])
    {
        // Terima selected eksemplar dari Alpine picker via component.call('store', selected)
        $this->selectedEksemplar = is_array($items) ? array_map('intval', $items) : [];
        $selectedEksemplar = $this->selectedEksemplar;
        $maxBuku = $this->getMaxBuku();

        // Validasi — Livewire akan handle ValidationException secara otomatis
        $this->validate([
            'id_anggota'        => 'required|exists:anggota,id_anggota',
            'tgl_pinjam'        => 'required|date',
            'tgl_jatuh_tempo'   => 'required|date|after_or_equal:tgl_pinjam',
            'selectedEksemplar' => 'required|array|min:1|max:' . $maxBuku,
        ], [
            'id_anggota.required'          => 'Anggota harus dipilih!',
            'id_anggota.exists'            => 'Anggota tidak valid!',
            'tgl_pinjam.required'          => 'Tanggal pinjam harus diisi!',
            'tgl_jatuh_tempo.required'     => 'Tanggal jatuh tempo harus diisi!',
            'tgl_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus setelah tanggal pinjam!',
            'selectedEksemplar.required'   => 'Pilih minimal 1 buku!',
            'selectedEksemplar.min'        => 'Pilih minimal 1 buku!',
            'selectedEksemplar.max'        => 'Maksimal ' . $maxBuku . ' buku per peminjaman!',
        ]);

        // Cek durasi
        $maxDurasi     = $this->getDurasi();
        $selisihHari   = Carbon::parse($this->tgl_pinjam)->diffInDays(Carbon::parse($this->tgl_jatuh_tempo));
        if ($selisihHari > $maxDurasi) {
            session()->flash('error', 'Peminjaman maksimal ' . $maxDurasi . ' hari.');
            return;
        }

        // Cek peminjaman aktif anggota
        $peminjamanAktif = Peminjaman::where('id_anggota', $this->id_anggota)
            ->where('status_buku', 'dipinjam')
            ->count();
        if ($peminjamanAktif > 0) {
            $anggota = Anggota::find($this->id_anggota);
            session()->flash('error', "Anggota {$anggota->nama_anggota} masih memiliki {$peminjamanAktif} peminjaman aktif!");
            return;
        }

        // Cek buku duplikat
        $bukuIds = Eksemplar::whereIn('id_eksemplar', $selectedEksemplar)->pluck('id_buku')->toArray();
        if (count($bukuIds) !== count(array_unique($bukuIds))) {
            session()->flash('error', 'Tidak boleh meminjam eksemplar dari buku yang sama!');
            return;
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_user'           => Auth::id(),
                'id_anggota'        => $this->id_anggota,
                'tgl_pinjam'        => $this->tgl_pinjam,
                'tgl_jatuh_tempo'   => $this->tgl_jatuh_tempo,
                'denda_total'       => 0,
                'jumlah_peminjaman' => count($selectedEksemplar),
                'status_buku'       => 'dipinjam',
                'kode_transaksi'    => $this->generateKodeTransaksi(),
            ]);

            foreach ($selectedEksemplar as $id_eksemplar) {
                DetailPeminjaman::create([
                    'id_peminjaman'  => $peminjaman->id_peminjaman,
                    'id_eksemplar'   => $id_eksemplar,
                    'tgl_kembali'    => null,
                    'kondisi_kembali'=> 'baik',
                    'denda_item'     => 0,
                ]);
                Eksemplar::where('id_eksemplar', $id_eksemplar)
                    ->update(['status_eksemplar' => 'dipinjam']);
            }

            DB::commit();

            $this->pendingWaPeminjamanId = $peminjaman->id_peminjaman;
            $this->pendingKodeTransaksi  = $peminjaman->kode_transaksi;
            $this->lastPeminjamanId      = $peminjaman->id_peminjaman;
            $this->showStruk             = true;

            $this->dispatch('close-modal');
            $this->dispatch('refresh-icons');

        } catch (\Exception $e) {
            DB::rollBack();
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
        $this->detailPeminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.eksemplar.buku'])
            ->find($id);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->detailPeminjaman = null;
        $this->dispatch('refresh-icons');
    }

    public function updatingSearch()
    {
        // PeminjamanComponent tidak pakai pagination — method ini tidak diperlukan
    }

    public function updatingFilterStatus()
    {
        // PeminjamanComponent tidak pakai pagination — method ini tidak diperlukan
    }
}
