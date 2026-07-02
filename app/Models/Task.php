<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{
    use SoftDeletes;
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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(TaskOrderUser::class);
    }

    public function info(): HasOne
    {
        return $this->hasOne(TaskInfo::class);
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
        $date = Carbon::parse($this->date_delivery . " 18:00:00");
        $now = Carbon::now();
        $now->hour = 18;
        $now->minute = 0;
        $now->second = 0;
        $dateDiff = $date->diffInDays($now);

        if(  $dateDiff >= -1 AND $dateDiff < 0 ) {
            return "Mañana";
        }
        if(  $dateDiff >= 0 AND $dateDiff < 1 ) {
            return "Hoy";
        }
        if(  $dateDiff >= 1 AND $dateDiff < 2 ) {
            return "Ayer";
        }
        return $date->diffForHumans($now);

    }

    /**
     * Function to get percent advanced of task, based on the number of subtasks finalized and total subtasks
     * @return int
     */
    public function getProgressAttribute()
    {
        $total = $this->childs()->count();
        if ($total == 0) {
            return -1;
        }
        $finalized = $this->childs()->where('status', 'FINALIZED')->count();
        return round(($finalized / $total) * 100);
    }

    /**
     * Function to get the number of completed subtasks
     * @return int
     */
    public function getChildsDoneAttribute()
    {
        return $this->childs()->where('status', 'FINALIZED')->count();
    }

    public static function getTaskCountByStatus($status, $user){
        $count = Task::where('status', $status)
            ->where(function($query) use($status, $user){ 
                $query->where('user_assign', $user->id)
                    ->orWhere('user_id', $user->id)
                    ->orWhereRaw('id in (SELECT task_id FROM task_collaborators WHERE user_id = ?)', [$user->id]);
                })
            ->count();

        return $count;
    }

    /**
     * Function to get hours worked on a task, based on the time control table
     * if hours is greater than 24, it will return the number of days and hours
     * check the task status in proccess and finalized 
     * @return string
     */
    public function getHoursWorkedAttribute(){
        $timeControl = TimeControl::where('task_id', $this->id)->get();
        if( $timeControl->isEmpty() ) return null;

        $processArray = [];
        $finalizedArray = [];

        $checkIfFirstStatusIsProcess = null;
        foreach ($timeControl as $time) {
            if($time->status == 'PROCESS'){
                $processArray[] = [
                    'status' => $time->status,
                    'hours' => $time->created_at
                ];
                $checkIfFirstStatusIsProcess = Carbon::parse($time->created_at);
            }
            if( $checkIfFirstStatusIsProcess != null ){
                if($time->status == 'FINALIZED' AND Carbon::parse($time->created_at)->isAfter($checkIfFirstStatusIsProcess) ){
                    $finalizedArray[] = [
                        'status' => $time->status,
                        'hours' => $time->created_at
                    ];
                }
            }
        }

        $countHours = 0;
        for ($i = 0; $i < count($processArray); $i++) {
            $process = Carbon::parse($processArray[$i]['hours']);
            if (isset($finalizedArray[$i]) == false) {
                return null;
            }
            $finalized = Carbon::parse($finalizedArray[$i]['hours']);
            $resultBetween = $this->checkStatusBetweenDates($process, $finalized);
            $countHours += $resultBetween;
        }

        if($countHours > 8){
            $days = floor($countHours / 8);
            $hours = $countHours % 8;

            $countHours = round($countHours, 2);
            $hour = floor($countHours);

            $minutes = ($countHours - $hour) * 60;
            $result = $days . "d ";


            if( $hours > 0 OR $minutes > 0 ){
                $result .= $hours . "h";
            }
            if( $minutes > 0 ){
                $result .= " " . intval($minutes) . "m";
            }
            return $result;
        }else{
            $countHours = round($countHours, 2);
            $hour = floor($countHours);

            $minutes = ($countHours - $hour) * 60;
            $result = "";

            if( $hour > 0 ){
                $result = $hour . "h "; 
            }
            if( $minutes > 0 ){
                $result .= intval($minutes) . "m";
            }
            return $result;
        }
    }

    function checkStatusBetweenDates($dateIni, $dateEnd){
        if( $dateIni->isSameDay($dateEnd) ){
            $hours = $dateIni->diffInHours($dateEnd);
            if( $dateIni->hour < 12 AND $dateEnd->hour > 14 ){
                $hours -= 2;
            }
            return $hours;
        }

        $daysTranscur = intval($dateIni->diffInDays($dateEnd));
        $dayLoop = $dateIni->copy();
        $countHours = 0;
        $daysTranscur += 1;
        for($i = 0; $i < $daysTranscur; $i++){
            if( $i == $daysTranscur - 1 ){
                $dayLoop = $dateEnd->copy();
            }

            if( $i == 0 ){
                $dayFinal = $dayLoop->copy();
                $dayFinal->hour = 12;
                $dayFinal->minute = 30;
                if( $dayLoop->isBefore($dayFinal) ){
                    $countHours += $dayLoop->diffInHours($dayFinal); 
                    $countHours += 4;
                }else{
                    $dayFinal->hour = 18;
                    $dayFinal->minute = 30;
                    $countHours += $dayLoop->diffInHours($dayFinal);
                }
            }else if( $i == $daysTranscur - 1 ){
                $dayInitial = $dayLoop->copy();
                $dayInitial->hour = 8;
                $dayInitial->minute = 30;
                $countHours += $dayInitial->diffInHours($dayLoop);
                if( $dayLoop->hour >= 14 ){
                    $countHours -= 2;
                }
            }else{
                $countHours += 8;
            }

            $dayLoop->addDay();
        }

        return $countHours;
    }

    function checkIfArrayStatusContainDate($arrayStatus, $date){
        $date = Carbon::parse($date);
        foreach ($arrayStatus as $status) {
            $itemData = Carbon::parse($status['hours']);
            if( $itemData->isSameDay($date) ){
                return $status;
            }
        }
        return null;
    }
}