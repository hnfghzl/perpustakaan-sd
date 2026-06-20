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
use Illuminate\Support\Facades\Cache;
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

    public $id_peminjaman;
    public $tgl_kembali;
    public $detailItems      = [];
    public $selectedEksemplar = [];
    public $total_denda        = 0;
    public $denda_keterlambatan = 0;
    public $denda_kerusakan    = 0;

    public $tarif_denda_per_hari = 1000;
    public $tarif_denda_rusak    = 50000;
    public $tarif_denda_hilang   = 100000;

    public function mount()
    {
        if (!in_array(Auth::user()->role, ['pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }

        $this->tarif_denda_per_hari = (int) Cache::remember('pengaturan_denda_per_hari', 300, fn() => Pengaturan::get('denda_per_hari',  1000));
        $this->tarif_denda_rusak    = (int) Cache::remember('pengaturan_denda_rusak',    300, fn() => Pengaturan::get('denda_rusak',    50000));
        $this->tarif_denda_hilang   = (int) Cache::remember('pengaturan_denda_hilang',   300, fn() => Pengaturan::get('denda_hilang',  100000));

        $this->tgl_kembali = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $query = Peminjaman::with([
                'anggota:id_anggota,nama_anggota,jenis_anggota',
                'detailPeminjaman:id_detail,id_peminjaman,id_eksemplar,tgl_kembali',
            ])
            ->where('status_buku', 'dipinjam');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('anggota', fn($q2) =>
                      $q2->where('nama_anggota', 'like', '%' . $this->search . '%')
                  );
            });
        }

        if ($this->filterTerlambat === 'terlambat') {
            $query->where('tgl_jatuh_tempo', '<', Carbon::now());
        } elseif ($this->filterTerlambat === 'belum_terlambat') {
            $query->where('tgl_jatuh_tempo', '>=', Carbon::now());
        }

        $peminjaman = $query->orderBy('tgl_pinjam', 'desc')->paginate(10);

        return view('livewire.pengembalian-modern', [
            'peminjaman'   => $peminjaman,
            'isPustakawan' => Auth::user()->role === 'pustakawan',
        ])->layoutData(['title' => 'Pengembalian Buku']);
    }

    public function openReturnForm($id)
    {
        $this->selectedPeminjaman = Peminjaman::with([
                'anggota:id_anggota,nama_anggota,no_hp',
                'detailPeminjaman.eksemplar.buku:id_buku,judul',
            ])->find($id);

        if (!$this->selectedPeminjaman) {
            session()->flash('error', 'Data peminjaman tidak ditemukan!');
            return;
        }

        $this->id_peminjaman     = $id;
        $this->tgl_kembali       = Carbon::now()->format('Y-m-d');
        $this->detailItems       = [];
        $this->selectedEksemplar = [];

        foreach ($this->selectedPeminjaman->detailPeminjaman as $detail) {
            if (!$detail->tgl_kembali) {
                $this->detailItems[$detail->id_detail] = [
                    'kondisi_kembali' => 'baik',
                    'denda_item'      => 0,
                ];
                $this->selectedEksemplar[] = $detail->id_detail;
            }
        }

        $this->hitungDenda();
        $this->showReturnForm = true;
    }

    public function closeReturnForm()
    {
        $this->showReturnForm      = false;
        $this->selectedPeminjaman  = null;
        $this->detailItems         = [];
        $this->selectedEksemplar   = [];
        $this->total_denda         = 0;
        $this->denda_keterlambatan = 0;
        $this->denda_kerusakan     = 0;
        $this->dispatch('refresh-icons');
    }

    public function hitungDenda()
    {
        if (!$this->selectedPeminjaman) return;

        $this->denda_keterlambatan = 0;
        $this->denda_kerusakan     = 0;

        $tgl_tempo   = Carbon::parse($this->selectedPeminjaman->tgl_jatuh_tempo)->startOfDay();
        $tgl_kembali = Carbon::parse($this->tgl_kembali)->startOfDay();

        if ($tgl_kembali->gt($tgl_tempo)) {
            $hari = (int) $tgl_tempo->diffInDays($tgl_kembali);
            $this->denda_keterlambatan = $hari * count($this->selectedEksemplar) * $this->tarif_denda_per_hari;
        }

        foreach ($this->detailItems as $id_detail => $item) {
            if (!in_array($id_detail, $this->selectedEksemplar)) {
                $this->detailItems[$id_detail]['denda_item'] = 0;
                continue;
            }
            $denda = match ($item['kondisi_kembali']) {
                'rusak'  => $this->tarif_denda_rusak,
                'hilang' => $this->tarif_denda_hilang,
                default  => 0,
            };
            $this->detailItems[$id_detail]['denda_item'] = $denda;
            $this->denda_kerusakan += $denda;
        }

        $this->total_denda = $this->denda_keterlambatan + $this->denda_kerusakan;
    }

    public function updatedDetailItems()       { $this->hitungDenda(); }
    public function updatedTglKembali()        { $this->hitungDenda(); }
    public function updatedSelectedEksemplar() { $this->hitungDenda(); }

    public function prosesKembalikan()
    {
        $this->validate(['tgl_kembali' => 'required|date'], [
            'tgl_kembali.required' => 'Tanggal kembali harus diisi!',
        ]);

        if (empty($this->selectedEksemplar)) {
            session()->flash('error', 'Pilih minimal 1 buku yang akan dikembalikan!');
            return;
        }

        DB::beginTransaction();
        try {
            // Load semua detail sekaligus — hindari N+1
            $detailMap = DetailPeminjaman::with('eksemplar')
                ->whereIn('id_detail', $this->selectedEksemplar)
                ->get()
                ->keyBy('id_detail');

            foreach ($this->selectedEksemplar as $id_detail) {
                $detail = $detailMap[$id_detail] ?? null;
                if (!$detail) continue;

                $item = $this->detailItems[$id_detail];
                $detail->update([
                    'tgl_kembali'     => $this->tgl_kembali,
                    'kondisi_kembali' => $item['kondisi_kembali'],
                    'denda_item'      => $item['denda_item'],
                ]);

                if ($detail->eksemplar) {
                    $statusBaru = match ($item['kondisi_kembali']) {
                        'rusak'  => 'rusak',
                        'hilang' => 'hilang',
                        default  => 'tersedia',
                    };
                    $detail->eksemplar->update(['status_eksemplar' => $statusBaru]);
                }
            }

            $peminjaman = Peminjaman::with('detailPeminjaman:id_detail,id_peminjaman,tgl_kembali')
                ->find($this->id_peminjaman);

            $total   = $peminjaman->detailPeminjaman->count();
            $kembali = $peminjaman->detailPeminjaman->whereNotNull('tgl_kembali')->count();

            $peminjaman->status_buku         = ($kembali >= $total) ? 'kembali' : 'dipinjam';
            $peminjaman->denda_keterlambatan = ($peminjaman->denda_keterlambatan ?? 0) + $this->denda_keterlambatan;
            $peminjaman->denda_kerusakan     = ($peminjaman->denda_kerusakan ?? 0) + $this->denda_kerusakan;
            $peminjaman->denda_total         = $peminjaman->denda_keterlambatan + $peminjaman->denda_kerusakan;
            $peminjaman->status_pembayaran   = $peminjaman->denda_total > 0 ? 'belum_dibayar' : 'sudah_dibayar';
            $peminjaman->tgl_pembayaran      = $peminjaman->denda_total > 0 ? null : Carbon::now();
            $peminjaman->save();

            LogAktivitas::create([
                'id_user'   => Auth::id(),
                'aktivitas' => 'Pengembalian ' . count($this->selectedEksemplar) . ' buku dari ' . ($peminjaman->anggota->nama_anggota ?? ''),
                'waktu'     => Carbon::now(),
            ]);

            DB::commit();

            $anggota = $peminjaman->anggota;
            if ($anggota && $anggota->no_hp) {
                try {
                    $detailBuku = $detailMap->map(fn($d) => [
                        'judul'           => $d->eksemplar?->buku?->judul ?? '-',
                        'kode_eksemplar'  => $d->eksemplar?->kode_eksemplar ?? '-',
                        'kondisi_kembali' => $this->detailItems[$d->id_detail]['kondisi_kembali'] ?? 'baik',
                        'denda_item'      => $this->detailItems[$d->id_detail]['denda_item'] ?? 0,
                    ])->values()->toArray();

                    $notif = new \App\Notifications\PengembalianBukuNotification(
                        $peminjaman, $detailBuku,
                        $this->denda_keterlambatan, $this->denda_kerusakan,
                        $this->total_denda, $this->tgl_kembali
                    );
                    $notif->sendWhatsapp($anggota);
                } catch (\Exception $waError) {
                    Log::warning('Gagal kirim WA pengembalian', ['error' => $waError->getMessage()]);
                }
            }

            $waInfo = ($anggota && $anggota->no_hp) ? ' (WA terkirim)' : '';
            session()->flash('success',
                'Pengembalian berhasil! Denda: Rp ' . number_format($this->total_denda, 0, ',', '.') . $waInfo
            );

            $this->closeReturnForm();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal proses pengembalian', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function updatingSearch()           { $this->resetPage(); }
    public function updatingFilterTerlambat()  { $this->resetPage(); }
    public function updatingFilterPembayaran() { $this->resetPage(); }

    public function markAsPaid($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) {
            session()->flash('error', 'Data peminjaman tidak ditemukan!');
            return;
        }
        if ($peminjaman->status_pembayaran === 'sudah_dibayar') {
            session()->flash('info', 'Denda sudah ditandai lunas sebelumnya.');
            return;
        }
        $peminjaman->update([
            'status_pembayaran' => 'sudah_dibayar',
            'tgl_pembayaran'    => Carbon::now(),
        ]);
        session()->flash('success', 'Denda berhasil ditandai sudah dibayar!');
    }
}
