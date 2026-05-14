<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firebase extends Model
{
    use SoftDeletes;
    protected $table = 'firebase';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}