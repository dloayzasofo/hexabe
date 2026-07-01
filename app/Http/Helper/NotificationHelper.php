<?php 

namespace App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Models\Notification;
use App\Models\User;
use App\Models\Firebase;
use Illuminate\Support\Facades\Log;
use App\Services\Firebase\FirebaseService;

class NotificationHelper {

    /**
     * send a notification to a user via email and save in DB
     * 
     * @param User $user the user to send the notification to
     * @param string $title the title of the notification
     * @param string $message the message of the notification
     * @param string $type the type of the notification (e.g., 'TASK', 'COMMENT', 'CRON')
     * @param User|null $user_origin the user who triggered the notification (optional)
     * @param string|null $link the link to the notification (optional)
     * @param string|null $priority the priority of the notification (optional) (e.g., 'HIGH', 'MEDIUM', 'LOW')
     * 
     */
    public static function send(User $user, $title, $message, $type, $taskId=null, User $user_origin=null, $link=null, $priority=null) {
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->user_origin_id = $user_origin != null ? $user_origin->id : null;
        $notification->title = $title;
        $notification->message = $message;
        $notification->type = $type;
        $notification->task_id = $taskId;
        $notification->link = $link;
        $notification->priority = $priority;
        $notification->save();

        if( env('APP_ENV') == 'local' ) {
            return;
        }

        try{
            $notificationMail = new NotificationMail($notification);
            $mailer = Mail::to($user->email);
            $mailer->send($notificationMail);
        }catch (\Throwable $e) {
            Log::error('Notification general mail error: ' . $e->getMessage(), ['user_id' => $user->id]);
        }

        try{
            $userFirebases = Firebase::where('user_id', $user->id)->pluck('token');
            foreach($userFirebases as $token) {
                $firebaseService = new FirebaseService();
                $imagePush = 'https://hexabe.sofopolis.com/assets/img/icon-push.png';
                //$token = 'cHaSZMLEVw7RRB1QjfbVDd:APA91bHTwBnfso0NqrpralA2Dsh-r7uyIiNjKAjP1W7y5-L_pwWBx9vrF_u5mkpGrOJsBSsdb1CLjJbuYMXSYOFrurwivp1mqYpK3lKVqOtRbp4kRJ_nqKw';
                $firebaseService->send($token, $title, $message, $link, $imagePush);
            }
        }catch (\Throwable $e) {
            Log::error('Notification firebase mail error: ' . $e->getMessage(), ['user_id' => $user->id]);
        }

        return;
    }
}