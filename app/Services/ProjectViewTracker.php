<?php

namespace App\Services;

use App\Jobs\LogProjectViewJob;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectViewTracker
{
    private const VIEW_TTL = 3600; // 1 jam

    public function track(Project $project, Request $request): void
    {
        $visitorHash = $this->generateVisitorHash($request);
        $cacheKey    = "project_view:{$project->id}:{$visitorHash}";

        // 1. CEK DI REDIS: Apakah visitor ini sudah view dalam 1 jam terakhir?
        if (Cache::has($cacheKey)) {
            return; // Spam prevention
        }

        // 2. TANDAI DI REDIS (Auto-expire 1 jam)
        Cache::put($cacheKey, true, self::VIEW_TTL);

        // 3. INCREMENT COUNTER (Atomic, aman untuk concurrent)
        $project->increment('views_count');

        // 4. DISPATCH KE QUEUE
        // ⚠️ PENTING: Ekstrak data mentah dari Request, JANGAN pass object Request!
        dispatch(new LogProjectViewJob(
            projectId:   $project->id,
            visitorHash: $visitorHash,
            ipAddress:   $request->ip(),
            userAgent:   $request->header('User-Agent'),
            referrerUrl: $request->header('referer'),
        ))->onQueue('analytics');
    }

    private function generateVisitorHash(Request $request): string
    {
        $ip = $request->ip();
        $ua = $request->header('User-Agent', 'unknown');
        return hash('sha256', "{$ip}|{$ua}");
    }
}
