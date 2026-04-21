<?php 

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller {
 
    public function index() {
        $user = Auth::user();

        $notificationsToday = Notification::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();

        $notificationsOld = Notification::where('user_id', $user->id)
            ->whereDate('created_at', '<', now()->toDateString())
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        $params = [
            'notificationsToday' => $notificationsToday,
            'notificationsOld' => $notificationsOld
        ];

        return view('notification.index', $params);
    }

    public function read(Request $request) {
        $ids = $request->input('ids');
        $user = Auth::user();
        Notification::whereIn('id', $ids)
            ->where('user_id', $user->id)
            ->update(['read_at' => now()]);
        
        return response()->json(['success' => true, 'data' => ["message"=> "Notificaciones marcadas como leidas"]]);
    }

}