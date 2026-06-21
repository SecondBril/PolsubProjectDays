<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Program;
use App\Models\User;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. CACHE STATISTIK DASHBOARD ADMIN (TTL: 5 menit)
        $stats = Cache::remember(CacheKeys::DASHBOARD_STATS, CacheKeys::TTL_SHORT, function () {
            return [
                'total_projects'     => Project::published()->count(),
                'active_programs'    => Program::where('is_active', true)->count(),
                'pending_projects'   => Project::pending()->count(),
                'pending_users'      => User::where('is_active', false)->count(),
                'rejected_projects'  => Project::where('status', 'rejected')->count(),
                'total_live_demos' => Project::published()
                    ->where(function($query) {
                        $query->where('demo_status', 'active')
                            ->orWhereNotNull('demo_url')
                            ->where('demo_url', '!=', '');
                    })->count(),
            ];
        });

        // 2. CACHE 3 PROYEK TERBARU YANG SUDAH LIVE (Mengembalikan variabel yang hilang)
        $latestProjects = Cache::remember(CacheKeys::DASHBOARD_LATEST, CacheKeys::TTL_SHORT, function () {
            return Project::published()
                ->with(['program'])
                ->latest('published_at')
                ->limit(3)
                ->get()
                ->each(function ($project) {
                    // Inject URL thumbnail dari Spatie MediaLibrary ke objek model
                    $project->thumbnail_url = $project->getFirstMediaUrl('thumbnail', 'card-thumbnail');
                });
        });

        // 3. DATA REALTIME UNTUK ACTIONABLE INSIGHTS (Tidak Di-cache)
        // Ambil 5 project yang butuh approval segera
        $pendingProjectList = Project::pending()
            ->with(['program'])
            ->latest()
            ->limit(5)
            ->get();

        // Ambil 5 user yang is_active-nya masih false (menunggu persetujuan)
        $pendingUserList = User::where('is_active', false)
            ->latest()
            ->limit(5)
            ->get();

        // 4. LOG AKTIVITAS ADMIN (Kosongkan dulu jika belum migrasi tabel log)
        $recentActivities = [];

        // Pastikan 'latestProjects' dilemparkan ke View di dalam compact()
        return view('admin.dashboard', compact(
            'stats',
            'latestProjects',
            'pendingProjectList',
            'pendingUserList',
            'recentActivities'
        ));
    }
}
