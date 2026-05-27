<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskInfo extends Model
{
    use SoftDeletes;
    protected $table = 'tasks_info';

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function dependency(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_dependency_id');
    }
}