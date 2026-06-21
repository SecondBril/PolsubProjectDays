<?php

namespace App\Observers;

use App\Support\CacheKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MasterDataObserver
{
    public function created(Model $model): void { CacheKeys::invalidateMasterData(); }
    public function updated(Model $model): void { CacheKeys::invalidateMasterData(); }
    public function deleted(Model $model): void { CacheKeys::invalidateMasterData();
        Cache::forget(\App\Support\CacheKeys::PROJECT_FILTER_OPTIONS);


    }
    public function saved($model)
    {
        Cache::forget(\App\Support\CacheKeys::PROJECT_FILTER_OPTIONS);
    }

}
