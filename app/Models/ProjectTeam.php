<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectTeam extends Pivot
{
    use HasUuids;

    protected $table = 'project_team';
    public $incrementing = false;
    protected $keyType = 'string';
}
