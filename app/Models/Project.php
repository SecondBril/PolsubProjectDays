<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// <--- 2. TAMBAHKAN implements HasMedia
class Project extends Model implements HasMedia
{
    // <--- 3. TAMBAHKAN InteractsWithMedia
    use HasUuids, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'team_name', 'description', 'short_description',
        'program_id', 'category_id', 'course_class_id', 'cohort',
        'demo_url', 'repository_url', 'documentation_url',
        'status', 'demo_status', 'last_demo_check_at', 'last_demo_status_code',
        'is_featured', 'featured_order', 'views_count', 'demo_clicks_count',
        'meta_title', 'meta_description', 'team_lead_id', 'reviewer_id',
        'published_at', 'rejected_reason', 'submitted_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'submitted_at' => 'datetime',
        'last_demo_check_at' => 'datetime',
        'views_count' => 'integer',
        'demo_clicks_count' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    public function program(): BelongsTo { return $this->belongsTo(Program::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function courseClass(): BelongsTo { return $this->belongsTo(CourseClass::class); }

    public function course(): HasOneThrough
    {
        return $this->hasOneThrough(Course::class, CourseClass::class, 'id', 'id', 'course_class_id', 'course_id');
    }

    public function lecturer(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, CourseClass::class, 'id', 'id', 'course_class_id', 'lecturer_id');
    }

    public function teamLead(): BelongsTo { return $this->belongsTo(User::class, 'team_lead_id'); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewer_id'); }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_team')
                    ->using(ProjectTeam::class)
                    ->withPivot('role', 'contribution', 'joined_at');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class)->orderBy('order');
    }

    public function tags(): BelongsToMany { return $this->belongsToMany(Tag::class, 'project_tags'); }
    public function demoLogs(): HasMany { return $this->hasMany(DemoChecksLog::class); }
    public function views(): HasMany { return $this->hasMany(ProjectView::class); }

    // ❌ HAPUS relasi media() dan primaryMedia() di bawah ini!
    // Biarkan Spatie MediaLibrary mengelola relasi media() secara internal.

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Query Builder)
    |--------------------------------------------------------------------------
    */
    public function scopePublished(Builder $query): void { $query->where('status', 'published'); }
    public function scopeFeatured(Builder $query): void { $query->where('is_featured', true)->orderBy('featured_order'); }
    public function scopePending(Builder $query): void { $query->where('status', 'pending'); }

    public function scopeSearch(Builder $query, ?string $term): void
    {
        if ($term) {
            $query->whereFullText(['title', 'short_description', 'description'], $term);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SPATIE MEDIA LIBRARY
    |--------------------------------------------------------------------------
    */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/webp']);
            });

        $this->addMediaCollection('screenshots')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/webp', 'video/mp4']);
            });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card-thumbnail')
            ->width(400)
            ->height(225)
            ->sharpen(10)
            ->optimize()
            ->nonQueued();

        $this->addMediaConversion('detail-image')
            ->width(800)
            ->height(450)
            ->optimize()
            ->nonQueued();
    }
}
