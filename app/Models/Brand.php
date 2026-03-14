<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $table = 'brands';
    protected $appends = ['image'];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function getImageAttribute(){
        if( $this->media == null ) return null;
        return Storage::url($this->media->path);
    }

}