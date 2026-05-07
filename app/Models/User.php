<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['image'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function teamusers(): HasMany
    {
        return $this->hasMany(TeamUser::class, 'user_id');
    }

    public function getImageAttribute(){
        if( $this->media == null ) return null;
        return Storage::url($this->media->path);
    }

    public function getNameInitialAttribute(){
        $name = substr($this->name, 0, 1);
        $lastName = substr($this->last_name, 0, 1);
        return strtoupper($name.$lastName);
    }

    public function totalTask(){
        $count = Task::where('user_assign', $this->id)->count();
        return $count;
    }

    public function timeDelivery(){
        $avergeDate = DB::select('SELECT avg(DATEDIFF(date_delivery, created_at)) AS avergedate FROM tasks where status="FINALIZED" AND user_assign = ?', [$this->id]);
        return round($avergeDate[0]->avergedate, 1);
    }

    public function totalFinalized(){
        $finalize_count = Task::where('user_assign', $this->id)->where('status', 'FINALIZED')->count();
        return $finalize_count;
    }

    public function efficiency(){
        $taskFinalizeInTime = Task::where('user_assign', $this->id)
            ->where('status', 'FINALIZED')
            ->whereNotNull('finalized_at')
            ->whereRaw('finalized_at <= date_delivery')
            ->count();

        $taskFinalizeOutTime = Task::where('user_assign', $this->id)
            //->where('status', '<>', 'FINALIZED')
            ->where(function($query){
                $now = date('Y-m-d');
                $query->whereRaw('(' . $now .' > date_delivery OR finalized_at > date_delivery)');
            })
            ->count();

        if( $taskFinalizeInTime == 0 && $taskFinalizeOutTime == 0 ) return 0;
        $percentEfficiency = round( ($taskFinalizeInTime / ($taskFinalizeInTime + $taskFinalizeOutTime)) * 100 );

        return $percentEfficiency;
    }

    public function totalTaskByDate($start, $end){
        if( $start == $end ){
            $count = Task::where('user_assign', $this->id)->whereDate('date_delivery', $start)->count();
            return $count;
        }
        $count = Task::where('user_assign', $this->id)->whereBetween('date_delivery', [$start, $end])->count();
        return $count;
    }


    public function totalFinalizedByDate($start, $end){
        if( $start == $end ){
            $finalize_count = Task::where('user_assign', $this->id)->whereDate('date_delivery', $start)->where('status', 'FINALIZED')->count();
            return $finalize_count;
        }
        $finalize_count = Task::where('user_assign', $this->id)->whereBetween('date_delivery', [$start, $end])->where('status', 'FINALIZED')->count();
        return $finalize_count;
    }
}
