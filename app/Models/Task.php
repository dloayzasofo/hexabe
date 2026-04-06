<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assign(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_assign');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function collaborators(): HasMany
    {
        return $this->hasMany(TaskCollaborator::class);
    }



    public function medias(): HasMany
    {
        return $this->hasMany(TaskMedia::class);
    }

    /**
     * Create function tu show date in format Ayer, hace 2 horas, etc
     * @return string
     */
    public function getRegisterAtAttribute()
    {
        //$date = Carbon::parse($this->created_at);
        $date = Carbon::parse($this->date_delivery . " 12:00:00");
        return $date->diffForHumans();

    }
}