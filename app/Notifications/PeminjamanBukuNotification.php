<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanBukuNotification extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $detailBuku;

    /**
     * Create a new notification instance.
     */
    public function __construct($peminjaman, $detailBuku)
    {
        $this->peminjaman = $peminjaman;
        $this->detailBuku = $detailBuku;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Notifikasi Peminjaman Buku - PERPUS SD MUHAMMADIYAH KARANG WARU')
            ->greeting('Halo ' . $notifiable->nama_anggota . ',')
            ->line('Terima kasih telah meminjam buku di PERPUS SD MUHAMMADIYAH KARANG WARU.')
            ->line('')
            ->line('**Detail Peminjaman:**')
            ->line('Kode Transaksi: **' . $this->peminjaman->kode_transaksi . '**')
            ->line('Tanggal Pinjam: **' . \Carbon\Carbon::parse($this->peminjaman->tgl_pinjam)->format('d/m/Y') . '**')
            ->line('Jatuh Tempo: **' . \Carbon\Carbon::parse($this->peminjaman->tgl_jatuh_tempo)->format('d/m/Y') . '**')
            ->line('Jumlah Buku: **' . count($this->detailBuku) . ' eksemplar**')
            ->line('')
            ->line('**Daftar Buku yang Dipinjam:**');

        foreach ($this->detailBuku as $index => $detail) {
            $message->line(($index + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ')');
        }

        $message->line('')
            ->line('⚠️ **Penting:**')
            ->line('• Harap kembalikan buku sebelum tanggal jatuh tempo')
            ->line('• Denda keterlambatan: Rp 1.000/hari/buku')
            ->line('• Jaga kondisi buku dengan baik')
            ->line('')
            ->line('Terima kasih atas perhatian Anda.')
            ->salutation('Salam, Tim PERPUS SD MUHAMMADIYAH KARANG WARU');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'kode_transaksi' => $this->peminjaman->kode_transaksi,
            'jumlah_buku' => count($this->detailBuku),
            'tgl_jatuh_tempo' => $this->peminjaman->tgl_jatuh_tempo
        ];
    }
}
