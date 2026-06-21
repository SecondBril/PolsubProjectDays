<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public string $userRole = 'mahasiswa'
    ) {}

    /**
     * ⬇️ TAMBAHKAN METHOD INI ⬇️
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'user_approved',
            'message' => 'Akun Anda telah diaktifkan. Selamat datang di JTIK Showcase!',
            'url'     => route('dashboard'),
            'icon'    => 'user-check',
            'color'   => 'green',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("✅ Akun JTIK Showcase Anda Telah Diaktifkan!")
            ->greeting("Selamat Datang, {$notifiable->name}! 🎉")
            ->line("Akun Anda di platform **JTIK Showcase** telah **disetujui dan diaktifkan** oleh Admin.")
            ->line("Sekarang Anda dapat:")
            ->line("- ✨ Submit dan publikasikan proyek PBL Anda")
            ->line("- 👥 Berkolaborasi dengan tim")
            ->line("- 🚀 Menampilkan live demo langsung di browser")
            ->line("- 📊 Membangun portofolio digital profesional")
            ->action('🔐 Login Sekarang', route('login'))
            ->line("Mari berkarya dan tunjukkan inovasi Anda kepada civitas akademika dan mitra industri!")
            ->salutation('Salam,\nTim JTIK Showcase | Politeknik Negeri Subang');
    }
}
