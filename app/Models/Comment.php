<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = 'comments';

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentmedias(): HasMany
    {
        return $this->hasMany(CommentMedia::class);
    }


    /**
     * Create function tu show date in format Ayer, hace 2 horas, etc
     * @return string
     */
    public function getRegisterAtAttribute()
    {
        $date = Carbon::parse($this->created_at);
        return $date->diffForHumans();

    }
}