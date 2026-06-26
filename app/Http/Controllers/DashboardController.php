<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Program;
use App\Models\User;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. CACHE STATISTIK DASHBOARD ADMIN (TTL: 5 menit)
        $stats = Cache::remember(CacheKeys::DASHBOARD_STATS, CacheKeys::TTL_SHORT, function () {
            $currentYear = date('Y');

            // Ambil data agregat bulanan untuk status 'published' (Disetujui)
            $publishedMonthly = Project::published()
                ->whereYear('published_at', $currentYear)
                ->select(DB::raw('MONTH(published_at) as month'), DB::raw('count(*) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Ambil data agregat bulanan untuk status 'pending' (Menunggu Review)
            $pendingMonthly = Project::pending()
                ->whereYear('created_at', $currentYear)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Struktur dasar untuk 6 bulan pertama
            $monthsMap = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
                4 => 'Apr', 5 => 'Mei', 6 => 'Jun'
            ];

            $chartData = [];
            $maxValue = 0;

            // Loop untuk menentukan nilai riil data per bulan
            foreach ($monthsMap as $num => $label) {
                $approved = $publishedMonthly[$num] ?? 0;
                $pending = $pendingMonthly[$num] ?? 0;
                $total = $approved + $pending;

                // Cari nilai tertinggi untuk basis pembagi persentase (agar tinggi grafik proporsional)
                if ($total > $maxValue) {
                    $maxValue = $total;
                }

                $chartData[] = [
                    'label'    => $label,
                    'approved' => $approved,
                    'pending'  => $pending,
                    'total'    => $total
                ];
            }

            // Normalisasi kalkulasi persentase tinggi CSS (Max pembagi default = 10 agar grafik tidak tenggelam saat data sedikit)
            $divisor = $maxValue > 0 ? $maxValue : 10;
            foreach ($chartData as $key => $data) {
                if ($data['total'] > 0) {
                    // Berapa persen ruang yang diambil oleh masing-masing bagian dari total tinggi kontainer grafik
                    $chartData[$key]['approved_height'] = ($data['approved'] / $divisor) * 100;
                    $chartData[$key]['pending_height'] = ($data['pending'] / $divisor) * 100;
                } else {
                    $chartData[$key]['approved_height'] = 0;
                    $chartData[$key]['pending_height'] = 0;
                }
            }

            return [
                'total_projects'     => Project::published()->count(),
                'active_programs'    => Program::where('is_active', true)->count(),
                'pending_projects'   => Project::pending()->count(),
                'pending_users'      => User::where('is_active', false)->count(),
                'rejected_projects'  => Project::where('status', 'rejected')->count(),
                'chart_data'         => $chartData, // Masukkan data chart ke array cache
                'total_live_demos'   => Project::published()
                    ->where(function($query) {
                        $query->where('demo_status', 'active')
                            ->orWhere(function($q) {
                                $q->whereNotNull('demo_url')->where('demo_url', '!=', '');
                            });
                    })->count(),
            ];
        });

        // 2. CACHE 3 PROYEK TERBARU YANG SUDAH LIVE
        // $latestProjects = Cache::remember(CacheKeys::DASHBOARD_LATEST, CacheKeys::TTL_SHORT, function () {
        //     return Project::published()
        //         ->with(['program'])
        //         ->withCount(['teamMembers'])
        //         ->latest('published_at')
        //         ->limit(3)
        //         ->get();
        // });

        // 2. AMBIL LANGSUNG TANPA CACHE UNTUK DEBUG
        $latestProjects = Project::published()
            ->with(['program'])
            ->withCount(['teamMembers'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        // 3. DATA REALTIME UNTUK ACTIONABLE INSIGHTS (Tidak Di-cache)
        $pendingProjectList = Project::pending()->with(['program'])->latest()->limit(5)->get();
        $pendingUserList = User::where('is_active', false)->latest()->limit(5)->get();
        $recentActivities = [];

        return view('admin.dashboard', compact(
            'stats',
            'latestProjects',
            'pendingProjectList',
            'pendingUserList',
            'recentActivities'
        ));
    }
}
