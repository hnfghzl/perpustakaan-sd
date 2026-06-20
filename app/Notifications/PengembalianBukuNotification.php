<?php

namespace App\Notifications;

use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengembalianBukuNotification extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $detailBuku;
    protected $denda_keterlambatan;
    protected $denda_kerusakan;
    protected $total_denda;
    protected $tgl_kembali;

    public function __construct($peminjaman, $detailBuku, $denda_keterlambatan, $denda_kerusakan, $total_denda, $tgl_kembali)
    {
        $this->peminjaman          = $peminjaman;
        $this->detailBuku          = $detailBuku;
        $this->denda_keterlambatan = $denda_keterlambatan;
        $this->denda_kerusakan     = $denda_kerusakan;
        $this->total_denda         = $total_denda;
        $this->tgl_kembali         = $tgl_kembali;
    }

    /**
     * Channel: hanya database, WA dikirim manual via sendWhatsapp()
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Kirim WhatsApp notifikasi pengembalian
     */
    public function sendWhatsapp(object $notifiable): void
    {
        if (empty($notifiable->no_hp)) return;

        $wa = new WhatsappService();
        $pesan = $wa->pesanPengembalian(
            $this->peminjaman,
            $this->detailBuku,
            $this->denda_keterlambatan,
            $this->denda_kerusakan,
            $this->total_denda,
            $this->tgl_kembali
        );
        $wa->kirim($notifiable->no_hp, $pesan);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kode_transaksi' => $this->peminjaman->kode_transaksi,
            'jumlah_buku'    => count($this->detailBuku),
            'tgl_kembali'    => $this->tgl_kembali,
            'total_denda'    => $this->total_denda,
        ];
    }
}
