<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $table = 'notifications';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userorigin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_origin_id');
    }
}