<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentMedia extends Model
{
    use SoftDeletes;
    protected $table = 'comment_medias';

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'Task_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}