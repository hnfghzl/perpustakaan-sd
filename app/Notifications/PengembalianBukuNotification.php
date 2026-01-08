<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
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

    /**
     * Create a new notification instance.
     */
    public function __construct($peminjaman, $detailBuku, $denda_keterlambatan, $denda_kerusakan, $total_denda, $tgl_kembali)
    {
        $this->peminjaman = $peminjaman;
        $this->detailBuku = $detailBuku;
        $this->denda_keterlambatan = $denda_keterlambatan;
        $this->denda_kerusakan = $denda_kerusakan;
        $this->total_denda = $total_denda;
        $this->tgl_kembali = $tgl_kembali;
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
            ->subject('Notifikasi Pengembalian Buku - PERPUS SD MUHAMMADIYAH KARANG WARU')
            ->greeting('Halo ' . $notifiable->nama_anggota . ',')
            ->line('Terima kasih telah mengembalikan buku di PERPUS SD MUHAMMADIYAH KARANG WARU.')
            ->line('')
            ->line('**Detail Pengembalian:**')
            ->line('Kode Transaksi: **' . $this->peminjaman->kode_transaksi . '**')
            ->line('Tanggal Pinjam: **' . \Carbon\Carbon::parse($this->peminjaman->tgl_pinjam)->format('d/m/Y') . '**')
            ->line('Tanggal Kembali: **' . \Carbon\Carbon::parse($this->tgl_kembali)->format('d/m/Y') . '**')
            ->line('Jatuh Tempo: **' . \Carbon\Carbon::parse($this->peminjaman->tgl_jatuh_tempo)->format('d/m/Y') . '**')
            ->line('Jumlah Buku: **' . count($this->detailBuku) . ' eksemplar**')
            ->line('')
            ->line('**Daftar Buku yang Dikembalikan:**');

        foreach ($this->detailBuku as $index => $detail) {
            $kondisi = ucfirst($detail['kondisi_kembali']);
            $denda_item = $detail['denda_item'] > 0 ? ' - Denda: Rp ' . number_format($detail['denda_item'], 0, ',', '.') : '';
            $message->line(($index + 1) . '. ' . $detail['judul'] . ' (' . $detail['kode_eksemplar'] . ') - Kondisi: ' . $kondisi . $denda_item);
        }

        $message->line('');

        // Tampilkan informasi denda
        if ($this->total_denda > 0) {
            $message->line('**💰 Informasi Denda:**');
            
            if ($this->denda_keterlambatan > 0) {
                $tgl_jatuh_tempo = \Carbon\Carbon::parse($this->peminjaman->tgl_jatuh_tempo);
                $tgl_kembali = \Carbon\Carbon::parse($this->tgl_kembali);
                $hari_terlambat = $tgl_kembali->diffInDays($tgl_jatuh_tempo);
                
                $message->line('• Denda Keterlambatan: **Rp ' . number_format($this->denda_keterlambatan, 0, ',', '.') . '** (' . $hari_terlambat . ' hari)');
            }
            
            if ($this->denda_kerusakan > 0) {
                $message->line('• Denda Kerusakan/Kehilangan: **Rp ' . number_format($this->denda_kerusakan, 0, ',', '.') . '**');
            }
            
            $message->line('• **Total Denda: Rp ' . number_format($this->total_denda, 0, ',', '.') . '**')
                ->line('')
                ->line('⚠️ **Harap segera melakukan pembayaran denda di perpustakaan.**');
        } else {
            $message->line('✅ **Tidak ada denda. Terima kasih telah mengembalikan buku tepat waktu dan dalam kondisi baik!**');
        }

        $message->line('')
            ->line('Terima kasih atas kerjasamanya.')
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
            'tgl_kembali' => $this->tgl_kembali,
            'total_denda' => $this->total_denda
        ];
    }
}
