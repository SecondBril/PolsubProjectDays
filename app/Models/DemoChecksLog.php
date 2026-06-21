<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoChecksLog extends Model
{
    use HasUuids;

    protected $table = 'demo_checks_log';

    protected $fillable = [
        'project_id', 'status_code', 'response_time_ms',
        'status', 'error_message', 'checked_at'
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
