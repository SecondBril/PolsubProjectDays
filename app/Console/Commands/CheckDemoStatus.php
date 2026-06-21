<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\DemoChecksLog;
use Illuminate\Support\Facades\Http;

class CheckDemoStatus extends Command
{
    protected $signature = 'app:check-demo-status';
    protected $description = 'Memeriksa status URL Live Demo proyek mahasiswa';

    public function handle()
    {
        $this->info('Memulai pengecekan URL Demo...');

        // Ambil proyek published yang punya URL demo
        $projects = Project::published()
            ->whereNotNull('demo_url')
            ->where('demo_url', '!=', '')
            ->get();

        foreach ($projects as $project) {
            $start = microtime(true);
            $statusCode = 0;
            $status = 'offline';
            $errorMessage = null;

            try {
                // Timeout 10 detik agar tidak memblokir cron job
                $response = Http::timeout(10)->get($project->demo_url);
                $statusCode = $response->status();
                $status = $response->successful() ? 'active' : 'error';
            } catch (\Exception $e) {
                $status = 'offline';
                $errorMessage = $e->getMessage();
            }

            $responseTime = round((microtime(true) - $start) * 1000); // dalam ms

            // 1. Simpan ke Log History
            DemoChecksLog::create([
                'project_id' => $project->id,
                'status_code' => $statusCode,
                'response_time_ms' => $responseTime,
                'status' => $status,
                'error_message' => $errorMessage,
                'checked_at' => now(),
            ]);

            // 2. Update Status Terbaru di Tabel Projects (Untuk ditampilkan di UI Card)
            $project->update([
                'demo_status' => $status,
                'last_demo_check_at' => now(),
                'last_demo_status_code' => $statusCode,
            ]);
        }

        $this->info('Pengecekan selesai. Total ' . $projects->count() . ' proyek diperiksa.');
    }
}
