<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    protected $table = 'teams';

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function teamuser(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function teambrand(): HasMany
    {
        return $this->hasMany(TeamBrand::class);
    }

    public function getImageAttribute(){
        if( $this->media == null ) return null;
        return Storage::url($this->media->path);
    }

    /**
     * Obtiene el progreso de las tareas asociadas a este equipo, calculado como el porcentaje de tareas finalizadas respecto al total de tareas.
     */
    public function getProgressAttribute(){
        $progress = -1;
        $users = $this->teamuser()->pluck('user_id');
        
        $tasksTotal = Task::whereIn('user_assign', $users)->count();
        $tasksCompleted = Task::whereIn('user_assign', $users)->where('status', 'FINALIZED')->count();

        if( $tasksTotal > 0 ) {
            $progress = round(($tasksCompleted / $tasksTotal) * 100);
        }

        return $progress;
    }

    /**
     * Obtiene el total de tareas pendientes o estado distinto a finalizado relacionadas a este equipo.
     */
    public function getPendingCountAttribute(){
        $pendingCount = 0;
        $users = $this->teamuser()->pluck('user_id');
        $allTasks = Task::whereIn('user_assign', $users)->count();
        $tasks = Task::whereIn('user_assign', $users)->where('status', '!=', 'FINALIZED')->count();

        $pendingCount = $allTasks - $tasks;
        return $pendingCount;
    }

    /**
     * Obtiene los miembros asociados a este equipo.
     */
    public function getMembersAttribute(){
        $members = $this->teamuser()->pluck('user_id');
        return User::whereIn('id', $members)->get();
    }

    /**
     * Obtiene el total de tareas asociadas a este equipo.
     */
    public function getTotalTasksAttribute(){
        $users = $this->teamuser()->pluck('user_id');
        return Task::whereIn('user_assign', $users)->count();
    }
}