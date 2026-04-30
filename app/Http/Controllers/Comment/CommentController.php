<?php 

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Helper\NotificationHelper;
use Illuminate\Support\Str;
use App\Models\CommentMedia;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Auth;

class CommentController extends Controller {

    public function save(Request $request, Task $task) {
        $data = $request->all();
        $description = $request->input('comment');
        $user = Auth::user();

        $comment = new Comment(); 
        $comment->description = $description;
        $comment->user_id = $user->id;
        $comment->task_id = $task->id;
        $comment->save();

        $medias = [];
        if( $request->file('medias') != null ) {
            $files = $request->file('medias');
            foreach ($files as $file) {
                $media = MediaHelper::save($file, 'resources', $user);
                $commentMedia =  new CommentMedia();
                $commentMedia->comment_id = $comment->id;
                $commentMedia->media_id = $media->id;
                $commentMedia->task_id = $task->id;
                $commentMedia->save();
 
                $medias[] = [
                    'id' => $media->id,
                    'name' => $media->name,
                    'url' => $media->url,
                    'mime' => $media->mime,
                    'size' => $media->size,
                    'sizeLiteral' => $media->sizeLiteral
                ];
            }
        }

        $result = [
            'medias' => $medias,
            'comment' => [
                'id' => $comment->id,
                'description' => $comment->description,
                'registerAt' => $comment->register_at
            ],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image,
                'nameInitial' => $user->name_initial
            ]
        ];

        //Si el comentario viene del mismo usuario no envia ninguna notificacion
        if( $task->user_assign == $user->id AND $task->user_id == $user->id ) {
            return response()->json(['success' => true, 'data' => $result]);
        }

        $userToNotify = $task->assign;
        if( $user->id == $task->user_assign ) $userToNotify = $task->user;

        NotificationHelper::send(
            $userToNotify, 
            $user->name . ' ha comentado la tarea: ' . Str::limit($task->title, 25),
            $comment->description, 
            'COMMENT',
            $user,
            route('task.view', ['task' => $task->id]),
            'medium'
        );

        //Si es un colaboradro enviar tb la notificacion al creador
        if( $user->id != $task->user_assign AND $user->id != $task->user_id ) {
            NotificationHelper::send(
                $task->user, 
                $user->name . ' ha comentado la tarea: ' . Str::limit($task->title, 25),
                $comment->description, 
                'COMMENT',
                $user,
                route('task.view', ['task' => $task->id]),
                'medium'
            );
        }

        return response()->json(['success' => true, 'data' => $result]);
    }
}