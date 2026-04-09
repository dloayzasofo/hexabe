<?php 

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Models\Brand;
use App\Models\CommentMedia;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Auth;

class CommentController extends Controller {
 
    public function index() {
        $teams = Team::all();
        $params = [
            'teams' => $teams
        ];

        return view('team.index', $params);
    }

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

        return response()->json(['success' => true, 'data' => $result]);
    }
}