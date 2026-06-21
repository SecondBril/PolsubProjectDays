<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Models\Category;
use App\Models\Program;
use App\Models\Tag;
use App\Models\Semester;
use App\Models\Course;
use App\Models\CourseClass;
use App\Observers\ProjectObserver;
use App\Observers\MasterDataObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Project Observer - Auto invalidate cache saat project berubah
        Project::observe(ProjectObserver::class);

        // Master Data Observer - Auto invalidate cache saat master data berubah
        Category::observe(MasterDataObserver::class);
        Program::observe(MasterDataObserver::class);
        Tag::observe(MasterDataObserver::class);
        Semester::observe(MasterDataObserver::class);
        Course::observe(MasterDataObserver::class);
        CourseClass::observe(MasterDataObserver::class);
    }
}
