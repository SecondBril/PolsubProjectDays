<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public Project $project,
        public ?string $reviewerName = null
    ) {}

    /**
     * ⬇️ TAMBAHKAN METHOD INI ⬇️
     * Tentukan channel notifikasi: Email + Database (in-app)
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Simpan data untuk in-app notification (disimpan di tabel `notifications`)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'project_approved',
            'project_id'   => $this->project->id,
            'project_title'=> $this->project->title,
            'project_slug' => $this->project->slug,
            'reviewer_name'=> $this->reviewerName,
            'message'      => "Proyek '{$this->project->title}' telah disetujui dan dipublikasikan.",
            'url'          => route('projects.show', $this->project->slug),
            'icon'         => 'check-circle',
            'color'        => 'green',
        ];
    }

    /**
     * Format untuk email
     */
    public function toMail(object $notifiable): MailMessage
    {
        $projectUrl = route('projects.show', $this->project->slug);

        return (new MailMessage)
            ->subject("🎉 Proyek '{$this->project->title}' Telah Dipublikasikan!")
            ->greeting("Halo {$notifiable->name}!")
            ->line("Kabar baik! Proyek yang Anda dan tim kerjakan telah **disetujui dan dipublikasikan** di JTIK Showcase.")
            ->line("**Detail Proyek:**")
            ->line("- Judul: **{$this->project->title}**")
            ->line("- Program Studi: {$this->project->program->name}")
            ->line("- Kategori: {$this->project->category->name}")
            ->line("- Disetujui oleh: {$this->reviewerName}")
            ->line("- Tanggal Publish: {$this->project->published_at->format('d M Y H:i')}")
            ->action('🚀 Lihat Proyek Saya', $projectUrl)
            ->line("Proyek Anda sekarang dapat diakses oleh civitas akademika JTIK, mitra industri, dan masyarakat umum.")
            ->line("Terima kasih atas karya luar biasa Anda! 🎓")
            ->salutation('Salam,\nTim JTIK Showcase | Politeknik Negeri Subang');
    }
}
