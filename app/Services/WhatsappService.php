<?php

namespace App\Services;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected string $token;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = Pengaturan::get('fonnte_token', '');
    }

    /**
     * Format nomor HP ke format internasional (628xxx)
     * Mendukung: 08xxx, 8xxx, 628xxx, +628xxx
     */
    private function formatNomor(string $no_hp): string
    {
        // Hapus semua karakter selain angka
        $nomor = preg_replace('/[^0-9]/', '', $no_hp);

        // Jika sudah diawali 62, langsung pakai
        if (str_starts_with($nomor, '62')) {
            return $nomor;
        }

        // Jika diawali 0, ganti dengan 62
        if (str_starts_with($nomor, '0')) {
            return '62' . substr($nomor, 1);
        }

        // Jika diawali 8 (kurang kode negara), tambahkan 62
        if (str_starts_with($nomor, '8')) {
            return '62' . $nomor;
        }

        return $nomor;
    }

    /**
     * Kirim pesan WA via Fonnte
     */
    public function kirim(string $no_hp, string $pesan): bool
    {
        if (empty($this->token)) {
            Log::warning('WhatsApp: Token Fonnte belum dikonfigurasi di Pengaturan.');
            return false;
        }

        if (empty($no_hp)) {
            Log::warning('WhatsApp: Nomor HP anggota kosong, pesan tidak dikirim.');
            return false;
        }

        $nomorFormatted = $this->formatNomor($no_hp);

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => $this->token,
                ])->post($this->apiUrl, [
                    'target'      => $nomorFormatted,
                    'message'     => $pesan,
                    'countryCode' => '62',
                ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                Log::info('WhatsApp terkirim ke ' . $nomorFormatted);
                return true;
            } else {
                Log::error('WhatsApp gagal terkirim: ' . json_encode($result));
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Buat pesan notifikasi peminjaman
     */
    public function pesanPeminjaman($peminjaman, array $detailBuku): string
    {
        $tglPinjam    = \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y');
        $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y');

        $daftarBuku = '';
        foreach ($detailBuku as $i => $detail) {
            $daftarBuku .= ($i + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ")\n";
        }

        return "📚 *NOTIFIKASI PEMINJAMAN BUKU*\n"
            . "Perpustakaan SD Muhammadiyah Karangwaru\n"
            . "─────────────────────\n"
            . "Kode Transaksi : *{$peminjaman->kode_transaksi}*\n"
            . "Tanggal Pinjam : {$tglPinjam}\n"
            . "Jatuh Tempo    : *{$tglJatuhTempo}*\n"
            . "Jumlah Buku    : " . count($detailBuku) . " eksemplar\n"
            . "─────────────────────\n"
            . "*Daftar Buku:*\n"
            . $daftarBuku
            . "─────────────────────\n"
            . "⚠️ *Harap kembalikan sebelum tanggal jatuh tempo!*\n"
            . "Denda keterlambatan: Rp 1.000/hari/buku\n\n"
            . "_Terima kasih_ 🙏";
    }

    /**
     * Kartu Pinjaman — bukti untuk diserahkan ke pustakawan saat mengambil buku
     */
    public function pesanKartuPinjaman($peminjaman, $anggota, array $detailBuku): string
    {
        $tglPinjam     = \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y');
        $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d M Y');

        $daftarBuku = '';
        foreach ($detailBuku as $i => $detail) {
            $daftarBuku .= "   " . ($i + 1) . ". " . $detail['judul'] . "\n"
                         . "      Kode: " . $detail['kode_eksemplar'] . "\n";
        }

        $infoAnggota = "👤 *{$anggota->nama_anggota}*\n";
        if (!empty($anggota->nis)) {
            $infoAnggota .= "   NIS   : {$anggota->nis}\n";
        }
        $infoAnggota .= "   ID    : {$anggota->id_anggota}\n";

        return "╔══════════════════════╗\n"
            . "║  📋 *KARTU PINJAMAN BUKU*  ║\n"
            . "╚══════════════════════╝\n"
            . "_Perpustakaan SD Muhammadiyah Karangwaru_\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . $infoAnggota
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "🔑 Kode  : *{$peminjaman->kode_transaksi}*\n"
            . "📅 Pinjam: {$tglPinjam}\n"
            . "⏰ Tempo : *{$tglJatuhTempo}*\n"
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "📚 *Daftar Buku (" . count($detailBuku) . " eksemplar):*\n"
            . $daftarBuku
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "✅ *Tunjukkan kartu ini ke pustakawan*\n"
            . "   untuk mengambil buku Anda.\n\n"
            . "⚠️ Kembalikan paling lambat *{$tglJatuhTempo}*\n"
            . "   Denda: Rp 1.000/hari/buku\n"
            . "━━━━━━━━━━━━━━━━━━━━━━\n"
            . "_Terima kasih, selamat membaca!_ 📖";
    }

    /**
     * Buat pesan notifikasi pengembalian
     */
    public function pesanPengembalian(
        $peminjaman,
        array $detailBuku,
        int $denda_keterlambatan,
        int $denda_kerusakan,
        int $total_denda,
        string $tgl_kembali
    ): string {
        $tglPinjam   = \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y');
        $tglKembali  = \Carbon\Carbon::parse($tgl_kembali)->format('d/m/Y');
        $tglTempo    = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y');

        $daftarBuku = '';
        foreach ($detailBuku as $i => $detail) {
            $kondisi    = ucfirst($detail['kondisi_kembali']);
            $dendaItem  = $detail['denda_item'] > 0
                ? ' | Denda: Rp ' . number_format($detail['denda_item'], 0, ',', '.')
                : '';
            $daftarBuku .= ($i + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ') - ' . $kondisi . $dendaItem . "\n";
        }

        $infoDenda = '';
        if ($total_denda > 0) {
            $infoDenda  = "─────────────────────\n";
            $infoDenda .= "💰 *INFORMASI DENDA:*\n";
            if ($denda_keterlambatan > 0) {
                $hari = \Carbon\Carbon::parse($tgl_kembali)->diffInDays(\Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo));
                $infoDenda .= "• Keterlambatan : Rp " . number_format($denda_keterlambatan, 0, ',', '.') . " ({$hari} hari)\n";
            }
            if ($denda_kerusakan > 0) {
                $infoDenda .= "• Kerusakan/Hilang : Rp " . number_format($denda_kerusakan, 0, ',', '.') . "\n";
            }
            $infoDenda .= "• *Total Denda : Rp " . number_format($total_denda, 0, ',', '.') . "*\n";
            $infoDenda .= "⚠️ Harap segera bayar denda di perpustakaan.\n";
        } else {
            $infoDenda = "✅ *Tidak ada denda. Terima kasih telah mengembalikan tepat waktu!*\n";
        }

        return "📚 *NOTIFIKASI PENGEMBALIAN BUKU*\n"
            . "Perpustakaan SD Muhammadiyah Karangwaru\n"
            . "─────────────────────\n"
            . "Kode Transaksi  : *{$peminjaman->kode_transaksi}*\n"
            . "Tanggal Pinjam  : {$tglPinjam}\n"
            . "Tanggal Kembali : {$tglKembali}\n"
            . "Jatuh Tempo     : {$tglTempo}\n"
            . "─────────────────────\n"
            . "*Daftar Buku:*\n"
            . $daftarBuku
            . $infoDenda
            . "─────────────────────\n"
            . "_Terima kasih_ 🙏";
    }

    /**
     * Pesan reminder H-1 sebelum jatuh tempo
     */
    public function pesanReminderJatuhTempo($peminjaman, array $detailBuku): string
    {
        $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y');
        $namaAnggota   = $peminjaman->anggota->nama_anggota ?? 'Anggota';

        $daftarBuku = '';
        foreach ($detailBuku as $i => $detail) {
            $daftarBuku .= ($i + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ")\n";
        }

        return "⏰ *PENGINGAT JATUH TEMPO BESOK*\n"
            . "Perpustakaan SD Muhammadiyah Karangwaru\n"
            . "─────────────────────\n"
            . "Halo *{$namaAnggota}*! 👋\n"
            . "Buku pinjaman Anda akan jatuh tempo *besok* ({$tglJatuhTempo}).\n"
            . "─────────────────────\n"
            . "Kode Transaksi : *{$peminjaman->kode_transaksi}*\n"
            . "Jatuh Tempo    : *{$tglJatuhTempo}*\n"
            . "─────────────────────\n"
            . "*Buku yang harus dikembalikan:*\n"
            . $daftarBuku
            . "─────────────────────\n"
            . "Harap kembalikan buku *sebelum atau besok* untuk menghindari denda.\n"
            . "Denda keterlambatan: *Rp 1.000/hari/buku*\n\n"
            . "_Terima kasih telah menggunakan perpustakaan_ 🙏";
    }

    /**
     * Pesan overdue H+ (sudah melewati jatuh tempo)
     */
    public function pesanOverdue($peminjaman, array $detailBuku, int $hariTerlambat): string
    {
        $tglJatuhTempo  = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y');
        $namaAnggota    = $peminjaman->anggota->nama_anggota ?? 'Anggota';
        $estimasiDenda  = $hariTerlambat * count($detailBuku) * 1000;

        $daftarBuku = '';
        foreach ($detailBuku as $i => $detail) {
            $daftarBuku .= ($i + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ")\n";
        }

        return "🚨 *PERINGATAN: BUKU TERLAMBAT DIKEMBALIKAN*\n"
            . "Perpustakaan SD Muhammadiyah Karangwaru\n"
            . "─────────────────────\n"
            . "Halo *{$namaAnggota}*!\n"
            . "Buku pinjaman Anda sudah *{$hariTerlambat} hari terlambat* dikembalikan.\n"
            . "─────────────────────\n"
            . "Kode Transaksi : *{$peminjaman->kode_transaksi}*\n"
            . "Jatuh Tempo    : {$tglJatuhTempo}\n"
            . "Terlambat      : *{$hariTerlambat} hari*\n"
            . "─────────────────────\n"
            . "*Buku yang belum dikembalikan:*\n"
            . $daftarBuku
            . "─────────────────────\n"
            . "💰 Estimasi denda saat ini:\n"
            . "*Rp " . number_format($estimasiDenda, 0, ',', '.') . "* ({$hariTerlambat} hari × " . count($detailBuku) . " buku × Rp 1.000)\n\n"
            . "⚠️ *Segera kembalikan buku ke perpustakaan!*\n"
            . "Denda akan terus bertambah setiap harinya.\n\n"
            . "_Perpustakaan SD Muhammadiyah Karangwaru_ 🙏";
    }
}
