<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearAppCache extends Command
{
    protected $signature = 'app:clear-cache {--type=all : Type of cache to clear (all|project|master)}';
    protected $description = 'Clear application cache selectively';

    public function handle(): int
    {
        $type = $this->option('type');

        match ($type) {
            'project' => \App\Support\CacheKeys::invalidateProjectRelated(),
            'master'  => \App\Support\CacheKeys::invalidateMasterData(),
            default   => Cache::flush(),
        };

        $this->info("✅ Cache [{$type}] berhasil dibersihkan!");
        return Command::SUCCESS;
    }
}

// Cara Pakai
// php artisan app:clear-cache              # Clear semua cache
// php artisan app:clear-cache --type=project  # Clear cache project saja
// php artisan app:clear-cache --type=master   # Clear cache master data saja
