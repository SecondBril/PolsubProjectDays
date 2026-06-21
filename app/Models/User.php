<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasUuids, SoftDeletes, Notifiable, HasRoles;

    protected $fillable = [
        'nim_nidn', 'name', 'email', 'password', 'phone', 'avatar',
        'role', 'is_active', 'program_id', 'cohort', 'current_semester',
        'expertise', 'academic_rank', 'last_login_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'expertise' => 'array',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function ledProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'team_lead_id');
    }

    public function teamProjects()
    {
        return $this->belongsToMany(Project::class, 'project_team')
                    ->withPivot('role', 'contribution', 'joined_at')
                    ->withTimestamps();
    }

    public function taughtClasses(): HasMany
    {
        return $this->hasMany(CourseClass::class, 'lecturer_id');
    }
}
