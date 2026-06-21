<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Tambahkan ini

class CourseClass extends Model
{
    use HasUuids;

    protected $fillable = [
        'course_id', 'semester_id', 'class_code' // Buat 'lecturer_id' dari sini
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    // UBAH RELASI INI MENJADI JAMAK (MANY-TO-MANY)
    public function lecturers(): BelongsToMany
    {
        // Parameter kedua adalah nama tabel pivot Anda, silakan sesuaikan jika berbeda
        return $this->belongsToMany(User::class, 'course_class_lecturer', 'course_class_id', 'user_id')
                    ->withTimestamps();
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
