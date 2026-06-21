<?php

namespace App\Support;

/**
 * Centralized Cache Keys & TTL
 *
 * ATURAN: Setiap kali ada perubahan data (create/update/delete project, category, dll),
 * method invalidate() di class ini akan dipanggil untuk membersihkan cache terkait.
 */
final class CacheKeys
{
    // ==================== TTL (Time To Live) ====================
    public const TTL_SHORT   = 300;    // 5 menit  - Data yang sering berubah (stats, featured)
    public const TTL_MEDIUM  = 600;    // 10 menit - Data semi-statis (dropdown filters)
    public const TTL_LONG    = 3600;   // 1 jam    - Data master data (programs, categories)

    // ==================== PUBLIC HOMEPAGE ====================
    public const HOME_STATS           = 'public:home:stats';
    public const HOME_FEATURED        = 'public:home:featured';
    public const HOME_LATEST          = 'public:home:latest';

    // ==================== PUBLIC PROJECTS ====================
    const PROJECT_FILTER_OPTIONS = 'project_filter_options_v2'; // Tambahkan _v2

    // ==================== DASHBOARD ====================
    public const DASHBOARD_STATS      = 'dashboard:stats';
    public const DASHBOARD_LATEST     = 'dashboard:latest_projects';

    /**
     * Invalidate semua cache yang terkait dengan data Project
     * Dipanggil saat: Project di-create, update, delete, approve, reject
     */
    public static function invalidateProjectRelated(): void
    {
        cache()->forget(self::HOME_STATS);
        cache()->forget(self::HOME_FEATURED);
        cache()->forget(self::HOME_LATEST);
        cache()->forget(self::DASHBOARD_STATS);
        cache()->forget(self::DASHBOARD_LATEST);
    }

    /**
     * Invalidate cache master data (Program, Category, Tag, Semester)
     * Dipanggil saat admin mengubah master data akademik
     */
    public static function invalidateMasterData(): void
    {
        cache()->forget(self::PROJECT_FILTER_OPTIONS);
        cache()->forget(self::HOME_STATS);
        cache()->forget(self::DASHBOARD_STATS);
    }
}
