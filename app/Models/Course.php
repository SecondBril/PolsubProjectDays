<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasUuids;

    protected $fillable = ['program_id', 'code', 'name', 'sks', 'description'];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(CourseClass::class);
    }
}
