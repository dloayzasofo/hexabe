<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;
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
        $sizeBt = $this->size;
        $sizeKb = number_format($this->size / 1024, 2) . ' KB';
        $sizeMB = number_format($this->size / 1024 / 1024, 2) . ' MB';

        if( $sizeBt < 1025 ) {
            return $sizeBt . ' bytes';
        }

        if( $sizeKb < 1 ) {
            return $sizeMB;
        }

        return $sizeKb;
    }
}