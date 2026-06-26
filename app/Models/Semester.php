<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Semester extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'year', 'term', 'start_date', 'end_date', 'is_active'
    ];

    // Pastikan field tanggal di-cast ke date dengan format yang tepat
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date'   => 'date:Y-m-d',
        'is_active'  => 'boolean',
    ];

    public function courseClasses(): HasMany
    {
        return $this->hasMany(CourseClass::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
