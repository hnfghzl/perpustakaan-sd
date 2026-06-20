<?php

namespace App\Notifications;

use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PeminjamanBukuNotification extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $detailBuku;

    public function __construct($peminjaman, $detailBuku)
    {
        $this->peminjaman  = $peminjaman;
        $this->detailBuku  = $detailBuku;
    }

    /**
     * Channel: hanya custom (WA via Fonnte), tidak pakai email
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Kirim WhatsApp saat notifikasi ini diproses.
     * Dipanggil langsung di PeminjamanComponent karena channel WA adalah custom.
     */
    public function sendWhatsapp(object $notifiable): void
    {
        if (empty($notifiable->no_hp)) return;

        $wa = new WhatsappService();
        $pesan = $wa->pesanPeminjaman($this->peminjaman, $this->detailBuku);
        $wa->kirim($notifiable->no_hp, $pesan);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kode_transaksi'  => $this->peminjaman->kode_transaksi,
            'jumlah_buku'     => count($this->detailBuku),
            'tgl_jatuh_tempo' => $this->peminjaman->tgl_jatuh_tempo,
        ];
    }
}
