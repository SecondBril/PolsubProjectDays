<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public Project $project,
        public string $reason,
        public ?string $reviewerName = null
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
            'type'           => 'project_rejected',
            'project_id'     => $this->project->id,
            'project_title'  => $this->project->title,
            'project_slug'   => $this->project->slug,
            'reason'         => $this->reason,
            'reviewer_name'  => $this->reviewerName,
            'message'        => "Proyek '{$this->project->title}' ditolak. Silakan perbaiki dan submit ulang.",
            'url'            => route('projects.edit', $this->project),
            'icon'           => 'x-circle',
            'color'          => 'red',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $editUrl = route('projects.edit', $this->project);

        return (new MailMessage)
            ->subject("⚠️ Proyek '{$this->project->title}' Memerlukan Perbaikan")
            ->greeting("Halo {$notifiable->name},")
            ->line("Mohon maaf, proyek yang Anda submit telah **ditolak** dan memerlukan perbaikan sebelum dapat dipublikasikan.")
            ->line("**Detail Proyek:**")
            ->line("- Judul: **{$this->project->title}**")
            ->line("- Ditinjau oleh: {$this->reviewerName}")
            ->line("**Alasan Penolakan:**")
            ->line("> _{$this->reason}_")
            ->line("Silakan perbaiki proyek Anda sesuai dengan catatan di atas, kemudian submit ulang melalui tombol di bawah.")
            ->action('✏️ Edit & Submit Ulang', $editUrl)
            ->line("Jika ada pertanyaan, silakan hubungi Dosen Pengampu atau Admin JTIK.")
            ->salutation('Salam,\nTim JTIK Showcase | Politeknik Negeri Subang');
    }
}
