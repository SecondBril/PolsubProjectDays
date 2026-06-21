<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Program;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Cache Statistik aman karena hanya berisi integer primitive
        $stats = Cache::remember(CacheKeys::HOME_STATS, CacheKeys::TTL_SHORT, function () {
            return [
                'total_projects'   => Project::published()->count(),
                'active_programs'  => Program::where('is_active', true)->count(),
                'total_live_demos' => Project::published()
                    ->where(function($query) {
                        $query->where('demo_status', 'active')
                            ->orWhereNotNull('demo_url')
                            ->where('demo_url', '!=', '');
                    })->count(),
                'total_teams'      => Project::published()->count(),
            ];
        });

        // 2. Cache Featured Projects dirubah menjadi ARRAY MURNI sebelum disimpan
        $featuredProjects = Cache::remember(CacheKeys::HOME_FEATURED, CacheKeys::TTL_SHORT, function () {
            return Project::published()
                ->featured()
                ->with(['program', 'category', 'teamMembers'])
                ->limit(6)
                ->get()
                ->map(function ($project) {
                    // Masukkan URL media langsung ke dalam struktur sebelum di-array-kan
                    $project->thumbnail_url = $project->getFirstMediaUrl('thumbnail', 'card-thumbnail');
                    return $project;
                })
                ->toArray(); // <--- KRITIKAL: Ubah ke array agar serializer file-driver tidak korup
        });

        // 3. Cache Latest Projects juga dirubah menjadi ARRAY MURNI
        $latestProjects = Cache::remember(CacheKeys::HOME_LATEST, CacheKeys::TTL_SHORT, function () {
            return Project::published()
                ->with(['program', 'category', 'teamMembers'])
                ->latest('published_at')
                ->limit(3)
                ->get()
                ->map(function ($project) {
                    $project->thumbnail_url = $project->getFirstMediaUrl('thumbnail', 'card-thumbnail');
                    return $project;
                })
                ->toArray(); // <--- KRITIKAL: Aman untuk driver cache lokal manapun
        });

        return view('home', compact('stats', 'featuredProjects', 'latestProjects'));
    }
}
