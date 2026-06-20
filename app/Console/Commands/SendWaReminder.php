<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWaReminder extends Command
{
    /**
     * Nama command artisan
     */
    protected $signature = 'wa:kirim-reminder
                            {--dry-run : Lihat daftar yang akan dikirim tanpa benar-benar mengirim WA}';

    protected $description = 'Kirim notifikasi WhatsApp: reminder H-1 jatuh tempo dan overdue H+ keterlambatan';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $wa       = new WhatsappService();
        $hari_ini = Carbon::today();
        $besok    = Carbon::tomorrow();

        $this->info('🔔 Memproses notifikasi WA...');
        $this->line('Tanggal hari ini: ' . $hari_ini->format('d/m/Y'));

        // ─────────────────────────────────────────────
        // NOTIFIKASI H-1: Jatuh tempo = besok
        // ─────────────────────────────────────────────
        $reminderList = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
            ->where('status_buku', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', $besok->toDateString())
            ->whereHas('anggota', fn($q) => $q->whereNotNull('no_hp')->where('no_hp', '!=', ''))
            ->get();

        $this->info("\n📅 Reminder H-1 ({$besok->format('d/m/Y')}): ditemukan {$reminderList->count()} peminjaman");

        $kirimReminder = 0;
        foreach ($reminderList as $peminjaman) {
            $anggota = $peminjaman->anggota;

            $detailBuku = $peminjaman->detailPeminjaman
                ->filter(fn($d) => is_null($d->tgl_kembali))
                ->map(fn($d) => [
                    'judul'          => $d->eksemplar->buku->judul,
                    'kode_eksemplar' => $d->eksemplar->kode_eksemplar,
                ])->values()->toArray();

            if (empty($detailBuku)) continue;

            $this->line("  → {$anggota->nama_anggota} ({$anggota->no_hp}) — {$peminjaman->kode_transaksi}");

            if (!$isDryRun) {
                $pesan = $wa->pesanReminderJatuhTempo($peminjaman, $detailBuku);
                $berhasil = $wa->kirim($anggota->no_hp, $pesan);

                if ($berhasil) {
                    $kirimReminder++;
                    Log::info('WA reminder H-1 terkirim', [
                        'no_hp'          => $anggota->no_hp,
                        'kode_transaksi' => $peminjaman->kode_transaksi,
                    ]);
                }
            } else {
                $kirimReminder++;
            }
        }

        $this->info("  ✅ Reminder H-1 terkirim: {$kirimReminder}" . ($isDryRun ? ' (dry-run)' : ''));

        // ─────────────────────────────────────────────
        // NOTIFIKASI H+: Sudah melewati jatuh tempo
        // ─────────────────────────────────────────────
        $overdueList = Peminjaman::with(['anggota', 'detailPeminjaman.eksemplar.buku'])
            ->where('status_buku', 'dipinjam')
            ->whereDate('tgl_jatuh_tempo', '<', $hari_ini->toDateString())
            ->whereHas('anggota', fn($q) => $q->whereNotNull('no_hp')->where('no_hp', '!=', ''))
            ->get();

        $this->info("\n⚠️  Overdue H+: ditemukan {$overdueList->count()} peminjaman");

        $kirimOverdue = 0;
        foreach ($overdueList as $peminjaman) {
            $anggota       = $peminjaman->anggota;
            $hariTerlambat = (int) Carbon::parse($peminjaman->tgl_jatuh_tempo)
                ->startOfDay()
                ->diffInDays($hari_ini->startOfDay());

            $detailBuku = $peminjaman->detailPeminjaman
                ->filter(fn($d) => is_null($d->tgl_kembali))
                ->map(fn($d) => [
                    'judul'          => $d->eksemplar->buku->judul,
                    'kode_eksemplar' => $d->eksemplar->kode_eksemplar,
                ])->values()->toArray();

            if (empty($detailBuku)) continue;

            $this->line("  → {$anggota->nama_anggota} ({$anggota->no_hp}) — {$peminjaman->kode_transaksi} (+{$hariTerlambat} hari)");

            if (!$isDryRun) {
                $pesan = $wa->pesanOverdue($peminjaman, $detailBuku, $hariTerlambat);
                $berhasil = $wa->kirim($anggota->no_hp, $pesan);

                if ($berhasil) {
                    $kirimOverdue++;
                    Log::info('WA overdue terkirim', [
                        'no_hp'           => $anggota->no_hp,
                        'kode_transaksi'  => $peminjaman->kode_transaksi,
                        'hari_terlambat'  => $hariTerlambat,
                    ]);
                }
            } else {
                $kirimOverdue++;
            }
        }

        $this->info("  ✅ Overdue terkirim: {$kirimOverdue}" . ($isDryRun ? ' (dry-run)' : ''));

        $this->newLine();
        $this->info('🏁 Selesai.');

        return Command::SUCCESS;
    }
}
