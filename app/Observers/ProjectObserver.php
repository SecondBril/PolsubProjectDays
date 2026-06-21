<?php

namespace App\Observers;

use App\Models\Project;
use App\Support\CacheKeys;

class ProjectObserver
{
    /**
     * Dipanggil saat: created, updated, deleted, restored
     */
    public function created(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }

    public function updated(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }

    public function deleted(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }

    public function restored(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }
    public function approve(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }
    public function reject(Project $project): void
    {
        CacheKeys::invalidateProjectRelated();
    }
}
