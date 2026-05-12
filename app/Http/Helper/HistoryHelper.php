<?php 

namespace App\Http\Helper;
use Illuminate\Http\Request;
use App\Models\UserHistory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HistoryHelper {

    /**
     * save hisotry to user actions
     * 
     * @param User $user the user to send the notification to
     * @param string $event a string with description to event
     * 
     */
    public static function save(User $user, $event) {

        $history = new UserHistory();
        $history->user_id = $user->id;
        $history->event = $event;
        $history->save();
    }
}