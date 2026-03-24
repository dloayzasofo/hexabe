<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
 
class Media extends Model
{
    protected $table = 'medias';
    protected $appends = ['url', 'sizeLiteral'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return $this->path ? Storage::url($this->path) : null;
    }

    public function getSizeLiteralAttribute(){
        $sizeKb = number_format($this->size / 1024, 2) . ' KB';
        $sizeMB = number_format($this->size / 1024 / 1024, 2) . ' MB';

        if( $sizeKb < 1 ) {
            return $sizeMB;
        }

        return $sizeKb;
    }
}