<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use App\Models\Eksemplar;
use App\Models\Pengaturan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VerifikasiPengajuanComponent extends Component
{
    use WithPagination;

    public string $search        = '';
    public bool   $showDetail    = false;
    public ?int   $detailId      = null;

    // Penolakan
    public bool   $showTolakModal = false;
    public ?int   $tolakId        = null;
    public string $alasanPenolakan = '';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        if (!in_array(Auth::user()->role, ['kepala', 'pustakawan'])) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');
            return redirect()->route('home');
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // ── Detail ────────────────────────────────────────────────
    public function lihatDetail(int $id): void
    {
        $this->detailId   = $id;
        $this->showDetail = true;
    }

    public function tutupDetail(): void
    {
        $this->showDetail = false;
        $this->detailId   = null;
    }

    // ── Setujui ───────────────────────────────────────────────
    public function setujui(int $id): void
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.eksemplar')->find($id);

        if (!$peminjaman || $peminjaman->status_buku !== 'menunggu') {
            session()->flash('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
            return;
        }

        DB::beginTransaction();
        try {
            // Validasi semua eksemplar masih tersedia
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $eks = $detail->eksemplar;
                if (!$eks || $eks->status_eksemplar !== 'tersedia') {
                    DB::rollBack();
                    session()->flash('error',
                        'Eksemplar "' . ($eks->kode_eksemplar ?? '-') . '" sudah tidak tersedia. Pengajuan tidak dapat disetujui.');
                    return;
                }
            }

            $durasi        = (int) Cache::remember('pengaturan_durasi_peminjaman', 300,
                fn() => Pengaturan::get('durasi_peminjaman_hari', 7));
            $tglPinjam     = Carbon::now()->toDateString();
            $tglJatuhTempo = Carbon::now()->addDays($durasi)->toDateString();

            // Update peminjaman
            $peminjaman->update([
                'status_buku'     => 'dipinjam',
                'tgl_pinjam'      => $tglPinjam,
                'tgl_jatuh_tempo' => $tglJatuhTempo,
                'id_user'         => Auth::id(),
            ]);

            // Kunci semua eksemplar
            foreach ($peminjaman->detailPeminjaman as $detail) {
                Eksemplar::where('id_eksemplar', $detail->id_eksemplar)
                    ->update(['status_eksemplar' => 'dipinjam']);
            }

            DB::commit();

            // Kirim notifikasi WA jika anggota punya no_hp
            $this->kirimNotifikasiSetuju($peminjaman->fresh(['anggota', 'detailPeminjaman.eksemplar.buku']));

            $this->tutupDetail();
            session()->flash('success',
                'Pengajuan ' . $peminjaman->kode_transaksi . ' berhasil disetujui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyetujui pengajuan', ['error' => $e->getMessage(), 'id' => $id]);
            session()->flash('error', 'Gagal menyetujui pengajuan: ' . $e->getMessage());
        }
    }

    // ── Buka Modal Tolak ─────────────────────────────────────
    public function bukaTolak(int $id): void
    {
        $this->tolakId         = $id;
        $this->alasanPenolakan = '';
        $this->showTolakModal  = true;
    }

    public function tutupTolak(): void
    {
        $this->showTolakModal  = false;
        $this->tolakId         = null;
        $this->alasanPenolakan = '';
    }

    // ── Konfirmasi Tolak ──────────────────────────────────────
    public function konfirmasiTolak(): void
    {
        $this->validate([
            'alasanPenolakan' => 'required|min:5',
        ], [
            'alasanPenolakan.required' => 'Alasan penolakan harus diisi.',
            'alasanPenolakan.min'      => 'Alasan minimal 5 karakter.',
        ]);

        $peminjaman = Peminjaman::with('anggota', 'detailPeminjaman')->find($this->tolakId);

        if (!$peminjaman || $peminjaman->status_buku !== 'menunggu') {
            session()->flash('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
            $this->tutupTolak();
            return;
        }

        DB::beginTransaction();
        try {
            $peminjaman->update([
                'status_buku'      => 'ditolak',
                'alasan_penolakan' => $this->alasanPenolakan,
            ]);
            // Eksemplar tidak perlu diubah — tetap 'tersedia'

            DB::commit();

            $this->kirimNotifikasiTolak(
                $peminjaman->fresh(['anggota', 'detailPeminjaman.eksemplar.buku']),
                $this->alasanPenolakan
            );

            $kode = $peminjaman->kode_transaksi;
            $this->tutupTolak();
            $this->tutupDetail();
            session()->flash('success', 'Pengajuan ' . $kode . ' berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menolak pengajuan', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal menolak pengajuan: ' . $e->getMessage());
        }
    }

    // ── Notifikasi WA ────────────────────────────────────────
    private function kirimNotifikasiSetuju(Peminjaman $peminjaman): void
    {
        if (!$peminjaman->anggota || !$peminjaman->anggota->no_hp) return;
        try {
            $detailBuku = $peminjaman->detailPeminjaman->map(fn($d) => [
                'judul'          => $d->eksemplar->buku->judul,
                'kode_eksemplar' => $d->eksemplar->kode_eksemplar,
            ])->toArray();

            $notif = new \App\Notifications\PeminjamanBukuNotification($peminjaman, $detailBuku);
            $notif->sendWhatsapp($peminjaman->anggota);
        } catch (\Exception $e) {
            Log::warning('Gagal kirim WA setujui pengajuan', ['error' => $e->getMessage()]);
        }
    }

    private function kirimNotifikasiTolak(Peminjaman $peminjaman, string $alasan): void
    {
        if (!$peminjaman->anggota || !$peminjaman->anggota->no_hp) return;
        try {
            $service = new \App\Services\WhatsappService();
            $nama    = $peminjaman->anggota->nama_anggota;
            $kode    = $peminjaman->kode_transaksi;
            $pesan   = "Halo {$nama},\n\nMohon maaf, pengajuan peminjaman buku Anda dengan kode *{$kode}* telah *ditolak*.\n\n*Alasan:* {$alasan}\n\nSilakan hubungi pustakawan untuk informasi lebih lanjut.";
            $service->send($peminjaman->anggota->no_hp, $pesan);
        } catch (\Exception $e) {
            Log::warning('Gagal kirim WA tolak pengajuan', ['error' => $e->getMessage()]);
        }
    }

    // ── Render ───────────────────────────────────────────────
    public function render()
    {
        $query = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
            ->where('status_buku', 'menunggu');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('anggota', fn($s) =>
                      $s->where('nama_anggota', 'like', '%' . $this->search . '%')
                  );
            });
        }

        $pengajuan    = $query->latest()->paginate(15);
        $totalMenunggu = Peminjaman::where('status_buku', 'menunggu')->count();

        $detailPeminjaman = $this->detailId
            ? Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])->find($this->detailId)
            : null;

        return view('livewire.verifikasi-pengajuan', [
            'pengajuan'        => $pengajuan,
            'totalMenunggu'    => $totalMenunggu,
            'detailPeminjaman' => $detailPeminjaman,
            'showDetail'       => $this->showDetail,
            'showTolakModal'   => $this->showTolakModal,
            'isPustakawan'     => in_array(Auth::user()->role, ['pustakawan', 'kepala']),
        ])->layoutData(['title' => 'Verifikasi Pengajuan']);
    }
}
