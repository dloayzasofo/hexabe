<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserHistory extends Model
{
    protected $table = 'user_histories';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}