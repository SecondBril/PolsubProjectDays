<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil Master Data & User Seeder (Wajib Urutan Pertama)
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // 2. Panggil Project Seeder (Urutan Terakhir)
        // Ini akan membuat 30 proyek dummy dan mengacak anggota tim dari UserSeeder
        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
