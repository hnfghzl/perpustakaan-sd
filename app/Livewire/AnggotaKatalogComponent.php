<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Eksemplar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AnggotaKatalogComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $activeTab = 'katalog';
    public $filterKategori = '';
    public $selectedEksemplar = [];
    public $showKonfirmasiModal = false;
    public $showBuktiModal = false;
    public $lastPeminjaman = null;
    public $alertPesan = '';
    public $alertTipe = '';
    protected $paginationTheme = 'bootstrap';
    
    protected $queryString = ['activeTab' => ['except' => 'katalog']];

    public function mount()
    {
        // Set activeTab dari query parameter 'tab'
        $this->activeTab = request()->get('tab', 'katalog');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleEksemplar($id_eksemplar)
    {
        if (in_array($id_eksemplar, $this->selectedEksemplar)) {
            $this->selectedEksemplar = array_diff($this->selectedEksemplar, [$id_eksemplar]);
        } else {
            if (count($this->selectedEksemplar) < 3) {
                $this->selectedEksemplar[] = $id_eksemplar;
            } else {
                $this->alertPesan = 'Maksimal 3 buku per peminjaman!';
                $this->alertTipe = 'warning';
            }
        }
    }

    public function konfirmasi()
    {
        if (empty($this->selectedEksemplar)) {
            $this->alertPesan = 'Pilih minimal 1 buku terlebih dahulu!';
            $this->alertTipe = 'warning';
            return;
        }
        $this->showKonfirmasiModal = true;
    }

    public function batalKonfirmasi()
    {
        $this->showKonfirmasiModal = false;
    }

    public function ajukanPeminjaman()
    {
        try {
            $anggota = Auth::guard('anggota')->user();
            if (!$anggota) {
                $this->alertPesan = 'Silakan login terlebih dahulu!';
                $this->alertTipe = 'error';
                return;
            }

            // Generate kode transaksi
            $date = date('Ymd');
            $last = Peminjaman::where('kode_transaksi', 'like', 'PJM-' . $date . '%')
                ->orderBy('kode_transaksi', 'desc')->first();
            $number = $last ? intval(substr($last->kode_transaksi, -4)) + 1 : 1;
            $kodeTransaksi = 'PJM-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

            // Create peminjaman dengan status menunggu verifikasi
            $peminjaman = Peminjaman::create([
                'kode_transaksi' => $kodeTransaksi,
                'id_anggota' => $anggota->id_anggota,
                'id_user' => null,
                'jumlah_peminjaman' => count($this->selectedEksemplar),
                'tgl_pinjam' => now(),
                'tgl_jatuh_tempo' => now()->addDays(7),
                'status_buku' => 'menunggu'  // Status menunggu verifikasi
            ]);

            // Create detail peminjaman
            foreach ($this->selectedEksemplar as $id_eksemplar) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_eksemplar' => $id_eksemplar
                ]);

                // TIDAK update status eksemplar dulu, tunggu disetujui pustakawan
                // Eksemplar::where('id_eksemplar', $id_eksemplar)
                //     ->update(['status_eksemplar' => 'dipinjam']);
            }

            $this->lastPeminjaman = $peminjaman;
            $this->showKonfirmasiModal = false;
            $this->showBuktiModal = true;
            $this->selectedEksemplar = [];
            $this->alertPesan = 'Pengajuan berhasil dikirim! Tunggu verifikasi dari pustakawan.';
            $this->alertTipe = 'success';
        } catch (\Exception $e) {
            $this->alertPesan = 'Gagal membuat peminjaman: ' . $e->getMessage();
            $this->alertTipe = 'error';
        }
    }

    public function tutupBukti()
    {
        $this->showBuktiModal = false;
        $this->lastPeminjaman = null;
    }

    public function render()
    {
        // Get authenticated anggota
        $anggota = Auth::guard('anggota')->user();

        // Filter buku berdasarkan kategori dan search
        $query = Buku::with('kategori');
        
        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }
        
        if ($this->filterKategori) {
            $query->where('kategori_id', $this->filterKategori);
        }
        
        $buku = $query->latest()->paginate(12);

        // Stats untuk anggota
        $totalBuku = Buku::count();
        $peminjamanAktif = $anggota ? Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status_buku', 'dipinjam')
            ->count() : 0;
        $bukuTerlambat = $anggota ? Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status_buku', 'dipinjam')
            ->where('tgl_jatuh_tempo', '<', now())
            ->count() : 0;
        
        // Pengajuan yang menunggu verifikasi
        $pengajuanMenunggu = $anggota ? Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status_buku', 'menunggu')
            ->count() : 0;

        // Riwayat Peminjaman untuk pagination di tab history
        $riwayatPeminjaman = $anggota ? Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->with('detailPeminjaman.eksemplar.buku', 'user')
            ->latest()
            ->paginate(10, ['*'], 'page_riwayat') : collect();

        // Kategori list untuk filter dropdown
        $kategoriList = Kategori::all();

        $data['anggota'] = $anggota;
        $data['buku'] = $buku;
        $data['katalogBuku'] = $buku;
        $data['kategoriList'] = $kategoriList;
        $data['selectedEksemplar'] = $this->selectedEksemplar;
        $data['showKonfirmasiModal'] = $this->showKonfirmasiModal;
        $data['showBuktiModal'] = $this->showBuktiModal;
        $data['lastPeminjaman'] = $this->lastPeminjaman;
        $data['totalBuku'] = $totalBuku;
        $data['peminjamanAktif'] = $peminjamanAktif;
        $data['bukuTerlambat'] = $bukuTerlambat;
        $data['pengajuanMenunggu'] = $pengajuanMenunggu;
        $data['riwayatPeminjaman'] = $riwayatPeminjaman;
        $data['activeTab'] = $this->activeTab;
        $data['alertPesan'] = $this->alertPesan;
        $data['alertTipe'] = $this->alertTipe;
        $data['title'] = 'Katalog Buku';

        return view('livewire.anggota-katalog', $data)
            ->layout('components.layouts.anggota')
            ->layoutData($data);
    }
}
