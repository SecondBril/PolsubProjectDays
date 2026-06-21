<?php

namespace App\Jobs;

use App\Models\ProjectView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogProjectViewJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;        // Retry 3x jika gagal
    public int $backoff = 10;     // Jeda 10 detik antar retry

    /**
     * Constructor MENERIMA parameter & simpan sebagai property.
     * Gunakan constructor property promotion (PHP 8+) untuk ringkas.
     *
     * CATATAN: Request object TIDAK boleh di-pass. Gunakan data mentah (string).
     */
    public function __construct(
        public string $projectId,
        public string $visitorHash,
        public ?string $ipAddress,
        public ?string $userAgent,
        public ?string $referrerUrl,
    ) {}

    /**
     * Execute the job.
     * handle() TIDAK menerima parameter (kecuali dependency injection dari container).
     */
    public function handle(): void
    {
        ProjectView::create([
            'project_id'   => $this->projectId,
            'visitor_hash' => $this->visitorHash,
            'ip_address'   => $this->ipAddress,
            'user_agent'   => $this->userAgent,
            'referrer_url' => $this->referrerUrl,
            'viewed_at'    => now(),
        ]);
    }
}
