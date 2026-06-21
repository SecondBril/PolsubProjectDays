<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_tags');
    }
}
