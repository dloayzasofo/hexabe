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

    public function getNameInitialAttribute(){
        $name = substr($this->name, 0, 2);
        return strtoupper($name);
    }

    public function getProgressAttribute(){
        $progress = -1;
        
        $tasksTotal = Task::where('brand_id', $this->id)->count();
        $tasksCompleted = Task::where('brand_id', $this->id)->where('status', 'FINALIZED')->count();

        if( $tasksTotal > 0 ) {
            $progress = round(($tasksCompleted / $tasksTotal) * 100);
        }

        return $progress;
    }

    public function getPendingCountAttribute(){
        $pendingCount = 0;
        
        $tasksTotal = Task::where('brand_id', $this->id)->count();
        $tasksCompleted = Task::where('brand_id', $this->id)->where('status', 'FINALIZED')->count();

        $pendingCount = $tasksTotal - $tasksCompleted;

        return $pendingCount;
    }

    public function getMembersAttribute(){
        $members = Task::where('brand_id', $this->id)->distinct()->pluck('user_assign');
        return User::whereIn('id', $members)->get();
    }

    public function getTotalTasksAttribute(){
        return Task::where('brand_id', $this->id)->count();
    }
}